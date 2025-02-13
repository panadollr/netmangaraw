@extends('frontend-web.app')

@section('content')
    @php
        $genreParam = request()->query('genre');
        if ($genreParam) {
            $currentGenre = $genres->where('slug', $genreParam)->first();
        } else {
            $currentGenre = null;
        }
    @endphp

    @include('frontend-web.partials.breadcrumb', [
        'items' => array_filter([
            ['url' => route('home'), 'label' => __('menu.home'), 'active' => false],
            ['url' => route('mangas.search'), 'label' => __('menu.mangas'), 'active' => false],
            $currentGenre
                ? [
                    'url' => route('mangas.search', ['genre' => $currentGenre->slug]),
                    'label' => $currentGenre->name,
                    'active' => true,
                ]
                : null,
        ]),
    ])

    <div class="row">
        <div class="center-side col-md-8" id="ctl00_divCenter">
            <div class="Module Module-169">
                <div class="ModuleContent">
                    <div class="comic-filter" id="ctl00_mainContent_ctl00_divBasicFilter">
                        <h1 class="text-center"> @lang('menu.search') </h1>
                        <div class="dropdown-genres mrb10 mrt10 visible-sm visible-xs">
                            <select class="changed-redirect form-control">
                                <option selected="" value="{{ route('mangas.search') }}">@lang('menu.all_genres')</option>
                                @foreach ($genres as $genre)
                                    @php
                                        $isActive = $genreParam == $genre->slug;
                                    @endphp
                                    <option {{ $isActive ? 'selected=""' : '' }}
                                        value="{{ route('mangas.search', ['genre' => $genre->slug]) }}"> {{ $genre->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="description" id="ctl00_mainContent_ctl00_divDescription">
                            <div class="info">
                                @if ($currentGenre)
                                    {{ $currentGenre->name }} : {{ $currentGenre->seo_des }}
                                @else
                                    @lang('menu.all_genres')
                                @endif
                            </div>
                        </div>

                        @php
                            $currentStatus = request()->query('status');
                        @endphp
                        <ul class="nav nav-tabs" id="ctl00_mainContent_ctl00_ulStatus">
                            <li class="{{ !$currentStatus ? 'active' : '' }}" style="margin-right: 5px;">
                                <a href="{{ route('mangas.search') }}"> @lang('menu.search') </a>
                            </li>
                            @foreach ($statuses as $status)
                                @php
                                    $isActive = $currentStatus == $status->slug;
                                @endphp
                                <li class="{{ $isActive ? 'active' : '' }}" style="margin-right: 5px;">
                                    <a
                                        href="{{ route('mangas.search', array_merge(request()->query(), ['status' => $status->slug])) }}">
                                        {{ $status->name }} </a>
                                </li>
                            @endforeach
                        </ul>
                        <div class="row sort-by" id="ctl00_mainContent_ctl00_divSort">
                            <div class="col-sm-3 mrb5 mrt5"> @lang('menu.type') </div>
                            <div class="col-sm-9">
                                <div class="hidden-xs">
                                    @php
                                        $sorts = [
                                            'latest_updated' => __('menu.recent_updates'),
                                            'newest' => __('menu.newest'),
                                            'top' => __('menu.top_overall'),
                                            'top-monthly' => __('menu.top_monthly'),
                                            'top-weekly' => __('menu.top_weekly'),
                                            'top-daily' => __('menu.top_daily'),
                                            'follow' => __('menu.followed'),
                                            'chapter' => __('menu.chapter_count'),
                                        ];
                                        $currentSort = request()->query('sort');
                                        $defaultSort = array_key_first($sorts);
                                    @endphp

                                    @foreach ($sorts as $key => $label)
                                        @php
                                            $isActive =
                                                (!$currentSort && $key === $defaultSort) || $currentSort == $key;
                                        @endphp
                                        <a class="ajaxlink {{ $isActive ? 'active' : '' }}"
                                            href="{{ route('mangas.search', array_merge(request()->query(), ['sort' => $key])) }}">
                                            {{ $label }} </a>
                                    @endforeach
                                </div>

                                <select class="changed-redirect form-control visible-xs"
                                    id="ctl00_mainContent_ctl00_ddSortBy" name="ctl00$mainContent$ctl00$ddSortBy">
                                    @foreach ($sorts as $key => $label)
                                        @php
                                            $isActive = request()->query('sort') == $key;
                                        @endphp
                                        <option {{ $isActive ? 'selected=""' : '' }}
                                            value="{{ route('mangas.search', array_merge(request()->query(), ['sort' => $key])) }}">
                                            {{ $label }} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="Module Module-170">
                <div class="ModuleContent">
                    <div class="items">
                        <div class="row">
                            @each('frontend-web.partials.manga-list.item', $mangas, 'manga')
                        </div>
                    </div>

                    @include('frontend-web.partials.manga-list.pagination', ['mangas' => $mangas])

                </div>
            </div>
        </div>
        <div class="cmszone col-md-4 right-side" id="ctl00_divRight">
            <div class="Module Module-179 box darkBox genres hidden-sm hidden-xs">
                <div class="ModuleContent">
                    <h2 class="module-title">
                        <b>@lang('menu.genres')</b>
                    </h2>
                    <ul class="nav">
                        <li class="{{ !$genreParam ? 'active' : '' }}">
                            <a href="{{ route('mangas.search', []) }}" {{ !$genreParam ? 'target="_self"' : '' }}>
                                @lang('menu.all_genres')
                            </a>
                        </li>

                        @foreach ($genres as $genre)
                            @php
                                $isActive = $genreParam == $genre->slug;
                            @endphp
                            <li class="{{ $isActive ? 'active' : '' }}">
                                <a href="{{ route('mangas.search', ['genre' => $genre->slug]) }}"
                                    {{ $genreParam ? '' : 'target="_self"' }}>
                                    {{ $genre->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
