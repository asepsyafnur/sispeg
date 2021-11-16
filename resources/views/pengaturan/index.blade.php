@extends('layouts.dashboard')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between">
        <h1 class="h3 mb-2 text-gray-800">Pengaturan Akun</h1>
    </div>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <form action="{{ route('pengaturan.update', ['pengaturan'=>$pengaturan->id]) }}" method="POST">
            <div class="card-body">
                @method('PUT')
                @csrf
                <input type="hidden" name="role" value="2">
                <div class="form-group">
                    <label for="nama">Nama</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $pengaturan->name) }}" id="name">
                    @error('name')
                        <span class="invalid-feedback">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="email">Nip</label>
                    <input type="text" name="nip" class="form-control @error('nip') is-invalid @enderror" value="{{ old('nip', $pengaturan->nip) }}" id="nip">
                    @error('nip')
                        <span class="invalid-feedback">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $pengaturan->email) }}" id="email">
                    @error('email')
                        <span class="invalid-feedback">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="golongan">Golongan</label>
                        <select name="golongan_id" class="form-control @error('golongan_id') is-invalid @enderror" id="golongan">
                            @foreach ($golongans as $golongan)
                            @if (old('golongan_id', $pengaturan->golongan_id) == $golongan->id)
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
                    <div class="form-group col-md-6">
                        <label for="jabatan">Jabatan</label>
                        <select name="jabatan_id" class="form-control @error('jabatan_id') is-invalid @enderror" id="jabatan">
                            @foreach ($jabatans as $jabatan)
                            @if (old('jabatan_id', $pengaturan->jabatan_id) == $jabatan->id)
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
                    <button type="submit" class="btn btn-primary">Ubah</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection