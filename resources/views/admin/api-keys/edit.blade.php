@extends('layouts.admin')

@section('page-title', 'Edit API Key')
@section('breadcrumb', 'Management > API Keys > Edit key')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="card-title">
            <i class="fas fa-edit"></i>
            Edit API Key: {{ ucfirst($apiKey->provider) }}
        </div>
        <a href="{{ route('admin.api-keys.index') }}" class="btn btn-secondary btn-sm">
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
        <form action="{{ route('admin.api-keys.update', $apiKey) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">Provider</label>
                    <input type="text" value="{{ ucfirst($apiKey->provider) }}" class="form-input" disabled style="background:var(--gray-100);">
                </div>
                <div class="form-group">
                    <label class="form-label">API Key</label>
                    <input type="text" value="{{ $apiKey->key }}" class="form-input" disabled style="background:var(--gray-100);font-family:monospace;">
                </div>
                <div class="form-group">
                    <label class="form-label">Priority</label>
                    <input type="number" name="priority" value="{{ old('priority', $apiKey->priority) }}" class="form-input" min="0">
                    <div style="font-size:11px;color:var(--gray-400);margin-top:4px;">Higher = more prioritized</div>
                    @error('priority')
                        <div style="color:var(--danger);font-size:11px;margin-top:4px;">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-input">
                        <option value="active" {{ $apiKey->status === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="limited" {{ $apiKey->status === 'limited' ? 'selected' : '' }}>Limited</option>
                        <option value="disabled" {{ $apiKey->status === 'disabled' ? 'selected' : '' }}>Disabled</option>
                    </select>
                    @error('status')
                        <div style="color:var(--danger);font-size:11px;margin-top:4px;">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group" style="grid-column:1/-1;">
                    <label class="form-label">Notes</label>
                    <textarea name="notes" rows="3" class="form-input" placeholder="Additional notes...">{{ old('notes', $apiKey->notes) }}</textarea>
                    @error('notes')
                        <div style="color:var(--danger);font-size:11px;margin-top:4px;">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Update API Key
                </button>
                <a href="{{ route('admin.api-keys.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection