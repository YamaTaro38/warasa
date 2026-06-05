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
                    <li><a href="#" class="hover:text-warasa-orange transition">Product Generator</a></li>
                    <li><a href="#" class="hover:text-warasa-orange transition">AI Chatbot</a></li>
                    <li><a href="#" class="hover:text-warasa-orange transition">Image Tools</a></li>
                    <li><a href="#" class="hover:text-warasa-orange transition">Export Shopee</a></li>
                </ul>
            </div>
            
            <!-- Support -->
            <div>
                <h4 class="font-semibold text-white mb-4">Support</h4>
                <ul class="space-y-2 text-gray-400 text-sm">
                    <li><a href="#" class="hover:text-warasa-orange transition">FAQ</a></li>
                    <li><a href="#" class="hover:text-warasa-orange transition">Kontak</a></li>
                    <li><a href="#" class="hover:text-warasa-orange transition">Privacy Policy</a></li>
                    <li><a href="#" class="hover:text-warasa-orange transition">Terms of Service</a></li>
                </ul>
            </div>
            
            <!-- Download -->
            <div>
                <h4 class="font-semibold text-white mb-4">Download App</h4>
                <div class="space-y-2">
                    <a href="#" class="flex items-center gap-3 bg-gray-800 rounded-lg p-3 hover:bg-gray-700 transition">
                        <i class="fab fa-google-play text-2xl text-warasa-orange"></i>
                        <div>
                            <p class="text-xs text-gray-400">Get it on</p>
                            <p class="text-sm font-semibold text-white">Google Play</p>
                        </div>
                    </a>
                    <a href="#" class="flex items-center gap-3 bg-gray-800 rounded-lg p-3 hover:bg-gray-700 transition">
                        <i class="fab fa-apple text-2xl text-warasa-orange"></i>
                        <div>
                            <p class="text-xs text-gray-400">Download on the</p>
                            <p class="text-sm font-semibold text-white">App Store</p>
                        </div>
                    </a>
                </div>
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