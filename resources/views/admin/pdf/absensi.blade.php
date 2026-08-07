<!DOCTYPE html>
<html>

<head>

<meta charset="utf-8">

<style>

body{
    font-family: DejaVu Sans;
    font-size:12px;
}

table{
    width:100%;
    border-collapse:collapse;
}

table,th,td{
    border:1px solid black;
}

th,td{
    padding:6px;
    text-align:center;
}

h2{
    text-align:center;
}

</style>

</head>

<body>

<h2>Laporan Absensi Teknisi</h2>

<p>Tanggal : {{ now()->format('d-m-Y') }}</p>

<table>

<thead>

<tr>

<th>No</th>
<th>Nama</th>
<th>Masuk</th>
<th>Keluar</th>
<th>Status</th>

</tr>

</thead>

<tbody>

@foreach($absensis as $item)

<tr>

<td>{{ $loop->iteration }}</td>

<td>{{ $item->user->nama }}</td>

<td>{{ $item->jam_masuk }}</td>

<td>{{ $item->jam_keluar }}</td>

<td>{{ $item->status }}</td>

</tr>

@endforeach

</tbody>

</table>

</body>

</html>