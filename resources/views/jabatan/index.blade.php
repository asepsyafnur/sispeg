@extends('layouts.dashboard')


@section('content')

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between">
        <h1 class="h3 mb-2 text-gray-800">Jabatan</h1>
        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#createModal">
            <span class="icon text-white-50">
                <i class="fas fa-plus"></i>
            </span>
            <span class="text">Tambah Data</span>
        </button>
    </div>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Jabatan</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered text-center" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Jabatan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($jabatans as $value => $jabatan)
                            <tr>
                                <td>{{ $value + 1 }}</td>
                                <td>{{ $jabatan->nama }}</td>
                                <td>
                                    <button type="button" class="btn btn-outline-warning btn-sm edit" onclick="edit({{$jabatan}})" data-toggle="modal" data-target="#editModal">
                                        <span class="icon">
                                            <i class="fas fa-edit"></i>
                                        </span>
                                     </button>
                                    <form action="{{ route('jabatan.destroy', ['jabatan' => $jabatan]) }}" class="d-inline" role="alert" alert-text="apakah anda yakin ingin menghapus {{$jabatan->nama_jbt}}" method="POST">
                                        @method('DELETE')
                                        @csrf
                                        <button type="submit" class="btn btn-outline-danger btn-sm">
                                            <span class="icon">
                                                <i class="fas fa-trash"></i>
                                            </span>
                                        </button>
                                    </form>
                                </td>
                            </tr>    
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

{{-- modal create --}}
@include('jabatan._create')

{{-- modal update --}}
@include('jabatan._edit')

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
    });

    function edit(data){
        let id = data.id
        let nama = data.nama
        $('#editModal #nama').val(nama)
        $('#editModal form').attr('action', 'jabatan/'+id)
    }

</script>
@endpush