@extends('layouts.admin')

@section('page-title', 'User Management')
@section('breadcrumb', 'Management > View and manage all users')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="card-title">
            <i class="fas fa-users"></i>
            All Users ({{ $users->total() }})
        </div>
        <form action="{{ route('admin.users') }}" method="GET" style="display:flex;gap:8px;">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search users..." class="form-input" style="width:200px;">
            <button type="submit" class="btn btn-primary btn-sm">
                <i class="fas fa-search"></i>
                Search
            </button>
        </form>
    </div>
    <div class="card-body" style="padding:0;">
        <div class="table-container">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Joined</th>
                        <th style="text-align:right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr style="cursor:pointer;" onclick="window.location='{{ route('admin.users.show', $user) }}'">
                        <td>
                            <div style="display:flex;align-items:center;gap:8px;">
                                <div style="width:28px;height:28px;background:var(--primary);border-radius:var(--radius-sm);display:flex;align-items:center;justify-content:center;color:white;font-weight:600;font-size:11px;">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                                <div style="font-weight:600;color:var(--gray-700);">{{ $user->name }}</div>
                            </div>
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <span class="badge {{ $user->isAdmin() ? 'badge-warning' : 'badge-success' }}">
                                {{ $user->role ?? 'user' }}
                            </span>
                        </td>
                        <td>
                            <span class="badge {{ ($user->is_active ?? true) ? 'badge-success' : 'badge-danger' }}">
                                {{ ($user->is_active ?? true) ? 'Active' : 'Suspended' }}
                            </span>
                        </td>
                        <td>{{ $user->created_at->format('d M Y') }}</td>
                        <td style="text-align:right;" onclick="event.stopPropagation();">
                            <div style="display:flex;gap:4px;justify-content:flex-end;">
                                @if(($user->is_active ?? true))
                                <button type="button" class="btn btn-sm btn-warning" onclick="confirmAction('Suspend User', 'Are you sure you want to suspend <strong>{{ $user->name }}</strong>? They will not be able to access the application.', 'Suspend', 'warning', '{{ route('admin.users.suspend', $user) }}')">
                                    <i class="fas fa-ban"></i> Suspend
                                </button>
                                @else
                                <button type="button" class="btn btn-sm btn-success" onclick="confirmAction('Activate User', 'Are you sure you want to activate <strong>{{ $user->name }}</strong>?', 'Activate', 'success', '{{ route('admin.users.activate', $user) }}')">
                                    <i class="fas fa-check"></i> Activate
                                </button>
                                @endif
                                <button type="button" class="btn btn-sm btn-danger" onclick="confirmAction('Delete User', 'Are you sure you want to delete <strong>{{ $user->name }}</strong>? This action cannot be undone.', 'Delete', 'danger', '{{ route('admin.users.delete', $user) }}', 'DELETE')">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="text-align:center;padding:20px;color:var(--gray-400);">
                            No users found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div style="margin-top:16px;">
    {{ $users->withQueryString()->links() }}
</div>
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