@extends('backend.app')

@section('content')
<div class="my-3 my-md-5">
          <div class="container">
            <div class="page-header">
              <h1 class="page-title">
                Dashboard
              </h1>
            </div>
            <div class="row row-cards">
              <div class="col-6 col-sm-4 col-lg-2">
                <div class="card">
                  <div class="card-body p-3 text-center">
                    <div class="text-right text-green">
                      <i class="fe fe-chevron-up"></i>
                    </div>
                    <div class="h1 m-0">{{$laporan}}</div>
                    <div class="text-muted mb-4">Laporan</div>
                  </div>
                </div>
              </div>
              <div class="col-6 col-sm-4 col-lg-2">
                <div class="card">
                  <div class="card-body p-3 text-center">
                    <div class="text-right text-red">
                      <i class="fe fe-chevron-down"></i>
                    </div>
                    <div class="h1 m-0">{{$laporan_verifikasi}}</div>
                    <div class="text-muted mb-4">Laporan Terverifikasi</div>
                  </div>
                </div>
              </div>
              <div class="col-6 col-sm-4 col-lg-2">
                <div class="card">
                  <div class="card-body p-3 text-center">
                    <div class="text-right text-green">
                      <i class="fe fe-chevron-up"></i>
                    </div>
                    <div class="h1 m-0">{{$laporan_menunggu}}</div>
                    <div class="text-muted mb-4">Laporan menunggu</div>
                  </div>
                </div>
              </div>
              <div class="col-6 col-sm-4 col-lg-2">
                <div class="card">
                  <div class="card-body p-3 text-center">
                    <div class="text-right text-red">
                      <i class="fe fe-chevron-down"></i>
                    </div>
                    <div class="h1 m-0">{{$wilayahKerja}}</div>
                    <div class="text-muted mb-4">Wilayah Kerja</div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
@endsection