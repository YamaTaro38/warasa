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
                                Generate produk, kalkulasi ROAS & biaya Shopee, analisis kompetitor, dan ekspor ke Shopee dengan bantuan AI. 
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
                            <div class="grid grid-cols-4 gap-4 mt-12 max-w-lg mx-auto lg:mx-0">
                                <div class="bg-white/15 backdrop-blur-md rounded-2xl p-4 text-center">
                                    <p class="text-2xl md:text-3xl font-bold text-white">10K+</p>
                                    <p class="text-xs text-white/80">Pengguna Aktif</p>
                                </div>
                                <div class="bg-white/15 backdrop-blur-md rounded-2xl p-4 text-center">
                                    <p class="text-2xl md:text-3xl font-bold text-white">100K+</p>
                                    <p class="text-xs text-white/80">Produk Generated</p>
                                </div>
                                <div class="bg-white/15 backdrop-blur-md rounded-2xl p-4 text-center">
                                    <p class="text-2xl md:text-3xl font-bold text-white">50K+</p>
                                    <p class="text-xs text-white/80">Export Terkirim</p>
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
<div class="w-full bg-gray-50 py-16 md:py-20">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold font-poppins mb-4 text-gray-900">Fitur Unggulan</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">Semua yang Anda butuhkan untuk jualan online ada di sini</p>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach([
                ['icon' => 'fa-magic', 'color' => 'text-purple-500', 'title' => 'Product Generator', 'desc' => 'Generate judul, deskripsi, keywords, dan gambar produk dengan AI canggih'],
                ['icon' => 'fa-brain', 'color' => 'text-blue-500', 'title' => 'Smart Generation', 'desc' => 'Generate produk massal dari file CSV dengan sekali klik menggunakan AI'],
                ['icon' => 'fa-file-excel', 'color' => 'text-green-500', 'title' => 'Export Shopee', 'desc' => 'Ekspor produk ke Excel sesuai template Shopee untuk upload massal'],
                ['icon' => 'fa-calculator', 'color' => 'text-orange-500', 'title' => 'ROAS Calculator', 'desc' => 'Hitung Return on Advertising Spend untuk optimasi iklan Anda'],
                ['icon' => 'fa-coins', 'color' => 'text-yellow-500', 'title' => 'Shopee Fee Kalkulator', 'desc' => 'Hitung biaya provisi, diskon, dan estimasi pendapatan bersih di Shopee'],
                ['icon' => 'fa-chart-line', 'color' => 'text-red-500', 'title' => 'Analytics Dashboard', 'desc' => 'Pantau performa produk dan dapatkan insight bisnis real-time'],
                ['icon' => 'fa-users-between-lines', 'color' => 'text-violet-500', 'title' => 'Competitor Analysis', 'desc' => 'Analisis kompetitor dan dapatkan rekomendasi harga & strategi'],
                ['icon' => 'fa-magnifying-glass-chart', 'color' => 'text-emerald-500', 'title' => 'SEO Score', 'desc' => 'Cek skor SEO produk dan optimasi agar mudah ditemukan pembeli'],
                ['icon' => 'fa-database', 'color' => 'text-sky-500', 'title' => 'Bulk Export', 'desc' => 'Export multi-produk sekaligus dengan format Excel siap upload'],
                ['icon' => 'fa-tags', 'color' => 'text-rose-500', 'title' => 'Kategori Produk', 'desc' => 'Kelola kategori produk untuk memudahkan pencarian dan filter'],
                ['icon' => 'fa-book', 'color' => 'text-amber-500', 'title' => 'Dokumentasi', 'desc' => 'Panduan lengkap penggunaan semua fitur Warasa'],
            ] as $feature)
            <div class="bg-white rounded-xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-gray-100">
                <div class="w-14 h-14 rounded-xl bg-warasa-orange/10 flex items-center justify-center mb-4">
                    <i class="fas {{ $feature['icon'] }} {{ $feature['color'] }} text-2xl"></i>
                </div>
                <h3 class="text-xl font-semibold mb-2 text-gray-900">{{ $feature['title'] }}</h3>
                <p class="text-gray-600 leading-relaxed">{{ $feature['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</div>

<!-- How It Works Section -->
<div class="w-full bg-white py-16 md:py-20">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold font-poppins mb-4 text-gray-900">Cara Kerja</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">Mudah, cepat, dan efisien</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center">
                <div class="w-20 h-20 bg-warasa-orange/20 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-upload text-3xl text-warasa-orange"></i>
                </div>
                <h3 class="text-lg font-semibold mb-2 text-gray-900">Input Produk</h3>
                <p class="text-gray-600">Upload file CSV atau input manual produk Anda</p>
            </div>
            <div class="text-center">
                <div class="w-20 h-20 bg-warasa-orange/20 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-wand-magic-sparkles text-3xl text-warasa-orange"></i>
                </div>
                <h3 class="text-lg font-semibold mb-2 text-gray-900">Generate dengan AI</h3>
                <p class="text-gray-600">AI akan generate judul, deskripsi, dan gambar</p>
            </div>
            <div class="text-center">
                <div class="w-20 h-20 bg-warasa-orange/20 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-file-export text-3xl text-warasa-orange"></i>
                </div>
                <h3 class="text-lg font-semibold mb-2 text-gray-900">Export & Jual</h3>
                <p class="text-gray-600">Ekspor ke Excel dan upload ke Shopee</p>
            </div>
        </div>
    </div>
</div>

<!-- Tools & Calculators Section -->
<div class="w-full bg-gray-50 py-16 md:py-20">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold font-poppins mb-4 text-gray-900">Tools & Kalkulator</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">Hitung biaya, analisis pasar, dan optimasi bisnis Anda</p>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white rounded-xl p-6 shadow-lg border border-gray-100 text-center hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                <div class="w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-calculator text-3xl text-orange-500"></i>
                </div>
                <h3 class="text-lg font-semibold mb-2 text-gray-900">ROAS Calculator</h3>
                <p class="text-gray-600 text-sm">Hitung Return on Advertising Spend untuk optimasi iklan Anda</p>
            </div>
            
            <div class="bg-white rounded-xl p-6 shadow-lg border border-gray-100 text-center hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-coins text-3xl text-yellow-500"></i>
                </div>
                <h3 class="text-lg font-semibold mb-2 text-gray-900">Shopee Fee Calc</h3>
                <p class="text-gray-600 text-sm">Hitung biaya provisi, admin, dan estimasi pendapatan bersih</p>
            </div>
            
            <div class="bg-white rounded-xl p-6 shadow-lg border border-gray-100 text-center hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-users-between-lines text-3xl text-purple-500"></i>
                </div>
                <h3 class="text-lg font-semibold mb-2 text-gray-900">Analisis Kompetitor</h3>
                <p class="text-gray-600 text-sm">Analisis harga & strategi kompetitor dengan AI</p>
            </div>
            
            <div class="bg-white rounded-xl p-6 shadow-lg border border-gray-100 text-center hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                <div class="w-16 h-16 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-magnifying-glass-chart text-3xl text-emerald-500"></i>
                </div>
                <h3 class="text-lg font-semibold mb-2 text-gray-900">SEO Score</h3>
                <p class="text-gray-600 text-sm">Cek dan optimasi skor SEO produk Anda</p>
            </div>
        </div>
    </div>
</div>

<!-- Testimonials Section -->
<div class="w-full bg-white py-16 md:py-20">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold font-poppins mb-4 text-gray-900">Apa Kata Mereka?</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">Lebih dari 10.000+ penjual online percaya dengan Warasa</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-gray-50 rounded-xl p-6 shadow-lg border border-gray-100">
                <div class="flex items-center gap-3 mb-4">
                    <img src="https://randomuser.me/api/portraits/women/1.jpg" alt="User" class="w-12 h-12 rounded-full object-cover">
                    <div>
                        <h4 class="font-semibold text-gray-900">Sarah Dewi</h4>
                        <p class="text-xs text-gray-500">Penjual Fashion</p>
                    </div>
                </div>
                <p class="text-gray-600 italic">"Warasa membantu saya menghemat waktu 80% untuk membuat deskripsi produk. Kalkulator ROAS-nya juga sangat membantu!"</p>
                <div class="flex items-center gap-1 mt-3">
                    <i class="fas fa-star text-yellow-400"></i>
                    <i class="fas fa-star text-yellow-400"></i>
                    <i class="fas fa-star text-yellow-400"></i>
                    <i class="fas fa-star text-yellow-400"></i>
                    <i class="fas fa-star text-yellow-400"></i>
                </div>
            </div>
            <div class="bg-gray-50 rounded-xl p-6 shadow-lg border border-gray-100">
                <div class="flex items-center gap-3 mb-4">
                    <img src="https://randomuser.me/api/portraits/men/2.jpg" alt="User" class="w-12 h-12 rounded-full object-cover">
                    <div>
                        <h4 class="font-semibold text-gray-900">Andi Wijaya</h4>
                        <p class="text-xs text-gray-500">Dropshipper</p>
                    </div>
                </div>
                <p class="text-gray-600 italic">"Bulk export ke Shopee sangat praktis! Sekali klik langsung jadi file Excel siap upload."</p>
                <div class="flex items-center gap-1 mt-3">
                    <i class="fas fa-star text-yellow-400"></i>
                    <i class="fas fa-star text-yellow-400"></i>
                    <i class="fas fa-star text-yellow-400"></i>
                    <i class="fas fa-star text-yellow-400"></i>
                    <i class="fas fa-star text-yellow-400"></i>
                </div>
            </div>
            <div class="bg-gray-50 rounded-xl p-6 shadow-lg border border-gray-100">
                <div class="flex items-center gap-3 mb-4">
                    <img src="https://randomuser.me/api/portraits/women/3.jpg" alt="User" class="w-12 h-12 rounded-full object-cover">
                    <div>
                        <h4 class="font-semibold text-gray-900">Rina Kartika</h4>
                        <p class="text-xs text-gray-500">UMKM Pemula</p>
                    </div>
                </div>
                <p class="text-gray-600 italic">"Gratis dan mudah digunakan! Fitur Smart Generation dari CSV dan kalkulator ROAS sangat membantu pemula."</p>
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

<!-- FAQ Section -->
<div class="w-full bg-gray-50 py-16 md:py-20">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold font-poppins mb-4 text-gray-900">Pertanyaan Umum</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">Yang sering ditanyakan tentang Warasa</p>
        </div>
        
        <div class="max-w-3xl mx-auto space-y-4">
            @foreach([
                ['q' => 'Apakah Warasa benar-benar gratis?', 'a' => 'Ya! Warasa 100% gratis untuk digunakan. Tidak ada biaya tersembunyi atau batasan penggunaan.'],
                ['q' => 'Apa saja yang bisa saya generate dengan AI?', 'a' => 'Anda bisa generate judul produk, deskripsi, keywords, gambar, dan analisis kompetitor menggunakan AI canggih.'],
                ['q' => 'Bagaimana cara export produk ke Shopee?', 'a' => 'Cukup pilih produk yang ingin di-export, klik tombol Export, dan file Excel siap upload ke Shopee.'],
                ['q' => 'Apa itu ROAS Calculator?', 'a' => 'ROAS Calculator membantu Anda menghitung Return on Advertising Spend untuk mengoptimalkan budget iklan.'],
                ['q' => 'Apakah data saya aman?', 'a' => 'Tentu! Semua data Anda terenkripsi dan aman. Kami tidak akan membagikan data Anda ke pihak ketiga.'],
                ['q' => 'Bisakah saya upload produk dari CSV?', 'a' => 'Ya! Fitur Smart Generation memungkinkan Anda upload file CSV berisi data produk untuk di-generate massal.'],
            ] as $faq)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <button class="faq-toggle w-full px-6 py-4 text-left flex items-center justify-between gap-4 hover:bg-gray-50 transition" onclick="toggleFaq(this)">
                    <span class="font-semibold text-gray-900 text-sm">{{ $faq['q'] }}</span>
                    <i class="fas fa-chevron-down text-gray-400 text-xs transition-transform duration-300"></i>
                </button>
                <div class="faq-answer px-6 pb-4 hidden">
                    <p class="text-gray-600 text-sm leading-relaxed">{{ $faq['a'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<!-- CTA Section -->
<div class="w-full bg-gradient-to-r from-warasa-orange to-warasa-orange-dark py-16 md:py-20">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-3xl md:text-4xl font-bold mb-4 text-white">Siap Meningkatkan Penjualan?</h2>
        <p class="text-white/80 mb-8 max-w-2xl mx-auto">Bergabunglah dengan ribuan penjual online yang sudah menggunakan Warasa. Gratis selamanya!</p>
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

@push('scripts')
<script>
function toggleFaq(button) {
    const answer = button.nextElementSibling;
    const icon = button.querySelector('i');
    
    if (answer.classList.contains('hidden')) {
        answer.classList.remove('hidden');
        icon.style.transform = 'rotate(180deg)';
    } else {
        answer.classList.add('hidden');
        icon.style.transform = 'rotate(0deg)';
    }
}
</script>
@endpush