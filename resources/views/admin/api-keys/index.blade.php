@extends('layouts.admin')

@section('page-title', 'API Keys Management')
@section('breadcrumb', 'Management > Manage AI provider API keys')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="card-title">
            <i class="fas fa-key"></i>
            All API Keys ({{ $keys->count() }})
        </div>
        <div style="display:flex;gap:8px;">
            <form action="{{ route('admin.api-keys.check-now') }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="btn btn-secondary btn-sm">
                    <i class="fas fa-sync"></i> Check All Keys
                </button>
            </form>
            <a href="{{ route('admin.api-keys.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Add API Key
            </a>
        </div>
    </div>
    @if(session('success'))
        <div style="padding:12px 16px;background:#ecfdf5;border-bottom:1px solid #d1fae5;color:#065f46;font-size:13px;">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div style="padding:12px 16px;background:#fef2f2;border-bottom:1px solid #fecaca;color:#991b1b;font-size:13px;">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
        </div>
    @endif
    <div class="card-body" style="padding:0;">
        <div class="table-container">
            <table class="data-table">
                <thead>
                    <tr>
                        <th style="width:50px;">No</th>
                        <th>Provider</th>
                        <th>API Key</th>
                        <th>Status</th>
                        <th>Priority</th>
                        <th>Last Checked</th>
                        <th>Fail Count</th>
                        <th style="text-align:right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($keys as $index => $key)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            <span class="badge {{ $key->provider === 'gemini' ? 'badge-success' : 'badge-info' }}">
                                <i class="fas {{ $key->provider === 'gemini' ? 'fa-brain' : 'fa-image' }}"></i>
                                {{ ucfirst($key->provider) }}
                            </span>
                        </td>
                        <td>
                            <span style="font-family:monospace;font-size:12px;color:var(--gray-500);">
                                {{ substr($key->key, 0, 8) }}...{{ substr($key->key, -4) }}
                            </span>
                        </td>
                        <td>
                            <span class="badge {{ $key->status === 'active' ? 'badge-success' : ($key->status === 'limited' ? 'badge-warning' : 'badge-danger') }}">
                                {{ ucfirst($key->status) }}
                            </span>
                        </td>
                        <td style="font-weight:600;">{{ $key->priority }}</td>
                        <td style="font-size:12px;color:var(--gray-400);">
                            {{ $key->last_checked_at ? $key->last_checked_at->diffForHumans() : '-' }}
                        </td>
                        <td>
                            @if($key->fail_count > 0)
                                <span style="color:var(--danger);font-weight:600;">{{ $key->fail_count }}</span>
                            @else
                                <span style="color:var(--gray-400);">0</span>
                            @endif
                        </td>
                        <td style="text-align:right;">
                            <div style="display:flex;gap:4px;justify-content:flex-end;">
                                <a href="{{ route('admin.api-keys.edit', $key) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <button type="button" class="btn btn-sm btn-danger" onclick="confirmAction('Delete API Key', 'Are you sure you want to delete this API key for <strong>{{ ucfirst($key->provider) }}</strong>? This action cannot be undone.', 'Delete', 'danger', '{{ route('admin.api-keys.destroy', $key) }}', 'DELETE')">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" style="text-align:center;padding:20px;color:var(--gray-400);">
                            No API keys found. Add your first API key to get started.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
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