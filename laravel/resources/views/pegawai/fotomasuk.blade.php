@extends('layouts.pegawai')
@section('title','Absen Masuk')
@section('style')
<link rel="stylesheet" href="{{ asset('css/fotomasuk.css') }}">
@endsection
@section('konten')

<div class="row loading" id="loading">
    <div class="loader"></div> 
    <div class="flex-break"></div>
    <div class="col-12justify-content-center">
        <div class="text text-center">
            <h1>Mohon Menunggu!</h1>
            <p id="keterangan" class="" style="color: white;"></p>
        </div>
    </div>
    
</div>
<div class="container mb-5 pb-5 konten" id="konten">
    <div class="row ">
        <div class="col-12 justify-content-center">
            <div class="peringatan text-center alert alert-success mt-2">
                <h5>Foto harus menampilkan wajah dan latar belakang sekolah</h5>
            </div>

            <form action="{{ route('kirimfotomasuk') }}" method="post" name="kirim_foto" id="kirim_foto">
                @csrf
                <input type="hidden" name="foto_masuk" id="foto_masuk" class="image-tag" required>
                <div class="form-group">
                </div>
            </form>
            <div class="text-center mx-auto">
                <div class="webcam-capture-body text-center mt-2 mx-auto">
                    <h5>Absen Masuk</h5>
                    <!-- Frame Lingkaran -->
                    <div class="circle-frame" id="frame">
                        <video id="webcam" autoplay playsinline muted></video>
                    </div>
                     <div id="status">Buka Kamera...</div>
                </div>
            </div>
         
           

        </div>

    </div>
</div>

<div class="luar-jarak container mb-5 pb-5 mt-5" id="luar-jarak">
    <div class="jarak">
        <div class="jarak-terlalu-jauh">
            <div class="alert alert-danger" role="alert">
                <h4 class="alert-heading">Anda terlalu jauh dari sekolah!</h4>
                <p>Anda harus berada dalam jarak {{$pengaturan[0]->jarak_maksimal}} meter dari sekolah, saat ini GPS menunjukkan anda berada <strong> <span id="jarak"></span> meter </strong>dari sekolah</p>
                <hr>
                <ol>
                    <li>Pastikan GPS Anda aktif</li>
                    <li>Periksa kembali lokasi anda  <a href="https://www.google.com/maps/?q={{ $pengaturan[0]->latitude }},{{ $pengaturan[0]->longitude }}"  target="_blank" class="btn btn-sm btn-primary">DISINI</a></li>
                    <li>Setelah memastikan lokasi anda pada GPS, silahkan <a href="{{route('pegawai')}}" class="btn btn-sm btn-success">ULANGI</a> lagi proses Absen </li>
                    <li>Periksa kembali jaringan internet anda</li>
                    <li>Jika masalah masih berlanjut, coba restart perangkat anda</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade " id="ModalError" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content bg-danger">
            <div class="modal-header">
                <h5 class="modal-title text-light">Terdapat kesalahan dari foto yang dikirimkan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-light">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>

            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script src="https://cdn.jsdelivr.net/npm/@mediapipe/face_mesh/face_mesh.js" crossorigin="anonymous"></script>
<script src="{{asset('dist/js/absen.js')}}"></script>
<script language="JavaScript">
       let latSMK1 = {{$pengaturan[0]->latitude}};
       let longSMK1 = {{$pengaturan[0]->longitude}};
       let jarak_maksimal={{$pengaturan[0]->jarak_maksimal}}

    @if($errors->any())
    $('#ModalError').modal('show');
    @endif
</script>
@endsection