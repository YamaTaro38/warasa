@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;">
        <div style="font-size:12px;color:var(--gray-500);">
            <span>Showing</span>
            <span style="font-weight:600;color:var(--gray-700);">{{ $paginator->firstItem() }}</span>
            <span>to</span>
            <span style="font-weight:600;color:var(--gray-700);">{{ $paginator->lastItem() }}</span>
            <span>of</span>
            <span style="font-weight:600;color:var(--gray-700);">{{ $paginator->total() }}</span>
            <span>results</span>
        </div>

        <div style="display:flex;align-items:center;gap:4px;">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <span style="padding:6px 10px;font-size:12px;color:var(--gray-300);border:1px solid var(--gray-200);border-radius:var(--radius-sm);cursor:not-allowed;">
                    <i class="fas fa-chevron-left" style="font-size:10px;"></i>
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" style="padding:6px 10px;font-size:12px;color:var(--gray-600);border:1px solid var(--gray-200);border-radius:var(--radius-sm);text-decoration:none;transition:all 0.15s;" onmouseover="this.style.background='var(--gray-100)'" onmouseout="this.style.background=''">
                    <i class="fas fa-chevron-left" style="font-size:10px;"></i>
                </a>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <span style="padding:6px 10px;font-size:12px;color:var(--gray-400);border:1px solid transparent;">{{ $element }}</span>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span style="padding:6px 12px;font-size:12px;font-weight:600;color:white;background:var(--primary);border:1px solid var(--primary);border-radius:var(--radius-sm);cursor:default;">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" style="padding:6px 12px;font-size:12px;color:var(--gray-600);border:1px solid var(--gray-300);border-radius:var(--radius-sm);text-decoration:none;transition:all 0.15s;" onmouseover="this.style.background='var(--gray-100)';this.style.borderColor='var(--primary)';this.style.color='var(--primary)'" onmouseout="this.style.background='';this.style.borderColor='var(--gray-300)';this.style.color='var(--gray-600)'">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" style="padding:6px 10px;font-size:12px;color:var(--gray-600);border:1px solid var(--gray-200);border-radius:var(--radius-sm);text-decoration:none;transition:all 0.15s;" onmouseover="this.style.background='var(--gray-100)'" onmouseout="this.style.background=''">
                    <i class="fas fa-chevron-right" style="font-size:10px;"></i>
                </a>
            @else
                <span style="padding:6px 10px;font-size:12px;color:var(--gray-300);border:1px solid var(--gray-200);border-radius:var(--radius-sm);cursor:not-allowed;">
                    <i class="fas fa-chevron-right" style="font-size:10px;"></i>
                </span>
            @endif
        </div>
    </nav>
@endif