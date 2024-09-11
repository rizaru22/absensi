<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
</head>
<body>
@if(session()->has('loginError'))
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h5><i class="icon fas fa-ban"></i> Alert!</h5>
                    {{ session('loginError') }}
                </div>
                @endif
    <form action="{{ route('postlogin')}}" method="POST">
        @csrf
        <input type="text" name="username" id="username" autofocus required>
        <input type="password" name="password" id="password" required>
        <input type="submit" value="Login">
    </form>
</body>
</html>