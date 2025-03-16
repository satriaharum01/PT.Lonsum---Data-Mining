<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Anime Template">
    <meta name="keywords" content="Anime, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{env('APP_NAME')}} | Template</title>

    @include('front.css')
</head>

<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>
    
    @include('front.header')

    
    @yield('login_page')
    <!-- Product Section Begin -->
    <section class="product spad">
        <div class="container">
            @yield('content')
        </div>
    </div>
    <div class="product__sidebar__comment">
        @yield('side_content')
    </div>
</div>
</div>
</div>
</div>
</section>
<!-- Product Section End -->

    @include('front.footer')
  <!-- Search model Begin -->
  <div class="search-model">
    <div class="h-100 d-flex align-items-center justify-content-center">
        <div class="search-close-switch"><i class="icon_close"></i></div>
        <form class="search-model-form">
            <input type="text" id="search-input" placeholder="Search here.....">
        </form>
    </div>
</div>
<!-- Search model end -->
@yield('js')

@include('front.js')

</body>

</html>