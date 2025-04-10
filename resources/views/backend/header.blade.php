
        <div class="header py-4">
          <div class="container">
            <div class="d-flex">
              <a class="align-items-center header-brand row" href="./index.html">
                <img src="{{asset('assets/img/logo.png')}}" class="header-brand-img" alt="tabler logo">
                <div class="ml-2 row flex-column ">
                  <h5 style="line-height: 10px;">{{ucwords( env('APP_DESCRIPTION'))}}</h5>
                  <h6 style="line-height: 0px;">{{ucwords( env('APP_NAME'))}}</h6>
                </div>
              </a>
              <div class="d-flex order-lg-2 ml-auto">
                <div class="dropdown">
                  <a href="#" class="nav-link pr-0 leading-none" data-toggle="dropdown">
                    <span class="avatar" style="background-image: url({{asset('/assets/img/faces/'.Auth::user()->faces)}})"></span>
                    <span class="ml-2 d-none d-lg-block">
                      <span class="text-default">{{Auth::user()->name}}</span>
                      <small class="text-muted d-block mt-1">{{ ucfirst (Auth::user()->level)}}</small>
                    </span>
                  </a>
                  <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                    <a class="dropdown-item" 
                    @if(Auth::user()->level == 'Administrator')
                      href="{{route('admin.profile')}}"
                    
                  @else

                  href="{{route('petugas.profile')}}"
                  @endif
                  >
                      <i class="dropdown-icon fe fe-user"></i> Profile
                    </a>
                    <!--
                    <a class="dropdown-item" href="#">
                      <i class="dropdown-icon fe fe-settings"></i> Log
                    </a>
-->
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                      <i class="dropdown-icon fe fe-log-out"></i> Sign out
                    </a>
                  </div>
                </div>
              </div>
              <a href="#" class="header-toggler d-lg-none ml-3 ml-lg-0" data-toggle="collapse" data-target="#headerMenuCollapse">
                <span class="header-toggler-icon"></span>
              </a>
            </div>
          </div>
        </div>
        <div class="bg-azure-darkest header collapse d-lg-flex p-0" id="headerMenuCollapse">
          <div class="container">
            <div class="row align-items-center">
              <div class="col-lg order-lg-first">
                <ul class="nav nav-tabs border-0 flex-column flex-lg-row">
                  @if(Auth::user()->level == 'Administrator')
                  <li class="nav-item">
                    <a href="{{route('admin.dashboard')}}" class="nav-link {{ (request()->is('admin/dashboard')) ? 'active' : '' }}"><i class="fe fe-home"></i> Home</a>
                  </li>
                  <li class="nav-item dropdown">
                    <a href="{{route('admin.pengguna')}}" class="nav-link {{ (request()->is('admin/pengguna')) ? 'active' : '' }} {{ (request()->is('admin/pengguna/*')) ? 'active' : '' }}"><i class="fe fe-users"></i> Pengguna</a>
                  </li>
                  <li class="nav-item dropdown">
                    <a href="{{route('admin.resources')}}" class="nav-link {{ (request()->is('admin/resources')) ? 'active' : '' }} {{ (request()->is('admin/resources/*')) ? 'active' : '' }}"><i class="fe fe-slack"></i> Sumber Daya</a>
                  </li>
                  <li class="nav-item dropdown">
                    <a href="{{route('admin.stoking')}}" class="nav-link {{ (request()->is('admin/stoking')) ? 'active' : '' }} {{ (request()->is('admin/stoking/*')) ? 'active' : '' }}"><i class="fa fa-truck mr-2"></i> Pengadaan</a>
                  </li>
                  <li class="nav-item dropdown">
                    <a href="javascript:void(0)" class="nav-link {{ (request()->is('admin/prediksi')) ? 'active' : '' }} {{ (request()->is('admin/prediksi/*')) ? 'active' : '' }}{{ (request()->is('admin/laporan')) ? 'active' : '' }} {{ (request()->is('admin/laporan/*')) ? 'active' : '' }}" data-toggle="dropdown" aria-expanded="false"><i class="fe fe-file-text"></i> Laporan</a>
                    <div class="dropdown-menu dropdown-menu-arrow" x-placement="bottom-start" style="position: absolute; transform: translate3d(12px, 55px, 0px); top: 0px; left: 0px; will-change: transform;">
                      <a href="{{route('admin.prediksi')}}" class="dropdown-item"><i class="fe fe-file-text"></i> Prediksi</a>
                      <a href="{{route('admin.laporan')}}" class="dropdown-item"><i class="fe fe-file-text"></i> Laporan</a>
                    </div>
                  </li>
                  @else
                  <li class="nav-item">
                    <a href="{{route('petugas.dashboard')}}" class="nav-link {{ (request()->is('petugas/dashboard')) ? 'active' : '' }}"><i class="fe fe-home"></i> Home</a>
                  </li>
                  <li class="nav-item dropdown">
                    <a href="{{route('petugas.laporan')}}" class="nav-link {{ (request()->is('petugas/laporan')) ? 'active' : '' }} {{ (request()->is('petugas/laporan/*')) ? 'active' : '' }}"><i class="fe fe-file-text"></i> Laporan</a>
                  </li>
                  @endif
                </ul>
              </div>
            </div>
          </div>
        </div>