@extends('layouts.app')

@section('style')
<style>
    .card-footer .btn-success {
        background-color: #3D9970;
    }

    .card-header {
        background-color: #3D9970 !important;
    }
</style>
@endsection
@section('namaHalaman','Upload Data Pegawai')
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
        <h3 class="card-title">Upload Data Pegawai</h3>
    </div>
    <div class="card-body">

        <form action="{{route('uploadfile')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="file" name="file" accept=".xlsx, .xls, .csv">
                    <label class="custom-file-label" for="file">Pilih file sesuai template yang disediakan</label>
                </div>
            </div>


    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-success float-right"><i class="fas fa-file-upload"></i> Unggah</button>
        </form>
        <a href="{{asset('download/template.xlsx')}}" class="btn btn-info"><i class="fas fa-file-download"></i> Unduh Template</a>
    </div>
</div>
@endsection

@section('script')
<script src="{{ asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
<script>
$(function () {
  bsCustomFileInput.init();
});
</script>
@endsection