@extends('layouts.app')

@section('content')
<!-- Hero Section - Fluid Container (Full Width) -->
<div class="w-full bg-gradient-to-r from-warasa-orange to-warasa-orange-dark">
    <div class="w-full px-0 sm:px-0 md:px-0">
        <div class="relative min-h-[90vh] flex items-center">
            <!-- Background Image -->
            <div class="absolute inset-0 w-full h-full">
                <img src="https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w=1920&h=1080&fit=crop" 
                     alt="Hero Background" 
                     class="w-full h-full object-cover opacity-30">
            </div>
            
            <!-- Content -->
            <div class="container mx-auto relative z-10 w-full py-16 md:py-24">
                <div class="mx-auto px-4 md:px-8">
                    <div class="flex flex-col lg:flex-row items-center justify-between gap-8 lg:gap-12">
                        <!-- Left Content -->
                        <div class="flex-1 text-center lg:text-left">
                            <div class="inline-flex items-center gap-2 bg-white/20 backdrop-blur-sm rounded-full px-4 py-1.5 mb-6">
                                <i class="fas fa-robot text-white text-sm"></i>
                                <span class="text-sm text-white font-medium">AI-Powered E-Commerce Assistant</span>
                            </div>
                            
                            <h1 class="text-4xl sm:text-5xl md:text-6xl font-bold font-poppins mb-6 text-white leading-tight">
                                Jualan Santai,<br>
                                <span class="text-yellow-300">Cuan Maksimal</span>
                            </h1>
                            
                            <p class="text-base md:text-lg text-white/90 mb-8 max-w-lg mx-auto lg:mx-0 leading-relaxed">
                                Generate produk, edit gambar, dan ekspor ke Shopee dengan bantuan AI. 
                                Semua dalam satu platform <span class="font-semibold text-yellow-300">100% GRATIS!</span>
                            </p>
                            
                            <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                                @auth
                                    <a href="{{ route('dashboard') }}" class="bg-white text-warasa-orange hover:bg-gray-100 font-semibold py-3 px-8 rounded-xl transition-all duration-300 inline-flex items-center justify-center gap-2 shadow-lg">
                                        <i class="fas fa-tachometer-alt"></i> Dashboard
                                    </a>
                                @else
                                    <a href="{{ route('register') }}" class="bg-white text-warasa-orange hover:bg-gray-100 font-semibold py-3 px-8 rounded-xl transition-all duration-300 inline-flex items-center justify-center gap-2 shadow-lg">
                                        <i class="fas fa-rocket"></i> Mulai Gratis
                                    </a>
                                    <a href="{{ route('login') }}" class="border-2 border-white text-white hover:bg-white/10 font-semibold py-3 px-8 rounded-xl transition-all duration-300 inline-flex items-center justify-center gap-2 backdrop-blur-sm">
                                        <i class="fas fa-sign-in-alt"></i> Login
                                    </a>
                                @endauth
                            </div>
                            
                            <!-- Stats -->
                            <div class="grid grid-cols-3 gap-4 mt-12 max-w-md mx-auto lg:mx-0">
                                <div class="bg-white/15 backdrop-blur-md rounded-2xl p-4 text-center">
                                    <p class="text-2xl md:text-3xl font-bold text-white">10K+</p>
                                    <p class="text-xs text-white/80">Pengguna Aktif</p>
                                </div>
                                <div class="bg-white/15 backdrop-blur-md rounded-2xl p-4 text-center">
                                    <p class="text-2xl md:text-3xl font-bold text-white">100K+</p>
                                    <p class="text-xs text-white/80">Produk Generated</p>
                                </div>
                                <div class="bg-white/15 backdrop-blur-md rounded-2xl p-4 text-center">
                                    <p class="text-2xl md:text-3xl font-bold text-white">98%</p>
                                    <p class="text-xs text-white/80">Kepuasan</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Right Content -->
                        <div class="flex-1 flex justify-center">
                            <div class="relative animate-float">
                                <div class="w-64 h-64 sm:w-80 sm:h-80 md:w-96 md:h-96 rounded-2xl overflow-hidden shadow-2xl ring-4 ring-white/30 bg-white/10 backdrop-blur-sm">
                                    <img src="https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w=500&h=500&fit=crop" 
                                         alt="Online Shopping" 
                                         class="w-full h-full object-cover">
                                </div>
                                
                                <div class="absolute -top-6 -right-6 bg-white rounded-2xl p-3 shadow-xl animate-float" style="animation-delay: 0.5s">
                                    <div class="flex items-center gap-2">
                                        <div class="w-8 h-8 bg-warasa-orange/10 rounded-full flex items-center justify-center">
                                            <i class="fas fa-magic text-warasa-orange"></i>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-500">AI Powered</p>
                                            <p class="text-sm font-semibold text-gray-800">Smart Generation</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="absolute -bottom-6 -left-6 bg-white rounded-2xl p-3 shadow-xl animate-float" style="animation-delay: 1s">
                                    <div class="flex items-center gap-2">
                                        <div class="w-8 h-8 bg-green-500/10 rounded-full flex items-center justify-center">
                                            <i class="fas fa-chart-line text-green-500"></i>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-500">Increased Sales</p>
                                            <p class="text-sm font-semibold text-gray-800">+47% Penjualan</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Features Section -->
<div class="w-full bg-gray-50 dark:bg-dark-bg py-16 md:py-20">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold font-poppins mb-4 text-gray-900 dark:text-white">Fitur Unggulan</h2>
            <p class="text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">Semua yang Anda butuhkan untuk jualan online ada di sini</p>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach([
                ['icon' => 'fa-magic', 'title' => 'Product Generator', 'desc' => 'Generate judul, deskripsi, keywords, dan gambar produk dengan AI canggih'],
                ['icon' => 'fa-image', 'title' => 'Image Enhancement', 'desc' => 'Hapus background, resize, watermark, dan edit gambar dengan mudah'],
                ['icon' => 'fa-robot', 'title' => 'AI Chatbot', 'desc' => 'Konsultasi bisnis dan dapatkan saran strategi dari AI 24/7'],
                ['icon' => 'fa-file-excel', 'title' => 'Export Shopee', 'desc' => 'Ekspor produk ke Excel sesuai template Shopee untuk upload massal'],
                ['icon' => 'fa-chart-line', 'title' => 'Analytics Dashboard', 'desc' => 'Pantau performa produk dan dapatkan insight bisnis real-time'],
                ['icon' => 'fa-folder', 'title' => 'Manajemen Project', 'desc' => 'Kelompokkan produk dalam project untuk organisasi yang lebih baik'],
            ] as $feature)
            <div class="bg-white dark:bg-dark-card rounded-xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-gray-100 dark:border-dark-border">
                <div class="w-14 h-14 rounded-xl bg-warasa-orange/10 flex items-center justify-center mb-4">
                    <i class="fas {{ $feature['icon'] }} text-warasa-orange text-2xl"></i>
                </div>
                <h3 class="text-xl font-semibold mb-2 text-gray-900 dark:text-white">{{ $feature['title'] }}</h3>
                <p class="text-gray-600 dark:text-gray-400 leading-relaxed">{{ $feature['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</div>

<!-- How It Works Section -->
<div class="w-full bg-white dark:bg-dark-card py-16 md:py-20">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold font-poppins mb-4 text-gray-900 dark:text-white">Cara Kerja</h2>
            <p class="text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">Mudah, cepat, dan efisien</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center">
                <div class="w-20 h-20 bg-warasa-orange/20 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-2xl font-bold text-warasa-orange">1</span>
                </div>
                <h3 class="text-lg font-semibold mb-2 text-gray-900 dark:text-white">Input Produk</h3>
                <p class="text-gray-600 dark:text-gray-400">Upload file CSV atau input manual produk Anda</p>
            </div>
            <div class="text-center">
                <div class="w-20 h-20 bg-warasa-orange/20 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-2xl font-bold text-warasa-orange">2</span>
                </div>
                <h3 class="text-lg font-semibold mb-2 text-gray-900 dark:text-white">Generate dengan AI</h3>
                <p class="text-gray-600 dark:text-gray-400">AI akan generate judul, deskripsi, dan gambar</p>
            </div>
            <div class="text-center">
                <div class="w-20 h-20 bg-warasa-orange/20 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-2xl font-bold text-warasa-orange">3</span>
                </div>
                <h3 class="text-lg font-semibold mb-2 text-gray-900 dark:text-white">Export & Jual</h3>
                <p class="text-gray-600 dark:text-gray-400">Ekspor ke Excel dan upload ke Shopee</p>
            </div>
        </div>
    </div>
</div>

<!-- Testimonials Section -->
<div class="w-full bg-gray-50 dark:bg-dark-bg py-16 md:py-20">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold font-poppins mb-4 text-gray-900 dark:text-white">Apa Kata Mereka?</h2>
            <p class="text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">Lebih dari 10.000+ penjual online percaya dengan Warasa</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white dark:bg-dark-card rounded-xl p-6 shadow-lg border border-gray-100 dark:border-dark-border">
                <div class="flex items-center gap-3 mb-4">
                    <img src="https://randomuser.me/api/portraits/women/1.jpg" alt="User" class="w-12 h-12 rounded-full object-cover">
                    <div>
                        <h4 class="font-semibold text-gray-900 dark:text-white">Sarah Dewi</h4>
                        <p class="text-xs text-gray-500">Penjual Fashion</p>
                    </div>
                </div>
                <p class="text-gray-600 dark:text-gray-400 italic">"Warasa membantu saya menghemat waktu 80% untuk membuat deskripsi produk. Highly recommended!"</p>
                <div class="flex items-center gap-1 mt-3">
                    <i class="fas fa-star text-yellow-400"></i>
                    <i class="fas fa-star text-yellow-400"></i>
                    <i class="fas fa-star text-yellow-400"></i>
                    <i class="fas fa-star text-yellow-400"></i>
                    <i class="fas fa-star text-yellow-400"></i>
                </div>
            </div>
            <div class="bg-white dark:bg-dark-card rounded-xl p-6 shadow-lg border border-gray-100 dark:border-dark-border">
                <div class="flex items-center gap-3 mb-4">
                    <img src="https://randomuser.me/api/portraits/men/2.jpg" alt="User" class="w-12 h-12 rounded-full object-cover">
                    <div>
                        <h4 class="font-semibold text-gray-900 dark:text-white">Andi Wijaya</h4>
                        <p class="text-xs text-gray-500">Dropshipper</p>
                    </div>
                </div>
                <p class="text-gray-600 dark:text-gray-400 italic">"Generator gambarnya luar biasa! Bisa generate banyak variasi dalam waktu singkat."</p>
                <div class="flex items-center gap-1 mt-3">
                    <i class="fas fa-star text-yellow-400"></i>
                    <i class="fas fa-star text-yellow-400"></i>
                    <i class="fas fa-star text-yellow-400"></i>
                    <i class="fas fa-star text-yellow-400"></i>
                    <i class="fas fa-star text-yellow-400"></i>
                </div>
            </div>
            <div class="bg-white dark:bg-dark-card rounded-xl p-6 shadow-lg border border-gray-100 dark:border-dark-border">
                <div class="flex items-center gap-3 mb-4">
                    <img src="https://randomuser.me/api/portraits/women/3.jpg" alt="User" class="w-12 h-12 rounded-full object-cover">
                    <div>
                        <h4 class="font-semibold text-gray-900 dark:text-white">Rina Kartika</h4>
                        <p class="text-xs text-gray-500">UMKM Pemula</p>
                    </div>
                </div>
                <p class="text-gray-600 dark:text-gray-400 italic">"Gratis dan mudah digunakan! Fitur export ke Shopee sangat membantu sekali."</p>
                <div class="flex items-center gap-1 mt-3">
                    <i class="fas fa-star text-yellow-400"></i>
                    <i class="fas fa-star text-yellow-400"></i>
                    <i class="fas fa-star text-yellow-400"></i>
                    <i class="fas fa-star text-yellow-400"></i>
                    <i class="fas fa-star text-yellow-400"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- CTA Section -->
<div class="w-full bg-warasa-orange py-16 md:py-20">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-3xl md:text-4xl font-bold mb-4 text-white">Siap Meningkatkan Penjualan?</h2>
        <p class="text-white/80 mb-8 max-w-2xl mx-auto">Bergabunglah dengan ribuan penjual online yang sudah menggunakan Warasa</p>
        @auth
            <a href="{{ route('dashboard') }}" class="bg-white text-warasa-orange hover:bg-gray-100 font-semibold py-3 px-8 rounded-xl transition-all duration-300 inline-flex items-center gap-2 shadow-lg">
                <i class="fas fa-tachometer-alt"></i> Go to Dashboard
            </a>
        @else
            <a href="{{ route('register') }}" class="bg-white text-warasa-orange hover:bg-gray-100 font-semibold py-3 px-8 rounded-xl transition-all duration-300 inline-flex items-center gap-2 shadow-lg">
                <i class="fas fa-user-plus"></i> Daftar Sekarang
            </a>
        @endauth
    </div>
</div>
@endsection