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
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <title>Absensi Pegawai</title>
</head>

<body onload="startTime()">
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
        </div>
    </header>
    <main>
        <div class="container">
            <div class="menu ml-2 mr-2 ">
                <div class="row pl-2 pt-4 pr-2">
                    <div class="col-4">
                        <a href="#" class="item"><button class="btn btn-outline-success"><i class="fas fa-sign-in-alt"></i></button><span>Masuk</span></a>
                    </div>
                    <div class="col-4 "> <a href="#" class="item"><button class="btn btn-outline-success"><i class="fas fa-sign-out-alt"></i></button><span>Pulang</span></a></div>
                    <div class="col-4 "> <a href="#" class="item"><button class="btn btn-outline-success"><i class="fas fa-envelope"></i></button><span>Cuti</span></a></div>
                </div>



            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="text pt-3">
                        <h4>Rekap absen minggu ini</h4>
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
                            <tr class="odd">
                                <td class="" tabindex="0">Senin</td>
                                <td>Firefox 1.0</td>
                                <td>Win 98+ / OSX.2+</td>

                            </tr>
                            <tr class="even">
                                <td class="" tabindex="0">Senin</td>
                                <td>Firefox 1.5</td>
                                <td>Win 98+ / OSX.2+</td>

                            </tr>
                            <tr class="odd">
                                <td class="" tabindex="0">Senin</td>
                                <td>Firefox 2.0</td>
                                <td>Win 98+ / OSX.2+</td>

                            </tr>
                            <tr class="even">
                                <td class="" tabindex="0">Senin</td>
                                <td>Firefox 3.0</td>
                                <td>Win 2k+ / OSX.3+</td>

                            </tr>
                            <tr class="odd">
                                <td class="">Senin</td>
                                <td>Camino 1.0</td>
                                <td>OSX.2+</td>
                            </tr>
                            <tr class="odd">
                                <td class="">Senin</td>
                                <td>Camino 1.0</td>
                                <td>OSX.2+</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="logout text-center pb-3">
            <form action="logout" method="POST">
                @csrf
                <button type="submit" class="btn btn-sm btn-outline-success"><i class="fas fa-power-off mr-2"></i>Logout</button>
            </form>
        </div>
    </main>


    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>

    <script>
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
    </script>
</body>

</html>