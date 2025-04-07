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
                      <button class="btn btn-primary btn-add"><i class="fa fa-plus"></i> Tambah Data</button>
                    </div>
                  </div>
                  <div class="card-body " id="card-main">
                      <div class="table-responsive">
                        <table class="table table-hover" id="data-width" width="100%">
                            <thead>
                              <tr>
                                <th width="10%"></th>
                                <th class="text-primary" width="40%">Nama Barang</th>
                                <th class="text-primary">Satuan</th>
                                <th class="text-primary">Action</th>
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
            data: "nama_barang",
            className: "text-center",
          },
          {
            data: "satuan",
            className: "text-center",
          },
          {
            data: "id",
            className: "text-center",
            orderable: false,
            searchable: false,
            render: function (data, type, row) {
              return (
                  '<button type="button" class="btn btn-success btn-edit" data-id="' + data +'"><i class="fa fa-edit"></i> </button>\
                  <a class="btn btn-danger btn-hapus" data-id="' + data +'" data-handler="data" href="delete/'+data +'">\
                  <i class="fa fa-trash"></i> </a> \
				  	      <form id="delete-form-' +data +'-data" action="{{ Request::url()  }}/delete/'+data+'" method="GET" style="display: none;">\
                  </form>'
              );
            },
          },
        ],
      });
    });
  $("body").on("click", ".btn-add", function () {
    window.location.href = "{{route($route_new.'.new')}}";
  })

  $("body").on("click", ".btn-edit", function () {
    var Id = $(this).attr("data-id");
    var url = "{{ route($route_new.'.edit', ':id') }}".replace(':id', Id);
    window.location.href = url;
  })
</script>
@endsection