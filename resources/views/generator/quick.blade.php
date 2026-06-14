@extends('layouts.dashboard')

@section('page-title', 'Quick Generate')
@section('breadcrumb', 'Product Generator / Quick Generate')

@section('content')
<style>
    /* Compact styles matching dashboard */
    .quick-generate-container {
        max-width: 1400px;
        margin: 0 auto;
    }
    
    .form-section {
        background: white;
        border: 1px solid var(--shopee-border, #e2e8f0);
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 20px;
    }
    
    .section-title {
        font-size: 14px;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 16px;
        padding-bottom: 10px;
        border-bottom: 1px solid #eef2f6;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .section-title i {
        color: #ee4d2d;
        font-size: 14px;
    }
    
    .input-solid {
        width: 100%;
        padding: 8px 12px;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        font-size: 13px;
        transition: all 0.2s;
        background: white;
    }
    
    .input-solid:focus {
        outline: none;
        border-color: #ee4d2d;
        box-shadow: 0 0 0 3px rgba(238, 77, 45, 0.1);
    }
    
    .input-solid:disabled {
        background: #f8fafc;
        cursor: not-allowed;
        opacity: 0.6;
    }
    
    textarea.input-solid {
        resize: vertical;
        min-height: 100px;
    }
    
    label {
        display: block;
        font-size: 12px;
        font-weight: 500;
        color: #334155;
        margin-bottom: 6px;
    }
    
    .required {
        color: #ef4444;
        margin-left: 2px;
    }
    
    /* Switch */
    .switch {
        position: relative;
        display: inline-block;
        width: 44px;
        height: 24px;
    }
    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }
    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #cbd5e1;
        transition: 0.3s;
        border-radius: 34px;
    }
    .slider:before {
        position: absolute;
        content: "";
        height: 18px;
        width: 18px;
        left: 3px;
        bottom: 3px;
        background-color: white;
        transition: 0.3s;
        border-radius: 50%;
    }
    input:checked + .slider {
        background-color: #ee4d2d;
    }
    input:checked + .slider:before {
        transform: translateX(20px);
    }
    
    /* Buttons */
    .btn-primary {
        background: #ee4d2d;
        color: white;
        padding: 10px 16px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        width: 100%;
    }
    
    .btn-primary:hover {
        background: #d63e1f;
        transform: translateY(-1px);
    }
    
    .btn-primary:disabled {
        opacity: 0.5;
        cursor: not-allowed;
        transform: none;
    }
    
    .btn-secondary {
        background: #f1f5f9;
        color: #475569;
        padding: 10px 16px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 500;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }
    
    .btn-secondary:hover {
        background: #e2e8f0;
    }
    
    /* Grid */
    .grid-2 {
        display: grid;
        grid-template-columns: 1fr 1.2fr;
        gap: 24px;
    }
    
    /* Sticky preview */
    .sticky-top {
        position: sticky;
        top: 80px;
    }
    
    /* Autocomplete */
    .autocomplete-container {
        position: relative;
    }
    
    .autocomplete-dropdown {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        max-height: 250px;
        overflow-y: auto;
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
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
        font-size: 11px;
        color: #94a3b8;
        margin-top: 2px;
    }
    
    /* Shipping cards */
    .shipping-cards {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-top: 8px;
    }
    
    .shipping-card {
        padding: 6px 14px;
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        cursor: pointer;
        font-size: 12px;
        transition: all 0.2s;
        background: white;
    }
    
    .shipping-card.selected {
        background: #ee4d2d;
        border-color: #ee4d2d;
        color: white;
    }
    
    .shipping-card.disabled {
        opacity: 0.5;
        pointer-events: none;
    }
    
    /* Gallery */
    .gallery-container {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-bottom: 12px;
    }
    
    .gallery-item {
        position: relative;
        width: 70px;
        height: 70px;
        border-radius: 8px;
        overflow: hidden;
        border: 1px solid #e2e8f0;
        background: #f8fafc;
        cursor: pointer;
    }
    
    .gallery-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .gallery-item .remove-img {
        position: absolute;
        top: 2px;
        right: 2px;
        background: rgba(0,0,0,0.6);
        color: white;
        border-radius: 50%;
        width: 18px;
        height: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 9px;
        cursor: pointer;
    }
    
    .upload-btn {
        width: 70px;
        height: 70px;
        border: 2px dashed #cbd5e1;
        border-radius: 8px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 11px;
        color: #64748b;
        background: #f8fafc;
    }
    
    /* Variation card */
    .variation-card {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 14px;
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
    
    .variation-name {
        flex: 1;
        min-width: 150px;
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
        border-radius: 8px;
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
        border-radius: 6px;
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
    
    .enable-images-checkbox {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 11px;
    }
    
    /* Keyword badges */
    .keyword-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #f1f5f9;
        color: #1e293b;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 11px;
    }
    
    .keyword-badge i {
        cursor: pointer;
        color: #94a3b8;
    }
    
    /* Spinner */
    .spinner-small {
        width: 14px;
        height: 14px;
        border: 2px solid #e2e8f0;
        border-top-color: #ee4d2d;
        border-radius: 50%;
        animation: spin 0.6s linear infinite;
        display: inline-block;
    }
    
    @keyframes spin {
        to { transform: rotate(360deg); }
    }
    
    .field-loading {
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    /* Validation */
    .validation-message.error {
        color: #ef4444;
        font-size: 11px;
        margin-top: 4px;
        display: flex;
        align-items: center;
        gap: 4px;
    }
    
    .validation-message.hidden {
        display: none;
    }
    
    /* Dimension group */
    .dimension-group {
        display: flex;
        align-items: center;
        gap: 6px;
    }
    
    .dimension-group input {
        width: 60px;
        text-align: center;
    }
    
    /* Info box */
    .variation-info {
        font-size: 11px;
        color: #64748b;
        margin-top: 10px;
        padding: 8px;
        background: #fff5f2;
        border-radius: 6px;
    }
    
    /* Lightbox */
    .lightbox {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.92);
        z-index: 9999;
        justify-content: center;
        align-items: center;
        cursor: pointer;
    }
    
    .lightbox.active {
        display: flex;
    }
    
    .lightbox img {
        max-width: 90%;
        max-height: 90%;
        object-fit: contain;
    }
    
    /* Editable */
    [contenteditable="true"] {
        background: white;
    }
    
    [contenteditable="true"].disabled {
        background: #f8fafc;
        cursor: not-allowed;
        opacity: 0.6;
    }
    
    /* Action buttons */
    .action-icon {
        color: #94a3b8;
        cursor: pointer;
        transition: color 0.2s;
    }
    
    .action-icon:hover {
        color: #ee4d2d;
    }
    
    .remove-variation {
        background: none;
        border: none;
        color: #ef4444;
        font-size: 11px;
        cursor: pointer;
        padding: 4px 8px;
        border-radius: 4px;
    }
    
    .remove-variation:hover {
        background: #fef2f2;
    }
    
    /* Responsive */
    @media (max-width: 992px) {
        .grid-2 {
            grid-template-columns: 1fr;
            gap: 20px;
        }
        .sticky-top {
            position: static;
        }
    }
</style>

<div class="quick-generate-container">
    <div class="grid-2">
        <!-- INPUT SECTION -->
        <div id="inputSection">
            <div class="form-section">
                <div class="section-title">
                    <i class="fas fa-box"></i>
                    <span>Informasi Produk</span>
                </div>
                <div class="space-y-3">
                    <div>
                        <label>Nama Produk <span class="required">*</span></label>
                        <input type="text" id="productName" class="input-solid w-full" placeholder="Contoh: Samsung A16 8/128GB">
                        <div id="productNameValidation" class="validation-message error hidden"><i class="fas fa-exclamation-circle"></i> Nama produk harus diisi</div>
                    </div>
                    <div>
                        <label>Kategori</label>
                        <div class="autocomplete-container">
                            <input type="text" id="categorySearch" class="input-solid w-full" placeholder="Cari kategori..." autocomplete="off">
                            <div id="categoryDropdown" class="autocomplete-dropdown"></div>
                        </div>
                        <input type="hidden" id="categoryId">
                    </div>
                    <div>
                        <label>Informasi Tambahan</label>
                        <textarea id="additionalInfo" rows="3" class="input-solid w-full" placeholder="Jelaskan produk secara detail..."></textarea>
                    </div>
                    <!-- <div>
                        <label>Project</label>
                        <select id="projectId" class="input-solid w-full">
                            <option value="">Tanpa Project</option>
                            @foreach($projects as $project)
                                <option value="{{ $project->id }}">{{ $project->name }}</option>
                            @endforeach
                        </select>
                    </div> -->
                </div>
            </div>

            @php
                $aiImageVisible = true;
                try {
                    $aiImageVisible = \App\Models\MenuVisibility::where('menu_key', 'ai_image_generate')->first()->is_visible ?? true;
                } catch (\Exception $e) {}
            @endphp
            @if($aiImageVisible)
            <div class="form-section">
                <div class="section-title">
                    <i class="fas fa-palette"></i>
                    <span>Generate Gambar AI</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm font-medium">Generate gambar produk dengan AI</span>
                    <label class="switch">
                        <input type="checkbox" id="genImageSwitch">
                        <span class="slider"></span>
                    </label>
                </div>
                <div id="imageOptions" class="mt-3 space-y-2" style="display: none;">
                    <textarea id="imagePrompt" rows="2" class="input-solid w-full" placeholder="Deskripsi gambar yang diinginkan..."></textarea>
                    <select id="imageCount" class="input-solid w-24">
                        <option value="1">1 Gambar</option>
                        <option value="2">2 Gambar</option>
                        <option value="3">3 Gambar</option>
                    </select>
                </div>
            </div>
            @endif

            <button id="generateBtn" class="btn-primary py-2">
                <i class="fas fa-magic"></i> Generate Produk
            </button>
        </div>

        <!-- PREVIEW SECTION -->
        <div class="sticky-top" id="previewSection">
            <div class="form-section">
                <div class="section-title">
                    <i class="fas fa-eye"></i>
                    <span>Preview Hasil</span>
                </div>

                <!-- Gallery -->
                <div class="mb-4">
                    <label>Galeri Gambar</label>
                    <div id="galleryContainer" class="gallery-container"></div>
                    <div class="upload-btn" id="uploadImageBtn">
                        <i class="fas fa-plus"></i>
                        <span class="text-[10px]">Upload</span>
                    </div>
                    <input type="file" id="imageUploadInput" accept="image/jpeg,image/png,image/jpg" multiple style="display: none;">
                </div>

                <!-- Title -->
                <div class="mb-4">
                    <div class="flex justify-between items-center mb-1">
                        <div class="field-loading">
                            <label>Judul Produk (SEO)</label>
                            <span id="titleSpinner" class="spinner-small" style="display: none;"></span>
                        </div>
                        <div class="flex gap-2">
                            <i class="fas fa-copy action-icon" id="copyTitleBtn" style="font-size: 12px;"></i>
                            <i class="fas fa-sync-alt action-icon" id="refreshTitleBtn" style="font-size: 12px;"></i>
                        </div>
                    </div>
                    <div id="editableTitle" class="input-solid min-h-[50px]" contenteditable="true">-</div>
                </div>

                <!-- Description -->
                <div class="mb-4">
                    <div class="flex justify-between items-center mb-1">
                        <div class="field-loading">
                            <label>Deskripsi Produk</label>
                            <span id="descSpinner" class="spinner-small" style="display: none;"></span>
                        </div>
                        <div class="flex gap-2">
                            <i class="fas fa-copy action-icon" id="copyDescBtn" style="font-size: 12px;"></i>
                            <i class="fas fa-sync-alt action-icon" id="refreshDescBtn" style="font-size: 12px;"></i>
                        </div>
                    </div>
                    <div id="editableDescription" class="input-solid min-h-[150px]" contenteditable="true">-</div>
                </div>

                <!-- Category & Brand -->
                <div class="grid grid-cols-2 gap-3 mb-4">
                    <div>
                        <label>Kategori</label>
                        <div class="autocomplete-container">
                            <input type="text" id="previewCategorySearch" class="input-solid w-full" placeholder="Kategori produk" autocomplete="off">
                            <div id="previewCategoryDropdown" class="autocomplete-dropdown"></div>
                        </div>
                        <input type="hidden" id="previewCategoryId">
                    </div>
                    <div>
                        <div class="field-loading">
                            <label>Merek / Brand</label>
                            <span id="brandSpinner" class="spinner-small" style="display: none;"></span>
                        </div>
                        <input type="text" id="brandInput" class="input-solid w-full" placeholder="Merek produk">
                    </div>
                </div>

                <!-- Price & Stock -->
                <div class="grid grid-cols-2 gap-3 mb-4">
                    <div>
                        <div class="field-loading">
                            <label>Harga (Rp)</label>
                            <span id="priceSpinner" class="spinner-small" style="display: none;"></span>
                        </div>
                        <input type="text" id="priceInput" class="input-solid w-full" placeholder="0" value="0">
                    </div>
                    <div>
                        <label>Stok</label>
                        <input type="number" id="stockInput" class="input-solid w-full" value="10">
                    </div>
                </div>

                <!-- Weight & Dimension -->
                <div class="grid grid-cols-2 gap-3 mb-4">
                    <div>
                        <div class="field-loading">
                            <label>Berat (gram)</label>
                            <span id="weightSpinner" class="spinner-small" style="display: none;"></span>
                        </div>
                        <input type="number" id="weightInput" class="input-solid w-full" step="any" value="250">
                    </div>
                    <div>
                        <div class="field-loading">
                            <label>Dimensi (P x L x T) cm</label>
                            <span id="dimensionSpinner" class="spinner-small" style="display: none;"></span>
                        </div>
                        <div class="dimension-group">
                            <input type="number" id="dimensionP" class="input-solid" placeholder="P" value="30">
                            <span class="text-gray-400">x</span>
                            <input type="number" id="dimensionL" class="input-solid" placeholder="L" value="20">
                            <span class="text-gray-400">x</span>
                            <input type="number" id="dimensionT" class="input-solid" placeholder="T" value="5">
                        </div>
                        <input type="hidden" id="dimensionInput">
                    </div>
                </div>

                <!-- Shipping -->
                <div class="mb-4">
                    <label>Jasa Kirim</label>
                    <div class="shipping-cards" id="shippingContainer">
                        <div class="shipping-card" data-value="jne">JNE</div>
                        <div class="shipping-card" data-value="jnt">J&T</div>
                        <div class="shipping-card" data-value="pos">POS</div>
                        <div class="shipping-card" data-value="sicepat">SiCepat</div>
                    </div>
                </div>

                <!-- Variations -->
                <div class="mb-4">
                    <div class="flex justify-between items-center mb-2">
                        <div class="field-loading">
                            <label>Variasi Produk</label>
                            <span id="variationSpinner" class="spinner-small" style="display: none;"></span>
                        </div>
                        <button type="button" id="addVariationBtn" class="text-xs text-orange-600 hover:underline">
                            <i class="fas fa-plus"></i> Tambah Variasi
                        </button>
                    </div>
                    <div id="variationsContainer"></div>
                    <div class="variation-info">
                        <i class="fas fa-info-circle"></i> Hanya <strong>SATU variasi</strong> yang dapat memiliki gambar per opsi
                    </div>
                </div>

                <!-- Keywords -->
                <div class="mb-4">
                    <div class="field-loading">
                        <label>Keywords SEO</label>
                        <span id="keywordsSpinner" class="spinner-small" style="display: none;"></span>
                    </div>
                    <div id="previewKeywords" class="flex flex-wrap gap-2 mt-1"></div>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-3 mt-5">
                    <button id="saveBtn" class="flex-1 btn-primary py-2" disabled>
                        <i class="fas fa-save"></i> Simpan Produk
                    </button>
                    <button id="clearBtn" class="flex-1 btn-secondary py-2">
                        <i class="fas fa-trash-alt"></i> Bersihkan
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Lightbox Modal -->
<div id="lightboxModal" class="lightbox" onclick="closeLightbox()">
    <img id="lightboxImage" src="" alt="Preview">
</div>

<script>
// ==================== DOM Elements ====================
const generateBtn = document.getElementById('generateBtn');
const productNameInput = document.getElementById('productName');
const additionalInfo = document.getElementById('additionalInfo');
const projectSelect = document.getElementById('projectId');
const genImageSwitch = document.getElementById('genImageSwitch');
const imageOptions = document.getElementById('imageOptions');
const imagePrompt = document.getElementById('imagePrompt');
const imageCount = document.getElementById('imageCount');
const saveBtn = document.getElementById('saveBtn');
const clearBtn = document.getElementById('clearBtn');
const editableTitle = document.getElementById('editableTitle');
const editableDescription = document.getElementById('editableDescription');
const previewKeywords = document.getElementById('previewKeywords');
const priceInput = document.getElementById('priceInput');
const stockInput = document.getElementById('stockInput');
const weightInput = document.getElementById('weightInput');
const dimensionP = document.getElementById('dimensionP');
const dimensionL = document.getElementById('dimensionL');
const dimensionT = document.getElementById('dimensionT');
const dimensionInput = document.getElementById('dimensionInput');
const brandInput = document.getElementById('brandInput');
const variationsContainer = document.getElementById('variationsContainer');
const addVariationBtn = document.getElementById('addVariationBtn');
const copyTitleBtn = document.getElementById('copyTitleBtn');
const copyDescBtn = document.getElementById('copyDescBtn');
const refreshTitleBtn = document.getElementById('refreshTitleBtn');
const refreshDescBtn = document.getElementById('refreshDescBtn');
const productNameValidation = document.getElementById('productNameValidation');
const galleryContainer = document.getElementById('galleryContainer');
const uploadImageBtn = document.getElementById('uploadImageBtn');
const imageUploadInput = document.getElementById('imageUploadInput');

// Spinners
const titleSpinner = document.getElementById('titleSpinner');
const descSpinner = document.getElementById('descSpinner');
const brandSpinner = document.getElementById('brandSpinner');
const priceSpinner = document.getElementById('priceSpinner');
const dimensionSpinner = document.getElementById('dimensionSpinner');
const variationSpinner = document.getElementById('variationSpinner');
const weightSpinner = document.getElementById('weightSpinner');
const keywordsSpinner = document.getElementById('keywordsSpinner');

// State
let currentGeneratedData = {
    title: '', description: '', keywords: '', price: 0, stock: 10, weight: 250, dimension: '',
    categoryId: null, brand: '', shippingOptions: ['jne','jnt','pos','sicepat'], variations: [], images: []
};
let isGenerating = false;
let allCategories = [];
let variationCounter = 0;
let variationData = [];
let activeImageVariationId = null;
let imageList = [];

// ==================== Helper Functions ====================
function escapeHtml(text) {
    if (!text) return '';
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

function sanitizeText(text) {
    if (!text) return '';
    return text.replace(/[\u0000-\u001F\u007F-\u009F]/g, '').trim();
}

function showToast(message, type, duration = 2000) {
    const toast = document.createElement('div');
    toast.style.cssText = `
        position: fixed;
        bottom: 20px;
        right: 20px;
        background: ${type === 'success' ? '#10b981' : '#ef4444'};
        color: white;
        padding: 10px 16px;
        border-radius: 8px;
        font-size: 12px;
        z-index: 9999;
        animation: slideIn 0.3s ease;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    `;
    toast.textContent = message;
    document.body.appendChild(toast);
    setTimeout(() => toast.remove(), duration);
}

// ==================== Disable Inputs ====================
function disableAllInputs(disabled) {
    document.querySelectorAll('#inputSection input, #inputSection textarea, #inputSection select, #previewSection input, #previewSection textarea, #previewSection select').forEach(el => {
        if (disabled && el.id !== 'saveBtn' && el.id !== 'clearBtn') {
            el.disabled = disabled;
        } else if (!disabled) {
            el.disabled = false;
        }
    });
    
    [editableTitle, editableDescription].forEach(div => {
        if (disabled) {
            div.setAttribute('contenteditable', 'false');
            div.classList.add('disabled');
        } else {
            div.setAttribute('contenteditable', 'true');
            div.classList.remove('disabled');
        }
    });
    
    document.querySelectorAll('.shipping-card').forEach(c => {
        if (disabled) c.classList.add('disabled');
        else c.classList.remove('disabled');
    });
    
    generateBtn.disabled = disabled;
    saveBtn.disabled = disabled || !productNameInput.value;
    clearBtn.disabled = disabled;
    if (disabled) uploadImageBtn.classList.add('disabled');
    else uploadImageBtn.classList.remove('disabled');
}

// ==================== Gallery ====================
function renderGallery() {
    galleryContainer.innerHTML = '';
    imageList.forEach((url, idx) => {
        const div = document.createElement('div');
        div.className = 'gallery-item';
        div.innerHTML = `
            <img src="${url}" onclick="openLightbox('${url}')">
            <span class="remove-img" onclick="removeImage(${idx})"><i class="fas fa-times"></i></span>
        `;
        galleryContainer.appendChild(div);
    });
    currentGeneratedData.images = [...imageList];
}

function removeImage(index) { 
    if (!isGenerating) { 
        imageList.splice(index, 1); 
        renderGallery(); 
    } 
}

function addImage(url) { 
    imageList.push(url); 
    renderGallery(); 
}

imageUploadInput.addEventListener('change', function(e) {
    if (isGenerating) return;
    Array.from(e.target.files).forEach(file => {
        if (file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = ev => addImage(ev.target.result);
            reader.readAsDataURL(file);
        }
    });
    imageUploadInput.value = '';
});

uploadImageBtn.addEventListener('click', () => { 
    if (!isGenerating) imageUploadInput.click(); 
});

function openLightbox(src) {
    document.getElementById('lightboxImage').src = src;
    document.getElementById('lightboxModal').classList.add('active');
}
function closeLightbox() { 
    document.getElementById('lightboxModal').classList.remove('active'); 
}
window.openLightbox = openLightbox;
window.removeImage = removeImage;
window.closeLightbox = closeLightbox;

// ==================== Shipping ====================
let selectedShipping = ['jne', 'jnt', 'pos', 'sicepat'];

function initShippingCards() {
    document.querySelectorAll('.shipping-card').forEach(card => {
        card.addEventListener('click', () => {
            if (isGenerating) return;
            const val = card.dataset.value;
            if (selectedShipping.includes(val)) {
                selectedShipping = selectedShipping.filter(v => v !== val);
                card.classList.remove('selected');
            } else {
                selectedShipping.push(val);
                card.classList.add('selected');
            }
        });
        if (selectedShipping.includes(card.dataset.value)) {
            card.classList.add('selected');
        }
    });
}
initShippingCards();
function getSelectedShipping() { return selectedShipping; }

// ==================== Validation ====================
function validateProductName() {
    const isValid = productNameInput.value.trim() !== '';
    productNameValidation.classList.toggle('hidden', isValid);
    return isValid;
}
productNameInput.addEventListener('input', validateProductName);
productNameInput.addEventListener('blur', validateProductName);

// ==================== Dimension ====================
function updateDimension() {
    dimensionInput.value = `${dimensionP.value || 0}x${dimensionL.value || 0}x${dimensionT.value || 0}`;
}
[dimensionP, dimensionL, dimensionT].forEach(inp => inp.addEventListener('input', updateDimension));
updateDimension();

// ==================== Price Format ====================
function formatPriceInput(input) {
    let val = input.value.replace(/[^0-9]/g, '');
    if (val === '') { 
        input.value = ''; 
        currentGeneratedData.price = 0; 
        return; 
    }
    let num = parseInt(val);
    currentGeneratedData.price = num;
    input.value = num.toLocaleString('id-ID');
}
priceInput.addEventListener('input', () => formatPriceInput(priceInput));

// ==================== Image Switch ====================
genImageSwitch.addEventListener('change', function() {
    imageOptions.style.display = this.checked ? 'block' : 'none';
});

// ==================== Category Autocomplete ====================
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

function setupCategoryAutocomplete(inputId, dropdownId, hiddenId, isPreview = false) {
    const input = document.getElementById(inputId);
    const dropdown = document.getElementById(dropdownId);
    const hidden = document.getElementById(hiddenId);
    if (!input) return;
    
    input.addEventListener('input', function() {
        if (isGenerating) return;
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
                    <div class="font-medium text-sm">${c.name}</div>
                    <div class="category-path">${getCategoryPath(c, map)}</div>
                </div>
            `).join('');
            dropdown.classList.add('active');
            dropdown.querySelectorAll('.autocomplete-item').forEach(item => {
                item.addEventListener('click', () => {
                    if (isGenerating) return;
                    input.value = item.dataset.name;
                    hidden.value = item.dataset.id;
                    if (!isPreview) currentGeneratedData.categoryId = parseInt(item.dataset.id);
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

// ==================== Variations ====================
function disableOtherImageVariations(exceptIdx) {
    document.querySelectorAll('.variation-card').forEach(card => {
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
            <input type="text" placeholder="Nama variasi (contoh: Warna, Ukuran)" 
                   class="variation-name input-solid" value="${variation ? escapeHtml(variation.name) : ''}">
            <div class="enable-images-checkbox">
                <input type="checkbox" class="enable-images-cb" ${hasImageSupport ? 'checked' : ''}>
                <span>Gambar</span>
            </div>
            <button type="button" class="remove-variation"><i class="fas fa-trash-alt"></i></button>
        </div>
        <div class="variation-options" id="var-options-${idx}"></div>
        <div class="mt-2">
            <input type="text" placeholder="Tambah opsi baru (contoh: Hijau, Biru atau S, M, L)" 
                   class="variation-new-option input-solid w-full text-sm" data-idx="${idx}">
        </div>
        <div class="image-support-info mt-2 text-xs ${hasImageSupport ? 'text-orange-600' : 'text-gray-400'}">
            ${hasImageSupport ? '<i class="fas fa-image"></i> Variasi ini dapat memiliki gambar per opsi' : '<i class="fas fa-info-circle"></i> Hanya 1 variasi yang dapat memiliki gambar per opsi'}
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
            optionsContainer.innerHTML = '<div class="text-xs text-gray-400 italic p-2">Belum ada opsi. Tambah opsi di atas.</div>';
            return;
        }
        
        for (let optIdx = 0; optIdx < options.length; optIdx++) {
            const opt = options[optIdx];
            const optDiv = document.createElement('div');
            optDiv.className = 'option-item';
            
            if (hasImage) {
                const imageHtml = opt.image && opt.image !== 'null' && opt.image !== '' 
                    ? `<img src="${opt.image}">` 
                    : '<i class="fas fa-image no-img" style="font-size: 20px; color: #cbd5e1;"></i>';
                optDiv.innerHTML = `
                    <div class="option-image" onclick="openLightbox('${opt.image || ''}')">
                        ${imageHtml}
                    </div>
                    <div class="option-value">${escapeHtml(opt.value)}</div>
                    <button type="button" class="option-upload-btn text-xs px-2 py-1 rounded border border-gray-300 hover:bg-gray-50" data-opt-idx="${optIdx}"><i class="fas fa-camera"></i></button>
                    <button type="button" class="option-remove-img text-xs text-red-500" data-opt-idx="${optIdx}" ${!opt.image ? 'disabled style="opacity:0.3;"' : ''}><i class="fas fa-trash-alt"></i></button>
                    <input type="file" class="option-file-input hidden" accept="image/jpeg,image/png,image/jpg" data-opt-idx="${optIdx}" style="display:none;">
                `;
                
                const uploadBtn = optDiv.querySelector('.option-upload-btn');
                const fileInput = optDiv.querySelector('.option-file-input');
                const removeBtn = optDiv.querySelector('.option-remove-img');
                
                uploadBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    if (isGenerating) return;
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
                    if (isGenerating) return;
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
        if (e.key === 'Enter' && newOptionInput.value.trim() && !isGenerating) {
            options.push({ value: newOptionInput.value.trim(), image: null });
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
            ? '<i class="fas fa-image"></i> Variasi ini dapat memiliki gambar per opsi' 
            : '<i class="fas fa-info-circle"></i> Hanya 1 variasi yang dapat memiliki gambar per opsi';
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
        if (!isGenerating) {
            div.remove();
            variationData = variationData.filter(function(v) {
                return v.idx !== idx;
            });
            syncVariationData();
        }
    });
    
    variationsContainer.appendChild(div);
    
    function syncVariationData() {
        const varName = div.querySelector('.variation-name').value.trim();
        const hasImage = enableCb.checked;
        const opts = hasImage 
            ? options.map(function(opt) {
                return { value: opt.value, image: opt.image };
            })
            : options.map(function(opt) {
                return opt.value;
            });
        
        if (varName && options.length > 0) {
            const existingIndex = variationData.findIndex(function(v) {
                return v.idx === idx;
            });
            if (existingIndex !== -1) {
                variationData[existingIndex] = { idx: idx, name: varName, options: opts, hasImage: hasImage };
            } else {
                variationData.push({ idx: idx, name: varName, options: opts, hasImage: hasImage });
            }
        } else {
            variationData = variationData.filter(function(v) {
                return v.idx !== idx;
            });
        }
        currentGeneratedData.variations = variationData.map(function(v) {
            return {
                name: v.name,
                hasImage: v.hasImage,
                options: v.options
            };
        });
    }
    
    const nameInput = div.querySelector('.variation-name');
    nameInput.addEventListener('input', syncVariationData);
    syncVariationData();
}

addVariationBtn.addEventListener('click', function() { 
    if (!isGenerating) addVariationField(); 
});

function getVariationsFromUI() {
    return currentGeneratedData.variations;
}

// ==================== Update Preview ====================
function updatePreview() {
    if (currentGeneratedData.price > 0) priceInput.value = currentGeneratedData.price.toLocaleString('id-ID');
    if (currentGeneratedData.stock) stockInput.value = currentGeneratedData.stock;
    if (currentGeneratedData.weight) weightInput.value = currentGeneratedData.weight;
    if (currentGeneratedData.brand) brandInput.value = currentGeneratedData.brand;
    if (currentGeneratedData.title) editableTitle.innerText = currentGeneratedData.title;
    
    if (currentGeneratedData.categoryId && allCategories.length) {
        const cat = allCategories.find(c => c.id === currentGeneratedData.categoryId);
        if (cat) {
            document.getElementById('previewCategorySearch').value = cat.name;
            document.getElementById('previewCategoryId').value = cat.id;
        }
    }
    
    if (currentGeneratedData.dimension) {
        const parts = currentGeneratedData.dimension.split('x');
        if (parts.length === 3) {
            dimensionP.value = parts[0];
            dimensionL.value = parts[1];
            dimensionT.value = parts[2];
            updateDimension();
        }
    }
    
    if (currentGeneratedData.description) {
        editableDescription.innerHTML = currentGeneratedData.description.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>').replace(/\n/g, '<br>');
    }
    
    if (currentGeneratedData.keywords) {
        let kwList = currentGeneratedData.keywords.split(',').map(k => k.trim()).filter(k => k);
        previewKeywords.innerHTML = kwList.map(k => `<span class="keyword-badge">${escapeHtml(k)} <i class="fas fa-copy" onclick="copyKeyword('${escapeHtml(k)}')"></i></span>`).join('');
    } else {
        previewKeywords.innerHTML = '<span class="text-gray-400 text-xs">-</span>';
    }
    
    if (currentGeneratedData.variations?.length && variationsContainer.children.length === 0) {
        variationCounter = 0;
        variationData = [];
        activeImageVariationId = null;
        currentGeneratedData.variations.forEach(function(v) {
            addVariationField(v);
        });
    }
    
    if (imageList.length === 0 && currentGeneratedData.images?.length) {
        imageList = [...currentGeneratedData.images];
        renderGallery();
    } else {
        renderGallery();
    }
    
    saveBtn.disabled = !productNameInput.value || isGenerating;
}

window.copyKeyword = function(kw) { 
    if (isGenerating) return;
    navigator.clipboard.writeText(kw); 
    showToast('Keyword "' + kw + '" copied!', 'success', 1500);
};

// ==================== Copy & Refresh ====================
copyTitleBtn.addEventListener('click', function() { 
    if (!isGenerating) navigator.clipboard.writeText(editableTitle.innerText); 
    showToast('Title copied!', 'success', 1500);
});

copyDescBtn.addEventListener('click', function() { 
    if (!isGenerating) navigator.clipboard.writeText(editableDescription.innerText); 
    showToast('Description copied!', 'success', 1500);
});

refreshTitleBtn.addEventListener('click', async function() {
    if (isGenerating || !validateProductName()) return;
    titleSpinner.style.display = 'inline-block';
    try {
        const res = await fetch('{{ route("generator.generate-complete") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                name: productNameInput.value,
                additional_prompt: additionalInfo.value,
                generate_image: false
            })
        });
        const data = await res.json();
        if (data.success && data.data) {
            const d = data.data;
            editableTitle.innerText = d.ai_title || productNameInput.value;
            currentGeneratedData.title = d.ai_title || productNameInput.value;
            if (d.recommended_brand) currentGeneratedData.brand = d.recommended_brand;
            if (d.recommended_weight) currentGeneratedData.weight = d.recommended_weight;
            if (d.recommended_dimension) currentGeneratedData.dimension = d.recommended_dimension;
            if (d.recommended_variations) currentGeneratedData.variations = d.recommended_variations;
            if (d.recommended_category_id) currentGeneratedData.categoryId = d.recommended_category_id;
            updatePreview();
        }
    } catch(e) { 
        console.error(e); 
        showToast('Error: ' + e.message, 'error', 3000);
    } finally {
        titleSpinner.style.display = 'none';
    }
});

refreshDescBtn.addEventListener('click', async function() {
    if (isGenerating || !validateProductName()) return;
    descSpinner.style.display = 'inline-block';
    try {
        const res = await fetch('{{ route("generator.generate-complete") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                name: productNameInput.value,
                additional_prompt: additionalInfo.value,
                generate_image: false
            })
        });
        const data = await res.json();
        if (data.success && data.data) {
            const d = data.data;
            editableDescription.innerHTML = (d.ai_description || '').replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>').replace(/\n/g, '<br>');
            currentGeneratedData.description = d.ai_description || '';
            if (d.recommended_brand) currentGeneratedData.brand = d.recommended_brand;
            if (d.recommended_weight) currentGeneratedData.weight = d.recommended_weight;
            if (d.recommended_dimension) currentGeneratedData.dimension = d.recommended_dimension;
            if (d.recommended_variations) currentGeneratedData.variations = d.recommended_variations;
            if (d.recommended_category_id) currentGeneratedData.categoryId = d.recommended_category_id;
            updatePreview();
        }
    } catch(e) { 
        console.error(e); 
        showToast('Error: ' + e.message, 'error', 3000);
    } finally {
        descSpinner.style.display = 'none';
    }
});

// ==================== Generate ====================
generateBtn.addEventListener('click', async function() {
    if (!validateProductName() || isGenerating) return;
    isGenerating = true;
    
    disableAllInputs(true);
    
    generateBtn.innerHTML = '<i class="fas fa-spinner fa-pulse"></i> Memproses...';
    [titleSpinner, descSpinner, brandSpinner, priceSpinner, dimensionSpinner, variationSpinner, weightSpinner, keywordsSpinner].forEach(s => s.style.display = 'inline-block');
    
    currentGeneratedData = {
        title: '', description: '', keywords: '', price: 0, stock: 10, weight: 250, dimension: dimensionInput.value,
        categoryId: null, brand: '', shippingOptions: getSelectedShipping(), variations: [], images: []
    };
    
    try {
        if (genImageSwitch.checked) {
            const prompt = imagePrompt.value || `${productNameInput.value} product photography, studio lighting, white background`;
            const count = parseInt(imageCount.value);
            const imgRes = await fetch('{{ route("generator.generate-image") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ prompt, count })
            });
            const imgData = await imgRes.json();
            if (imgData.success && imgData.images) {
                imgData.images.forEach(img => {
                    if (!imageList.includes(img)) imageList.push(img);
                });
                renderGallery();
            }
        }
        
        const textRes = await fetch('{{ route("generator.generate-complete") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                name: productNameInput.value,
                additional_prompt: additionalInfo.value,
                generate_image: false
            })
        });
        const textData = await textRes.json();
        
        if (textData.success && textData.data) {
            const d = textData.data;
            currentGeneratedData.title = d.ai_title || productNameInput.value;
            currentGeneratedData.description = d.ai_description || '';
            currentGeneratedData.keywords = d.keywords || '';
            currentGeneratedData.price = d.recommended_price || 0;
            if (d.recommended_category_id) currentGeneratedData.categoryId = d.recommended_category_id;
            if (d.recommended_brand) currentGeneratedData.brand = d.recommended_brand;
            if (d.recommended_weight) currentGeneratedData.weight = d.recommended_weight;
            if (d.recommended_dimension) currentGeneratedData.dimension = d.recommended_dimension;
            if (d.recommended_variations) {
                currentGeneratedData.variations = d.recommended_variations;
            }
            updatePreview();
        }
    } catch(e) { 
        console.error(e); 
        showToast('Error: ' + e.message, 'error', 3000);
    } finally {
        isGenerating = false;
        disableAllInputs(false);
        generateBtn.innerHTML = '<i class="fas fa-magic"></i> Generate Produk';
        [titleSpinner, descSpinner, brandSpinner, priceSpinner, dimensionSpinner, variationSpinner, weightSpinner, keywordsSpinner].forEach(s => s.style.display = 'none');
        saveBtn.disabled = !productNameInput.value;
    }
});

// ==================== Save ====================
saveBtn.addEventListener('click', async function() {
    if (isGenerating || !validateProductName()) return;
    
    // Validasi gambar variasi
    let hasImageVariation = false;
    let missingImages = [];
    
    for (const variation of variationData) {
        if (variation.hasImage && variation.options && variation.options.length > 0) {
            hasImageVariation = true;
            for (let i = 0; i < variation.options.length; i++) {
                const opt = variation.options[i];
                if (!opt.image || opt.image === null || opt.image === '') {
                    missingImages.push(`${variation.name}: ${opt.value}`);
                }
            }
        }
    }
    
    if (hasImageVariation && missingImages.length > 0) {
        showToast('Gambar wajib diupload untuk semua opsi variasi yang aktif!', 'error', 3000);
        return;
    }
    
    this.disabled = true;
    this.innerHTML = '<i class="fas fa-spinner fa-pulse"></i> Menyimpan...';
    
    const variations = getVariationsFromUI();
    const descriptionText = sanitizeText(editableDescription.innerHTML);
    const titleText = sanitizeText(editableTitle.innerText);
    
    const imagesToSend = imageList.filter(img => img && img.length > 0);
    
    const cleanedVariations = variations.map(function(variation) {
        if (variation.hasImage && Array.isArray(variation.options)) {
            return {
                name: variation.name,
                hasImage: true,
                options: variation.options.map(function(opt) {
                    return {
                        value: opt.value,
                        image: opt.image || null
                    };
                })
            };
        } else {
            return {
                name: variation.name,
                hasImage: false,
                options: variation.options
            };
        }
    });
    
    const payload = {
        name: sanitizeText(productNameInput.value),
        ai_title: titleText,
        description: descriptionText,
        keywords: currentGeneratedData.keywords || '',
        category_id: document.getElementById('previewCategoryId').value || null,
        brand: sanitizeText(brandInput.value),
        price: parseInt(priceInput.value.replace(/[^0-9]/g, '')) || 0,
        stock: parseInt(stockInput.value) || 0,
        weight: parseFloat(weightInput.value) || 250,
        dimension: dimensionInput.value || '',
        shipping_options: getSelectedShipping(),
        variations: cleanedVariations,
        project_id: (projectSelect ? projectSelect.value : null) || null,
        images: imagesToSend
    };
    
    try {
        console.log('Saving product...', payload);
        const controller = new AbortController();
        const timeoutId = setTimeout(() => controller.abort(), 30000);
        
        const res = await fetch('{{ route("generator.save") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(payload),
            signal: controller.signal
        });
        
        clearTimeout(timeoutId);
        console.log('Save response status:', res.status);
        
        const text = await res.text();
        console.log('Save response text:', text.substring(0, 500));
        
        let data;
        try { data = JSON.parse(text); } catch(parseErr) {
            console.error('JSON parse error:', parseErr);
            alert('Server mengembalikan respons tidak valid. Status: ' + res.status);
            return;
        }
        
        if (data.success) { 
            if (typeof showToast === 'function') showToast('Produk berhasil disimpan!', 'success', 1500);
            else alert('Produk berhasil disimpan!');
            setTimeout(() => {
                if (data.product && data.product.uuid) {
                    window.location.href = '/products/' + data.product.uuid;
                } else {
                    window.location.href = '{{ route("generator.quick") }}';
                }
            }, 1500);
        } else {
            var msg = 'Gagal menyimpan: ' + (data.message || 'Unknown error');
            if (typeof showToast === 'function') showToast(msg, 'error', 3000);
            else alert(msg);
            console.error('Error response:', data);
        }
    } catch(e) { 
        console.error('Save error:', e);
        var errMsg = 'Error: ' + e.message;
        if (e.name === 'AbortError') errMsg = 'Request timeout - server terlalu lama merespon';
        if (typeof showToast === 'function') showToast(errMsg, 'error', 3000);
        else alert(errMsg);
    } finally { 
        this.disabled = false; 
        this.innerHTML = '<i class="fas fa-save"></i> Simpan Produk'; 
    }
});

// ==================== Clear ====================
clearBtn.addEventListener('click', function() {
    if (isGenerating) return;
    if (confirm('Bersihkan semua data?')) {
        productNameInput.value = '';
        additionalInfo.value = '';
        imagePrompt.value = '';
        genImageSwitch.checked = false;
        imageOptions.style.display = 'none';
        variationsContainer.innerHTML = '';
        variationCounter = 0;
        variationData = [];
        activeImageVariationId = null;
        editableTitle.innerText = '-';
        editableDescription.innerText = '-';
        previewKeywords.innerHTML = '';
        brandInput.value = '';
        priceInput.value = '';
        stockInput.value = '10';
        weightInput.value = '250';
        dimensionP.value = '30';
        dimensionL.value = '20';
        dimensionT.value = '5';
        updateDimension();
        document.getElementById('previewCategorySearch').value = '';
        document.getElementById('previewCategoryId').value = '';
        document.getElementById('categorySearch').value = '';
        document.getElementById('categoryId').value = '';
        productNameValidation.classList.add('hidden');
        selectedShipping = ['jne', 'jnt', 'pos', 'sicepat'];
        document.querySelectorAll('.shipping-card').forEach(function(c) { return c.classList.remove('selected'); });
        initShippingCards();
        imageList = [];
        renderGallery();
        currentGeneratedData = { 
            title: '', description: '', keywords: '', price: 0, stock: 10, weight: 250, dimension: '', 
            categoryId: null, brand: '', shippingOptions: ['jne', 'jnt', 'pos', 'sicepat'], variations: [], images: [] 
        };
        updatePreview();
        saveBtn.disabled = true;
    }
});

// ==================== Initialize ====================
loadCategories();
setupCategoryAutocomplete('categorySearch', 'categoryDropdown', 'categoryId');
setupCategoryAutocomplete('previewCategorySearch', 'previewCategoryDropdown', 'previewCategoryId', true);
updatePreview();
</script>
@endsection