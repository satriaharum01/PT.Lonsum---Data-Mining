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
                    <div class="text-muted mb-4">Laporan Menunggu</div>
                  </div>
                </div>
              </div>
              <div class="col-6 col-sm-4 col-lg-2">
                <div class="card">
                  <div class="card-body p-3 text-center">
                    <div class="text-right text-green">
                      <i class="fe fe-chevron-up"></i>
                    </div>
                    <div class="h1 m-0">{{$petugas}}</div>
                    <div class="text-muted mb-4">Petugas</div>
                  </div>
                </div>
              </div>
              <div class="col-6 col-sm-4 col-lg-2">
                <div class="card">
                  <div class="card-body p-3 text-center">
                    <div class="text-right text-red">
                      <i class="fe fe-chevron-down"></i>
                    </div>
                    <div class="h1 m-0">{{$kecamatan}}</div>
                    <div class="text-muted mb-4">Kecamatan</div>
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
            <div class="row">
              <div class="col-md-12 col-xl-12">
                  <div class="card">
                    <div class="card-header">
                      <h3 class="card-title">Rekaptulasi Laporan</h3>
                      <div class="card-options align-items-center">

                      </div>
                    </div>
                    <div class="card-body " id="card-main">
                        <div class="table-responsive">
                          <table class="table table-hover" id="data-width" width="100%">
                              <thead>
                                <tr>
                                  <th class="text-primary text-center align-content-around" rowspan="2">Kabupaten</th>
                                  <th class="text-primary text-center align-content-around" rowspan="2">Komoditas</th>
                                  <th class="text-primary text-center align-content-around" rowspan="2">Periode</th>
                                  <th class="text-primary text-center align-content-around" rowspan="2">OPT</th>
                                  <th class="text-primary text-center" colspan="5">Luas Terserang</th>
                                </tr>
                                <tr>
                                  <th class="text-primary">R</th>
                                  <th class="text-primary">S</th>
                                  <th class="text-primary">B</th>
                                  <th class="text-primary">P</th>
                                  <th class="text-primary">J</th>
                                </tr>
                              </thead>
                              <tbody>

                              </tbody>
                          </table>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between">
                        <div>
                          {{env('APP_NAME')}} - {{$title}}
                        </div>
                    </div>
                  </div>
              </div>
            </div>
          </div>
        </div>
@endsection
@section('js')
<script>
  let icon = 'check';
  $(function () {
      table = $("#data-width").DataTable({
        searching: false,
        paging: false,
        lengthChange: false,
        info: false,
        ordering: false,
        ajax: '{{Request::url() }}/json',
        columns: [
          {
            data: "nama_kabupaten",
            className: "text-center",
          },
          {
            data: "tanaman",
            className: "text-center",
          },
          {
            data: "periode",
            className: "text-center",
          },
          {
            data: "jenis_opt",
            className: "text-center",
          },
          {
            data: "r_serang",
            className: "text-center", render: function(data){return data +' ha';}
          },
          {
            data: "s_serang",
            className: "text-center", render: function(data){return data +' ha';}
          },
          {
            data: "b_serang",
            className: "text-center", render: function(data){return data +' ha';}
          },
          {
            data: "p_serang",
            className: "text-center", render: function(data){return data +' ha';}
          },
          {
            data: "j_serang",
            className: "text-center", render: function(data){return data +' ha';}
          },
        ],
      });
  });
</script>
@endsection