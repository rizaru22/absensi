@extends('layouts.app')

@section('style')
    <style>
        .card-footer .btn-success{
            background-color: #3D9970;
        }
        .card-header{
            background-color: #3D9970 !important;
        }
    </style>
@endsection
@section('namaHalaman','Tambah Data Pegawai')
@section('konten')
@if ($errors->any())
    <div class="alert alert-danger">
        <strong>Whoops!</strong> Ada masalah dengan data yang disimpan.<br><br>
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
<div class="card card-success">
    <div class="card-header">
        <h3 class="card-title">Ubah Data Pegawai</h3>
    </div>
    <div class="card-body">

        <form action="{{route('pengguna.update',$user->id)}}" method="post">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="nama">Nama Lengkap:</label>
                <input type="text" class="form-control" id="name" name="name"  value="{{$user->name}}" required>
            </div>
            <div class="form-group">
                <label for="nip">NIP/NIPPPK/NIPS/NIK:</label>
                <input type="number" class="form-control" id="nip" name="nip" value="{{$user->nip}}">
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email"  value="{{$user->email}}" required>
            </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-success float-right"><i class="fas fa-save"></i> Simpan</button>
        </form>
    </div>
</div>
@endsection

@section('script')

@endsection