@extends('layouts.admin')

@section('page-title', 'Edit Category')
@section('breadcrumb', 'Management > Categories > Edit category')

@section('content')
<div class="card" style="margin-bottom:16px;">
    <div class="card-header">
        <div class="card-title">
            <i class="fas fa-edit"></i>
            Edit Category: {{ $category->name }}
        </div>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.categories.update', $category) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">Name <span style="color:var(--danger);">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $category->name) }}" class="form-input" required>
                    @error('name')
                        <div style="color:var(--danger);font-size:11px;margin-top:4px;">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Slug <span style="color:var(--danger);">*</span></label>
                    <input type="text" name="slug" value="{{ old('slug', $category->slug) }}" class="form-input" required>
                    @error('slug')
                        <div style="color:var(--danger);font-size:11px;margin-top:4px;">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Sort Order</label>
                    <input type="number" name="sort_order" value="{{ old('sort_order', $category->sort_order) }}" class="form-input" min="0">
                </div>
                <div class="form-group">
                    <label class="form-label">Status</label>
                    <select name="is_active" class="form-input">
                        <option value="1" {{ $category->is_active ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ !$category->is_active ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
                <div class="form-group" style="grid-column:1/-1;">
                    <label class="form-label">Description</label>
                    <textarea name="description" rows="3" class="form-input">{{ old('description', $category->description) }}</textarea>
                    @error('description')
                        <div style="color:var(--danger);font-size:11px;margin-top:4px;">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Update Category
                </button>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

@if($category->children->count() > 0)
<div class="card">
    <div class="card-header">
        <div class="card-title">
            <i class="fas fa-sitemap"></i>
            Sub-Categories ({{ $category->children->count() }})
        </div>
    </div>
    <div class="card-body" style="padding:0;">
        <div class="table-container">
            <table class="data-table">
                <thead>
                    <tr>
                        <th style="width:40px;">No</th>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>Products</th>
                        <th>Status</th>
                        <th>Order</th>
                        <th style="text-align:right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($category->children as $index => $child)
                    @php
                        $childHasProducts = $child->products()->count() > 0;
                    @endphp
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td style="font-weight:500;color:var(--gray-700);">
                            <i class="fas fa-level-indent" style="color:var(--gray-400);margin-right:6px;"></i>
                            {{ $child->name }}
                        </td>
                        <td style="color:var(--gray-400);font-size:12px;">{{ $child->slug }}</td>
                        <td>
                            @if($childHasProducts)
                                <span class="badge badge-success">{{ $child->products()->count() }}</span>
                            @else
                                <span style="color:var(--gray-400);">0</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge {{ $child->is_active ? 'badge-success' : 'badge-danger' }}">
                                {{ $child->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td>{{ $child->sort_order }}</td>
                        <td style="text-align:right;">
                            <div style="display:flex;gap:4px;justify-content:flex-end;">
                                <a href="{{ route('admin.categories.edit', $child) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <button type="button" class="btn btn-sm {{ $child->is_active ? 'btn-warning' : 'btn-success' }}" onclick="confirmAction('{{ $child->is_active ? 'Deactivate' : 'Activate' }}', '{{ $child->is_active ? 'Deactivate' : 'Activate' }} <strong>{{ $child->name }}</strong>?', '{{ $child->is_active ? 'Deactivate' : 'Activate' }}', '{{ $child->is_active ? 'warning' : 'success' }}', '{{ route('admin.categories.toggle-active', $child) }}')">
                                    <i class="fas {{ $child->is_active ? 'fa-eye-slash' : 'fa-eye' }}"></i>
                                </button>
                                @if(!$childHasProducts)
                                <button type="button" class="btn btn-sm btn-danger" onclick="confirmAction('Delete', 'Delete <strong>{{ $child->name }}</strong>?', 'Delete', 'danger', '{{ route('admin.categories.destroy', $child) }}', 'DELETE')">
                                    <i class="fas fa-trash"></i>
                                </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif
@endsection

@section('scripts')
<script>
function confirmAction(title, message, confirmText, type, url, method) {
    method = method || 'POST';
    showConfirmModal({title:title, message:message, confirmText:confirmText, type:type||'warning', cancelText:'Cancel'})
    .then(function(c) {
        if (c) {
            var f = document.createElement('form'); f.method = 'POST'; f.action = url;
            if (method === 'DELETE') { var m = document.createElement('input'); m.type = 'hidden'; m.name = '_method'; m.value = 'DELETE'; f.appendChild(m); }
            var csrf = document.createElement('input'); csrf.type = 'hidden'; csrf.name = '_token'; csrf.value = '{{ csrf_token() }}'; f.appendChild(csrf);
            document.body.appendChild(f); f.submit();
        }
    });
}
</script>
@endsection