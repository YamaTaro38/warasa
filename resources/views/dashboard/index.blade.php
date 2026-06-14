@extends('layouts.dashboard')

@section('content')
<div>
    <!-- Header -->
    <div class="mb-4">
        <h1 class="text-lg font-semibold text-gray-800">Dashboard</h1>
        <p class="text-xs text-gray-500 mt-0.5">Selamat datang kembali, {{ auth()->user()->name }}!</p>
    </div>
    
    <!-- Stats Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-header">
                <div>
                    <div class="stat-value">{{ $totalProducts ?? 0 }}</div>
                    <div class="stat-label">Total Produk</div>
                </div>
                <div class="stat-icon"><i class="fas fa-box"></i></div>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-header">
                <div>
                    <div class="stat-value">{{ $totalProjects ?? 0 }}</div>
                    <div class="stat-label">Total Project</div>
                </div>
                <div class="stat-icon"><i class="fas fa-folder"></i></div>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-header">
                <div>
                    <div class="stat-value">Rp {{ number_format($portfolioValue ?? 0, 0, ',', '.') }}</div>
                    <div class="stat-label">Nilai Portofolio</div>
                </div>
                <div class="stat-icon"><i class="fas fa-wallet"></i></div>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-header">
                <div>
                    <div class="stat-value">Rp {{ number_format($averagePrice ?? 0, 0, ',', '.') }}</div>
                    <div class="stat-label">Rata-rata Harga</div>
                </div>
                <div class="stat-icon"><i class="fas fa-tag"></i></div>
            </div>
        </div>
    </div>
    
    <!-- Charts Row -->
    <div class="grid-2">
        <!-- Line Chart: Products per Month -->
        <div class="card">
            <div class="card-header">
                <div class="card-title"><i class="fas fa-chart-line"></i> Produk per Bulan</div>
            </div>
            <div class="card-body">
                <div id="lineChart" style="min-height: 260px;"></div>
            </div>
        </div>
        
        <!-- Donut Chart: Published vs Draft -->
        <div class="card">
            <div class="card-header">
                <div class="card-title"><i class="fas fa-chart-pie"></i> Status Produk</div>
            </div>
            <div class="card-body">
                <div id="donutChart" style="min-height: 260px;"></div>
            </div>
        </div>
    </div>
    
    <!-- Quick Actions + Recent Activity -->
    <div class="grid-2">
        <div class="card">
            <div class="card-header">
                <div class="card-title"><i class="fas fa-bolt"></i> Quick Actions</div>
            </div>
            <div class="card-body">
                <div class="grid grid-cols-2 gap-2">
                    <a href="{{ route('generator') }}" class="flex items-center gap-2 p-2.5 rounded-lg bg-warasa-orange/5 hover:bg-warasa-orange/10 transition text-gray-700 text-xs">
                        <i class="fas fa-magic text-warasa-orange text-xs"></i>
                        <span>Generate Produk</span>
                    </a>
                    <a href="{{ route('projects.create') }}" class="flex items-center gap-2 p-2.5 rounded-lg bg-warasa-orange/5 hover:bg-warasa-orange/10 transition text-gray-700 text-xs">
                        <i class="fas fa-plus-circle text-warasa-orange text-xs"></i>
                        <span>Buat Project</span>
                    </a>
                    <a href="{{ route('chatbot') }}" class="flex items-center gap-2 p-2.5 rounded-lg bg-warasa-orange/5 hover:bg-warasa-orange/10 transition text-gray-700 text-xs">
                        <i class="fas fa-robot text-warasa-orange text-xs"></i>
                        <span>Chat AI</span>
                    </a>
                    <a href="{{ route('products.index') }}" class="flex items-center gap-2 p-2.5 rounded-lg bg-warasa-orange/5 hover:bg-warasa-orange/10 transition text-gray-700 text-xs">
                        <i class="fas fa-list text-warasa-orange text-xs"></i>
                        <span>Lihat Produk</span>
                    </a>
                </div>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header">
                <div class="card-title"><i class="fas fa-history"></i> Aktivitas Terkini</div>
            </div>
            <div class="card-body">
                <div class="space-y-2 max-h-48 overflow-y-auto">
                    @forelse($recentProducts ?? [] as $product)
                    <div class="flex items-center gap-2 text-xs py-1.5 border-b border-gray-100 last:border-0">
                        <i class="fas fa-circle text-warasa-orange text-[6px]"></i>
                        <span class="text-gray-600 flex-1">Produk <strong>{{ $product->name }}</strong> ditambahkan</span>
                        <span class="text-gray-400 text-[10px]">{{ $product->created_at->diffForHumans() }}</span>
                    </div>
                    @empty
                    <p class="text-gray-500 text-center text-xs py-3">Belum ada aktivitas</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
    
    <!-- Recent Products Table -->
    <div class="card">
        <div class="card-header">
            <div class="card-title"><i class="fas fa-cubes"></i> Produk Terbaru</div>
            <a href="{{ route('products.index') }}" class="text-warasa-orange text-xs hover:underline font-medium">Lihat semua →</a>
        </div>
        <div class="table-container">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Nama Produk</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentProducts ?? [] as $product)
                    <tr>
                        <td>
                            <div class="flex items-center gap-2">
                                @if($product->images && $product->images->count())
                                <img src="{{ $product->images->first()->url ?? $product->images->first()->path }}" alt="" class="w-7 h-7 rounded object-cover">
                                @else
                                <div class="w-7 h-7 rounded bg-gray-100 flex items-center justify-center">
                                    <i class="fas fa-image text-gray-400 text-[10px]"></i>
                                </div>
                                @endif
                                <span class="font-medium text-gray-800">{{ $product->name }}</span>
                            </div>
                        </td>
                        <td class="font-medium text-gray-800">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                        <td class="text-gray-600">{{ $product->stock ?? 0 }}</td>
                        <td>
                            @if($product->status === 'published')
                            <span class="badge badge-success"><i class="fas fa-check-circle"></i> Published</span>
                            @elseif($product->status === 'draft')
                            <span class="badge badge-warning"><i class="fas fa-edit"></i> Draft</span>
                            @else
                            <span class="badge badge-info"><i class="fas fa-info-circle"></i> {{ ucfirst($product->status) }}</span>
                            @endif
                        </td>
                        <td class="text-gray-500">{{ $product->created_at->diffForHumans() }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-6 text-center text-gray-500">
                            <div class="flex flex-col items-center gap-2">
                                <i class="fas fa-box-open text-gray-300 text-2xl"></i>
                                <span>Belum ada produk. Buat produk pertama Anda!</span>
                                <a href="{{ route('generator') }}" class="btn btn-primary btn-sm mt-1">
                                    <i class="fas fa-magic"></i> Generate Sekarang
                                </a>
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
    // Line Chart: Products per Month
    const lineOptions = {
        series: [{
            name: 'Produk',
            data: {!! json_encode($chartData ?? [0,0,0,0,0,0]) !!}
        }],
        chart: {
            type: 'area',
            height: 260,
            toolbar: { show: false },
            fontFamily: 'Inter, sans-serif',
            sparkline: { enabled: false }
        },
        colors: ['#ee4d2d'],
        stroke: { curve: 'smooth', width: 2.5 },
        fill: {
            type: 'gradient',
            gradient: {
                shadeIntensity: 1,
                opacityFrom: 0.3,
                opacityTo: 0.05,
                stops: [0, 90, 100]
            }
        },
        xaxis: {
            categories: {!! json_encode($chartLabels ?? []) !!},
            labels: { style: { fontSize: '10px', colors: '#94a3b8' } },
            axisBorder: { show: false },
            axisTicks: { show: false }
        },
        yaxis: {
            labels: { style: { fontSize: '10px', colors: '#94a3b8' }, minWidth: 30 },
            min: 0,
            tickAmount: 4
        },
        grid: {
            borderColor: '#f1f5f9',
            strokeDashArray: 4,
            xaxis: { lines: { show: false } },
            yaxis: { lines: { show: true } }
        },
        dataLabels: { enabled: false },
        tooltip: {
            theme: 'light',
            style: { fontSize: '12px' },
            y: { formatter: (val) => val + ' produk' }
        }
    };
    const lineChart = new ApexCharts(document.querySelector('#lineChart'), lineOptions);
    lineChart.render();

    // Donut Chart: Published vs Draft
    const donutOptions = {
        series: {!! json_encode($donutData ?? [0, 0]) !!},
        chart: {
            type: 'donut',
            height: 260,
            fontFamily: 'Inter, sans-serif'
        },
        colors: ['#10b981', '#f59e0b'],
        labels: ['Published', 'Draft'],
        plotOptions: {
            pie: {
                donut: {
                    size: '65%',
                    labels: {
                        show: true,
                        name: { show: true, fontSize: '11px', color: '#64748b' },
                        value: { show: true, fontSize: '18px', fontWeight: 700, color: '#1e293b' },
                        total: { show: true, label: 'Total', fontSize: '11px', color: '#64748b' }
                    }
                }
            }
        },
        stroke: { width: 0 },
        dataLabels: { enabled: false },
        legend: {
            position: 'bottom',
            fontSize: '11px',
            fontWeight: 500,
            markers: { width: 8, height: 8, radius: 2 },
            itemMargin: { horizontal: 12 }
        },
        tooltip: {
            theme: 'light',
            style: { fontSize: '12px' },
            y: { formatter: (val) => val + ' produk' }
        }
    };
    const donutChart = new ApexCharts(document.querySelector('#donutChart'), donutOptions);
    donutChart.render();
});
</script>
@endpush
@endsection