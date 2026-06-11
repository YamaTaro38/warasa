@extends('layouts.admin')

@section('page-title', 'Categories Management')
@section('breadcrumb', 'Management > Manage product categories')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="card-title">
            <i class="fas fa-tags"></i>
            All Categories ({{ $categories->total() }})
        </div>
        <div style="display:flex;gap:8px;">
            <div style="position:relative;">
                <input type="text" id="categorySearch" placeholder="Search categories..." onkeyup="liveSearch(this.value)"
                    style="padding:6px 10px 6px 30px;border:1px solid var(--gray-300);border-radius:var(--radius-sm);font-size:12px;width:200px;">
                <i class="fas fa-search" style="position:absolute;left:10px;top:50%;transform:translateY(-50%);color:var(--gray-400);font-size:12px;"></i>
            </div>
            <a href="{{ route('admin.categories.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Add Category
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
            <table class="data-table" id="categoriesTable">
                <thead>
                    <tr>
                        <th style="width:40px;">No</th>
                        <th style="width:24px;"></th>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>Products</th>
                        <th>Status</th>
                        <th>Order</th>
                        <th style="text-align:right;">Actions</th>
                    </tr>
                </thead>
                <tbody id="categoriesBody">
                    @forelse($categories as $index => $category)
                    @php
                        $hasProducts = $category->products()->count() > 0;
                        $hasChildren = $category->children->count() > 0;
                    @endphp
                    <tr class="category-row parent-row" data-name="{{ strtolower($category->name) }}" data-slug="{{ strtolower($category->slug) }}">
                        <td>{{ ($categories->currentPage() - 1) * $categories->perPage() + $index + 1 }}</td>
                        <td>
                            @if($hasChildren)
                                <span class="tree-toggle" data-target="children-{{ $category->id }}" style="cursor:pointer;color:var(--gray-600);font-size:10px;">
                                    <i class="fas fa-chevron-right tree-icon"></i>
                                </span>
                            @endif
                        </td>
                        <td>
                            <div style="font-weight:600;color:var(--gray-700);font-size:13px;">
                                {{ $category->name }}
                                @if($hasChildren)
                                    <span style="font-size:10px;color:var(--gray-400);font-weight:400;">({{ $category->children->count() }})</span>
                                @endif
                            </div>
                        </td>
                        <td style="color:var(--gray-400);font-size:12px;">{{ $category->slug }}</td>
                        <td>
                            @if($hasProducts)
                                <span class="badge badge-success">{{ $category->products()->count() }} products</span>
                            @else
                                <span style="color:var(--gray-400);font-size:12px;">0</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge {{ $category->is_active ? 'badge-success' : 'badge-danger' }}">
                                {{ $category->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td>{{ $category->sort_order }}</td>
                        <td style="text-align:right;">
                            <div style="display:flex;gap:4px;justify-content:flex-end;flex-wrap:wrap;">
                                @if($hasProducts)
                                    <span class="btn btn-sm btn-outline" style="opacity:0.5;cursor:not-allowed;" title="Protected"><i class="fas fa-lock"></i></span>
                                @else
                                    <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <button type="button" class="btn btn-sm {{ $category->is_active ? 'btn-warning' : 'btn-success' }}" onclick="confirmAction('{{ $category->is_active ? 'Deactivate' : 'Activate' }}', '{{ $category->is_active ? 'Deactivate' : 'Activate' }} <strong>{{ $category->name }}</strong>?', '{{ $category->is_active ? 'Deactivate' : 'Activate' }}', '{{ $category->is_active ? 'warning' : 'success' }}', '{{ route('admin.categories.toggle-active', $category) }}')">
                                        <i class="fas {{ $category->is_active ? 'fa-eye-slash' : 'fa-eye' }}"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-danger" onclick="confirmAction('Delete', 'Delete <strong>{{ $category->name }}</strong>?', 'Delete', 'danger', '{{ route('admin.categories.destroy', $category) }}', 'DELETE')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @if($hasChildren)
                        @foreach($category->children as $child)
                        @php
                            $childHasProducts = $child->products()->count() > 0;
                        @endphp
                        <tr class="child-row children-{{ $category->id }}" style="display:none;background:var(--gray-50);" data-name="{{ strtolower($child->name) }}" data-slug="{{ strtolower($child->slug) }}">
                            <td></td>
                            <td style="text-align:center;color:var(--gray-400);font-size:10px;"><i class="fas fa-level-indent"></i></td>
                            <td>
                                <div style="display:flex;align-items:center;gap:6px;padding-left:16px;">
                                    <div style="width:2px;height:16px;background:var(--gray-300);border-radius:1px;"></div>
                                    <span style="font-weight:500;font-size:12px;color:var(--gray-700);">{{ $child->name }}</span>
                                </div>
                            </td>
                            <td style="color:var(--gray-400);font-size:12px;">{{ $child->slug }}</td>
                            <td>
                                @if($childHasProducts)
                                    <span class="badge badge-success">{{ $child->products()->count() }}</span>
                                @else
                                    <span style="color:var(--gray-400);font-size:12px;">0</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge {{ $child->is_active ? 'badge-success' : 'badge-danger' }}">{{ $child->is_active ? 'Active' : 'Inactive' }}</span>
                            </td>
                            <td>{{ $child->sort_order }}</td>
                            <td style="text-align:right;">
                                <div style="display:flex;gap:4px;justify-content:flex-end;">
                                    @if($childHasProducts)
                                        <span class="btn btn-sm btn-outline" style="opacity:0.5;cursor:not-allowed;"><i class="fas fa-lock"></i></span>
                                    @else
                                        <a href="{{ route('admin.categories.edit', $child) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i> Edit</a>
                                        <button type="button" class="btn btn-sm {{ $child->is_active ? 'btn-warning' : 'btn-success' }}" onclick="confirmAction('{{ $child->is_active ? 'Deactivate' : 'Activate' }}', '{{ $child->is_active ? 'Deactivate' : 'Activate' }} <strong>{{ $child->name }}</strong>?', '{{ $child->is_active ? 'Deactivate' : 'Activate' }}', '{{ $child->is_active ? 'warning' : 'success' }}', '{{ route('admin.categories.toggle-active', $child) }}')">
                                            <i class="fas {{ $child->is_active ? 'fa-eye-slash' : 'fa-eye' }}"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger" onclick="confirmAction('Delete', 'Delete <strong>{{ $child->name }}</strong>?', 'Delete', 'danger', '{{ route('admin.categories.destroy', $child) }}', 'DELETE')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    @endif
                    @empty
                    <tr><td colspan="8" style="text-align:center;padding:20px;color:var(--gray-400);font-size:13px;">No categories found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div style="margin-top:16px;">
    {{ $categories->withQueryString()->links() }}
</div>
@endsection

@section('scripts')
<script>
// Tree toggle
document.querySelectorAll('.tree-toggle').forEach(function(toggle) {
    toggle.addEventListener('click', function() {
        var target = this.dataset.target;
        var icon = this.querySelector('.tree-icon');
        var rows = document.querySelectorAll('.' + target);
        rows.forEach(function(r) { r.style.display = r.style.display === 'none' ? '' : 'none'; });
        var hidden = rows.length > 0 && rows[0].style.display === 'none';
        icon.className = hidden ? 'fas fa-chevron-right tree-icon' : 'fas fa-chevron-down tree-icon';
    });
});

// Live search
function liveSearch(query) {
    query = query.toLowerCase().trim();
    document.querySelectorAll('.category-row, .child-row').forEach(function(row) {
        var name = (row.dataset.name || '') + (row.dataset.slug || '');
        row.style.display = (!query || name.includes(query)) ? '' : 'none';
    });
    if (query) {
        document.querySelectorAll('.child-row').forEach(function(c) {
            if (c.style.display !== 'none') {
                var cls = Array.from(c.classList).find(function(x) { return x.startsWith('children-'); });
                if (cls) {
                    document.querySelectorAll('.' + cls).forEach(function(e) { e.style.display = ''; });
                    var t = document.querySelector('[data-target="' + cls + '"]');
                    if (t) t.querySelector('.tree-icon').className = 'fas fa-chevron-down tree-icon';
                }
            }
        });
    } else {
        document.querySelectorAll('.child-row').forEach(function(r) { r.style.display = 'none'; });
        document.querySelectorAll('.tree-icon').forEach(function(i) { i.className = 'fas fa-chevron-right tree-icon'; });
    }
}

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