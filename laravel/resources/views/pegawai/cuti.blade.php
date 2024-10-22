@extends('layouts.pegawai')
@section('title','Izin/Cuti')

@section('konten')
<div class="container">
<div class="row pb-5">
            <div class="col-12">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Whoops!</strong> There were some problems with your input.<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            </div>
        </div>

    <div class="row">
        <div class="col-12">
            <div class="card mt-4">
                <div class="card-header">
                    Pilih Jenis Izin dan Kirim Bukti Dukung
                </div>
                <div class="card-body">

                    <form action="{{ route('kirimizin') }}" method="post" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label for="jam_masuk">Jenis Izin</label>
                            <select name="jam_masuk" id="jam_masuk" class="form-control" required>
                                <option value="DL">Dinas Luar</option>
                                <option value="I">Izin</option>
                                <option value="S">Sakit</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="foto_izin">Bukti Dukung</label>
                            <input type="file" id="foto_izin" class="form-control-file" name="foto_izin" accept="image/*" capture="user" />
                        </div>


                        <div class="card-footer text-right mt-4">

                            <button type="submit" class="btn btn-success"><i class="fas fa-envelope"></i> Kirim</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection