@extends('layouts.admin')

@section('page-title', 'Menu Visibility')
@section('breadcrumb', 'Management > Control which menus are visible to users')

@section('content')
<form action="{{ route('admin.menus.update-bulk') }}" method="POST">
    @csrf
    @method('PUT')

    @foreach($groups as $group => $items)
    @php
        $groupLabels = [
            'main' => 'Main Navigation',
            'generator' => 'Generator Tools',
            'workspace' => 'Workspace',
        ];
    @endphp
    <div class="section-group">
        <div class="section-header">
            <div class="section-title">
                <i class="fas fa-layer-group" style="color:var(--primary);margin-right:6px;"></i>
                {{ $groupLabels[$group] ?? ucfirst($group) }}
            </div>
            <span class="badge badge-info">{{ $items->count() }} items</span>
        </div>
        <div class="section-body" style="padding:0;">
            @foreach($items as $menu)
            <div class="setting-row" style="padding:10px 14px;">
                <div class="setting-info" style="display:flex;align-items:center;gap:10px;">
                    <i class="{{ $menu->icon }}" style="width:18px;color:var(--gray-500);font-size:14px;"></i>
                    <div>
                        <div class="setting-label">
                            {{ $menu->label }}
                            @if($menu->is_sub_feature)
                                <span class="badge badge-warning" style="margin-left:4px;">Sub-feature</span>
                            @endif
                        </div>
                        <div class="setting-desc">
                            Key: {{ $menu->menu_key }}
                            @if($menu->parent_menu)
                                | Parent: {{ $menu->parent_menu }}
                            @endif
                            @if($menu->route_name)
                                | Route: {{ $menu->route_name }}
                            @endif
                        </div>
                    </div>
                </div>
                <div class="setting-value" style="display:flex;align-items:center;gap:12px;">
                    <span class="badge {{ $menu->is_visible ? 'badge-success' : 'badge-danger' }}">
                        {{ $menu->is_visible ? 'Visible' : 'Hidden' }}
                    </span>
                    <input type="hidden" name="menus[{{ $menu->id }}][id]" value="{{ $menu->id }}">
                    <input type="hidden" name="menus[{{ $menu->id }}][is_visible]" value="0">
                    <label class="toggle-switch">
                        <input type="checkbox" name="menus[{{ $menu->id }}][is_visible]" value="1" {{ $menu->is_visible ? 'checked' : '' }}>
                        <span class="toggle-slider"></span>
                    </label>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endforeach

    <div style="display:flex;gap:10px;justify-content:flex-end;margin-top:16px;">
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i>
            Save Changes
        </button>
    </div>
</form>
@endsection