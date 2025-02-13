<header class="header" id="header"
    style="background: url({{ asset('frontend-web/images/bg_header_2017') }}) top center repeat-x;">
    <div class="navbar">
        <div class="container">
            <div class="navbar-header">
                <div class="navbar-brand">
                    <a class="logo" href="{{ route('home') }}" title=""><img alt=""
                            src="{{ asset('frontend-web/images/logo.png') }}"
                            style="aspect-ratio: 3.6; object-fit: cover" width="135" /></a>
                </div>
                <div class="comicsearchbox hidden-xs navbar-form navbar-left search-box">
                    <div class="input-group">
                        <input autocomplete="off" class="form-control searchinput" placeholder="@lang('menu.search_placeholder')"
                            type="text" />
                        <div class="input-group-btn">
                            <input class="btn btn-default searchbutton" type="submit" value="" />
                        </div>
                    </div>
                </div>
                <i class="fa fa-lightbulb-o toggle-dark"></i>
                <button aria-label="Search" class="search-button-icon visible-xs" type="button">
                    <i class="fa fa-search"></i>
                </button>
                <button aria-label="Menu" class="navbar-toggle" type="button">
                    <i class="fa fa-bars"></i>
                </button>
            </div>
            <script>
                var gOpts = {};
                gOpts.host = "{{ url('/') }}";
            </script>
            <script>
                var _0xcca4 = [
                        ".toggle-dark",
                        "querySelector",
                        "undefined",
                        "body",
                        "class",
                        "fa fa-lightbulb-o on toggle-dark",
                        "setAttribute",
                        "dark",
                        "indexOf",
                        "getAttribute",
                        " dark",
                        "fa fa-lightbulb-o toggle-dark",
                        "",
                        "replace",
                        "dark-theme",
                        "click",
                        "removeItem",
                        "addEventListener",
                        "parentNode",
                        "removeChild",
                    ],
                    toggleDarkObj = document[_0xcca4[1]](_0xcca4[0]);
                if (_0xcca4[2] != typeof Storage) {
                    function setDarkTheme(c, a) {
                        var e = document[_0xcca4[3]];
                        1 == a ?
                            (c[_0xcca4[6]](_0xcca4[4], _0xcca4[5]),
                                e[_0xcca4[9]](_0xcca4[4])[_0xcca4[8]](_0xcca4[7]) < 0 &&
                                e[_0xcca4[6]](
                                    _0xcca4[4],
                                    e[_0xcca4[9]](_0xcca4[4]) + _0xcca4[10]
                                )) :
                            (c[_0xcca4[6]](_0xcca4[4], _0xcca4[11]),
                                e[_0xcca4[9]](_0xcca4[4])[_0xcca4[8]](_0xcca4[10]) >= 0 &&
                                e[_0xcca4[6]](
                                    _0xcca4[4],
                                    e[_0xcca4[9]](_0xcca4[4])[_0xcca4[13]](
                                        _0xcca4[10],
                                        _0xcca4[12]
                                    )
                                ));
                    }
                    void 0 !== localStorage[_0xcca4[14]] &&
                        setDarkTheme(toggleDarkObj, !0),
                        toggleDarkObj[_0xcca4[17]](_0xcca4[15], function(c) {
                            _0xcca4[11] == this[_0xcca4[9]](_0xcca4[4]) ?
                                (setDarkTheme(this, !0),
                                    (localStorage[_0xcca4[14]] = 1)) :
                                (setDarkTheme(this, !1),
                                    void 0 !== localStorage[_0xcca4[14]] &&
                                    localStorage[_0xcca4[16]](_0xcca4[14]));
                        });
                } else
                    toggleDarkObj[_0xcca4[18]] &&
                    toggleDarkObj[_0xcca4[18]][_0xcca4[19]](toggleDarkObj);
            </script>
            <ul class="hidden-xs list-inline nav-account pull-right"></ul>
        </div>
    </div>
</header>
<nav class="hidden-xs main-nav" id="mainNav">
    <div class="inner">
        <div class="container">
            <div class="Module Module-144">
                <div class="ModuleContent">
                    <ul class="main-menu nav navbar-nav">
                        <li class="{{ request()->routeIs('home') ? 'active' : '' }}">
                            <a href="{{ route('home') }}" target="_self"><i class="fa fa-home hidden-xs"></i>
                                <span class="visible-xs">@lang('menu.home')</span>
                        </li>
                        <li class="{{ request()->routeIs('bookmark') ? 'active' : '' }}">
                            <a href="{{ route('bookmark') }}" target="_self">@lang('menu.bookmark')</a>
                        </li>
                        <li class="{{ request()->routeIs('history') ? 'active' : '' }}">
                            <a href="{{ route('history') }}" target="_self">@lang('menu.history')</a>
                        </li>
                        <li class="dropdown {{ request()->routeIs('mangas.search') ? 'active' : '' }}">
                            <a aria-expanded="false" class="dropdown-toggle" data-toggle="dropdown" href="#"
                                role="button" target="_self">
                                @lang('menu.categories')
                                <i class="fa fa-caret-down"></i>
                            </a>

                            @php
                                $totalGenres = count($headerGenres);
                                $index = 0;
                            @endphp

                            <ul class="dropdown-menu megamenu">
                                <li>
                                    <div class="clearfix">
                                        @for ($i = 0; $i < $totalGenres; $i++)
                                            @if ($index < $totalGenres)
                                                <div class="col-sm-3">
                                                    <ul class="nav">
                                                        @for ($j = 0; $j < 2; $j++)
                                                            @if ($index < $totalGenres)
                                                                <li>
                                                                    <a data-title="{{ $headerGenres[$index]->seo_des ?? '' }}"
                                                                        href="{{ route('mangas.search', ['genre' => $headerGenres[$index]->slug]) }}"
                                                                        target="_self">
                                                                        {{ $headerGenres[$index]->name ?? '' }}
                                                                    </a>
                                                                </li>
                                                                @php $index++; @endphp
                                                            @endif
                                                        @endfor
                                                    </ul>
                                                </div>
                                            @endif
                                        @endfor

                                        <div class="col-sm-12 hidden-xs">
                                            <p class="tip"></p>
                                        </div>
                                    </div>
                                </li>
                            </ul>

                        </li>
                        <li class="dropdown">
                            <a aria-expanded="false" class="dropdown-toggle" data-toggle="dropdown" href="#"
                                rel="nofollow" role="button">
                                @lang('menu.rankings')
                                <i class="fa fa-sort"></i></a>
                            <div class="dropdown-menu navbar-dropdown">
                                <a href="{{ route('mangas.search') }}" rel="nofollow">
                                    <i class="fa fa-eye"></i> @lang('menu.top_overall') </a>
                                <a href="{{ route('mangas.search', ['status' => 'completed']) }}">
                                    <strong>
                                        <i class="fa fa-signal"></i> @lang('menu.completed') </strong>
                                </a>
                                <a href="{{ route('mangas.search', ['sort' => 'top-monthly']) }}" rel="nofollow">
                                    <i class="fa fa-eye"></i> @lang('menu.top_monthly') </a>
                                <a href="{{ route('mangas.search', ['sort' => 'top-weekly']) }}" rel="nofollow">
                                    <i class="fa fa-eye"></i> @lang('menu.top_weekly') </a>
                                <a href="{{ route('mangas.search', ['sort' => 'newest']) }}">
                                    <i class="fa fa-refresh"></i> @lang('menu.newest') </a>
                                <a href="{{ route('mangas.search', ['sort' => 'top-daily']) }}" rel="nofollow">
                                    <i class="fa fa-eye"></i> @lang('menu.top_daily') </a>
                                <a href="{{ route('mangas.search', ['sort' => 'top-daily']) }}" rel="nofollow">
                                    <i class="fa fa-list"></i> @lang('menu.chapter_count') </a>
                            </div>
                        </li>
                        <li class="">
                            <a href="{{ route('mangas.search') }}" target="_self">@lang('menu.search')</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</nav>
