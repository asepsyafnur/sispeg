@extends('layouts.dashboard')


@section('content')

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between">
        <h1 class="h3 mb-2 text-gray-800">Pegawai</h1>
        <a href="{{ route('absens.exportpdf') }}" class="btn btn-sm btn-primary">
            <span class="icon text-white-50">
                <i class="fas fa-file-pdf"></i>
            </span>
            <span class="text">Export Laporan</span>
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
                            <th>Nama</th>
                            <th>Nip</th>
                            <th>Tanggal</th>
                            <th>Jam Masuk</th>
                            <th>Jam Keluar</th>
                            <th>Keterangan</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pegawais as $value => $pegawai)
                            <tr>
                                <td>{{ $pegawai->user->name }}</td>
                                <td>{{ $pegawai->user->nip }}</td>
                                <td>{{ date('d-m-Y', strtotime($pegawai->tanggal)) }}</td>
                                <td>{{ $pegawai->kedatangan }}</td>
                                <td>{{ $pegawai->kepulangan }}</td>
                                <td>{{ $pegawai->keterangan }}</td>
                                <td>
                                    <a href="" class="badge badge-secondary p-2" id="show" data-toggle="modal" data-target="#exampleModal" 
                                    data-id="{{$pegawai->id}}"
                                    data-status="{{ $pegawai->status }}">
                                            {{$pegawai->status}}
                                    </a>
                                </td>
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
                <h5 class="modal-title" id="ModalLabel">Konfirmasi Kehadiran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('absens.update') }}" method="post">
                    @csrf
                    <input type="hidden" name="id" id="id">
                    <div class="form-group">
                        <select class="form-control" name="status" id="status">
                            @foreach ($statuses as $value => $status)
                                <option value="{{ $value }}">{{ $status }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="btn-group w-100">
                        <button class="btn btn-primary">Konfirmasi</button>
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
        
        var id = $(this).data('id');
        var status = $(this).data('status');

        $('#exampleModal').find('#id').val(id);
        $('#exampleModal').find('#status').val(status);



    })

</script>
@endpush