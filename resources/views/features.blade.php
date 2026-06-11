@extends('layouts.app')

@section('content')
<!-- Hero Features -->
<div class="w-full bg-gradient-to-r from-warasa-orange to-warasa-orange-dark py-16 md:py-20">
    <div class="container mx-auto px-4 text-center">
        <h1 class="text-4xl md:text-5xl font-bold font-poppins mb-4 text-white">Fitur Lengkap Warasa</h1>
        <p class="text-white/80 max-w-2xl mx-auto">Semua alat yang Anda butuhkan untuk sukses jualan online dalam satu platform gratis</p>
    </div>
</div>

<!-- All Features -->
<div class="w-full bg-gray-50 dark:bg-dark-bg py-16 md:py-20">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Product Generator -->
            <div class="bg-white dark:bg-dark-card rounded-xl p-6 shadow-lg border border-gray-100 dark:border-dark-border">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-14 h-14 rounded-xl bg-purple-100 dark:bg-purple-900/20 flex items-center justify-center">
                        <i class="fas fa-magic text-2xl text-purple-500"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Product Generator</h3>
                        <p class="text-sm text-gray-500">Quick & Smart Mode</p>
                    </div>
                </div>
                <p class="text-gray-600 dark:text-gray-400">Generate judul, deskripsi, keywords, dan gambar produk menggunakan AI canggih. Tersedia mode Quick untuk single product dan Smart untuk bulk generation dari CSV.</p>
            </div>

            <!-- Smart Generation -->
            <div class="bg-white dark:bg-dark-card rounded-xl p-6 shadow-lg border border-gray-100 dark:border-dark-border">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-14 h-14 rounded-xl bg-blue-100 dark:bg-blue-900/20 flex items-center justify-center">
                        <i class="fas fa-brain text-2xl text-blue-500"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Smart Generation</h3>
                        <p class="text-sm text-gray-500">Bulk Upload CSV</p>
                    </div>
                </div>
                <p class="text-gray-600 dark:text-gray-400">Upload file CSV berisi data produk Anda, dan AI akan secara otomatis generate judul, deskripsi, serta gambar untuk semua produk sekaligus.</p>
            </div>

            <!-- Image Enhancement -->
            <div class="bg-white dark:bg-dark-card rounded-xl p-6 shadow-lg border border-gray-100 dark:border-dark-border">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-14 h-14 rounded-xl bg-pink-100 dark:bg-pink-900/20 flex items-center justify-center">
                        <i class="fas fa-image text-2xl text-pink-500"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Image Enhancement</h3>
                        <p class="text-sm text-gray-500">Edit & Optimasi</p>
                    </div>
                </div>
                <p class="text-gray-600 dark:text-gray-400">Hapus background, resize, crop, dan edit gambar produk dengan mudah. Dilengkapi filter dan tools editing profesional.</p>
            </div>

            <!-- Watermark Tools -->
            <div class="bg-white dark:bg-dark-card rounded-xl p-6 shadow-lg border border-gray-100 dark:border-dark-border">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-14 h-14 rounded-xl bg-indigo-100 dark:bg-indigo-900/20 flex items-center justify-center">
                        <i class="fas fa-copyright text-2xl text-indigo-500"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Watermark Tools</h3>
                        <p class="text-sm text-gray-500">Perlindungan Gambar</p>
                    </div>
                </div>
                <p class="text-gray-600 dark:text-gray-400">Tambahkan watermark otomatis ke semua gambar produk Anda untuk melindungi dari penyalahgunaan oleh pihak lain.</p>
            </div>

            <!-- AI Chatbot -->
            <div class="bg-white dark:bg-dark-card rounded-xl p-6 shadow-lg border border-gray-100 dark:border-dark-border">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-14 h-14 rounded-xl bg-teal-100 dark:bg-teal-900/20 flex items-center justify-center">
                        <i class="fas fa-robot text-2xl text-teal-500"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">AI Chatbot</h3>
                        <p class="text-sm text-gray-500">Konsultasi 24/7</p>
                    </div>
                </div>
                <p class="text-gray-600 dark:text-gray-400">Konsultasi bisnis dan dapatkan saran strategi dari AI kapan saja. Chatbot pintar yang siap membantu Anda 24 jam sehari, 7 hari seminggu.</p>
            </div>

            <!-- Export Shopee -->
            <div class="bg-white dark:bg-dark-card rounded-xl p-6 shadow-lg border border-gray-100 dark:border-dark-border">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-14 h-14 rounded-xl bg-green-100 dark:bg-green-900/20 flex items-center justify-center">
                        <i class="fas fa-file-excel text-2xl text-green-500"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Export Shopee</h3>
                        <p class="text-sm text-gray-500">Bulk & Single Export</p>
                    </div>
                </div>
                <p class="text-gray-600 dark:text-gray-400">Ekspor produk ke Excel sesuai template Shopee untuk upload massal. Dukung single export per produk maupun bulk export banyak produk sekaligus.</p>
            </div>

            <!-- ROAS Calculator -->
            <div class="bg-white dark:bg-dark-card rounded-xl p-6 shadow-lg border border-gray-100 dark:border-dark-border">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-14 h-14 rounded-xl bg-orange-100 dark:bg-orange-900/20 flex items-center justify-center">
                        <i class="fas fa-calculator text-2xl text-orange-500"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">ROAS Calculator</h3>
                        <p class="text-sm text-gray-500">Optimasi Iklan</p>
                    </div>
                </div>
                <p class="text-gray-600 dark:text-gray-400">Hitung Return on Advertising Spend untuk mengoptimalkan budget iklan Anda. Dapatkan insight tentang efektivitas kampanye iklan.</p>
            </div>

            <!-- Shopee Fee Calculator -->
            <div class="bg-white dark:bg-dark-card rounded-xl p-6 shadow-lg border border-gray-100 dark:border-dark-border">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-14 h-14 rounded-xl bg-yellow-100 dark:bg-yellow-900/20 flex items-center justify-center">
                        <i class="fas fa-coins text-2xl text-yellow-500"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Shopee Fee Kalkulator</h3>
                        <p class="text-sm text-gray-500">Hitung Biaya</p>
                    </div>
                </div>
                <p class="text-gray-600 dark:text-gray-400">Hitung biaya provisi, biaya admin, diskon, dan estimasi pendapatan bersih penjualan di Shopee dengan mudah dan akurat.</p>
            </div>

            <!-- Analytics Dashboard -->
            <div class="bg-white dark:bg-dark-card rounded-xl p-6 shadow-lg border border-gray-100 dark:border-dark-border">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-14 h-14 rounded-xl bg-red-100 dark:bg-red-900/20 flex items-center justify-center">
                        <i class="fas fa-chart-line text-2xl text-red-500"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Analytics Dashboard</h3>
                        <p class="text-sm text-gray-500">Insight Bisnis</p>
                    </div>
                </div>
                <p class="text-gray-600 dark:text-gray-400">Pantau performa produk, lihat statistik generasi AI, aktivitas chatbot, dan dapatkan insight bisnis real-time dalam satu dashboard.</p>
            </div>

            <!-- Manajemen Project -->
            <div class="bg-white dark:bg-dark-card rounded-xl p-6 shadow-lg border border-gray-100 dark:border-dark-border">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-14 h-14 rounded-xl bg-cyan-100 dark:bg-cyan-900/20 flex items-center justify-center">
                        <i class="fas fa-folder text-2xl text-cyan-500"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Manajemen Project</h3>
                        <p class="text-sm text-gray-500">Organisasi Produk</p>
                    </div>
                </div>
                <p class="text-gray-600 dark:text-gray-400">Kelompokkan produk dalam project-project untuk organisasi yang lebih baik. Fitur archive, restore, dan filter memudahkan manajemen.</p>
            </div>

            <!-- Competitor Analysis -->
            <div class="bg-white dark:bg-dark-card rounded-xl p-6 shadow-lg border border-gray-100 dark:border-dark-border">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-14 h-14 rounded-xl bg-violet-100 dark:bg-violet-900/20 flex items-center justify-center">
                        <i class="fas fa-users-between-lines text-2xl text-violet-500"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Competitor Analysis</h3>
                        <p class="text-sm text-gray-500">Analisis Pasar</p>
                    </div>
                </div>
                <p class="text-gray-600 dark:text-gray-400">Analisis kompetitor dan dapatkan rekomendasi harga serta strategi pemasaran yang tepat untuk produk Anda dengan bantuan AI.</p>
            </div>

            <!-- SEO Score -->
            <div class="bg-white dark:bg-dark-card rounded-xl p-6 shadow-lg border border-gray-100 dark:border-dark-border">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-14 h-14 rounded-xl bg-emerald-100 dark:bg-emerald-900/20 flex items-center justify-center">
                        <i class="fas fa-magnifying-glass-chart text-2xl text-emerald-500"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">SEO Score</h3>
                        <p class="text-sm text-gray-500">Optimasi Produk</p>
                    </div>
                </div>
                <p class="text-gray-600 dark:text-gray-400">Cek skor SEO produk Anda dan dapatkan rekomendasi optimasi agar produk mudah ditemukan oleh pembeli di marketplace.</p>
            </div>

            <!-- Image Tools -->
            <div class="bg-white dark:bg-dark-card rounded-xl p-6 shadow-lg border border-gray-100 dark:border-dark-border">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-14 h-14 rounded-xl bg-sky-100 dark:bg-sky-900/20 flex items-center justify-center">
                        <i class="fas fa-wand-magic-sparkles text-2xl text-sky-500"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Image Tools</h3>
                        <p class="text-sm text-gray-500">Manipulasi Gambar</p>
                    </div>
                </div>
                <p class="text-gray-600 dark:text-gray-400">Tools lengkap untuk manipulasi gambar: resize, crop, convert format, kompresi, filter, dan berbagai efek menarik lainnya.</p>
            </div>

            <!-- Manajemen Kategori -->
            <div class="bg-white dark:bg-dark-card rounded-xl p-6 shadow-lg border border-gray-100 dark:border-dark-border">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-14 h-14 rounded-xl bg-rose-100 dark:bg-rose-900/20 flex items-center justify-center">
                        <i class="fas fa-tags text-2xl text-rose-500"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Kategori Produk</h3>
                        <p class="text-sm text-gray-500">Filter & Organisasi</p>
                    </div>
                </div>
                <p class="text-gray-600 dark:text-gray-400">Kelola kategori produk untuk memudahkan pencarian dan filter. Tersedia manajemen kategori lengkap dengan status aktif/non-aktif.</p>
            </div>

            <!-- Dokumentasi -->
            <div class="bg-white dark:bg-dark-card rounded-xl p-6 shadow-lg border border-gray-100 dark:border-dark-border">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-14 h-14 rounded-xl bg-amber-100 dark:bg-amber-900/20 flex items-center justify-center">
                        <i class="fas fa-book text-2xl text-amber-500"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Dokumentasi</h3>
                        <p class="text-sm text-gray-500">Panduan Lengkap</p>
                    </div>
                </div>
                <p class="text-gray-600 dark:text-gray-400">Dokumentasi lengkap penggunaan semua fitur Warasa. Mulai dari generator produk, export, kalkulator, hingga tips & trik jualan online.</p>
            </div>
        </div>
    </div>
</div>

<!-- CTA -->
<div class="w-full bg-gradient-to-r from-warasa-orange to-warasa-orange-dark py-16">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-3xl md:text-4xl font-bold mb-4 text-white">Mulai Gunakan Semua Fitur</h2>
        <p class="text-white/80 mb-8 max-w-2xl mx-auto">Semua fitur dapat Anda akses gratis. Tidak ada batasan!</p>
        @auth
            <a href="{{ route('generator') }}" class="bg-white text-warasa-orange hover:bg-gray-100 font-semibold py-3 px-8 rounded-xl transition-all duration-300 inline-flex items-center gap-2 shadow-lg">
                <i class="fas fa-magic"></i> Mulai Generate
            </a>
        @else
            <a href="{{ route('register') }}" class="bg-white text-warasa-orange hover:bg-gray-100 font-semibold py-3 px-8 rounded-xl transition-all duration-300 inline-flex items-center gap-2 shadow-lg">
                <i class="fas fa-user-plus"></i> Daftar Gratis
            </a>
        @endauth
    </div>
</div>
@endsection