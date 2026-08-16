@extends('layoutsAdmin.master')

@section('content')

<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800">
        Absensi Teknisi Assurance
    </h1>

    {{-- KPI --}}
    <div class="row">

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-success text-uppercase mb-2">
                        Hadir Hari Ini
                    </div>
                    <div class="h2 font-weight-bold">
                        {{ $totalHadir }}
                    </div>
                    <i class="fas fa-user-check fa-2x text-gray-300 float-right"></i>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-2">
                        Sudah Pulang
                    </div>
                    <div class="h2 font-weight-bold">
                        {{ $sudahPulang }}
                    </div>
                    <i class="fas fa-sign-out-alt fa-2x text-gray-300 float-right"></i>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-2">
                        Belum Pulang
                    </div>
                    <div class="h2 font-weight-bold">
                        {{ $belumPulang }}
                    </div>
                    <i class="fas fa-clock fa-2x text-gray-300 float-right"></i>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-danger text-uppercase mb-2">
                        Terlambat
                    </div>
                    <div class="h2 font-weight-bold">
                        {{ $terlambat }}
                    </div>
                    <i class="fas fa-exclamation-circle fa-2x text-gray-300 float-right"></i>
                </div>
            </div>
        </div>

    </div>

    {{-- TABEL --}}
    <div class="card shadow mb-4">

        <div class="card-header bg-primary text-white">
            <strong>
                Absensi Teknisi - Assurance
            </strong>
        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-hover">

                    <thead class="thead-light">

                        <tr>
                            <th width="50">No</th>
                            <th>NIK</th>
                            <th>Nama Teknisi</th>
                            <th>Divisi</th>
                            <th>Jam Masuk</th>
                            <th>Jam Keluar</th>
                            <th>Status</th>
                            <th>Durasi</th>
                        </tr>

                    </thead>

                    <tbody>

                    @forelse($teknisis as $teknisi)

                        <tr>

                            <td>
                                {{ $loop->iteration }}
                            </td>

                            <td>
                                {{ $teknisi->nik }}
                            </td>

                            <td>
                                {{ $teknisi->user->nama }}
                            </td>

                            <td>
                                {{ $teknisi->divisi->nama_divisi }}
                            </td>

                            <td>
                                {{ optional($teknisi->absensiHariIni)->jam_masuk ?? '-' }}
                            </td>

                            <td>
                                {{ optional($teknisi->absensiHariIni)->jam_keluar ?? '-' }}
                            </td>

                            <td>

                                @if(!$teknisi->absensiHariIni)

                                    <span class="badge badge-danger">
                                        Belum Hadir
                                    </span>

                                @elseif($teknisi->absensiHariIni->jam_keluar)

                                    <span class="badge badge-success">
                                        Sudah Pulang
                                    </span>

                                @else

                                    <span class="badge badge-warning">
                                        Belum Pulang
                                    </span>

                                @endif

                            </td>

                            <td>

                                @if($teknisi->absensiHariIni && $teknisi->absensiHariIni->jam_keluar)

                                    {{
                                        \Carbon\Carbon::parse($teknisi->absensiHariIni->jam_masuk)
                                        ->diff(
                                            \Carbon\Carbon::parse($teknisi->absensiHariIni->jam_keluar)
                                        )
                                        ->format('%H Jam %I Menit')
                                    }}

                                @elseif($teknisi->absensiHariIni)

                                    Sedang Bekerja

                                @else

                                    -

                                @endif

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="8" class="text-center">
                                Belum ada teknisi Assurance.
                            </td>
                        </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

    {{-- EXPORT --}}
    <div class="card shadow mb-4">

        <div class="card-header bg-primary text-white">
            <strong>Export Absensi Assurance</strong>
        </div>

        <div class="card-body">

            <a href="{{ route('admin.absensi.assurance.pdf') }}"
               class="btn btn-danger mr-2">

                <i class="fas fa-file-pdf"></i>
                PDF Assurance

            </a>

            <a href="{{ route('admin.absensi.assurance.excel') }}"
               class="btn btn-success">

                <i class="fas fa-file-excel"></i>
                Excel Assurance

            </a>

        </div>

    </div>

</div>

@endsection