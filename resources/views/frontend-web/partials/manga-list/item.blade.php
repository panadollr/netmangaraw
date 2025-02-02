<article class="item">
    <figure class="clearfix">
        <div class="image">
            <a href="{{ route('manga.detail', ['slug' => $manga->slug]) }}" title="{{ $manga->title }}">
                <img alt="{{ $manga->title }}" class="lazy" data-original="{{ $manga->cover }}"
                    src="{{ asset(config('custom.preload_cover')) }}"
                    onerror="this.onerror=null;this.src='{{ asset('frontend-web/images/logo.png') }}';" />
            </a>
            <div class="clearfix view">
                <span class="pull-left">
                    <i class="fa fa-eye"></i> {{ number_format($manga->views_sum_views ?? 0) }}
                    <i class="fa fa-comment"></i> 0
                    <i class="fa fa-heart"></i> 0
                </span>
            </div>
        </div>

        {{-- Thông tin chi tiết --}}
        <figcaption>
            @if (!empty($isHistoryPage))
                <ul>
                    @foreach ($manga->chapters as $chapter)
                        <li class="chapter clearfix">
                            <a style="color: green; font-weight: bold"
                                href="{{ route('manga.read', ['slug' => $manga->slug, 'chapter_number' => $chapter->chapter_number]) }}">
                                @lang('menu.continue_reading', ['number' => $chapter->chapter_number])
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endif

            @if (!empty($isBookmarkPage))
                <div class="follow-action clearfix">
                    <a href="javascript:void(0)" class="unfollow follow-link btn-danger" data-id="{{ $manga->id }}">
                        <i class="fa fa-times"></i> <span>Unfollow</span>
                    </a>

                    <script>
                        $('.unfollow').on('click', function() {
                            location.reload();
                        });
                    </script>

                </div>
            @endif
            <h3>
                <a class="jtip" data-jtip="#manga-{{ $manga->id }}"
                    href="{{ route('manga.detail', ['slug' => $manga->slug]) }}">
                    {{ $manga->title }}
                </a>
            </h3>

            <ul class="comic-item" data-id="{{ $manga->id }}">
                @foreach ($manga->chapters as $chapter)
                    <li class="chapter clearfix">
                        <a data-id="{{ $chapter->id }}"
                            href="{{ route('manga.read', ['slug' => $manga->slug, 'chapter_number' => $chapter->chapter_number]) }}"
                            title="@lang('menu.chapter', ['number' => $chapter->chapter_number])">
                            @lang('menu.chapter', ['number' => $chapter->chapter_number])
                        </a>
                        <i class="time">{{ diffForHumans($manga->updated_at) }}</i>
                    </li>
                @endforeach
            </ul>
        </figcaption>

    </figure>
    <div class="box_tootip" id="manga-{{ $manga->id }}" style="display: none">
        <div class="box_li">
            <div class="title"></div>
            <div class="clearfix">
                <div class="box_img">
                    <a href="{{ route('manga.detail', ['slug' => $manga->slug]) }}" title="{{ $manga->title }}">
                        <img alt="{{ $manga->title }}" class="lazy" data-original="{{ $manga->cover }}"
                            src="{{ asset(config('custom.preload_cover')) }}"
                            onerror="this.onerror=null;this.src='{{ asset('frontend-web/images/logo.png') }}';" />
                    </a>
                </div>
                <div class="message_main">
                    <p>
                        <label>@lang('menu.alternative_titles'):</label> {{ $manga->alternative_titles }}
                    </p>
                    <p>
                        <label>@lang('menu.genres'):</label>
                        {{ $manga->genres->pluck('name')->join(', ') }}
                    </p>
                    <p>
                        <label>@lang('menu.status'):</label> 0
                    </p>
                    <p>
                        <label>@lang('menu.views'):</label> {{ number_format($manga->views_sum_views ?? 0) }}
                    </p>
                    <p>
                        <label>@lang('menu.updated_at'):</label> {{ diffForHumans($manga->updated_at) }}
                    </p>
                </div>
            </div>
            <div class="box_text"> {!! limitString($manga->description, 100) !!} </div>
        </div>
    </div>
</article>
