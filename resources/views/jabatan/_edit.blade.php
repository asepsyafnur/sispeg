<!-- Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModalLabel">Tambah Jabatan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
          <form action="" method="POST">
            <div class="modal-body">
                @method('PUT')
                @csrf
                <div class="form-group">
                  <label for="jabatan">Jabatan</label>
                  <input type="text" name="nama" value="" class="form-control @error('nama') is-invalid @enderror" id="jabatan">
                    @error('nama')
                        <span class="invalid-feedback">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Keluar</button>
                <button type="submit" class="btn btn-primary">Edit</button>
            </div>
        </form>
    </div>
  </div>
</div>
@if (session()->has('editFail'))
    @push('javascript-internal')
        <script>
            $('#createModal').modal('show')
        </script>
    @endpush
@endif