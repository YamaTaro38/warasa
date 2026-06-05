@extends('layouts.dashboard')

@section('page-title', 'Edit Product')
@section('breadcrumb', 'Edit Product')

@section('content')
<style>
    /* Premium Form Styles - Compact Dashboard-aligned Sizing */
    .form-container {
        max-width: 1400px;
        margin: 0 auto;
    }
    
    .form-section {
        background: white;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        padding: 16px;
        margin-bottom: 16px;
        box-shadow: 0 1px 2px rgba(0,0,0,0.01);
        transition: all 0.2s;
    }
    
    .section-title {
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 16px;
        padding-bottom: 8px;
        border-bottom: 1px solid #e9ecef;
        display: flex;
        align-items: center;
        gap: 8px;
        color: #1a1a2e;
    }
    
    .section-title i {
        color: #ee4d2d;
        font-size: 14px;
    }
    
    .form-grid-2 {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 16px;
    }
    
    .form-grid-3 {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 16px;
    }
    
    .form-group {
        margin-bottom: 0;
    }
    
    .form-label {
        display: block;
        font-size: 11px;
        font-weight: 600;
        color: #4a5568;
        margin-bottom: 4px;
    }
    
    .form-label .required {
        color: #ef4444;
    }
    
    .input-solid {
        width: 100%;
        padding: 6px 10px;
        border: 1px solid #cbd5e1;
        border-radius: 6px;
        font-size: 12px;
        transition: all 0.2s;
        background: white;
    }
    
    .input-solid:focus {
        outline: none;
        border-color: #ee4d2d;
        box-shadow: 0 0 0 2px rgba(238,77,45,0.1);
    }
    
    textarea.input-solid {
        resize: vertical;
        min-height: 120px;
        font-family: 'Inter', sans-serif;
        line-height: 1.5;
    }
    
    .description-editor {
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        overflow: hidden;
    }
    
    .description-content {
        min-height: 200px;
        padding: 12px;
        font-size: 12px;
        line-height: 1.6;
        color: #2d3748;
        background: white;
        overflow-y: auto;
    }
    
    .description-content:focus {
        outline: none;
    }
    
    .description-content p {
        margin-bottom: 8px;
    }
    
    .description-content ul, 
    .description-content ol {
        margin: 6px 0 10px 18px;
    }
    
    .autocomplete-container {
        position: relative;
    }
    
    .autocomplete-dropdown {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        max-height: 200px;
        overflow-y: auto;
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.05);
        z-index: 50;
        display: none;
    }
    
    .autocomplete-dropdown.active {
        display: block;
    }
    
    .autocomplete-item {
        padding: 8px 12px;
        cursor: pointer;
        transition: background 0.2s;
        border-bottom: 1px solid #f1f5f9;
    }
    
    .autocomplete-item:hover {
        background: #f8fafc;
    }
    
    .category-path {
        font-size: 10px;
        color: #94a3b8;
        margin-top: 2px;
    }
    
    .gallery-container {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 12px;
    }
    
    .gallery-item {
        position: relative;
        width: 70px;
        height: 70px;
        border-radius: 6px;
        overflow: hidden;
        border: 1px solid #cbd5e1;
        background: #f8fafc;
        transition: all 0.2s;
    }
    
    .gallery-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .gallery-item .remove-img {
        position: absolute;
        top: 4px;
        right: 4px;
        background: rgba(0,0,0,0.6);
        color: white;
        border-radius: 50%;
        width: 18px;
        height: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 8px;
        cursor: pointer;
        transition: all 0.2s;
    }
    
    .gallery-item .remove-img:hover {
        background: #ef4444;
    }
    
    .upload-btn {
        width: 70px;
        height: 70px;
        border: 2px dashed #cbd5e1;
        border-radius: 6px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 11px;
        color: #64748b;
        background: #f8fafc;
        transition: all 0.2s;
    }
    
    .upload-btn:hover {
        border-color: #ee4d2d;
        color: #ee4d2d;
        background: #fff5f2;
    }
    
    .keywords-container {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        align-items: center;
        border: 1px solid #cbd5e1;
        border-radius: 6px;
        padding: 6px 10px;
        min-height: 38px;
        background: white;
    }
    
    .keyword-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 3px 8px;
        background: #f1f5f9;
        border-radius: 15px;
        font-size: 11px;
        color: #1e293b;
    }
    
    .keyword-badge i {
        cursor: pointer;
        font-size: 9px;
        color: #94a3b8;
        transition: color 0.2s;
    }
    
    .keyword-badge i:hover {
        color: #ef4444;
    }
    
    .keywords-input {
        border: none;
        flex: 1;
        min-width: 120px;
        padding: 4px;
        font-size: 12px;
        outline: none;
        background: transparent;
    }
    
    .shipping-cards {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }
    
    .shipping-card {
        padding: 6px 14px;
        border: 1px solid #cbd5e1;
        border-radius: 20px;
        cursor: pointer;
        text-align: center;
        transition: all 0.2s;
        background: white;
        font-size: 12px;
        font-weight: 500;
    }
    
    .shipping-card.selected {
        background: #ee4d2d;
        border-color: #ee4d2d;
        color: white;
    }
    
    .variation-card {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 12px;
        margin-bottom: 12px;
    }
    
    .variation-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 12px;
        flex-wrap: wrap;
        gap: 10px;
    }
    
    .variation-options {
        display: flex;
        flex-direction: column;
        gap: 8px;
        margin-top: 10px;
    }
    
    .option-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 8px;
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        flex-wrap: wrap;
    }
    
    .option-value {
        flex: 1;
        font-weight: 500;
        font-size: 12px;
    }
    
    .option-image {
        width: 40px;
        height: 40px;
        border-radius: 4px;
        overflow: hidden;
        background: #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #e2e8f0;
        cursor: pointer;
    }
    
    .option-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .option-upload-btn {
        background: none;
        border: 1px solid #cbd5e1;
        border-radius: 4px;
        padding: 4px 10px;
        font-size: 11px;
        cursor: pointer;
        transition: all 0.2s;
    }
    
    .option-upload-btn:hover {
        border-color: #ee4d2d;
        color: #ee4d2d;
    }
    
    .option-remove-img {
        color: #ef4444;
        cursor: pointer;
        font-size: 14px;
    }
    
    .enable-images-checkbox {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 11px;
    }
    
    .btn-save {
        background: #ee4d2d;
        color: white;
        padding: 6px 16px;
        border-radius: 6px;
        font-weight: 500;
        font-size: 12px;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
    }
    
    .btn-save:hover {
        background: #d63e1f;
        transform: translateY(-1px);
        box-shadow: 0 2px 6px rgba(238,77,45,0.2);
    }
    
    .btn-cancel {
        background: #f1f5f9;
        color: #475569;
        padding: 6px 16px;
        border-radius: 6px;
        font-weight: 500;
        font-size: 12px;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    
    .btn-cancel:hover {
        background: #e2e8f0;
    }
    
    .dimension-group {
        display: flex;
        gap: 8px;
        align-items: center;
    }
    
    .dimension-group input {
        flex: 1;
        text-align: center;
    }
    
    .variation-info {
        font-size: 11px;
        color: #64748b;
        margin-top: 8px;
        padding: 8px 12px;
        background: #fff5f2;
        border-radius: 6px;
    }
    
    @media (max-width: 900px) {
        .form-grid-2, .form-grid-3 {
            grid-template-columns: 1fr;
            gap: 12px;
        }
        .form-section {
            padding: 12px;
        }
    }
</style>

<div class="form-container">
    <div class="mb-4">
        <h1 class="text-lg font-semibold text-gray-800">Edit Product</h1>
        <p class="text-xs text-gray-500 mt-0.5">Update product information and details</p>
    </div>

    <form id="editProductForm">
        @csrf
        @method('PUT')
        
        <!-- Basic Information -->
        <div class="form-section">
            <div class="section-title">
                <i class="fas fa-box"></i>
                <span>Basic Information</span>
            </div>
            <div class="form-grid-2">
                <div class="form-group">
                    <label class="form-label">Product Name <span class="required">*</span></label>
                    <input type="text" name="name" class="input-solid" value="{{ $product->name }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Brand</label>
                    <input type="text" name="brand" class="input-solid" value="{{ $product->brand }}">
                </div>
                <div class="form-group">
                    <label class="form-label">Category</label>
                    <div class="autocomplete-container">
                        <input type="text" id="categorySearch" class="input-solid w-full" placeholder="Cari kategori..." autocomplete="off">
                        <div id="categoryDropdown" class="autocomplete-dropdown"></div>
                    </div>
                    <input type="hidden" id="categoryId" name="category_id" value="{{ $product->category_id }}">
                </div>
                <div class="form-group">
                    <label class="form-label">Project</label>
                    <select name="project_id" class="input-solid">
                        <option value="">Select Project</option>
                        @foreach($projects as $project)
                            <option value="{{ $project->id }}" {{ $product->project_id == $project->id ? 'selected' : '' }}>
                                {{ $project->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <!-- Pricing & Inventory -->
        <div class="form-section">
            <div class="section-title">
                <i class="fas fa-chart-line"></i>
                <span>Pricing & Inventory</span>
            </div>
            <div class="form-grid-3">
                <div class="form-group">
                    <label class="form-label">Price (Rp)</label>
                    <input type="text" id="priceInput" name="price" class="input-solid" value="{{ number_format($product->price, 0, ',', '.') }}">
                </div>
                <div class="form-group">
                    <label class="form-label">Stock</label>
                    <input type="number" name="stock" class="input-solid" value="{{ $product->stock }}">
                </div>
                <div class="form-group">
                    <label class="form-label">Weight (gram)</label>
                    <input type="number" name="weight" class="input-solid" step="any" value="{{ $product->weight }}">
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Dimension (P x L x T) cm</label>
                <div class="dimension-group">
                    @php
                        $dimensions = explode('x', $product->dimension ?? '30x20x5');
                        $dimP = $dimensions[0] ?? 30;
                        $dimL = $dimensions[1] ?? 20;
                        $dimT = $dimensions[2] ?? 5;
                    @endphp
                    <input type="number" id="dimensionP" class="input-solid" placeholder="P" value="{{ $dimP }}">
                    <span class="text-gray-400">x</span>
                    <input type="number" id="dimensionL" class="input-solid" placeholder="L" value="{{ $dimL }}">
                    <span class="text-gray-400">x</span>
                    <input type="number" id="dimensionT" class="input-solid" placeholder="T" value="{{ $dimT }}">
                </div>
                <input type="hidden" name="dimension" id="dimensionInput" value="{{ $product->dimension }}">
            </div>
        </div>

        <!-- Product Images -->
        <div class="form-section">
            <div class="section-title">
                <i class="fas fa-images"></i>
                <span>Product Images</span>
            </div>
            <div id="galleryContainer" class="gallery-container"></div>
            <div class="upload-btn" id="uploadImageBtn">
                <i class="fas fa-plus"></i>
                <span class="text-[10px]">Upload Image</span>
            </div>
            <input type="file" id="imageUploadInput" accept="image/jpeg,image/png,image/jpg" multiple style="display: none;">
            <p class="text-xs text-gray-400 mt-3">Click on image to remove. Supports JPG, PNG (max 5MB)</p>
        </div>

        <!-- Description - Simple Textarea (No HTML) -->
        <div class="form-section">
            <div class="section-title">
                <i class="fas fa-align-left"></i>
                <span>Product Description</span>
            </div>
            <div class="form-group">
                <textarea name="description" id="productDescription" class="input-solid" rows="10">{{ $product->description }}</textarea>
                <p class="text-xs text-gray-400 mt-2">Plain text description. You can use basic formatting.</p>
            </div>
        </div>

        <!-- Keywords -->
        <div class="form-section">
            <div class="section-title">
                <i class="fas fa-tags"></i>
                <span>SEO Keywords</span>
            </div>
            <div class="form-group">
                <div class="keywords-container" id="keywordsContainer">
                    <div id="keywordsBadges"></div>
                    <input type="text" id="keywordInput" class="keywords-input" placeholder="Type keyword and press Enter or comma...">
                </div>
                <input type="hidden" name="keywords" id="keywordsHidden" value="{{ is_array($product->keywords) ? implode(',', $product->keywords) : $product->keywords }}">
                <p class="text-xs text-gray-400 mt-2">Press Enter or comma to add keyword</p>
            </div>
            <div class="form-group mt-4">
                <label class="form-label">SEO Title</label>
                <input type="text" name="ai_generated_title" class="input-solid" value="{{ $product->ai_generated_title }}" placeholder="Optional SEO title">
            </div>
        </div>

        <!-- Shipping Options -->
        <div class="form-section">
            <div class="section-title">
                <i class="fas fa-truck"></i>
                <span>Shipping Options</span>
            </div>
            <div class="shipping-cards" id="shippingContainer">
                <div class="shipping-card" data-value="jne">JNE</div>
                <div class="shipping-card" data-value="jnt">J&T</div>
                <div class="shipping-card" data-value="pos">POS</div>
                <div class="shipping-card" data-value="sicepat">SiCepat</div>
            </div>
        </div>

        <!-- Variations -->
        <div class="form-section">
            <div class="flex justify-between items-center mb-5">
                <div class="section-title" style="border: none; padding: 0; margin: 0;">
                    <i class="fas fa-layer-group"></i>
                    <span>Product Variations</span>
                </div>
                <button type="button" id="addVariationBtn" class="text-xs bg-orange-50 text-[#ee4d2d] hover:bg-orange-100/50 px-2.5 py-1 rounded transition">
                    <i class="fas fa-plus"></i> Add Variation
                </button>
            </div>
            <div id="variationsContainer"></div>
            <div class="variation-info mt-4">
                <i class="fas fa-info-circle"></i> Only <strong>ONE variation</strong> can have images per option. Check "Enable Images" on the variation you want to add product photos.
            </div>
        </div>

        <!-- Status -->
        <div class="form-section">
            <div class="section-title">
                <i class="fas fa-toggle-on"></i>
                <span>Status</span>
            </div>
            <div class="flex gap-6">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="radio" name="status" value="draft" {{ $product->status === 'draft' ? 'checked' : '' }} class="w-4 h-4 text-orange-500"> 
                    <span>Draft</span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="radio" name="status" value="published" {{ $product->status === 'published' ? 'checked' : '' }} class="w-4 h-4 text-orange-500"> 
                    <span>Published</span>
                </label>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex gap-2 justify-end mt-4 pb-4">
            <a href="{{ route('products.show', $product->uuid) }}" class="btn-cancel">Cancel</a>
            <button type="submit" class="btn-save">
                <i class="fas fa-save mr-1.5"></i> Save Changes
            </button>
        </div>
    </form>
</div>

<script>
// ==================== DOM Elements ====================
const form = document.getElementById('editProductForm');
const priceInput = document.getElementById('priceInput');
const dimensionP = document.getElementById('dimensionP');
const dimensionL = document.getElementById('dimensionL');
const dimensionT = document.getElementById('dimensionT');
const dimensionInput = document.getElementById('dimensionInput');
const galleryContainer = document.getElementById('galleryContainer');
const uploadImageBtn = document.getElementById('uploadImageBtn');
const imageUploadInput = document.getElementById('imageUploadInput');
const variationsContainer = document.getElementById('variationsContainer');
const addVariationBtn = document.getElementById('addVariationBtn');
const productNameInput = document.querySelector('input[name="name"]');
const brandInput = document.querySelector('input[name="brand"]');
const projectSelect = document.querySelector('select[name="project_id"]');
const aiGeneratedTitleInput = document.querySelector('input[name="ai_generated_title"]');
const stockInput = document.querySelector('input[name="stock"]');
const weightInput = document.querySelector('input[name="weight"]');

// ==================== Helper Functions ====================
function sanitizeText(text) {
    if (!text) return '';
    return String(text).replace(/[\u0000-\u001F\u007F-\u009F]/g, '').trim();
}

function escapeHtml(text) {
    if (!text) return '';
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

// ==================== Category Autocomplete ====================
let allCategories = [];

async function loadCategories() {
    try {
        const res = await fetch('{{ route("categories.list") }}');
        const data = await res.json();
        if (data.success) allCategories = data.categories;
    } catch(e) { console.error(e); }
}

function getCategoryPath(cat, map) {
    let path = [cat.name];
    let cur = cat;
    while (cur.parent_id && map[cur.parent_id]) {
        cur = map[cur.parent_id];
        path.unshift(cur.name);
    }
    return path.join(' > ');
}

function setupCategoryAutocomplete() {
    const input = document.getElementById('categorySearch');
    const dropdown = document.getElementById('categoryDropdown');
    const hidden = document.getElementById('categoryId');
    if (!input) return;
    
    const initialCategory = {!! json_encode($product->category ? ['id' => $product->category->id, 'name' => $product->category->name] : null) !!};
    if (initialCategory) {
        input.value = initialCategory.name;
        hidden.value = initialCategory.id;
    }
    
    input.addEventListener('input', function() {
        const query = this.value.toLowerCase();
        if (!query.trim()) {
            dropdown.classList.remove('active');
            return;
        }
        const map = {};
        allCategories.forEach(c => map[c.id] = c);
        const filtered = allCategories.filter(c => c.name.toLowerCase().includes(query)).slice(0, 15);
        if (filtered.length) {
            dropdown.innerHTML = filtered.map(c => `
                <div class="autocomplete-item" data-id="${c.id}" data-name="${c.name.replace(/"/g, '&quot;')}">
                    <div class="font-medium">${c.name}</div>
                    <div class="category-path">${getCategoryPath(c, map)}</div>
                </div>
            `).join('');
            dropdown.classList.add('active');
            dropdown.querySelectorAll('.autocomplete-item').forEach(item => {
                item.addEventListener('click', () => {
                    input.value = item.dataset.name;
                    hidden.value = item.dataset.id;
                    dropdown.classList.remove('active');
                });
            });
        } else {
            dropdown.classList.remove('active');
        }
    });
    
    document.addEventListener('click', (e) => {
        if (!input.contains(e.target) && !dropdown.contains(e.target)) {
            dropdown.classList.remove('active');
        }
    });
}

// ==================== Keywords Badge ====================
let keywordsList = [];

function initKeywords() {
    const keywordsHidden = document.getElementById('keywordsHidden');
    const initialKeywords = keywordsHidden.value;
    if (initialKeywords) {
        keywordsList = initialKeywords.split(',').map(k => k.trim()).filter(k => k);
    }
    renderKeywords();
    
    const keywordInput = document.getElementById('keywordInput');
    keywordInput.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' || e.key === ',') {
            e.preventDefault();
            let value = this.value.trim();
            if (value.endsWith(',')) {
                value = value.slice(0, -1).trim();
            }
            if (value && !keywordsList.includes(value)) {
                keywordsList.push(value);
                renderKeywords();
                this.value = '';
            }
        }
    });
    
    keywordInput.addEventListener('blur', function() {
        let value = this.value.trim();
        if (value && !keywordsList.includes(value)) {
            keywordsList.push(value);
            renderKeywords();
            this.value = '';
        }
    });
}

function removeKeyword(keyword) {
    keywordsList = keywordsList.filter(k => k !== keyword);
    renderKeywords();
}

function renderKeywords() {
    const container = document.getElementById('keywordsBadges');
    const hidden = document.getElementById('keywordsHidden');
    container.innerHTML = '';
    keywordsList.forEach(keyword => {
        const badge = document.createElement('span');
        badge.className = 'keyword-badge';
        badge.innerHTML = `${escapeHtml(keyword)} <i class="fas fa-times" onclick="removeKeyword('${escapeHtml(keyword)}')"></i>`;
        container.appendChild(badge);
    });
    hidden.value = keywordsList.join(',');
}

// ==================== Initialize Existing Images ====================
let imageList = [];
let deletedImages = [];

const existingImages = {!! json_encode($images->map(function($img) { return ['id' => $img->id, 'path' => asset($img->path)]; })->values()) !!};
imageList = existingImages;

// ==================== Shipping Options ====================
let selectedShipping = {!! json_encode($product->shipping_options ?? ['jne', 'jnt', 'pos', 'sicepat']) !!};

// ==================== Render Gallery ====================
function renderGallery() {
    galleryContainer.innerHTML = '';
    imageList.forEach((img, idx) => {
        const div = document.createElement('div');
        div.className = 'gallery-item';
        div.innerHTML = `
            <img src="${img.path}" onclick="window.open('${img.path}', '_blank')">
            <span class="remove-img" onclick="removeImage(${idx}, ${img.id || 'null'})"><i class="fas fa-times"></i></span>
        `;
        galleryContainer.appendChild(div);
    });
}

function removeImage(index, imageId) {
    if (imageId) {
        deletedImages.push(imageId);
    }
    imageList.splice(index, 1);
    renderGallery();
}

function addImage(url) {
    imageList.push({ path: url, is_new: true });
    renderGallery();
}

imageUploadInput.addEventListener('change', function(e) {
    const files = Array.from(e.target.files);
    files.forEach(file => {
        if (file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function(ev) {
                addImage(ev.target.result);
            };
            reader.readAsDataURL(file);
        }
    });
    imageUploadInput.value = '';
});

uploadImageBtn.addEventListener('click', function() {
    imageUploadInput.click();
});

// ==================== Shipping Cards Init ====================
function initShippingCards() {
    const cards = document.querySelectorAll('.shipping-card');
    cards.forEach(card => {
        card.addEventListener('click', function() {
            const val = this.dataset.value;
            if (selectedShipping.includes(val)) {
                selectedShipping = selectedShipping.filter(v => v !== val);
                this.classList.remove('selected');
            } else {
                selectedShipping.push(val);
                this.classList.add('selected');
            }
        });
        if (selectedShipping.includes(card.dataset.value)) {
            card.classList.add('selected');
        }
    });
}
initShippingCards();

// ==================== Price Format ====================
function formatPriceInput(input) {
    let val = input.value.replace(/[^0-9]/g, '');
    if (val === '') {
        input.value = '';
        return;
    }
    input.value = new Intl.NumberFormat('id-ID').format(parseInt(val));
}
priceInput.addEventListener('input', function() {
    formatPriceInput(priceInput);
});

// ==================== Dimension ====================
function updateDimension() {
    const p = dimensionP.value || 0;
    const l = dimensionL.value || 0;
    const t = dimensionT.value || 0;
    dimensionInput.value = p + 'x' + l + 'x' + t;
}
dimensionP.addEventListener('input', updateDimension);
dimensionL.addEventListener('input', updateDimension);
dimensionT.addEventListener('input', updateDimension);
updateDimension();

// ==================== Variations ====================
let variationData = [];
let variationCounter = 0;
let activeImageVariationId = null;

function disableOtherImageVariations(exceptIdx) {
    const cards = document.querySelectorAll('.variation-card');
    cards.forEach(card => {
        const cb = card.querySelector('.enable-images-cb');
        const idx = parseInt(card.dataset.idx);
        if (cb && idx !== exceptIdx && cb.checked) {
            cb.checked = false;
            cb.dispatchEvent(new Event('change'));
        }
    });
    activeImageVariationId = exceptIdx;
}

function addVariationField(variation = null) {
    const idx = variationCounter++;
    const hasImageSupport = variation ? variation.hasImage === true : false;
    
    const div = document.createElement('div');
    div.className = 'variation-card';
    div.dataset.idx = idx;
    
    div.innerHTML = `
        <div class="variation-header">
            <input type="text" placeholder="Variation name (e.g., Color, Size)" 
                   class="variation-name input-solid" style="flex:1; max-width: 300px;" value="${variation ? escapeHtml(variation.name) : ''}">
            <div class="enable-images-checkbox">
                <input type="checkbox" class="enable-images-cb" ${hasImageSupport ? 'checked' : ''}>
                <span>Enable Images</span>
            </div>
            <button type="button" class="remove-variation text-red-500 text-xs px-3 py-1.5 rounded-lg hover:bg-red-50 transition">Remove</button>
        </div>
        <div class="variation-options" id="var-options-${idx}"></div>
        <div class="mt-3">
            <input type="text" placeholder="Add new option (e.g., Red, Blue or S, M, L)" 
                   class="variation-new-option input-solid w-full" data-idx="${idx}">
        </div>
        <div class="image-support-info mt-2 text-xs ${hasImageSupport ? 'text-orange-600' : 'text-gray-400'}">
            ${hasImageSupport ? '<i class="fas fa-image"></i> This variation can have images per option' : '<i class="fas fa-info-circle"></i> Only 1 variation can have images per option'}
        </div>
    `;
    
    const optionsContainer = div.querySelector('#var-options-' + idx);
    const enableCb = div.querySelector('.enable-images-cb');
    const infoDiv = div.querySelector('.image-support-info');
    
    let options = [];
    if (variation && variation.options) {
        if (hasImageSupport && Array.isArray(variation.options) && variation.options[0] && variation.options[0].value !== undefined) {
            options = variation.options.map(function(opt) {
                return { value: opt.value, image: opt.image || null };
            });
        } else if (!hasImageSupport && Array.isArray(variation.options)) {
            options = variation.options.map(function(opt) {
                return { value: opt, image: null };
            });
        }
    }
    
    function renderOptions() {
        const hasImage = enableCb.checked;
        optionsContainer.innerHTML = '';
        
        if (options.length === 0) {
            optionsContainer.innerHTML = '<div class="text-xs text-gray-400 italic p-2">No options yet. Add options above.</div>';
            return;
        }
        
        for (let optIdx = 0; optIdx < options.length; optIdx++) {
            const opt = options[optIdx];
            const optDiv = document.createElement('div');
            optDiv.className = 'option-item';
            
            if (hasImage) {
                const imageHtml = opt.image && opt.image !== 'null' && opt.image !== '' 
                    ? `<img src="${opt.image}">` 
                    : '<i class="fas fa-image no-img"></i>';
                optDiv.innerHTML = `
                    <div class="option-image" onclick="window.open('${opt.image || ''}', '_blank')">
                        ${imageHtml}
                    </div>
                    <div class="option-value">${escapeHtml(opt.value)}</div>
                    <button type="button" class="option-upload-btn" data-opt-idx="${optIdx}"><i class="fas fa-camera"></i> Upload</button>
                    <button type="button" class="option-remove-img" data-opt-idx="${optIdx}" ${!opt.image ? 'disabled style="opacity:0.3;"' : ''}><i class="fas fa-trash-alt"></i></button>
                    <input type="file" class="option-file-input hidden" accept="image/jpeg,image/png,image/jpg" data-opt-idx="${optIdx}" style="display:none;">
                `;
                
                const uploadBtn = optDiv.querySelector('.option-upload-btn');
                const fileInput = optDiv.querySelector('.option-file-input');
                const removeBtn = optDiv.querySelector('.option-remove-img');
                
                uploadBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    fileInput.click();
                });
                fileInput.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    if (file && file.type.startsWith('image/')) {
                        const reader = new FileReader();
                        reader.onload = function(ev) {
                            opt.image = ev.target.result;
                            renderOptions();
                            syncVariationData();
                        };
                        reader.readAsDataURL(file);
                    }
                    fileInput.value = '';
                });
                removeBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    opt.image = null;
                    renderOptions();
                    syncVariationData();
                });
            } else {
                optDiv.innerHTML = `
                    <div class="option-value" style="margin-left: 0;">${escapeHtml(opt.value)}</div>
                `;
            }
            optionsContainer.appendChild(optDiv);
        }
    }
    
    renderOptions();
    
    const newOptionInput = div.querySelector('.variation-new-option');
    newOptionInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter' && newOptionInput.value.trim()) {
            const newValue = sanitizeText(newOptionInput.value.trim());
            options.push({ value: newValue, image: null });
            renderOptions();
            newOptionInput.value = '';
            syncVariationData();
        }
    });
    
    enableCb.addEventListener('change', function() {
        const hasImage = enableCb.checked;
        
        if (hasImage) {
            disableOtherImageVariations(idx);
        } else {
            if (activeImageVariationId === idx) {
                activeImageVariationId = null;
            }
        }
        
        document.querySelectorAll('.variation-card .enable-images-cb').forEach(function(cb) {
            const cbIdx = parseInt(cb.closest('.variation-card').dataset.idx);
            if (cb && cbIdx !== idx) {
                cb.disabled = hasImage;
            }
        });
        
        infoDiv.innerHTML = hasImage 
            ? '<i class="fas fa-image"></i> This variation can have images per option' 
            : '<i class="fas fa-info-circle"></i> Only 1 variation can have images per option';
        infoDiv.className = 'image-support-info mt-2 text-xs ' + (hasImage ? 'text-orange-600' : 'text-gray-400');
        
        if (!hasImage) {
            for (var i = 0; i < options.length; i++) {
                options[i].image = null;
            }
        }
        renderOptions();
        syncVariationData();
    });
    
    div.querySelector('.remove-variation').addEventListener('click', function() {
        div.remove();
        variationData = variationData.filter(function(v) {
            return v.idx !== idx;
        });
        syncVariationData();
    });
    
    variationsContainer.appendChild(div);
    
    function syncVariationData() {
        const varName = div.querySelector('.variation-name').value.trim();
        const hasImage = enableCb.checked;
        const opts = hasImage 
            ? options.map(function(opt) {
                return { 
                    value: sanitizeText(opt.value), 
                    image: opt.image || null 
                };
            })
            : options.map(function(opt) {
                return sanitizeText(opt.value);
            });
        
        if (varName && options.length > 0) {
            const existingIndex = variationData.findIndex(function(v) {
                return v.idx === idx;
            });
            if (existingIndex !== -1) {
                variationData[existingIndex] = { 
                    idx: idx, 
                    name: sanitizeText(varName), 
                    options: opts, 
                    hasImage: hasImage 
                };
            } else {
                variationData.push({ 
                    idx: idx, 
                    name: sanitizeText(varName), 
                    options: opts, 
                    hasImage: hasImage 
                });
            }
        } else {
            variationData = variationData.filter(function(v) {
                return v.idx !== idx;
            });
        }
    }
    
    const nameInput = div.querySelector('.variation-name');
    nameInput.addEventListener('input', syncVariationData);
    syncVariationData();
}

// Load existing variations
const existingVariations = {!! json_encode($product->variations ?? []) !!};
if (existingVariations.length > 0) {
    for (let i = 0; i < existingVariations.length; i++) {
        addVariationField(existingVariations[i]);
    }
}

addVariationBtn.addEventListener('click', function() {
    addVariationField();
});

// ==================== SUBMIT FORM (PENTING - Menggunakan FormData) ====================
form.addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const submitBtn = form.querySelector('button[type="submit"]');
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-pulse mr-2"></i> Saving...';
    
    // Gunakan FormData untuk menghindari masalah JSON encoding
    const formData = new FormData();
    
    // Method spoofing untuk PUT
    formData.append('_method', 'PUT');
    formData.append('_token', '{{ csrf_token() }}');
    
    // Basic Information
    formData.append('name', productNameInput?.value || '');
    formData.append('brand', brandInput?.value || '');
    formData.append('category_id', document.getElementById('categoryId')?.value || '');
    formData.append('project_id', projectSelect?.value || '');
    
    // Pricing & Inventory
    formData.append('price', parseInt(priceInput.value.replace(/[^0-9]/g, '')) || 0);
    formData.append('stock', parseInt(stockInput?.value) || 0);
    formData.append('weight', parseFloat(weightInput?.value) || 250);
    formData.append('dimension', dimensionInput.value || '');
    
    // Status
    const selectedStatus = document.querySelector('input[name="status"]:checked');
    formData.append('status', selectedStatus ? selectedStatus.value : 'draft');
    
    // SEO
    formData.append('ai_generated_title', aiGeneratedTitleInput?.value || '');
    
    // Description (plain text - aman)
    const descriptionText = document.getElementById('productDescription')?.value || '';
    formData.append('description', descriptionText);
    
    // Keywords
    formData.append('keywords', keywordsList.join(','));
    
    // Shipping Options (JSON string)
    formData.append('shipping_options', JSON.stringify(selectedShipping));
    
    // Variations (JSON string)
    const cleanVariations = variationData.map(function(v) {
        if (v.hasImage) {
            return {
                name: v.name,
                hasImage: true,
                options: v.options.map(function(opt) {
                    return {
                        value: opt.value,
                        image: opt.image || null
                    };
                })
            };
        } else {
            return {
                name: v.name,
                hasImage: false,
                options: v.options.map(function(opt) {
                    return typeof opt === 'string' ? opt : opt.value;
                })
            };
        }
    });
    formData.append('variations', JSON.stringify(cleanVariations));
    
    // Images
    formData.append('images', JSON.stringify(imageList));
    formData.append('deleted_images', JSON.stringify(deletedImages));
    
    try {
        const response = await fetch('{{ route("products.update", $product->uuid) }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: formData
        });
        
        const result = await response.json();
        
        if (result.success) {
            showToast('✅ Product updated successfully!', 'success', 2000);
            setTimeout(() => {
                window.location.href = '{{ route("products.show", $product->uuid) }}';
            }, 1500);
        } else {
            showToast('❌ Failed to update: ' + (result.message || 'Unknown error'), 'error', 3000);
            console.error('Error response:', result);
        }
    } catch (error) {
        console.error('Update error:', error);
        showToast('Error: ' + error.message, 'error', 3000);
    } finally {
        submitBtn.disabled = false;
        submitBtn.innerHTML = '<i class="fas fa-save mr-2"></i> Save Changes';
    }
});

// ==================== Initialize ====================
loadCategories();
setupCategoryAutocomplete();
initKeywords();
renderGallery();
</script>
@endsection