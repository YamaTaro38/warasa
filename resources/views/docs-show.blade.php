@extends('layouts.app')

@section('title', $doc->title)
@section('description', \Illuminate\Support\Str::limit(strip_tags($doc->content), 160))

@section('content')
<style>
    .docs-show {
        max-width: 1200px;
        margin: 0 auto;
        padding: 40px 20px;
        display: grid;
        grid-template-columns: 260px 1fr;
        gap: 32px;
    }
    .docs-sidebar {
        position: sticky;
        top: 80px;
        align-self: start;
    }
    .docs-sidebar-title {
        font-size: 13px;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .docs-sidebar-category {
        margin-bottom: 12px;
    }
    .docs-sidebar-cat-title {
        font-size: 11px;
        font-weight: 600;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 6px;
        padding-left: 8px;
    }
    .docs-sidebar-link {
        display: block;
        padding: 4px 8px;
        font-size: 12px;
        color: #64748b;
        text-decoration: none;
        border-radius: 4px;
        margin-bottom: 2px;
        transition: all 0.15s;
        border-left: 2px solid transparent;
    }
    .docs-sidebar-link:hover {
        background: #f1f5f9;
        color: #334155;
    }
    .docs-sidebar-link.active {
        background: #fff0eb;
        color: #ee4d2d;
        border-left-color: #ee4d2d;
        font-weight: 500;
    }
    .docs-content {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 32px 36px;
        min-height: 400px;
    }
    .docs-content h1 {
        font-size: 24px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 8px;
    }
    .docs-content .meta {
        font-size: 12px;
        color: #94a3b8;
        margin-bottom: 24px;
        padding-bottom: 16px;
        border-bottom: 1px solid #e2e8f0;
    }
    .docs-content .body {
        font-size: 14px;
        line-height: 1.8;
        color: #334155;
    }
    .docs-content .body h2 {
        font-size: 18px;
        font-weight: 600;
        color: #1e293b;
        margin: 24px 0 8px;
    }
    .docs-content .body h3 {
        font-size: 15px;
        font-weight: 600;
        color: #1e293b;
        margin: 20px 0 6px;
    }
    .docs-content .body p {
        margin-bottom: 12px;
    }
    .docs-content .body ul, .docs-content .body ol {
        margin-bottom: 12px;
        padding-left: 20px;
    }
    .docs-content .body li {
        margin-bottom: 4px;
    }
    .docs-content .body code {
        background: #f1f5f9;
        padding: 2px 6px;
        border-radius: 4px;
        font-size: 12px;
    }
    .docs-content .body pre {
        background: #1e293b;
        color: #e2e8f0;
        padding: 16px;
        border-radius: 8px;
        overflow-x: auto;
        margin-bottom: 12px;
        font-size: 12px;
    }
    @media (max-width: 768px) {
        .docs-show {
            grid-template-columns: 1fr;
        }
        .docs-sidebar {
            display: none;
        }
    }
</style>

<div class="docs-show">
    <aside class="docs-sidebar">
        <div class="docs-sidebar-title">
            <i class="fas fa-list"></i> Documentation
        </div>
        @foreach($sidebar as $category => $docs)
            <div class="docs-sidebar-category">
                <div class="docs-sidebar-cat-title">{{ ucfirst(str_replace('-', ' ', $category)) }}</div>
                @foreach($docs as $d)
                    <a href="{{ route('docs.show', $d->slug) }}" class="docs-sidebar-link {{ $d->id === $doc->id ? 'active' : '' }}">
                        {{ $d->title }}
                    </a>
                @endforeach
            </div>
        @endforeach
        <a href="{{ route('docs') }}" style="display:block;margin-top:16px;padding:8px;font-size:12px;color:#ee4d2d;text-decoration:none;text-align:center;">
            <i class="fas fa-arrow-left"></i> Back to Documentation
        </a>
    </aside>
    
    <article class="docs-content">
        <h1>{{ $doc->title }}</h1>
        <div class="meta">
            <i class="fas fa-folder"></i> {{ ucfirst(str_replace('-', ' ', $doc->category)) }}
            &middot; Last updated {{ $doc->updated_at->format('d M Y') }}
        </div>
        <div class="body">
            {!! $doc->content !!}
        </div>
    </article>
</div>
@endsection