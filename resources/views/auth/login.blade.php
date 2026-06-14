<!DOCTYPE html>
<html lang="id">
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
        :root { --primary: #ee4d2d; --primary-dark: #d63e1f; --primary-glow: rgba(238,77,45,0.15); }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; min-height: 100vh; background: #f8fafc; }
        .auth-bg { position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: -1; }
        .auth-bg::before { content: ''; position: absolute; top: -50%; left: -50%; width: 200%; height: 200%; background: radial-gradient(circle at 30% 40%, rgba(238,77,45,0.03) 0%, transparent 50%); animation: bgShift 20s ease-in-out infinite alternate; }
        @keyframes bgShift { 0% { transform: translate(0,0); } 100% { transform: translate(5%,5%); } }
        .orb { position: absolute; border-radius: 50%; filter: blur(80px); opacity: 0.4; }
        .orb-1 { width: 300px; height: 300px; background: radial-gradient(circle, rgba(238,77,45,0.2), transparent); top: -80px; right: -80px; }
        .orb-2 { width: 250px; height: 250px; background: radial-gradient(circle, rgba(59,130,246,0.15), transparent); bottom: -60px; left: -60px; }
        .auth-container { display: flex; min-height: 100vh; position: relative; z-index: 1; }
        .brand-side { display: none; width: 45%; background: linear-gradient(135deg, #ee4d2d 0%, #d63e1f 50%, #b8301a 100%); position: relative; overflow: hidden; padding: 48px; flex-direction: column; justify-content: center; color: white; }
        .brand-side::before { content: ''; position: absolute; inset: 0; background: radial-gradient(circle at 20% 80%, rgba(255,255,255,0.08) 0%, transparent 50%); }
        .brand-content { position: relative; z-index: 1; max-width: 420px; }
        .brand-logo { display: inline-flex; align-items: center; gap: 12px; margin-bottom: 40px; }
        .brand-logo-icon { width: 48px; height: 48px; background: rgba(255,255,255,0.2); border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 22px; backdrop-filter: blur(4px); border: 1px solid rgba(255,255,255,0.15); }
        .brand-logo-text { font-size: 24px; font-weight: 800; }
        .brand-title { font-size: 32px; font-weight: 800; line-height: 1.2; margin-bottom: 16px; }
        .brand-desc { font-size: 14px; line-height: 1.6; opacity: 0.85; margin-bottom: 40px; }
        .brand-features { display: flex; flex-direction: column; gap: 16px; }
        .brand-feature { display: flex; align-items: center; gap: 12px; font-size: 13px; opacity: 0.9; }
        .brand-feature-icon { width: 32px; height: 32px; border-radius: 8px; background: rgba(255,255,255,0.12); display: flex; align-items: center; justify-content: center; font-size: 12px; flex-shrink: 0; border: 1px solid rgba(255,255,255,0.08); }
        .form-side { flex: 1; display: flex; align-items: center; justify-content: center; padding: 24px 16px; }
        .form-wrapper { width: 100%; max-width: 400px; }
        .mobile-logo { display: inline-flex; align-items: center; gap: 8px; margin-bottom: 24px; }
        .mobile-logo-icon { width: 36px; height: 36px; background: var(--primary); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: white; font-size: 16px; }
        .mobile-logo-text { font-size: 20px; font-weight: 700; color: var(--primary); }
        .form-header { text-align: center; margin-bottom: 28px; }
        .form-title { font-size: 20px; font-weight: 700; color: #1e293b; }
        .form-subtitle { font-size: 13px; color: #64748b; margin-top: 6px; }
        .auth-card { background: rgba(255,255,255,0.9); backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,0.5); border-radius: 16px; padding: 28px; box-shadow: 0 4px 24px rgba(0,0,0,0.06); }
        .form-group { margin-bottom: 16px; }
        .form-label { display: block; font-size: 12px; font-weight: 600; color: #334155; margin-bottom: 6px; }
        .form-label-icon { margin-right: 6px; color: var(--primary); font-size: 10px; }
        .form-input { width: 100%; padding: 10px 14px; background: #f8fafc; border: 1.5px solid #e2e8f0; border-radius: 10px; font-size: 14px; color: #1e293b; outline: none; font-family: 'Inter', sans-serif; transition: all 0.2s; }
        .form-input::placeholder { color: #94a3b8; }
        .form-input:focus { background: #fff; border-color: var(--primary); box-shadow: 0 0 0 3px var(--primary-glow); }
        .form-input.error { border-color: #ef4444; }
        .form-error { color: #ef4444; font-size: 11px; margin-top: 4px; }
        .password-wrapper { position: relative; }
        .password-toggle { position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none; border: none; color: #94a3b8; cursor: pointer; font-size: 13px; }
        .password-toggle:hover { color: var(--primary); }
        .checkbox-wrapper { display: flex; align-items: center; gap: 8px; cursor: pointer; }
        .checkbox-wrapper input { width: 16px; height: 16px; accent-color: var(--primary); }
        .checkbox-label { font-size: 12px; color: #64748b; }
        .btn-submit { width: 100%; padding: 12px 20px; background: linear-gradient(135deg, var(--primary), var(--primary-dark)); color: white; border: none; border-radius: 10px; font-size: 14px; font-weight: 600; cursor: pointer; transition: all 0.3s; display: flex; align-items: center; justify-content: center; gap: 8px; }
        .btn-submit:hover { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(238,77,45,0.3); }
        .btn-submit:disabled { opacity: 0.6; cursor: not-allowed; transform: none; }
        .divider { display: flex; align-items: center; margin: 20px 0; }
        .divider-line { flex-grow: 1; height: 1px; background: #e2e8f0; }
        .divider-text { padding: 0 16px; font-size: 11px; font-weight: 500; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.5px; }
        .btn-google { width: 100%; display: flex; align-items: center; justify-content: center; gap: 10px; padding: 10px 20px; background: #fff; border: 1.5px solid #e2e8f0; border-radius: 10px; font-size: 13px; font-weight: 500; color: #334155; cursor: pointer; transition: all 0.2s; text-decoration: none; }
        .btn-google:hover { background: #f8fafc; border-color: #cbd5e1; }
        .btn-google svg { width: 18px; height: 18px; }
        .auth-footer { text-align: center; margin-top: 20px; }
        .auth-footer-text { font-size: 12px; color: #64748b; }
        .auth-footer-link { color: var(--primary); font-weight: 600; text-decoration: none; }
        .auth-footer-link:hover { text-decoration: underline; }
        @media (min-width: 1024px) { .brand-side { display: flex; } .mobile-logo { display: none; } }
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        .animate-in { animation: fadeInUp 0.5s ease-out forwards; }
    </style>
</head>
<body>
    <div class="auth-bg">
        <div class="orb orb-1"></div>
        <div class="orb orb-2"></div>
    </div>
    <div class="auth-container">
        <div class="brand-side">
            <div class="brand-content">
                <div class="brand-logo">
                    <div class="brand-logo-icon"><i class="fas fa-store"></i></div>
                    <div class="brand-logo-text">Warasa</div>
                </div>
                <h1 class="brand-title">Kelola Toko Online Anda dengan Lebih Cerdas</h1>
                <p class="brand-desc">Warasa membantu Anda membuat, mengelola, dan mengoptimalkan produk toko online dengan kecerdasan buatan.</p>
                <div class="brand-features">
                    <div class="brand-feature"><div class="brand-feature-icon"><i class="fas fa-robot"></i></div><span>Generate deskripsi produk dengan AI</span></div>
                    <div class="brand-feature"><div class="brand-feature-icon"><i class="fas fa-calculator"></i></div><span>Hitung ROAS & profitabilitas campaign</span></div>
                    <div class="brand-feature"><div class="brand-feature-icon"><i class="fas fa-chart-line"></i></div><span>Optimasi produk untuk penjualan maksimal</span></div>
                </div>
            </div>
        </div>
        <div class="form-side">
            <div class="form-wrapper">
                <div class="text-center">
                    <div class="mobile-logo">
                        <div class="mobile-logo-icon"><i class="fas fa-store"></i></div>
                        <div class="mobile-logo-text">Warasa</div>
                    </div>
                </div>
                <div class="form-header animate-in">
                    <h2 class="form-title">Selamat Datang Kembali</h2>
                    <p class="form-subtitle">Masuk ke akun Warasa Anda</p>
                </div>
                <div class="auth-card animate-in">
                    <form method="POST" action="{{ route('login') }}" id="loginForm">
                        @csrf
                        <div class="form-group">
                            <label class="form-label"><i class="fas fa-envelope form-label-icon"></i>Email Address</label>
                            <input type="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus class="form-input @error('email') error @enderror" placeholder="you@example.com">
                            @error('email')<p class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>@enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label"><i class="fas fa-lock form-label-icon"></i>Password</label>
                            <div class="password-wrapper">
                                <input type="password" name="password" required autocomplete="current-password" class="form-input @error('password') error @enderror" placeholder="&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;" id="loginPassword">
                                <button type="button" class="password-toggle" onclick="togglePassword('loginPassword', this)" tabindex="-1"><i class="fas fa-eye"></i></button>
                            </div>
                            @error('password')<p class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>@enderror
                        </div>
                        <div class="flex items-center justify-between mb-5">
                            <label class="checkbox-wrapper">
                                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                <span class="checkbox-label">Ingat saya</span>
                            </label>
                        </div>
                        <button type="submit" class="btn-submit" id="loginSubmitBtn"><i class="fas fa-sign-in-alt"></i> Masuk</button>
                    </form>
                    <div class="divider"><div class="divider-line"></div><span class="divider-text">atau</span><div class="divider-line"></div></div>
                    <a href="{{ route('auth.google') }}" class="btn-google">
                        <svg viewBox="0 0 24 24"><path fill="#EA4335" d="M12 5.04c1.78 0 3.39.61 4.65 1.8l3.48-3.48C17.98 1.19 15.15 0 12 0 7.31 0 3.3 2.69 1.4 6.6l3.96 3.07C6.31 6.84 8.94 5.04 12 5.04z"/><path fill="#4285F4" d="M23.49 12.27c0-.82-.07-1.6-.21-2.27H12v4.51h6.47c-.28 1.48-1.12 2.73-2.38 3.58l3.7 2.87c2.16-1.99 3.4-4.92 3.4-8.69z"/><path fill="#FBBC05" d="M5.36 14.77C5.12 14.07 5 13.32 5 12.5s.12-1.57.36-2.27L1.4 7.16C.51 8.94 0 10.92 0 12.5s.51 3.56 1.4 5.34l3.96-3.07z"/><path fill="#34A853" d="M12 24c3.24 0 5.97-1.07 7.96-2.91l-3.7-2.87c-1.03.69-2.35 1.1-4.26 1.1-3.06 0-5.69-1.8-6.61-4.49L1.43 17.9C3.33 21.8 7.34 24 12 24z"/></svg>
                        Lanjutkan dengan Google
                    </a>
                    <div class="auth-footer">
                        <p class="auth-footer-text">Belum punya akun? <a href="{{ route('register') }}" class="auth-footer-link">Daftar sekarang</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function togglePassword(inputId, btn) {
            const input = document.getElementById(inputId);
            if (!input) return;
            const icon = btn.querySelector('i');
            if (input.type === 'password') { input.type = 'text'; icon.className = 'fas fa-eye-slash'; }
            else { input.type = 'password'; icon.className = 'fas fa-eye'; }
        }
        document.getElementById('loginForm')?.addEventListener('submit', function() {
            const btn = document.getElementById('loginSubmitBtn');
            if (btn) { btn.disabled = true; btn.innerHTML = '<i class="fas fa-spinner fa-pulse"></i> Memproses...'; }
        });
    </script>
</body>
</html>