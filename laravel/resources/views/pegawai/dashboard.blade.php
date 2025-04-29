@extends('layouts.pegawai')
@section('style')
<!-- Toastr -->
<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.css">

@endsection
@section('title','HadirIn')

@section('konten')



    <div id="body">
        <header>
            <div class="container-fluid">
                <div class="row d-flex">
                    <div class="col-sm-12 text-end">
                        <p class="pt-2 pr-2">
                            <span class="pr-2 ">{{ $tanggal }}</span>
                            <span class="jam pl-2 pr-2" id="waktu"></span>
                        </p>
                    </div>

                </div>
                <div class="d-flex flex-row justify-content-center">
                    <div class="p-1">
                        <h3>{{$pengaturan[0]->nama_instansi}}</h3>
                    </div>
                </div>
            </div>
        </header>
        <main>
            <div class="container-fluid">
                <div class="row  overlap">
                    <div class="col-sm-12 ">
                        <div class="card card-borderless">
                            <div class="card-header card-header-center card-header-light">
                                <h6>Selamat Datang</h6>

                                <h4>{{ Auth::user()->name }}</h4>
                            </div>
                            <div class="card-body">
                                <div class="d-flex flex-row justify-content-center">

                                    <div class="ps-3 pe-3">
                                        <a href="{{ route('absen') }}" class="d-flex flex-column align-items-center">
                                            <button class="btn btn-danger btn-red btn-lg">
                                                <i class="fas fa-camera"></i>
                                            </button>
                                            <span class="text-black">{{$nama_tombol}}</span>
                                        </a>
                                    </div>
                                    <div class="ps-3 pe-3">
                                        <a href="{{route('izin')}}" class="d-flex flex-column align-items-center">
                                            <button class="btn btn-primary btn-blue btn-lg">
                                                <i class="fas fa-envelope"></i>
                                            </button>
                                            <span class="text-black">Cuti</span>
                                        </a>
                                    </div>
                                    <div class="ps-3 pe-3">
                                        <a href="{{route('akun')}}" class="d-flex flex-column align-items-center">
                                            <button class="btn btn-warning btn-lg">
                                                <i class="fas fa-user" style="color:white;"></i>
                                            </button>
                                            <span class="text-black">Akun</span>
                                        </a>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-4">
                    <h4 class="text text-black">Hari Ini</h4>
                    <div class="col">
                        <div class="card card-red card-borderless pt-3 pb-3 text-light card-header-center">
                            Absen Masuk
                            <h5>{{ $jamMasukHariIni }}</h5>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card card-blue card-borderless pt-3 pb-3 text-light card-header-center">
                            Absen Pulang
                            <h5>{{ $jamPulangHariIni }}</h5>
                        </div>
                    </div>
                </div>
                <div class="row mt-4 ">
                    <div class="col">
                        <div class="text text-black">
                            <h4>Rekap absen pekan ini</h4>
                        </div>
                    </div>
                </div>

                <div class="row spasi-bawah ms-1 me-1 ">
                    <div class="col-sm-12 ">
                        <table class="table table-bordered table-sm table-dark colorize ">
                            <thead>
                                <tr>
                                    <th class="align-middle">Hari</th>
                                    <th class="align-middle">Jam Masuk</th>
                                    <th class="align-middle">Jam Pulang</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $daftar_hari = array(
                                'Sunday' => 'Minggu',
                                'Monday' => 'Senin',
                                'Tuesday' => 'Selasa',
                                'Wednesday' => 'Rabu',
                                'Thursday' => 'Kamis',
                                'Friday' => 'Jumat',
                                'Saturday' => 'Sabtu'
                                );

                                @endphp

                                @foreach($dataAbsen as $item)
                                @foreach($item as $subItem)
                                <tr>
                                    <td class="align-middle">{{ $daftar_hari[date('l',strtotime($subItem['created_at']))] }}</td>
                                    <td class="align-middle">{{ $subItem['jam_masuk'] }}</td>
                                    <td class="align-middle">{{ $subItem['jam_pulang'] }}</td>

                                </tr>

                                @endforeach
                                @endforeach
                                <tr>
                                    <td class="align-middle">Total Jam Per Minggu</td>
                                    <td colspan="2" class="align-middle">{{ $jamKerjaPerMinggu }} </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>


            </div>

        </main>
    </div>


    @endsection
    @section('script')

    <!-- <script src="{{asset('dist/js/detect.js')}}"></script> -->
    <!-- Toastr -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        // const x = document.getElementById("keterangan");
        window.onload=startTime;
        function startTime() {
            const today = new Date();
            let h = today.getHours();
            let m = today.getMinutes();
            let s = today.getSeconds();
            m = checkTime(m);
            s = checkTime(s);
            document.getElementById('waktu').innerHTML = h + ":" + m + ":" + s;
            setTimeout(startTime, 1000);
        }

        function checkTime(i) {
            if (i < 10) {
                i = "0" + i
            }; // add zero in front of numbers < 10
            return i;
        }


        @if($message = Session::get('error'))
        toastr.error("{{ $message}}");
        @elseif($message = Session::get('success'))
        toastr.success("{{ $message}}");
        @endif
    </script>

</body>

</html>


@endsection