<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengguna</title>
</head>
<body>
    <a href="{{route('pengguna.create')}}" >Create</a>
    <a href="{{route('pengguna.show','4')}}" >Cek pass</a>

    <br>
    @foreach($data as $dt)
        <p>{{$dt->name}}-{{$dt->email}}</p>
    @endforeach
</body>
</html>