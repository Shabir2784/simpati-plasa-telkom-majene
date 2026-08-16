<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">

    <title>Laporan {{ $divisi->nama_divisi }}</title>

    <style>

        body {
            font-family: DejaVu Sans;
            font-size: 10px;
        }

        h2 {
            text-align: center;
            margin-bottom: 5px;
        }

        h3 {
            text-align: center;
            margin-top: 0;
            margin-bottom: 5px;
        }

        p {
            text-align: center;
            margin-top: 0;
            margin-bottom: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th,
        table td {
            border: 1px solid #000;
            padding: 5px;
            font-size: 9px;
        }

        table th {
            background: #f2f2f2;
            text-align: center;
        }

        table td {
            vertical-align: middle;
        }

        .center {
            text-align: center;
        }

        .selesai {
            color: green;
            font-weight: bold;
        }

        .pending {
            color: orange;
            font-weight: bold;
        }

    </style>

</head>

<body>

<h2>
    LAPORAN PRODUKTIVITAS TEKNISI
</h2>

<h3>
    DIVISI {{ strtoupper($divisi->nama_divisi) }}
</h3>

<p>
    Periode:
    {{ $periodeLabel ?? '-' }}
    <br>

    Dicetak:
    {{ now()->format('d-m-Y H:i') }}
</p>


<table>

    <thead>

        <tr>

            <th>No</th>

            <th>Tanggal</th>

            <th>Teknisi</th>


            {{-- ASSURANCE --}}

            @if($divisi->nama_divisi == 'Assurance')

                <th>Nomor Tiket</th>

                <th>ALPRO</th>

                <th>Pelanggan</th>

                <th>Jenis Pekerjaan</th>

                <th>Jam Selesai</th>

                <th>Status</th>


            {{-- PROVISIONING --}}

            @elseif($divisi->nama_divisi == 'Provisioning')

                <th>Nomor WO</th>

                <th>SC Order</th>

                <th>ALPRO</th>

                <th>Segmen</th>

                <th>Pelanggan</th>

                <th>Jenis Pekerjaan</th>

                <th>Jam Selesai</th>

                <th>Status</th>

            @endif

        </tr>

    </thead>


    <tbody>

        @forelse($laporans as $laporan)

            <tr>

                <td class="center">
                    {{ $loop->iteration }}
                </td>


                <td class="center">

                    {{ $laporan->tanggal
                        ? \Carbon\Carbon::parse($laporan->tanggal)->format('d-m-Y')
                        : '-' }}

                </td>


                <td>

                    {{ optional($laporan->user)->nama ?? '-' }}

                </td>


                {{-- ============================= --}}
                {{-- ASSURANCE --}}
                {{-- ============================= --}}

                @if($divisi->nama_divisi == 'Assurance')

                    <td>
                        {{ $laporan->nomor_tiket ?? '-' }}
                    </td>

                    <td>
                        {{ $laporan->alpro ?? '-' }}
                    </td>

                    <td>
                        {{ $laporan->nama_pelanggan ?? '-' }}
                    </td>

                    <td>
                        {{ $laporan->jenis_pekerjaan ?? '-' }}
                    </td>

                    <td class="center">
                        {{ $laporan->jam_selesai ?? '-' }}
                    </td>

                    <td class="center">

                        @if($laporan->status == 'selesai')

                            <span class="selesai">
                                Selesai
                            </span>

                        @else

                            <span class="pending">
                                Pending
                            </span>

                        @endif

                    </td>


                {{-- ============================= --}}
                {{-- PROVISIONING --}}
                {{-- ============================= --}}

                @elseif($divisi->nama_divisi == 'Provisioning')

                    <td>
                        {{ $laporan->nomor_wo ?? '-' }}
                    </td>

                    <td>
                        {{ $laporan->sc_order ?? '-' }}
                    </td>

                    <td>
                        {{ $laporan->alpro ?? '-' }}
                    </td>

                    <td>
                        {{ $laporan->segmen ?? '-' }}
                    </td>

                    <td>
                        {{ $laporan->nama_pelanggan ?? '-' }}
                    </td>

                    <td>
                        {{ $laporan->jenis_pekerjaan ?? '-' }}
                    </td>

                    <td class="center">
                        {{ $laporan->jam_selesai ?? '-' }}
                    </td>

                    <td class="center">

                        @if($laporan->status == 'selesai')

                            <span class="selesai">
                                Selesai
                            </span>

                        @else

                            <span class="pending">
                                Pending
                            </span>

                        @endif

                    </td>

                @endif

            </tr>

        @empty

            <tr>

                <td
                    colspan="{{ $divisi->nama_divisi == 'Assurance' ? 9 : 11 }}"
                    class="center">

                    Tidak ada data laporan.

                </td>

            </tr>

        @endforelse

    </tbody>

</table>

</body>

</html>