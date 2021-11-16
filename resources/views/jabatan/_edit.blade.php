<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title">Ubah Data Jabatan</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
              <form action="{{ route('jabatan.update') }}" method="post" id="update-form">
                  @csrf
                  <input type="hidden" name="id" id="id">
                  <div class="form-group">
                      <input type="text" name="nama" class="form-control" id="nama" placeholder="Masukkan nama jabatan">
                      <span class="invalid-feedback nama_error"></span>
                  </div>
                  <div class="btn-group w-100">
                      <button type="submit" class="btn btn-primary">Ubah</button>
                  </div>
              </form>
          </div>
      </div>
  </div>
</div>