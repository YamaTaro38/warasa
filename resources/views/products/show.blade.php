@extends('layouts.dashboard')

@section('page-title', $product->name)
@section('breadcrumb', 'Product Details')

@section('content')
<style>
    /* Compact Product Detail Styles */
    :root {
        --shopee-orange: #ee4d2d;
        --shopee-orange-dark: #c63d22;
        --shopee-orange-light: #fef2ee;
        --shopee-gray-bg: #f8fafc;
        --shopee-border: #e2e8f0;
        --shopee-text-primary: #0f172a;
        --shopee-text-secondary: #475569;
        --shopee-text-tertiary: #94a3b8;
    }

    .product-detail-compact {
        max-width: 1400px;
        margin: 0 auto;
    }

    /* Breadcrumb Compact */
    .compact-breadcrumb {
        padding: 0 0 12px 0;
        font-size: 11px;
        color: var(--shopee-text-tertiary);
        margin-bottom: 16px;
        border-bottom: 1px solid var(--shopee-border);
    }
    .compact-breadcrumb a {
        color: var(--shopee-text-tertiary);
        text-decoration: none;
    }
    .compact-breadcrumb a:hover {
        color: var(--shopee-orange);
    }
    .compact-breadcrumb .separator {
        margin: 0 6px;
    }

    /* Main Product Section */
    .compact-product-main {
        display: flex;
        gap: 20px;
        background: white;
        border: 1px solid var(--shopee-border);
        border-radius: 10px;
        padding: 16px;
        margin-bottom: 16px;
    }

    /* Gallery */
    .compact-gallery {
        flex: 0 0 320px;
    }
    .compact-gallery-main {
        position: relative;
        width: 100%;
        aspect-ratio: 1;
        border: 1px solid var(--shopee-border);
        border-radius: 8px;
        overflow: hidden;
        background: white;
        cursor: pointer;
    }
    .compact-gallery-main img {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }
    .compact-gallery-thumbs {
        display: flex;
        gap: 6px;
        margin-top: 8px;
        overflow-x: auto;
        padding-bottom: 2px;
    }
    .compact-thumb {
        width: 56px;
        height: 56px;
        border: 1px solid var(--shopee-border);
        border-radius: 6px;
        cursor: pointer;
        overflow: hidden;
        transition: all 0.2s;
    }
    .compact-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .compact-thumb.active {
        border-color: var(--shopee-orange);
        box-shadow: 0 0 0 2px rgba(238,77,45,0.15);
    }
    .compact-thumb:hover {
        border-color: var(--shopee-orange);
    }

    /* Product Info */
    .compact-info {
        flex: 1;
    }
    .compact-product-name {
        font-size: 18px;
        font-weight: 600;
        color: var(--shopee-text-primary);
        margin-bottom: 6px;
        line-height: 1.35;
    }
    .compact-product-meta {
        font-size: 11px;
        color: var(--shopee-text-tertiary);
        margin-bottom: 12px;
        padding-bottom: 10px;
        border-bottom: 1px solid var(--shopee-border);
        display: flex;
        gap: 16px;
    }
    
    /* Price Section */
    .compact-price-section {
        background: var(--shopee-gray-bg);
        padding: 12px 14px;
        border-radius: 8px;
        margin-bottom: 12px;
        display: flex;
        align-items: baseline;
        gap: 12px;
        flex-wrap: wrap;
    }
    .compact-price-label {
        font-size: 12px;
        font-weight: 500;
        color: var(--shopee-text-secondary);
    }
    .compact-price {
        font-size: 22px;
        font-weight: 600;
        color: var(--shopee-orange);
    }
    .compact-price-currency {
        font-size: 14px;
        margin-right: 2px;
    }
    
    /* Info Grid */
    .compact-info-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 8px 16px;
        margin-bottom: 12px;
    }
    .compact-info-item {
        display: flex;
        justify-content: space-between;
        align-items: baseline;
        padding: 6px 0;
        border-bottom: 1px dashed var(--shopee-border);
    }
    .compact-info-label {
        font-size: 11px;
        font-weight: 500;
        color: var(--shopee-text-secondary);
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }
    .compact-info-value {
        font-size: 12px;
        font-weight: 500;
        color: var(--shopee-text-primary);
    }
    
    /* Status Badge */
    .compact-status {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 2px 8px;
        border-radius: 20px;
        font-size: 10px;
        font-weight: 600;
    }
    .compact-status-published {
        background: #ecfdf5;
        color: #10b981;
    }
    .compact-status-draft {
        background: #fffbeb;
        color: #f59e0b;
    }
    
    /* Variations */
    .compact-variation-section {
        margin: 12px 0;
    }
    .compact-variation-title {
        font-size: 12px;
        font-weight: 600;
        color: var(--shopee-text-primary);
        margin-bottom: 8px;
    }
    .compact-variation-options {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }
    .compact-variation-option {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 10px;
        border: 1px solid var(--shopee-border);
        border-radius: 6px;
        background: white;
        font-size: 11px;
        font-weight: 500;
        cursor: default;
    }
    .compact-variation-option-img {
        width: 18px;
        height: 18px;
        border-radius: 3px;
        object-fit: cover;
    }
    
    /* Shipping */
    .compact-shipping {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        margin-top: 6px;
    }
    .compact-shipping-item {
        padding: 2px 8px;
        background: var(--shopee-gray-bg);
        border-radius: 4px;
        font-size: 10px;
        font-weight: 500;
        color: var(--shopee-text-secondary);
        text-transform: uppercase;
    }
    
    /* Action Buttons */
    .compact-actions {
        display: flex;
        gap: 10px;
        margin-top: 16px;
        padding-top: 12px;
        border-top: 1px solid var(--shopee-border);
    }
    .compact-btn {
        padding: 6px 14px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .compact-btn-primary {
        background: var(--shopee-orange);
        color: white;
        border: none;
    }
    .compact-btn-primary:hover {
        background: var(--shopee-orange-dark);
    }
    .compact-btn-outline {
        background: white;
        border: 1px solid var(--shopee-border);
        color: var(--shopee-text-primary);
    }
    .compact-btn-outline:hover {
        border-color: var(--shopee-orange);
        color: var(--shopee-orange);
    }
    .compact-btn-danger:hover {
        border-color: #ef4444;
        color: #ef4444;
    }

    /* Description & Spec Sections */
    .compact-section {
        background: white;
        border: 1px solid var(--shopee-border);
        border-radius: 10px;
        margin-bottom: 16px;
        overflow: hidden;
    }
    .compact-section-header {
        padding: 10px 14px;
        border-bottom: 1px solid var(--shopee-border);
        background: var(--shopee-gray-bg);
    }
    .compact-section-title {
        font-size: 13px;
        font-weight: 600;
        color: var(--shopee-text-primary);
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .compact-section-title i {
        color: var(--shopee-orange);
        font-size: 12px;
    }
    .compact-section-body {
        padding: 16px 20px;
    }
    
    /* Description HTML Content Styling */
    .product-description {
        font-size: 14px;
        line-height: 1.7;
        color: var(--shopee-text-secondary);
        word-wrap: break-word;
    }
    
    .product-description p {
        margin-bottom: 16px;
    }
    
    .product-description p:last-child {
        margin-bottom: 0;
    }
    
    .product-description strong,
    .product-description b {
        color: var(--shopee-text-primary);
        font-weight: 600;
    }
    
    .product-description em,
    .product-description i {
        font-style: italic;
    }
    
    .product-description h1,
    .product-description h2,
    .product-description h3,
    .product-description h4,
    .product-description h5,
    .product-description h6 {
        margin: 20px 0 12px 0;
        font-weight: 600;
        color: var(--shopee-text-primary);
        line-height: 1.4;
    }
    
    .product-description h1 { font-size: 24px; }
    .product-description h2 { font-size: 20px; }
    .product-description h3 { font-size: 18px; }
    .product-description h4 { font-size: 16px; }
    .product-description h5 { font-size: 14px; }
    .product-description h6 { font-size: 13px; }
    
    .product-description ul,
    .product-description ol {
        margin: 12px 0 16px 24px;
        padding: 0;
    }
    
    .product-description li {
        margin-bottom: 6px;
        line-height: 1.6;
    }
    
    .product-description ul ul,
    .product-description ol ol,
    .product-description ul ol,
    .product-description ol ul {
        margin: 6px 0 6px 20px;
    }
    
    .product-description a {
        color: var(--shopee-orange);
        text-decoration: none;
    }
    
    .product-description a:hover {
        text-decoration: underline;
    }
    
    .product-description table {
        width: 100%;
        border-collapse: collapse;
        margin: 16px 0;
        font-size: 13px;
    }
    
    .product-description table th,
    .product-description table td {
        border: 1px solid var(--shopee-border);
        padding: 10px 12px;
        text-align: left;
        vertical-align: top;
    }
    
    .product-description table th {
        background: var(--shopee-gray-bg);
        font-weight: 600;
        color: var(--shopee-text-primary);
    }
    
    .product-description table tr:nth-child(even) {
        background: var(--shopee-gray-bg);
    }
    
    .product-description img {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
        margin: 12px 0;
    }
    
    .product-description blockquote {
        margin: 16px 0;
        padding: 12px 20px;
        border-left: 4px solid var(--shopee-orange);
        background: var(--shopee-gray-bg);
        font-style: italic;
        color: var(--shopee-text-secondary);
    }
    
    .product-description code {
        background: #f1f5f9;
        padding: 2px 6px;
        border-radius: 4px;
        font-family: 'SF Mono', Monaco, 'Cascadia Code', 'Roboto Mono', monospace;
        font-size: 13px;
        color: #d63384;
    }
    
    .product-description pre {
        background: #1e293b;
        color: #e2e8f0;
        padding: 16px;
        border-radius: 8px;
        overflow-x: auto;
        font-size: 13px;
        line-height: 1.5;
        margin: 16px 0;
    }
    
    .product-description pre code {
        background: transparent;
        padding: 0;
        color: inherit;
    }
    
    .product-description hr {
        margin: 20px 0;
        border: none;
        border-top: 1px solid var(--shopee-border);
    }
    
    /* Spec Table */
    .compact-spec-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
    }
    .compact-spec-table tr {
        border-bottom: 1px solid var(--shopee-border);
    }
    .compact-spec-table tr:last-child {
        border-bottom: none;
    }
    .compact-spec-table th {
        width: 140px;
        padding: 12px 16px;
        background: var(--shopee-gray-bg);
        font-weight: 600;
        text-align: left;
        font-size: 12px;
        color: var(--shopee-text-secondary);
        letter-spacing: 0.3px;
    }
    .compact-spec-table td {
        padding: 12px 16px;
        font-size: 13px;
        color: var(--shopee-text-primary);
        line-height: 1.5;
    }
    
    /* Keyword Tags */
    .keyword-tag {
        display: inline-block;
        background: var(--shopee-gray-bg);
        padding: 4px 10px;
        border-radius: 4px;
        margin: 2px;
        font-size: 11px;
        font-weight: 500;
        color: var(--shopee-text-secondary);
    }
    .keyword-tag:hover {
        background: var(--shopee-orange-light);
        color: var(--shopee-orange);
    }

    /* Lightbox */
    .compact-lightbox {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.9);
        z-index: 10000;
        justify-content: center;
        align-items: center;
        cursor: pointer;
    }
    .compact-lightbox.active {
        display: flex;
    }
    .compact-lightbox img {
        max-width: 90%;
        max-height: 90%;
        object-fit: contain;
    }

    /* Modal */
    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(4px);
        z-index: 1000;
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        visibility: hidden;
        transition: all 0.2s ease;
    }
    .modal-overlay.active {
        opacity: 1;
        visibility: visible;
    }
    .modal-container {
        background: white;
        border-radius: 12px;
        width: 400px;
        max-width: 90%;
        box-shadow: 0 20px 40px -12px rgba(0, 0, 0, 0.25);
        transform: scale(0.95);
        transition: transform 0.2s ease;
        overflow: hidden;
    }
    .modal-overlay.active .modal-container {
        transform: scale(1);
    }
    .modal-header {
        padding: 14px 20px;
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .modal-header i {
        font-size: 18px;
    }
    .modal-header.danger i {
        color: #ef4444;
    }
    .modal-title {
        font-size: 14px;
        font-weight: 600;
        color: #1e293b;
        flex: 1;
    }
    .modal-body {
        padding: 20px;
        font-size: 13px;
        color: #475569;
        line-height: 1.5;
    }
    .modal-footer {
        padding: 12px 20px;
        border-top: 1px solid #e2e8f0;
        display: flex;
        justify-content: flex-end;
        gap: 10px;
    }
    .modal-btn {
        padding: 6px 16px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
        border: none;
    }
    .modal-btn-cancel {
        background: #f1f5f9;
        color: #475569;
    }
    .modal-btn-cancel:hover {
        background: #e2e8f0;
    }
    .modal-btn-danger {
        background: #ef4444;
        color: white;
    }
    .modal-btn-danger:hover {
        background: #dc2626;
    }

    /* Empty State */
    .empty-description {
        color: #94a3b8;
        font-style: italic;
        font-size: 13px;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .compact-product-main {
            flex-direction: column;
        }
        .compact-gallery {
            flex: none;
        }
        .compact-info-grid {
            grid-template-columns: 1fr;
        }
        .compact-actions {
            flex-wrap: wrap;
        }
        .compact-spec-table th {
            width: 100px;
        }
        .compact-section-body {
            padding: 12px 16px;
        }
        .product-description {
            font-size: 13px;
        }
    }
</style>

<div class="product-detail-compact">
    <!-- Breadcrumb -->
    <div class="compact-breadcrumb">
        <a href="{{ route('dashboard') }}"><i class="fas fa-home"></i></a>
        <span class="separator">›</span>
        <a href="{{ route('products.index') }}">Products</a>
        <span class="separator">›</span>
        <span>{{ \Illuminate\Support\Str::limit($product->name, 40) }}</span>
    </div>

    <!-- Main Product Section -->
    <div class="compact-product-main">
        <!-- Gallery Section -->
        <div class="compact-gallery">
            <div class="compact-gallery-main" onclick="openLightbox()">
                @php $firstImage = $images->first(); @endphp
                <img id="mainImage" src="{{ $firstImage ? asset($firstImage->path) : 'https://placehold.co/320x320/e2e8f0/94a3b8?text=No+Image' }}" alt="{{ $product->name }}">
            </div>
            @if($images->count() > 1)
            <div class="compact-gallery-thumbs" id="galleryThumbs">
                @foreach($images as $index => $image)
                <div class="compact-thumb {{ $index === 0 ? 'active' : '' }}" onclick="changeImage('{{ asset($image->path) }}', {{ $index }})">
                    <img src="{{ asset($image->path) }}" alt="Thumb {{ $index + 1 }}">
                </div>
                @endforeach
            </div>
            @endif
        </div>

        <!-- Product Info Section -->
        <div class="compact-info">
            <h1 class="compact-product-name">{{ $product->name }}</h1>
            <div class="compact-product-meta">
                <span><i class="fas fa-tag"></i> {{ $product->brand ?? 'No Brand' }}</span>
                <span><i class="fas fa-barcode"></i> SKU: {{ substr($product->uuid, 0, 8) }}</span>
            </div>

            <div class="compact-price-section">
                <span class="compact-price-label">Harga</span>
                <span class="compact-price">
                    <span class="compact-price-currency">Rp</span> {{ number_format($product->price, 0, ',', '.') }}
                </span>
                @if($product->stock > 0)
                    <span class="compact-status compact-status-published" style="margin-left: auto;">
                        <i class="fas fa-check-circle"></i> In Stock
                    </span>
                @else
                    <span class="compact-status compact-status-draft" style="margin-left: auto;">
                        <i class="fas fa-clock"></i> Out of Stock
                    </span>
                @endif
            </div>

            <div class="compact-info-grid">
                <div class="compact-info-item">
                    <span class="compact-info-label"><i class="fas fa-box"></i> Stock</span>
                    <span class="compact-info-value">{{ number_format($product->stock) }} items</span>
                </div>
                <div class="compact-info-item">
                    <span class="compact-info-label"><i class="fas fa-weight-hanging"></i> Weight</span>
                    <span class="compact-info-value">{{ number_format($product->weight) }} g</span>
                </div>
                <div class="compact-info-item">
                    <span class="compact-info-label"><i class="fas fa-arrows-alt"></i> Dimension</span>
                    <span class="compact-info-value">{{ $product->dimension ?? '-' }} cm</span>
                </div>
                <div class="compact-info-item">
                    <span class="compact-info-label"><i class="fas fa-folder"></i> Category</span>
                    <span class="compact-info-value">{{ $product->category->name ?? '-' }}</span>
                </div>
                <div class="compact-info-item">
                    <span class="compact-info-label"><i class="fas fa-chart-line"></i> Status</span>
                    <span class="compact-info-value">
                        <span class="compact-status {{ $product->status === 'published' ? 'compact-status-published' : 'compact-status-draft' }}">
                            <i class="fas {{ $product->status === 'published' ? 'fa-check-circle' : 'fa-pen' }}"></i>
                            {{ ucfirst($product->status === 'published' ? 'Published' : 'Draft') }}
                        </span>
                    </span>
                </div>
                <div class="compact-info-item">
                    <span class="compact-info-label"><i class="fas fa-calendar"></i> Created</span>
                    <span class="compact-info-value">{{ $product->created_at->format('d M Y') }}</span>
                </div>
            </div>

            <!-- Variations -->
            @if(!empty($product->variations) && count($product->variations) > 0)
                @foreach($product->variations as $variation)
                <div class="compact-variation-section">
                    <div class="compact-variation-title">{{ ucfirst($variation['name'] ?? 'Variation') }}</div>
                    <div class="compact-variation-options">
                        @foreach($variation['options'] as $option)
                            @if(is_array($option) && isset($option['value']))
                            <div class="compact-variation-option">
                                @if(isset($option['image']) && $option['image'])
                                    <img src="{{ asset($option['image']) }}" class="compact-variation-option-img">
                                @endif
                                {{ $option['value'] }}
                            </div>
                            @else
                            <div class="compact-variation-option">{{ $option }}</div>
                            @endif
                        @endforeach
                    </div>
                </div>
                @endforeach
            @endif

            <!-- Shipping -->
            <div class="compact-variation-section">
                <div class="compact-variation-title"><i class="fas fa-truck"></i> Shipping Options</div>
                <div class="compact-shipping">
                    @php
                        $shippingOptions = is_array($product->shipping_options) 
                            ? $product->shipping_options 
                            : (is_string($product->shipping_options) 
                                ? json_decode($product->shipping_options, true) 
                                : ['jne', 'jnt', 'pos', 'sicepat']);
                    @endphp
                    @foreach($shippingOptions as $option)
                        <span class="compact-shipping-item">{{ strtoupper($option) }}</span>
                    @endforeach
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="compact-actions">
                <a href="{{ route('products.edit', $product->uuid) }}" class="compact-btn compact-btn-primary">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <button onclick="openDeleteModal('{{ $product->uuid }}', '{{ addslashes($product->name) }}')" class="compact-btn compact-btn-outline compact-btn-danger">
                    <i class="fas fa-trash-alt"></i> Delete
                </button>
                <a href="{{ route('products.duplicate', $product->uuid) }}" class="compact-btn compact-btn-outline">
                    <i class="fas fa-copy"></i> Duplicate
                </a>
                <a href="{{ route('products.index') }}" class="compact-btn compact-btn-outline">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
            </div>
        </div>
    </div>

    <!-- Description Section with HTML Formatting -->
    <div class="compact-section">
        <div class="compact-section-header">
            <div class="compact-section-title">
                <i class="fas fa-align-left"></i> Product Description
            </div>
        </div>
        <div class="compact-section-body">
            <div class="product-description">
                @if($product->description && trim($product->description) !== '')
                    <div id="markdown-description" style="display:none;">{{ $product->description }}</div>
                    <div id="rendered-description"></div>
                @else
                    <div class="empty-description">
                        <i class="fas fa-edit"></i> No description provided.
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Specifications Section -->
    <div class="compact-section">
        <div class="compact-section-header">
            <div class="compact-section-title">
                <i class="fas fa-microchip"></i> Specifications
            </div>
        </div>
        <div class="compact-section-body" style="padding: 0;">
            <table class="compact-spec-table">
                <tr>
                    <th>Product Name</th>
                    <td>{{ $product->name }}</td>
                </tr>
                <tr>
                    <th>Brand</th>
                    <td>{{ $product->brand ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Category</th>
                    <td>{{ $product->category->name ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Price</th>
                    <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <th>Stock</th>
                    <td>{{ number_format($product->stock) }} items</td>
                </tr>
                <tr>
                    <th>Weight</th>
                    <td>{{ number_format($product->weight) }} g</td>
                </tr>
                <tr>
                    <th>Dimension</th>
                    <td>{{ $product->dimension ?? '-' }} cm</td>
                </tr>
                @if($product->ai_generated_title)
                <tr>
                    <th>SEO Title</th>
                    <td>{{ $product->ai_generated_title }}</td>
                </tr>
                @endif
                @if($product->keywords)
                <tr>
                    <th>Keywords</th>
                    <td>
                        @php
                            $keywords = is_array($product->keywords) ? $product->keywords : explode(',', $product->keywords ?? '');
                        @endphp
                        @foreach($keywords as $keyword)
                            @if(trim($keyword))
                                <span class="keyword-tag">{{ trim($keyword) }}</span>
                            @endif
                        @endforeach
                    </td>
                </tr>
                @endif
                @if($product->created_at)
                <tr>
                    <th>Created Date</th>
                    <td>{{ $product->created_at->format('d M Y H:i') }}</td>
                </tr>
                @endif
                <tr>
                    <th>Last Updated</th>
                    <td>{{ $product->updated_at->format('d M Y H:i') }}</td>
                </tr>
            </table>
        </div>
    </div>
</div>

<!-- Lightbox Modal -->
<div id="lightboxModal" class="compact-lightbox" onclick="closeLightbox()">
    <img id="lightboxImage" src="" alt="Preview">
</div>

<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
<script>
// Gallery Functions
let currentImageIndex = 0;
let imageUrls = [];

@php
    $imageUrlsArray = [];
    foreach($images as $img) {
        $imageUrlsArray[] = asset($img->path);
    }
@endphp

imageUrls = {!! json_encode($imageUrlsArray) !!};

// Render Markdown Description
(function() {
    var mdEl = document.getElementById('markdown-description');
    var renderedEl = document.getElementById('rendered-description');
    if (mdEl && renderedEl) {
        var mdText = mdEl.textContent || mdEl.innerText || '';
        if (mdText.trim()) {
            renderedEl.innerHTML = marked.parse(mdText);
        }
    }
})();

function changeImage(src, index) {
    const mainImage = document.getElementById('mainImage');
    if (mainImage) mainImage.src = src;
    currentImageIndex = index;
    
    const thumbs = document.querySelectorAll('.compact-thumb');
    thumbs.forEach((thumb, i) => {
        if (i === index) {
            thumb.classList.add('active');
        } else {
            thumb.classList.remove('active');
        }
    });
}

function openLightbox() {
    const modal = document.getElementById('lightboxModal');
    const img = document.getElementById('lightboxImage');
    if (imageUrls.length > 0 && imageUrls[currentImageIndex]) {
        img.src = imageUrls[currentImageIndex];
    } else {
        const mainImage = document.getElementById('mainImage');
        if (mainImage) img.src = mainImage.src;
    }
    modal.classList.add('active');
}

function closeLightbox() {
    const modal = document.getElementById('lightboxModal');
    if (modal) modal.classList.remove('active');
}

// Escape HTML helper
function escapeHtml(text) {
    if (!text) return '';
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

// Delete Functions
function openDeleteModal(uuid, productName) {
    const existingModal = document.getElementById('deleteModal');
    if (existingModal) existingModal.remove();
    
    const modal = document.createElement('div');
    modal.className = 'modal-overlay';
    modal.id = 'deleteModal';
    modal.innerHTML = `
        <div class="modal-container">
            <div class="modal-header danger">
                <i class="fas fa-exclamation-triangle"></i>
                <div class="modal-title">Delete Product</div>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete <strong>${escapeHtml(productName)}</strong>?</p>
                <p class="text-xs text-gray-400 mt-2" style="font-size: 11px; color: #94a3b8;">This action cannot be undone. All product data will be permanently removed.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="modal-btn modal-btn-cancel" id="cancelDeleteBtn">Cancel</button>
                <button type="button" class="modal-btn modal-btn-danger" id="confirmDeleteBtn">Delete</button>
            </div>
        </div>
    `;
    document.body.appendChild(modal);
    setTimeout(() => modal.classList.add('active'), 10);
    
    const cancelBtn = document.getElementById('cancelDeleteBtn');
    const confirmBtn = document.getElementById('confirmDeleteBtn');
    
    if (cancelBtn) cancelBtn.addEventListener('click', closeDeleteModal);
    if (confirmBtn) confirmBtn.addEventListener('click', function() {
        confirmDelete(uuid);
    });
    
    modal.addEventListener('click', function(e) {
        if (e.target === modal) closeDeleteModal();
    });
}

function closeDeleteModal() {
    const modal = document.getElementById('deleteModal');
    if (modal) {
        modal.classList.remove('active');
        setTimeout(() => modal.remove(), 300);
    }
}

async function confirmDelete(uuid) {
    closeDeleteModal();
    
    try {
        const response = await fetch(`/products/${uuid}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        });
        
        const data = await response.json();
        
        if (data.success) {
            alert('Product deleted successfully!');
            setTimeout(() => {
                window.location.href = '{{ route("products.index") }}';
            }, 500);
        } else {
            alert('Failed to delete: ' + (data.message || 'Unknown error'));
        }
    } catch (error) {
        console.error('Delete error:', error);
        alert('Error: ' + error.message);
    }
}
</script>
@endsection