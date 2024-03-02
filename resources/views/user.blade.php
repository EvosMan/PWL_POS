<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data User</title>
</head>
<body>
    <h1>Data User</h1>
    <table border="1" cellpadding="2" cellspacing="0">
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Nama</th>
            <th>ID Level Pengguna</th>
        </tr>
        @foreach ( $data as $d )
        <tr>
            <td><center>{{$d->user_id}}</center></td>
            <td>{{$d->username}}</td>
            <td>{{$d->nama}}</td>
            <td><center>{{$d->level_id}}</center></td>
        </tr>
        @endforeach
    </table>
</body>
</html>