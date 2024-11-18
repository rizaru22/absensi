@extends('layouts.pegawai')
@section('style')
<style>
    .card-header .btn-link{
        text-decoration: none !important;
        color: white;
        font-weight: 500;
        border: none !important;
    }
</style>
@endsection
@section('title','FAQ')a
@section('konten')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h2>FAQ</h2>
        </div>
    </div>
    <div class="row pb-3">
        <div class="col-12">
            <div class="accordion" id="accordionExample">
                <div class="card">
                    <div class="card-header" id="headingOne">
                        <h2 class="mb-0">
                            <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                Dimana titik pusat lokasi yang menjadi acuan?
                            </button>
                        </h2>
                    </div>

                    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                        <div class="card-body">
                        Titik pusat kordinat sekolah yang menjadi acuan absen cek <a href="https://www.google.com/maps/?q={{ $data['0']->latitude }},{{ $data[0]->longitude }}" target="_blank" >di sini</a>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="headingTwo">
                        <h2 class="mb-0">
                            <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                Berapa jarak maksimum yang diperbolehkan dari titik pusat lokasi?
                            </button>
                        </h2>
                    </div>
                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                        <div class="card-body">
                        Jarak maksimum absensi dalam radius <b>{{$data[0]->jarak_maksimal}} meter </b>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="headingThree">
                        <h2 class="mb-0">
                            <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                Bagaimana rincian ketentuan saat melakukan absen?
                            </button>
                        </h2>
                    </div>
                    <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                        <div class="card-body">
                            <ol>
                                <li>Absen masuk dapat dilakukan pada pukul <b> {{$data[0]->jam_masuk}} sampai dengan {{$data[0]->jam_maksimal_masuk}} </b></li>
                                <li>Absen pulang dapat dilakukan pada pukul <b>{{$data[0]->jam_pulang}} sampai dengan {{$data[0]->jam_maksimal_pulang}}</b></li>
                                <li>Tidak bisa melakukan absen pulang jika belum melakukan absen masuk</li>
                                <li>Lakukan Foto Absen pada tempat yang menandakan bahwa anda berada di lingkungan sekolah</li>
                                <li>Notifikasi belum absen bisa dilihat di <a href="https://t.me/+ViL3ZuEe0Lo3ZDdl" target="_blank">Grup Telegram</a></li>
                            </ol>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="headingFour">
                        <h2 class="mb-0">
                            <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                Bagaimana jika muncul pesan error pada aplikasi?
                            </button>
                        </h2>
                    </div>
                    <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordionExample">
                        <div class="card-body">
                            <p>Jika terjadi error dapat melakukan tangkap layar dan mengirimkannya ke tim pengembang melalui <a href="https://wa.me/6285221274876" target="_blank" >wa.me</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row pb-5">
        <div class="col-12 text-center">
            <a href="{{route('pegawai')}}" class="btn btn-sm btn-outline-success"><i class="fas fa-home"></i> Dashboard</a>
        </div>
    </div>
</div>
@endsection