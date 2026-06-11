@extends('layouts.admin')

@section('page-title', 'User Details')
@section('breadcrumb', 'Management > Users > {{ $user->name }}')

@section('content')
<div class="grid-2">
    <!-- User Info -->
    <div class="card">
        <div class="card-header">
            <div class="card-title">
                <i class="fas fa-user"></i>
                User Information
            </div>
            <a href="{{ route('admin.users') }}" class="btn btn-sm btn-outline">
                <i class="fas fa-arrow-left"></i>
                Back
            </a>
        </div>
        <div class="card-body">
            <div style="display:flex;align-items:center;gap:14px;margin-bottom:16px;">
                <div style="width:48px;height:48px;background:var(--primary);border-radius:var(--radius-md);display:flex;align-items:center;justify-content:center;color:white;font-weight:700;font-size:18px;">
                    {{ substr($user->name, 0, 1) }}
                </div>
                <div>
                    <div style="font-size:16px;font-weight:700;color:var(--gray-800);">{{ $user->name }}</div>
                    <div style="font-size:12px;color:var(--gray-500);">{{ $user->email }}</div>
                </div>
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
                <div>
                    <div style="font-size:10px;font-weight:600;color:var(--gray-500);text-transform:uppercase;margin-bottom:4px;">Role</div>
                    <span class="badge {{ $user->isAdmin() ? 'badge-warning' : 'badge-success' }}">
                        {{ $user->role ?? 'user' }}
                    </span>
                </div>
                <div>
                    <div style="font-size:10px;font-weight:600;color:var(--gray-500);text-transform:uppercase;margin-bottom:4px;">Status</div>
                    <span class="badge {{ ($user->is_active ?? true) ? 'badge-success' : 'badge-danger' }}">
                        {{ ($user->is_active ?? true) ? 'Active' : 'Suspended' }}
                    </span>
                </div>
                <div>
                    <div style="font-size:10px;font-weight:600;color:var(--gray-500);text-transform:uppercase;margin-bottom:4px;">Joined</div>
                    <div style="font-size:12px;font-weight:500;color:var(--gray-700);">{{ $user->created_at->format('d M Y H:i') }}</div>
                </div>
                <div>
                    <div style="font-size:10px;font-weight:600;color:var(--gray-500);text-transform:uppercase;margin-bottom:4px;">Email Verified</div>
                    <div style="font-size:12px;font-weight:500;color:var(--gray-700);">
                        {{ $user->email_verified_at ? 'Yes' : 'No' }}
                    </div>
                </div>
            </div>

            <div style="margin-top:16px;display:flex;gap:8px;">
                @if(($user->is_active ?? true))
                <button type="button" class="btn btn-sm btn-warning" onclick="confirmAction('Suspend User', 'Are you sure you want to suspend <strong>{{ $user->name }}</strong>? They will not be able to access the application.', 'Suspend', 'warning', '{{ route('admin.users.suspend', $user) }}')">
                    <i class="fas fa-ban"></i> Suspend User
                </button>
                @else
                <button type="button" class="btn btn-sm btn-success" onclick="confirmAction('Activate User', 'Are you sure you want to activate <strong>{{ $user->name }}</strong>?', 'Activate', 'success', '{{ route('admin.users.activate', $user) }}')">
                    <i class="fas fa-check"></i> Activate User
                </button>
                @endif
                <button type="button" class="btn btn-sm btn-danger" onclick="confirmAction('Delete User', 'Are you sure you want to delete <strong>{{ $user->name }}</strong>? This action cannot be undone.', 'Delete', 'danger', '{{ route('admin.users.delete', $user) }}', 'DELETE')">
                    <i class="fas fa-trash"></i> Delete User
                </button>
            </div>
        </div>
    </div>

    <!-- Stats -->
    <div class="card">
        <div class="card-header">
            <div class="card-title">
                <i class="fas fa-chart-bar"></i>
                Activity Stats
            </div>
        </div>
        <div class="card-body">
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
                <div style="text-align:center;padding:14px;background:var(--gray-50);border-radius:var(--radius-md);">
                    <div style="font-size:24px;font-weight:700;color:var(--primary);">{{ $products->count() }}</div>
                    <div style="font-size:11px;font-weight:500;color:var(--gray-500);">Products</div>
                </div>
                <div style="text-align:center;padding:14px;background:var(--gray-50);border-radius:var(--radius-md);">
                    <div style="font-size:24px;font-weight:700;color:var(--primary);">{{ $projects->count() }}</div>
                    <div style="font-size:11px;font-weight:500;color:var(--gray-500);">Projects</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Products -->
@if($products->count() > 0)
<div class="card" style="margin-bottom:16px;">
    <div class="card-header">
        <div class="card-title">
            <i class="fas fa-cubes"></i>
            Recent Products
        </div>
    </div>
    <div class="card-body" style="padding:0;">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>SKU</th>
                    <th>Price</th>
                    <th>Created</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                <tr>
                    <td style="font-weight:500;">{{ $product->name }}</td>
                    <td><code style="font-size:11px;background:var(--gray-100);padding:2px 6px;border-radius:4px;">{{ $product->sku ?? '-' }}</code></td>
                    <td>Rp {{ number_format($product->price ?? 0, 0, ',', '.') }}</td>
                    <td>{{ $product->created_at->format('d M Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

<!-- Recent Projects -->
@if($projects->count() > 0)
<div class="card">
    <div class="card-header">
        <div class="card-title">
            <i class="fas fa-folder"></i>
            Recent Projects
        </div>
    </div>
    <div class="card-body" style="padding:0;">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Created</th>
                </tr>
            </thead>
            <tbody>
                @foreach($projects as $project)
                <tr>
                    <td style="font-weight:500;">{{ $project->name }}</td>
                    <td>{{ Str::limit($project->description ?? '-', 50) }}</td>
                    <td>{{ $project->created_at->format('d M Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif
@endsection

@section('scripts')
<script>
function confirmAction(title, message, confirmText, type, url, method) {
    method = method || 'POST';
    showConfirmModal({
        title: title,
        message: message,
        confirmText: confirmText,
        type: type || 'warning',
        cancelText: 'Cancel'
    }).then(function(confirmed) {
        if (confirmed) {
            var form = document.createElement('form');
            form.method = 'POST';
            form.action = url;
            if (method === 'DELETE') {
                var methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'DELETE';
                form.appendChild(methodInput);
            }
            var csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = '{{ csrf_token() }}';
            form.appendChild(csrfInput);
            document.body.appendChild(form);
            form.submit();
        }
    });
}
</script>
@endsection