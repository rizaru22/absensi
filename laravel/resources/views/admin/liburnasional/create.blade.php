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
@section('namaHalaman','Data Libur')
@section('konten')
<div class="row">
    <div class="col-6">
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
        <h3 class="card-title">Tambah Data Libur</h3>
    </div>
    <div class="card-body">

        <form action="{{route('liburnasional.store')}}" method="post">
            @csrf
            <div class="form-group">
                <label for="tanggal">Tanggal</label>
                <input type="date" class="form-control" id="tanggal" name="tanggal" required>
            </div>
            <div class="form-group">
                <label for="kode">Kode</label>
                <select class="form-control" name="kode" id="kode" required>
                    <option value="LN">Libur Nasional</option>
                    <option value="CB">Cuti Bersama</option>
                </select>
            </div>
            <div class="form-group">
                <label for="keterangan">Keterangan:</label>
                <input type="text" class="form-control" id="keterangan" name="keterangan" placeholder="Keterangan">
            </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-success float-right"><i class="fas fa-save"></i> Simpan</button>
        </form>
    </div>
</div>
    </div>
</div>

@endsection

@section('script')

@endsection