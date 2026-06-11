<!DOCTYPE html>
<html lang="id" class="{{ session('theme', 'light') === 'dark' ? 'dark' : '' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - Warasa</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        :root {
            --primary: #ee4d2d;
            --primary-dark: #d63e1f;
            --primary-light: #ff6b4a;
            --primary-glow: rgba(238, 77, 45, 0.15);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            overflow: hidden;
            height: 100vh;
        }

        /* ====== Animated Background ====== */
        .auth-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            background: #f8fafc;
        }
        .dark .auth-bg {
            background: #0f0f1a;
        }

        .auth-bg::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle at 30% 40%, rgba(238, 77, 45, 0.03) 0%, transparent 50%),
                        radial-gradient(circle at 70% 60%, rgba(238, 77, 45, 0.02) 0%, transparent 50%);
            animation: bgShift 20s ease-in-out infinite alternate;
        }
        .dark .auth-bg::before {
            background: radial-gradient(circle at 30% 40%, rgba(238, 77, 45, 0.06) 0%, transparent 50%),
                        radial-gradient(circle at 70% 60%, rgba(238, 77, 45, 0.04) 0%, transparent 50%);
        }

        @keyframes bgShift {
            0% { transform: translate(0, 0) rotate(0deg); }
            100% { transform: translate(5%, 5%) rotate(3deg); }
        }

        /* Floating Orbs */
        .orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.4;
            animation: orbFloat 15s ease-in-out infinite alternate;
        }
        .dark .orb {
            opacity: 0.2;
        }

        .orb-1 {
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(238, 77, 45, 0.2), transparent);
            top: -100px;
            right: -100px;
            animation-delay: 0s;
        }
        .orb-2 {
            width: 350px;
            height: 350px;
            background: radial-gradient(circle, rgba(59, 130, 246, 0.15), transparent);
            bottom: -80px;
            left: -80px;
            animation-delay: -5s;
        }
        .orb-3 {
            width: 250px;
            height: 250px;
            background: radial-gradient(circle, rgba(16, 185, 129, 0.12), transparent);
            top: 50%;
            left: 60%;
            animation-delay: -10s;
        }

        @keyframes orbFloat {
            0% { transform: translate(0, 0) scale(1); }
            100% { transform: translate(30px, -30px) scale(1.1); }
        }

        /* ====== Grid Pattern Overlay ====== */
        .grid-pattern {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: 
                linear-gradient(rgba(238, 77, 45, 0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(238, 77, 45, 0.03) 1px, transparent 1px);
            background-size: 60px 60px;
            mask-image: radial-gradient(ellipse at center, black 30%, transparent 70%);
            -webkit-mask-image: radial-gradient(ellipse at center, black 30%, transparent 70%);
        }
        .dark .grid-pattern {
            background-image: 
                linear-gradient(rgba(238, 77, 45, 0.05) 1px, transparent 1px),
                linear-gradient(90deg, rgba(238, 77, 45, 0.05) 1px, transparent 1px);
        }

        /* ====== Layout ====== */
        .auth-container {
            display: flex;
            min-height: 100vh;
            position: relative;
            z-index: 1;
        }

        /* ====== Brand Side (Left) ====== */
        .brand-side {
            display: none;
            width: 45%;
            background: linear-gradient(135deg, #ee4d2d 0%, #d63e1f 50%, #b8301a 100%);
            position: relative;
            overflow: hidden;
            padding: 48px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            color: white;
        }

        .brand-side::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: 
                radial-gradient(circle at 20% 80%, rgba(255,255,255,0.08) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(255,255,255,0.05) 0%, transparent 50%);
        }

        .brand-side::after {
            content: '';
            position: absolute;
            bottom: -20%;
            right: -20%;
            width: 60%;
            height: 60%;
            border-radius: 50%;
            background: rgba(255,255,255,0.04);
        }

        .brand-content {
            position: relative;
            z-index: 1;
            max-width: 420px;
        }

        .brand-logo {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 40px;
        }

        .brand-logo-icon {
            width: 48px;
            height: 48px;
            background: rgba(255,255,255,0.2);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            backdrop-filter: blur(4px);
            border: 1px solid rgba(255,255,255,0.15);
        }

        .brand-logo-text {
            font-size: 24px;
            font-weight: 800;
            letter-spacing: -0.5px;
        }

        .brand-title {
            font-size: 32px;
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 16px;
            letter-spacing: -0.5px;
        }

        .brand-desc {
            font-size: 14px;
            line-height: 1.6;
            opacity: 0.85;
            margin-bottom: 40px;
        }

        .brand-features {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .brand-feature {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 13px;
            opacity: 0.9;
        }

        .brand-feature-icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            background: rgba(255,255,255,0.12);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            flex-shrink: 0;
            backdrop-filter: blur(4px);
            border: 1px solid rgba(255,255,255,0.08);
        }

        /* ====== Form Side (Right) ====== */
        .form-side {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }

        .form-wrapper {
            width: 100%;
            max-width: 400px;
        }

        .form-header {
            text-align: center;
            margin-bottom: 32px;
        }

        /* Mobile Logo (shown on small screens) */
        .mobile-logo {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 24px;
        }
        .mobile-logo-icon {
            width: 36px;
            height: 36px;
            background: var(--primary);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 16px;
        }
        .mobile-logo-text {
            font-size: 20px;
            font-weight: 700;
            color: var(--primary);
            letter-spacing: -0.3px;
        }

        .form-title {
            font-size: 20px;
            font-weight: 700;
            color: #1e293b;
            letter-spacing: -0.3px;
        }
        .dark .form-title {
            color: #f1f5f9;
        }

        .form-subtitle {
            font-size: 13px;
            color: #64748b;
            margin-top: 6px;
        }
        .dark .form-subtitle {
            color: #94a3b8;
        }

        /* ====== Card ====== */
        .auth-card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            border-radius: 16px;
            padding: 32px;
            box-shadow: 
                0 4px 6px -1px rgba(0, 0, 0, 0.04),
                0 10px 30px -8px rgba(0, 0, 0, 0.08),
                0 0 0 1px rgba(0, 0, 0, 0.02);
            transition: all 0.3s ease;
        }
        .dark .auth-card {
            background: rgba(30, 30, 46, 0.85);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.06);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.2),
                        0 10px 30px -8px rgba(0, 0, 0, 0.3);
        }

        /* ====== Form Elements ====== */
        .form-group {
            margin-bottom: 18px;
        }

        .form-label {
            display: block;
            font-size: 12px;
            font-weight: 600;
            color: #334155;
            margin-bottom: 6px;
            letter-spacing: 0.2px;
        }
        .dark .form-label {
            color: #cbd5e1;
        }

        .form-label-icon {
            margin-right: 6px;
            color: var(--primary);
            font-size: 10px;
        }

        .form-input {
            width: 100%;
            padding: 10px 14px;
            background: #f8fafc;
            border: 1.5px solid #e2e8f0;
            border-radius: 10px;
            font-size: 13px;
            color: #1e293b;
            transition: all 0.2s ease;
            outline: none;
            font-family: 'Inter', sans-serif;
        }
        .dark .form-input {
            background: rgba(255, 255, 255, 0.04);
            border-color: rgba(255, 255, 255, 0.1);
            color: #f1f5f9;
        }

        .form-input::placeholder {
            color: #94a3b8;
        }
        .dark .form-input::placeholder {
            color: rgba(255, 255, 255, 0.3);
        }

        .form-input:focus {
            background: #ffffff;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px var(--primary-glow);
        }
        .dark .form-input:focus {
            background: rgba(255, 255, 255, 0.06);
            border-color: var(--primary-light);
            box-shadow: 0 0 0 3px rgba(238, 77, 45, 0.15);
        }

        .form-input.error {
            border-color: #ef4444;
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
        }

        .form-error {
            color: #ef4444;
            font-size: 11px;
            margin-top: 4px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        /* ====== Password Input with Toggle ====== */
        .password-wrapper {
            position: relative;
        }

        .password-toggle {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #94a3b8;
            cursor: pointer;
            padding: 4px;
            font-size: 13px;
            transition: color 0.2s;
        }
        .password-toggle:hover {
            color: var(--primary);
        }
        .dark .password-toggle {
            color: rgba(255, 255, 255, 0.3);
        }
        .dark .password-toggle:hover {
            color: var(--primary-light);
        }

        /* ====== Checkbox ====== */
        .checkbox-wrapper {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
        }

        .checkbox-wrapper input[type="checkbox"] {
            width: 16px;
            height: 16px;
            border-radius: 4px;
            border: 1.5px solid #cbd5e1;
            accent-color: var(--primary);
            cursor: pointer;
            flex-shrink: 0;
        }
        .dark .checkbox-wrapper input[type="checkbox"] {
            border-color: rgba(255, 255, 255, 0.2);
        }

        .checkbox-label {
            font-size: 12px;
            color: #64748b;
            user-select: none;
        }
        .dark .checkbox-label {
            color: #94a3b8;
        }

        /* ====== Submit Button ====== */
        .btn-submit {
            width: 100%;
            padding: 11px 20px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            position: relative;
            overflow: hidden;
        }

        .btn-submit::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.15), transparent);
            transition: left 0.5s ease;
        }

        .btn-submit:hover::before {
            left: 100%;
        }

        .btn-submit:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(238, 77, 45, 0.3);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        .btn-submit:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        /* ====== Divider ====== */
        .divider {
            display: flex;
            align-items: center;
            margin: 22px 0;
        }

        .divider-line {
            flex-grow: 1;
            height: 1px;
            background: #e2e8f0;
        }
        .dark .divider-line {
            background: rgba(255, 255, 255, 0.08);
        }

        .divider-text {
            flex-shrink: 0;
            padding: 0 16px;
            font-size: 11px;
            font-weight: 500;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .dark .divider-text {
            color: rgba(255, 255, 255, 0.3);
        }

        /* ====== Social Button ====== */
        .btn-google {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 10px 20px;
            background: #ffffff;
            border: 1.5px solid #e2e8f0;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 500;
            color: #334155;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
        }
        .dark .btn-google {
            background: rgba(255, 255, 255, 0.04);
            border-color: rgba(255, 255, 255, 0.1);
            color: #e2e8f0;
        }

        .btn-google:hover {
            background: #f8fafc;
            border-color: #cbd5e1;
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }
        .dark .btn-google:hover {
            background: rgba(255, 255, 255, 0.08);
            border-color: rgba(255, 255, 255, 0.15);
        }

        .btn-google svg {
            width: 18px;
            height: 18px;
            flex-shrink: 0;
        }

        /* ====== Footer Link ====== */
        .auth-footer {
            text-align: center;
            margin-top: 20px;
        }

        .auth-footer-text {
            font-size: 12px;
            color: #64748b;
        }
        .dark .auth-footer-text {
            color: #94a3b8;
        }

        .auth-footer-link {
            color: var(--primary);
            font-weight: 600;
            text-decoration: none;
            transition: color 0.2s;
        }
        .auth-footer-link:hover {
            color: var(--primary-dark);
            text-decoration: underline;
        }
        .dark .auth-footer-link:hover {
            color: var(--primary-light);
        }

        /* ====== Theme Toggle ====== */
        .theme-toggle {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 10;
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: #64748b;
            transition: all 0.3s ease;
            font-size: 16px;
        }
        .dark .theme-toggle {
            background: rgba(30, 30, 46, 0.8);
            border-color: rgba(255, 255, 255, 0.08);
            color: #94a3b8;
        }

        .theme-toggle:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            color: var(--primary);
        }

        /* ====== Responsive ====== */
        @media (min-width: 1024px) {
            .brand-side {
                display: flex;
            }
            .mobile-logo {
                display: none;
            }
        }

        @media (max-width: 1023px) {
            .form-side {
                padding: 32px 24px;
            }
            .auth-card {
                padding: 28px 24px;
            }
        }

        @media (max-width: 480px) {
            .auth-card {
                padding: 24px 20px;
                border-radius: 12px;
            }
            .form-title {
                font-size: 18px;
            }
            .theme-toggle {
                top: 12px;
                right: 12px;
                width: 36px;
                height: 36px;
            }
        }

        /* ====== Shake Animation for Errors ====== */
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-3px); }
            20%, 40%, 60%, 80% { transform: translateX(3px); }
        }

        .shake {
            animation: shake 0.5s ease-in-out;
        }

        /* ====== Fade In Animation ====== */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-in {
            animation: fadeInUp 0.6s ease-out forwards;
            opacity: 0;
        }

        .animate-in-delay-1 { animation-delay: 0.1s; }
        .animate-in-delay-2 { animation-delay: 0.2s; }
        .animate-in-delay-3 { animation-delay: 0.3s; }
        .animate-in-delay-4 { animation-delay: 0.4s; }
    </style>
</head>
<body>
    <!-- Background -->
    <div class="auth-bg">
        <div class="grid-pattern"></div>
        <div class="orb orb-1"></div>
        <div class="orb orb-2"></div>
        <div class="orb orb-3"></div>
    </div>

    <!-- Theme Toggle -->
    <button class="theme-toggle" onclick="toggleTheme()" id="themeToggleBtn" title="Toggle theme">
        <i id="themeIcon" class="fas fa-moon"></i>
    </button>

    <div class="auth-container">
        <!-- Brand Side -->
        <div class="brand-side">
            <div class="brand-content">
                <div class="brand-logo">
                    <div class="brand-logo-icon"><i class="fas fa-store"></i></div>
                    <div class="brand-logo-text">Warasa</div>
                </div>
                <h1 class="brand-title">Kelola Toko Online Anda dengan Lebih Cerdas</h1>
                <p class="brand-desc">
                    Warasa membantu Anda membuat, mengelola, dan mengoptimalkan produk toko online 
                    dengan kecerdasan buatan. Tingkatkan penjualan Anda sekarang.
                </p>
                <div class="brand-features">
                    <div class="brand-feature">
                        <div class="brand-feature-icon"><i class="fas fa-robot"></i></div>
                        <span>Generate deskripsi produk dengan AI</span>
                    </div>
                    <div class="brand-feature">
                        <div class="brand-feature-icon"><i class="fas fa-calculator"></i></div>
                        <span>Hitung ROAS & profitabilitas campaign</span>
                    </div>
                    <div class="brand-feature">
                        <div class="brand-feature-icon"><i class="fas fa-chart-line"></i></div>
                        <span>Optimasi produk untuk penjualan maksimal</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Side -->
        <div class="form-side">
            <div class="form-wrapper">
                <!-- Mobile Logo -->
                <div class="text-center">
                    <div class="mobile-logo">
                        <div class="mobile-logo-icon"><i class="fas fa-store"></i></div>
                        <div class="mobile-logo-text">Warasa</div>
                    </div>
                </div>

                <!-- Form Header -->
                <div class="form-header animate-in">
                    <h2 class="form-title">Selamat Datang Kembali</h2>
                    <p class="form-subtitle">Masuk ke akun Warasa Anda</p>
                </div>

                <!-- Auth Card -->
                <div class="auth-card animate-in animate-in-delay-1">
                    <form method="POST" action="{{ route('login') }}" id="loginForm">
                        @csrf

                        <!-- Email -->
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-envelope form-label-icon"></i>
                                Email Address
                            </label>
                            <input type="email" 
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   required 
                                   autocomplete="email" 
                                   autofocus
                                   class="form-input @error('email') error @enderror" 
                                   placeholder="you@example.com">
                            @error('email')
                                <p class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-lock form-label-icon"></i>
                                Password
                            </label>
                            <div class="password-wrapper">
                                <input type="password" 
                                       name="password" 
                                       required 
                                       autocomplete="current-password"
                                       class="form-input @error('password') error @enderror" 
                                       placeholder="••••••••"
                                       id="loginPassword">
                                <button type="button" class="password-toggle" onclick="togglePassword('loginPassword', this)" tabindex="-1">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            @error('password')
                                <p class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Remember & Forgot -->
                        <div class="flex items-center justify-between mb-5">
                            <label class="checkbox-wrapper">
                                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                <span class="checkbox-label">Ingat saya</span>
                            </label>
                            
                        </div>

                        <!-- Submit -->
                        <button type="submit" class="btn-submit" id="loginSubmitBtn">
                            <i class="fas fa-sign-in-alt"></i>
                            Masuk
                        </button>
                    </form>

                    <!-- Divider -->
                    <div class="divider">
                        <div class="divider-line"></div>
                        <span class="divider-text">atau</span>
                        <div class="divider-line"></div>
                    </div>

                    <!-- Google Login -->
                    <a href="{{ route('auth.google') }}" class="btn-google">
                        <svg viewBox="0 0 24 24">
                            <path fill="#EA4335" d="M12 5.04c1.78 0 3.39.61 4.65 1.8l3.48-3.48C17.98 1.19 15.15 0 12 0 7.31 0 3.3 2.69 1.4 6.6l3.96 3.07C6.31 6.84 8.94 5.04 12 5.04z"/>
                            <path fill="#4285F4" d="M23.49 12.27c0-.82-.07-1.6-.21-2.27H12v4.51h6.47c-.28 1.48-1.12 2.73-2.38 3.58l3.7 2.87c2.16-1.99 3.4-4.92 3.4-8.69z"/>
                            <path fill="#FBBC05" d="M5.36 14.77C5.12 14.07 5 13.32 5 12.5s.12-1.57.36-2.27L1.4 7.16C.51 8.94 0 10.92 0 12.5s.51 3.56 1.4 5.34l3.96-3.07z"/>
                            <path fill="#34A853" d="M12 24c3.24 0 5.97-1.07 7.96-2.91l-3.7-2.87c-1.03.69-2.35 1.1-4.26 1.1-3.06 0-5.69-1.8-6.61-4.49L1.43 17.9C3.33 21.8 7.34 24 12 24z"/>
                        </svg>
                        Lanjutkan dengan Google
                    </a>

                    <!-- Register Link -->
                    <div class="auth-footer">
                        <p class="auth-footer-text">
                            Belum punya akun? 
                            <a href="{{ route('register') }}" class="auth-footer-link">Daftar sekarang</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // ====== Password Toggle ======
        function togglePassword(inputId, btn) {
            const input = document.getElementById(inputId);
            if (!input) return;
            const icon = btn.querySelector('i');
            if (input.type === 'password') {
                input.type = 'text';
                icon.className = 'fas fa-eye-slash';
            } else {
                input.type = 'password';
                icon.className = 'fas fa-eye';
            }
        }

        // ====== Theme Toggle ======
        function toggleTheme() {
            const isDark = document.documentElement.classList.contains('dark');
            if (isDark) {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('theme', 'light');
            } else {
                document.documentElement.classList.add('dark');
                localStorage.setItem('theme', 'dark');
            }
            updateThemeIcon();
        }

        function updateThemeIcon() {
            const isDark = document.documentElement.classList.contains('dark');
            const icon = document.getElementById('themeIcon');
            if (icon) {
                icon.className = isDark ? 'fas fa-sun' : 'fas fa-moon';
            }
        }

        // ====== Form Loading State ======
        document.getElementById('loginForm')?.addEventListener('submit', function(e) {
            const btn = document.getElementById('loginSubmitBtn');
            if (btn) {
                btn.disabled = true;
                btn.innerHTML = '<i class="fas fa-spinner fa-pulse"></i> Memproses...';
            }
        });

        // ====== Shake on Error ======
        document.addEventListener('DOMContentLoaded', function() {
            const errorInputs = document.querySelectorAll('.form-input.error');
            if (errorInputs.length > 0) {
                const card = document.querySelector('.auth-card');
                if (card) card.classList.add('shake');
                setTimeout(() => {
                    if (card) card.classList.remove('shake');
                }, 500);
            }

            // Load saved theme
            const savedTheme = localStorage.getItem('theme');
            if (savedTheme === 'dark') {
                document.documentElement.classList.add('dark');
            } else if (savedTheme === 'light') {
                document.documentElement.classList.remove('dark');
            }
            updateThemeIcon();
        });

        window.toggleTheme = toggleTheme;
    </script>
</body>
</html>