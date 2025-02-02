<div class="box_doc reading-detail">
    @php
        $pages = $currentChapter->content;
        $totalPages = count($pages);
    @endphp
    <div class="page-chapter" id="page_0}">
        <img alt="{{ config('custom.frontend-name') }} - Page 0"
            data-cdn="{{ asset('frontend-web/images/chapter_page_notify.jpg') }}" data-index="0"
            data-original="{{ asset('frontend-web/images/chapter_page_notify.jpg') }}" referrerpolicy="no-referrer"
            src="{{ asset('frontend-web/images/chapter_page_notify.jpg') }}" loading="lazy" />
    </div>
    @foreach ($pages as $index => $page)
        <div class="page-chapter" id="page_{{ $index }}">
            <img alt="{{ $manga->title }} - Page {{ $index }}" data-cdn="{{ $page }}" data-index="1"
                data-original="{{ $page }}" referrerpolicy="no-referrer" src="{{ $page }}"
                loading="lazy" />
        </div>
        @if ($index === $totalPages - 1)
            <div class="lazy-module page-chapter" data-type="end-chapter" id="page_{{ $index }}">
                <img alt="{{ $manga->title }} - Page {{ $index }}" data-cdn="{{ $page }}"
                    data-index="{{ $index }}" data-original="{{ $page }}" loading="lazy"
                    referrerpolicy="no-referrer" src="{{ $page }}" />
            </div>
        @endif
    @endforeach
</div>
