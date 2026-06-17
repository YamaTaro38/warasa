<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Warasa') }} – Admin Dashboard</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&display=swap" rel="stylesheet">

    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --primary: #ee4d2d;
            --primary-dark: #d63e1f;
            --primary-light: #fff0eb;
            --gray-50: #f8fafc;
            --gray-100: #f1f5f9;
            --gray-200: #e2e8f0;
            --gray-300: #cbd5e1;
            --gray-400: #94a3b8;
            --gray-500: #64748b;
            --gray-600: #475569;
            --gray-700: #334155;
            --gray-800: #1e293b;
            --gray-900: #0f172a;
            --shadow-sm: 0 1px 2px rgba(0, 0, 0, 0.03);
            --shadow-md: 0 1px 3px rgba(0, 0, 0, 0.08);
            --shadow-lg: 0 4px 12px rgba(0, 0, 0, 0.08);
            --radius-sm: 6px;
            --radius-md: 8px;
            --radius-lg: 12px;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --info: #3b82f6;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--gray-50);
            color: var(--gray-700);
            line-height: 1.4;
        }

        .dashboard {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: 240px;
            background: white;
            border-right: 1px solid var(--gray-200);
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            z-index: 40;
            display: flex;
            flex-direction: column;
        }

        .sidebar-header {
            padding: 16px;
            border-bottom: 1px solid var(--gray-100);
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .logo-icon {
            width: 28px;
            height: 28px;
            background: var(--primary);
            border-radius: var(--radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 14px;
        }

        .logo-text {
            font-size: 16px;
            font-weight: 700;
            letter-spacing: -0.3px;
            color: var(--gray-800);
        }

        .admin-badge {
            font-size: 9px;
            font-weight: 600;
            background: #fef3c7;
            color: #d97706;
            padding: 2px 6px;
            border-radius: 10px;
            margin-left: auto;
        }

        .sidebar-nav {
            flex: 1;
            padding: 12px 10px;
            overflow-y: auto;
        }

        .nav-group {
            margin-bottom: 16px;
        }

        .nav-label {
            font-size: 10px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            color: var(--gray-400);
            margin-bottom: 8px;
            padding-left: 10px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 10px;
            margin-bottom: 2px;
            color: var(--gray-600);
            font-size: 13px;
            font-weight: 500;
            border-radius: var(--radius-sm);
            transition: all 0.15s;
            text-decoration: none;
        }

        .nav-item i {
            width: 18px;
            font-size: 14px;
            color: var(--gray-500);
        }

        .nav-item:hover {
            background: var(--gray-100);
            color: var(--gray-800);
        }

        .nav-item.active {
            background: var(--primary-light);
            color: var(--primary);
        }

        .nav-item.active i {
            color: var(--primary);
        }

        .nav-badge {
            margin-left: auto;
            background: var(--primary);
            color: white;
            font-size: 10px;
            font-weight: 600;
            padding: 1px 6px;
            border-radius: 20px;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: 240px;
            min-height: 100vh;
        }

        /* Top Bar */
        .top-bar {
            background: white;
            border-bottom: 1px solid var(--gray-200);
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 30;
        }

        .page-title h1 {
            font-size: 15px;
            font-weight: 600;
            color: var(--gray-800);
        }

        .page-title p {
            font-size: 11px;
            color: var(--gray-500);
            margin-top: 1px;
        }

        .user-menu {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .user-name {
            font-size: 12px;
            font-weight: 500;
            color: var(--gray-700);
        }

        .user-avatar {
            width: 28px;
            height: 28px;
            background: var(--primary);
            border-radius: var(--radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 11px;
        }

        .logout-btn {
            background: none;
            border: none;
            color: var(--gray-500);
            cursor: pointer;
            font-size: 13px;
            padding: 6px;
            border-radius: var(--radius-sm);
            transition: all 0.15s;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .logout-btn span {
            font-size: 12px;
        }

        .logout-btn:hover {
            background: var(--gray-100);
            color: var(--primary);
        }

        /* Page Wrapper */
        .page-wrapper {
            padding: 16px 20px;
        }

        /* Cards */
        .card {
            background: white;
            border: 1px solid var(--gray-200);
            border-radius: var(--radius-md);
        }

        .card-header {
            padding: 12px 14px;
            border-bottom: 1px solid var(--gray-200);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-title {
            font-size: 13px;
            font-weight: 600;
            color: var(--gray-800);
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .card-title i {
            color: var(--primary);
            font-size: 13px;
        }

        .card-body {
            padding: 14px;
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
            margin-bottom: 20px;
        }

        .stat-card {
            background: white;
            border: 1px solid var(--gray-200);
            border-radius: var(--radius-md);
            padding: 14px;
            transition: all 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-1px);
            box-shadow: var(--shadow-sm);
        }

        .stat-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .stat-icon {
            width: 32px;
            height: 32px;
            background: var(--primary-light);
            border-radius: var(--radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .stat-icon i {
            font-size: 14px;
            color: var(--primary);
        }

        .stat-value {
            font-size: 20px;
            font-weight: 700;
            color: var(--gray-800);
            margin-bottom: 4px;
        }

        .stat-label {
            font-size: 11px;
            font-weight: 500;
            color: var(--gray-500);
        }

        /* Grid layouts */
        .grid-2 {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
            margin-bottom: 20px;
        }

        /* Tables */
        .table-container {
            overflow-x: auto;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }

        .data-table th {
            text-align: left;
            padding: 10px 12px;
            background: var(--gray-50);
            color: var(--gray-600);
            font-weight: 600;
            border-bottom: 1px solid var(--gray-200);
        }

        .data-table td {
            padding: 10px 12px;
            border-bottom: 1px solid var(--gray-100);
            color: var(--gray-700);
        }

        .data-table tr:hover td {
            background: var(--gray-50);
        }

        /* Badges */
        .badge {
            display: inline-flex;
            align-items: center;
            padding: 2px 8px;
            font-size: 10px;
            font-weight: 600;
            border-radius: 20px;
            gap: 4px;
        }

        .badge-success {
            background: #ecfdf5;
            color: #10b981;
        }

        .badge-warning {
            background: #fffbeb;
            color: #f59e0b;
        }

        .badge-danger {
            background: #fef2f2;
            color: #ef4444;
        }

        .badge-info {
            background: #eff6ff;
            color: #3b82f6;
        }

        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 14px;
            font-size: 12px;
            font-weight: 500;
            border-radius: var(--radius-sm);
            border: 1px solid transparent;
            cursor: pointer;
            transition: all 0.15s;
            text-decoration: none;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
        }

        .btn-outline {
            background: white;
            border-color: var(--gray-300);
            color: var(--gray-700);
        }

        .btn-outline:hover {
            background: var(--gray-100);
            border-color: var(--gray-400);
        }

        .btn-sm {
            padding: 4px 8px;
            font-size: 11px;
        }

        .btn-success {
            background: var(--success);
            color: white;
        }

        .btn-danger {
            background: var(--danger);
            color: white;
        }

        .btn-warning {
            background: var(--warning);
            color: white;
        }

        /* Forms */
        .form-group {
            margin-bottom: 14px;
        }

        .form-label {
            display: block;
            font-size: 11px;
            font-weight: 600;
            color: var(--gray-600);
            margin-bottom: 4px;
        }

        .form-input {
            width: 100%;
            padding: 7px 10px;
            border: 1px solid var(--gray-300);
            border-radius: var(--radius-sm);
            font-size: 12px;
            color: var(--gray-700);
            background: white;
            transition: border-color 0.15s;
        }

        .form-input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(238, 77, 45, 0.1);
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }
        @media (max-width: 768px) {
            .form-grid {
                grid-template-columns: 1fr;
            }
        }

        .form-actions {
            display: flex;
            gap: 8px;
            margin-top: 20px;
            padding-top: 16px;
            border-top: 1px solid var(--gray-200);
        }

        .btn-secondary {
            background: var(--gray-100);
            color: var(--gray-600);
            padding: 8px 16px;
            border-radius: var(--radius-sm);
            font-size: 13px;
            font-weight: 500;
            border: 1px solid var(--gray-200);
            cursor: pointer;
            transition: all 0.15s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .btn-secondary:hover {
            background: var(--gray-200);
        }

        /* Toggle Switch */
        .toggle-switch {
            position: relative;
            display: inline-block;
            width: 36px;
            height: 20px;
            cursor: pointer;
        }

        .toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .toggle-slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: var(--gray-300);
            border-radius: 20px;
            transition: 0.3s;
        }

        .toggle-slider:before {
            content: "";
            position: absolute;
            height: 16px;
            width: 16px;
            left: 2px;
            bottom: 2px;
            background-color: white;
            border-radius: 50%;
            transition: 0.3s;
        }

        .toggle-switch input:checked + .toggle-slider {
            background-color: var(--primary);
        }

        .toggle-switch input:checked + .toggle-slider:before {
            transform: translateX(16px);
        }

        /* Alert */
        .alert {
            padding: 10px 14px;
            border-radius: var(--radius-sm);
            font-size: 12px;
            font-weight: 500;
            margin-bottom: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .alert-success {
            background: #ecfdf5;
            color: #10b981;
            border: 1px solid #d1fae5;
        }

        .alert-danger {
            background: #fef2f2;
            color: #ef4444;
            border: 1px solid #fecaca;
        }

        /* Section Group */
        .section-group {
            background: white;
            border: 1px solid var(--gray-200);
            border-radius: var(--radius-md);
            margin-bottom: 16px;
        }

        .section-header {
            padding: 12px 14px;
            border-bottom: 1px solid var(--gray-200);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .section-title {
            font-size: 13px;
            font-weight: 600;
            color: var(--gray-800);
        }

        .section-body {
            padding: 14px;
        }

        .setting-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid var(--gray-100);
        }

        .setting-row:last-child {
            border-bottom: none;
        }

        .setting-info {
            flex: 1;
        }

        .setting-label {
            font-size: 12px;
            font-weight: 600;
            color: var(--gray-700);
        }

        .setting-desc {
            font-size: 11px;
            color: var(--gray-500);
            margin-top: 2px;
        }

        .setting-value {
            margin-left: 20px;
        }

        .fee-input {
            width: 120px;
            padding: 6px 10px;
            border: 1px solid var(--gray-300);
            border-radius: var(--radius-sm);
            font-size: 12px;
            color: var(--gray-700);
            text-align: right;
        }

        .fee-input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(238, 77, 45, 0.1);
        }

        /* Responsive */
        @media (max-width: 1200px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            .grid-2 {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                position: fixed;
                z-index: 50;
            }
            .main-content {
                margin-left: 0;
            }
            .stats-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <!-- Toast Container -->
    <div id="toastContainer" class="toast-container" style="position:fixed;bottom:20px;right:20px;z-index:10000;display:flex;flex-direction:column;gap:8px;"></div>

    <div class="dashboard">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <div class="logo">
                    <div class="logo-icon">W</div>
                    <div class="logo-text">Warasa</div>
                    <span class="admin-badge">ADMIN</span>
                </div>
            </div>
            <nav class="sidebar-nav">
                <div class="nav-group">
                    <div class="nav-label">Admin Panel</div>
                    <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-chart-pie"></i>
                        <span>Dashboard</span>
                    </a>
                    <a href="{{ route('admin.users') }}" class="nav-item {{ request()->routeIs('admin.users*') ? 'active' : '' }}">
                        <i class="fas fa-users"></i>
                        <span>Users</span>
                    </a>
                </div>
                <div class="nav-group">
                    <div class="nav-label">Management</div>
                    <a href="{{ route('admin.menus.index') }}" class="nav-item {{ request()->routeIs('admin.menus*') ? 'active' : '' }}">
                        <i class="fas fa-bars"></i>
                        <span>Menu Visibility</span>
                    </a>
                    <a href="{{ route('admin.settings.index') }}" class="nav-item {{ request()->routeIs('admin.settings*') ? 'active' : '' }}">
                        <i class="fas fa-sliders-h"></i>
                        <span>Features</span>
                    </a>
                    <a href="{{ route('admin.shopee-fees.index') }}" class="nav-item {{ request()->routeIs('admin.shopee-fees*') ? 'active' : '' }}">
                        <i class="fas fa-calculator"></i>
                        <span>Shopee Fees</span>
                    </a>
                    <a href="{{ route('admin.categories.index') }}" class="nav-item {{ request()->routeIs('admin.categories*') ? 'active' : '' }}">
                        <i class="fas fa-tags"></i>
                        <span>Categories</span>
                    </a>
                    <a href="{{ route('admin.documentations.index') }}" class="nav-item {{ request()->routeIs('admin.documentations*') ? 'active' : '' }}">
                        <i class="fas fa-book"></i>
                        <span>Documentation</span>
                    </a>
                </div>
                <div class="nav-group">
                    <div class="nav-label">API</div>
                    <a href="{{ route('admin.api-keys.index') }}" class="nav-item {{ request()->routeIs('admin.api-keys*') ? 'active' : '' }}">
                        <i class="fas fa-key"></i>
                        <span>API Keys</span>
                    </a>
                </div>
                <div class="nav-group">
                    <div class="nav-label">Back to</div>
                    <a href="{{ route('dashboard') }}" class="nav-item">
                        <i class="fas fa-arrow-left"></i>
                        <span>User Dashboard</span>
                    </a>
                </div>
            </nav>
        </aside>

        <!-- Main -->
        <main class="main-content">
            <div class="top-bar">
                <div class="page-title">
                    <h1>@yield('page-title', 'Admin Dashboard')</h1>
                    <p>@yield('breadcrumb', 'Administration Panel')</p>
                </div>
                <div class="user-menu">
                    <span class="user-name">{{ auth()->user()->name ?? 'Admin' }}</span>
                    @if(auth()->user()->avatar)
                        <img src="{{ auth()->user()->avatar }}" alt="Avatar" style="width:28px;height:28px;border-radius:6px;object-fit:cover;" referrerpolicy="no-referrer">
                    @else
                        <div class="user-avatar">{{ substr(auth()->user()->name ?? 'A', 0, 1) }}</div>
                    @endif
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="logout-btn">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>Logout</span>
                        </button>
                    </form>
                </div>
            </div>
            <div class="page-wrapper">
                @if(session('success'))
                    <div class="alert alert-success" id="successAlert">
                        <i class="fas fa-check-circle"></i>
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger" id="errorAlert">
                        <i class="fas fa-exclamation-circle"></i>
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>

    <script>
        // Auto-dismiss alerts
        setTimeout(() => {
            const alert = document.getElementById('successAlert') || document.getElementById('errorAlert');
            if (alert) {
                alert.style.transition = 'opacity 0.3s';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 300);
            }
        }, 3000);

        // Toast notification
        function showToast(message, type = 'success', duration = 3000) {
            const container = document.getElementById('toastContainer');
            if (!container) return;

            const toastId = 'toast_' + Date.now();
            const toast = document.createElement('div');
            toast.className = 'toast';
            toast.id = toastId;
            toast.style.cssText = 'min-width:280px;max-width:360px;background:white;border-radius:8px;box-shadow:0 10px 25px -8px rgba(0,0,0,0.15);overflow:hidden;transform:translateX(380px);transition:transform 0.3s cubic-bezier(0.68,-0.55,0.265,1.55);';

            const iconMap = {success: 'fa-check-circle', error: 'fa-exclamation-circle', info: 'fa-info-circle', warning: 'fa-exclamation-triangle'};
            const colorMap = {success: '#10b981', error: '#ef4444', info: '#3b82f6', warning: '#f59e0b'};

            toast.innerHTML = `
                <div style="padding:10px 14px;display:flex;align-items:center;gap:10px;">
                    <div style="width:24px;height:24px;border-radius:8px;display:flex;align-items:center;justify-content:center;background:${colorMap[type]}20;color:${colorMap[type]};">
                        <i class="fas ${iconMap[type]}" style="font-size:12px;"></i>
                    </div>
                    <div style="flex:1;font-size:12px;font-weight:500;color:#334155;">${message}</div>
                    <button onclick="this.closest('.toast').remove()" style="background:none;border:none;cursor:pointer;color:#94a3b8;font-size:12px;">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `;

            container.appendChild(toast);
            setTimeout(() => toast.style.transform = 'translateX(0)', 10);
            setTimeout(() => {
                toast.style.transform = 'translateX(380px)';
                setTimeout(() => toast.remove(), 300);
            }, duration);
        }

        // Confirm modal
        function showConfirmModal(options) {
            return new Promise((resolve) => {
                const overlay = document.createElement('div');
                overlay.className = 'modal-overlay';
                overlay.style.cssText = 'position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.5);backdrop-filter:blur(4px);z-index:10001;display:flex;align-items:center;justify-content:center;opacity:0;visibility:hidden;transition:all 0.2s ease;';

                overlay.innerHTML = `
                    <div style="background:white;border-radius:12px;width:400px;max-width:90%;box-shadow:0 20px 40px -12px rgba(0,0,0,0.25);overflow:hidden;">
                        <div style="padding:16px 20px;background:#f8fafc;border-bottom:1px solid #e2e8f0;display:flex;align-items:center;gap:10px;">
                            <i class="fas ${options.type === 'danger' ? 'fa-exclamation-triangle' : 'fa-question-circle'}" style="font-size:18px;color:${options.type === 'danger' ? '#ef4444' : '#f59e0b'};"></i>
                            <div style="font-size:14px;font-weight:600;color:#1e293b;flex:1;">${options.title || 'Confirmation'}</div>
                        </div>
                        <div style="padding:20px;font-size:13px;color:#475569;line-height:1.5;">${options.message}</div>
                        <div style="padding:12px 20px;border-top:1px solid #e2e8f0;display:flex;justify-content:flex-end;gap:10px;">
                            <button class="cancel-btn" style="padding:6px 16px;border-radius:6px;font-size:12px;font-weight:500;cursor:pointer;background:#f1f5f9;color:#475569;border:none;">${options.cancelText || 'Cancel'}</button>
                            <button class="confirm-btn" style="padding:6px 16px;border-radius:6px;font-size:12px;font-weight:500;cursor:pointer;background:${options.type === 'danger' ? '#ef4444' : '#ee4d2d'};color:white;border:none;">${options.confirmText || 'Confirm'}</button>
                        </div>
                    </div>
                `;

                document.body.appendChild(overlay);
                setTimeout(() => {
                    overlay.style.opacity = '1';
                    overlay.style.visibility = 'visible';
                }, 10);

                const closeModal = (result) => {
                    overlay.style.opacity = '0';
                    overlay.style.visibility = 'hidden';
                    setTimeout(() => overlay.remove(), 200);
                    resolve(result);
                };

                overlay.querySelector('.cancel-btn').addEventListener('click', () => closeModal(false));
                overlay.querySelector('.confirm-btn').addEventListener('click', () => closeModal(true));
                overlay.addEventListener('click', (e) => { if (e.target === overlay) closeModal(false); });
            });
        }
    </script>
    @stack('scripts')
    @yield('scripts')
</body>
</html>