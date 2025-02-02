@extends('frontend-web.app')

@section('title', '')
@section('content')

    @if ($sliderMangas->isNotEmpty())
        @include('frontend-web.home.partials.slider_mangas', ['mangas' => $sliderMangas])
    @endif
    <div class="row">
        <div class="center-side col-md-8" id="ctl00_divCenter">
            <section class="Module Module-163">
                <div class="ModuleContent">
                    <div class="items">
                        <div class="relative">
                            <h1 class="page-title">
                                @lang('menu.recent_updates') <i class="fa fa-angle-right"></i>
                            </h1>
                            <a class="filter-icon" href="{{ route('mangas.search') }}" title="Filter Manga"><i
                                    class="fa fa-filter"></i></a>
                        </div>
                        <div class="row">
                            @if (!empty($updatedMangas))
                                @each('frontend-web.partials.manga-list.item', $updatedMangas, 'manga')
                            @endif
                        </div>
                    </div>

                    @include('frontend-web.partials.manga-list.pagination', ['mangas' => $updatedMangas])

                </div>
            </section>
        </div>

        @include('frontend-web.partials.most-viewed-mangas', ['mangas' => $mostViewedMangas])
    </div>

@endsection
