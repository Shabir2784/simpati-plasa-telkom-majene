<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">

    <title>Laporan Produktivitas Teknisi</title>

    <style>

        body{

            font-family: DejaVu Sans;

            font-size:12px;

        }

        h2{

            text-align:center;

            margin-bottom:5px;

        }

        p{

            text-align:center;

            margin-top:0;

            margin-bottom:20px;

        }

        table{

            width:100%;

            border-collapse:collapse;

        }

        table th,
        table td{

            border:1px solid #000;

            padding:6px;

            font-size:11px;

        }

        table th{

            background:#f2f2f2;

        }

    </style>

</head>

<body>

<h2>

    LAPORAN PRODUKTIVITAS TEKNISI

</h2>

<p>

    Dicetak :
    {{ now()->format('d-m-Y H:i') }}

</p>

<table>

    <thead>

        <tr>

            <th>No</th>

            <th>Tanggal</th>

            <th>Teknisi</th>

            <th>Divisi</th>

            <th>No Tiket</th>

            <th>Pelanggan</th>

            <th>Jenis</th>

            <th>Durasi</th>

            <th>Status</th>

        </tr>

    </thead>

    <tbody>

        @foreach($laporans as $laporan)

        <tr>

            <td>

                {{ $loop->iteration }}

            </td>

            <td>

                {{ \Carbon\Carbon::parse($laporan->tanggal)->format('d-m-Y') }}

            </td>

            <td>

                {{ $laporan->user->nama }}

            </td>

            <td>

                {{ optional($laporan->user->teknisi->divisi)->nama_divisi }}

            </td>

            <td>

                {{ $laporan->nomor_tiket }}

            </td>

            <td>

                {{ $laporan->nama_pelanggan }}

            </td>

            <td>

                {{ $laporan->jenis_pekerjaan }}

            </td>

            <td>

                {{ $laporan->durasi }}

                Menit

            </td>

            <td>

                {{ ucfirst($laporan->status) }}

            </td>

        </tr>

        @endforeach

    </tbody>

</table>

</body>

</html>