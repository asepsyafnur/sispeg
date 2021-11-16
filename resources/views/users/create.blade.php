<!-- Modal -->
@extends('layouts.dashboard')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between">
        <h1 class="h3 mb-2 text-gray-800">Tambah Data Pegawai</h1>
    </div>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <a href="{{route('users.index')}}" class="nav-link"><i class="fas fa-arrow-left"></i>
                    Kembali
                </a>
            </h6>
        </div>
        <form action="{{ route('users.store') }}" method="POST">
            <div class="card-body">
                @csrf
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="nama">Nama</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" id="name">
                        @error('name')
                            <span class="invalid-feedback">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="email">Email</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" id="email">
                        @error('email')
                            <span class="invalid-feedback">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="email">Nip</label>
                        <input type="text" name="nip" class="form-control @error('nip') is-invalid @enderror" value="{{ old('nip') }}" id="nip">
                        @error('nip')
                            <span class="invalid-feedback">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="form-group col-md-4">
                        <label for="golongan">Golongan</label>
                        <select name="golongan_id" class="form-control @error('golongan_id') is-invalid @enderror" id="golongan">
                            @foreach ($golongans as $golongan)
                                @if (old('golongan_id') == $golongan->id)
                                    <option value="{{ $golongan->id }}" selected>{{ $golongan->nama }}</option>
                                @else
                                    <option value="{{ $golongan->id }}">{{ $golongan->nama }}</option>
                                @endif
                            @endforeach
                        </select>
                        @error('golongan_id')
                            <span class="invalid-feedback">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="form-group col-md-4">
                        <label for="jabatan">Jabatan</label>
                        <select name="jabatan_id" class="form-control @error('jabatan_id') is-invalid @enderror" id="jabatan">
                            @foreach ($jabatans as $jabatan)
                            @if (old('jabatan_id') == $jabatan->id)
                                <option value="{{ $jabatan->id }}" selected>{{ $jabatan->nama }}</option>
                            @else
                                <option value="{{ $jabatan->id }}">{{ $jabatan->nama }}</option>
                            @endif
                        @endforeach
                        </select>
                        @error('jabatan_id')
                            <span class="invalid-feedback">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" value="{{ old('password') }}" id="password" autocomplete="new-password">
                    @error('password')
                        <span class="invalid-feedback">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="password-confirmation">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" value="{{ old('password_confirmation') }}" id="password-confirmation" autocomplete="new-password">
                    @error('password_confirmation')
                        <span class="invalid-feedback">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
                <div class="form-group d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection