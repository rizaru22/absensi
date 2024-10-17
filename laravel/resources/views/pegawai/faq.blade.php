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
@section('title','FAQ')
@section('konten')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h2>FAQ</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="accordion" id="accordionExample">
                <div class="card">
                    <div class="card-header" id="headingOne">
                        <h2 class="mb-0">
                            <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                Dimana titip pusat lokasi yang menjadi acuan?
                            </button>
                        </h2>
                    </div>

                    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                        <div class="card-body embed-responsive embed-responsive-16by9">
                        <iframe class="embed-responsive-item" src="https://www.google.com/maps/embed?pb=!1m17!1m12!1m3!1d3196.0232018970546!2d{{ $data[0]->longitude }}!3d{{ $data['0']->latitude }}!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m2!1m1!2zNMKwMjInMjguOCJOIDk4wrAwNSczNS41IkU!5e1!3m2!1sen!2sid!4v1729162820164!5m2!1sen!2sid"  style="border:0;" allowfullscreen loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="headingTwo">
                        <h2 class="mb-0">
                            <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                Berapa jarak maksimum yang diperbolehkan dari titik pusan lokasi?
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
                                <li>Foto Absen dilakukan dengan latar belakang sekolah, jika sedang ada jam mengajar maka lakukan di dalam kelas atau lab/bengkel. Jika tidak ada jam mengajar lakukan di tempat yang menandakan bahwa anda berada di lingkungan sekolah</li>
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
    <div class="row pt-5">
        <div class="col-12 text-center">
            <a href="{{route('pegawai')}}" class="btn btn-sm btn-outline-success"><i class="fas fa-home"></i> Dashboard</a>
        </div>
    </div>
</div>
@endsection