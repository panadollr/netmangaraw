@extends('frontend-web.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="center-side col-md-8" id="ctl00_divCenter">

                @include('frontend-web.partials.breadcrumb', [
                    'items' => array_filter([
                        ['url' => route('home'), 'label' => __('menu.home'), 'active' => false],
                        ['url' => route('mangas.search'), 'label' => __('menu.mangas'), 'active' => false],
                        [
                            'url' => route('manga.detail', ['slug' => $manga->slug]),
                            'label' => limitString($manga->title, 50),
                            'active' => true,
                        ],
                    ]),
                ])

                <article id="item-detail">
                    <h1 class="title-detail">
                        {{ e($manga->title) }}
                    </h1>
                    <time class="small"> [@lang('menu.updated_at'): {{ $manga->updated_at }}] </time>
                    <div class="detail-info">
                        <div class="row">
                            <div class="col-image col-xs-4">
                                <img alt="{{ $manga->title }}" src="{{ $manga->cover }}" />
                            </div>
                            <div class="col-info col-xs-8">
                                <ul class="list-info">
                                    <li class="othername row">
                                        <p class="col-xs-4 name">
                                            <i class="fa fa-plus"></i> @lang('menu.alternative_titles')
                                        </p>
                                        <p class="col-xs-8">
                                            {{ $manga->alternative_titles }}
                                        </p>
                                    </li>
                                    <li class="author row">
                                        <p class="col-xs-4 name">
                                            <i class="fa fa-user"></i> @lang('menu.author')
                                        </p>
                                        <p class="col-xs-8">{{ $manga->author }}</p>
                                    </li>
                                    <li class="row status">
                                        <p class="col-xs-4 name">
                                            <i class="fa fa-rss"></i> @lang('menu.status')
                                        </p>
                                        <p class="col-xs-8">{{ $status->name }}</p>
                                    </li>
                                    <li class="kind row">
                                        <p class="col-xs-4 name">
                                            <i class="fa fa-tags"></i> @lang('menu.genres')
                                        </p>
                                        <p class="col-xs-8">
                                            @foreach ($genres as $index => $genre)
                                                <a href="{{ route('mangas.search', ['genre' => $genre->slug]) }}">
                                                    {{ e($genre->name) }}
                                                </a>
                                                @if (!$loop->last)
                                                    -
                                                @endif
                                            @endforeach
                                        </p>
                                    </li>
                                    <li class="row">
                                        <p class="col-xs-4 name">
                                            <i class="fa fa-eye"></i> @lang('menu.views')
                                        </p>
                                        <p class="col-xs-8">{{ number_format($manga->views_sum_views) }}</p>
                                    </li>
                                </ul>
                                <div class="mrb10 mrt5" itemscope="" itemtype="http://schema.org/Book">
                                    <a href="{{ route('manga.detail', ['slug' => $manga->slug]) }}" itemprop="url"><span
                                            itemprop="name">{{ $manga->title }}</span></a>
                                    <span itemprop="aggregateRating" itemscope=""
                                        itemtype="https://schema.org/AggregateRating">
                                        @lang('menu.rating'): <span itemprop="ratingValue">5</span>/<span
                                            itemprop="bestRating">5</span>
                                </div>
                                <div class="rating row">
                                    <div class="col-xs-6">
                                        <div class="star" data-allowrating="true" data-id="{{ $manga->id }}"
                                            data-rating="5" style="cursor: pointer;">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <img src="{{ asset('frontend-web/images/star-on.png') }}"
                                                    alt="{{ $i }}"
                                                    title="{{ ['bad', 'poor', 'regular', 'good', 'gorgeous'][$i - 1] }}">
                                            @endfor
                                            <input type="hidden" name="score" value="5">
                                        </div>
                                    </div>
                                </div>

                                @include('frontend-web.manga-detail.components.bookmark_btn')

                                <div class="mrt10 read-action">
                                    @if ($oldestChapter)
                                        <a class="btn btn-warning mrb5"
                                            href="{{ route('manga.read', ['slug' => $manga->slug, 'chapter_number' => $oldestChapter->chapter_number]) }}">
                                            @lang('menu.read_first_btn')
                                        </a>
                                    @endif

                                    @if ($latestChapter)
                                        <a class="btn btn-warning mrb5"
                                            href="{{ route('manga.read', ['slug' => $manga->slug, 'chapter_number' => $latestChapter->chapter_number]) }}">
                                            @lang('menu.read_latest_btn')
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    @include('frontend-web.manga-detail.components.description', [
                        'manga' => $manga,
                    ])

                    @if ($manga->chapters->isNotEmpty())
                        @include('frontend-web.manga-detail.components.chapters', [
                            'chapters' => $manga->chapters,
                        ])
                    @endif

                    <div class="detail-content" style="margin-top: 20px">
                        <h3 class="list-title">@lang('menu.related_keywords')</h3>
                        <p>
                            {{ $seoData['keywords'] }}
                        </p>
                    </div>
                </article>
            </div>

            @include('frontend-web.partials.most-viewed-mangas', ['mangas' => $mostViewedMangas])

        </div>
    </div>
@endsection
