<?php

namespace App\Livewire;

use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ActivityLog;
use App\Services\ExportService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithPagination;

class ProductIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $status = '';
    public $perPage = 10;
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public $selectedProducts = [];
    public $selectPage = false;
    public $bulkAction = '';

    // State untuk modal konfirmasi hapus
    public $confirmingDelete = false;
    public $productToDelete = null;
    public $productToDeleteName = null;
    public $productToDeleteImage = null;
    public $isBulkDelete = false;
    public $bulkDeleteCount = 0;

    // State untuk modal export
    public $showExportModal = false;
    public $exporting = false;

    protected $queryString = ['search', 'status', 'perPage', 'sortField', 'sortDirection'];

    public function updatingSearch()
    {
        $this->resetPage();
        $this->selectedProducts = [];
        $this->selectPage = false;
    }

    public function updatingStatus()
    {
        $this->resetPage();
        $this->selectedProducts = [];
        $this->selectPage = false;
    }

    public function updatedSelectPage($value)
    {
        if ($value) {
            $this->selectedProducts = $this->products->pluck('uuid')->map(fn($u) => (string) $u)->toArray();
        } else {
            $this->selectedProducts = [];
        }
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
        $this->resetPage();
    }

    // === EXPORT FUNCTIONS ===
    public function exportToShopee()
    {
        if (empty($this->selectedProducts)) {
            session()->flash('error', 'Pilih minimal 1 produk untuk diexport!');
            return;
        }

        $this->exporting = true;

        try {
            $products = Product::whereIn('uuid', $this->selectedProducts)
                ->where('user_id', auth()->id())
                ->with(['category', 'images'])
                ->get();

            if ($products->isEmpty()) {
                session()->flash('error', 'Tidak ada produk yang ditemukan!');
                $this->exporting = false;
                return;
            }

            $exportService = new ExportService();
            $filePath = $exportService->exportToShopeeExcel($products);

            $this->exporting = false;
            $this->showExportModal = false;

            $this->dispatch('download-export', path: $filePath);

            session()->flash('message', count($products) . ' produk berhasil diexport!');
        } catch (\Exception $e) {
            Log::error('Export failed: ' . $e->getMessage());
            session()->flash('error', 'Gagal export: ' . $e->getMessage());
            $this->exporting = false;
        }
    }

    public function exportSingle($uuid)
    {
        $product = Product::where('uuid', $uuid)
            ->where('user_id', auth()->id())
            ->with(['category', 'images'])
            ->first();

        if (!$product) {
            session()->flash('error', 'Produk tidak ditemukan!');
            return;
        }

        try {
            $exportService = new ExportService();
            $filePath = $exportService->exportToShopeeExcel(collect([$product]));

            $this->dispatch('download-export', path: $filePath);
            session()->flash('message', 'Produk "' . $product->name . '" berhasil diexport!');
        } catch (\Exception $e) {
            Log::error('Export single failed: ' . $e->getMessage());
            session()->flash('error', 'Gagal export: ' . $e->getMessage());
        }
    }

    public function openExportModal()
    {
        if (empty($this->selectedProducts)) {
            session()->flash('error', 'Pilih minimal 1 produk untuk diexport!');
            return;
        }
        $this->showExportModal = true;
    }

    public function closeExportModal()
    {
        $this->showExportModal = false;
        $this->exporting = false;
    }

    // === DELETE FUNCTIONS ===
    public function confirmDelete($uuid)
    {
        $product = Product::where('uuid', $uuid)
            ->where('user_id', auth()->id())
            ->with('images')
            ->first();

        if (!$product) {
            session()->flash('error', 'Product not found or unauthorized.');
            return;
        }

        $this->productToDelete = $product->uuid;
        $this->productToDeleteName = $product->name;
        $firstImage = optional($product->images)->first();
        $this->productToDeleteImage = $firstImage ? $firstImage->path : null;
        $this->isBulkDelete = false;
        $this->bulkDeleteCount = 0;
        $this->confirmingDelete = true;
    }

    public function confirmBulkDelete()
    {
        if (empty($this->selectedProducts)) {
            session()->flash('error', 'No products selected.');
            return;
        }

        $this->productToDelete = null;
        $this->productToDeleteName = null;
        $this->productToDeleteImage = null;
        $this->isBulkDelete = true;
        $this->bulkDeleteCount = count($this->selectedProducts);
        $this->confirmingDelete = true;
    }

    public function cancelDelete()
    {
        $this->resetDeleteState();
    }

    public function performDelete()
    {
        if ($this->isBulkDelete) {
            $this->executeBulkDelete();
        } else {
            $this->executeSingleDelete();
        }
        $this->resetDeleteState();
    }

    private function executeSingleDelete()
    {
        if (empty($this->productToDelete)) {
            return;
        }

        $product = Product::where('uuid', $this->productToDelete)
            ->where('user_id', auth()->id())
            ->first();

        if (!$product) {
            session()->flash('error', 'Product not found or unauthorized.');
            return;
        }

        try {
            $this->cleanupProductFiles($product);
            $productName = $product->name;
            $product->delete();

            ActivityLog::create([
                'user_id' => auth()->id(),
                'action' => 'product_delete',
                'description' => 'Deleted product: ' . $productName,
                'ip_address' => request()->ip(),
            ]);

            $this->selectedProducts = [];
            $this->selectPage = false;

            session()->flash('message', 'Product "' . $productName . '" deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Delete product failed: ' . $e->getMessage());
            session()->flash('error', 'Failed to delete product: ' . $e->getMessage());
        }
    }

    private function executeBulkDelete()
    {
        if (empty($this->selectedProducts)) {
            session()->flash('error', 'No products selected.');
            return;
        }

        $products = Product::whereIn('uuid', $this->selectedProducts)
            ->where('user_id', auth()->id())
            ->get();

        if ($products->isEmpty()) {
            session()->flash('error', 'No matching products found.');
            return;
        }

        $count = $products->count();

        try {
            foreach ($products as $product) {
                $this->cleanupProductFiles($product);
                $product->delete();
            }

            ActivityLog::create([
                'user_id' => auth()->id(),
                'action' => 'product_bulk_delete',
                'description' => 'Bulk deleted ' . $count . ' product(s)',
                'ip_address' => request()->ip(),
            ]);

            $this->selectedProducts = [];
            $this->selectPage = false;
            session()->flash('message', $count . ' product(s) deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Bulk delete failed: ' . $e->getMessage());
            session()->flash('error', 'Bulk delete failed: ' . $e->getMessage());
        }
    }

    private function resetDeleteState()
    {
        $this->confirmingDelete = false;
        $this->productToDelete = null;
        $this->productToDeleteName = null;
        $this->productToDeleteImage = null;
        $this->isBulkDelete = false;
        $this->bulkDeleteCount = 0;
    }

    public function applyBulkAction()
    {
        if (empty($this->selectedProducts)) {
            session()->flash('error', 'No products selected.');
            return;
        }

        if (empty($this->bulkAction)) {
            session()->flash('error', 'Please choose a bulk action.');
            return;
        }

        if ($this->bulkAction === 'delete') {
            $this->confirmBulkDelete();
            return;
        }

        $products = Product::whereIn('uuid', $this->selectedProducts)
            ->where('user_id', auth()->id())
            ->get();

        if ($products->isEmpty()) {
            session()->flash('error', 'No matching products found.');
            $this->resetBulkState();
            return;
        }

        $count = $products->count();

        switch ($this->bulkAction) {
            case 'archive':
                foreach ($products as $product) {
                    $product->update(['is_archived' => true]);
                }
                session()->flash('message', $count . ' product(s) archived.');
                break;
            case 'publish':
                foreach ($products as $product) {
                    $product->update(['status' => 'published']);
                }
                session()->flash('message', $count . ' product(s) published.');
                break;
            case 'draft':
                foreach ($products as $product) {
                    $product->update(['status' => 'draft']);
                }
                session()->flash('message', $count . ' product(s) moved to draft.');
                break;
            default:
                session()->flash('error', 'Unknown bulk action.');
                $this->resetBulkState();
                return;
        }

        $this->resetBulkState();
        $this->resetPage();
    }

    private function resetBulkState()
    {
        $this->selectedProducts = [];
        $this->selectPage = false;
        $this->bulkAction = '';
    }

    private function cleanupProductFiles(Product $product)
    {
        $images = ProductImage::where('product_id', $product->id)->get();
        foreach ($images as $image) {
            $this->deleteStorageFile($image->path);
            $image->delete();
        }

        $variations = $product->variations ?? [];
        if (is_array($variations)) {
            foreach ($variations as $variation) {
                if (!empty($variation['hasImage']) && !empty($variation['options']) && is_array($variation['options'])) {
                    foreach ($variation['options'] as $opt) {
                        if (is_array($opt) && !empty($opt['image'])) {
                            $this->deleteStorageFile($opt['image']);
                        }
                    }
                }
            }
        }
    }

    private function deleteStorageFile(?string $path)
    {
        if (empty($path)) {
            return;
        }

        $relative = preg_replace('#^/?storage/#', '', $path);

        try {
            if ($relative && Storage::disk('public')->exists($relative)) {
                Storage::disk('public')->delete($relative);
            }
        } catch (\Exception $e) {
            Log::warning('Failed to delete product file: ' . $e->getMessage(), [
                'path' => $path,
            ]);
        }
    }

    public function getProductsProperty()
    {
        return Product::where('user_id', auth()->id())
            ->where('is_archived', false)
            ->when($this->search, fn($q) => $q->where('name', 'like', '%' . $this->search . '%')
                ->orWhere('brand', 'like', '%' . $this->search . '%')
                ->orWhere('ai_generated_title', 'like', '%' . $this->search . '%'))
            ->when($this->status, fn($q) => $q->where('status', $this->status))
            ->with('category', 'images')
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);
    }

    public function render()
    {
        return view('livewire.product-index', [
            'products' => $this->products,
        ]);
    }

public function exportSelected()
{
    if (empty($this->selectedProducts)) {
        session()->flash('error', 'Pilih minimal 1 produk untuk diexport!');
        return;
    }

    $this->exporting = true;
    
    try {
        $products = Product::whereIn('uuid', $this->selectedProducts)
            ->where('user_id', auth()->id())
            ->with(['category', 'images'])
            ->get();

        if ($products->isEmpty()) {
            session()->flash('error', 'Tidak ada produk yang ditemukan!');
            $this->exporting = false;
            return;
        }

        $exportService = new \App\Services\ExportService();
        $filePath = $exportService->exportToShopeeExcel($products);
        
        $this->exporting = false;
        $this->showExportModal = false;
        
        $this->dispatch('download-export', path: $filePath);
        
        session()->flash('message', count($products) . ' produk berhasil diexport!');
    } catch (\Exception $e) {
        \Illuminate\Support\Facades\Log::error('Export failed: ' . $e->getMessage());
        session()->flash('error', 'Gagal export: ' . $e->getMessage());
        $this->exporting = false;
    }
}
}
