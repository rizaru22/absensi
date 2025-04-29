<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta name="theme-color" content="#00A693">
    <meta name="msapplication-TileColor" content="#00A693">
    <meta name="msapplication-navbutton-color" content="#00A693">
    <meta name="apple-mobile-web-app-status-bar-style" content="#00A693">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name=”robots” content="index, follow">
    <meta name="keywords"
        content="Aplikasi Absensi Online, Absensi Online, Absensi, Absensi SMK, Absensi SMK Negeri 1 Karang Baru, Absensi SMK Negeri 1 Karang Baru">
    <meta name="description" content="Aplikasi Absensi Online SMK Negeri 1 Karang Baru">
    <meta name="author" content="SAFRIZAL">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{asset('bootstrap/css/bootstrap.min.css')}}">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="icon" href="{{asset('img/favicon.ico')}}">
    <link rel="shortcut icon" href="{{ asset('img/icon3.ico') }}">
    <link rel="apple-touch-icon" href="{{ asset('img/apple-touch-icon.png') }}" />
    @yield('style')
    <title>@yield('title')</title>
</head>

<body>
    <div class="wrapper">
        @yield('konten')
        <footer>
            <div class="container">
                <div class="d-flex flex-row mb-1 justify-content-center">
                    <div class="p-2">
                        <a href="{{route('pegawai')}}" class="item">
                            <button class="btn btn-outline-success">
                                <i class="fas fa-home"></i></button>
                            <br>
                            <span>Beranda</span></a>
                    </div>
                    <div class="p-2">
                        <a href="#" class="item">
                            <button class="btn btn-outline-success">
                                <i class="fas fa-scroll"></i>
                            </button><br>
                            <span>Rekap</span>
                        </a>
                    </div>
                    <div class="p-2">
                        <a href="https://www.google.com/maps/?q={{ $pengaturan[0]->latitude }},{{ $pengaturan[0]->longitude }}"
                            class="item" target="_blank"><button class="btn btn-outline-success">
                                <i class="fas  fa-map-marker-alt"></i></button><br><span>Lokasi</span>
                        </a>
                    </div>
                    <div class="p-2"> <a href="{{route('faq')}}" class="item"><button class="btn btn-outline-success"><i
                                    class="fas fa-question"></i></button><br><span>FAQ</span></a>
                    </div>
                    <div class="p-2">
                        <form action="{{route('logout')}}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger"><i
                                    class="fas fa-power-off"></i></button><br><span class="text-red">Logout</span>
                        </form>
                    </div>
                </div>
            </div>
    </div>
    </footer>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="{{asset('bootstrap/js/bootstrap.bundle.min.js')}}"></script>

    @yield('script')

</body>

</html>