<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class ProductTable extends Component
{
    use WithPagination;
    
    public $search = '';
    public $status = '';
    public $perPage = 10;
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    
    protected $queryString = ['search', 'status', 'perPage', 'sortField', 'sortDirection'];
    
    public function updatingSearch() { $this->resetPage(); }
    public function updatingStatus() { $this->resetPage(); }
    
    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }
    
    public function getProductsProperty()
    {
        return Product::where('user_id', auth()->id())
            ->where('is_archived', false)
            ->select('id', 'uuid', 'name', 'brand', 'price', 'stock', 'status', 'category_id', 'created_at', 'ai_generated_title')
            ->when($this->search, function($query) {
                $query->where(function($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('brand', 'like', '%' . $this->search . '%')
                      ->orWhere('ai_generated_title', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->status, function($query) {
                $query->where('status', $this->status);
            })
            ->with('category:id,name')
            ->orderBy($this->sortField === 'created_at' ? 'id' : $this->sortField, $this->sortDirection)
            ->paginate($this->perPage);
    }
    
    public function render()
    {
        return view('livewire.product-table', [
            'products' => $this->products
        ]);
    }
}