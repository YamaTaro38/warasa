<nav class="navbar-warasa">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center h-16">
            <!-- Logo -->
            <a href="{{ url('/') }}" class="flex items-center gap-2">
                <div class="w-8 h-8 bg-warasa-orange rounded-lg flex items-center justify-center">
                    <i class="fas fa-store text-white text-sm"></i>
                </div>
                <span class="text-xl font-bold text-warasa-orange">Warasa</span>
                <span class="text-xs text-gray-400 hidden sm:inline">| AI-Powered</span>
            </a>
            
            <!-- Desktop Navigation -->
            <div class="hidden md:flex items-center gap-6">
                <a href="{{ url('/') }}" class="text-gray-600 dark:text-gray-300 hover:text-warasa-orange transition">Home</a>
                <a href="{{ url('/features') }}" class="text-gray-600 dark:text-gray-300 hover:text-warasa-orange transition">Fitur</a>
                <a href="{{ url('/pricing') }}" class="text-gray-600 dark:text-gray-300 hover:text-warasa-orange transition">Harga</a>
                <a href="{{ url('/faq') }}" class="text-gray-600 dark:text-gray-300 hover:text-warasa-orange transition">FAQ</a>
            </div>
            
            <!-- Right Section -->
            <div class="flex items-center gap-4">
                <!-- Theme Toggle Button (Shopee-style) -->
                <button onclick="toggleTheme()" class="theme-toggle-btn w-9 h-9 rounded-full bg-gray-100 dark:bg-dark-border flex items-center justify-center hover:bg-warasa-orange/10 transition">
                    <i class="fas fa-moon text-gray-600 dark:text-gray-300"></i>
                </button>
                
                @auth
                    <a href="{{ route('dashboard') }}" class="text-gray-600 dark:text-gray-300 hover:text-warasa-orange transition">
                        <i class="fas fa-home mr-1"></i>Dashboard
                    </a>
                    <div class="relative group">
                        <button class="flex items-center gap-2 hover:text-warasa-orange transition">
                            <div class="w-8 h-8 rounded-full bg-warasa-orange flex items-center justify-center">
                                <i class="fas fa-user text-white text-sm"></i>
                            </div>
                            <span class="text-sm text-gray-600 dark:text-gray-300">{{ auth()->user()->name }}</span>
                            <i class="fas fa-chevron-down text-xs text-gray-400"></i>
                        </button>
                        <div class="absolute right-0 mt-2 w-48 bg-white dark:bg-dark-card border border-gray-200 dark:border-dark-border rounded-lg shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                            <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-3 text-gray-600 dark:text-gray-300 hover:bg-warasa-orange/10 hover:text-warasa-orange transition">
                                <i class="fas fa-user-circle w-5"></i>Profile
                            </a>
                            <a href="{{ route('generator') }}" class="flex items-center gap-3 px-4 py-3 text-gray-600 dark:text-gray-300 hover:bg-warasa-orange/10 hover:text-warasa-orange transition">
                                <i class="fas fa-magic w-5"></i>Generator
                            </a>
                            <hr class="my-1 border-gray-200 dark:border-dark-border">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 text-gray-600 dark:text-gray-300 hover:bg-warasa-orange/10 hover:text-warasa-orange transition">
                                    <i class="fas fa-sign-out-alt w-5"></i>Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="text-gray-600 dark:text-gray-300 hover:text-warasa-orange transition">Login</a>
                    <a href="{{ route('register') }}" class="btn-warasa-primary px-4 py-2">
                        <i class="fas fa-user-plus"></i> Daftar
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>

<script>
    // Update theme button icon on load
    document.addEventListener('DOMContentLoaded', function() {
        const isDark = document.documentElement.classList.contains('dark');
        const btn = document.querySelector('.theme-toggle-btn i');
        if (btn) {
            if (isDark) {
                btn.className = 'fas fa-sun';
            } else {
                btn.className = 'fas fa-moon';
            }
        }
    });
    
    window.toggleTheme = function() {
        const isDark = document.documentElement.classList.contains('dark');
        if (isDark) {
            document.documentElement.classList.remove('dark');
            localStorage.setItem('theme', 'light');
        } else {
            document.documentElement.classList.add('dark');
            localStorage.setItem('theme', 'dark');
        }
        
        // Update icon
        const btn = document.querySelector('.theme-toggle-btn i');
        if (btn) {
            if (document.documentElement.classList.contains('dark')) {
                btn.className = 'fas fa-sun';
            } else {
                btn.className = 'fas fa-moon';
            }
        }
    };
</script>