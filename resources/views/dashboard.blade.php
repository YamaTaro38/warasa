@extends('layouts.dashboard')

@section('page-title', 'Analytics Dashboard')
@section('breadcrumb', 'Your product performance at a glance')

@section('content')
<!-- Stats Cards - Compact -->
<div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-6">
    <div class="bg-white border border-gray-200 rounded-lg p-3">
        <div class="flex items-center justify-between mb-1">
            <div class="w-7 h-7 bg-warasa-orange/10 rounded flex items-center justify-center">
                <i class="fas fa-boxes text-warasa-orange text-xs"></i>
            </div>
            <span class="text-xs font-medium text-green-600">+12%</span>
        </div>
        <div class="text-lg font-semibold text-gray-800">{{ number_format($totalProducts ?? 0) }}</div>
        <div class="text-xs text-gray-500 uppercase">Total</div>
    </div>
    <div class="bg-white border border-gray-200 rounded-lg p-3">
        <div class="flex items-center justify-between mb-1">
            <div class="w-7 h-7 bg-warasa-orange/10 rounded flex items-center justify-center">
                <i class="fas fa-globe text-warasa-orange text-xs"></i>
            </div>
            <span class="text-xs font-medium text-green-600">+8%</span>
        </div>
        <div class="text-lg font-semibold text-gray-800">{{ number_format($publishedProducts ?? 0) }}</div>
        <div class="text-xs text-gray-500 uppercase">Published</div>
    </div>
    <div class="bg-white border border-gray-200 rounded-lg p-3">
        <div class="flex items-center justify-between mb-1">
            <div class="w-7 h-7 bg-warasa-orange/10 rounded flex items-center justify-center">
                <i class="fas fa-pen-fancy text-warasa-orange text-xs"></i>
            </div>
            <span class="text-xs font-medium text-red-500">-3%</span>
        </div>
        <div class="text-lg font-semibold text-gray-800">{{ number_format($draftProducts ?? 0) }}</div>
        <div class="text-xs text-gray-500 uppercase">Draft</div>
    </div>
    <div class="bg-white border border-gray-200 rounded-lg p-3">
        <div class="flex items-center justify-between mb-1">
            <div class="w-7 h-7 bg-warasa-orange/10 rounded flex items-center justify-center">
                <i class="fas fa-folder text-warasa-orange text-xs"></i>
            </div>
            <span class="text-xs font-medium text-green-600">+5%</span>
        </div>
        <div class="text-lg font-semibold text-gray-800">{{ number_format($totalProjects ?? 0) }}</div>
        <div class="text-xs text-gray-500 uppercase">Projects</div>
    </div>
</div>

<!-- Row: Chart + Top Products -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-6">
    <div class="bg-white border border-gray-200 rounded-lg">
        <div class="px-4 py-3 border-b border-gray-200 flex items-center justify-between">
            <div class="text-xs font-semibold text-gray-700 flex items-center gap-2"><i class="fas fa-chart-line text-warasa-orange text-xs"></i> Performance</div>
            <select id="chartPeriod" class="text-xs border border-gray-200 rounded px-2 py-0.5 bg-white">
                <option value="7">7d</option>
                <option value="30" selected>30d</option>
                <option value="90">90d</option>
            </select>
        </div>
        <div class="p-3">
            <div id="performanceChart" style="height: 240px;"></div>
        </div>
    </div>

    <div class="bg-white border border-gray-200 rounded-lg">
        <div class="px-4 py-3 border-b border-gray-200 flex items-center justify-between">
            <div class="text-xs font-semibold text-gray-700 flex items-center gap-2"><i class="fas fa-trophy text-warasa-orange text-xs"></i> Top Products</div>
            <a href="{{ route('products.index') }}" class="text-warasa-orange text-xs hover:underline">View all →</a>
        </div>
        <div class="p-3">
            @forelse(($topProducts ?? []) as $product)
            <div class="flex items-center justify-between py-2 {{ !$loop->last ? 'border-b border-gray-100' : '' }}">
                <div class="flex items-center gap-2 min-w-0">
                    @php $img = optional($product->images)->first(); @endphp
                    @if($img)
                        <img src="{{ asset($img->path) }}" class="w-7 h-7 rounded object-cover flex-shrink-0" alt="{{ $product->name }}">
                    @else
                        <div class="w-7 h-7 bg-gray-100 rounded flex items-center justify-center flex-shrink-0"><i class="fas fa-box text-gray-400 text-xs"></i></div>
                    @endif
                    <div class="min-w-0">
                        <div class="text-xs font-medium truncate">{{ \Illuminate\Support\Str::limit($product->name, 20) }}</div>
                        <div class="text-xs text-gray-400 truncate">{{ $product->category->name ?? '-' }}</div>
                    </div>
                </div>
                <div class="text-right flex-shrink-0">
                    <div class="text-xs font-semibold">Rp {{ number_format($product->price,0,',','.') }}</div>
                    <div class="text-xs text-gray-400">Stok {{ $product->stock }}</div>
                </div>
            </div>
            @empty
            <div class="text-center text-gray-400 py-4 text-xs">No products yet</div>
            @endforelse
        </div>
    </div>
</div>

<!-- Livewire Product Table -->
<div class="bg-white border border-gray-200 rounded-lg mb-6">
    <div class="px-4 py-3 border-b border-gray-200">
        <div class="text-xs font-semibold text-gray-700 flex items-center gap-2"><i class="fas fa-table-list text-warasa-orange text-xs"></i> Recent Products</div>
    </div>
    <div class="p-0">
        @livewire('product-table')
    </div>
</div>

<!-- Bottom Grid: Activity + Insights + Quick Actions -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    <div class="bg-white border border-gray-200 rounded-lg">
        <div class="px-4 py-3 border-b border-gray-200">
            <div class="text-xs font-semibold text-gray-700 flex items-center gap-2"><i class="fas fa-history text-warasa-orange text-xs"></i> Activity</div>
        </div>
        <div class="p-3 space-y-2">
            <div class="flex items-center gap-2 text-xs"><div class="w-5 h-5 bg-warasa-orange/10 rounded flex items-center justify-center"><i class="fas fa-plus text-warasa-orange text-xs"></i></div><div class="flex-1 truncate"><span class="font-medium">Product added</span><div class="text-gray-400">2 min ago</div></div></div>
            <div class="flex items-center gap-2 text-xs"><div class="w-5 h-5 bg-warasa-orange/10 rounded flex items-center justify-center"><i class="fas fa-edit text-warasa-orange text-xs"></i></div><div class="flex-1 truncate"><span class="font-medium">Product updated</span><div class="text-gray-400">1 hour ago</div></div></div>
            <div class="flex items-center gap-2 text-xs"><div class="w-5 h-5 bg-warasa-orange/10 rounded flex items-center justify-center"><i class="fas fa-download text-warasa-orange text-xs"></i></div><div class="flex-1 truncate"><span class="font-medium">Export finished</span><div class="text-gray-400">3 hours ago</div></div></div>
        </div>
    </div>

    <div class="bg-white border border-gray-200 rounded-lg">
        <div class="px-4 py-3 border-b border-gray-200">
            <div class="text-xs font-semibold text-gray-700 flex items-center gap-2"><i class="fas fa-chart-simple text-warasa-orange text-xs"></i> Insights</div>
        </div>
        <div class="p-3 space-y-2">
            <div class="flex justify-between text-xs"><span class="text-gray-500">Portfolio</span><span class="font-medium">Rp {{ number_format($portfolioValue ?? 0,0,',','.') }}</span></div>
            <div class="flex justify-between text-xs"><span class="text-gray-500">Average</span><span class="font-medium">Rp {{ number_format($averagePrice ?? 0,0,',','.') }}</span></div>
            <div><div class="flex justify-between text-xs mb-1"><span>Publish rate</span><span>{{ $totalProducts > 0 ? round(($publishedProducts / $totalProducts)*100) : 0 }}%</span></div><div class="w-full bg-gray-200 rounded-full h-1"><div class="bg-warasa-orange h-1 rounded-full" style="width: {{ $totalProducts > 0 ? ($publishedProducts / $totalProducts)*100 : 0 }}%"></div></div></div>
        </div>
    </div>

    <div class="bg-white border border-gray-200 rounded-lg">
        <div class="px-4 py-3 border-b border-gray-200">
            <div class="text-xs font-semibold text-gray-700 flex items-center gap-2"><i class="fas fa-bolt text-warasa-orange text-xs"></i> Quick Actions</div>
        </div>
        <div class="p-2 space-y-1">
            <a href="{{ route('generator.quick') }}" class="flex items-center justify-between px-2 py-1.5 text-xs rounded hover:bg-gray-50"><div><i class="fas fa-magic text-warasa-orange mr-1.5"></i> Quick Generate</div><i class="fas fa-arrow-right text-gray-300 text-xs"></i></a>
            <a href="{{ route('generator.smart') }}" class="flex items-center justify-between px-2 py-1.5 text-xs rounded hover:bg-gray-50"><div><i class="fas fa-brain text-warasa-orange mr-1.5"></i> Smart Generate</div><i class="fas fa-arrow-right text-gray-300 text-xs"></i></a>
            <a href="{{ route('products.export.page') }}" class="flex items-center justify-between px-2 py-1.5 text-xs rounded hover:bg-gray-50"><div><i class="fas fa-file-excel text-warasa-orange mr-1.5"></i> Export</div><i class="fas fa-arrow-right text-gray-300 text-xs"></i></a>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var options = {
            series: [{ name: 'Products', data: [12,19,15,28,24,35,42,48,52,58,64,72,78,85,92] },{ name: 'Published', data: [8,14,12,22,20,28,34,38,42,48,52,58,62,68,75] }],
            chart: { type: 'area', height: 240, toolbar: { show: false }, fontFamily: 'Inter' },
            colors: ['#ee4d2d', '#98a2b3'],
            fill: { type: 'gradient', gradient: { opacityFrom: 0.3, opacityTo: 0.05 } },
            stroke: { curve: 'smooth', width: 2 },
            grid: { borderColor: '#e4e7ec' },
            xaxis: { categories: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec','Jan','Feb','Mar'] }
        };
        var chart = new ApexCharts(document.querySelector("#performanceChart"), options);
        chart.render();
    });
</script>
@endsection