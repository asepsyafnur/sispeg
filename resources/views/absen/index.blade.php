@extends('layouts.dashboard')

@section('content')

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between">
        <h1 class="h3 mb-2 text-gray-800">Absenku</h1>
    </div>
    <!-- DataTales Example -->
    <div class="card mb-3">
        <div class="card-header">
            <div class="alert {{$info['alert']}}" role="alert">
                {{$info['status']}}
              </div>
        </div>
        <div class="card-body">
            <form action="{{ route('absens.store') }}" method="POST">
                @csrf
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <input type="text" name="keterangan" class="form-control" placeholder="keterangan...">
                    </div>
                    <div class="form-group col-md-4">
                        <input type="submit" name="masuk" value="Absen Masuk" class="btn btn-primary" {{$info['masuk']}}>
                        <input type="submit" name="keluar" value="Absen Keluar" class="btn btn-primary" {{$info['keluar']}}>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Catatan Absen</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered text-center" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Jam Masuk</th>
                            <th>Jam Keluar</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($absens as $absen)
                            <tr>
                                <td>{{ date('d-m-Y', strtotime($absen->tanggal)) }}</td>
                                <td>{{ $absen->kedatangan }}</td>
                                <td>{{ $absen->kepulangan }}</td>
                                <td>{{ $absen->keterangan }}</td>
                            </tr>    
                        @endforeach
                    </tbody>
                </table>
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
        
    })
<script>
@endpush
