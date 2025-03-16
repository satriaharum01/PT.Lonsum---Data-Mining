@extends('backend.app')
@section('content')
<div class="my-3 my-md-5">
    <div class="container">
        <div class="row">
        
            <div class="col-md-12 col-xl-12">
                <div class="card">
                  <div class="card-header">
                    <h3 class="card-title">{{$sub_title}}</h3>
                    <div class="card-options align-items-center">
                    
                    </div>
                  </div>
                  <div class="card-body " id="card-main">
                      <div class="table-responsive">
                        <table class="table table-hover" id="data-width" width="100%">
                            <thead>
                              <tr>
                                <th width="10%"></th>
                                <th class="text-primary">Petugas</th>
                                <th class="text-primary">Wilayah Kerja</th>
                                <th class="text-primary">Tanaman</th>
                                <th class="text-primary">OPT</th>
                                <th class="text-primary">Periode</th>
                                <th class="text-primary">Luas Terserang</th>
                                <th class="text-primary">status</th>
                                <th class="text-primary" width="20%">Action</th>
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
@include('models.verify')
@endsection
@section('js')
<script>
  let icon = 'check';
  $(function () {
      table = $("#data-width").DataTable({
        searching: true,
        ajax: '{{Request::url() }}/json',
        columns: [
          {
            data: "DT_RowIndex",
            name: "DT_RowIndex",
            className: "text-center",
          },
          {
            data: "nama_petugas",
            className: "text-left",
          },
          {
            data: "wilayah_kerja",
            className: "text-left",
          },
          {
            data: "tanaman",
            className: "text-left",
          },
          {
            data: "jenis_opt",
            className: "text-left",
          },
          {
            data: "periode",
            className: "text-left",
          },
          {
            data: "luas_terserang",
            className: "text-left", render: function(data){return data +' ha';}
          },
          {
            data: "status",
            className: "text-center",
            render: function(data){
              if(data == 'Menunggu'){ icon = 'check';}else{icon = 'edit';}
              return data;
            }
          },
          {
            data: "id",
            className: "text-center",
            render: function (data, type, row) {
              return '<button type="button" class="btn btn-primary btn-show" data-id="' + data +'"><i class="fa fa-eye"></i> </button>\
                  <button type="button" class="btn btn-success btn-'+icon+'" data-id="' + data +'"><i class="fa fa-'+icon+'"></i> </button>';
            },
          },
        ],
      });
  });
    
</script>
<script>
  
  $("body").on("click", ".btn-show", function () {
    var Id = $(this).attr("data-id");
    var url = "{{ route('kordinator.laporan.show', ':id') }}".replace(':id', Id);
    window.location.href = url;
  })

  $("body").on("click", ".btn-edit", function () {
    var Id = $(this).attr("data-id");
    
    find_data(Id);
    jQuery("#verifyForm").attr("action", "{{ url ($page) }}/verifikasi/"+Id);
    jQuery("#verifyModal").modal("toggle");
  })
  $("body").on("click", ".btn-check", function () {
    var Id = $(this).attr("data-id");
    
    jQuery("#verifyForm input[name=laporan_id]").val(Id);
    kosongkan();
    jQuery("#verifyForm").attr("action", "{{ url ($page) }}/verifikasi/"+Id);
    jQuery("#verifyModal").modal("toggle");
  })
  
  function kosongkan() {
    jQuery("#verifyForm textarea[name=catatan]").val("");
    jQuery("#verifyForm select[name=status]").val("menunggu");
  }

  function find_data(id){
      $.ajax({
          url: '{{ url("$page") }}/find/'+id,
          type: "GET",
          cache: false,
          dataType: 'json',
          success: function (dataResult) { 
              console.log(dataResult);
              set_value(dataResult);
              console.log('Edit Data :', dataResult);
          }
      });
  }
  
  function set_value(value) {
    jQuery("#verifyForm input[name=laporan_id]").val(value.laporan_id);
    jQuery("#verifyForm textarea[name=catatan]").val(value.catatan);
    jQuery("#verifyForm select[name=status]").val(value.status);
  }
</script>
@endsection