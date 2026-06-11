@extends('layouts.admin')

@section('page-title', 'Add API Key')
@section('breadcrumb', 'Management > API Keys > Add new key')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="card-title">
            <i class="fas fa-plus"></i>
            Add New API Key
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
        <form action="{{ route('admin.api-keys.store') }}" method="POST">
            @csrf
            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">Provider <span style="color:var(--danger);">*</span></label>
                    <select name="provider" class="form-input" required>
                        <option value="">Select Provider</option>
                        <option value="gemini">Gemini</option>
                        <option value="pollinations">Pollinations</option>
                    </select>
                    @error('provider')
                        <div style="color:var(--danger);font-size:11px;margin-top:4px;">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="form-label">API Key <span style="color:var(--danger);">*</span></label>
                    <input type="text" name="key" value="{{ old('key') }}" class="form-input" placeholder="Enter API key" required style="font-family:monospace;">
                    @error('key')
                        <div style="color:var(--danger);font-size:11px;margin-top:4px;">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Priority</label>
                    <input type="number" name="priority" value="{{ old('priority', 0) }}" class="form-input" min="0">
                    <div style="font-size:11px;color:var(--gray-400);margin-top:4px;">Higher = more prioritized</div>
                    @error('priority')
                        <div style="color:var(--danger);font-size:11px;margin-top:4px;">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-input">
                        <option value="active">Active</option>
                        <option value="limited">Limited</option>
                        <option value="disabled">Disabled</option>
                    </select>
                    @error('status')
                        <div style="color:var(--danger);font-size:11px;margin-top:4px;">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group" style="grid-column:1/-1;">
                    <label class="form-label">Notes</label>
                    <textarea name="notes" rows="3" class="form-input" placeholder="Additional notes...">{{ old('notes') }}</textarea>
                    @error('notes')
                        <div style="color:var(--danger);font-size:11px;margin-top:4px;">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Save API Key
                </button>
                <a href="{{ route('admin.api-keys.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection