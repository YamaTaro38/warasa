@extends('layouts.app')

@section('content')
<!-- Hero -->
<div class="w-full bg-gradient-to-r from-warasa-orange to-warasa-orange-dark py-16 md:py-20">
    <div class="container mx-auto px-4 text-center">
        <h1 class="text-4xl md:text-5xl font-bold font-poppins mb-4 text-white">Harga</h1>
        <p class="text-white/80 max-w-2xl mx-auto">Warasa 100% gratis untuk semua pengguna. Tidak ada biaya tersembunyi!</p>
    </div>
</div>

<!-- Pricing Cards -->
<div class="w-full bg-gray-50 py-16 md:py-20">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Free Plan -->
            <div class="bg-white rounded-2xl p-8 shadow-lg border border-gray-100 text-center">
                <div class="w-16 h-16 bg-warasa-orange/10 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-rocket text-3xl text-warasa-orange"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">Gratis</h3>
                <div class="text-5xl font-bold text-warasa-orange mb-6">
                    Rp0
                </div>
                <p class="text-gray-500 text-sm mb-6">Untuk pemula yang ingin mencoba</p>
                <ul class="text-left space-y-3 mb-8">
                    <li class="flex items-center gap-3 text-gray-600">
                        <i class="fas fa-check text-green-500"></i>
                        <span>Product Generator</span>
                    </li>
                    <li class="flex items-center gap-3 text-gray-600">
                        <i class="fas fa-check text-green-500"></i>
                        <span>AI Chatbot</span>
                    </li>
                    <li class="flex items-center gap-3 text-gray-600">
                        <i class="fas fa-check text-green-500"></i>
                        <span>Image Tools</span>
                    </li>
                    <li class="flex items-center gap-3 text-gray-600">
                        <i class="fas fa-check text-green-500"></i>
                        <span>Export Shopee</span>
                    </li>
                    <li class="flex items-center gap-3 text-gray-600">
                        <i class="fas fa-check text-green-500"></i>
                        <span>ROAS Calculator</span>
                    </li>
                    <li class="flex items-center gap-3 text-gray-600">
                        <i class="fas fa-check text-green-500"></i>
                        <span>Shopee Fee Kalkulator</span>
                    </li>
                    <li class="flex items-center gap-3 text-gray-600">
                        <i class="fas fa-check text-green-500"></i>
                        <span>Competitor Analysis</span>
                    </li>
                    <li class="flex items-center gap-3 text-gray-600">
                        <i class="fas fa-check text-green-500"></i>
                        <span>SEO Score</span>
                    </li>
                    <li class="flex items-center gap-3 text-gray-600">
                        <i class="fas fa-check text-green-500"></i>
                        <span>Unlimited Products</span>
                    </li>
                </ul>
                @auth
                    <a href="{{ route('dashboard') }}" class="block w-full bg-warasa-orange text-white font-semibold py-3 px-6 rounded-xl hover:bg-warasa-orange-dark transition text-center">
                        <i class="fas fa-tachometer-alt mr-2"></i> Dashboard
                    </a>
                @else
                    <a href="{{ route('register') }}" class="block w-full bg-warasa-orange text-white font-semibold py-3 px-6 rounded-xl hover:bg-warasa-orange-dark transition text-center">
                        <i class="fas fa-user-plus mr-2"></i> Daftar Gratis
                    </a>
                @endauth
            </div>

            <!-- Popular -->
            <div class="bg-white rounded-2xl p-8 shadow-xl border-2 border-warasa-orange text-center relative scale-105">
                <div class="absolute -top-4 left-1/2 -translate-x-1/2 bg-warasa-orange text-white px-6 py-1 rounded-full text-sm font-semibold">
                    <i class="fas fa-crown mr-1"></i> Paling Populer
                </div>
                <div class="w-16 h-16 bg-warasa-orange/10 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-gem text-3xl text-warasa-orange"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">Selamanya</h3>
                <div class="text-5xl font-bold text-warasa-orange mb-2">
                    GRATIS
                </div>
                <p class="text-gray-500 text-sm mb-6">Semua fitur tanpa batas!</p>
                <ul class="text-left space-y-3 mb-8">
                    <li class="flex items-center gap-3 text-gray-600">
                        <i class="fas fa-check text-green-500"></i>
                        <span>✓ Semua fitur gratis</span>
                    </li>
                    <li class="flex items-center gap-3 text-gray-600">
                        <i class="fas fa-check text-green-500"></i>
                        <span>✓ Tanpa batas penggunaan</span>
                    </li>
                    <li class="flex items-center gap-3 text-gray-600">
                        <i class="fas fa-check text-green-500"></i>
                        <span>✓ Update gratis selamanya</span>
                    </li>
                    <li class="flex items-center gap-3 text-gray-600">
                        <i class="fas fa-check text-green-500"></i>
                        <span>✓ Prioritas fitur baru</span>
                    </li>
                    <li class="flex items-center gap-3 text-gray-600">
                        <i class="fas fa-check text-green-500"></i>
                        <span>✓ Tidak ada iklan</span>
                    </li>
                </ul>
                @auth
                    <a href="{{ route('dashboard') }}" class="block w-full bg-warasa-orange text-white font-semibold py-3 px-6 rounded-xl hover:bg-warasa-orange-dark transition text-center">
                        <i class="fas fa-tachometer-alt mr-2"></i> Mulai Sekarang
                    </a>
                @else
                    <a href="{{ route('register') }}" class="block w-full bg-warasa-orange text-white font-semibold py-3 px-6 rounded-xl hover:bg-warasa-orange-dark transition text-center">
                        <i class="fas fa-user-plus mr-2"></i> Daftar Gratis
                    </a>
                @endauth
            </div>

            <!-- Enterprise -->
            <div class="bg-white rounded-2xl p-8 shadow-lg border border-gray-100 text-center">
                <div class="w-16 h-16 bg-warasa-orange/10 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-building text-3xl text-warasa-orange"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">Bisnis</h3>
                <div class="text-5xl font-bold text-warasa-orange mb-2">
                    Rp0
                </div>
                <p class="text-gray-500 text-sm mb-6">Untuk tim dan bisnis</p>
                <ul class="text-left space-y-3 mb-8">
                    <li class="flex items-center gap-3 text-gray-600">
                        <i class="fas fa-check text-green-500"></i>
                        <span>Semua fitur Gratis</span>
                    </li>
                    <li class="flex items-center gap-3 text-gray-600">
                        <i class="fas fa-check text-green-500"></i>
                        <span>Multi-user (coming soon)</span>
                    </li>
                    <li class="flex items-center gap-3 text-gray-600">
                        <i class="fas fa-check text-green-500"></i>
                        <span>API Access (coming soon)</span>
                    </li>
                    <li class="flex items-center gap-3 text-gray-600">
                        <i class="fas fa-check text-green-500"></i>
                        <span>Dedicated support</span>
                    </li>
                </ul>
                @auth
                    <a href="{{ route('dashboard') }}" class="block w-full bg-gray-100 text-gray-700 font-semibold py-3 px-6 rounded-xl hover:bg-gray-200:bg-gray-700 transition text-center">
                        <i class="fas fa-tachometer-alt mr-2"></i> Dashboard
                    </a>
                @else
                    <a href="{{ route('contact') }}" class="block w-full bg-gray-100 text-gray-700 font-semibold py-3 px-6 rounded-xl hover:bg-gray-200:bg-gray-700 transition text-center">
                        <i class="fas fa-envelope mr-2"></i> Hubungi Kami
                    </a>
                @endauth
            </div>
        </div>

        <!-- FAQ Notice -->
        <div class="text-center mt-12">
            <p class="text-gray-500">
                Ada pertanyaan? Cek <a href="{{ route('faq') }}" class="text-warasa-orange hover:underline">FAQ</a> atau <a href="{{ route('contact') }}" class="text-warasa-orange hover:underline">hubungi kami</a>
            </p>
        </div>
    </div>
</div>
@endsection