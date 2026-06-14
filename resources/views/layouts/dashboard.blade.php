<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Warasa') }} – Dashboard</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&display=swap" rel="stylesheet">

    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- ApexCharts -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

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
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--gray-50);
            color: var(--gray-700);
            line-height: 1.4;
        }

        .dashboard { display: flex; min-height: 100vh; }

        .sidebar {
            width: 240px;
            background: white;
            border-right: 1px solid var(--gray-200);
            position: fixed;
            top: 0; left: 0; bottom: 0;
            z-index: 40;
            display: flex;
            flex-direction: column;
        }

        .sidebar-header { padding: 16px; border-bottom: 1px solid var(--gray-100); }
        .logo { display: flex; align-items: center; gap: 8px; }
        .logo-icon { width: 28px; height: 28px; background: var(--primary); border-radius: var(--radius-sm); display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 14px; }
        .logo-text { font-size: 16px; font-weight: 700; letter-spacing: -0.3px; color: var(--gray-800); }
        .sidebar-nav { flex: 1; padding: 12px 10px; overflow-y: auto; }
        .nav-group { margin-bottom: 16px; }
        .nav-label { font-size: 10px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.6px; color: var(--gray-400); margin-bottom: 8px; padding-left: 10px; }
        .nav-item { display: flex; align-items: center; gap: 10px; padding: 6px 10px; margin-bottom: 2px; color: var(--gray-600); font-size: 13px; font-weight: 500; border-radius: var(--radius-sm); transition: all 0.15s; text-decoration: none; }
        .nav-item i { width: 18px; font-size: 14px; color: var(--gray-500); }
        .nav-item:hover { background: var(--gray-100); color: var(--gray-800); }
        .nav-item.active { background: var(--primary-light); color: var(--primary); }
        .nav-item.active i { color: var(--primary); }
        .nav-badge { margin-left: auto; background: var(--gray-100); color: var(--gray-600); font-size: 10px; font-weight: 600; padding: 1px 6px; border-radius: 20px; }

        .main-content { flex: 1; margin-left: 240px; min-height: 100vh; }

        .top-bar { background: white; border-bottom: 1px solid var(--gray-200); padding: 8px 20px; display: flex; justify-content: space-between; align-items: center; position: sticky; top: 0; z-index: 30; }
        .page-title h1 { font-size: 15px; font-weight: 600; color: var(--gray-800); }
        .page-title p { font-size: 11px; color: var(--gray-500); margin-top: 1px; }
        .user-menu { display: flex; align-items: center; gap: 12px; }
        .user-name { font-size: 12px; font-weight: 500; color: var(--gray-700); }
        .user-avatar { width: 28px; height: 28px; background: var(--primary); border-radius: var(--radius-sm); display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 11px; }
        .logout-btn { background: none; border: none; color: var(--gray-500); cursor: pointer; font-size: 13px; padding: 6px; border-radius: var(--radius-sm); transition: all 0.15s; display: flex; align-items: center; gap: 6px; }
        .logout-btn span { font-size: 12px; }
        .logout-btn:hover { background: var(--gray-100); color: var(--primary); }

        .page-wrapper { padding: 16px 20px; }

        .card { background: white; border: 1px solid var(--gray-200); border-radius: var(--radius-md); }
        .card-header { padding: 10px 14px; border-bottom: 1px solid var(--gray-200); display: flex; justify-content: space-between; align-items: center; }
        .card-title { font-size: 12px; font-weight: 600; color: var(--gray-800); display: flex; align-items: center; gap: 6px; }
        .card-title i { color: var(--primary); font-size: 12px; }
        .card-body { padding: 12px 14px; }

        .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 12px; margin-bottom: 20px; }
        .stat-card { background: white; border: 1px solid var(--gray-200); border-radius: var(--radius-md); padding: 12px; transition: all 0.2s; }
        .stat-card:hover { transform: translateY(-1px); box-shadow: var(--shadow-sm); }
        .stat-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px; }
        .stat-icon { width: 32px; height: 32px; background: var(--primary-light); border-radius: var(--radius-sm); display: flex; align-items: center; justify-content: center; }
        .stat-icon i { font-size: 14px; color: var(--primary); }
        .stat-value { font-size: 20px; font-weight: 700; color: var(--gray-800); margin-bottom: 4px; line-height: 1.2; }
        .stat-label { font-size: 10px; font-weight: 500; color: var(--gray-500); text-transform: uppercase; letter-spacing: 0.4px; }

        .grid-2 { display: grid; grid-template-columns: repeat(2, 1fr); gap: 16px; margin-bottom: 20px; }
        .grid-3 { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; margin-bottom: 20px; }

        .table-container { overflow-x: auto; }
        .data-table { width: 100%; border-collapse: collapse; font-size: 12px; }
        .data-table th { text-align: left; padding: 10px 12px; background: var(--gray-50); color: var(--gray-600); font-weight: 600; border-bottom: 1px solid var(--gray-200); }
        .data-table td { padding: 8px 12px; border-bottom: 1px solid var(--gray-100); color: var(--gray-700); }
        .data-table tr:hover td { background: var(--gray-50); }

        .badge { display: inline-flex; align-items: center; padding: 2px 8px; font-size: 10px; font-weight: 600; border-radius: 20px; gap: 4px; }
        .badge-success { background: #ecfdf5; color: #10b981; }
        .badge-warning { background: #fffbeb; color: #f59e0b; }
        .badge-danger { background: #fef2f2; color: #ef4444; }
        .badge-info { background: #eff6ff; color: #3b82f6; }

        .btn { display: inline-flex; align-items: center; gap: 6px; padding: 6px 12px; font-size: 12px; font-weight: 500; border-radius: var(--radius-sm); border: 1px solid transparent; cursor: pointer; transition: all 0.15s; text-decoration: none; }
        .btn-primary { background: var(--primary); color: white; }
        .btn-primary:hover { background: var(--primary-dark); }
        .btn-outline { background: white; border-color: var(--gray-300); color: var(--gray-700); }
        .btn-outline:hover { background: var(--gray-100); border-color: var(--gray-400); }
        .btn-sm { padding: 4px 8px; font-size: 11px; }

        .list-group { list-style: none; }
        .list-item { display: flex; align-items: center; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid var(--gray-100); }
        .list-item:last-child { border-bottom: none; }
        .list-item-title { font-size: 12px; font-weight: 500; color: var(--gray-700); }
        .list-item-subtitle { font-size: 11px; color: var(--gray-500); margin-top: 2px; }
        .list-item-value { font-size: 12px; font-weight: 600; color: var(--gray-800); }

        @media (max-width: 1200px) {
            .stats-grid { grid-template-columns: repeat(2, 1fr); }
            .grid-2, .grid-3 { grid-template-columns: 1fr; }
        }

        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); position: fixed; z-index: 50; }
            .main-content { margin-left: 0; }
            .stats-grid { grid-template-columns: 1fr; }
            .page-wrapper { padding: 12px 16px; }
            .top-bar { padding: 8px 16px; }
        }

        /* Toast */
        .toast-container { position: fixed; bottom: 20px; right: 20px; z-index: 10000; display: flex; flex-direction: column; gap: 8px; }
        .toast { min-width: 280px; max-width: 360px; background: white; border-radius: var(--radius-md); box-shadow: 0 10px 25px -8px rgba(0,0,0,0.15); overflow: hidden; transform: translateX(380px); transition: transform 0.3s cubic-bezier(0.68,-0.55,0.265,1.55); }
        .toast.show { transform: translateX(0); }
        .toast.removing { transform: translateX(380px); }
        .toast-header { padding: 10px 14px; display: flex; align-items: center; gap: 10px; }
        .toast-icon { width: 24px; height: 24px; border-radius: 8px; display: flex; align-items: center; justify-content: center; }
        .toast-icon.success { background: #d1fae5; color: #10b981; }
        .toast-icon.error { background: #fee2e2; color: #ef4444; }
        .toast-icon.info { background: #dbeafe; color: #3b82f6; }
        .toast-icon.warning { background: #fef3c7; color: #f59e0b; }
        .toast-content { flex: 1; font-size: 12px; font-weight: 500; color: var(--gray-700); }
        .toast-close { background: none; border: none; cursor: pointer; color: var(--gray-400); font-size: 12px; transition: color 0.2s; }
        .toast-close:hover { color: #ef4444; }
        .toast-progress { height: 2px; background: var(--gray-100); }
        .toast-progress-bar { height: 100%; width: 100%; background: linear-gradient(90deg, var(--primary), #fb6a3d); transition: width 0.1s linear; }

        /* Modal */
        .modal-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); backdrop-filter: blur(4px); z-index: 10001; display: flex; align-items: center; justify-content: center; opacity: 0; visibility: hidden; transition: all 0.2s ease; }
        .modal-overlay.active { opacity: 1; visibility: visible; }
        .modal-container { background: white; border-radius: var(--radius-lg); width: 400px; max-width: 90%; box-shadow: 0 20px 40px -12px rgba(0,0,0,0.25); transform: scale(0.95); transition: transform 0.2s ease; overflow: hidden; }
        .modal-overlay.active .modal-container { transform: scale(1); }
        .modal-header { padding: 16px 20px; background: var(--gray-50); border-bottom: 1px solid var(--gray-200); display: flex; align-items: center; gap: 10px; }
        .modal-header i { font-size: 18px; }
        .modal-header.warning i { color: #f59e0b; }
        .modal-header.danger i { color: #ef4444; }
        .modal-header.success i { color: #10b981; }
        .modal-title { font-size: 14px; font-weight: 600; color: var(--gray-800); flex: 1; }
        .modal-body { padding: 20px; font-size: 13px; color: var(--gray-600); line-height: 1.5; }
        .modal-footer { padding: 12px 20px; border-top: 1px solid var(--gray-200); display: flex; justify-content: flex-end; gap: 10px; }
        .modal-btn { padding: 6px 16px; border-radius: var(--radius-sm); font-size: 12px; font-weight: 500; cursor: pointer; transition: all 0.2s; border: none; }
        .modal-btn-cancel { background: var(--gray-100); color: var(--gray-600); }
        .modal-btn-cancel:hover { background: var(--gray-200); }
        .modal-btn-confirm { background: var(--primary); color: white; }
        .modal-btn-confirm:hover { background: var(--primary-dark); }
        .modal-btn-danger { background: #ef4444; color: white; }
        .modal-btn-danger:hover { background: #dc2626; }
    </style>
</head>

<body>
    <div id="toastContainer" class="toast-container"></div>

    <div class="dashboard">
        <aside class="sidebar">
            <div class="sidebar-header">
                <div class="logo">
                    <div class="logo-icon">W</div>
                    <div class="logo-text">Warasa</div>
                </div>
            </div>
            <nav class="sidebar-nav">
                @php
                    $menuVisibilities = [];
                    try {
                        if (\Illuminate\Support\Facades\Schema::hasTable('menu_visibilities')) {
                            $menuVisibilities = \App\Models\MenuVisibility::get()->keyBy('menu_key');
                        }
                    } catch (\Exception $e) {}
                @endphp

                @if(($menuVisibilities['dashboard']->is_visible ?? true) || ($menuVisibilities['products']->is_visible ?? true))
                <div class="nav-group">
                    <div class="nav-label">Main</div>
                    @if($menuVisibilities['dashboard']->is_visible ?? true)
                    <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="fas fa-chart-pie"></i>
                        <span>Dashboard</span>
                    </a>
                    @endif
                    @if($menuVisibilities['products']->is_visible ?? true)
                    <a href="{{ route('products.index') }}" class="nav-item {{ request()->routeIs('products.*') ? 'active' : '' }}">
                        <i class="fas fa-cubes"></i>
                        <span>Products</span>
                        <span class="nav-badge">{{ $totalProducts ?? 0 }}</span>
                    </a>
                    @endif
                </div>
                @endif

                @if(($menuVisibilities['generator_quick']->is_visible ?? true) || ($menuVisibilities['generator_smart']->is_visible ?? true) || ($menuVisibilities['roas_calculator']->is_visible ?? true) || ($menuVisibilities['shopee_fee_calculator']->is_visible ?? true))
                <div class="nav-group">
                    <div class="nav-label">Generator</div>
                    @if($menuVisibilities['generator_quick']->is_visible ?? true)
                    <a href="{{ route('generator.quick') }}" class="nav-item {{ request()->routeIs('generator.quick') ? 'active' : '' }}">
                        <i class="fas fa-bolt"></i>
                        <span>Quick Generate</span>
                    </a>
                    @endif
                    @if($menuVisibilities['generator_smart']->is_visible ?? true)
                    <a href="{{ route('generator.smart') }}" class="nav-item {{ request()->routeIs('generator.smart') ? 'active' : '' }}">
                        <i class="fas fa-brain"></i>
                        <span>Smart Generate</span>
                    </a>
                    @endif
                    @if($menuVisibilities['roas_calculator']->is_visible ?? true)
                    <a href="{{ route('roas.calculator') }}" class="nav-item {{ request()->routeIs('roas.calculator') ? 'active' : '' }}">
                        <i class="fas fa-file-excel"></i>
                        <span>ROAS Calculator</span>
                    </a>
                    @endif
                    @if($menuVisibilities['shopee_fee_calculator']->is_visible ?? true)
                    <a href="{{ route('shopee.fee.calculator') }}" class="nav-item {{ request()->routeIs('shopee.fee.calculator') ? 'active' : '' }}">
                        <i class="fas fa-calculator"></i>
                        <span>Shopee Fee Calc.</span>
                    </a>
                    @endif
                </div>
                @endif

                @if(($menuVisibilities['chatbot']->is_visible ?? false) || ($menuVisibilities['settings']->is_visible ?? false))
                <div class="nav-group">
                    <div class="nav-label">Workspace</div>
                    @if($menuVisibilities['chatbot']->is_visible ?? false)
                    <a href="{{ route('chatbot') }}" class="nav-item {{ request()->routeIs('chatbot*') ? 'active' : '' }}">
                        <i class="fas fa-robot"></i>
                        <span>Chatbot</span>
                    </a>
                    @endif
                    @if($menuVisibilities['settings']->is_visible ?? false)
                    <a href="{{ route('profile.edit') }}" class="nav-item">
                        <i class="fas fa-user-cog"></i>
                        <span>Settings</span>
                    </a>
                    @endif
                </div>
                @endif

                @if(auth()->user()->isAdmin() ?? false)
                <div class="nav-group">
                    <div class="nav-label">Admin</div>
                    <a href="{{ route('admin.dashboard') }}" class="nav-item">
                        <i class="fas fa-shield-alt"></i>
                        <span>Admin Panel</span>
                    </a>
                </div>
                @endif
            </nav>
        </aside>

        <main class="main-content">
            <div class="top-bar">
                <div class="page-title">
                    <h1>@yield('page-title', 'Dashboard')</h1>
                    <p>@yield('breadcrumb', 'Welcome back')</p>
                </div>
                <div class="user-menu">
                    <span class="user-name">{{ auth()->user()->name ?? 'User' }}</span>
                    <div class="user-avatar">{{ substr(auth()->user()->name ?? 'U', 0, 1) }}</div>
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
                @yield('content')
            </div>
        </main>
    </div>
    @livewireScripts
    <script>
        function showToast(message, type = 'success', duration = 3000) {
            const container = document.getElementById('toastContainer');
            if (!container) return;
            const toastId = 'toast_' + Date.now() + '_' + Math.random().toString(36).substr(2, 6);
            const toast = document.createElement('div');
            toast.className = 'toast';
            toast.id = toastId;
            let iconClass = 'fa-check-circle';
            let iconBg = 'success';
            if (type === 'error') { iconClass = 'fa-exclamation-circle'; iconBg = 'error'; }
            else if (type === 'info') { iconClass = 'fa-info-circle'; iconBg = 'info'; }
            else if (type === 'warning') { iconClass = 'fa-exclamation-triangle'; iconBg = 'warning'; }
            toast.innerHTML = `<div class="toast-header"><div class="toast-icon ${iconBg}"><i class="fas ${iconClass}"></i></div><div class="toast-content">${message}</div><button class="toast-close" onclick="closeToast('${toastId}')"><i class="fas fa-times"></i></button></div><div class="toast-progress"><div class="toast-progress-bar" style="width:100%;"></div></div>`;
            container.appendChild(toast);
            setTimeout(() => toast.classList.add('show'), 10);
            const progressBar = toast.querySelector('.toast-progress-bar');
            let startTime = Date.now();
            const interval = setInterval(() => { const elapsed = Date.now() - startTime; const remaining = Math.max(0, ((duration - elapsed) / duration) * 100); progressBar.style.width = remaining + '%'; if (remaining <= 0) clearInterval(interval); }, 50);
            setTimeout(() => { closeToast(toastId); }, duration);
        }
        function closeToast(toastId) { const toast = document.getElementById(toastId); if (toast) { toast.classList.add('removing'); setTimeout(() => toast.remove(), 300); } }
        function showConfirmModal(options) {
            return new Promise((resolve) => {
                const modalId = 'confirm_modal_' + Date.now();
                const overlay = document.createElement('div');
                overlay.className = 'modal-overlay';
                overlay.id = modalId;
                const iconMap = { danger: 'fa-exclamation-triangle', warning: 'fa-exclamation-triangle', success: 'fa-check-circle', info: 'fa-info-circle' };
                const icon = iconMap[options.type] || 'fa-question-circle';
                const headerClass = options.type === 'danger' ? 'danger' : (options.type === 'warning' ? 'warning' : '');
                overlay.innerHTML = `<div class="modal-container"><div class="modal-header ${headerClass}"><i class="fas ${icon}"></i><div class="modal-title">${options.title || 'Confirmation'}</div></div><div class="modal-body">${options.message}</div><div class="modal-footer"><button class="modal-btn modal-btn-cancel" id="cancelBtn_${modalId}">${options.cancelText || 'Cancel'}</button><button class="modal-btn ${options.type === 'danger' ? 'modal-btn-danger' : 'modal-btn-confirm'}" id="confirmBtn_${modalId}">${options.confirmText || 'Confirm'}</button></div></div>`;
                document.body.appendChild(overlay);
                setTimeout(() => overlay.classList.add('active'), 10);
                const cancelBtn = document.getElementById(`cancelBtn_${modalId}`);
                const confirmBtn = document.getElementById(`confirmBtn_${modalId}`);
                const closeModal = (result) => { overlay.classList.remove('active'); setTimeout(() => overlay.remove(), 300); resolve(result); };
                cancelBtn.addEventListener('click', () => closeModal(false));
                confirmBtn.addEventListener('click', () => closeModal(true));
                overlay.addEventListener('click', (e) => { if (e.target === overlay) closeModal(false); });
            });
        }
        function showAlertModal(options) {
            return new Promise((resolve) => {
                const modalId = 'alert_modal_' + Date.now();
                const overlay = document.createElement('div');
                overlay.className = 'modal-overlay';
                overlay.id = modalId;
                const iconMap = { success: 'fa-check-circle', error: 'fa-exclamation-circle', warning: 'fa-exclamation-triangle', info: 'fa-info-circle' };
                const icon = iconMap[options.type] || 'fa-info-circle';
                const headerClass = options.type === 'error' ? 'danger' : (options.type === 'warning' ? 'warning' : (options.type === 'success' ? 'success' : ''));
                overlay.innerHTML = `<div class="modal-container"><div class="modal-header ${headerClass}"><i class="fas ${icon}"></i><div class="modal-title">${options.title || 'Notification'}</div></div><div class="modal-body">${options.message}</div><div class="modal-footer"><button class="modal-btn modal-btn-confirm" id="okBtn_${modalId}">OK</button></div></div>`;
                document.body.appendChild(overlay);
                setTimeout(() => overlay.classList.add('active'), 10);
                const okBtn = document.getElementById(`okBtn_${modalId}`);
                const closeModal = () => { overlay.classList.remove('active'); setTimeout(() => overlay.remove(), 300); resolve(); };
                okBtn.addEventListener('click', closeModal);
                overlay.addEventListener('click', (e) => { if (e.target === overlay) closeModal(); });
            });
        }
    </script>
    @stack('scripts')
</body>
</html>