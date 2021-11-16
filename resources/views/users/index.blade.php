@extends('layouts.dashboard')


@section('content')

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between">
        <h1 class="h3 mb-2 text-gray-800">Pegawai</h1>
        <a href="{{ route('users.create') }}" class="btn btn-sm btn-primary">
            <span class="icon text-white-50">
                <i class="fas fa-plus"></i>
            </span>
            <span class="text">Tambah Data</span>
        </a>
    </div>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Pegawai</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered text-center" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Nip</th>
                            <th>Golongan</th>
                            <th>Jabatan</th>
                            {{-- <th>Aksi</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $value => $user)
                            <tr>
                                <td>{{ $value + 1 }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->nip }}</td>
                                <td>{{ $user->golongan->nama }}</td>
                                <td>{{ $user->jabatan->nama }}</td>
                                {{-- <td>
                                    <button class="btn btn-outline-warning btn-sm" id="show" data-toggle="modal" data-target="#exampleModal" 
                                        data-nama="{{ $user->name }}"
                                        data-nip="{{ $user->nip }}"
                                        data-email="{{ $user->email }}"
                                        data-golongan="{{ $user->golongan->nama }}"
                                        data-jabatan="{{ $user->jabatan->nama }}">
                                        <span class="icon">
                                            <i class="fas fa-eye"></i>
                                        </span>
                                    </button>
                                    <form action="{{ route('users.destroy', ['user' => $user]) }}" class="d-inline" role="alert" alert-text="apakah anda yakin ingin menghapus {{$user->name}}" method="POST">
                                        @method('DELETE')
                                        @csrf
                                        <button type="submit" class="btn btn-outline-danger btn-sm">
                                            <span class="icon">
                                                <i class="fas fa-trash"></i>
                                            </span>
                                        </button>
                                    </form>
                                </td> --}}
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="Modallabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalLabel">Detail Pegawai</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <input type="text" class="form-control" value="" id="name" disabled>
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-control" value="" id="email" disabled>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" value="" id="nip" disabled>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" value="" id="jabatan" disabled>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" value="" id="golongan" disabled>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

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

    })

    $('#dataTable').on('click', '#show', function(){
        var data = {
            nama : $(this).data('nama'),
            nip : $(this).data('nip'),
            email : $(this).data('email'),
            golongan : $(this).data('golongan'),
            jabatan : $(this).data('jabatan'),
        }


        $('#exampleModal').find('#name').val(data.nama)
        $('#exampleModal').find('#nip').val(data.nip)
        $('#exampleModal').find('#email').val(data.email)
        $('#exampleModal').find('#golongan').val(data.golongan)
        $('#exampleModal').find('#jabatan').val(data.jabatan)

    })

    


</script>
@endpush