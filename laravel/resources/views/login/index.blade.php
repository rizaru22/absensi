<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/fotomasuk.css') }}">
<style>

</style>
    <title>Login</title>
</head>
<body>
    <div class="container">
        <div class="row h-100">
            <div class="col-sm-12 align-self-center">
                <div class="card card-block w-70 mx-auto">
                    <div class="card-header">
                        Login
                    </div>
                    <div class="card-body">
                    @if(session()->has('loginError'))
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h5><i class="icon fas fa-ban"></i> Alert!</h5>
                    {{ session('loginError') }}
                </div>
                @endif
                <form action="{{ route('postlogin')}}" method="POST">
        @csrf
        <div class="form-group">
        <label for="username">Username:</label>
        <input type="text" class="form-control" name="username" id="username" placeholder="Username" required>
        </div>
        <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
        </div>
        
                    </div>
                    <div class="card-footer text-right">
                    <button type="submit" class="btn btn-success"><i class="fas fa-envelope"></i> Login</button>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
        
        
       
 

    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>

</body>
</html> 