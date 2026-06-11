@extends('layouts.admin')

@section('page-title', 'Shopee Fee Configuration')
@section('breadcrumb', 'Management > Manage Shopee fee rates and settings')

@section('content')
<form action="{{ route('admin.shopee-fees.update') }}" method="POST">
    @csrf
    @method('PUT')

    @foreach($groups as $groupName => $items)
    <div class="section-group">
        <div class="section-header">
            <div class="section-title">
                <i class="fas fa-percent" style="color:var(--primary);margin-right:6px;"></i>
                {{ $groupLabels[$groupName] ?? ucfirst(str_replace('_', ' ', $groupName)) }}
            </div>
            <span class="badge badge-info">{{ $items->count() }} configs</span>
        </div>
        <div class="card-body" style="padding:0;">
            <table class="data-table">
                <thead>
                    <tr>
                        <th style="width:40%;">Description</th>
                        <th style="width:25%;">Key</th>
                        <th style="width:15%;">Type</th>
                        <th style="width:20%;text-align:right;">Value</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $config)
                    <tr>
                        <td style="font-weight:500;color:var(--gray-700);">
                            {{ $config->description ?? $config->key }}
                        </td>
                        <td>
                            <code style="font-size:11px;background:var(--gray-100);padding:2px 6px;border-radius:4px;">{{ $config->key }}</code>
                        </td>
                        <td>
                            <span class="badge badge-info">{{ $config->type }}</span>
                        </td>
                        <td style="text-align:right;">
                            <input type="hidden" name="configs[{{ $config->id }}][key]" value="{{ $config->key }}">
                            <input type="text"
                                   name="configs[{{ $config->id }}][value]"
                                   value="{{ $config->value }}"
                                   class="fee-input"
                                   step="{{ $config->type === 'float' ? '0.01' : '1' }}"
                                   min="0"
                                   required>
                            @if($config->type === 'float')
                                <span style="font-size:11px;color:var(--gray-500);">%</span>
                            @elseif(str_contains($config->key, 'max') || str_contains($config->key, 'fixed') || str_contains($config->key, 'preorder'))
                                <span style="font-size:11px;color:var(--gray-500);">Rp</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endforeach

    <div style="display:flex;gap:10px;justify-content:flex-end;margin-top:16px;">
        <a href="{{ route('admin.shopee-fees.reset') }}"
           class="btn btn-outline"
           onclick="event.preventDefault();document.getElementById('reset-form').submit();">
            <i class="fas fa-undo"></i>
            Reset to Defaults
        </a>
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i>
            Save All Changes
        </button>
    </div>
</form>

<form id="reset-form" action="{{ route('admin.shopee-fees.reset') }}" method="POST" style="display:none;">
    @csrf
    @method('DELETE')
</form>
@endsection