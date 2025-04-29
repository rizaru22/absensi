<!DOCTYPE html>
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
  <meta name="keywords" content="Aplikasi Absensi Online, Absensi Online, Absensi, Absensi SMK, Absensi SMK Negeri 1 Karang Baru, Absensi SMK Negeri 1 Karang Baru">
  <meta name="description" content="Aplikasi Absensi Online SMK Negeri 1 Karang Baru">
  <meta name="author" content="SAFRIZAL">

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="{{asset('css/font.css')}}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
  <link rel="icon" href="{{asset('img/favicon.ico')}}">
  <link rel="shortcut icon" href="{{asset('img/icon3.ico')}}">
  <link rel="apple-touch-icon" href="{{asset('img/apple-touch-icon.png')}}" />
  <style>
    .btn-primary {
      background-color: #00A693 !important;
      border-color: #00A693 !important;
    }

    .text-logo {
      color: #00A693;
      font-weight: bold;
    }

    .card-primary.card-outline {
      border-top: 3px solid #00A693 !important;
    }
  </style>
  <title>Login Hadirin</title>
</head>

<body class="hold-transition login-page">

@if(Auth::user())
  @if(Auth::user()->role=='admin')
  <script>
    window.location="/admin";
  </script>
  @else
  <script>
    window.location="/pegawai";
  </script>
  @endif
@endif


  <div class="login-box">

    <!-- /.login-logo -->
    <div class="card card-outline card-primary">
      <div class="card-header text-center">
        <h3> <img src="{{asset('img/apple-touch-icon.png')}}" alt="" width="50" height="50"> Hadir<span class="text-logo">In</span></h3>
      </div>
      <div class="card-body login-card-body">

        @if(session()->has('loginError'))
        <div class="alert alert-danger alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
          <h5><i class="icon fas fa-ban"></i> Alert!</h5>
          {{ session('loginError') }}
        </div>
        @endif

        <form action="{{ route('postlogin')}}" method="post">
          @csrf
          <div class="input-group mb-3">
            <input type="text" class="form-control" id="username" name="username" placeholder="Username" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" id="showpassword" name="showpassword" onclick="showPassword()">
              <label class="form-check-label">Lihat Password</label>
            </div>

          </div>
          <div class="row">
            <div class="col-12">
              <button type="submit" class="btn btn-primary btn-lg btn-block"><i class="fas fa-user-check"></i> Sign In</button>
            </div>

          </div>
        </form>

      </div>
      <!-- /.login-card-body -->
    </div>
  </div>
  <!-- /.login-box -->






  <!-- jQuery -->
  <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
  <!-- Bootstrap 4 -->
  <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <!-- AdminLTE App -->
  <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
  <script>
    function showPassword() {
      var x = document.getElementById("password");
      if (x.type === "password") {
        x.type = "text";
      } else {
        x.type = "password";
      }
    }
  </script>
</body>

</html>