<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-sm-4 copyright" itemscope="" itemtype="http://schema.org/Organization">
                <a href="{{ route('home') }}" itemprop="url"><img alt="{{ config('custom.frontend_name') }}" itemprop="logo"
                        src="{{ asset('frontend-web/images/logo.png') }}" style="aspect-ratio: 3.6; object-fit: cover"
                        width="135" /></a>
                <br />
                {{-- <p class="link">
          <a href="">Contact</a>
        </p>
        <p class="link">
          <a href="">Privacy Policy</a>
        </p> --}}
                <p>Copyright © {{ date('Y') }} {{ config('custom.frontend_name') }}. All Rights Reserved.</p>
            </div>
            <div class="col-sm-8">
                <div class="link-footer">
                    <h4>タグ</h4>
                    <ul>
                        <li>
                            <a href="{{ route('home') }}" target="_self" title="mangaraw">Manga</a>
                        </li>
                        <li>
                            <a href="{{ route('home') }}" target="_self" title="mangaraw">Truyện tranh</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>
<nav class="navbar-collapse">
    <div class="comicsearchbox search-box">
        <div class="input-group">
            <input autocomplete="off" class="form-control searchinput" placeholder="作品名、作家名、キーワードで探す" type="text" />
            <div class="input-group-btn">
                <input class="btn btn-default searchbutton" type="submit" value="" />
            </div>
        </div>
    </div>
    <div class="Module Module-144">
        <div class="ModuleContent">
            <ul class="main-menu nav navbar-nav">
                <li class="active">
                    <a href="{{ route('home') }}" target="_self">
                        <i class="fa fa-home hidden-xs"></i>
                        <span class="visible-xs">@lang('messages.home')</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('bookmark') }}" target="_self">@lang('messages.bookmark')</a>
                </li>
                <li>
                    <a href="{{ route('history') }}" target="_self">@lang('messages.history')</a>
                </li>
                <li class="dropdown">
                    <a aria-expanded="false" class="dropdown-toggle" data-toggle="dropdown"
                        href="{{ route('mangas.search') }}" role="button" target="_self">
                        ジャンル <i class="fa fa-caret-down"></i></a>
                    <ul class="dropdown-menu megamenu">
                        <li>
                            @php
                                $totalGenres = count($footerGenres);
                                $index = 0;
                            @endphp
                            <div class="clearfix">
                                @for ($i = 0; $i < $totalGenres; $i++)
                                    @if ($index < $totalGenres)
                                        <div class="col-sm-3">
                                            <ul class="nav">
                                                @for ($j = 0; $j < 2; $j++)
                                                    @if ($index < $totalGenres)
                                                        <li>
                                                            <a data-title="{{ $footerGenres[$index]->seo_des ?? '「説明は利用できません」' }}"
                                                                href="{{ route('mangas.search', ['genre' => $footerGenres[$index]->slug]) }}"
                                                                target="_self">
                                                                {{ $footerGenres[$index]->name }}
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
                        rel="nofollow" role="button">ランキング <i class="fa fa-sort"></i></a>
                    <div class="dropdown-menu navbar-dropdown">
                        <a href="{{ route('mangas.search') }}" rel="nofollow">
                            <i class="fa fa-eye"></i> トップ全体 </a>
                        <a href="{{ route('mangas.search', ['status' => 'completed']) }}">
                            <strong>
                                <i class="fa fa-signal"></i> 完結済み </strong>
                        </a>
                        <a href="{{ route('mangas.search', ['sort' => 'top-monthly']) }}" rel="nofollow">
                            <i class="fa fa-eye"></i> トップ月別 </a>
                        <a href="{{ route('mangas.search', ['sort' => 'top-weekly']) }}" rel="nofollow">
                            <i class="fa fa-eye"></i> トップ週間 </a>
                        <a href="{{ route('mangas.search', ['sort' => 'newest']) }}">
                            <i class="fa fa-refresh"></i> 最新 </a>
                        <a href="{{ route('mangas.search', ['sort' => 'top-daily']) }}" rel="nofollow">
                            <i class="fa fa-eye"></i> トップ日別 </a>
                        <a href="{{ route('mangas.search', ['sort' => 'top-daily']) }}" rel="nofollow">
                            <i class="fa fa-list"></i> チャプター数 </a>
                    </div>
                </li>
                <li>
                    <a href="{{ route('mangas.search') }}" target="_self">検索</a>
                </li>
            </ul>
        </div>
    </div>
    <ul class="list-inline nav-account"></ul>
</nav>
<span id="back-to-top"><i class="fa fa-angle-up"></i></span>
<script src="{{ asset('frontend-web/js/jquery.min.js') }}"></script>
<script src="{{ asset('frontend-web/js/owl.carousel.min.js') }}"></script>
<script src="{{ asset('frontend-web/js/scripts.min.js') }}"></script>

</form>
