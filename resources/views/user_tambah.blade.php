<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Form Tambah Data User</h1>
    <form action="/user/tambah_simpan" method="post"></form>

    {{csrf_field()}}

    <label for="">Username</label>
    <input type="text" name="username" placeholder="Masukkan Username" id="">
    <br>
    <label for="">Nama</label>
    <input type="text" name="nama" placeholder="Masukkan Nama" id="">
    <br>
    <label for="">Password</label>
    <input type="text" name="password" placeholder="Masukkan Password" id="">
    <br>
    <label for="">Level ID</label>
    <input type="text" name="level_id"  placeholder="Masukkan ID Level">
    <br><br>
    <input type="submit" class="" value="Simpan">


</body>
</html>