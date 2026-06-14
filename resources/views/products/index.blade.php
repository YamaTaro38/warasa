@extends('layouts.dashboard')

@section('page-title', 'Products')
@section('breadcrumb', 'Manage your product catalog')

@section('content')
<style>
    /* Stats Row */
    .stats-row {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 10px;
        margin-bottom: 16px;
    }
    @media (min-width: 640px) {
        .stats-row {
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
            margin-bottom: 20px;
        }
    }
    .stat-box {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 14px 16px;
        display: flex;
        align-items: center;
        gap: 12px;
        transition: all 0.2s ease;
    }
    .stat-box:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
    }
    .stat-icon {
        width: 40px; height: 40px; border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        font-size: 16px; flex-shrink: 0;
    }
    .stat-icon.orange { background: #fff0eb; color: #ee4d2d; }
    .stat-icon.green { background: #ecfdf5; color: #10b981; }
    .stat-icon.blue { background: #eff6ff; color: #3b82f6; }
    .stat-icon.purple { background: #f5f3ff; color: #8b5cf6; }
    .stat-value {
        font-size: 20px; font-weight: 700; color: #1e293b; line-height: 1.2;
    }
    .stat-label {
        font-size: 11px; font-weight: 500; color: #64748b;
        margin-top: 1px; text-transform: uppercase; letter-spacing: 0.3px;
    }

    /* Filter Bar */
    .filter-bar {
        display: flex;
        align-items: flex-start;
        gap: 8px;
        margin-bottom: 16px;
        padding: 10px 12px;
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
    }
    @media (min-width: 640px) {
        .filter-bar {
            align-items: center;
            padding: 10px 14px;
        }
    }
    .filter-label { 
        font-size: 12px; font-weight: 600; color: #475569; 
        white-space: nowrap; margin-top: 3px;
    }
    .filter-chips { 
        display: flex; 
        gap: 6px; 
        flex: 1;
        overflow-x: auto;
        padding-bottom: 4px;
        -webkit-overflow-scrolling: touch;
        scrollbar-width: none;
    }
    .filter-chips::-webkit-scrollbar { display: none; }
    .filter-chip {
        padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 500;
        border: 1px solid #e2e8f0; background: white; color: #64748b;
        cursor: pointer; transition: all 0.2s ease; user-select: none;
        white-space: nowrap; flex-shrink: 0;
    }
    .filter-chip:hover { border-color: #ee4d2d; color: #ee4d2d; }
    .filter-chip.active { background: #ee4d2d; border-color: #ee4d2d; color: white; }

    /* Toolbar */
    .toolbar {
        display: flex;
        flex-direction: column;
        gap: 12px;
        margin-bottom: 16px;
    }
    @media (min-width: 640px) {
        .toolbar { flex-direction: row; align-items: center; justify-content: space-between; }
    }
    .toolbar-left { display: flex; align-items: center; gap: 8px; flex: 1; }
    .toolbar-right { display: flex; align-items: center; gap: 8px; }
    .search-wrapper { position: relative; flex: 1; max-width: 360px; }
    .search-wrapper i {
        position: absolute; left: 10px; top: 50%; transform: translateY(-50%);
        color: #94a3b8; font-size: 12px; pointer-events: none;
    }
    .search-input {
        width: 100%; padding: 7px 10px 7px 28px;
        border: 1px solid #e2e8f0; border-radius: 8px; font-size: 12px;
        background: white; color: #1e293b; outline: none; transition: all 0.2s;
    }
    .search-input:focus { border-color: #ee4d2d; box-shadow: 0 0 0 3px rgba(238, 77, 45, 0.1); }
    .search-input::placeholder { color: #94a3b8; }
    .toolbar-btn {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 7px 14px; border-radius: 8px; font-size: 12px; font-weight: 600;
        border: none; cursor: pointer; transition: all 0.2s ease;
        text-decoration: none; white-space: nowrap;
    }

    /* Product Grid */
    .product-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 10px;
    }
    @media (min-width: 480px) {
        .product-grid { gap: 12px; }
    }
    @media (min-width: 640px) {
        .product-grid { grid-template-columns: repeat(3, 1fr); gap: 14px; }
    }
    @media (min-width: 1024px) {
        .product-grid { grid-template-columns: repeat(4, 1fr); }
    }
    @media (min-width: 1280px) {
        .product-grid { grid-template-columns: repeat(4, 1fr); }
    }

    .product-card {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        overflow: hidden;
        transition: all 0.2s ease;
        cursor: pointer;
        display: block;
        text-decoration: none;
        color: inherit;
    }
    .product-card:hover {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        transform: translateY(-2px);
    }
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
    }

    .product-image-wrapper {
        position: relative;
        width: 100%;
        padding-top: 75%;
        overflow: hidden;
        background: #f8fafc;
    }
    @media (min-width: 640px) {
        .product-image-wrapper { padding-top: 75%; }
    }

    .product-image-inner {
        position: absolute;
        top: 0; left: 0;
        width: 100%;
        height: 100%;
    }

    .product-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .product-image-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: #cbd5e1;
    }
    .product-image-placeholder i { font-size: 28px; margin-bottom: 4px; }
    @media (min-width: 640px) {
        .product-image-placeholder i { font-size: 36px; margin-bottom: 6px; }
    }
    .product-image-placeholder span { font-size: 10px; }
    @media (min-width: 640px) {
        .product-image-placeholder span { font-size: 11px; }
    }

    .product-stock-badge {
        position: absolute;
        top: 8px;
        right: 8px;
        padding: 3px 8px;
        border-radius: 4px;
        font-size: 10px;
        font-weight: 600;
    }
    .product-stock-badge.in-stock { background: #26aa99; color: white; }
    .product-stock-badge.low-stock { background: #f69113; color: white; }
    .product-stock-badge.out-of-stock { background: #f53d2d; color: white; }

    .product-info {
        padding: 8px 8px 4px;
    }
    @media (min-width: 640px) {
        .product-info { padding: 10px; }
    }

    .product-name {
        font-size: 12px;
        font-weight: 500;
        color: #222;
        line-height: 1.3;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        min-height: 31px;
        margin-bottom: 3px;
    }
    @media (min-width: 640px) {
        .product-name {
            font-size: 13px;
            min-height: 36px;
            margin-bottom: 4px;
        }
    }

    .product-brand {
        font-size: 10px;
        color: #9b9b9b;
        margin-bottom: 2px;
    }
    @media (min-width: 640px) {
        .product-brand { font-size: 11px; margin-bottom: 4px; }
    }

    .product-price {
        font-size: 14px;
        font-weight: 700;
        color: #ee4d2d;
        margin-bottom: 4px;
    }
    @media (min-width: 640px) {
        .product-price { font-size: 15px; margin-bottom: 6px; }
    }

    .product-meta {
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-size: 9px;
        color: #9b9b9b;
        padding-top: 4px;
        border-top: 1px solid #f1f5f9;
        flex-wrap: wrap;
        gap: 2px;
    }
    @media (min-width: 640px) {
        .product-meta { font-size: 10px; padding-top: 6px; }
    }

    .product-meta-item {
        display: flex;
        align-items: center;
        gap: 3px;
    }

    /* Actions */
    .product-actions {
        border-top: 1px solid #f1f5f9;
        display: flex;
        gap: 4px;
        padding: 5px 8px 7px;
    }
    @media (min-width: 640px) {
        .product-actions { padding: 6px 10px 8px; }
    }

    .product-btn {
        flex: 1;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 3px;
        padding: 5px 6px;
        border-radius: 4px;
        font-size: 9px;
        font-weight: 600;
        transition: all 0.15s ease;
        text-decoration: none;
        border: none;
        cursor: pointer;
    }
    @media (min-width: 640px) {
        .product-btn { gap: 4px; padding: 5px 8px; font-size: 10px; }
    }
    .product-btn-edit {
        background: #ee4d2d;
        color: white;
    }
    .product-btn-edit:hover { background: #d63e1f; }
    .product-btn-delete {
        background: #f1f5f9;
        color: #475569;
    }
    .product-btn-delete:hover { background: #e2e8f0; }

    /* Empty State */
    .empty-state {
        text-align: center; padding: 60px 20px;
        background: white; border: 1px solid #e2e8f0; border-radius: 12px;
    }
    .empty-state-icon { font-size: 48px; color: #cbd5e1; margin-bottom: 16px; }
    .empty-state-title { font-size: 16px; font-weight: 600; color: #475569; }
    .empty-state-text { font-size: 13px; color: #94a3b8; margin-top: 4px; }
</style>

<div>
    <!-- Stats Row -->
    <div class="stats-row">
        <div class="stat-box">
            <div class="stat-icon orange"><i class="fas fa-box"></i></div>
            <div>
                <div class="stat-value">{{ $products->total() }}</div>
                <div class="stat-label">Total Produk</div>
            </div>
        </div>
        <div class="stat-box">
            <div class="stat-icon green"><i class="fas fa-check-circle"></i></div>
            <div>
                <div class="stat-value">{{ $products->where('stock', '>', 10)->count() }}</div>
                <div class="stat-label">Tersedia</div>
            </div>
        </div>
        <div class="stat-box">
            <div class="stat-icon blue"><i class="fas fa-chart-line"></i></div>
            <div>
                <div class="stat-value">Rp {{ number_format($products->avg('price') ?? 0, 0, ',', '.') }}</div>
                <div class="stat-label">Rata-rata Harga</div>
            </div>
        </div>
        <div class="stat-box">
            <div class="stat-icon purple"><i class="fas fa-tag"></i></div>
            <div>
                <div class="stat-value">{{ $products->where('stock', '>', 0)->sum('stock') }}</div>
                <div class="stat-label">Total Stok</div>
            </div>
        </div>
    </div>

    <!-- Filter Bar Category -->
    <div class="filter-bar">
        <span class="filter-label"><i class="fas fa-tags mr-1"></i> Kategori:</span>
        <div class="filter-chips" id="categoryFilter">
            <span class="filter-chip active" data-category="all">Semua</span>
            @php
                $categories = $products->pluck('category')->filter()->unique('id');
            @endphp
            @foreach($categories as $cat)
                <span class="filter-chip" data-category="{{ $cat->id }}">{{ $cat->name }}</span>
            @endforeach
        </div>
    </div>

    <!-- Filter Bar Status -->
    <div class="filter-bar" style="margin-top: 8px;">
        <span class="filter-label"><i class="fas fa-eye mr-1"></i> Status:</span>
        <div class="filter-chips" id="statusFilter">
            <span class="filter-chip active" data-status="all">Semua</span>
            <span class="filter-chip" data-status="published">Published</span>
            <span class="filter-chip" data-status="draft">Draft</span>
        </div>
    </div>

    <!-- Toolbar -->
    <div class="toolbar">
        <div class="toolbar-left">
            <div class="search-wrapper">
                <i class="fas fa-search"></i>
                <input type="text" class="search-input" placeholder="Cari produk..." id="searchProduct">
            </div>
        </div>
        <div class="toolbar-right">
            <a href="{{ route('generator.quick') }}" class="toolbar-btn" style="background: #ee4d2d; color: white;">
                <i class="fas fa-plus"></i> New Product
            </a>
            <a href="{{ route('products.export.page') }}" class="toolbar-btn" style="background: #10b981; color: white;">
                <i class="fas fa-file-excel"></i> Export
            </a>
        </div>
    </div>

    <!-- Product Grid -->
    @if($products->count() > 0)
        <div class="product-grid" id="productGrid">
            @foreach($products as $product)
                @php
                    $statusClass = $product->status === 'published' ? 'in-stock' : 'low-stock';
                    $statusText = $product->status === 'published' ? 'Published' : 'Draft';
                @endphp
                <div class="product-card" data-category="{{ $product->category_id }}" data-status="{{ $product->status }}">
                    <a href="{{ route('products.show', $product->uuid) }}" class="block">
                        <div class="product-image-wrapper">
                            <div class="product-image-inner">
                                @if($product->primary_image)
                                    <img src="{{ asset($product->primary_image) }}" alt="{{ $product->name }}" class="product-image" loading="lazy">
                                @else
                                    <div class="product-image-placeholder">
                                        <i class="fas fa-image"></i>
                                        <span>Tidak ada gambar</span>
                                    </div>
                                @endif
                            </div>
                            <div class="product-stock-badge {{ $statusClass }}">{{ $statusText }}</div>
                        </div>
                        <div class="product-info">
                            @if($product->brand)
                                <div class="product-brand">{{ $product->brand }}</div>
                            @endif
                            <h3 class="product-name">{{ $product->name }}</h3>
                            <div class="product-price">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                            <div class="product-meta">
                                @if($product->category)
                                    <span class="product-meta-item">
                                        <i class="fas fa-folder"></i> {{ $product->category->name }}
                                    </span>
                                @endif
                                @if($product->created_at)
                                    <span class="product-meta-item">
                                        <i class="fas fa-calendar"></i> {{ $product->created_at->format('d M Y') }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </a>
                    <div class="product-actions" onclick="event.stopPropagation();">
                        <a href="{{ route('products.edit', $product->uuid) }}" class="product-btn product-btn-edit" onclick="event.stopPropagation();">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <button type="button" class="product-btn" style="background: {{ $product->status === 'published' ? '#10b981' : '#f59e0b' }}; color: white;" onclick="event.stopPropagation(); toggleStatus('{{ $product->uuid }}')">
                            <i class="fas {{ $product->status === 'published' ? 'fa-eye' : 'fa-eye-slash' }}"></i> {{ $product->status === 'published' ? 'Published' : 'Draft' }}
                        </button>
                        <button type="button" class="product-btn product-btn-delete" onclick="event.stopPropagation(); deleteProduct('{{ $product->uuid }}')">
                            <i class="fas fa-trash-alt"></i> Hapus
                        </button>
                    </div>
                    <form id="delete-form-{{ $product->uuid }}" action="{{ route('products.destroy', $product->uuid) }}" method="POST" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
            @endforeach
        </div>
    @else
        <div class="empty-state">
            <div class="empty-state-icon"><i class="fas fa-box-open"></i></div>
            <h3 class="empty-state-title">Belum ada produk</h3>
            <p class="empty-state-text">Mulai dengan membuat produk baru menggunakan AI generator</p>
            <a href="{{ route('generator.quick') }}" class="toolbar-btn" style="background: #ee4d2d; color: white; margin-top: 16px; display: inline-flex;">
                <i class="fas fa-plus"></i> Buat Produk Pertama
            </a>
        </div>
    @endif
</div>

<script>
function deleteProduct(uuid) {
    showConfirmModal({
        title: 'Hapus Produk',
        message: 'Yakin ingin menghapus produk ini?',
        type: 'danger',
        confirmText: 'Hapus',
        cancelText: 'Batal'
    }).then(function(result) {
        if (result) {
            document.getElementById('delete-form-' + uuid).submit();
        }
    });
}

// Status Filter
document.querySelectorAll('#statusFilter .filter-chip').forEach(function(chip) {
    chip.addEventListener('click', function() {
        document.querySelectorAll('#statusFilter .filter-chip').forEach(function(c) {
            c.classList.remove('active');
        });
        this.classList.add('active');
        filterProducts();
    });
});

// Category Filter
document.querySelectorAll('#categoryFilter .filter-chip').forEach(function(chip) {
    chip.addEventListener('click', function() {
        document.querySelectorAll('#categoryFilter .filter-chip').forEach(function(c) {
            c.classList.remove('active');
        });
        this.classList.add('active');
        filterProducts();
    });
});

// Search
document.getElementById('searchProduct')?.addEventListener('input', function() {
    filterProducts();
});

// Combined filter function
function filterProducts() {
    const searchQuery = document.getElementById('searchProduct')?.value?.toLowerCase() || '';
    const activeCategory = document.querySelector('#categoryFilter .filter-chip.active');
    const selectedCategory = activeCategory ? activeCategory.getAttribute('data-category') : 'all';
    const activeStatus = document.querySelector('#statusFilter .filter-chip.active');
    const selectedStatus = activeStatus ? activeStatus.getAttribute('data-status') : 'all';

    document.querySelectorAll('.product-card').forEach(function(card) {
        const cardCategory = card.getAttribute('data-category');
        const cardStatus = card.getAttribute('data-status');
        const cardName = card.querySelector('.product-name')?.textContent?.toLowerCase() || '';
        
        const matchCategory = selectedCategory === 'all' || cardCategory === selectedCategory;
        const matchStatus = selectedStatus === 'all' || cardStatus === selectedStatus;
        const matchSearch = cardName.includes(searchQuery);
        
        card.style.display = (matchCategory && matchStatus && matchSearch) ? '' : 'none';
    });
}

// Toggle Status
function toggleStatus(uuid) {
    showConfirmModal({
        title: 'Ubah Status',
        message: 'Yakin ingin mengubah status produk ini?',
        type: 'warning',
        confirmText: 'Ubah',
        cancelText: 'Batal'
    }).then(function(result) {
        if (result) {
            var form = document.createElement('form');
            form.method = 'POST';
            form.action = '/products/' + uuid + '/toggle-status';
            var csrf = document.createElement('input');
            csrf.type = 'hidden'; csrf.name = '_token'; csrf.value = '{{ csrf_token() }}';
            form.appendChild(csrf);
            document.body.appendChild(form);
            form.submit();
        }
    });
}
</script>
@endsection