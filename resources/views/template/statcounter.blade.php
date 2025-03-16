<div class="col-lg-3 mb-4 mb-lg-0 px-lg-0 mt-lg-0">
    <div
        style="visibility: hidden; display: none; width: 285px; height: 801px; margin: 0px; float: none; position: static; inset: 85px auto auto;">
    </div>
    <div data-settings="{&quot;parent&quot;:&quot;#content&quot;,&quot;mind&quot;:&quot;#header&quot;,&quot;top&quot;:10,&quot;breakpoint&quot;:992}"
        data-toggle="sticky" class="sticky" style="top: 85px;">
        <div class="sticky-inner">
            @yield('button')
            <div class="bg-white text-sm">
                <h4 class="px-3 py-4 op-5 m-0 roboto-bold">
                    Stats
                </h4>
                <hr class="my-0">
                <div class="row text-center d-flex flex-row op-7 mx-0">
                    <div class="col-sm-6 flex-ew text-center py-3 border-bottom border-right"> <a
                            class="d-block lead font-weight-bold" href="#">{{$c_artikel}}</a> Artikel</div>
                    <div class="col-sm-6 col flex-ew text-center py-3 border-bottom mx-0"> <a
                            class="d-block lead font-weight-bold" href="#">{{$c_diskusi}}</a> Diskusi</div>
                </div>
                <div class="row d-flex flex-row op-7">
                    <div class="col-sm-6 flex-ew text-center py-3 border-right mx-0"> <a
                            class="d-block lead font-weight-bold" href="#">{{$c_user}}</a> Users</div>
                    <div class="col-sm-6 flex-ew text-center py-3 mx-0"> <a
                            class="d-block lead font-weight-bold" href="#">{{$c_departemen}}</a> Departemen </div>
                </div>
            </div>
        </div>
    </div>
</div>