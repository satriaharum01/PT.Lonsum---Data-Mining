@extends('backend.app')

@section('content')
<div class="my-3 my-md-5">
    <div class="container">
        <div class="row">
        
            <div class="col-md-12 col-xl-12">
                <div class="card">
                  <div class="card-header">
                    <h3 class="card-title">{{$sub_title}}</h3>
                  </div>
                  <form id="compose-form" class="" method="POST" enctype="multipart/form-data" action="{{url($action)}}">
                    @csrf
                    <div class="card-body row">
                          @foreach ($fieldTypes as $field => $type)
                              @include('models.forms', ['field' => $field, 'type' => $type, 'value' => old($field, $load->$field ?? '')])
                          @endforeach
                    </div>
                    <div class="card-footer">
                      <button type="reset" class="btn btn-danger btn-back" data-bs-dismiss="modal">Kembali</button>
                      <button type="submit" class="btn btn-primary btn-simpan">Simpan</button>
                      <div class="float-right">{{env('APP_NAME')}} - {{$title}}</div>
                    </div>
                  </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<script>
  
  var kecamatan_id = {{$load->kecamatan_id ?? 0}};
  $("body").on("click", ".btn-back", function () {
    window.location.href = "{{route('kordinator.wilayah_kerja')}}";
  })

</script>

<script>
  
$(function () {
    //Kecamatan
    $.ajax({
            url: "{{ url('/get/kecamatan/')}}",
            type: "GET",
            cache: false,
            dataType: 'json',
            success: function(dataResult) {
                console.log(dataResult);
                var resultData = dataResult.data;
                $.each(resultData, function(index, row) {
                  $('#kecamatan_id').append('<option value="' + row.id + '">' + row.nama_kecamatan + '</option>');
                })
            },complete: function (xhr, status) 
            {
              jQuery("#compose-form select[name=kecamatan_id]").val(kecamatan_id);
            }
        });

  
  })
</script>
@endsection