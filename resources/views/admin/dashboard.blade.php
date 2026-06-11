@extends('layouts.admin')

@section('page-title', 'Admin Dashboard')
@section('breadcrumb', 'Overview & Management')

@section('content')
<!-- Stats -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-header">
            <div class="stat-icon">
                <i class="fas fa-users"></i>
            </div>
        </div>
        <div class="stat-value">{{ $totalUsers ?? 0 }}</div>
        <div class="stat-label">Total Users</div>
    </div>
    <div class="stat-card">
        <div class="stat-header">
            <div class="stat-icon">
                <i class="fas fa-cubes"></i>
            </div>
        </div>
        <div class="stat-value">{{ $totalProducts ?? 0 }}</div>
        <div class="stat-label">Total Products</div>
    </div>
    <div class="stat-card">
        <div class="stat-header">
            <div class="stat-icon">
                <i class="fas fa-folder"></i>
            </div>
        </div>
        <div class="stat-value">{{ $totalProjects ?? 0 }}</div>
        <div class="stat-label">Total Projects</div>
    </div>
    <div class="stat-card">
        <div class="stat-header">
            <div class="stat-icon">
                <i class="fas fa-clipboard-list"></i>
            </div>
        </div>
        <div class="stat-value">{{ $totalActivities ?? 0 }}</div>
        <div class="stat-label">Activity Logs</div>
    </div>
</div>

<!-- Quick Actions & Recent Activity -->
<div class="grid-2">
    <!-- Quick Actions -->
    <div class="card">
        <div class="card-header">
            <div class="card-title">
                <i class="fas fa-bolt"></i>
                Quick Actions
            </div>
        </div>
        <div class="card-body">
            <a href="{{ route('admin.menus.index') }}" class="nav-item" style="border:1px solid var(--gray-200);border-radius:var(--radius-sm);margin-bottom:8px;">
                <i class="fas fa-bars" style="color:var(--primary);"></i>
                <span>Manage Menu Visibility</span>
                <i class="fas fa-chevron-right" style="margin-left:auto;color:var(--gray-400);font-size:10px;"></i>
            </a>
            <a href="{{ route('admin.settings.index') }}" class="nav-item" style="border:1px solid var(--gray-200);border-radius:var(--radius-sm);margin-bottom:8px;">
                <i class="fas fa-sliders-h" style="color:var(--primary);"></i>
                <span>Toggle Features</span>
                <i class="fas fa-chevron-right" style="margin-left:auto;color:var(--gray-400);font-size:10px;"></i>
            </a>
            <a href="{{ route('admin.shopee-fees.index') }}" class="nav-item" style="border:1px solid var(--gray-200);border-radius:var(--radius-sm);margin-bottom:8px;">
                <i class="fas fa-calculator" style="color:var(--primary);"></i>
                <span>Shopee Fee Configuration</span>
                <i class="fas fa-chevron-right" style="margin-left:auto;color:var(--gray-400);font-size:10px;"></i>
            </a>
            <a href="{{ route('admin.categories.index') }}" class="nav-item" style="border:1px solid var(--gray-200);border-radius:var(--radius-sm);margin-bottom:8px;">
                <i class="fas fa-tags" style="color:var(--primary);"></i>
                <span>Manage Categories</span>
                <i class="fas fa-chevron-right" style="margin-left:auto;color:var(--gray-400);font-size:10px;"></i>
            </a>
            <a href="{{ route('admin.users') }}" class="nav-item" style="border:1px solid var(--gray-200);border-radius:var(--radius-sm);margin-bottom:8px;">
                <i class="fas fa-users" style="color:var(--primary);"></i>
                <span>Manage Users</span>
                <i class="fas fa-chevron-right" style="margin-left:auto;color:var(--gray-400);font-size:10px;"></i>
            </a>
        </div>
    </div>

    <!-- Recent Users -->
    <div class="card">
        <div class="card-header">
            <div class="card-title">
                <i class="fas fa-user-clock"></i>
                Recent Users
            </div>
            <a href="{{ route('admin.users') }}" class="btn btn-sm btn-outline">View All</a>
        </div>
        <div class="card-body" style="padding:0;">
            @if(isset($recentUsers) && $recentUsers->count() > 0)
                @foreach($recentUsers as $user)
                <div style="display:flex;align-items:center;justify-content:space-between;padding:10px 14px;border-bottom:1px solid var(--gray-100);">
                    <div style="display:flex;align-items:center;gap:10px;">
                        <div style="width:28px;height:28px;background:var(--primary);border-radius:var(--radius-sm);display:flex;align-items:center;justify-content:center;color:white;font-weight:600;font-size:11px;">
                            {{ substr($user->name, 0, 1) }}
                        </div>
                        <div>
                            <div style="font-size:12px;font-weight:600;color:var(--gray-700);">{{ $user->name }}</div>
                            <div style="font-size:11px;color:var(--gray-500);">{{ $user->email }}</div>
                        </div>
                    </div>
                    <span class="badge {{ $user->isAdmin() ? 'badge-warning' : 'badge-success' }}">
                        {{ $user->role ?? 'user' }}
                    </span>
                </div>
                @endforeach
            @else
                <div style="padding:20px;text-align:center;color:var(--gray-400);font-size:12px;">
                    No users yet.
                </div>
            @endif
        </div>
    </div>
</div>
@endsection