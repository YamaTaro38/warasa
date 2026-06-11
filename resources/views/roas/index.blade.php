@extends('layouts.dashboard')

@section('page-title', 'ROAS Calculator')
@section('breadcrumb', 'Generator / ROAS Calculator')

@section('content')
<style>
    .form-section {
        background: white;
        border: 1px solid var(--shopee-border, #e2e8f0);
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 20px;
    }
    .dark .form-section { border-color: #334155; background: #1e293b; }
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
    .dark .section-title { color: #f1f5f9; border-color: #334155; }
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
    .dark .input-solid { background: #0f172a; border-color: #475569; color: #e2e8f0; }
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
    .dark label { color: #cbd5e1; }
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
    .roas-grid {
        display: grid;
        grid-template-columns: 1fr 1.2fr;
        gap: 24px;
    }
    @media (max-width: 992px) {
        .roas-grid { grid-template-columns: 1fr; }
    }
    .recommendation-item {
        padding: 10px 12px;
        border-radius: 8px;
        background: #f9fafb;
        margin-bottom: 8px;
        font-size: 12px;
    }
    .dark .recommendation-item { background: #1e1e2e; }
    .sticky-top { position: sticky; top: 80px; }
</style>

<div class="max-w-full">
    <div class="roas-grid">
        <!-- Input Section -->
        <div class="form-section">
            <div class="section-title">
                <i class="fas fa-calculator"></i>
                Masukkan Data Campaign
            </div>
            <div class="space-y-4">
                    <!-- Info Produk -->
                    <div class="border-b border-gray-200 dark:border-gray-700 pb-3">
                        <p class="text-xs font-medium text-gray-500 mb-2">Informasi Produk</p>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">Nama Produk</label>
                                <input type="text" id="productName" class="input-solid w-full" placeholder="Contoh: Baju Koko Premium">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">Nama Campaign</label>
                                <input type="text" id="campaignName" class="input-solid w-full" placeholder="Shopee Ads">
                            </div>
                        </div>
                    </div>
                    
                    <!-- Biaya & Harga -->
                    <div class="border-b border-gray-200 dark:border-gray-700 pb-3">
                        <p class="text-xs font-medium text-gray-500 mb-2">Harga & Biaya Produk</p>
                        <div class="space-y-3">
                            <div>
                                <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">Harga Jual Produk (Rp)</label>
                                <input type="number" id="sellingPrice" class="input-solid w-full" placeholder="0" value="0">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">Modal Produk (Rp)</label>
                                <input type="number" id="productCost" class="input-solid w-full" placeholder="0" value="0">
                            </div>
                        </div>
                    </div>
                    
                    <!-- Biaya Iklan & Promosi -->
                    <div class="border-b border-gray-200 dark:border-gray-700 pb-3">
                        <p class="text-xs font-medium text-gray-500 mb-2">Biaya Iklan & Promosi</p>
                        <div class="space-y-3">
                            <div>
                                <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">Biaya Promosi (Ad Spend) - Rp</label>
                                <input type="number" id="adSpend" class="input-solid w-full" placeholder="0" value="0">
                            </div>
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">Target ACOS (%)</label>
                                    <input type="number" id="targetAcos" class="input-solid w-full" placeholder="30" value="30">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">% Fee Marketplace</label>
                                    <input type="number" id="marketplaceFee" class="input-solid w-full" placeholder="10" value="10">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Biaya Lain-lain & Pendapatan -->
                    <div class="border-b border-gray-200 dark:border-gray-700 pb-3">
                        <p class="text-xs font-medium text-gray-500 mb-2">Pendapatan & Biaya Lain</p>
                        <div class="space-y-3">
                            <div>
                                <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">Total Pendapatan (Revenue) - Rp</label>
                                <input type="number" id="revenue" class="input-solid w-full" placeholder="0" value="0">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">Biaya Lain-lain (Rp)</label>
                                <input type="number" id="otherCosts" class="input-solid w-full" placeholder="0" value="0">
                            </div>
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">Periode</label>
                                    <select id="period" class="input-solid w-full">
                                        <option value="hari">Harian</option>
                                        <option value="minggu">Mingguan</option>
                                        <option value="bulan">Bulanan</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">Estimasi Unit Terjual</label>
                                    <input type="number" id="unitsSold" class="input-solid w-full" placeholder="0" value="0">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <button id="calculateBtn" class="btn-primary">
                        <i class="fas fa-chart-line"></i> Hitung ROAS & Profitabilitas
                    </button>
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
                        <i class="fas fa-chart-line text-4xl mb-3 opacity-50"></i>
                        <p class="text-sm">Masukkan data campaign di samping</p>
                        <p class="text-xs mt-1">Klik "Hitung ROAS & Profitabilitas" untuk melihat hasil</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Info Panel -->
    <div class="mt-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg p-3 border border-blue-200 dark:border-blue-800">
        <div class="flex items-start gap-2">
            <i class="fas fa-info-circle text-blue-500 text-sm mt-0.5"></i>
            <div class="text-xs text-gray-700 dark:text-gray-300">
                <p class="font-medium mb-1">Apa itu ACOS?</p>
                <p>ACOS (Advertising Cost of Sales) = (Biaya Iklan / Pendapatan) × 100%. Target ACOS yang baik untuk Shopee: 15% - 30%.</p>
                <p class="mt-1">Apa itu ROAS? ROAS (Return on Ad Spend) = (Pendapatan / Biaya Iklan). Target ROAS yang baik: 2x - 5x (200% - 500%).</p>
            </div>
        </div>
    </div>
</div>

<script>
const calculateBtn = document.getElementById('calculateBtn');
const resultContainer = document.getElementById('resultContainer');

calculateBtn.addEventListener('click', async function() {
    // Ambil semua nilai input
    const sellingPrice = parseInt(document.getElementById('sellingPrice').value) || 0;
    const productCost = parseInt(document.getElementById('productCost').value) || 0;
    const adSpend = parseInt(document.getElementById('adSpend').value) || 0;
    const targetAcos = parseInt(document.getElementById('targetAcos').value) || 0;
    const marketplaceFee = parseInt(document.getElementById('marketplaceFee').value) || 0;
    const revenue = parseInt(document.getElementById('revenue').value) || 0;
    const otherCosts = parseInt(document.getElementById('otherCosts').value) || 0;
    const unitsSold = parseInt(document.getElementById('unitsSold').value) || 0;
    const productName = document.getElementById('productName').value;
    const campaignName = document.getElementById('campaignName').value;
    const period = document.getElementById('period').value;
    
    if (adSpend === 0 && revenue === 0 && sellingPrice === 0) {
        showToast('Masukkan data terlebih dahulu (harga jual, biaya iklan, atau pendapatan)', 'error');
        return;
    }
    
    this.disabled = true;
    this.innerHTML = '<i class="fas fa-spinner fa-pulse"></i> Menghitung...';
    
    // Hitung di frontend agar lebih cepat
    setTimeout(() => {
        const result = calculateProfitability({
            sellingPrice, productCost, adSpend, targetAcos, marketplaceFee,
            revenue, otherCosts, unitsSold, productName, campaignName, period
        });
        displayResult(result);
        showToast('Perhitungan berhasil!', 'success');
        
        this.disabled = false;
        this.innerHTML = '<i class="fas fa-chart-line"></i> Hitung ROAS & Profitabilitas';
    }, 100);
});

function calculateProfitability(data) {
    // Perhitungan dasar
    const adSpend = data.adSpend;
    const revenue = data.revenue;
    const sellingPrice = data.sellingPrice;
    const productCost = data.productCost;
    const marketplaceFeePercent = data.marketplaceFee;
    const otherCosts = data.otherCosts;
    const unitsSold = data.unitsSold;
    const targetAcos = data.targetAcos;
    
    // 1. Hitung revenue jika tidak diisi (berdasarkan harga jual x unit)
    let finalRevenue = revenue;
    let finalUnitsSold = unitsSold;
    
    if (finalRevenue === 0 && sellingPrice > 0 && finalUnitsSold > 0) {
        finalRevenue = sellingPrice * finalUnitsSold;
    }
    if (finalUnitsSold === 0 && sellingPrice > 0 && finalRevenue > 0) {
        finalUnitsSold = Math.floor(finalRevenue / sellingPrice);
    }
    
    // 2. ROAS
    const roas = adSpend > 0 ? finalRevenue / adSpend : 0;
    const roasPercent = roas * 100;
    
    // 3. ACOS (Advertising Cost of Sales)
    const acos = finalRevenue > 0 ? (adSpend / finalRevenue) * 100 : 0;
    const acosDiff = targetAcos > 0 ? acos - targetAcos : 0;
    const isAcosGood = acos <= targetAcos;
    
    // 4. Gross Profit (Pendapatan - HPP - Fee Marketplace - Biaya Iklan - Biaya Lain)
    const totalProductCost = productCost * finalUnitsSold;
    const marketplaceFeeAmount = (marketplaceFeePercent / 100) * finalRevenue;
    const grossProfit = finalRevenue - totalProductCost - marketplaceFeeAmount - adSpend - otherCosts;
    const grossProfitMargin = finalRevenue > 0 ? (grossProfit / finalRevenue) * 100 : 0;
    
    // 5. Interpretasi
    let roasInterpretation, acosInterpretation, profitInterpretation;
    
    // ROAS Interpretation
    if (roas >= 5) {
        roasInterpretation = { level: 'Sangat Baik', color: 'success', icon: 'fa-trophy', grade: 'A+', message: 'ROAS sangat baik! Campaign Anda sangat menguntungkan.' };
    } else if (roas >= 3) {
        roasInterpretation = { level: 'Baik', color: 'primary', icon: 'fa-chart-line', grade: 'A', message: 'ROAS baik. Campaign Anda menguntungkan.' };
    } else if (roas >= 2) {
        roasInterpretation = { level: 'Cukup', color: 'info', icon: 'fa-chart-simple', grade: 'B', message: 'ROAS cukup. Masih ada ruang untuk optimasi.' };
    } else if (roas >= 1) {
        roasInterpretation = { level: 'Break Even', color: 'warning', icon: 'fa-balance-scale', grade: 'C', message: 'ROAS break even. Anda tidak untung dan tidak rugi.' };
    } else {
        roasInterpretation = { level: 'Rugi', color: 'danger', icon: 'fa-exclamation-triangle', grade: 'D', message: 'ROAS di bawah break even. Campaign Anda merugi.' };
    }
    
    // ACOS Interpretation
    if (acos <= 15) {
        acosInterpretation = { level: 'Sangat Efisien', color: 'success', message: 'Biaya iklan sangat efisien!' };
    } else if (acos <= 25) {
        acosInterpretation = { level: 'Efisien', color: 'primary', message: 'Biaya iklan cukup efisien.' };
    } else if (acos <= 40) {
        acosInterpretation = { level: 'Cukup', color: 'info', message: 'Biaya iklan masih dalam batas wajar.' };
    } else {
        acosInterpretation = { level: 'Boros', color: 'warning', message: 'Biaya iklan terlalu tinggi. Perlu optimasi.' };
    }
    
    // Profit Interpretation
    if (grossProfit > 0) {
        profitInterpretation = { status: 'Untung', color: 'success', message: `Profit bersih: Rp ${formatNumber(grossProfit)}` };
    } else if (grossProfit === 0) {
        profitInterpretation = { status: 'Impase', color: 'warning', message: 'Tidak untung dan tidak rugi.' };
    } else {
        profitInterpretation = { status: 'Rugi', color: 'danger', message: `Rugi bersih: Rp ${formatNumber(Math.abs(grossProfit))}` };
    }
    
    return {
        adSpend, finalRevenue, roas, roasPercent, acos, acosDiff, isAcosGood,
        targetAcos, grossProfit, grossProfitMargin, finalUnitsSold,
        totalProductCost, marketplaceFeeAmount, otherCosts, sellingPrice, productCost,
        marketplaceFeePercent, roasInterpretation, acosInterpretation, profitInterpretation
    };
}

function formatNumber(num) {
    return new Intl.NumberFormat('id-ID').format(num);
}

function getColorClass(color) {
    const colors = {
        success: 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
        primary: 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400',
        info: 'bg-cyan-100 text-cyan-800 dark:bg-cyan-900/30 dark:text-cyan-400',
        warning: 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400',
        danger: 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400',
    };
    return colors[color] || colors.info;
}

function displayResult(data) {
    const roasColor = getColorClass(data.roasInterpretation.color);
    const acosColor = getColorClass(data.acosInterpretation.color);
    const profitColor = getColorClass(data.profitInterpretation.color);
    
    let html = `
        <div class="bg-gray-50 dark:bg-gray-900/50 rounded-lg p-4 space-y-4">
            <!-- Summary ROAS & ACOS -->
            <div class="grid grid-cols-2 gap-3">
                <div class="text-center p-3 rounded-lg ${roasColor}">
                    <i class="fas ${data.roasInterpretation.icon} text-base"></i>
                    <p class="text-xs uppercase mt-1 font-semibold">ROAS</p>
                    <p class="text-lg font-bold">${data.roas.toFixed(2)}x</p>
                    <p class="text-xs">(${data.roasPercent.toFixed(1)}%)</p>
                    <p class="text-xs mt-1">${data.roasInterpretation.grade}</p>
                </div>
                <div class="text-center p-3 rounded-lg ${acosColor}">
                    <i class="fas fa-chart-simple text-base"></i>
                    <p class="text-xs uppercase mt-1 font-semibold">ACOS</p>
                    <p class="text-lg font-bold">${data.acos.toFixed(1)}%</p>
                    <p class="text-xs">Target: ${data.targetAcos}%</p>
                    <p class="text-xs ${data.isAcosGood ? 'text-green-600' : 'text-red-600'}">
                        ${data.acosDiff > 0 ? '+' : ''}${data.acosDiff.toFixed(1)}%
                    </p>
                </div>
            </div>
            
            <!-- Profit Summary -->
            <div class="grid grid-cols-2 gap-3">
                <div class="bg-white dark:bg-gray-800 rounded-lg p-3 text-center shadow-sm">
                    <p class="text-xs text-gray-400 uppercase font-medium">Pendapatan</p>
                    <p class="text-sm font-bold text-gray-800 dark:text-white">Rp ${formatNumber(data.finalRevenue)}</p>
                    <p class="text-xs text-gray-500">${data.finalUnitsSold} unit terjual</p>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-lg p-3 text-center shadow-sm">
                    <p class="text-xs text-gray-400 uppercase font-medium">Biaya Iklan</p>
                    <p class="text-sm font-bold text-gray-800 dark:text-white">Rp ${formatNumber(data.adSpend)}</p>
                    <p class="text-xs text-gray-500">${(data.adSpend / data.finalRevenue * 100).toFixed(1)}% dari revenue</p>
                </div>
            </div>
            
            <!-- Detail Biaya -->
            <div class="bg-white dark:bg-gray-800 rounded-lg p-3">
                <p class="text-xs font-semibold mb-2 flex items-center gap-1">
                    <i class="fas fa-receipt text-[#ee4d2d]"></i> Rincian Biaya
                </p>
                <div class="space-y-1 text-xs">
                    <div class="flex justify-between">
                        <span class="text-gray-500">HPP (${data.finalUnitsSold} unit)</span>
                        <span>Rp ${formatNumber(data.totalProductCost)}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Fee Marketplace (${data.marketplaceFeePercent}%)</span>
                        <span>Rp ${formatNumber(data.marketplaceFeeAmount)}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Biaya Iklan</span>
                        <span>Rp ${formatNumber(data.adSpend)}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Biaya Lain-lain</span>
                        <span>Rp ${formatNumber(data.otherCosts)}</span>
                    </div>
                    <div class="border-t border-gray-200 dark:border-gray-700 pt-1 mt-1">
                        <div class="flex justify-between font-semibold">
                            <span>Total Biaya</span>
                            <span>Rp ${formatNumber(data.totalProductCost + data.marketplaceFeeAmount + data.adSpend + data.otherCosts)}</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Profit Bersih -->
            <div class="text-center p-3 rounded-lg ${profitColor}">
                <i class="fas fa-dollar-sign text-base"></i>
                <p class="text-xs uppercase mt-1 font-semibold">${data.profitInterpretation.status}</p>
                <p class="text-lg font-bold">${data.grossProfit >= 0 ? '+' : ''}Rp ${formatNumber(Math.abs(data.grossProfit))}</p>
                <p class="text-xs">Margin: ${data.grossProfitMargin.toFixed(1)}%</p>
                <p class="text-xs mt-1">${data.profitInterpretation.message}</p>
            </div>
            
            <!-- Rekomendasi -->
            <div>
                <p class="text-xs font-semibold text-gray-700 dark:text-gray-300 mb-2 flex items-center gap-1">
                    <i class="fas fa-lightbulb text-[#ee4d2d]"></i> Rekomendasi
                </p>
                <div class="space-y-2">
                    ${generateRecommendations(data).map(rec => `
                        <div class="recommendation-item">
                            <i class="fas fa-check-circle text-[#ee4d2d] text-xs mr-2"></i>
                            <span class="text-xs">${rec}</span>
                        </div>
                    `).join('')}
                </div>
            </div>
            
            <!-- Note -->
            <div class="text-xs text-gray-400 text-center border-t border-gray-200 dark:border-gray-700 pt-3">
                <i class="fas fa-chart-simple mr-1"></i> Hitung secara rutin untuk memantau performa campaign Anda.
            </div>
        </div>
    `;
    
    resultContainer.innerHTML = html;
}

function generateRecommendations(data) {
    const recs = [];
    
    // Rekomendasi berdasarkan ROAS
    if (data.roas < 2) {
        recs.push('Turunkan biaya iklan atau optimasi target audiens untuk meningkatkan ROAS.');
        recs.push('Evaluasi ulang kreatif iklan (gambar/video) agar lebih menarik.');
    } else if (data.roas >= 3) {
        recs.push('Perbesar budget campaign ini secara bertahap untuk skala keuntungan.');
    }
    
    // Rekomendasi berdasarkan ACOS
    if (data.acos > data.targetAcos) {
        recs.push(`ACOS ${data.acos.toFixed(1)}% melebihi target ${data.targetAcos}%. Optimasi kata kunci dan bidding.`);
    } else if (data.acos <= 15) {
        recs.push(`ACOS sangat efisien! Pertimbangkan untuk meningkatkan budget campaign.`);
    }
    
    // Rekomendasi berdasarkan profit
    if (data.grossProfit <= 0) {
        recs.push('Periksa kembali struktur biaya. Coba turunkan harga pokok atau cari supplier lebih murah.');
        recs.push('Tingkatkan volume penjualan untuk menekan biaya tetap per unit.');
    }
    
    // Rekomendasi umum Shopee
    recs.push('Gunakan fitur Shopee Ads Keyword untuk target yang lebih tepat.');
    recs.push('Manfaatkan momen flash sale dan campaign event Shopee.');
    
    // Batasi 5 rekomendasi
    return recs.slice(0, 5);
}
</script>
@endsection