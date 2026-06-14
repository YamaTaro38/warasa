@extends('layouts.app')

@section('content')
<!-- Hero -->
<div class="w-full bg-gradient-to-r from-warasa-orange to-warasa-orange-dark py-16 md:py-20">
    <div class="container mx-auto px-4 text-center">
        <h1 class="text-4xl md:text-5xl font-bold font-poppins mb-4 text-white">Tentang Warasa</h1>
        <p class="text-white/80 max-w-2xl mx-auto">Platform AI-powered e-commerce assistant untuk penjual online Indonesia</p>
    </div>
</div>

<!-- Content -->
<div class="w-full bg-gray-50 py-16 md:py-20">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white rounded-2xl p-8 shadow-lg border border-gray-100 mb-8">
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-16 h-16 bg-warasa-orange/10 rounded-2xl flex items-center justify-center">
                        <i class="fas fa-store text-3xl text-warasa-orange"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">Apa itu Warasa?</h2>
                        <p class="text-gray-500">AI-Powered E-Commerce Assistant</p>
                    </div>
                </div>
                <p class="text-gray-600 leading-relaxed mb-4">
                    Warasa adalah platform berbasis AI yang membantu para penjual online di Indonesia untuk membuat konten produk berkualitas tinggi dengan cepat dan mudah. Mulai dari generate judul, deskripsi, gambar, hingga export ke Shopee - semua bisa dilakukan dalam satu platform.
                </p>
                <p class="text-gray-600 leading-relaxed">
                    Dibangun dengan teknologi AI terkini, Warasa dirancang khusus untuk memenuhi kebutuhan seller Shopee Indonesia. Kami percaya bahwa teknologi harus bisa diakses oleh semua orang, itulah mengapa Warasa <strong class="text-warasa-orange">100% gratis</strong>.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 text-center">
                    <div class="w-12 h-12 bg-warasa-orange/10 rounded-full flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-eye text-xl text-warasa-orange"></i>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">Visi</h3>
                    <p class="text-sm text-gray-600">Menjadi platform AI terdepan untuk e-commerce di Indonesia</p>
                </div>
                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 text-center">
                    <div class="w-12 h-12 bg-warasa-orange/10 rounded-full flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-bullseye text-xl text-warasa-orange"></i>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">Misi</h3>
                    <p class="text-sm text-gray-600">Memberdayakan UMKM Indonesia dengan teknologi AI yang mudah diakses</p>
                </div>
                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 text-center">
                    <div class="w-12 h-12 bg-warasa-orange/10 rounded-full flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-heart text-xl text-warasa-orange"></i>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">Nilai</h3>
                    <p class="text-sm text-gray-600">Gratis, mudah, dan bermanfaat untuk semua penjual online</p>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-8 shadow-lg border border-gray-100">
                <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                    <i class="fas fa-star text-warasa-orange"></i>
                    Kenapa Memilih Warasa?
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="flex items-start gap-3 p-4 rounded-xl bg-gray-50">
                        <i class="fas fa-check-circle text-warasa-orange mt-1"></i>
                        <div>
                            <h4 class="font-semibold text-gray-900">100% Gratis</h4>
                            <p class="text-sm text-gray-600">Semua fitur bisa diakses tanpa biaya</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3 p-4 rounded-xl bg-gray-50">
                        <i class="fas fa-check-circle text-warasa-orange mt-1"></i>
                        <div>
                            <h4 class="font-semibold text-gray-900">AI Canggih</h4>
                            <p class="text-sm text-gray-600">Menggunakan teknologi AI terkini</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3 p-4 rounded-xl bg-gray-50">
                        <i class="fas fa-check-circle text-warasa-orange mt-1"></i>
                        <div>
                            <h4 class="font-semibold text-gray-900">Mudah Digunakan</h4>
                            <p class="text-sm text-gray-600">Antarmuka sederhana dan intuitif</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3 p-4 rounded-xl bg-gray-50">
                        <i class="fas fa-check-circle text-warasa-orange mt-1"></i>
                        <div>
                            <h4 class="font-semibold text-gray-900">Shopee Integration</h4>
                            <p class="text-sm text-gray-600">Export langsung sesuai format Shopee</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- CTA -->
<div class="w-full bg-gradient-to-r from-warasa-orange to-warasa-orange-dark py-16">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-3xl md:text-4xl font-bold mb-4 text-white">Mulai Perjalanan Anda</h2>
        <p class="text-white/80 mb-8 max-w-2xl mx-auto">Bergabung dengan ribuan penjual online yang sudah menggunakan Warasa</p>
        @auth
            <a href="{{ route('dashboard') }}" class="bg-white text-warasa-orange hover:bg-gray-100 font-semibold py-3 px-8 rounded-xl transition-all duration-300 inline-flex items-center gap-2 shadow-lg">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>
        @else
            <a href="{{ route('register') }}" class="bg-white text-warasa-orange hover:bg-gray-100 font-semibold py-3 px-8 rounded-xl transition-all duration-300 inline-flex items-center gap-2 shadow-lg">
                <i class="fas fa-user-plus"></i> Daftar Gratis
            </a>
        @endauth
    </div>
</div>
@endsection