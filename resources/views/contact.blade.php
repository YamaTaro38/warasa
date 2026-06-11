@extends('layouts.app')

@section('content')
<!-- Hero -->
<div class="w-full bg-gradient-to-r from-warasa-orange to-warasa-orange-dark py-16 md:py-20">
    <div class="container mx-auto px-4 text-center">
        <h1 class="text-4xl md:text-5xl font-bold font-poppins mb-4 text-white">Hubungi Kami</h1>
        <p class="text-white/80 max-w-2xl mx-auto">Punya pertanyaan atau saran? Kami siap membantu!</p>
    </div>
</div>

<!-- Contact Content -->
<div class="w-full bg-gray-50 dark:bg-dark-bg py-16 md:py-20">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Contact Info -->
            <div class="space-y-6">
                <div class="bg-white dark:bg-dark-card rounded-xl p-6 shadow-sm border border-gray-100 dark:border-dark-border">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-12 h-12 rounded-full bg-warasa-orange/10 flex items-center justify-center">
                            <i class="fas fa-envelope text-xl text-warasa-orange"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 dark:text-white">Email</h3>
                            <p class="text-sm text-gray-500">support@warasa.com</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-dark-card rounded-xl p-6 shadow-sm border border-gray-100 dark:border-dark-border">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-12 h-12 rounded-full bg-warasa-orange/10 flex items-center justify-center">
                            <i class="fab fa-instagram text-xl text-warasa-orange"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 dark:text-white">Instagram</h3>
                            <p class="text-sm text-gray-500">@warasa.app</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-dark-card rounded-xl p-6 shadow-sm border border-gray-100 dark:border-dark-border">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-12 h-12 rounded-full bg-warasa-orange/10 flex items-center justify-center">
                            <i class="fab fa-tiktok text-xl text-warasa-orange"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 dark:text-white">TikTok</h3>
                            <p class="text-sm text-gray-500">@warasa.app</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-dark-card rounded-xl p-6 shadow-sm border border-gray-100 dark:border-dark-border">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-12 h-12 rounded-full bg-warasa-orange/10 flex items-center justify-center">
                            <i class="fab fa-whatsapp text-xl text-warasa-orange"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 dark:text-white">WhatsApp</h3>
                            <p class="text-sm text-gray-500">+62 812-3456-7890</p>
                        </div>
                    </div>
                </div>

                <!-- FAQ Link -->
                <div class="bg-warasa-orange/5 dark:bg-warasa-orange/10 rounded-xl p-6 border border-warasa-orange/20">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full bg-warasa-orange/10 flex items-center justify-center">
                            <i class="fas fa-circle-question text-xl text-warasa-orange"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 dark:text-white">Cek FAQ</h3>
                            <p class="text-sm text-gray-500">Mungkin pertanyaan Anda sudah terjawab di <a href="{{ route('faq') }}" class="text-warasa-orange hover:underline">FAQ</a></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="bg-white dark:bg-dark-card rounded-xl p-8 shadow-sm border border-gray-100 dark:border-dark-border">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                    <i class="fas fa-paper-plane text-warasa-orange"></i>
                    Kirim Pesan
                </h3>

                <form action="mailto:support@warasa.com" method="GET" class="space-y-4" onsubmit="return handleContactForm(event)">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Lengkap</label>
                        <input type="text" name="name" id="contact_name" required 
                            class="w-full px-4 py-3 rounded-lg border border-gray-200 dark:border-dark-border bg-white dark:bg-dark-bg text-gray-900 dark:text-white focus:ring-2 focus:ring-warasa-orange focus:border-transparent transition">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email</label>
                        <input type="email" name="email" id="contact_email" required 
                            class="w-full px-4 py-3 rounded-lg border border-gray-200 dark:border-dark-border bg-white dark:bg-dark-bg text-gray-900 dark:text-white focus:ring-2 focus:ring-warasa-orange focus:border-transparent transition">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Subjek</label>
                        <input type="text" name="subject" id="contact_subject" required 
                            class="w-full px-4 py-3 rounded-lg border border-gray-200 dark:border-dark-border bg-white dark:bg-dark-bg text-gray-900 dark:text-white focus:ring-2 focus:ring-warasa-orange focus:border-transparent transition">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Pesan</label>
                        <textarea name="message" id="contact_message" rows="4" required 
                            class="w-full px-4 py-3 rounded-lg border border-gray-200 dark:border-dark-border bg-white dark:bg-dark-bg text-gray-900 dark:text-white focus:ring-2 focus:ring-warasa-orange focus:border-transparent transition"></textarea>
                    </div>
                    <button type="submit" 
                        class="w-full bg-warasa-orange text-white font-semibold py-3 px-6 rounded-xl hover:bg-warasa-orange-dark transition inline-flex items-center justify-center gap-2">
                        <i class="fas fa-paper-plane"></i>
                        Kirim Pesan
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function handleContactForm(event) {
    event.preventDefault();
    const name = document.getElementById('contact_name').value;
    const email = document.getElementById('contact_email').value;
    const subject = document.getElementById('contact_subject').value;
    const message = document.getElementById('contact_message').value;
    
    const mailto = `mailto:support@warasa.com?subject=${encodeURIComponent(subject)}&body=${encodeURIComponent('Name: ' + name + '\nEmail: ' + email + '\n\n' + message)}`;
    window.location.href = mailto;
    return false;
}
</script>
@endpush