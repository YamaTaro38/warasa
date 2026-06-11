@extends('layouts.admin')

@section('page-title', 'Feature Settings')
@section('breadcrumb', 'Management > Toggle features and general settings')

@section('content')
<form action="{{ route('admin.settings.update') }}" method="POST">
    @csrf
    @method('PUT')

    @foreach($groups as $groupName => $items)
    <div class="section-group">
        <div class="section-header">
            <div class="section-title">
                <i class="fas fa-cog" style="color:var(--primary);margin-right:6px;"></i>
                {{ $groupLabels[$groupName] ?? ucfirst($groupName) }}
            </div>
            <span class="badge badge-info">{{ $items->count() }} settings</span>
        </div>
        <div class="section-body" style="padding:0;">
            @foreach($items as $setting)
            <div class="setting-row" style="padding:10px 14px;">
                <div class="setting-info">
                    <div class="setting-label">{{ $setting->description ?? $setting->key }}</div>
                    <div class="setting-desc">Key: {{ $setting->key }} | Type: {{ $setting->type }}</div>
                </div>
                <div class="setting-value">
                    <input type="hidden" name="settings[{{ $setting->id }}][key]" value="{{ $setting->key }}">
                    @if($setting->type === 'boolean')
                        <input type="hidden" name="settings[{{ $setting->id }}][value]" value="false">
                        <label class="toggle-switch">
                            <input type="checkbox" name="settings[{{ $setting->id }}][value]" value="true" {{ filter_var($setting->value, FILTER_VALIDATE_BOOLEAN) ? 'checked' : '' }}>
                            <span class="toggle-slider"></span>
                        </label>
                    @elseif($setting->type === 'integer')
                        <input type="number" name="settings[{{ $setting->id }}][value]" value="{{ $setting->value }}" class="fee-input" min="0">
                    @elseif($setting->type === 'float')
                        <input type="number" name="settings[{{ $setting->id }}][value]" value="{{ $setting->value }}" class="fee-input" step="0.01" min="0">
                    @else
                        <input type="text" name="settings[{{ $setting->id }}][value]" value="{{ $setting->value }}" class="fee-input" style="width:200px;">
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endforeach

    <div style="display:flex;gap:10px;justify-content:flex-end;margin-top:16px;">
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i>
            Save Settings
        </button>
    </div>
</form>
@endsection