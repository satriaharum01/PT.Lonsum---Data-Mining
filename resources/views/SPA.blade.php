<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'Halaman' }} - {{ env('APP_NAME') }}</title>
    @include('backend.css')

    {{-- React Entry --}}
    @viteReactRefresh
    @vite('resources/js/main.jsx')
  </head>
  <body>
    <div class="page">
      <div class="page-main">
        @include('backend.header')

        {{-- Non-React content --}}
        @yield('content')

        {{-- React content --}}
        <div id="root"></div>

        @include('backend.footer')
      </div>
    </div>
    @include('backend.js')
    @yield('js')
  </body>
</html>
