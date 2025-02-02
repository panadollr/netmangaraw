<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
<title>{{ $seoData['title'] }}</title>
<meta content="{{ $seoData['description'] }}" name="description" />
<meta content="{{ $seoData['keywords'] }}" name="keywords" />
<meta content="{{ $seoData['image'] }}" property="og:image" />
<meta content="{{ $seoData['title'] }}" property="og:title" />
<meta content="{{ config('custom.frontend_name') }}" property="og:site_name" />
<meta content="{{ url()->current() }}" property="og:url" />
<meta content="website" property="og:type" />
<meta content="{{ $seoData['description'] }}" property="og:description" />
<meta content="{{ $seoData['title'] }}" itemprop="name" />
<meta content="{{ $seoData['description'] }}" itemprop="description" />
<meta content="ja_JP" property="og:locale" />
<link href="{{ url()->current() }}" rel="canonical" />
<link href="{{ asset('frontend-web/images/favicon.ico') }}" rel="icon" type="image/png" />
<meta content="Copyright © {{ date('Y') }} {{ config('custom.frontend_name') }}" name="copyright" />
<meta content="{{ config('custom.frontend_name') }}" name="Author" />
<meta content="width=device-width, initial-scale=1.0" name="viewport" />
<meta content="IE=Edge" http-equiv="X-UA-Compatible" />
<meta content="on" http-equiv="x-dns-prefetch-control" />
<meta content="light only" name="color-scheme" />
<meta content="notranslate" name="google" />
<link href="{{ asset('frontend-web/css/styles.min.css') }}" rel="stylesheet" />
<link href="{{ asset('frontend-web/css/font-manga.min.css') }}" rel="stylesheet" />
<link href="{{ asset('frontend-web/images/favicon.ico') }}" rel="apple-touch-icon" sizes="180x180" />

{!! $seoData['site_script'] !!}
