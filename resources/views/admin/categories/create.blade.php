@extends('layouts.admin')

@section('page-title', 'Add Category')
@section('breadcrumb', 'Management > Categories > Add new category')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="card-title">
            <i class="fas fa-plus"></i>
            Add New Category
        </div>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div style="padding:12px 16px;background:#ecfdf5;border:1px solid #d1fae5;border-radius:var(--radius-sm);color:#065f46;font-size:13px;margin-bottom:16px;">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div style="padding:12px 16px;background:#fef2f2;border:1px solid #fecaca;border-radius:var(--radius-sm);color:#991b1b;font-size:13px;margin-bottom:16px;">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            </div>
        @endif
        <form action="{{ route('admin.categories.store') }}" method="POST">
            @csrf
            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">Name <span style="color:var(--danger);">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}" class="form-input" placeholder="Category name" required>
                    @error('name')
                        <div style="color:var(--danger);font-size:11px;margin-top:4px;">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Slug <span style="color:var(--danger);">*</span></label>
                    <input type="text" name="slug" value="{{ old('slug') }}" class="form-input" placeholder="category-slug" required>
                    @error('slug')
                        <div style="color:var(--danger);font-size:11px;margin-top:4px;">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Parent Category</label>
                    <select name="parent_id" class="form-input">
                        <option value="">— Top Level Category —</option>
                        @foreach($parents as $parent)
                            <option value="{{ $parent->id }}" {{ old('parent_id') == $parent->id ? 'selected' : '' }}>
                                {{ $parent->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('parent_id')
                        <div style="color:var(--danger);font-size:11px;margin-top:4px;">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Status</label>
                    <select name="is_active" class="form-input">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Sort Order</label>
                    <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" class="form-input" min="0">
                </div>
                <div class="form-group" style="grid-column:1/-1;">
                    <label class="form-label">Description</label>
                    <textarea name="description" rows="3" class="form-input" placeholder="Category description (optional)">{{ old('description') }}</textarea>
                    @error('description')
                        <div style="color:var(--danger);font-size:11px;margin-top:4px;">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Save Category
                </button>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection