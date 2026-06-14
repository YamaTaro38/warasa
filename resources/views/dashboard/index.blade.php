@extends('layouts.dashboard')

@section('content')
<div>
    <!-- Header -->
    <div class="mb-4">
        <h1 class="text-lg font-semibold text-gray-800">Dashboard</h1>
        <p class="text-xs text-gray-500 mt-0.5">Selamat datang kembali, {{ auth()->user()->name }}!</p>
    </div>
    
    <!-- Stats Cards - Grid rapi tanpa margin berlebih -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 mb-4">
        <div class="bg-white rounded-lg p-3 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-500">Total Produk</p>
                    <p class="text-xl font-bold text-gray-800">{{ $totalProducts ?? 0 }}</p>
                </div>
                <div class="w-8 h-8 rounded-lg bg-warasa-orange/10 flex items-center justify-center">
                    <i class="fas fa-box text-warasa-orange text-sm"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg p-3 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-500">Total Project</p>
                    <p class="text-xl font-bold text-gray-800">{{ $totalProjects ?? 0 }}</p>
                </div>
                <div class="w-8 h-8 rounded-lg bg-warasa-orange/10 flex items-center justify-center">
                    <i class="fas fa-folder text-warasa-orange text-sm"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg p-3 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-500">AI Generations</p>
                    <p class="text-xl font-bold text-gray-800">{{ $totalGenerations ?? 0 }}</p>
                </div>
                <div class="w-8 h-8 rounded-lg bg-warasa-orange/10 flex items-center justify-center">
                    <i class="fas fa-magic text-warasa-orange text-sm"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg p-3 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-500">Chat Sessions</p>
                    <p class="text-xl font-bold text-gray-800">{{ $totalChats ?? 0 }}</p>
                </div>
                <div class="w-8 h-8 rounded-lg bg-warasa-orange/10 flex items-center justify-center">
                    <i class="fas fa-comments text-warasa-orange text-sm"></i>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Two Column Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-3 mb-4">
        <!-- Quick Actions -->
        <div class="bg-white rounded-lg p-3 shadow-sm border border-gray-100">
            <h3 class="text-sm font-semibold text-gray-800 mb-2 flex items-center gap-1.5">
                <i class="fas fa-bolt text-warasa-orange text-xs"></i>
                Quick Actions
            </h3>
            <div class="grid grid-cols-2 gap-2">
                <a href="{{ route('generator') }}" class="flex items-center gap-2 p-2 rounded-lg bg-warasa-orange/5 hover:bg-warasa-orange/10 transition text-gray-700 text-xs">
                    <i class="fas fa-magic text-warasa-orange text-xs"></i>
                    <span>Generate Produk</span>
                </a>
                <a href="{{ route('projects.create') }}" class="flex items-center gap-2 p-2 rounded-lg bg-warasa-orange/5 hover:bg-warasa-orange/10 transition text-gray-700 text-xs">
                    <i class="fas fa-plus-circle text-warasa-orange text-xs"></i>
                    <span>Buat Project</span>
                </a>
                <a href="{{ route('chatbot') }}" class="flex items-center gap-2 p-2 rounded-lg bg-warasa-orange/5 hover:bg-warasa-orange/10 transition text-gray-700 text-xs">
                    <i class="fas fa-robot text-warasa-orange text-xs"></i>
                    <span>Chat AI</span>
                </a>
                <a href="{{ route('products.index') }}" class="flex items-center gap-2 p-2 rounded-lg bg-warasa-orange/5 hover:bg-warasa-orange/10 transition text-gray-700 text-xs">
                    <i class="fas fa-list text-warasa-orange text-xs"></i>
                    <span>Lihat Produk</span>
                </a>
            </div>
        </div>
        
        <!-- Recent Activity -->
        <div class="bg-white rounded-lg p-3 shadow-sm border border-gray-100">
            <h3 class="text-sm font-semibold text-gray-800 mb-2 flex items-center gap-1.5">
                <i class="fas fa-history text-warasa-orange text-xs"></i>
                Aktivitas Terkini
            </h3>
            <div class="space-y-2 max-h-48 overflow-y-auto">
                @forelse($recentActivities ?? [] as $activity)
                <div class="flex items-center gap-2 text-xs py-1.5 border-b border-gray-100 last:border-0">
                    <i class="fas fa-circle text-warasa-orange text-[6px]"></i>
                    <span class="text-gray-600 flex-1">{{ $activity->description ?? 'Activity' }}</span>
                    <span class="text-gray-400 text-[10px]">{{ $activity->created_at->diffForHumans() ?? 'Just now' }}</span>
                </div>
                @empty
                <p class="text-gray-500 text-center text-xs py-3">Belum ada aktivitas</p>
                @endforelse
            </div>
        </div>
    </div>
    
    <!-- Recent Products -->
    <div class="bg-white rounded-lg p-3 shadow-sm border border-gray-100">
        <div class="flex justify-between items-center mb-2">
            <h3 class="text-sm font-semibold text-gray-800 flex items-center gap-1.5">
                <i class="fas fa-boxes text-warasa-orange text-xs"></i>
                Produk Terbaru
            </h3>
            <a href="{{ route('products.index') }}" class="text-warasa-orange text-xs hover:underline">Lihat semua →</a>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-xs">
                <thead class="border-b border-gray-200">
                    <tr class="text-left text-gray-500">
                        <th class="pb-2 font-medium">Nama Produk</th>
                        <th class="pb-2 font-medium">Harga</th>
                        <th class="pb-2 font-medium">Status</th>
                        <th class="pb-2 font-medium">Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentProducts ?? [] as $product)
                    <tr class="border-b border-gray-100">
                        <td class="py-2 text-gray-700">{{ $product->name }} </td>
                        <td class="py-2 text-gray-700">Rp {{ number_format($product->price, 0, ',', '.') }} </td>
                        <td class="py-2">
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-medium {{ $product->status === 'published' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                {{ ucfirst($product->status) }}
                            </span>
                        </td>
                        <td class="py-2 text-gray-500">{{ $product->created_at->diffForHumans() }} </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="py-4 text-center text-gray-500">Belum ada produk. Buat produk pertama Anda!</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection