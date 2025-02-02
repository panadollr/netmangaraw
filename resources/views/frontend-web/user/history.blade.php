@extends('frontend-web.app')

@section('content')
    <div class="container">
        <div id="ctl00_Breadcrumbs_pnlWrapper">

            @include('frontend-web.partials.breadcrumb', [
                'items' => array_filter([
                    ['url' => route('home'), 'label' => __('menu.home'), 'active' => false],
                    ['url' => '/history', 'label' => __('menu.history'), 'active' => false],
                ]),
            ])

        </div>
        <div class="row">
            <div class="center-side col-md-8" id="ctl00_divCenter">
                <div class="Module Module-233 mrb10">
                    <div class="ModuleContent">
                        <h1 class="page-title">@lang('menu.history') <em class="fa fa-angle-right"></em>
                        </h1>
                        <div class="mrt15 visited-tab">
                            <ul class="comment-nav text-center" style="font-size:16px;margin-bottom:15px;">
                                <li class="active">
                                    <a href="{{ route('history') }}">@lang('menu.history')</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="Module Module-273 items visited-comics-page">
                    <div class="row visited-list">

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
                    $(".visited-comics-page").length ||
                    $(".visited-comics").length
                ) {
                    var e = 0,
                        o = $(".visited-comics-page");
                    if ($(".visited-comics-nopaging").length)
                        (e = 1), (o = $(".visited-comics"));
                    else if ($(".visited-comics-withpaging").length)
                        (e = 2), (o = $(".visited-comics"));
                    else {
                        var a = getParameterByName("t");
                        3 == a && (e = a);
                    }!(function(e, o) {
                        if (0 == AjaxHelper.loadWaiting) {
                            AjaxHelper.setLoadWaiting(!0);
                            var a = getParameterByName("page");
                            var historyIds = JSON.parse(localStorage.getItem('historyIds')) || [];
                            null == a && (a = 1),
                                $.ajax({
                                    type: "GET",
                                    url: "/get-history",
                                    data: {
                                        page: a,
                                        loadType: o,
                                        historyIds: historyIds
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
                                                    '<p>Bạn vẫn chưa theo dõi câu chuyện. Để theo dõi câu chuyện, vui lòng nhấn vào <u>Theo dõi</u> như trong hình dưới đây.<br />Để truy cập vào câu chuyện mà bạn đã theo dõi từ bất kỳ đâu, vui lòng <a href="/Secure/Login.aspx">đăng nhập</a>.</p><p class="text-center"><img src="/public/assets/images/huong-dan-theo-doi-truyen.jpg" width="660" style="aspect-ratio:1.52" alt="Cách theo dõi truyện"></img></p>'
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
                setupLazyLoad(".visited-comics-block");
            }
            PopulateData()
        });
    </script>
@endsection
