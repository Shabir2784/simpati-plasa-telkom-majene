@extends('layoutsAdmin.master')

@section('content')

<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800">
        Detail Monitoring Teknisi
    </h1>

    {{-- INFORMASI TEKNISI --}}
    <div class="card shadow mb-4">

        <div class="card-header bg-primary text-white">
            <strong>Informasi Teknisi</strong>
        </div>

        <div class="card-body">

            <div class="row">

                <div class="col-md-6 mb-3">
                    <strong>Nama Teknisi</strong>
                    <div>{{ $teknisi->user->nama }}</div>
                </div>

                <div class="col-md-6 mb-3">
                    <strong>NIK</strong>
                    <div>{{ $teknisi->nik }}</div>
                </div>

                <div class="col-md-6 mb-3">
                    <strong>Divisi</strong>
                    <div>{{ $teknisi->divisi->nama_divisi }}</div>
                </div>

                <div class="col-md-6 mb-3">
                    <strong>No HP</strong>
                    <div>{{ $teknisi->no_hp }}</div>
                </div>

            </div>

        </div>

    </div>


    {{-- PRODUKTIVITAS --}}
    <div class="row mb-4">

        <div class="col-md-4">

            <div class="card border-left-primary shadow">

                <div class="card-body">

                    <div class="text-xs font-weight-bold text-primary text-uppercase">
                        Target Hari Ini
                    </div>

                    <div class="h3 mb-0">
                        {{ $target }}
                    </div>

                </div>

            </div>

        </div>

        <div class="col-md-4">

            <div class="card border-left-success shadow">

                <div class="card-body">

                    <div class="text-xs font-weight-bold text-success text-uppercase">
                        Pekerjaan Hari Ini
                    </div>

                    <div class="h3 mb-0">
                        {{ $jumlah }}
                    </div>

                </div>

            </div>

        </div>

        <div class="col-md-4">

            <div class="card border-left-warning shadow">

                <div class="card-body">

                    <div class="text-xs font-weight-bold text-warning text-uppercase">
                        Progress
                    </div>

                    <div class="progress mt-2">

                        <div class="progress-bar bg-success"
                             style="width: {{ $persen }}%">

                            {{ round($persen) }}%

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- PEKERJAAN HARI INI --}}
    <div class="card shadow mb-4">

        <div class="card-header bg-primary text-white">
            <strong>Pekerjaan Hari Ini</strong>
        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-hover">

                    <thead class="thead-light">

                        <tr>
                            <th>No</th>
                            <th>Referensi</th>
                            <th>Nama Pelanggan</th>
                            <th>Jenis Pekerjaan</th>
                            <th>Status</th>
                            <th>Jam Selesai</th>
                        </tr>

                    </thead>

                    <tbody>

                    @forelse($pekerjaans as $pekerjaan)

                        <tr>

                            <td>{{ $loop->iteration }}</td>

                            <td>
                                {{ $teknisi->divisi->nama_divisi == 'Assurance'
                                    ? $pekerjaan->nomor_tiket
                                    : $pekerjaan->nomor_wo }}
                            </td>

                            <td>
                                {{ $pekerjaan->nama_pelanggan }}
                            </td>

                            <td>
                                {{ $pekerjaan->jenis_pekerjaan }}
                            </td>

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

                            <td>
                                {{ $pekerjaan->jam_selesai ?? '-' }}
                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="6" class="text-center">
                                Belum ada pekerjaan hari ini.
                            </td>

                        </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>


    <a href="{{ url()->previous() }}"
       class="btn btn-secondary">

        <i class="fas fa-arrow-left"></i>
        Kembali

    </a>

</div>

@endsection