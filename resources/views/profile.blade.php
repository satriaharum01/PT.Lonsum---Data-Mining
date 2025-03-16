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
                        <div class="col-md-6 col-lg-3">
                            <div class="form-group text-center">
                                <label class="form-label">Foto</label>
                                <div id="preview" class="my-2">
                                    <a href="{{ asset('assets/img/faces/'.$load->faces) }}" data-lightbox="gallery">
                                      <img src="{{ asset('assets/img/faces/'.$load->faces) }}"  alt="Foto" style="width: 100px; height: auto; margin: 5px;">
                                    </a>
                                </div>
                                <input type="file" name="photos" id="photos" required onchange="previewImages()" accept="image/*">
                                <button type="button" onclick="resetForm()" class="btn btn-danger btn-reset" hidden><i class="fa fa-refresh"></i></button>
                          
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-9 row">
                        
                        @foreach ($fieldTypes as $field => $type)
                            @include('models.forms', ['field' => $field, 'type' => $type, 'value' => old($field, $load->$field ?? '')])
                        @endforeach
                  </div>
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
    function previewImages() {
            let preview = document.getElementById('preview'); // Tempat menampilkan preview
            let files = document.getElementById('photos').files; // File yang dipilih

            preview.innerHTML = ''; // Mengosongkan preview sebelumnya

            if (files) {
                Array.from(files).forEach(file => {
                    let reader = new FileReader(); // Membaca file sebagai URL data
                    reader.onload = function (e) {
                        let img = document.createElement('img'); // Membuat elemen gambar
                        img.src = e.target.result; // Menetapkan sumber gambar
                        img.style.width = '100px'; // Ukuran gambar
                        img.style.height = 'auto';
                        img.style.margin = '5px';
                        preview.appendChild(img); // Menambahkan gambar ke preview
                    }
                    reader.readAsDataURL(file); // Membaca file sebagai URL
                });
                $('.btn-reset').prop('hidden',false);
            }
        }

        // Fungsi untuk mereset formulir dan menghapus preview
        function resetForm() {
            let input = document.getElementById('photos'); // Input file
            let preview = document.getElementById('preview'); // Tempat preview

            input.value = ''; // Mengosongkan input file
            preview.innerHTML = '<a href="{{ asset('assets/img/faces/'.$load->faces) }}" data-lightbox="gallery">\
                                      <img src="{{ asset('assets/img/faces/'.$load->faces) }}"  alt="Foto" style="width: 100px; height: auto; margin: 5px;">\
                                    </a>'; // Mengosongkan preview
            
            $('.btn-reset').prop('hidden',true);
        }
</script>
@endsection