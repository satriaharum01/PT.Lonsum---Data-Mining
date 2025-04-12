<!doctype html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Language" content="en" />
    <meta name="msapplication-TileColor" content="#2d89ef">
    <meta name="theme-color" content="#4188c9">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent"/>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="HandheldFriendly" content="True">
    <meta name="MobileOptimized" content="320">
    <link rel="icon" href="{{asset('assets/img/logo.png')}}" type="image/x-icon"/>
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('assets/img/logo.png')}}" />
    <!-- Generated: 2018-04-06 16:27:42 +0200 -->
    <title>{{$title}} - {{env('APP_NAME')}}</title>
    @include('backend.css')
  </head>
  <body class="">
    <div class="page">
      <div class="page-main">
        @include('backend.header')
        @yield('content')
      </div>
      @include('backend.footer')
      @include('backend.logoutModal')
      @include('backend.js')
      @yield('js')
    </div>
  </body>
</html>