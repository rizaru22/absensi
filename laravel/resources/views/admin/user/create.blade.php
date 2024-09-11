<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="{{route('pengguna.store')}}" method="post">
        @csrf
        <input type="text" name="name" id="name" placeholder="Nama">
        <input type="text" name="username" id="username" placeholder="nama.pengguna">
        <input type="text" name="nip" id="nip" placeholder="NIP">
        <input type="password" name="password" id="password" placeholder="">
        <input type="email" name="email" id="email" placeholder="jhondoe@gmail.com">
        <input type="submit" value="Simpan">
    </form>
</body>
</html>