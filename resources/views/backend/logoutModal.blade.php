
       <!-- Logout Modal-->
       <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
              <div class="modal-content">
                  <div class="modal-header flex-row">
                      <h5 class="modal-title card-body p-0 text-center" id="exampleModalLabel">Akan Logout?</h5>
                      <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">×</span>
                      </button>
                  </div>
                  <div class="modal-body">Pilih "Logout" Untuk Mengakhiri Sesi.</div>
                  <div class="modal-footer">
                      <button class="btn btn-danger" type="button" data-dismiss="modal">Cancel</button>
                      <form id="logout-form" action="{{ route('logout') }}" method="POST">
                          @csrf
                      </form>
                      <a class="btn btn-primary text-white" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Logout</a>
                  </div>
              </div>
          </div>
      </div>