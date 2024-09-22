@extends('layouts.pegawai')
@section('title','Izin/Cuti')

@section('konten')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card mt-4">
                <div class="card-header">
                    Ubah Passsword
                </div>
                <div class="card-body">

                    <form action="{{ route('updateAkun') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="name">Nama</label>
                            <input type="text" id="name" name="name" class="form-control" disabled>
                        </div>
                        <div class="form-group">
                            <label for="nip">NIP</label>
                            <input type="text" id="nip" name="nip" class="form-control" disabled>
                        </div>
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" id="username" name="username" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="password ">Password</label>
                            <input type="password" id="password" name="password" class="form-control" required>
                        </div>
         
                        

                        <div class="card-footer text-right mt-4">
                            <a href="{{route('pegawai')}}" class="btn btn-warning float-left"><i class="fas fa-window-close"></i> Batal</a>
                            <button type="submit" class="btn btn-danger"><i class="fas fa-edit"></i> Ubah</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection