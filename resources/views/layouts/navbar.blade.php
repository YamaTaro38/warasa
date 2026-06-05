{{-- resources/views/layouts/navbar.blade.php --}}
<nav class="bg-warasa-card/80 backdrop-blur-lg border-b border-warasa-primary/20 sticky top-0 z-50">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center h-16">
            <!-- Logo -->
            <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                <div class="relative">
                    <div class="absolute inset-0 bg-warasa-primary/40 blur-xl rounded-full opacity-60 group-hover:opacity-100 transition"></div>
                    <i class="fas fa-robot text-2xl text-warasa-primary relative z-10"></i>
                </div>
                <span class="text-xl font-space font-bold bg-gradient-to-r from-warasa-primary to-warasa-secondary bg-clip-text text-transparent">
                    Warasa
                </span>
            </a>
            
            <!-- Navigation Links (Desktop) -->
            <div class="hidden md:flex items-center gap-6">
                <a href="{{ route('home') }}" class="text-gray-300 hover:text-warasa-primary transition {{ request()->routeIs('home') ? 'text-warasa-primary' : '' }}">
                    Home
                </a>
                <a href="{{ route('features') }}" class="text-gray-300 hover:text-warasa-primary transition">Fitur</a>
                <a href="{{ route('pricing') }}" class="text-gray-300 hover:text-warasa-primary transition">Harga</a>
                <a href="{{ route('faq') }}" class="text-gray-300 hover:text-warasa-primary transition">FAQ</a>
            </div>
            
            <!-- Auth Links -->
            <div class="flex items-center gap-4">
                @auth
                    <a href="{{ route('dashboard') }}" class="text-gray-300 hover:text-warasa-primary transition">
                        <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                    </a>
                    <div class="relative group">
                        <button class="flex items-center gap-2 bg-warasa-primary/10 rounded-full px-4 py-2 hover:bg-warasa-primary/20 transition">
                            <div class="w-8 h-8 rounded-full bg-gradient-to-r from-warasa-primary to-warasa-secondary flex items-center justify-center">
                                <i class="fas fa-user text-white text-sm"></i>
                            </div>
                            <span class="text-sm">{{ Auth::user()->name }}</span>
                            <i class="fas fa-chevron-down text-xs"></i>
                        </button>
                        <div class="absolute right-0 mt-2 w-48 bg-warasa-card border border-warasa-primary/20 rounded-xl shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                            <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-3 text-gray-300 hover:bg-warasa-primary/10 hover:text-warasa-primary transition">
                                <i class="fas fa-user-circle w-5"></i>Profile
                            </a>
                            <a href="{{ route('generator') }}" class="flex items-center gap-3 px-4 py-3 text-gray-300 hover:bg-warasa-primary/10 hover:text-warasa-primary transition">
                                <i class="fas fa-magic w-5"></i>Generator
                            </a>
                            <a href="{{ route('projects.index') }}" class="flex items-center gap-3 px-4 py-3 text-gray-300 hover:bg-warasa-primary/10 hover:text-warasa-primary transition">
                                <i class="fas fa-folder w-5"></i>Projects
                            </a>
                            <a href="{{ route('chatbot') }}" class="flex items-center gap-3 px-4 py-3 text-gray-300 hover:bg-warasa-primary/10 hover:text-warasa-primary transition">
                                <i class="fas fa-robot w-5"></i>AI Chat
                            </a>
                            <hr class="border-warasa-primary/20 my-1">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 text-gray-300 hover:bg-warasa-primary/10 hover:text-warasa-primary transition">
                                    <i class="fas fa-sign-out-alt w-5"></i>Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="text-gray-300 hover:text-warasa-primary transition">Login</a>
                    <a href="{{ route('register') }}" class="bg-gradient-to-r from-warasa-primary to-warasa-secondary px-4 py-2 rounded-lg text-white font-medium hover:opacity-90 transition">
                        Register
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>