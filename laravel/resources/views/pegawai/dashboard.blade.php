@extends('layouts.pegawai')
@section('style')
<!-- Toastr -->
<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.css">

@endsection
@section('title','HadirIn')

@section('konten')






<body onload="startAll()">
    <div id="body">
        <header>
            <div class="container-fluid">
                <div class="row d-flex">
                    <div class="col-sm-12 text-end">
                        <p class="pt-2 pr-2">
                            <span class="pr-2">{{ $tanggal }}</span>
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
                                        <a href="#" class="d-flex flex-column align-items-center">
                                            <button class="btn btn-danger btn-red btn-lg">
                                                <i class="fas fa-camera"></i>
                                            </button>
                                            <span class="text-black">Absen</span>
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
                            <h5>00:00:00</h5>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card card-blue card-borderless pt-3 pb-3 text-light card-header-center">
                            Absen Pulang
                            <h5>00:00:00</h5>
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

    <form action="{{ route('masuk') }}" method="POST" name="formJarak">
        @csrf
        <input type="hidden" name="inputJarak" id="inputJarak">
    </form>
    <form action="{{ route('pulang') }}" method="POST" name="formJarakPulang">
        @csrf
        <input type="hidden" name="inputJarakPulang" id="inputJarakPulang">
    </form>
    @endsection
    @section('script')

    <!-- <script src="{{asset('dist/js/detect.js')}}"></script> -->
    <!-- Toastr -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        // const x = document.getElementById("keterangan");

        var inputJarak = document.getElementById("inputJarak");
        var inputJarakPulang = document.getElementById("inputJarakPulang");
        let latitude;
        let longitude;
        var jarak;
        let latSMK1 = {{$pengaturan[0]->latitude}};
        let longSMK1 = {{$pengaturan[0]->longitude}};

        function startAll() {
            startTime();
            getLocation();
        }

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



        function getLocation() {
            // alert('getlocation');
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition, showError);
            } else {
                alert("Geolocation is not supported by this browser.");
            }
        }

        function showError(error) {
            switch (error.code) {
                case error.PERMISSION_DENIED:
                    alert("Peramban yang anda gunakan tidak mengizinkan deteksi lokasi.");
                    break;
                case error.POSITION_UNAVAILABLE:
                    alert("Informasi Lokasi tidak tersedia");
                    break;
                case error.TIMEOUT:
                    alert("Permintaan untuk mendapatkan lokasi pengguna telah habis waktunya.");
                    break;
                case error.UNKNOWN_ERROR:
                    alert("Error tidak diketahui");
                    break;
            }
        }

        function showPosition(position) {
            latitude = position.coords.latitude;
            longitude = position.coords.longitude;
            // alert(latitude+'-'+longitude);
            // document.getElementById('Latitude').innerHTML="Latitude: " +latitude
            // document.getElementById('Longitude').innerHTML="Longitude: " +longitude
            hitungjarak(latSMK1, longSMK1, latitude, longitude);
        }

        function hitungjarak(lat1, long1, lat2, long2, unit = 'kilometers') {
            console.log(lat1, long1, lat2, long2, unit);
            let theta = long1 - long2;
            let distance = 60 * 1.1515 * (180 / Math.PI) * Math.acos(
                Math.sin(lat1 * (Math.PI / 180)) * Math.sin(lat2 * (Math.PI / 180)) + Math.cos(lat1 * (Math.PI / 180)) * Math.cos(lat2 * (Math.PI / 180)) * Math.cos(theta * (Math.PI / 180))
            );
            if (unit == 'miles') {
                jarak = Math.round(distance);

            } else if (unit == 'kilometers') {
                jarak = Math.round(distance * 1.609344 * 1000);
            }
            inputJarak.value = jarak;
            inputJarakPulang.value = jarak;

            // document.getElementById('Jarak').innerHTML="Jarak: " +inputJarakPulang.value+" meter"
            // console.log(jarak)
            // var url = "{{route('masuk',':jarak')}}";
            // url = url.replace(':jarak', jarak);
            // window.location.href = url;
        }

        function submitForm() {
            document.formJarak.submit();
        }

        function submitFormPulang() {
            document.formJarakPulang.submit();
        }

        @if($message = Session::get('error'))
        toastr.error("{{ $message}}");
        @elseif($message = Session::get('success'))
        toastr.success("{{ $message}}");
        @endif

        @if($errors->any())
        $('#ModalError').modal('show');
        @endif
    </script>

</body>

</html>


@endsection