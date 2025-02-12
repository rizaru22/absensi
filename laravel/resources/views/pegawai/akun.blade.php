@extends('layouts.pegawai')
@section('title','Ubah Password')

@section('konten')
<div class="container spasi-bawah">
    <div class="row">
        <div class="col-12">
            <div class="card mt-4 ">
                <div class="card-header text-bg-success">
                    Formulir Ubah Password
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong>Ada yang salah</strong> Input yang anda masukkan ada yang salah<br><br>
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                </div>
                <div class="card-body">

                    <form action="{{ route('updateAkun') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="name">Nama</label>
                            <input type="text" id="name" name="name" class="form-control" value="{{$data->name}}" disabled>
                        </div>
                        <div class="form-group">
                            <label for="nip">NIP</label>
                            <input type="text" id="nip" name="nip" class="form-control" disabled value="{{$data->nip}}">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" class="form-control" disabled value="{{$data->email}}">
                        </div>
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" id="username" name="username" class="form-control" disabled value="{{$data->username}}">
                        </div>
                        <div class="form-group">
                            <label for="password ">Password</label>
                            <input type="password" id="password" name="password" class="form-control" required>
                        </div>



              
                </div>
                <div class="card-footer text-end mt-4">
                            <a href="{{route('pegawai')}}" class="btn btn-warning float-start"><i class="fas fa-window-close"></i> Batal</a>
                            <button type="submit" class="btn btn-danger"><i class="fas fa-edit"></i> Ubah</button>
                        </div>
                    </form>
            </div>
        </div>
    </div>
</div>
@endsection