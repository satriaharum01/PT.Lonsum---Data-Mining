
<!-- Logout Modal-->
<div class="modal fade" id="verifyModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header flex-row">
                <h5 class="modal-title card-body p-0 text-center" id="exampleModalLabel">Verifikasi</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    
                </button>
            </div>
            <form action="" method="post" id="verifyForm">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">ID Laporan</label>
                    <input type="text" class="form-control" name="laporan_id" value="" readonly/>
                </div>
                <div class="form-group">
                    <label class="form-label">Verikator</label>
                    <input type="text" class="form-control d-none" name="verifikator_id" value="{{Auth::user()->id}}" readonly/>
                    <input type="text" class="form-control" name="verifikator_name" value="{{Auth::user()->name}}" readonly/>
                </div>
                <div class="form-group">
                    <label class="form-label">Tanggal Verifikasi</label>
                    <input type="date" class="form-control" name="tanggal_verifikasi" value="{{date('Y-m-d')}}" readonly/>
                </div>
                <div class="form-group">
                    <label class="form-label">Status</label>
                    <select class="form-control" name="status" id="status">
                        <option value="menunggu">Menunggu</option>
                        <option value="diterima">Diterima</option>
                        <option value="ditolak">Ditolak</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Catatan</label>
                    <textarea class="form-control" name="catatan" cols="30" rows="3" placeholder="Contoh: Bukti Foto sesuai."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="reset" class="btn btn-danger" data-dismiss="modal">Kembali</button>
                <button type="submit" class="btn btn-primary btn-simpan">Simpan</button>
            </div>
            </form>
        </div>
    </div>
</div>