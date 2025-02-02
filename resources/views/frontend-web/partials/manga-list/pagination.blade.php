<div class="pagination-outter" id="ctl00_mainContent_ctl01_divPager">
    @php
        $start = max(1, $mangas->currentPage() - 2);
        $end = min($mangas->lastPage(), $start + 4);
    @endphp
    <ul class="pagination" role="navigation">
        {{-- Previous Page Links --}}
        @if ($mangas->onFirstPage())
            <li class="page-item disabled"><span class="page-link">«</span></li>
            <li class="page-item disabled"><span class="page-link">‹</span></li>
        @else
            <li class="page-item"><a class="page-link" href="{{ $mangas->url(1) }}">«</a></li>
            <li class="page-item"><a class="page-link" href="{{ $mangas->previousPageUrl() }}">‹</a></li>
        @endif

        {{-- Page Number Links --}}
        @for ($i = $start; $i <= $end; $i++)
            <li class="page-item {{ $mangas->currentPage() == $i ? 'active' : '' }}">
                <a class="page-link" href="{{ $mangas->url($i) }}">{{ $i }}</a>
            </li>
        @endfor

        {{-- Next Page Links --}}
        @if ($mangas->hasMorePages())
            <li class="page-item"><a class="page-link" href="{{ $mangas->nextPageUrl() }}">›</a>
            </li>
            <li class="page-item"><a class="page-link" href="{{ $mangas->url($mangas->lastPage()) }}">»</a></li>
        @else
            <li class="page-item disabled"><span class="page-link">›</span></li>
            <li class="page-item disabled"><span class="page-link">»</span></li>
        @endif
    </ul>
</div>
