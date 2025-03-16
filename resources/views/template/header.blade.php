<!DOCTYPE HTML>
<html lang="en" dir="ltr">
<head >
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <title>{{env('APP_NAME')}} - {{$title}}</title>

  <!-- GOOGLE FONTS -->
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500|Poppins:400,500,600,700|Roboto:400,500" rel="stylesheet"/>
  <link href="{{ asset('assets/css/materialdesignicons.min.css') }}" rel="stylesheet" />

  <!-- PLUGINS CSS STYLE -->
  <link href="{{ asset('assets/plugins/toaster/toastr.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/nprogress/nprogress.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/flag-icons/css/flag-icon.min.css') }}" rel="stylesheet"/>
  <link href="{{ asset('assets/plugins/jvectormap/jquery-jvectormap-2.0.3.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/ladda/ladda.min.css') }}" rel="stylesheet" />
  
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('bower_components/font-awesome/css/font-awesome.min.css') }}">
  <link rel="stylesheet" href="{{ asset('bower_components/font-awesome-free-6/css/all.css') }}">

  <link href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/daterangepicker/daterangepicker.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/data-tables/datatables.bootstrap4.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/css/progress-bar.css') }}" rel="stylesheet" />
  <x-head.tinymce-config/>
  <!-- SLEEK CSS -->
  <link id="sleek-css" rel="stylesheet" href="{{ asset('assets/css/sleek.css') }}" />

  <!-- SweetAlert 2 -->
  <script src="{{ asset('assets/dist/sweetalert2/sweetalert2.all.min.js') }}"></script>
    <link rel="{{ asset('assets/dist/sweetalert2/sweetalert2.min.css') }}">

  <!-- FAVICON -->
  <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/img/favicon.png') }}">

  <!--
    HTML5 shim and Respond.js') }} for IE8 support of HTML5 elements and media queries
  -->
  <!-- WARNING: Respond.js') }} doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js') }}"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js') }}"></script>
  <![endif]-->
  <script src="{{ asset('assets/plugins/nprogress/nprogress.js') }}"></script>
  <style>
    .form-group label{
      align-content: center;
    }
  </style>
  @yield('css')
</head>
<body class="sidebar-fixed sidebar-dark header-light header-fixed" id="body">
    <script>
      NProgress.configure({ showSpinner: false });
      NProgress.start();
    </script>
    @if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <div class="mobile-sticky-body-overlay"></div>

    <div class="wrapper">
      
              <!--
          ====================================
          ——— LEFT SIDEBAR WITH FOOTER
          =====================================
        -->

        @if(Auth::user()->level == 'Admin')        
        <aside class="left-sidebar bg-sidebar" >
          <div id="sidebar" class="sidebar">
            <!-- Aplication Brand -->
            <div class="app-brand">
              <a href="#">
                
                <img class="brand-icon" src="{{ asset('assets/img/logo.png')}}" width="40" height="40">
                  <g fill="none" fill-rule="evenodd">
                    <path
                      class="logo-fill-blue"
                      fill="#7DBCFF"
                      d="M0 4v25l8 4V0zM22 4v25l8 4V0z"
                    />
                    <path class="logo-fill-white" fill="#FFF" d="M11 4v25l8 4V0z" />
                  </g>
                </img>
                <span class="brand-name text-center" style="line-height:25px;">KECAMATAN <br>MEDAN TEMBUNG</span>
              </a>
            </div>
            <!-- begin sidebar scrollbar -->
            <div class="sidebar-scrollbar">

              <!-- sidebar menu -->
              <ul class="nav sidebar-inner" id="sidebar-menu">    
                  <li  class="has-sub {{ (request()->is('admin/dashboard')) ? 'active' : '' }}" >
                    <a class="sidenav-item-link" href="{{route('admin.dashboard')}}" 
                      aria-expanded="false" aria-controls="dashboard">
                      <i class="mdi mdi-desktop-mac"></i>
                      <span class="nav-text">Dashboard</span> 
                    </a>
                  </li>
                  <li  class="has-sub {{ (request()->is('admin/departemen')) ? 'active' : '' }} {{ (request()->is('admin/departemen/*')) ? 'active' : '' }}" >
                    <a class="sidenav-item-link" href="{{route('admin.departemen')}}"
                      aria-expanded="false" aria-controls="ui-elements">
                      <i class="mdi mdi-city"></i>
                      <span class="nav-text">Departemen</span> 
                    </a>
                  </li>
                  <li  class="has-sub {{ (request()->is('admin/artikel')) ? 'active' : '' }} {{ (request()->is('admin/artikel/*')) ? 'active' : '' }}" >
                    <a class="sidenav-item-link" href="{{route('admin.artikel')}}"
                      aria-expanded="false" aria-controls="ui-elements">
                      <i class="mdi mdi-database-search"></i>
                      <span class="nav-text">Artikel</span> 
                    </a>
                  </li>
                  
                  <li  class="has-sub {{ (request()->is('admin/komentar')) ? 'active' : '' }} {{ (request()->is('admin/komentar/*')) ? 'active' : '' }}" >
                    <a class="sidenav-item-link" href="{{route('admin.komentar')}}"
                      aria-expanded="false" aria-controls="ui-elements">
                      <i class="mdi mdi-comment"></i>
                      <span class="nav-text">Komentar</span> 
                    </a>
                  </li>
                  <li  class="d-none has-sub {{ (request()->is('admin/lampiran')) ? 'active' : '' }} {{ (request()->is('admin/lampiran/*')) ? 'active' : '' }}" >
                    <a class="sidenav-item-link" href="{{route('admin.lampiran')}}"
                      aria-expanded="false" aria-controls="ui-elements">
                      <i class="mdi mdi-file"></i>
                      <span class="nav-text">Lampiran</span> 
                    </a>
                  </li>
                  <li  class="has-sub {{ (request()->is('admin/diskusi')) ? 'active' : '' }} {{ (request()->is('admin/diskusi/*')) ? 'active' : '' }}" >
                    <a class="sidenav-item-link" href="{{route('admin.diskusi')}}"
                      aria-expanded="false" aria-controls="ui-elements">
                      <i class="mdi mdi-comment-text-multiple"></i>
                      <span class="nav-text">Diskusi</span> 
                    </a>
                  </li>
                  <li  class="has-sub {{ (request()->is('admin/user')) ? 'active' : '' }} {{ (request()->is('admin/user/*')) ? 'active' : '' }}" >
                    <a class="sidenav-item-link" href="{{route('admin.user')}}"
                      aria-expanded="false" aria-controls="ui-elements">
                      <i class="mdi mdi-account-multiple"></i>
                      <span class="nav-text">Pengguna</span> 
                    </a>
                  </li>
              </ul>

            </div>

            <hr class="separator" />
          </div>
        </aside>

        @endif
      
        <div class="page-wrapper" @if(Auth::user()->level != 'Admin') style="padding-left:0px;" @endif>
                  <!-- Header -->
          <header class="main-header" @if(Auth::user()->level != 'Admin') style="padding-left:0px;" @endif id="header">
            <nav class="navbar navbar-static-top navbar-expand-lg">
              <!-- Sidebar toggle button -->
              @if(Auth::user()->level == 'Admin')
              <button id="sidebar-toggler" class="sidebar-toggle">
                <span class="sr-only">Toggle navigation</span>
              </button>
              @endif
              <!-- search form ->
              <div class="search-form d-none d-lg-inline-block">
                <div class="input-group">
                  <button type="button" name="search" id="search-btn" class="btn btn-flat">
                    <i class="mdi mdi-magnify"></i>
                  </button>
                  <input type="text" name="query" id="search-input" class="form-control" placeholder="'button', 'chart' etc."
                    autofocus autocomplete="off" />
                </div>
                <div id="search-results-container">
                  <ul id="search-results"></ul>
                </div>
              </div>
              <-- search form -->
              @if(Auth::user()->level != 'Admin')
              <div class="navbar-left ml-5">
                <ul class="nav navbar-nav">
                  <li  class="has-sub {{ (request()->is('pegawai/dashboard')) ? 'active' : '' }}" >
                    <a class="sidenav-item-link" href="{{route('pegawai.dashboard')}}" 
                      aria-expanded="false" aria-controls="dashboard">
                      <i class="mdi mdi-desktop-mac"></i>
                      <span class="nav-text">Dashboard</span> 
                    </a>
                  </li>
                  <li  class="has-sub {{ (request()->is('pegawai/artikel')) ? 'active' : '' }} {{ (request()->is('pegawai/artikel/*')) ? 'active' : '' }}" >
                    <a class="sidenav-item-link" href="{{route('pegawai.artikel')}}"
                      aria-expanded="false" aria-controls="ui-elements">
                      <i class="mdi mdi-database-search"></i>
                      <span class="nav-text">Artikel</span> 
                    </a>
                  </li>
                  <li  class="has-sub {{ (request()->is('pegawai/diskusi')) ? 'active' : '' }} {{ (request()->is('pegawai/diskusi/*')) ? 'active' : '' }}" >
                    <a class="sidenav-item-link" href="{{route('pegawai.diskusi')}}"
                      aria-expanded="false" aria-controls="ui-elements">
                      <i class="mdi mdi-comment-text-multiple"></i>
                      <span class="nav-text">Diskusi</span> 
                    </a>
                  </li>
                  <li  class="has-sub {{ (request()->is('pegawai/logs')) ? 'active' : '' }} {{ (request()->is('pegawai/logs/*')) ? 'active' : '' }}" >
                    <a class="sidenav-item-link" href="{{url('pegawai/logs')}}"
                      aria-expanded="false" aria-controls="ui-elements">
                      <i class="mdi mdi-clock"></i>
                      <span class="nav-text">Aktivitas</span> 
                    </a>
                  </li>
                </ul>
              </div>
              @endif
              <div class="navbar-right" style="position:absolute; right:0;">
                <ul class="nav navbar-nav">
                  <!-- User Account -->
                  <li class="dropdown user-menu">
                    <button href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                      <img src="{{ asset('assets/img/user/user.jpg')}}" class="user-image" alt="User Image" />
                      <span class="d-none d-lg-inline-block"><?=ucwords(Auth::user()->name)?></span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-right">
                      <!-- User image -->
                      <li class="dropdown-header">
                        <img src="{{ asset('assets/img/user/user.jpg')}}" class="img-circle" alt="User Image" />
                        <div class="d-inline-block">
                        <?=ucwords(Auth::user()->level)?> <small class="pt-1"></small>
                        </div>
                      </li>
                      <li class="dropdown-footer">
                        <a href="{{route('logout')}}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                    @csrf
                                </form>
                        <i class="mdi mdi-logout"></i> Log Out </a>
                      </li>
                    </ul>
                  </li>
                </ul>
              </div>
            </nav>


          </header>
          
          <div class="content-wrapper">
              <div class="content">						 
                <p>
                  <div class="alert alert-primary" role="alert" style="width:100%;">
                  <marquee behavior="" direction="left">  
                      <span>Selamat Datang di {{env('APP_DETAIL')}}</span>
                  </marquee>
                  </div>
                </p>
                <!-- Top Statistics -->
                @yield('content')
            
          </div>
          <footer class="footer mt-auto">
              <div class="copyright bg-white">
                <p>
                  &copy; <span id="copy-year"><?=date('Y')?></span> Copyright {{env('APP_NAME')}}
                  <a
                    class="text-primary"
                    href="http://www.instagram.com/satriaharumi"
                    target="_blank"
                    ></a
                  >.
                </p>
              </div>
              <script>
                  var d = new Date();
                  var year = d.getFullYear();
                  document.getElementById("copy-year").innerHTML = year;
              </script>
          </footer>
        </div>
</div>
@yield('modal')
<script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/plugins/toaster/toastr.min.js') }}"></script>
<script src="{{ asset('assets/plugins/slimscrollbar/jquery.slimscroll.min.js') }}"></script>
<script src="{{ asset('assets/plugins/charts/Chart.min.js') }}"></script>
<script src="{{ asset('assets/plugins/ladda/spin.min.js') }}"></script>
<script src="{{ asset('assets/plugins/ladda/ladda.min.js') }}"></script>
<script src="{{ asset('assets/plugins/jquery-mask-input/jquery.mask.min.js') }}"></script>
<script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>
<script src="{{ asset('assets/plugins/daterangepicker/moment.min.js') }}"></script>
<script src="{{ asset('assets/plugins/daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ asset('assets/plugins/jekyll-search.min.js') }}"></script>
<script src="{{ asset('assets/js/sleek.js') }}"></script>
<script src="{{ asset('assets/js/chart.js') }}"></script>
<script src="{{ asset('assets/js/date-range.js') }}"></script>
<script src="{{ asset('assets/js/custom.js') }}"></script>
<script src="{{ asset('assets/plugins/data-tables/jquery.datatables.min.js') }}"></script>
<script src="{{ asset('assets/plugins/data-tables/datatables.bootstrap4.min.js') }}"></script>
@yield('js')
@yield('custom_script')
<script>

    $(function (){
      $(".alert-function").fadeOut(5000);
      /*
      $("#basic-data-table").DataTable()
      $.ajax({
        url: "http://localhost:3000/status",
        type: "GET",
        success: function (data) {
          $("#status-bot").html('<i class="fa-solid fa-circle-dot text-success"></i> Bot Online');
        },error: function(data){
          $("#status-bot").html('<i class="fa-solid fa-circle-dot text-secondary"></i> Bot Offline');
        }
      });
      */
    });
    
    $("body").on("click",".btn-hapus",function(){
    var x = jQuery(this).attr("data-id");
    var y = jQuery(this).attr("data-handler");
    var xy = x+'-'+y;
    event.preventDefault()
        Swal.fire({
            title: 'Hapus Data ?',
            text: "Data yang dihapus tidak dapat dikembalikan !",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes',
            cancelButtonText: 'Tidak'
            }).then((result) => {
            if (result.value) {
                Swal.fire(
                'Data Dihapus!',
                '',
                'success'
                );
                document.getElementById('delete-form-'+xy).submit();
            }              
            });
                            
    })
</script>
</body>
</html>