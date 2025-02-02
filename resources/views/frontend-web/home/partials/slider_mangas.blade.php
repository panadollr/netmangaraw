<div class="altcontent1 cmszone" id="ctl00_divAlt1">
    <div class="Module Module-183 top-comics">
        <div class="ModuleContent">
            <h2 class="page-title">
                @lang('menu.top_overall')
                <i class="fa fa-angle-right"></i>
            </h2>
            <div class="items-slide">
                <div class="clearfix owl-carousel">
                    @foreach ($mangas as $manga)
                        <div class="item">
                            <a href="{{ route('manga.detail', ['slug' => $manga->slug]) }}"
                                title="{{ $manga->title }}"><img alt="{{ $manga->title }}" class="center lazyOwl lazy"
                                    data-original="{{ $manga->cover }}"
                                    src="{{ asset(config('custom.preload_cover')) }}" /></a>
                            <div class="slide-caption">
                                <h3>
                                    <a href="{{ route('manga.detail', ['slug' => $manga->slug]) }}"
                                        title="{{ $manga->title }}">
                                        {{ $manga->title }}
                                    </a>
                                </h3>

                                @if ($manga->latestChapter)
                                    <a href="{{ route('manga.read', ['slug' => $manga->slug, 'chapter_number' => $manga->latestChapter->chapter_number]) }}"
                                        title="@lang('menu.chapter', ['number' => $manga->latestChapter->chapter_number])">
                                        @lang('menu.chapter', ['number' => $manga->latestChapter->chapter_number])
                                    </a>
                                    <span class="time"><i class="fa fa-clock-o"></i>
                                        {{ diffForHumans($manga->latestChapter->created_at) }}
                                    </span>
                                @endif

                            </div>
                        </div>
                    @endforeach
                </div>
                </ <a aria-label="@lang('pagination.previous')" class="prev" href="#"></a>
                <a aria-label="@lang('pagination.next')" class="next" href="#"></a>
            </div>
        </div>
    </div>
</div>
