@extends('layouts.app')

@section('content')
<!-- Hero -->
<div class="w-full bg-gradient-to-r from-warasa-orange to-warasa-orange-dark py-16 md:py-20">
    <div class="container mx-auto px-4 text-center">
        <h1 class="text-4xl md:text-5xl font-bold font-poppins mb-4 text-white">FAQ</h1>
        <p class="text-white/80 max-w-2xl mx-auto">Pertanyaan yang sering diajukan tentang Warasa</p>
    </div>
</div>

<!-- FAQ Content -->
<div class="w-full bg-gray-50 dark:bg-dark-bg py-16 md:py-20">
    <div class="container mx-auto px-4">
        <div class="max-w-3xl mx-auto space-y-4">
            @foreach([
                ['icon' => 'fa-circle-question', 'q' => 'Apakah Warasa benar-benar gratis?', 'a' => 'Ya! Warasa 100% gratis untuk digunakan. Tidak ada biaya tersembunyi, tidak ada batasan penggunaan, dan tidak perlu kartu kredit. Semua fitur dapat diakses secara gratis selamanya.'],
                ['icon' => 'fa-magic', 'q' => 'Apa saja yang bisa saya generate dengan AI?', 'a' => 'Anda bisa generate judul produk, deskripsi produk, keywords SEO, gambar produk, dan analisis kompetitor menggunakan AI canggih. Tersedia mode Quick untuk single product dan Smart untuk bulk generation dari file CSV.'],
                ['icon' => 'fa-file-export', 'q' => 'Bagaimana cara export produk ke Shopee?', 'a' => 'Cukup pilih produk yang ingin di-export, klik tombol Export, dan file Excel akan di-download sesuai template Shopee. Anda bisa export satu produk atau banyak produk sekaligus (bulk export). File siap upload ke dashboard Shopee Anda.'],
                ['icon' => 'fa-calculator', 'q' => 'Apa itu ROAS Calculator?', 'a' => 'ROAS (Return on Advertising Spend) Calculator membantu Anda menghitung efektivitas budget iklan. Masukkan biaya iklan dan pendapatan, dan kami akan menghitung ROAS serta memberikan rekomendasi optimasi.'],
                ['icon' => 'fa-coins', 'q' => 'Apa itu Shopee Fee Calculator?', 'a' => 'Shopee Fee Calculator membantu Anda menghitung estimasi biaya penjualan di Shopee, termasuk biaya provisi, biaya admin tetap, diskon, dan estimasi pendapatan bersih yang akan Anda terima.'],
                ['icon' => 'fa-shield-halved', 'q' => 'Apakah data saya aman?', 'a' => 'Tentu! Semua data Anda terenkripsi dan aman. Kami menggunakan enkripsi SSL, hashing password yang kuat, dan tidak akan membagikan data Anda ke pihak ketiga. Data produk Anda sepenuhnya milik Anda.'],
                ['icon' => 'fa-upload', 'q' => 'Bisakah saya upload produk dari file CSV?', 'a' => 'Ya! Fitur Smart Generation memungkinkan Anda upload file CSV berisi data produk untuk di-generate secara massal. AI akan memproses semua data dan menghasilkan konten untuk setiap produk secara otomatis.'],
                ['icon' => 'fa-image', 'q' => 'Fitur edit gambar apa saja yang tersedia?', 'a' => 'Anda bisa menghapus background (remove bg), resize gambar, crop, menambahkan filter, mengatur brightness/contrast, dan menambahkan watermark ke gambar produk Anda.'],
                ['icon' => 'fa-chart-line', 'q' => 'Apa itu SEO Score?', 'a' => 'SEO Score adalah fitur yang mengecek kualitas optimasi produk Anda untuk marketplace. Skor ini memberikan rekomendasi perbaikan judul, deskripsi, dan keywords agar produk lebih mudah ditemukan pembeli.'],
                ['icon' => 'fa-users-between-lines', 'q' => 'Bagaimana cara analisis kompetitor?', 'a' => 'Masukkan produk kompetitor, dan AI akan menganalisis harga, deskripsi, serta strategi mereka. Anda akan mendapat rekomendasi harga dan strategi untuk produk Anda sendiri.'],
                ['icon' => 'fa-robot', 'q' => 'Apa itu AI Chatbot?', 'a' => 'AI Chatbot adalah asisten virtual yang siap membantu Anda 24/7. Anda bisa konsultasi bisnis, tanya tips jualan online, diskusi strategi marketing, atau sekedar brainstorming ide produk.'],
                ['icon' => 'fa-folder', 'q' => 'Apa itu fitur Manajemen Project?', 'a' => 'Manajemen Project memungkinkan Anda mengelompokkan produk ke dalam project-project berbeda. Misalnya project "Baju Muslim", "Aksesoris", dll. Memudahkan organisasi dan pencarian produk.'],
            ] as $faq)
            <div class="bg-white dark:bg-dark-card rounded-xl shadow-sm border border-gray-100 dark:border-dark-border overflow-hidden">
                <button class="faq-toggle w-full px-6 py-4 text-left flex items-center justify-between gap-4 hover:bg-gray-50 dark:hover:bg-dark-bg transition" onclick="toggleFaq(this)">
                    <div class="flex items-center gap-3">
                        <i class="fas {{ $faq['icon'] }} text-warasa-orange"></i>
                        <span class="font-semibold text-gray-900 dark:text-white text-sm">{{ $faq['q'] }}</span>
                    </div>
                    <i class="fas fa-chevron-down text-gray-400 text-xs transition-transform duration-300"></i>
                </button>
                <div class="faq-answer px-6 pb-4 hidden">
                    <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed pl-9">{{ $faq['a'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<!-- CTA -->
<div class="w-full bg-gradient-to-r from-warasa-orange to-warasa-orange-dark py-16">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-3xl md:text-4xl font-bold mb-4 text-white">Masih Punya Pertanyaan?</h2>
        <p class="text-white/80 mb-8 max-w-2xl mx-auto">Tim kami siap membantu Anda</p>
        <a href="{{ route('contact') }}" class="bg-white text-warasa-orange hover:bg-gray-100 font-semibold py-3 px-8 rounded-xl transition-all duration-300 inline-flex items-center gap-2 shadow-lg">
            <i class="fas fa-envelope"></i> Hubungi Kami
        </a>
    </div>
</div>
@endsection

@push('scripts')
<script>
function toggleFaq(button) {
    const answer = button.nextElementSibling;
    const icon = button.querySelector('.fa-chevron-down');
    
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