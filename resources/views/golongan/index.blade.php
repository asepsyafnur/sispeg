@extends('layouts.dashboard')


@section('content')

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between">
        <h1 class="h3 mb-2 text-gray-800">Golongan</h1>
    </div>
    <!-- DataTales Example -->
    <div class="row">
        <div class="col-md-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Data Golongan</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-condensed text-center" id="golonganTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Golongan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
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
                    <form action="{{route('golongan.store')}}" method="POST" id="add-golongan-form">
                        @csrf
                        <div class="form-group">
                            <label for="nama">Golongan</label>
                            <input type="text" name="nama" class="form-control" id="nama" placeholder="Masukkan nama golongan">
                            <span class="text-danger error-text nama_error"></span>
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
            // Event: delete post
        $("form[role='alert']").submit(function(event) {
        event.preventDefault();
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
                if (result.isConfirmed) {
                    // todo: process of deleting categories
                    event.target.submit()
                }
            });
        });

        // tambah golongan
        $('#add-golongan-form').on('submit', function(e){
            e.preventDefault();
            var form = this;
            $.ajax({
                url : $(form).attr('action'),
                method: $(form).attr('method'),
                data : new FormData(form),
                processData : false,
                dataType : 'json',
                contentType: false,
                beforeSend : function (){
                    $(form).find('span.error-text').text('')
                },
                success : function (data) {
                    if(data.code == 0 ){
                        $.each(data.error, function(prefix, val){
                            $(form).find('span.'+prefix+'_error').text(val[0]);
                        });
                    }else{
                        $(form)[0].reset();
                        $('#golonganTable').DataTable().ajax.reload(null, false);
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            text: data.msg,
                            showConfirmButton: false,
                            timer: 2000
                        });
                    }
                }
            });
        });

        // tampilkan golongan
        $('#golonganTable').DataTable({
            processing : true,
            info : true,
            ajax : "{{ route('golongan.list') }}",
            columns : [
                // {data : 'id', name:'id'},
                {data : 'DT_RowIndex', name:'DT_RowIndex'},
                {data : 'nama', name: 'nama'},
                {data : 'aksi', name : 'aksi'}
            ]
        });

        // edit golongan
        $('#golonganTable').on('click', '#btnEdit', function(){
            var golonganId = $(this).data('id');
            $('#editModal').find('form')[0].reset();
            $('#editModal').find('span.error-text').text('');
            $.get(`{{url('dashboard/golongan/${golonganId}/edit')}}`, {}, function(data){
                $('#editModal').find('#nama').val(data.details.nama)
            }, 'json');
        });

        // proses update
        $('#update-golongan-form').on('submit', function(e){
            e.preventDefault();
            var form = this;
            console.log(form)
            $.ajax({
                url : $(form).attr('action'),
                method : $(form).attr('method'),
                data : new FormData(form),
                processData : false,
                typeData : 'json',
                contentType : false,
                beforeSend : function () {
                    $(form).find('span.error-text').text('');
                },
                success : function(data) {
                    if(data.code == 0){
                        $.each(data.error, function(prefix, val){
                            $(form).find('span.'+prefix+'_error').text(val[0]);
                            console.log(prefix);
                        });
                    }
                }
            })
        });

    });
    // $('#tambah').on('click', function(e){
    //     e.preventDefault()
    //     $('#exampleModal .close').click();
    //     $.get("", {}, function(data, status){
    //         $('#ModalLabel').html('Tambah Data')
    //         $('#exampleModal .modal-body').html(data)
    //         $('#exampleModal').modal('show')
    //         tambah()
    //     });
    // });
</script>
@endpush