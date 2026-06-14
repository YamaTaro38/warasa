<nav class="navbar-warasa">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center h-16">
            <!-- Logo -->
            <a href="{{ url('/') }}" class="flex items-center gap-2">
                <img src="/images/icon.ico" alt="Warasa" class="w-8 h-8 rounded-lg object-contain">
                <span class="text-xl font-bold text-warasa-orange">Warasa</span>
                <span class="text-xs text-gray-400 hidden sm:inline">| AI-Powered</span>
            </a>
            
            <!-- Desktop Navigation -->
            <div class="hidden md:flex items-center gap-6">
                <a href="{{ url('/') }}" class="text-gray-600 hover:text-warasa-orange transition">Home</a>
                <a href="{{ url('/docs') }}" class="text-gray-600 hover:text-warasa-orange transition"><i class="fas fa-book mr-1"></i>Dokumentasi</a>
                <a href="{{ url('/faq') }}" class="text-gray-600 hover:text-warasa-orange transition">FAQ</a>
            </div>
            
            <!-- Right Section -->
            <div class="flex items-center gap-4">
                @auth
                    <a href="{{ route('dashboard') }}" class="text-gray-600 hover:text-warasa-orange transition">
                        <i class="fas fa-home mr-1"></i>Dashboard
                    </a>
                    <div class="relative group">
                        <button class="flex items-center gap-2 hover:text-warasa-orange transition">
                            <div class="w-8 h-8 rounded-full bg-warasa-orange flex items-center justify-center">
                                <i class="fas fa-user text-white text-sm"></i>
                            </div>
                            <span class="text-sm text-gray-600">{{ auth()->user()->name }}</span>
                            <i class="fas fa-chevron-down text-xs text-gray-400"></i>
                        </button>
                        <div class="absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-lg shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                            <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-3 text-gray-600 hover:bg-warasa-orange/10 hover:text-warasa-orange transition">
                                <i class="fas fa-user-circle w-5"></i>Profile
                            </a>
                            <a href="{{ route('generator') }}" class="flex items-center gap-3 px-4 py-3 text-gray-600 hover:bg-warasa-orange/10 hover:text-warasa-orange transition">
                                <i class="fas fa-magic w-5"></i>Generator
                            </a>
                            <hr class="my-1 border-gray-200">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 text-gray-600 hover:bg-warasa-orange/10 hover:text-warasa-orange transition">
                                    <i class="fas fa-sign-out-alt w-5"></i>Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="text-gray-600 hover:text-warasa-orange transition">Login</a>
                    <a href="{{ route('register') }}" class="btn-warasa-primary px-4 py-2">
                        <i class="fas fa-user-plus"></i> Daftar
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>