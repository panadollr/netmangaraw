<aside class="cmszone col-md-4 right-side" id="ctl00_divRight">
    <div class="random text-center"></div>
    <div class="visited-comics"></div>
    <section class="Module Module-168 comic-wrap">
        <div class="ModuleContent">
            <div class="box box-tab darkBox">
                <ul class="clearfix tab-nav">
                    <li>
                        <a class="active" href="{{ route('mangas.search', ['sort' => 'top-monthly']) }}" rel="nofollow"
                            title="@lang('menu.top_monthly')">@lang('menu.top_monthly')</a>
                    </li>
                    <li>
                        <a href="{{ route('mangas.search', ['sort' => 'top-weekly']) }}" rel="nofollow"
                            title="@lang('menu.top_weekly')">@lang('menu.top_weekly')</a>
                    </li>
                    <li>
                        <a href="{{ route('mangas.search', ['sort' => 'top-daily']) }}" rel="nofollow"
                            title="@lang('menu.top_daily')">@lang('menu.top_daily')</a>
                    </li>
                </ul>
                <div class="tab-pane">
                    <div id="topMonth">
                        <ul class="list-unstyled">
                            @foreach ($mangas as $index => $manga)
                                <li class="clearfix">
                                    <span class="fn-order pos1 txt-rank">{{ $index + 1 }}</span>
                                    <div class="comic-item t-item" data-id="{{ $manga->id }}">
                                        <a class="thumb" href="{{ route('manga.detail', ['slug' => $manga->slug]) }}"
                                            title="{{ $manga->title }}"><img alt="{{ $manga->title }}"
                                                class="center lazy" data-original="{{ $manga->cover }}" loading="lazy"
                                                src="{{ asset(config('custom.preload_cover')) }}" /></a>
                                        <h3 class="title">
                                            <a href="{{ route('manga.detail', ['slug' => $manga->slug]) }}"
                                                title="{{ $manga->title }}">{{ $manga->title }}</a>
                                        </h3>
                                        <p class="chapter top">
                                            @foreach ($manga->chapters as $chapter)
                                                <a data-id="{{ $chapter->chapter_number }}"
                                                    href="{{ route('manga.read', ['slug' => $manga->slug, 'chapter_number' => $chapter->chapter_number]) }}"
                                                    title="@lang('menu.chapter', ['number' => $chapter->chapter_number])">
                                                    @lang('menu.chapter', ['number' => $chapter->chapter_number])
                                                </a>
                                                <span class="pull-right view"><i class="fa fa-eye"></i>
                                                    {{ number_format($manga->views_sum_views) }}</span>
                                            @endforeach
                                        </p>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div id="topWeek"></div>
                    <div id="topDay"></div>
                </div>
            </div>
        </div>
    </section>
</aside>
