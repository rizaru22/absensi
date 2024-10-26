@extends('layouts.app')

@section('style')
    <!-- Toastr -->
    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.css">
<style>
    .card-footer .btn-success {
        background-color: #3D9970;
    }

    .card-header {
        background-color: #3D9970 !important;
    }
</style>
@endsection
@section('namaHalaman','Pengaturan')
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

    <div class="card-body">

        <form action="{{route('pengaturan.update',$data->id)}}" method="post">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="nama">Nama Instanssi:</label>
                <input type="text" class="form-control" id="nama_instansi" name="nama_instansi" value="{{$data->nama_instansi}}" required>
            </div>
            <div class="form-group">
                <label for="nip">Latitude:</label>
                <input type="number" class="form-control" id="latitude" name="latitude" value="{{$data->latitude}}" step="any">
            </div>
            <div class="form-group">
                <label for="nip">Longitude:</label>
                <input type="number" class="form-control" id="longitude" name="longitude" value="{{$data->longitude}}" step="any">
            </div>
            <div class="form-group">
                <label for="nip">Jarak Maksimal (meter):</label>
                <input type="number" class="form-control" id="jarak_maksimal" name="jarak_maksimal" value="{{$data->jarak_maksimal}}">
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-6">
                        <label for="nip">Jam Masuk :</label>
                        <input type="time" class="form-control" id="jam_masuk" name="jam_masuk" value="{{$data->jam_masuk}}">
                    </div>
                    <div class="col-6">
                        <label for="nip">Jam Maksimal Masuk :</label>
                        <input type="time" class="form-control" id="jam_maksimal_masuk" name="jam_maksimal_masuk" value="{{$data->jam_maksimal_masuk}}">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-6">
                        <label for="nip">Jam Pulang :</label>
                        <input type="time" class="form-control" id="jam_pulang" name="jam_pulang" value="{{$data->jam_pulang}}">
                    </div>
                    <div class="col-6">
                        <label for="nip">Jam Maksimal Pulang :</label>
                        <input type="time" class="form-control" id="jam_maksimal_pulang" name="jam_maksimal_pulang" value="{{$data->jam_maksimal_pulang}}">
                    </div>
                </div>
            </div>

    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-success float-right"><i class="fas fa-save"></i> Simpan</button>
        </form>
    </div>
</div>
@endsection

@section('script')
<!-- Toastr -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
@if($message = Session::get('success'))
    toastr.success("{{ $message}}");
@endif
</script>
@endsection