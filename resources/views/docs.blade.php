@extends('layouts.app')

@section('title', 'Documentation')
@section('description', 'Learn how to use Warasa tools and features')

@section('content')
<style>
    .docs-page {
        max-width: 1200px;
        margin: 0 auto;
        padding: 40px 20px;
    }
    .docs-header {
        text-align: center;
        margin-bottom: 40px;
    }
    .docs-header h1 {
        font-size: 32px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 8px;
    }
    .docs-header p {
        font-size: 16px;
        color: #64748b;
    }
    .docs-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;
    }
    .docs-category {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        overflow: hidden;
    }
    .docs-category-header {
        padding: 14px 16px;
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
        font-weight: 600;
        font-size: 14px;
        color: #1e293b;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .docs-category-header i {
        color: #ee4d2d;
    }
    .docs-list {
        padding: 8px;
    }
    .doc-item {
        display: block;
        padding: 8px 12px;
        border-radius: 8px;
        color: #475569;
        font-size: 13px;
        text-decoration: none;
        transition: all 0.15s;
        border-left: 3px solid transparent;
    }
    .doc-item:hover {
        background: #f1f5f9;
        border-left-color: #ee4d2d;
        color: #ee4d2d;
    }
</style>

<div class="docs-page">
    <div class="docs-header">
        <h1><i class="fas fa-book" style="color:#ee4d2d;"></i> Documentation</h1>
        <p>Learn how to use Warasa to its full potential</p>
    </div>

    <!-- Search Bar -->
    <div style="max-width:600px;margin:0 auto 32px;">
        <form action="{{ route('docs') }}" method="GET" style="position:relative;">
            <input type="text" name="q" value="{{ $searchQuery ?? '' }}" placeholder="Search documentation..." 
                style="width:100%;padding:12px 16px 12px 44px;border:2px solid #e2e8f0;border-radius:12px;font-size:14px;background:white;transition:all 0.15s;outline:none;"
                onfocus="this.style.borderColor='#ee4d2d';this.style.boxShadow='0 0 0 3px rgba(238,77,45,0.1)'"
                onblur="this.style.borderColor='#e2e8f0';this.style.boxShadow='none'">
            <i class="fas fa-search" style="position:absolute;left:16px;top:50%;transform:translateY(-50%);color:#94a3b8;font-size:16px;"></i>
            @if(!empty($searchQuery))
                <a href="{{ route('docs') }}" style="position:absolute;right:12px;top:50%;transform:translateY(-50%);color:#94a3b8;text-decoration:none;padding:4px 8px;border-radius:6px;font-size:12px;">
                    <i class="fas fa-times"></i> Clear
                </a>
            @endif
        </form>
        @if(!empty($searchQuery))
            <div style="text-align:center;margin-top:8px;font-size:13px;color:#64748b;">
                Found <strong>{{ $resultsCount }}</strong> result{{ $resultsCount !== 1 ? 's' : '' }} for "{{ $searchQuery }}"
            </div>
        @endif
    </div>

    @if(!empty($searchQuery) && $resultsCount === 0)
        <div style="text-align:center;padding:60px 20px;">
            <i class="fas fa-search-minus" style="font-size:48px;color:#cbd5e1;margin-bottom:16px;"></i>
            <h2 style="font-size:20px;color:#64748b;">No results found</h2>
            <p style="color:#94a3b8;margin-top:8px;">Try different keywords or browse the categories below.</p>
        </div>
    @endif

    @forelse($categories as $category => $docs)
        <div style="margin-bottom: 32px;">
            <h2 style="font-size:18px;font-weight:600;color:#1e293b;margin-bottom:12px;display:flex;align-items:center;gap:8px;">
                <span style="width:24px;height:24px;background:#fef3c7;border-radius:6px;display:flex;align-items:center;justify-content:center;">
                    <i class="fas fa-folder" style="font-size:12px;color:#d97706;"></i>
                </span>
                {{ ucfirst(str_replace('-', ' ', $category)) }}
            </h2>
            <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:12px;">
                @foreach($docs as $doc)
                    <a href="{{ route('docs.show', $doc->slug) }}" class="doc-item" style="background:white;border:1px solid #e2e8f0;border-radius:10px;padding:14px 16px;border-left:3px solid #ee4d2d;display:block;text-decoration:none;">
                        <div style="font-weight:600;color:#1e293b;font-size:13px;margin-bottom:4px;">{{ $doc->title }}</div>
                        <div style="font-size:11px;color:#94a3b8;line-height:1.4;">
                            {{ \Illuminate\Support\Str::limit(strip_tags($doc->content), 100) }}
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @empty
        <div style="text-align:center;padding:60px 20px;">
            <i class="fas fa-book-open" style="font-size:48px;color:#cbd5e1;margin-bottom:16px;"></i>
            <h2 style="font-size:20px;color:#64748b;">No documentation available</h2>
            <p style="color:#94a3b8;margin-top:8px;">Documentation will appear here once added by the admin.</p>
        </div>
    @endforelse
</div>
@endsection