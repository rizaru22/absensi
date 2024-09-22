<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Toastr -->
    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <title>Absensi Pegawai</title>
</head>

<body onload="startAll()">
    <header>
        <div class="container-fluid">
            <div class="row d-flex">
                <div class="col-sm-12 text-right">
                    <p class="pt-2 pr-2">
                        <span class="pr-2">{{ $tanggal }}</span>
                        <span class="jam pl-2 pr-2" id="waktu"></span>
                    </p>
                </div>
            </div>

            <div class="row d-flex">
                <div class="col-sm-12 ml-3 info">
                    <h2 class="">
                        {{ Auth::user()->name }}
                    </h2>
                    <p class="nip">{{Auth::user()->nip}}</p>

                </div>
            </div>
            <div class="row d-flex">
                <div class="col-sm-12 ml-3">
                    <div class="logout">
                        <form action="logout" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-outline-success"><i class="fas fa-power-off mr-2"></i>Logout</button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </header>
    <main>
        <div class="container">
            <div class="menu ml-2 mr-2 ">
                <div class="row pl-2 pt-4 pr-2">
                    <div class="col-3">

                        <a href="#" class="item" onclick=" submitForm();"><button class="btn btn-outline-success"><i class="fas fa-sign-in-alt"></i></button><span>Masuk</span></a>
                    </div>
                    <div class="col-3 ">
                        <a href="#" class="item" onclick=" submitFormPulang();"><button class="btn btn-outline-success">
                            <i class="fas fa-sign-out-alt"></i></button><span>Pulang</span>
                        </a>
                    </div>

                    <div class="col-3 "> <a href="{{route('izin')}}" class="item"><button class="btn btn-outline-success"><i class="fas fa-envelope"></i></button><span>Cuti</span></a></div>

                    <div class="col-3 "> <a href="{{route('akun')}}" class="item"><button class="btn btn-outline-success"><i class="fas fa-user-alt"></i></button><span>Akun</span></a></div>
                </div>



            </div>
           
            <div class="row">
                <div class="col-sm-12">
                    <div class="text pt-3">
                        <h4>Rekap absen pekan ini</h4>
                    </div>
                    <table id="example2" class="table table-bordered table-hover dataTable dtr-inline" aria-describedby="example2_info">
                        <thead>
                            <tr>
                                <th class="">Hari</th>
                                <th class="">Jam Masuk</th>
                                <th class="">Jam Pulang</th>
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
                    
                    
                    <td>{{ $daftar_hari[date('l',strtotime($subItem['created_at']))] }}</td>

                        <td>{{ $subItem['jam_masuk'] }}</td>
                        <td>{{ $subItem['jam_pulang'] }}</td>
            
                    </tr>
                   
                @endforeach
                @endforeach
                <tr>
                        <td>Total Jam Per Minggu</td>
                        <td colspan="2">{{ $jamKerjaPerMinggu }} </td>
                    </tr>
                        </tbody>
                    </table>
                </div>
            </div>
           
            <div class="row mt-2 pb-2">
            <div class="col-sm-12 text-center">
                <div class="keterangan" id="keterangan">
                    <a href="#" class="btn btn-sm btn-outline-success"><i class="fas fa-question-circle mr-1"></i>FAQ</a>
                </div>
            </div>
        </div>
            </div>
        </div>

    </main>
<form action="{{ route('masuk') }}" method="POST" name="formJarak">
    @csrf
    <input type="hidden" name="inputJarak" id="inputJarak">
</form>
<form action="{{ route('pulang') }}" method="POST" name="formJarakPulang">
    @csrf
    <input type="hidden" name="inputJarakPulang" id="inputJarakPulang">
</form>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
    <!-- Toastr -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        // const x = document.getElementById("keterangan");
  
        var inputJarak=document.getElementById("inputJarak");
        let latitude;
        let longitude;
        var jarak;
        let latSMK1 = {{$pengaturan[0] -> latitude}};
        let longSMK1 = {{$pengaturan[0] -> longitude}};

        function startAll(){
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
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition);
            } else {
                alert("Geolocation is not supported by this browser.");
            }
        }

        function showPosition(position) {
            latitude = position.coords.latitude;
            longitude = position.coords.longitude;
            alert(latitude+'-'+longitude);
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
            inputJarak.value=jarak;
            inputJarakPulang.value=jarak;
            console.log(jarak)
            // var url = "{{route('masuk',':jarak')}}";
            // url = url.replace(':jarak', jarak);
            // window.location.href = url;
        }

        function submitForm(){
            document.formJarak.submit();
        }
        
        function submitFormPulang(){
            document.formJarakPulang.submit();
        }
 
        @if($message = Session::get('error'))
            toastr.error("{{ $message}}");
        @elseif($message = Session::get('success'))
            toastr.success("{{ $message}}");
        @endif
    </script>

</body>

</html>