@extends('layouts.dashboard')

@section('page-title', 'Products')
@section('breadcrumb', 'Manage your product catalog')

@section('content')
<div class="mb-4 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
    <div>
        <h2 class="text-base font-semibold text-gray-800">Products</h2>
        <p class="text-xs text-gray-500 mt-0.5">Manage, edit, and organize your products</p>
    </div>
    <div class="flex items-center gap-2">
    <a href="{{ route('generator.quick') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-warasa-orange text-white text-xs font-medium rounded-md hover:bg-warasa-orange-dark transition">
        <i class="fas fa-plus text-xs"></i> New Product
    </a>
    <a href="{{ route('products.export.page') }}" id="exportSelectedBtn" class="btn btn-primary" style="background: #10b981;">
        <i class="fas fa-file-excel"></i> Export ke Shopee
    </a>
    </div>
</div>

@livewire('product-index')
@endsection