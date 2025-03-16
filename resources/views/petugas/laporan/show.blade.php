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
                  <form class="" method="POST" enctype="multipart/form-data" action="{{url($action)}}">
                    @csrf
                    <div class="card-body row">
                          @php
                              $seranganLabelShown = false;
                              $keadaanLabelShown = false;
                              $informasiLabelShown = false;
                              $pengendalianLabelShown = false;
                              
                              use App\Http\helpers\Formula;

                          @endphp

                          @foreach ($fieldTypes as $field => $type)
                              
                          @php
                               $isSerangan = in_array($field, Formula::$serangan_array); 
                               $isKeadaan = in_array($field, Formula::$keadaan_array);
                               $isPengendalian = in_array($field, Formula::$pengendalian_array);
                          @endphp

                           <!-- Tampilkan label utama hanya sekali -->
                           @if(!$informasiLabelShown)
                               @php $informasiLabelShown = true; @endphp
                               <div class="col-md-12"><label class="section-label">Informasi Laporan</label></div>
                           @endif

                           @if($isSerangan && !$seranganLabelShown)
                               @php $seranganLabelShown = true; @endphp
                               <div class="col-md-12"><label class="section-label">Luas Tambah Serangan</label></div>
                           @endif

                           @if($isKeadaan && !$keadaanLabelShown)
                               @php $keadaanLabelShown = true; @endphp
                               <div class="col-md-12"><label class="section-label">Luas Keadaan Serangan</label></div>
                           @endif

                           @if($isPengendalian && !$pengendalianLabelShown)
                               @php $pengendalianLabelShown = true; @endphp
                               <div class="col-md-12"><label class="section-label">Luas Pengendalian</label></div>
                           @endif
                           @include('models.formsLaporan', ['field' => $field, 'type' => $type, 'value' => old($field, $load->$field ?? '')])
                          @endforeach
                          
                        <div class="form-group">  
                          <label class="form-label">Bukti Foto</label>
                          <div id="preview" style="display: flex; gap: 10px; flex-wrap: wrap;">
                          @if(count($photos) > 1)
                            @foreach($photos as $photo)
                                <div class="photo">
                                    <a href="{{ asset('assets/images/laporan/'.$photo->id.'.jpg') }}" data-lightbox="gallery">
                                      <img src="{{ asset('assets/images/laporan/'.$photo->id.'.jpg') }}"  alt="Foto" style="width: 100px; height: auto; margin: 5px;">
                                    </a>
                                </div>
                            @endforeach
                          @else
                          <h4>Tidak Ada Data !</h4>
                          @endif
                          </div>
                        </div>
                    </div>
                    <div class="card-footer">
                      <button type="reset" class="btn btn-danger btn-back" data-bs-dismiss="modal">Kembali</button>
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
  var wilayah_kerja_id = {{$load->wilayah_kerja_id ?? 0}};
  var tanaman_id = {{$load->tanaman_id ?? 0}};
  var opt_id = {{$load->opt_id ?? 0}};
  $("body").on("click", ".btn-back", function () {
    window.location.href = "{{route('petugas.laporan')}}";
  })

</script>

<script>
  
$(function () {
  
    //Petugas
    $.ajax({
        url: "{{ url('/find/petugas/'.Auth::user()->id)}}",
        type: "GET",
        cache: false,
        dataType: 'json',
        success: function(dataResult) {
            console.log(dataResult);
            var resultData = dataResult.data;
            $.each(resultData, function(index, row) {
              $('#petugas_id').append('<option value="' + row.id + '" selected>' + row.name + '</option>');
            })
        }
    });
    
    //Tanaman
    $.ajax({
        url: "{{ url('/get/tanaman/')}}",
        type: "GET",
        cache: false,
        dataType: 'json',
        success: function(dataResult) {
            console.log(dataResult);
            var resultData = dataResult.data;
            $.each(resultData, function(index, row) {
              if(tanaman_id === row.id)
              {
                $('#tanaman_id').append('<option value="' + row.id + '" selected>' + row.nama_tanaman + '</option>');
              }else{
                $('#tanaman_id').append('<option value="' + row.id + '">' + row.nama_tanaman + '</option>');
              }
            })
        }
    });

    //OPT
    $.ajax({
        url: "{{ url('/get/opt/')}}",
        type: "GET",
        cache: false,
        dataType: 'json',
        success: function(dataResult) {
            console.log(dataResult);
            var resultData = dataResult.data;
            $.each(resultData, function(index, row) {
              if(opt_id === row.id)
              {
                $('#opt_id').append('<option value="' + row.id + '" selected>' + row.nama_opt + '</option>');
              }else{
                $('#opt_id').append('<option value="' + row.id + '">' + row.nama_opt + '</option>');
              }
            })
        }
    });

    //Wilayah Kerja
    $.ajax({
        url: "{{ url('/get/wilayah_kerja/'.Auth::user()->kabupaten_id)}}",
        type: "GET",
        cache: false,
        dataType: 'json',
        success: function(dataResult) {
            console.log(dataResult);
            var resultData = dataResult.data;
            $.each(resultData, function(index, row) {
              if(wilayah_kerja_id === row.id)
              {
                $('#wilayah_kerja_id').append('<option value="' + row.id + '" selected>' + row.nama_daerah + '</option>');
              }else{
                $('#wilayah_kerja_id').append('<option value="' + row.id + '">' + row.nama_daerah + '</option>');
              }
            })
        }
    });
    
  })
</script>
@endsection