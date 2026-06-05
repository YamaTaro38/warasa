<?php
// app/Livewire/ProductExport.php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class ProductExport extends Component
{
    use WithPagination;

    public $search = '';
    public $status = '';
    public $perPage = 10;
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    
    // Selection
    public $selectedProducts = [];
    public $selectPage = false;
    
    protected $queryString = [
        'search' => ['except' => ''],
        'status' => ['except' => ''],
        'sortField' => ['except' => 'created_at'],
        'sortDirection' => ['except' => 'desc'],
        'perPage' => ['except' => 10],
    ];
    
    public function updatingSearch()
    {
        $this->resetPage();
        $this->resetSelection();
    }
    
    public function updatingStatus()
    {
        $this->resetPage();
        $this->resetSelection();
    }
    
    public function updatingPerPage()
    {
        $this->resetPage();
        $this->resetSelection();
    }
    
    public function resetSelection()
    {
        $this->selectedProducts = [];
        $this->selectPage = false;
    }

    public function exportSelected()
    {
        if (empty($this->selectedProducts)) {
            $this->dispatch('show-toast', message: 'Pilih minimal 1 produk untuk diexport!', type: 'error');
            return;
        }

        // Get only published products among selected
        $publishedIds = Product::whereIn('id', $this->selectedProducts)
            ->where('status', 'published')
            ->where('user_id', Auth::id())
            ->pluck('id')
            ->toArray();

        if (empty($publishedIds)) {
            $this->dispatch('show-toast', message: 'Produk yang dipilih harus berstatus Published!', type: 'error');
            return;
        }

        if (count($publishedIds) < count($this->selectedProducts)) {
            $this->dispatch('show-toast', message: 'Beberapa produk tidak berstatus Published dan tidak akan diexport.', type: 'warning');
        }

        $this->dispatch('export-products', productIds: $publishedIds);
    }

    public function exportSingle($id)
    {
        $product = Product::where('id', $id)
            ->where('user_id', Auth::id())
            ->first();

        if (!$product) {
            $this->dispatch('show-toast', message: 'Produk tidak ditemukan!', type: 'error');
            return;
        }

        if ($product->status !== 'published') {
            $this->dispatch('show-toast', message: 'Hanya produk dengan status Published yang dapat di-export!', type: 'error');
            return;
        }

        $this->dispatch('export-single-product', uuid: $product->uuid);
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
    
    public function updatedSelectPage($value)
    {
        if ($value) {
            $this->selectedProducts = $this->getProducts()->pluck('id')->map(fn($id) => (string) $id)->toArray();
        } else {
            $this->selectedProducts = [];
        }
    }
    
    public function selectAll()
    {
        $this->selectedProducts = $this->getAllProducts()->pluck('id')->map(fn($id) => (string) $id)->toArray();
        $this->selectPage = true;
    }
    
    public function deselectAll()
    {
        $this->selectedProducts = [];
        $this->selectPage = false;
    }
    
    protected function getProducts()
    {
        $query = Product::query()
            ->with(['category', 'images'])
            ->where('user_id', Auth::id());
            
        if ($this->search) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('ai_generated_title', 'like', '%' . $this->search . '%');
            });
        }
        
        if ($this->status) {
            $query->where('status', $this->status);
        }
        
        return $query->orderBy($this->sortField, $this->sortDirection);
    }
    
    protected function getAllProducts()
    {
        return $this->getProducts()->get();
    }
    
    public function getTotalProductsCount()
    {
        return Product::where('user_id', Auth::id())->count();
    }
    
    public function getPublishedCount()
    {
        return Product::where('user_id', Auth::id())->where('status', 'published')->count();
    }
    
    public function getDraftCount()
    {
        return Product::where('user_id', Auth::id())->where('status', 'draft')->count();
    }
    
    public function render()
    {
        $products = $this->getProducts()->paginate($this->perPage);
        
        return view('livewire.product-export', [
            'products' => $products,
            'totalProducts' => $this->getTotalProductsCount(),
            'publishedCount' => $this->getPublishedCount(),
            'draftCount' => $this->getDraftCount(),
        ]);
    }
}