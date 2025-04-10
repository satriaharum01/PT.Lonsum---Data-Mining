@extends('backend.app')

<?php $totalFields = count($fieldTypes); ?>
@section('content')
<div class="my-3 my-md-5">
    <div class="container">
        <div class="row">
        
            <div class="col-md-12 col-xl-12">
                <div class="card">
                  <div class="card-header">
                    <h3 class="card-title">{{$sub_title}}</h3>
                  </div>
                  <form class="" method="POST" enctype="multipart/form-data" action="{{url($action)}}">
                    @csrf
                    <div class="card-body row">

                      @foreach ($fieldTypes as $field => $type)
                          @include('models.forms', [
                              'field' => $field,
                              'type' => $type,
                              'value' => old($field, $load->$field ?? ''),
                              'totalFields' => $totalFields
                          ])
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
  
  $("body").on("click", ".btn-back", function () {
    window.location.href = "{{route($route_new)}}";
  })

</script>
<script>
  $(function () {
    //Sumber Daya
    $.ajax({
       url: "{{ url('/get/barang/')}}",
       type: "GET",
       cache: false,
       dataType: 'json',
       success: function(dataResult) {
           console.log(dataResult);
           var resultData = dataResult.data;
           $.each(resultData, function(index, row) {
             $('#id_barang').append('<option value="' + row.id + '">' + row.nama_barang + '</option>');
           })
       }
      });
    })
</script>
@endsection