<!doctype html>
<!--
* Tabler - Premium and Open Source dashboard template with responsive and high quality UI.
* @version 1.0.0-beta10
* @link https://tabler.io
* Copyright 2018-2022 The Tabler Authors
* Copyright 2018-2022 codecalm.net Paweł Kuna
* Licensed under MIT (https://github.com/tabler/tabler/blob/master/LICENSE)
-->
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>{{ env('APP_NAME') }} - Login</title>
    <!-- CSS files -->
    
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/img/favicon.png') }}">
    <link href="<?= asset('assets/login/dist/css/tabler.min.css') ?>" rel="stylesheet" />
    <link href="<?= asset('assets/login/dist/css/tabler-flags.min.css') ?>" rel="stylesheet" />
    <link href="<?= asset('assets/login/dist/css/tabler-payments.min.css') ?>" rel="stylesheet" />
    <link href="<?= asset('assets/login/dist/css/tabler-vendors.min.css') ?>" rel="stylesheet" />
    <link href="<?= asset('assets/login/dist/css/demo.min.css') ?>" rel="stylesheet" />
    <style>
        .bg-custom{
            background-image: url("{{asset('assets/login/img/bg-login.jpg')}}");
            background-size: cover;
        }
        .overlay-bg{
        position: absolute; 
        bottom: 0; 
        background: rgb(0, 0, 0);
        background: rgba(0, 0, 0, 0.3); /* Black see-through */
        color: #f1f1f1; 
        width: 100%;
        height: 100%;
        transition: .5s ease;
        opacity:1;
        color: white;
        font-size: 20px;
        padding: 20px;
        text-align: center;
    } 
    </style>
</head>

<body class="border-top-wide border-primary d-flex flex-column bg-custom">
    <div class="page page-center">
        <div class="container-tight py-4">
            @yield('content')
        </div>
    </div>
    <!-- Libs JS -->
    <!-- Tabler Core -->
    <script src="<?= asset('assets/login/dist/js/tabler.min.js') ?>" defer></script>
    <script src="<?= asset('assets/login/dist/js/demo.min.js') ?>" defer></script>
    <div class="overlay-bg"></div>
</body>

</html>