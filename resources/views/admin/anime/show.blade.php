@extends('backend.app')

@section('content')
<div class="my-3 my-md-5">
    <div class="container">
        <div class="row">
        
            <div class="col-md-9 col-xl-9">
                <div class="card">
                  <div class="card-header">
                    <h3 class="card-title">{{$sub_title}}</h3>
                  </div>
                  <div class="card-body">
                    <div class="col-lg-12">
                        <iframe width="100%" height="480" src="{{$anime->trailer}}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                        <div class="border-bottom pt-2">
                            <h4>Sinopsis</h4>
                        </div>
                        <p class="text-justify border-bottom pt-2">
                          <strong>{{$anime->title}} :</strong> {{$anime->description}}
                        </p>
                        <div class="border-bottom pt-2">
                            <h4>Episode List</h4>
                        </div>
                        <div class="table-responsive">
                        <table class="table table-hover" id="data-width" width="100%">
                            <thead>
                              <tr>
                                <th width="10%"></th>
                                <th class="text-primary" width="60%">Episode</th>
                                <th class="text-primary">Replies</th>
                                <th class="text-primary">Updated</th>
                              </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                        </div>
                    </div>
                    <div class="row">  
                    </div>
                  </div>
                  <div class="card-footer">
                     {{env('APP_NAME')}} - {{$title}}
                  </div>
                </div>
            </div>
            <div class="col-md-3 col-xl-3">
              <div class="card"> 
                <div class="card-body">
                  <div class="form-group">
                    <img src="{{ asset('assets/img/anime/' . ($anime->cover ?? 'default.jpg')) }}" alt="Anime Cover" class="cover__anime pb-2">
                    <a href="#"><u>Tambahkan ke Favorit</u></a>
                  </div>
                  <div class="form-group">
                    <h4 class="border-bottom pt-2">Judul</h4>
                    <div class="d-flex flex-column">
                    <span><strong>Global:</strong> {{$anime->title}}</span>
                    <span><strong>Japanese:</strong> {{$anime->original_title}}</span>
                    </div>
                  </div>
                  <div class="form-group">
                    <h4 class="border-bottom pt-2">Informasi</h4>
                    <div class="d-flex flex-column">
                    <span><strong>Type:</strong> {{$anime->type}}</span>
                    <span><strong>Publish:</strong> {{date('F, Y', strtotime($anime->date_aired))}}</span>
                    <span><strong>Studio:</strong> {{$anime->studio}}</span>
                    <span><strong>Durasi:</strong> {{$anime->duration}}</span>
                    <span><strong>Kualtias:</strong> {{$anime->quality}}</span>
                    </div>
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
        paging: false,
        info: false,
        searching: false,
        lengthchange: false,
        ajax: '{{Request::url() }}/json',
        columns: [
          {
            data: "DT_RowIndex",
            name: "DT_RowIndex",
            className: "text-center",
          },
          {
            data: "episode",
            className: "text-left",
          },
          {
            data: "replies",
            className: "text-center", render: function(data){
              return `<i class="fa fa-comments"></i> ${data}`;
            }
          },
          {
            data: "date_updated",
            className: "text-center",
          },
        ],
      });
    });
</script>
@endsection