@extends('frontend-web.app')

@section('content')
    <div class="container">
        <div id="ctl00_Breadcrumbs_pnlWrapper">

            @include('frontend-web.partials.breadcrumb', [
                'items' => array_filter([
                    ['url' => route('home'), 'label' => __('menu.home'), 'active' => false],
                    ['url' => route('bookmark'), 'label' => __('menu.bookmark'), 'active' => false],
                ]),
            ])

        </div>
        <div class="row">
            <div class="center-side col-md-8" id="ctl00_divCenter">
                <div class="Module Module-287">
                    <div class="ModuleContent">
                        <h1 class="page-title"> @lang('menu.bookmark') <em class="fa fa-angle-right"></em>
                        </h1>
                    </div>
                </div>
                <div class="comics-followed-page">
                    <div class="mrt15">
                        <ul class="comment-nav text-center" style="font-size:16px;margin-bottom:15px">
                            <li class="active">
                                <a href="{{ route('bookmark') }}">@lang('menu.bookmark')</a>
                            </li>
                        </ul>
                    </div>
                    <div class="items">
                        <div class="row">
                        </div>
                    </div>

                    <div class="pagination-outter">
                        <ul class="pagination" role="navigation">
                            <li class="page-item active">
                                <a class="page-link" href="/bookmark?page=1">1</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            @include('frontend-web.partials.most-viewed-mangas', ['mangas' => $mostViewedMangas])

        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            function PopulateData() {
                if ($("body").hasClass("chapter-detail")) processComicLoader(!0);
                else if ($("body").hasClass("comic-detail")) processComicLoader(!1);
                else if (
                    $(".comics-followed-page .row").length ||
                    $(".comics-followed").length
                ) {
                    var e = 0,
                        o = $(".comics-followed-page .row");
                    if ($(".comics-followed-nopaging").length)
                        (e = 1), (o = $(".comics-followed"));
                    else if ($(".comics-followed-withpaging").length)
                        (e = 2), (o = $(".comics-followed"));
                    else {
                        var a = getParameterByName("t");
                        3 == a && (e = a);
                    }!(function(e, o) {
                        // alert('haha')
                        if (0 == AjaxHelper.loadWaiting) {
                            AjaxHelper.setLoadWaiting(!0);
                            var a = getParameterByName("page");
                            // Lấy mảng bookmarkIds từ localStorage
                            var bookmarkIds = JSON.parse(localStorage.getItem('bookmarkIds')) || [];
                            null == a && (a = 1),
                                $.ajax({
                                    type: "GET",
                                    url: "{{ route('get-bookmark') }}",
                                    data: {
                                        page: a,
                                        loadType: o,
                                        bookmarkIds: bookmarkIds
                                    },
                                    success: function(a) {
                                        a.success &&
                                            (a.followedListHtml ?
                                                (e.html(replaceUrl(a.followedListHtml)),
                                                    initLazyload(),
                                                    loadTooltip(),
                                                    a.pagerHtml &&
                                                    $(
                                                        '<div class="pagination-outter"></div>'
                                                    )
                                                    .html(a.pagerHtml)
                                                    .appendTo(e),
                                                    $("html, body").animate({
                                                            scrollTop: 0
                                                        },
                                                        0,
                                                        "linear"
                                                    )) :
                                                0 == o &&
                                                e.html(
                                                    '<p>{{ __('menu.no_mangas') }}</p>'
                                                ));
                                    },
                                    complete: function(e) {
                                        AjaxHelper.setLoadWaiting(!1);
                                    },
                                    error: function(e, o, a) {
                                        console.log(a);
                                    },
                                });
                        }
                    })(o, e);
                }
                setupLazyLoad(".comics-followed-block");
            }
            PopulateData()


        });
    </script>
@endsection
