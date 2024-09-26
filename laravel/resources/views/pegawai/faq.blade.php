@extends('layouts.pegawai')
@section('title','FAQ')

@section('konten')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h2>Penting Untuk Dibaca</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="accordion" id="accordionExample">
                <div class="card">
                    <div class="card-header" id="headingOne">
                        <h2 class="mb-0">
                            <button class="btn btn-success" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                Titik Pusat Kordinat dan Radius
                            </button>
                        </h2>
                    </div>

                    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                        <div class="card-body">
                            <ol>
                                <li>Titik pusat kordinat sekolah yang menjadi acuan absen cek <a href="https://www.google.com/maps/?q={{ $data['0']->latitude }},{{ $data[0]->longitude }}" target="_blank" >di sini</a></li>
                                <li>Jarak maksimal absensi dalam radius <b>{{$data[0]->jarak_maksimal}} meter </b></li>
                            </ol>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="headingTwo">
                        <h2 class="mb-0">
                            <button class="btn btn-success collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                Absens Masuk dan Pulang
                            </button>
                        </h2>
                    </div>
                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                        <div class="card-body">
                            <ol>
                                <li>Absen masuk dapat dilakukan pada pukul <b> {{$data[0]->jam_masuk}} sampai dengan {{$data[0]->jam_maksimal_masuk}} </b></li>
                                <li>Absen pulang dapat dilakukan pada pukul <b>{{$data[0]->jam_pulang}} sampai dengan {{$data[0]->jam_maksimal_pulang}}</b></li>
                                <li>Tidak bisa melakukan absen pulang jika belum melakukan absen masuk</li>
                                <li>Foto Absen dilakukan dengan latar belakang sekolah, jika sedang ada jam mengajar maka lakukan di dalam kelas atau lab/bengkel. Jika tidak ada jam mengajar lakukan di tempat yang menandakan bahwa anda berada di lingkungan sekolah</li>
                            </ol>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="headingThree">
                        <h2 class="mb-0">
                            <button class="btn btn-success collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                Jika terdapat error pada aplikasi
                            </button>
                        </h2>
                    </div>
                    <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                        <div class="card-body">
                            <p>Jika terjadi error dapat melakukan tangkap layar dan mengirimkannya ke tim pengembang melalui <a href="https://wa.me/6285221274876" target="_blank" >wa.me</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row pt-5">
        <div class="col-12 text-center">
            <a href="{{route('pegawai')}}" class="btn btn-sm btn-outline-success"><i class="fas fa-home"></i> Dashboard</a>
        </div>
    </div>
</div>
@endsection