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
                      <button class="btn btn-primary btn-add"><i class="fa fa-plus"></i> New Anime</button>
                      <a href="#" class="card-options-collapse btn btn-outline-primary" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="row">  
                      @foreach($animes as $anime)
                      <div class="col-6 col-md-4 col-lg-2 custom-col">
                        <div class="form-group ">
                          <div class="image-container my-2">
                            <img src="{{asset('assets/img/anime/').'/'.$anime->cover}}" alt="Anime Cover">
                            <div class="overlay-full">
                              <div class="btn btn-primary rounded-circle btn-eye" data-id="{{$anime->id}}"><i class="fa fa-eye"></i></div>
                            </div>
                            <div class="overlay">
                              <div class="title">{{$anime->title}}</div>
                            </div>
                          </div>
                          <div class="text-center">
                            <button class="btn btn-success btn-edit"><i class="fa fa-edit"></i> Edit</button>
                            <button class="btn btn-danger btn-hapus"><i class="fa fa-trash"></i> Hapus</button>
                            <div class="p-2"><i class="fa fa-eye"></i> Views : 1</div>
                          </div>
                        </div>
                      </div>
                      @endforeach
                    </div>
                  </div>
                  <div class="card-footer d-flex justify-content-between">
                      <div>
                        {{env('APP_NAME')}} - {{$title}}
                      </div>
                      <div class="d-flex justify-content-center">
                          {{ $animes->links('pagination::bootstrap-4') }}
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
  
  $("body").on("click", ".btn-add", function () {
    window.location.href = "{{route('admin.anime.new')}}";
  })

  $("body").on("click", ".btn-eye", function () {
    var id = jQuery(this).attr("data-id");
    window.location.href = "{{url('admin/anime/show')}}/"+id;
  })
</script>
@endsection