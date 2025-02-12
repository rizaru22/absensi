@extends('layouts.app')

@section('style')
<!-- Tempusdominus Bootstrap 4 -->
<link rel="stylesheet" href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
@endsection
@section('namaHalaman','Laporan Harian')
@section('konten')
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
            

                <form action="{{ route('updateabsen', $id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="name">Nama</label>
                        <input type="text" id="name" name="name" class="form-control" value="{{$data[0]->user->name}}" disabled>
                    </div>
                    <div class="form-group">
                        <label for="nip">NIP</label>
                        <input type="text" id="nip" name="nip" class="form-control" disabled value="{{$data[0]->user->nip}}" >
                    </div>
                    <div class="form-group">
                        <label for="nip">Jam Masuk</label>
                        <input type="time" step="1" id="jam_masuk" name="jam_masuk" class="form-control"  value="{{$data[0]->jam_masuk}}" >
                    </div>
                    <div class="form-group">
                        <label for="jam_pulang">Jam Pulang</label>
                        <input type="time" step="1" id="jam_pulang" name="jam_pulang" class="form-control"  value="{{$data[0]->jam_pulang}}" >
                    </div>
                    <div class="form-group">
                        <label for="foto_masuk">Foto Masuk</label>
                        <input type="file" id="foto_masuk" name="foto_masuk" class="form-control" value="{{$data[0]->foto_masuk}}" >
                    </div>
                    <div class="form-group">
                        <label for="foto_pulang">Foto Pulang</label>
                        <input type="file" id="foto_pulang" name="foto_pulang" class="form-control" value="{{$data[0]->foto_pulang}}" >
                    </div>
       
            </div>
            <div class="card-footer text-right mt-4">
                <a href="{{route('admin')}}" class="btn btn-warning float-left"><i class="fas fa-window-close"></i> Batal</a>
                <button type="submit" class="btn btn-danger"><i class="fas fa-edit"></i> Ubah</button>
                </form>
            </div>

        </div>
    </div>
</div>

@endsection

@section('script')
<script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<script>
    $(function() {
        $('#reservationdate').datetimepicker({
            format: 'L'
        });

    });
</script>
@endsection