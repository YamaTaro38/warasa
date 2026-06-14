@extends('layouts.dashboard')

@section('page-title', 'Shopee Fee Calculator')
@section('breadcrumb', 'Tools / Shopee Fee Calculator')

@section('content')
<style>
    .fee-grid {
        display: grid;
        grid-template-columns: 1fr 1.2fr;
        gap: 24px;
    }
    @media (max-width: 992px) {
        .fee-grid { grid-template-columns: 1fr; }
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
    .section-title i { color: #ee4d2d; font-size: 14px; }

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

    label {
        display: block;
        font-size: 12px;
        font-weight: 500;
        color: #334155;
        margin-bottom: 6px;
    }

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
    .btn-primary:hover { background: #d63e1f; transform: translateY(-1px); }
    .btn-primary:disabled { opacity: 0.5; cursor: not-allowed; transform: none; }

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
    .btn-secondary:hover { background: #e2e8f0; }

    .sticky-top { position: sticky; top: 80px; }

    /* Autocomplete — same as Quick Generate */
    .autocomplete-container { position: relative; }
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
    .autocomplete-dropdown.active { display: block; }
    .autocomplete-item {
        padding: 8px 12px;
        cursor: pointer;
        transition: background 0.2s;
        border-bottom: 1px solid #f1f5f9;
        font-size: 12px;
        color: #334155;
    }
    .autocomplete-item:last-child { border-bottom: none; }
    .autocomplete-item:hover { background: #f8fafc; }

    /* Toggle Switch */
    .toggle-row {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 12px;
        padding: 10px 12px;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.2s;
        margin-bottom: 8px;
    }
    .toggle-row:hover { background: #f8fafc; }
    .toggle-row.active { border-color: #ee4d2d; background: #fff0eb; }
    .toggle-info { flex: 1; min-width: 0; }
    .toggle-title { font-size: 13px; font-weight: 500; color: #1e293b; }
    .toggle-desc { font-size: 11px; color: #64748b; margin-top: 2px; }
    .toggle-switch {
        position: relative;
        width: 44px; height: 24px;
        flex-shrink: 0;
        border-radius: 12px;
        background: #cbd5e1;
        transition: all 0.3s;
        margin-top: 2px;
    }
    .toggle-row.active .toggle-switch { background: #ee4d2d; }
    .toggle-switch::after {
        content: '';
        position: absolute;
        top: 2px; left: 2px;
        width: 20px; height: 20px;
        border-radius: 50%;
        background: white;
        box-shadow: 0 1px 3px rgba(0,0,0,0.15);
        transition: all 0.3s;
    }
    .toggle-row.active .toggle-switch::after { transform: translateX(20px); }

    .result-amount {
        font-size: 36px;
        font-weight: 800;
        color: #0f172a;
        letter-spacing: -0.5px;
    }
    .result-amount.positive { color: #059669; }

    .breakdown-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 8px 0;
        border-bottom: 1px solid #f1f5f9;
        font-size: 13px;
    }
    .breakdown-item:last-child { border-bottom: none; }
    .breakdown-label { color: #64748b; }
    .breakdown-amount { font-weight: 600; color: #1e293b; }
    .breakdown-amount.negative { color: #ef4444; }

    .disclaimer {
        font-size: 11px;
        color: #94a3b8;
        line-height: 1.5;
        margin-top: 12px;
        padding: 0 4px;
    }
</style>

<div class="max-w-full">
    <div class="fee-grid">
        <!-- Input Section -->
        <div class="form-section">
            <div class="section-title">
                <i class="fas fa-calculator"></i>
                Detail Produk
            </div>
            <div class="space-y-4">
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label>Harga Produk (Rp)</label>
                        <input type="number" id="harga" class="input-solid" placeholder="0" min="0">
                    </div>
                    <div>
                        <label>Diskon Penjual (Rp)</label>
                        <input type="number" id="diskon" class="input-solid" placeholder="0" min="0" value="0">
                    </div>
                    <div>
                        <label>Voucher Penjual (Rp)</label>
                        <input type="number" id="voucher" class="input-solid" placeholder="0" min="0" value="0">
                    </div>
                    <div>
                        <label>Cashback Koin Ditanggung (Rp)</label>
                        <input type="number" id="cashback" class="input-solid" placeholder="0" min="0" value="0">
                    </div>
                </div>

                <div class="border-b border-gray-200 pb-3">
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label>Kategori Produk Shopee</label>
                            <div class="autocomplete-container">
                                <input type="text" id="kategoriSearch" class="input-solid" placeholder="Cari kategori..." autocomplete="off">
                                <div id="kategoriDropdown" class="autocomplete-dropdown"></div>
                            </div>
                            <input type="hidden" id="kategoriSlug" value="">
                        </div>
                        <div>
                            <label>Status Penjual</label>
                            <select id="statusPenjual" class="input-solid">
                                <option value="STAR">Star / Star+</option>
                                <option value="NON_STAR">Non-Star</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div>
                    <p class="text-xs font-medium text-gray-500 mb-2">Promo & Layanan</p>
                    <div class="toggle-row" data-toggle="promo_xtra">
                        <div class="toggle-info">
                            <p class="toggle-title">Ikut Promo XTRA</p>
                            <p class="toggle-desc">Tambahan 4.50%, max Rp 60.000</p>
                        </div>
                        <div class="toggle-switch"></div>
                    </div>
                    <div class="toggle-row" data-toggle="live_xtra">
                        <div class="toggle-info">
                            <p class="toggle-title">Ikut Live XTRA</p>
                            <p class="toggle-desc">Tambahan 3.00%, max Rp 20.000</p>
                        </div>
                        <div class="toggle-switch"></div>
                    </div>
                    <div class="toggle-row" data-toggle="gratis_ongkir">
                        <div class="toggle-info">
                            <p class="toggle-title">Ikut Gratis Ongkir XTRA</p>
                            <p class="toggle-desc">Rate beda per kategori</p>
                        </div>
                        <div class="toggle-switch"></div>
                    </div>
                    <div class="toggle-row" data-toggle="preorder">
                        <div class="toggle-info">
                            <p class="toggle-title">Produk Pre-Order</p>
                            <p class="toggle-desc">+3.00% (kecuali kategori tertentu)</p>
                        </div>
                        <div class="toggle-switch"></div>
                    </div>
                </div>

                <div class="flex gap-3">
                    <button type="button" id="hitungBtn" class="btn-primary flex-1">
                        <i class="fas fa-calculator"></i> Hitung Biaya
                    </button>
                    <button type="button" id="resetBtn" class="btn-secondary">Reset</button>
                </div>
            </div>
        </div>

        <!-- Result Section -->
        <div class="sticky-top">
            <div class="form-section" style="margin-bottom: 0;">
                <div class="section-title">
                    <i class="fas fa-chart-pie"></i>
                    Hasil Perhitungan
                </div>
                <div id="resultContainer">
                    <div class="text-center text-gray-500 py-8">
                        <i class="fas fa-chart-pie text-4xl mb-3 opacity-50"></i>
                        <p class="text-sm">Masukkan data produk di samping</p>
                        <p class="text-xs mt-1">Klik "Hitung Biaya" untuk melihat hasil</p>
                    </div>
                </div>
            </div>
            <p class="disclaimer">*Estimasi berdasarkan struktur biaya Shopee per November 2025. Angka sebenarnya bisa berubah sesuai kebijakan Shopee.</p>
        </div>
    </div>
</div>

<script>
// ====== Data Kategori ======
const categories = {
    'elektronik': 'Elektronik',
    'handphone': 'Handphone & Tablet',
    'komputer': 'Komputer & Laptop',
    'kamera': 'Kamera',
    'fashion': 'Fashion',
    'kecantikan': 'Kecantikan',
    'ibu_anak': 'Ibu & Anak',
    'makanan': 'Makanan & Minuman',
    'rumah_tangga': 'Rumah Tangga',
    'otomotif': 'Otomotif',
    'olahraga': 'Olahraga',
    'buku': 'Buku & Stationery',
};
const categoryKeys = Object.keys(categories);

// ====== DOM ======
const hargaInput = document.getElementById('harga');
const diskonInput = document.getElementById('diskon');
const voucherInput = document.getElementById('voucher');
const cashbackInput = document.getElementById('cashback');
const kategoriSearch = document.getElementById('kategoriSearch');
const kategoriSlug = document.getElementById('kategoriSlug');
const hitungBtn = document.getElementById('hitungBtn');
const resetBtn = document.getElementById('resetBtn');
const resultContainer = document.getElementById('resultContainer');
const kategoriDropdown = document.getElementById('kategoriDropdown');

// ====== Autocomplete (same as Quick Generate) ======
function filterCategories(query) {
    if (!query) return categoryKeys;
    const q = query.toLowerCase();
    return categoryKeys.filter(k =>
        categories[k].toLowerCase().includes(q) || k.includes(q)
    );
}

function showDropdown(results) {
    kategoriDropdown.innerHTML = '';
    if (results.length === 0) {
        kategoriDropdown.classList.remove('active');
        return;
    }
    results.forEach(function(slug) {
        const item = document.createElement('div');
        item.className = 'autocomplete-item';
        item.textContent = categories[slug];
        item.dataset.slug = slug;
        item.addEventListener('click', function() {
            kategoriSlug.value = this.dataset.slug;
            kategoriSearch.value = categories[this.dataset.slug];
            kategoriDropdown.classList.remove('active');
        });
        kategoriDropdown.appendChild(item);
    });
    kategoriDropdown.classList.add('active');
}

kategoriSearch.addEventListener('input', function() {
    const q = this.value;
    if (!q) { kategoriSlug.value = ''; showDropdown(categoryKeys); return; }
    const results = filterCategories(q);
    kategoriSlug.value = results.length > 0 ? results[0] : '';
    showDropdown(results);
});
kategoriSearch.addEventListener('focus', function() {
    showDropdown(this.value ? filterCategories(this.value) : categoryKeys);
});
kategoriSearch.addEventListener('blur', function() {
    setTimeout(function() { kategoriDropdown.classList.remove('active'); }, 200);
    if (!kategoriSlug.value && this.value) this.value = '';
});
document.addEventListener('click', function(e) {
    if (!e.target.closest('.autocomplete-container')) {
        kategoriDropdown.classList.remove('active');
    }
});

// ====== Toggle ======
document.querySelectorAll('.toggle-row').forEach(function(row) {
    row.addEventListener('click', function() { this.classList.toggle('active'); });
});

function formatRupiah(n) { return 'Rp ' + n.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.'); }

// ====== Hitung ======
hitungBtn.addEventListener('click', function() {
    const harga = parseInt(hargaInput.value) || 0;
    const diskon = parseInt(diskonInput.value) || 0;
    const voucher = parseInt(voucherInput.value) || 0;
    const cashback = parseInt(cashbackInput.value) || 0;
    const slug = kategoriSlug.value;
    const status = document.getElementById('statusPenjual').value;
    const promoXtra = document.querySelector('[data-toggle="promo_xtra"]').classList.contains('active');
    const liveXtra = document.querySelector('[data-toggle="live_xtra"]').classList.contains('active');
    const gratisOngkir = document.querySelector('[data-toggle="gratis_ongkir"]').classList.contains('active');
    const preorder = document.querySelector('[data-toggle="preorder"]').classList.contains('active');

    if (harga <= 0) { showToast('Masukkan harga produk', 'error'); return; }
    if (!slug) { showToast('Pilih kategori produk', 'error'); return; }

    this.disabled = true;
    this.innerHTML = '<i class="fas fa-spinner fa-pulse"></i> Menghitung...';

    fetch('{{ route("shopee.fee.calculate") }}', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
        body: JSON.stringify({ harga, diskon, voucher_penjual: voucher, cashback_koin: cashback, kategori_slug: slug, status_penjual: status, promo_xtra: promoXtra, live_xtra: liveXtra, gratis_ongkir_xtra: gratisOngkir, preorder }),
    })
    .then(function(r) { return r.json(); })
    .then(function(res) {
        if (res.success) { displayResult(res.data); showToast('Perhitungan berhasil!', 'success'); }
        else showToast('Terjadi kesalahan', 'error');
    })
    .catch(function() { showToast('Gagal menghubungi server', 'error'); })
    .finally(function() {
        hitungBtn.disabled = false;
        hitungBtn.innerHTML = '<i class="fas fa-calculator"></i> Hitung Biaya';
    });
});

function displayResult(data) {
    let breakdownHtml = '';
    data.breakdown.forEach(function(item) {
        breakdownHtml += '<div class="breakdown-item"><span class="breakdown-label">' + item.label + '</span><span class="breakdown-amount negative">' + formatRupiah(item.amount) + '</span></div>';
    });

    resultContainer.innerHTML =
        '<div class="bg-[#fff0eb] rounded-lg p-4 border border-[#fdbaa0] mb-4">' +
        '<div class="flex items-center justify-between"><p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Dana Diterima</p><span class="text-xs text-gray-400">dari Rp ' + data.harga.toLocaleString('id-ID') + '</span></div>' +
        '<div class="result-amount positive mt-1">' + formatRupiah(data.dana_diterima) + '</div>' +
        '<div class="flex items-center gap-4 mt-2"><span class="text-xs text-gray-500">Setelah diskon: ' + formatRupiah(data.harga_setelah_diskon) + '</span><span class="text-xs text-red-500">-' + data.persen_biaya + '% biaya</span></div>' +
        '</div>' +
        '<p class="text-xs font-medium text-gray-500 mb-2">Rincian Biaya</p>' +
        '<div class="bg-gray-50 rounded-lg p-3">' + breakdownHtml +
        '<div class="breakdown-item border-t-2 border-gray-200 mt-2 pt-2 font-semibold"><span class="breakdown-label">Total Biaya</span><span class="breakdown-amount negative" style="font-size:15px">' + formatRupiah(data.total_biaya) + '</span></div>' +
        '<div class="breakdown-item font-semibold"><span class="breakdown-label">Dana Diterima</span><span style="font-weight:700;font-size:14px;color:#059669">' + formatRupiah(data.dana_diterima) + '</span></div>' +
        '</div>';
}

// ====== Reset ======
resetBtn.addEventListener('click', function() {
    hargaInput.value = '';
    diskonInput.value = '0'; voucherInput.value = '0'; cashbackInput.value = '0';
    kategoriSearch.value = ''; kategoriSlug.value = '';
    document.querySelectorAll('.toggle-row').forEach(function(r) { r.classList.remove('active'); });
    resultContainer.innerHTML = '<div class="text-center text-gray-500 py-8"><i class="fas fa-chart-pie text-4xl mb-3 opacity-50"></i><p class="text-sm">Masukkan data produk di samping</p><p class="text-xs mt-1">Klik "Hitung Biaya" untuk melihat hasil</p></div>';
    showToast('Form berhasil direset', 'info');
});
</script>
@endsection