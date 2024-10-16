<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="refresh" content="300">

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('dist/css/adminlte.css') }}">
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
  </style>
  <title>Login Hadirin</title>
</head>

<body class="hold-transition login-page">
  <div class="login-box">

    <!-- /.login-logo -->
    <div class="card card-outline card-primary">
      <div class="card-header text-center">
      <h3> <img src="{{asset('img/android-chrome-512x512.png')}}" alt="" width="50px"> Hadir<span class="text-logo">In</span></h3>
      </div>
      <div class="card-body login-card-body">
        <p class="login-box-msg">Login untuk menggunakan aplikasi</p>
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
          <div class="row">
            <div class="col-8">

            </div>
            <!-- /.col -->
            <div class="col-4">
              <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-user-check"></i> Sign In</button>
            </div>
            <!-- /.col -->
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
</body>

</html>