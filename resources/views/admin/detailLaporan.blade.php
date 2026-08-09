@extends('layoutsAdmin.master')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h1 class="h3 text-gray-800">
            Detail Laporan Pekerjaan
        </h1>

        <a href="{{ route('admin.laporan') }}"
           class="btn btn-secondary">

            <i class="fas fa-arrow-left"></i>
            Kembali

        </a>

    </div>


    <div class="card shadow mb-4">

        <div class="card-header bg-primary text-white">

            <strong>
                Informasi Pekerjaan
            </strong>

        </div>

        <div class="card-body">

            <div class="row">

                <div class="col-md-6">

                    <table class="table table-borderless">

                        <tr>
                            <th width="180">Tanggal</th>
                            <td>
                                {{ \Carbon\Carbon::parse($pekerjaan->tanggal)->format('d-m-Y') }}
                            </td>
                        </tr>

                        <tr>
                            <th>Teknisi</th>
                            <td>
                                {{ optional($pekerjaan->user)->nama ?? '-' }}
                            </td>
                        </tr>

                        <tr>
                            <th>Divisi</th>
                            <td>
                                {{ optional(optional($pekerjaan->user)->teknisi->divisi)->nama_divisi ?? '-' }}
                            </td>
                        </tr>

                        <tr>
                            <th>Nomor Tiket</th>
                            <td>
                                {{ $pekerjaan->nomor_tiket ?? '-' }}
                            </td>
                        </tr>

                        <tr>
                            <th>Nomor WO</th>
                            <td>
                                {{ $pekerjaan->nomor_wo ?? '-' }}
                            </td>
                        </tr>

                        <tr>
                            <th>Nomor Referensi</th>
                            <td>
                                {{ $pekerjaan->nomor_referensi ?? '-' }}
                            </td>
                        </tr>

                        <tr>
                            <th>Jenis Referensi</th>
                            <td>
                                {{ $pekerjaan->jenis_referensi ?? '-' }}
                            </td>
                        </tr>

                    </table>

                </div>


                <div class="col-md-6">

                    <table class="table table-borderless">

                        <tr>
                            <th width="180">Pelanggan</th>
                            <td>
                                {{ $pekerjaan->nama_pelanggan ?? '-' }}
                            </td>
                        </tr>

                        <tr>
                            <th>Alamat Pelanggan</th>
                            <td>
                                {{ $pekerjaan->alamat_pelanggan ?? '-' }}
                            </td>
                        </tr>

                        <tr>
                            <th>Jenis Pekerjaan</th>
                            <td>
                                {{ $pekerjaan->jenis_pekerjaan ?? '-' }}
                            </td>
                        </tr>

                        <tr>
                            <th>Jam Selesai</th>
                            <td>
                                {{ $pekerjaan->jam_selesai ?? '-' }}
                            </td>
                        </tr>

                        <tr>
                            <th>Durasi</th>
                            <td>
                                {{ $pekerjaan->durasi ?? '-' }}

                                @if($pekerjaan->durasi)
                                    Menit
                                @endif
                            </td>
                        </tr>

                        <tr>
                            <th>Status</th>
                            <td>

                                @if($pekerjaan->status == 'selesai')

                                    <span class="badge badge-success">
                                        Selesai
                                    </span>

                                @else

                                    <span class="badge badge-warning">
                                        Pending
                                    </span>

                                @endif

                            </td>
                        </tr>

                    </table>

                </div>

            </div>

        </div>

    </div>


    <div class="card shadow mb-4">

        <div class="card-header bg-info text-white">

            <strong>
                Deskripsi Pekerjaan
            </strong>

        </div>

        <div class="card-body">

            {{ $pekerjaan->deskripsi ?? '-' }}

        </div>

    </div>


    @if($pekerjaan->foto)

    <div class="card shadow mb-4">

        <div class="card-header bg-success text-white">

            <strong>
                Foto Pekerjaan
            </strong>

        </div>

        <div class="card-body text-center">

            <img src="{{ asset('storage/' . $pekerjaan->foto) }}"
                 class="img-fluid rounded"
                 style="max-height:500px;">

        </div>

    </div>

    @endif

</div>

@endsection