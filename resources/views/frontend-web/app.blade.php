<!DOCTYPE html>
<html lang="ja">

<head>
    @include('frontend-web.partials.seo')
</head>

<body class="homepage site1" id="ctl00_Body">
    @include('frontend-web.partials.header')
    <main class="main">
        @include('frontend-web.partials.notification')
        <div class="container">
            @yield('content')
        </div>
    </main>

    @include('frontend-web.partials.footer')
    @yield('script')
</body>

</html>
