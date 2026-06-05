<!DOCTYPE html>
<html lang="id" class="{{ session('theme', 'light') === 'dark' ? 'dark' : '' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - Warasa</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #e4e8ec 100%);
        }
        .dark body {
            background: linear-gradient(135deg, #1a1a2e 0%, #0f0f1a 100%);
        }
    </style>
</head>
<body class="font-inter text-sm">
    <div class="min-h-screen flex items-center justify-center p-4">
        <!-- Login Card -->
        <div class="w-full max-w-sm">
            <!-- Logo -->
            <div class="text-center mb-6">
                <a href="{{ url('/') }}" class="inline-flex items-center gap-2">
                    <div class="w-10 h-10 bg-warasa-orange rounded-xl flex items-center justify-center shadow-md">
                        <i class="fas fa-store text-white text-lg"></i>
                    </div>
                    <span class="text-xl font-bold text-warasa-orange">Warasa</span>
                </a>
                <h2 class="text-base font-semibold text-gray-800 dark:text-white mt-4">Welcome Back</h2>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Sign in to your account</p>
            </div>
            
            <!-- Form Card -->
            <div class="bg-white/90 dark:bg-dark-card/90 backdrop-blur-sm rounded-xl shadow-lg border border-white/30 dark:border-dark-border/30 p-5">
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    
                    <!-- Email -->
                    <div class="mb-4">
                        <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                            <i class="fas fa-envelope mr-1 text-warasa-orange text-[10px]"></i>
                            Email Address
                        </label>
                        <input type="email" name="email" value="{{ old('email') }}" required
                            class="w-full px-3 py-2 bg-white dark:bg-dark-card border border-gray-200 dark:border-dark-border rounded-lg focus:outline-none focus:border-warasa-orange focus:ring-1 focus:ring-warasa-orange/20 transition text-sm"
                            placeholder="you@example.com">
                        @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Password -->
                    <div class="mb-4">
                        <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                            <i class="fas fa-lock mr-1 text-warasa-orange text-[10px]"></i>
                            Password
                        </label>
                        <input type="password" name="password" required
                            class="w-full px-3 py-2 bg-white dark:bg-dark-card border border-gray-200 dark:border-dark-border rounded-lg focus:outline-none focus:border-warasa-orange focus:ring-1 focus:ring-warasa-orange/20 transition text-sm"
                            placeholder="••••••••">
                        @error('password')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Remember & Forgot -->
                    <div class="flex items-center justify-between mb-5">
                        <label class="flex items-center gap-1.5 cursor-pointer">
                            <input type="checkbox" name="remember" class="w-3.5 h-3.5 rounded border-gray-300 dark:border-dark-border text-warasa-orange focus:ring-warasa-orange focus:ring-offset-0">
                            <span class="text-xs text-gray-600 dark:text-gray-400">Remember me</span>
                        </label>
                        <a href="#" class="text-xs text-warasa-orange hover:underline">Forgot password?</a>
                    </div>
                    
                    <!-- Submit Button -->
                    <button type="submit" class="w-full bg-warasa-orange hover:bg-warasa-orange-dark text-white font-medium py-2 rounded-lg transition text-sm flex items-center justify-center gap-2">
                        <i class="fas fa-sign-in-alt text-xs"></i>
                        Sign In
                    </button>
                </form>

                <!-- Divider -->
                <div class="flex items-center my-4">
                    <div class="flex-grow border-t border-gray-100 dark:border-dark-border/50"></div>
                    <span class="flex-shrink mx-4 text-[10px] text-gray-400 dark:text-gray-500 uppercase tracking-wider font-medium">Or</span>
                    <div class="flex-grow border-t border-gray-100 dark:border-dark-border/50"></div>
                </div>

                <!-- Google Login Button -->
                <a href="{{ route('auth.google') }}" class="w-full flex items-center justify-center gap-2.5 bg-white hover:bg-gray-50 dark:bg-dark-card dark:hover:bg-dark-card/80 border border-gray-200 dark:border-dark-border rounded-lg transition text-sm py-2 shadow-sm font-medium text-gray-700 dark:text-gray-200">
                    <svg class="w-4 h-4" viewBox="0 0 24 24">
                        <path fill="#EA4335" d="M12 5.04c1.78 0 3.39.61 4.65 1.8l3.48-3.48C17.98 1.19 15.15 0 12 0 7.31 0 3.3 2.69 1.4 6.6l3.96 3.07C6.31 6.84 8.94 5.04 12 5.04z"/>
                        <path fill="#4285F4" d="M23.49 12.27c0-.82-.07-1.6-.21-2.27H12v4.51h6.47c-.28 1.48-1.12 2.73-2.38 3.58l3.7 2.87c2.16-1.99 3.4-4.92 3.4-8.69z"/>
                        <path fill="#FBBC05" d="M5.36 14.77C5.12 14.07 5 13.32 5 12.5s.12-1.57.36-2.27L1.4 7.16C.51 8.94 0 10.92 0 12.5s.51 3.56 1.4 5.34l3.96-3.07z"/>
                        <path fill="#34A853" d="M12 24c3.24 0 5.97-1.07 7.96-2.91l-3.7-2.87c-1.03.69-2.35 1.1-4.26 1.1-3.06 0-5.69-1.8-6.61-4.49L1.43 17.9C3.33 21.8 7.34 24 12 24z"/>
                    </svg>
                    Continue with Google
                </a>
                
                <!-- Register Link -->
                <div class="mt-5 text-center">
                    <p class="text-xs text-gray-500 dark:text-gray-400">
                        Don't have an account?
                        <a href="{{ route('register') }}" class="text-warasa-orange hover:underline font-medium">Sign up</a>
                    </p>
                </div>
            </div>
            
            <!-- Theme Toggle -->
            <div class="text-center mt-4">
                <button onclick="toggleTheme()" class="text-gray-500 hover:text-warasa-orange transition text-xs flex items-center justify-center gap-1 mx-auto">
                    <i id="loginThemeIcon" class="fas fa-moon text-xs"></i>
                    <span id="loginThemeText">Dark Mode</span>
                </button>
            </div>
        </div>
    </div>
    
    <script>
        // Theme Toggle
        function toggleTheme() {
            const isDark = document.documentElement.classList.contains('dark');
            if (isDark) {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('theme', 'light');
            } else {
                document.documentElement.classList.add('dark');
                localStorage.setItem('theme', 'dark');
            }
            updateThemeUI();
        }
        
        function updateThemeUI() {
            const isDark = document.documentElement.classList.contains('dark');
            const themeIcon = document.getElementById('loginThemeIcon');
            const themeText = document.getElementById('loginThemeText');
            
            if (themeIcon && themeText) {
                if (isDark) {
                    themeIcon.className = 'fas fa-sun text-xs';
                    themeText.innerText = 'Light Mode';
                } else {
                    themeIcon.className = 'fas fa-moon text-xs';
                    themeText.innerText = 'Dark Mode';
                }
            }
        }
        
        document.addEventListener('DOMContentLoaded', function() {
            updateThemeUI();
        });
        
        window.toggleTheme = toggleTheme;
    </script>
</body>
</html>