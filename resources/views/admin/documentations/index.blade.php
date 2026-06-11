@extends('layouts.admin')

@section('page-title', 'Documentation Management')
@section('breadcrumb', 'Management > Manage user documentation')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="card-title">
            <i class="fas fa-book"></i>
            All Documentation ({{ $documentations->total() }})
        </div>
        <div style="display:flex;gap:8px;">
            <a href="{{ route('docs') }}" class="btn btn-secondary btn-sm" target="_blank">
                <i class="fas fa-external-link-alt"></i> View Public
            </a>
            <a href="{{ route('admin.documentations.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Add Documentation
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
                        <th>Title</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th>Order</th>
                        <th style="text-align:right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($documentations as $index => $doc)
                    <tr>
                        <td>{{ ($documentations->currentPage() - 1) * $documentations->perPage() + $index + 1 }}</td>
                        <td>
                            <div style="font-weight:600;color:var(--gray-700);">{{ $doc->title }}</div>
                            <div style="font-size:11px;color:var(--gray-400);">{{ \Illuminate\Support\Str::limit(strip_tags($doc->content), 60) }}</div>
                        </td>
                        <td>
                            <span class="badge badge-info">{{ ucfirst($doc->category) }}</span>
                        </td>
                        <td>
                            <span class="badge {{ $doc->is_published ? 'badge-success' : 'badge-danger' }}">
                                {{ $doc->is_published ? 'Published' : 'Draft' }}
                            </span>
                        </td>
                        <td>{{ $doc->sort_order }}</td>
                        <td style="text-align:right;">
                            <div style="display:flex;gap:4px;justify-content:flex-end;">
                                <button type="button" class="btn btn-sm {{ $doc->is_published ? 'btn-warning' : 'btn-success' }}" onclick="confirmAction('{{ $doc->is_published ? 'Unpublish' : 'Publish' }} Documentation', 'Are you sure you want to {{ $doc->is_published ? 'unpublish' : 'publish' }} <strong>{{ $doc->title }}</strong>?', '{{ $doc->is_published ? 'Unpublish' : 'Publish' }}', '{{ $doc->is_published ? 'warning' : 'success' }}', '{{ route('admin.documentations.toggle', $doc) }}')">
                                    <i class="fas {{ $doc->is_published ? 'fa-eye-slash' : 'fa-eye' }}"></i>
                                </button>
                                <a href="{{ route('admin.documentations.edit', $doc) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <button type="button" class="btn btn-sm btn-danger" onclick="confirmAction('Delete Documentation', 'Are you sure you want to delete <strong>{{ $doc->title }}</strong>? This action cannot be undone.', 'Delete', 'danger', '{{ route('admin.documentations.destroy', $doc) }}', 'DELETE')">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="text-align:center;padding:20px;color:var(--gray-400);">
                            No documentation found. Create your first guide.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div style="margin-top:16px;">
    {{ $documentations->withQueryString()->links() }}
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