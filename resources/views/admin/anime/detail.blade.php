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
                  <div class="card-body">
                    <form class="row" method="POST" enctype="multipart/form-data">  
                      <div class="col-md-6 col-lg-3">
                        <div class="form-group">
                          <label class="form-label">Cover</label>
                          <img src="{{ asset('assets/img/' . ($anime->cover ?? 'default.jpg')) }}" alt="Anime Cover" class="cover__anime">
                          <input type="file" class="form-control" accept="image/png, image/gif, image/jpeg" placeholder="Upload Cover">
                          <div class="p-2"><i class="fa fa-eye"></i> Views : 1 view</div>
                        </div>
                      </div>
                      <div class="col-md-6 col-lg-3">
                        <div class="form-group">
                          <label class="form-label">Title</label>
                          <textarea class="form-control" name="title" cols="30" rows="3"></textarea>
                        </div>
                        <div class="form-group">
                          <label class="form-label">Original Title</label>
                          <textarea class="form-control" name="original_title" cols="30" rows="3"></textarea>
                        </div>
                        <div class="form-group">
                          <label class="form-label">Description</label>
                          <textarea class="form-control" name="description" cols="30" rows="3"></textarea>
                        </div>
                      </div>
                      <div class="col-md-6 col-lg-3">
                        <div class="form-group">
                          <label class="form-label">Type</label>
                          <input type="text" class="form-control" name="type" />
                        </div>
                        <div class="form-group">
                          <label class="form-label">Studio</label>
                          <input type="text" class="form-control" name="studio" />
                        </div>
                        <div class="form-group">
                          <label class="form-label">Aired</label>
                          <input type="date" class="form-control" name="date_aired" />
                        </div>
                        <div class="form-group">
                          <label class="form-label">Status</label>
                          <select class="form-control" name="status">
                            <option value="">-- Pilih Status</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-6 col-lg-3">
                        <div class="form-group">
                          <label class="form-label">MyAnimelist Score</label>
                          <input type="text" class="form-control" name="score" />
                        </div>
                        <div class="form-group">
                          <label class="form-label">Rating</label>
                          <input type="text" class="form-control" name="rating" />
                        </div>
                        <div class="form-group">
                          <label class="form-label">Episode Duration</label>
                          <input type="text" class="form-control" name="duration" />
                        </div>
                        <div class="form-group">
                          <label class="form-label">Movie Quality</label>
                          <input type="text" class="form-control" name="quality" />
                        </div>
                      </div>
                    </form>
                  </div>
                  <div class="card-footer">
                     {{env('APP_NAME')}} - {{$title}}
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection