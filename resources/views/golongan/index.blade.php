@extends('layouts.dashboard')


@section('content')

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between">
        <h1 class="h3 mb-2 text-gray-800">Golongan</h1>
    </div>
    <div class="row">
        <div class="col-md-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Data Golongan</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered text-center" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Golongan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Tambah Golongan</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('golongan.store') }}" method="POST" id="add-golongan">
                        @csrf
                        <div class="form-group">
                            <input type="text" name="nama" class="form-control" value="{{ old('nama') }}" id="nama" placeholder="Masukkan nama golongan">
                            <span class="invalid-feedback nama_error"></span>
                        </div>
                        <div class="btn-group w-100">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@include('golongan._edit')

@endsection

@push('css-external')
    <link href="{{ asset('assets/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush

@push('javascript-external')
<script src="{{ asset('assets/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/datatables/dataTables.bootstrap4.min.js') }}"></script>

<!-- Page level custom scripts -->
<script src="{{ asset('assets/dashboard/js/demo/datatables-demo.js') }}"></script>
@endpush

@push('javascript-internal')
<script>
    $(document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        // tambah golongan
        $('#add-golongan').on('submit', function(e){
            e.preventDefault();
            var form = this;
            $.ajax({
                url : $(form).attr('action'),
                method : $(form).attr('method'),
                data : new FormData(form),
                processData : false,
                dataType : 'json',
                contentType : false,
                beforeSend : function(){
                    $(form).find('span.invalid-feedback').text('');
                },
                success : function(data) {
                    if(data.code == 400){
                        $.each(data.error, function(prefix, val){
                            $(form).find('#nama').addClass('is-invalid');
                            $(form).find('span.'+prefix+'_error').text(val[0]);
                        });
                    }else{
                        $(form).find('#nama').removeClass('is-invalid');
                        $('#dataTable').DataTable().ajax.reload(null, false);
                        $(form)[0].reset();
                        Swal.fire({
                            title: "Sukses",
                            text: data.msg,
                            icon: 'success',
                            showConfirmButton : false,
                            timer: 2000
                        });
                    }
                }
            });
        });


    });

    // read golongan
    $('#dataTable').DataTable({
        processing : true,
        info : true,
        ajax : "{{ route('golongan.read') }}",
        columns : [
            {data : 'DT_RowIndex', name : 'DT_RowIndex'},
            {data : 'nama', name : 'nama'},
            {data : 'aksi', name : 'aksi'}
        ],
    });

    $(document).on('click', '#btnEdit', function(){
        var id = $(this).data('id');
        $('#editModal').find('form')[0].reset();
        $('#editModal').find('span.invalid-feedback').text('');
        $.post("{{ route('golongan.edit') }}", {id:id}, function(data){
            $('#editModal').find('#id').val(data.details.id)
            $('#editModal').find('#nama').val(data.details.nama)
            $('#editModal').modal('show');
        }, 'json');
    });

    $('#update-form').on('submit', function(e){
        e.preventDefault();
        var form = this;
        $.ajax({
            url : $(form).attr('action'),
            method : $(form).attr('method'),
            data : new FormData(form),
            processData : false,
            dataType : 'json',
            contentType : false,
            beforeSend : function(){
                $(form).find('span.invalid-feedback').text('');
            },
            success : function(data){
                if(data.status == 400){
                    $.each(data.error, function(prefix, val){
                        $(form).find('#nama').addClass('is-invalid');
                        $(form).find('span.'+prefix+'_error').text(val[0]);
                    });
                }else{
                    $('#dataTable').DataTable().ajax.reload(null, false);
                    $('#editModal').modal('hide');
                    $(form).find('#nama').removeClass('is-invalid');
                    $('#editModal').find('form')[0].reset();
                    Swal.fire({
                            title: "Sukses",
                            text: data.msg,
                            icon: 'success',
                            showConfirmButton : false,
                            timer: 2000
                    });
                }
            }
        });
    });

    $(document).on('click', '#btnHapus', function(){
        var id = $(this).data('id');
        var url = "{{ route('golongan.destroy') }}"
         // Event: delete post
        Swal.fire({
            title: "Peringatan",
            text: $(this).attr('alert-text'),
            icon: 'warning',
            allowOutsideClick: false,
            showCancelButton: true,
            cancelButtonText:  "Batal",
            reverseButtons: true,
            confirmButtonText:  "Hapus",
        }).then((result) => {
            if (result.value) {
                $.post(url,{id:id}, function(data){
                    if(data.status == 200){
                        $('#dataTable').DataTable().ajax.reload(null, false);
                        Swal.fire({
                            title: "Sukses",
                            text: data.msg,
                            icon: 'success',
                            showConfirmButton : false,
                            timer: 2000
                        });
                    }else{
                        Swal.fire({
                            title: "Gagal",
                            text: data.msg,
                            icon: 'error',
                            showConfirmButton : false,
                            timer: 2000
                        });
                    }
                }, 'json')
            }
        });
    });

</script>
@endpush