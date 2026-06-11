<footer class="bg-gray-900 dark:bg-dark-card border-t border-gray-800">
    <div class="container mx-auto px-4 py-12">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <!-- Brand -->
            <div>
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-8 h-8 bg-warasa-orange rounded-lg flex items-center justify-center">
                        <i class="fas fa-store text-white text-sm"></i>
                    </div>
                    <span class="text-xl font-bold text-white">Warasa</span>
                </div>
                <p class="text-gray-400 text-sm mb-4">AI-Powered E-Commerce Assistant untuk membantu Anda menjual lebih mudah dan cepat.</p>
                <div class="flex gap-3">
                    <a href="#" class="w-8 h-8 rounded-full bg-gray-800 flex items-center justify-center hover:bg-warasa-orange transition">
                        <i class="fab fa-facebook-f text-gray-400 hover:text-white text-xs"></i>
                    </a>
                    <a href="#" class="w-8 h-8 rounded-full bg-gray-800 flex items-center justify-center hover:bg-warasa-orange transition">
                        <i class="fab fa-instagram text-gray-400 hover:text-white text-xs"></i>
                    </a>
                    <a href="#" class="w-8 h-8 rounded-full bg-gray-800 flex items-center justify-center hover:bg-warasa-orange transition">
                        <i class="fab fa-twitter text-gray-400 hover:text-white text-xs"></i>
                    </a>
                    <a href="#" class="w-8 h-8 rounded-full bg-gray-800 flex items-center justify-center hover:bg-warasa-orange transition">
                        <i class="fab fa-tiktok text-gray-400 hover:text-white text-xs"></i>
                    </a>
                </div>
            </div>
            
            <!-- Fitur -->
            <div>
                <h4 class="font-semibold text-white mb-4">Fitur</h4>
                <ul class="space-y-2 text-gray-400 text-sm">
                    <li><a href="{{ url('/') }}" class="hover:text-warasa-orange transition"><i class="fas fa-magic mr-2 text-xs"></i>Product Generator</a></li>
                    <li><a href="{{ url('/') }}" class="hover:text-warasa-orange transition"><i class="fas fa-brain mr-2 text-xs"></i>Smart Generation</a></li>
                    <li><a href="{{ url('/') }}" class="hover:text-warasa-orange transition"><i class="fas fa-calculator mr-2 text-xs"></i>ROAS Calculator</a></li>
                    <li><a href="{{ url('/') }}" class="hover:text-warasa-orange transition"><i class="fas fa-coins mr-2 text-xs"></i>Shopee Fee Kalkulator</a></li>
                    <li><a href="{{ url('/') }}" class="hover:text-warasa-orange transition"><i class="fas fa-file-excel mr-2 text-xs"></i>Export Shopee</a></li>
                </ul>
            </div>
            
            <!-- Support -->
            <div>
                <h4 class="font-semibold text-white mb-4">Support</h4>
                <ul class="space-y-2 text-gray-400 text-sm">
                    <li><a href="{{ route('faq') }}" class="hover:text-warasa-orange transition"><i class="fas fa-circle-question mr-2 text-xs"></i>FAQ</a></li>
                    <li><a href="{{ route('contact') }}" class="hover:text-warasa-orange transition"><i class="fas fa-envelope mr-2 text-xs"></i>Kontak</a></li>
                    <li><a href="{{ url('/docs') }}" class="hover:text-warasa-orange transition"><i class="fas fa-book mr-2 text-xs"></i>Dokumentasi</a></li>
                    <li><a href="#" class="hover:text-warasa-orange transition"><i class="fas fa-shield-halved mr-2 text-xs"></i>Privacy Policy</a></li>
                    <li><a href="#" class="hover:text-warasa-orange transition"><i class="fas fa-file-contract mr-2 text-xs"></i>Terms of Service</a></li>
                </ul>
            </div>
        </div>
        
        <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-500 text-sm">
            <p>&copy; 2026 Warasa. All rights reserved.</p>
        </div>
    </div>
</footer>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const savedTheme = localStorage.getItem('theme');
        if (savedTheme === 'dark') {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    });
</script>