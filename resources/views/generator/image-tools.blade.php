@extends('layouts.dashboard')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="mb-8">
        <h1 class="text-3xl font-bold font-space">Image Enhancement Tools</h1>
        <p class="text-gray-400 mt-1">Edit, resize, dan optimasi gambar produk Anda</p>
    </div>
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Image Upload Area -->
        <div class="lg:col-span-1">
            <div class="bg-warasa-card/30 rounded-2xl p-6 border border-warasa-primary/20 sticky top-8">
                <h2 class="text-xl font-semibold mb-4 flex items-center gap-2">
                    <i class="fas fa-upload text-warasa-primary"></i>
                    Upload Gambar
                </h2>
                
                <div id="imageUploadArea"
                    class="border-2 border-dashed border-warasa-primary/30 rounded-xl p-8 text-center cursor-pointer hover:border-warasa-primary transition">
                    <i class="fas fa-cloud-upload-alt text-3xl text-gray-500 mb-2"></i>
                    <p class="text-gray-400">Klik atau drag & drop gambar</p>
                    <p class="text-xs text-gray-500 mt-1">Support: JPG, PNG, WEBP (Max 10MB)</p>
                    <input type="file" id="imageInput" accept="image/*" class="hidden">
                </div>
                
                <div id="imagePreview" class="hidden mt-4">
                    <img id="previewImage" src="" class="rounded-xl w-full object-cover">
                </div>
            </div>
        </div>
        
        <!-- Tools Area -->
        <div class="lg:col-span-2">
            <div class="grid grid-cols-1 gap-6">
                <!-- Remove Background -->
                <div class="bg-warasa-card/30 rounded-2xl p-6 border border-warasa-primary/20">
                    <h3 class="text-lg font-semibold mb-3 flex items-center gap-2">
                        <i class="fas fa-eraser text-warasa-primary"></i>
                        Remove Background
                    </h3>
                    <button id="removeBgBtn" class="bg-warasa-primary px-4 py-2 rounded-lg hover:opacity-90 transition">
                        Hapus Background
                    </button>
                    <div id="removeBgResult" class="hidden mt-3"></div>
                </div>
                
                <!-- Resize Image -->
                <div class="bg-warasa-card/30 rounded-2xl p-6 border border-warasa-primary/20">
                    <h3 class="text-lg font-semibold mb-3 flex items-center gap-2">
                        <i class="fas fa-expand-alt text-warasa-primary"></i>
                        Resize Gambar
                    </h3>
                    <div class="grid grid-cols-2 gap-4 mb-3">
                        <select id="presetSize" class="px-3 py-2 bg-warasa-dark/50 border border-warasa-primary/20 rounded-lg">
                            <option value="">Pilih Preset</option>
                            <option value="shopee">Shopee (800x800)</option>
                            <option value="tokopedia">Tokopedia (720x720)</option>
                            <option value="lazada">Lazada (500x500)</option>
                            <option value="instagram">Instagram (1080x1080)</option>
                            <option value="custom">Custom</option>
                        </select>
                        <div id="customSize" class="hidden flex gap-2">
                            <input type="number" id="resizeWidth" placeholder="Width" class="w-1/2 px-3 py-2 bg-warasa-dark/50 border border-warasa-primary/20 rounded-lg">
                            <input type="number" id="resizeHeight" placeholder="Height" class="w-1/2 px-3 py-2 bg-warasa-dark/50 border border-warasa-primary/20 rounded-lg">
                        </div>
                    </div>
                    <button id="resizeBtn" class="bg-warasa-primary px-4 py-2 rounded-lg hover:opacity-90 transition">
                        Resize
                    </button>
                </div>
                
                <!-- Add Watermark -->
                <div class="bg-warasa-card/30 rounded-2xl p-6 border border-warasa-primary/20">
                    <h3 class="text-lg font-semibold mb-3 flex items-center gap-2">
                        <i class="fas fa-watermark text-warasa-primary"></i>
                        Add Watermark
                    </h3>
                    <input type="text" id="watermarkText" placeholder="Masukkan teks watermark" 
                        class="w-full mb-3 px-3 py-2 bg-warasa-dark/50 border border-warasa-primary/20 rounded-lg">
                    <button id="watermarkBtn" class="bg-warasa-primary px-4 py-2 rounded-lg hover:opacity-90 transition">
                        Tambah Watermark
                    </button>
                </div>
                
                <!-- Batch Processing -->
                <div class="bg-warasa-card/30 rounded-2xl p-6 border border-warasa-primary/20">
                    <h3 class="text-lg font-semibold mb-3 flex items-center gap-2">
                        <i class="fas fa-layer-group text-warasa-primary"></i>
                        Batch Processing
                    </h3>
                    <div class="space-y-3">
                        <label class="flex items-center gap-2">
                            <input type="checkbox" id="batchResize" class="rounded border-warasa-primary/20">
                            <span>Resize semua gambar</span>
                        </label>
                        <label class="flex items-center gap-2">
                            <input type="checkbox" id="batchWatermark" class="rounded border-warasa-primary/20">
                            <span>Tambahkan watermark ke semua gambar</span>
                        </label>
                        <label class="flex items-center gap-2">
                            <input type="checkbox" id="batchCompress" class="rounded border-warasa-primary/20">
                            <span>Compress semua gambar</span>
                        </label>
                        <input type="file" id="batchImages" accept="image/*" multiple class="hidden">
                        <button id="batchSelectBtn" class="w-full bg-warasa-primary/20 hover:bg-warasa-primary/30 py-2 rounded-lg transition">
                            Pilih Gambar untuk Batch
                        </button>
                        <div id="batchPreview" class="grid grid-cols-4 gap-2 mt-3 max-h-32 overflow-y-auto"></div>
                        <button id="processBatchBtn" class="w-full bg-green-600 hover:bg-green-700 py-2 rounded-lg transition hidden">
                            Proses Batch
                        </button>
                    </div>
                </div>
                
                <!-- Compress & Convert -->
                <div class="bg-warasa-card/30 rounded-2xl p-6 border border-warasa-primary/20">
                    <h3 class="text-lg font-semibold mb-3 flex items-center gap-2">
                        <i class="fas fa-file-archive text-warasa-primary"></i>
                        Compress & Convert
                    </h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm mb-2">Kualitas Compress</label>
                            <input type="range" id="compressQuality" min="10" max="100" value="80" class="w-full">
                            <span id="qualityValue" class="text-xs">80%</span>
                        </div>
                        <div>
                            <label class="block text-sm mb-2">Convert Format</label>
                            <select id="convertFormat" class="w-full px-3 py-2 bg-warasa-dark/50 border border-warasa-primary/20 rounded-lg">
                                <option value="">Tetap</option>
                                <option value="jpg">JPG</option>
                                <option value="png">PNG</option>
                                <option value="webp">WEBP</option>
                            </select>
                        </div>
                    </div>
                    <button id="processBtn" class="w-full mt-3 bg-warasa-primary px-4 py-2 rounded-lg hover:opacity-90 transition">
                        Proses
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    let currentImage = null;
    let batchFiles = [];
    
    // Image upload
    const uploadArea = document.getElementById('imageUploadArea');
    const imageInput = document.getElementById('imageInput');
    const imagePreview = document.getElementById('imagePreview');
    const previewImage = document.getElementById('previewImage');
    
    uploadArea.addEventListener('click', () => imageInput.click());
    uploadArea.addEventListener('dragover', (e) => {
        e.preventDefault();
        uploadArea.classList.add('border-warasa-primary');
    });
    uploadArea.addEventListener('dragleave', () => {
        uploadArea.classList.remove('border-warasa-primary');
    });
    uploadArea.addEventListener('drop', (e) => {
        e.preventDefault();
        uploadArea.classList.remove('border-warasa-primary');
        const file = e.dataTransfer.files[0];
        if (file && file.type.startsWith('image/')) {
            handleImageUpload(file);
        }
    });
    
    imageInput.addEventListener('change', (e) => {
        if (e.target.files[0]) {
            handleImageUpload(e.target.files[0]);
        }
    });
    
    function handleImageUpload(file) {
        const reader = new FileReader();
        reader.onload = function(event) {
            currentImage = event.target.result;
            previewImage.src = currentImage;
            imagePreview.classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    }
    
    // Remove Background
    document.getElementById('removeBgBtn').addEventListener('click', async () => {
        if (!currentImage) {
            alert('Upload gambar terlebih dahulu!');
            return;
        }
        
        // For demo, show message (implement with remove.bg API)
        document.getElementById('removeBgResult').innerHTML = `
            <div class="bg-green-500/20 p-3 rounded-lg">
                <p class="text-green-400">✅ Background removal simulated</p>
                <p class="text-xs text-gray-400 mt-1">For actual background removal, integrate with remove.bg API</p>
            </div>
        `;
        document.getElementById('removeBgResult').classList.remove('hidden');
    });
    
    // Resize with preset
    const presetSize = document.getElementById('presetSize');
    const customSize = document.getElementById('customSize');
    
    presetSize.addEventListener('change', () => {
        if (presetSize.value === 'custom') {
            customSize.classList.remove('hidden');
        } else {
            customSize.classList.add('hidden');
        }
    });
    
    document.getElementById('resizeBtn').addEventListener('click', () => {
        if (!currentImage) {
            alert('Upload gambar terlebih dahulu!');
            return;
        }
        alert('Resize feature - akan diimplementasikan dengan Intervention Image');
    });
    
    // Watermark
    document.getElementById('watermarkBtn').addEventListener('click', () => {
        const text = document.getElementById('watermarkText').value;
        if (!text) {
            alert('Masukkan teks watermark!');
            return;
        }
        alert(`Watermark "${text}" akan ditambahkan`);
    });
    
    // Compress quality slider
    const compressQuality = document.getElementById('compressQuality');
    const qualityValue = document.getElementById('qualityValue');
    compressQuality.addEventListener('input', () => {
        qualityValue.textContent = compressQuality.value + '%';
    });
    
    // Batch processing
    const batchSelectBtn = document.getElementById('batchSelectBtn');
    const batchImages = document.getElementById('batchImages');
    const batchPreview = document.getElementById('batchPreview');
    const processBatchBtn = document.getElementById('processBatchBtn');
    
    batchSelectBtn.addEventListener('click', () => batchImages.click());
    
    batchImages.addEventListener('change', (e) => {
        batchFiles = Array.from(e.target.files);
        batchPreview.innerHTML = batchFiles.map(file => `
            <div class="aspect-square rounded-lg overflow-hidden border border-warasa-primary/20">
                <img src="${URL.createObjectURL(file)}" class="w-full h-full object-cover">
            </div>
        `).join('');
        processBatchBtn.classList.remove('hidden');
    });
    
    processBatchBtn.addEventListener('click', () => {
        const options = {
            resize: document.getElementById('batchResize').checked,
            watermark: document.getElementById('batchWatermark').checked,
            compress: document.getElementById('batchCompress').checked,
        };
        alert(`Batch processing dengan ${batchFiles.length} gambar\nResize: ${options.resize}\nWatermark: ${options.watermark}\nCompress: ${options.compress}`);
    });
    
    // Process single image
    document.getElementById('processBtn').addEventListener('click', () => {
        const quality = document.getElementById('compressQuality').value;
        const format = document.getElementById('convertFormat').value;
        alert(`Memproses gambar dengan kualitas ${quality}% dan format ${format || 'tetap'}`);
    });
</script>
@endpush
@endsection