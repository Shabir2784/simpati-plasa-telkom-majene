@extends('layoutsAdmin.master')

@section('content')

<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800">
        Absensi Teknisi
    </h1>

    {{-- ================= KPI ================= --}}

    <div class="row mt-4">

        {{-- Hadir Hari Ini --}}
        <div class="col-xl-3 col-md-6 mb-4">

            <div class="card border-left-success shadow h-100">

                <div class="card-body">

                    <div class="row align-items-center">

                        <div class="col">

                            <div class="text-xs font-weight-bold text-success text-uppercase mb-2">
                                Hadir Hari Ini
                            </div>

                            <div class="h2 font-weight-bold">
                                {{ $totalHadir }}
                            </div>

                        </div>

                        <div class="col-auto">
                            <i class="fas fa-user-check fa-3x text-success"></i>
                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- Sudah Pulang --}}
        <div class="col-xl-3 col-md-6 mb-4">

            <div class="card border-left-primary shadow h-100">

                <div class="card-body">

                    <div class="row align-items-center">

                        <div class="col">

                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-2">
                                Sudah Pulang
                            </div>

                            <div class="h2 font-weight-bold">
                                {{ $sudahPulang }}
                            </div>

                        </div>

                        <div class="col-auto">
                            <i class="fas fa-sign-out-alt fa-3x text-primary"></i>
                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- Belum Pulang --}}
        <div class="col-xl-3 col-md-6 mb-4">

            <div class="card border-left-warning shadow h-100">

                <div class="card-body">

                    <div class="row align-items-center">

                        <div class="col">

                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-2">
                                Belum Pulang
                            </div>

                            <div class="h2 font-weight-bold">
                                {{ $belumPulang }}
                            </div>

                        </div>

                        <div class="col-auto">
                            <i class="fas fa-clock fa-3x text-warning"></i>
                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- Terlambat --}}
        <div class="col-xl-3 col-md-6 mb-4">

            <div class="card border-left-danger shadow h-100">

                <div class="card-body">

                    <div class="row align-items-center">

                        <div class="col">

                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-2">
                                Terlambat
                            </div>

                            <div class="h2 font-weight-bold">
                                {{ $terlambat }}
                            </div>

                        </div>

                        <div class="col-auto">
                            <i class="fas fa-exclamation-circle fa-3x text-danger"></i>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- ====================================================== --}}
    {{-- TABEL ASSURANCE --}}
    {{-- ====================================================== --}}

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
                            <th>Nama Teknisi</th>
                            <th>Divisi</th>
                            <th>Jam Masuk</th>
                            <th>Jam Keluar</th>
                            <th>Status</th>
                            <th>Durasi</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($assurance as $teknisi)

                            <tr>

                                <td>
                                    {{ $loop->iteration }}
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

                                <td colspan="7" class="text-center">
                                    Belum ada teknisi Assurance.
                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>
     {{-- ====================================================== --}}
    {{-- EXPORT ASSURANCE --}}
    {{-- ====================================================== --}}

    <div class="card shadow mb-4">

        <div class="card-header bg-primary text-white">

            <strong>
                Export Absensi Assurance
            </strong>

        </div>

        <div class="card-body">

            <div class="d-flex">

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


    {{-- ====================================================== --}}
    {{-- TABEL PROVISIONING --}}
    {{-- ====================================================== --}}

    <div class="card shadow mb-4">

        <div class="card-header bg-success text-white">

            <strong>
                Absensi Teknisi - Provisioning
            </strong>

        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-hover">

                    <thead class="thead-light">

                        <tr>

                            <th width="50">No</th>
                            <th>Nama Teknisi</th>
                            <th>Divisi</th>
                            <th>Jam Masuk</th>
                            <th>Jam Keluar</th>
                            <th>Status</th>
                            <th>Durasi</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($provisioning as $teknisi)

                            <tr>

                                <td>
                                    {{ $loop->iteration }}
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

                                <td colspan="7" class="text-center">
                                    Belum ada teknisi Provisioning.
                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>


    {{-- ====================================================== --}}
    {{-- EXPORT PROVISIONING --}}
    {{-- ====================================================== --}}

    <div class="card shadow mb-4">

        <div class="card-header bg-success text-white">

            <strong>
                Export Absensi Provisioning
            </strong>

        </div>

        <div class="card-body">

            <div class="d-flex">

                <a href="{{ route('admin.absensi.provisioning.pdf') }}"
                   class="btn btn-danger mr-2">

                    <i class="fas fa-file-pdf"></i>
                    PDF Provisioning

                </a>

                <a href="{{ route('admin.absensi.provisioning.excel') }}"
                   class="btn btn-success">

                    <i class="fas fa-file-excel"></i>
                    Excel Provisioning

                </a>

            </div>

        </div>

    </div>

</div>

@endsection