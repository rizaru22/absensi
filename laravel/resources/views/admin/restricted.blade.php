<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Lockscreen</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
  <link rel="icon" href="{{asset('img/favicon.ico')}}">
</head>

<body class="hold-transition lockscreen">
  <!-- Automatic element centering -->
  <div class="lockscreen-wrapper">
    <div class="lockscreen-logo">
      <a href="../../index2.html"><b>Teacher</b>Attendance</a>
    </div>
    <!-- User name -->
    <div class="lockscreen-name">{{Auth::user()->name}}</div>




  </div>
  <!-- /.lockscreen-item -->
  <div class="help-block text-center">
    You don't have access to this page. Please
    <a href="{{route('pegawai')}}">return</a> and log out first.
  </div>


  <div class="lockscreen-footer text-center">
    Copyright &copy; 2024 <b><a href="#" class="text-black">teacher-attendance</a></b><br>
    All rights reserved
  </div>
  </div>
  <!-- /.center -->

  <!-- jQuery -->
  <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
  <!-- Bootstrap 4 -->
  <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>