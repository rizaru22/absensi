@extends('layouts.pegawai')

@section('title','FAQ')
@section('konten')
<div class="container spasi-bawah">
    <div class="row">
        <div class="col-12">
            <h2>FAQ</h2>
        </div>
    </div>



    <div class="accordion accordion-flush " id="accordionExample">
  <div class="accordion-item ">
    <h2 class="accordion-header ">
      <button class="accordion-button " type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
      Berapa jarak maksimum yang diperbolehkan dari titik pusat lokasi?
      </button>
    </h2>
    <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
      <div class="accordion-body">
      Jarak maksimum absensi dalam radius <b>{{$pengaturan[0]->jarak_maksimal}} meter </b>
      </div>
    </div>
  </div>
  <div class="accordion-item">
    <h2 class="accordion-header">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
      Bagaimana rincian ketentuan saat melakukan absen?
      </button>
    </h2>
    <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
      <div class="accordion-body">
      <ol>
                                <li>Absen masuk dapat dilakukan pada pukul <b> {{$pengaturan[0]->jam_masuk}} sampai dengan {{$pengaturan[0]->jam_maksimal_masuk}} </b></li>
                                <li>Absen pulang dapat dilakukan pada pukul <b>{{$pengaturan[0]->jam_pulang}} sampai dengan {{$pengaturan[0]->jam_maksimal_pulang}}</b></li>
                                <li>Tidak bisa melakukan absen pulang jika belum melakukan absen masuk</li>
                                <li>Lakukan Foto Absen pada tempat yang menandakan bahwa anda berada di lingkungan sekolah</li>
                                <li>Notifikasi belum absen bisa dilihat di Whatsapp</li>
                            </ol>
      </div>
    </div>
  </div>
  <div class="accordion-item">
    <h2 class="accordion-header">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
      Bagaimana jika muncul pesan error pada aplikasi?
      </button>
    </h2>
    <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
      <div class="accordion-body">
      <p>Jika terjadi error dapat melakukan tangkap layar dan mengirimkannya ke tim pengembang melalui <a href="https://wa.me/6285221274876" target="_blank" >wa.me</a></p>
      </div>
    </div>
  </div>
</div>
</div>
@endsection