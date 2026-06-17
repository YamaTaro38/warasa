@extends('layouts.dashboard')

@section('page-title', 'Dashboard')
@section('breadcrumb', 'Overview')

@section('content')
<style>
* { box-sizing: border-box; }

/* ── Card ── */
.d-card {
    background:#fff;
    border-radius:16px;
    border:1px solid #eef2f6;
    transition:all .25s;
}
.d-card:hover { border-color:#e2e8f0; }

/* ── Stat Card ── */
.d-stat {
    padding:20px 24px;
    position:relative;
    overflow:hidden;
}
.d-stat::after {
    content:'';
    position:absolute;
    top:-50%;right:-20%;
    width:120px;height:120px;
    border-radius:50%;
    background:currentColor;
    opacity:.035;
    pointer-events:none;
}
.d-stat .ico {
    width:44px;height:44px;
    border-radius:14px;
    display:flex;align-items:center;justify-content:center;
    font-size:18px;flex-shrink:0;
}

/* ── Table ── */
.tbl-wrap { overflow-x:auto; }
.tbl { width:100%;border-collapse:collapse; }
.tbl thead th {
    padding:12px 20px;
    font-size:10px;font-weight:700;
    text-transform:uppercase;letter-spacing:.8px;
    color:#94a3b8;background:#fafbfc;
    border-bottom:1px solid #eef2f6;
    text-align:left;white-space:nowrap;
}
.tbl tbody td {
    padding:14px 20px;
    font-size:13px;color:#334155;
    border-bottom:1px solid #f1f5f9;
    vertical-align:middle;
}
.tbl tbody tr:last-child td { border-bottom:0; }

/* ── Thumb ── */
.thumb { width:40px;height:40px;border-radius:10px;object-fit:cover;background:#f1f5f9;flex-shrink:0; }
.thumb-ph { width:40px;height:40px;border-radius:10px;background:#f1f5f9;display:flex;align-items:center;justify-content:center;color:#cbd5e1;flex-shrink:0;font-size:14px; }

/* ── Badge ── */
.b { display:inline-flex;align-items:center;gap:5px;padding:3px 14px;border-radius:100px;font-size:11px;font-weight:600; }
.b-pub { background:#ecfdf5;color:#059669; }
.b-dft { background:#fffbeb;color:#d97706; }

/* ── Action Icon ── */
.ia { width:32px;height:32px;border-radius:10px;display:inline-flex;align-items:center;justify-content:center;color:#94a3b8;transition:all .15s;font-size:12px; }
.ia:hover { background:#f1f5f9;color:#ee4d2d; }

/* ── Anim ── */
@keyframes fi { 0%{opacity:0;transform:translateY(12px)} 100%{opacity:1;transform:translateY(0)} }
.an { animation:fi .4s ease forwards;opacity:0; }
.a1 { animation-delay:.05s; }
.a2 { animation-delay:.10s; }
.a3 { animation-delay:.15s; }
.a4 { animation-delay:.20s; }
</style>

<div class="space-y-5">

    <!-- ═══ HEADER ═══ -->
    <div class="an">
        <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Dashboard</h1>
        <p class="text-sm text-gray-400 mt-1">Selamat datang, <span class="font-semibold text-gray-600">{{ auth()->user()->name }}</span></p>
    </div>

    <!-- ═══ STATS ═══ 3 kolom -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="d-card d-stat an a1" style="color:#ee4d2d">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-widest">Total Produk</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ $totalProducts ?? 0 }}</p>
                </div>
                <div class="ico" style="background:color-mix(in srgb, currentColor 10%, transparent);color:inherit"><i class="fas fa-box"></i></div>
            </div>
            <div class="mt-4 flex gap-3 text-xs">
                <span class="flex items-center gap-1.5 font-medium" style="color:#059669"><span class="w-2 h-2 rounded-full" style="background:#059669"></span>{{ $publishedProducts ?? 0 }} Publis</span>
                <span class="flex items-center gap-1.5 font-medium" style="color:#d97706"><span class="w-2 h-2 rounded-full" style="background:#d97706"></span>{{ $draftProducts ?? 0 }} Draft</span>
            </div>
        </div>
        <div class="d-card d-stat an a2" style="color:#3b82f6">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-widest">Project</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ $totalProjects ?? 0 }}</p>
                </div>
                <div class="ico" style="background:color-mix(in srgb, currentColor 10%, transparent);color:inherit"><i class="fas fa-folder"></i></div>
            </div>
            <p class="mt-4 text-xs text-gray-400">Project aktif</p>
        </div>
        <div class="d-card d-stat an a3" style="color:#10b981">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-widest">Portfolio</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">Rp {{ number_format($portfolioValue ?? 0, 0, ',', '.') }}</p>
                </div>
                <div class="ico" style="background:color-mix(in srgb, currentColor 10%, transparent);color:inherit"><i class="fas fa-chart-line"></i></div>
            </div>
            <p class="mt-4 text-xs text-gray-400">Rata² Rp {{ number_format($averagePrice ?? 0, 0, ',', '.') }}</p>
        </div>
    </div>

    <!-- ═══ CHARTS ═══ 2 kolom -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
        <!-- Monthly Line Chart -->
        <div class="d-card an a2">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg flex items-center justify-center text-sm" style="background:#fef2ee;color:#ee4d2d"><i class="fas fa-chart-line"></i></div>
                <div>
                    <h3 class="text-sm font-semibold text-gray-800">Produk per Bulan</h3>
                    <p class="text-[11px] text-gray-400">6 bulan terakhir</p>
                </div>
            </div>
            <div class="p-5"><div id="mChart" style="width:100%;height:230px;"></div></div>
        </div>
        <!-- Status Donut -->
        <div class="d-card an a3">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg flex items-center justify-center text-sm" style="background:#fef2ee;color:#ee4d2d"><i class="fas fa-chart-pie"></i></div>
                <div>
                    <h3 class="text-sm font-semibold text-gray-800">Status Produk</h3>
                    <p class="text-[11px] text-gray-400">{{ $totalProducts ?? 0 }} total</p>
                </div>
            </div>
            <div class="p-5"><div id="sChart" style="width:100%;height:230px;"></div></div>
        </div>
    </div>

    <!-- ═══ QUICK + ACTIVITY ═══ -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
        <div class="d-card an a3">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg flex items-center justify-center text-sm" style="background:#fef2ee;color:#ee4d2d"><i class="fas fa-bolt"></i></div>
                <h3 class="text-sm font-semibold text-gray-800">Quick Actions</h3>
            </div>
            <div class="p-5 grid grid-cols-2 gap-3">
                <a href="{{ route('generator.quick') }}" class="flex items-center gap-3.5 p-3.5 rounded-xl transition-all hover:-translate-y-0.5" style="background:#fef2ee">
                    <div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center text-base shadow-sm" style="color:#ee4d2d"><i class="fas fa-magic"></i></div>
                    <div><p class="text-sm font-semibold text-gray-800">Quick</p><p class="text-[11px] text-gray-400">Generate cepat</p></div>
                </a>
                <a href="{{ route('generator.smart') }}" class="flex items-center gap-3.5 p-3.5 rounded-xl transition-all hover:-translate-y-0.5" style="background:#fef2ee">
                    <div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center text-base shadow-sm" style="color:#ee4d2d"><i class="fas fa-brain"></i></div>
                    <div><p class="text-sm font-semibold text-gray-800">Smart</p><p class="text-[11px] text-gray-400">Dengan analisis</p></div>
                </a>
                <a href="{{ route('products.index') }}" class="flex items-center gap-3.5 p-3.5 rounded-xl transition-all hover:-translate-y-0.5" style="background:#eff6ff">
                    <div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center text-base shadow-sm" style="color:#3b82f6"><i class="fas fa-cubes"></i></div>
                    <div><p class="text-sm font-semibold text-gray-800">Produk</p><p class="text-[11px] text-gray-400">Kelola katalog</p></div>
                </a>
                <a href="{{ route('products.export.page') }}" class="flex items-center gap-3.5 p-3.5 rounded-xl transition-all hover:-translate-y-0.5" style="background:#ecfdf5">
                    <div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center text-base shadow-sm" style="color:#10b981"><i class="fas fa-file-excel"></i></div>
                    <div><p class="text-sm font-semibold text-gray-800">Export</p><p class="text-[11px] text-gray-400">Ke Excel</p></div>
                </a>
            </div>
        </div>
        <div class="d-card an a4">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg flex items-center justify-center text-sm" style="background:#fef2ee;color:#ee4d2d"><i class="fas fa-history"></i></div>
                <h3 class="text-sm font-semibold text-gray-800">Aktivitas Terkini</h3>
            </div>
            <div class="p-5 max-h-[280px] overflow-y-auto space-y-1">
                @forelse($recentActivities ?? [] as $activity)
                <div class="flex items-start gap-3.5 py-2.5 border-b border-gray-50 last:border-0">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0" style="background:#fef2ee"><span class="w-2 h-2 rounded-full" style="background:#ee4d2d"></span></div>
                    <div class="min-w-0 flex-1">
                        <p class="text-sm text-gray-700 truncate font-medium">{{ $activity->description ?? 'Aktivitas' }}</p>
                        <p class="text-xs text-gray-400 mt-0.5">{{ $activity->created_at->diffForHumans() ?? '' }}</p>
                    </div>
                </div>
                @empty
                <div class="py-10 text-center text-gray-400">
                    <div class="w-12 h-12 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-3"><i class="fas fa-inbox text-lg text-gray-300"></i></div>
                    <p class="text-sm font-medium text-gray-500">Belum ada aktivitas</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- ═══ TABLE ═══ -->
    <div class="d-card an a4">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg flex items-center justify-center text-sm" style="background:#fef2ee;color:#ee4d2d"><i class="fas fa-boxes"></i></div>
                <div>
                    <h3 class="text-sm font-semibold text-gray-800">Produk Terbaru</h3>
                    <p class="text-[11px] text-gray-400">{{ $recentProducts->count() }} dari {{ $totalProducts ?? 0 }} produk</p>
                </div>
            </div>
            <a href="{{ route('products.index') }}" class="inline-flex items-center gap-1.5 px-4 py-2 text-xs font-semibold rounded-xl transition-colors" style="color:#ee4d2d;background:#fef2ee">Lihat Semua <i class="fas fa-arrow-right text-[10px]"></i></a>
        </div>
        <div class="tbl-wrap">
            <table class="tbl">
                <thead>
                    <tr><th>Produk</th><th>Kategori</th><th>Harga</th><th>Status</th><th>Dibuat</th><th></th></tr>
                </thead>
                <tbody>
                    @forelse($recentProducts ?? [] as $product)
                    <tr>
                        <td>
                            <a href="{{ route('products.show', $product->uuid) }}" class="flex items-center gap-3 group">
                                @php $img = $product->images->first(); @endphp
                                @if($img)<img src="{{ asset($img->path) }}" alt="" class="thumb" loading="lazy">
                                @else<div class="thumb-ph"><i class="fas fa-image"></i></div>@endif
                                <div>
                                    <p class="text-sm font-semibold text-gray-800 group-hover:text-orange-500 transition-colors">{{ \Illuminate\Support\Str::limit($product->name, 25) }}</p>
                                    @if($product->brand)<p class="text-xs text-gray-400 mt-0.5">{{ $product->brand }}</p>@endif
                                </div>
                            </a>
                        </td>
                        <td class="text-gray-500">{{ $product->category->name ?? '-' }}</td>
                        <td class="font-semibold text-gray-800">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                        <td>
                            @if($product->status === 'published')<span class="b b-pub"><span class="w-1.5 h-1.5 rounded-full" style="background:#059669"></span> Published</span>
                            @else<span class="b b-dft"><span class="w-1.5 h-1.5 rounded-full" style="background:#d97706"></span> Draft</span>@endif
                        </td>
                        <td class="text-gray-400 text-xs">{{ $product->created_at->diffForHumans() }}</td>
                        <td>
                            <div class="flex gap-0.5">
                                <a href="{{ route('products.show', $product->uuid) }}" class="ia" title="Lihat"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('products.edit', $product->uuid) }}" class="ia" title="Edit"><i class="fas fa-pen"></i></a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-20 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-20 h-20 rounded-full bg-gray-50 flex items-center justify-center mb-4"><i class="fas fa-box-open text-3xl text-gray-200"></i></div>
                                <p class="text-base font-semibold text-gray-500">Belum ada produk</p>
                                <p class="text-sm text-gray-400 mt-1 mb-5">Mulai dengan AI generator</p>
                                <a href="{{ route('generator.quick') }}" class="inline-flex items-center gap-2 px-6 py-2.5 text-white text-sm font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all" style="background:linear-gradient(135deg,#ee4d2d,#f97316)"><i class="fas fa-plus"></i> Buat Produk</a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // ─── Monthly LINE Chart ───
    var mEl = document.getElementById('mChart');
    if (mEl && typeof ApexCharts !== 'undefined') {
        var md = {!! json_encode($monthlyStats ?? []) !!};
        new ApexCharts(mEl, {
            chart: {
                type: 'line',
                height: 230,
                toolbar: { show: false },
                fontFamily: 'Inter, sans-serif',
                animations: { enabled: true, easing: 'easeinout', speed: 600, animateGradually: { enabled: true, delay: 100 } }
            },
            series: [{ name: 'Produk', data: md.map(function(d) { return d.products; }) }],
            xaxis: {
                categories: md.map(function(d) { return d.month; }),
                labels: { style: { fontSize: '11px', colors: '#94a3b8', fontWeight: 500 } },
                axisBorder: { show: false },
                axisTicks: { show: false }
            },
            yaxis: {
                labels: { style: { fontSize: '11px', colors: '#94a3b8' } },
                min: 0, forceNiceScale: true, tickAmount: 3
            },
            colors: ['#ee4d2d'],
            stroke: { curve: 'smooth', width: 3 },
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 0.6,
                    opacityFrom: 0.35,
                    opacityTo: 0.05,
                    stops: [0, 90, 100],
                    colorStops: [
                        { offset: 0, color: '#ee4d2d', opacity: 0.35 },
                        { offset: 60, color: '#f97316', opacity: 0.10 },
                        { offset: 100, color: '#f97316', opacity: 0.02 }
                    ]
                }
            },
            dataLabels: { enabled: false },
            grid: { borderColor: '#f1f5f9', strokeDashArray: 4, padding: { left: 0, right: 0 } },
            markers: { size: 5, strokeColors: '#fff', strokeWidth: 2, hover: { size: 7 } },
            tooltip: { y: { formatter: function(v) { return v + ' produk'; } }, style: { fontSize: '12px' }, theme: 'light' }
        }).render();
    }

    // ─── Status Donut ───
    var sEl = document.getElementById('sChart');
    if (sEl && typeof ApexCharts !== 'undefined') {
        var raw = {!! json_encode($statusChart ?? []) !!};
        var has = raw.some(function(d) { return d.value > 0; });
        if (!has) raw = [{ label: 'Belum ada data', value: 1, color: '#e2e8f0' }];

        new ApexCharts(sEl, {
            chart: { type: 'donut', height: 230, fontFamily: 'Inter, sans-serif', animations: { enabled: true, easing: 'easeout', speed: 500 } },
            series: raw.map(function(d) { return d.value; }),
            labels: raw.map(function(d) { return d.label; }),
            colors: raw.map(function(d) { return d.color; }),
            legend: { position: 'bottom', fontSize: '11px', fontWeight: 500, markers: { width: 10, height: 10, radius: 3 }, itemMargin: { horizontal: 12, vertical: 4 } },
            dataLabels: { enabled: true, formatter: function(v) { return Math.round(v) + '%'; }, style: { fontSize: '11px', fontWeight: 700, colors: ['#fff'] }, dropShadow: { enabled: true, top: 0, left: 0, blur: 3, color: '#000', opacity: 0.25 } },
            plotOptions: { pie: { donut: { size: '60%', labels: { show: true, name: { show: true, fontSize: '11px', offsetY: -8, color: '#64748b' }, value: { show: true, fontSize: '20px', fontWeight: 700, offsetY: 8, color: '#0f172a', formatter: function() { return raw.reduce(function(s, d) { return s + d.value; }, 0); } }, total: { show: true, showAlways: true, label: 'Total', fontSize: '10px', color: '#94a3b8', formatter: function() { return raw.reduce(function(s, d) { return s + d.value; }, 0); } } } } } },
            tooltip: { y: { formatter: function(v) { return v + ' produk'; } }, style: { fontSize: '12px' } },
            stroke: { width: 2, colors: ['#fff'] },
            states: { hover: { filter: { type: 'none' } } }
        }).render();
    }
});
</script>
@endpush
@endsection