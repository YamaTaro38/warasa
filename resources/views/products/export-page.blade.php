{{-- resources/views/products/export-page.blade.php --}}
@extends('layouts.dashboard')

@section('page-title', 'Export Produk ke Shopee')
@section('breadcrumb', 'Products / Export to Shopee')

@section('content')
<div class="max-w-full">
    @livewire('product-export')
</div>
@endsection