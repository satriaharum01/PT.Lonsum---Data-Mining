<!-- Logout Modal-->
<div class="modal fade" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header flex-row">
                <h5 class="modal-title card-body p-0 text-center" id="exampleModalLabel">Akan Logout?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('admin.stoking.preview')}}" method="POST" id="upload-form"
                    enctype="multipart/form-data">
                    @csrf
                    <label class="form-label">Pilih file Excel:</label>
                    <div class="form-group d-flex">
                        <input type="file" name="file" class="form-control col-md-8" accept=".xlsx" required>
                        <button type="submit" class="btn btn-primary col-md-4 mx-2">Preview</button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger" type="button" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>