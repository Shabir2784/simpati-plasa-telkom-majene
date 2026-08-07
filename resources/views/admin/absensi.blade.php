@extends('layoutsAdmin.master')

@section('content')

<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800">
        Absensi Teknisi
    </h1>

    <!-- KPI -->

    <div class="row mt-4">

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

    <div class="card shadow mb-4">

    <div class="card-header py-3 d-flex justify-content-between align-items-center">

        <h6 class="m-0 font-weight-bold text-primary">
            Data Absensi Teknisi Hari Ini
        </h6>

        <span class="badge badge-primary">
            {{ $teknisis->count() }} Teknisi
        </span>

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

                        <th>Lokasi</th>

                        <th>Durasi</th>

                        <th width="100">Aksi</th>

                    </tr>

                </thead>

                <tbody>

                    @foreach($teknisis as $teknisi)

                    <tr>

                        <td>{{ $loop->iteration }}</td>

                        <td>{{ $teknisi->user->nama }}</td>

                        <td>{{ $teknisi->divisi->nama_divisi }}</td>

                        <td>
                            {{ optional($teknisi->absensi)->jam_masuk ?? '-' }}
                        </td>

                        <td>
                            {{ optional($teknisi->absensi)->jam_keluar ?? '-' }}
                        </td>

                        <td>

                            @if(!$teknisi->absensi)

                                <span class="badge badge-danger">
                                    Belum Hadir
                                </span>

                            @elseif($teknisi->absensi->jam_keluar)

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

                            @if($teknisi->absensi)
                                
                                <a href=""
                                    class="btn btn-info btn-sm">

                                    <i class="fas fa-map-marker-alt"></i>

                                    Lihat

                                </a>

                            @else

                                -

                            @endif

                        </td>

                        <td>

                            @if($teknisi->absensi && $teknisi->absensi->jam_keluar)

                                {{
                                    \Carbon\Carbon::parse($teknisi->absensi->jam_masuk)
                                    ->diff(
                                        \Carbon\Carbon::parse($teknisi->absensi->jam_keluar)
                                    )
                                    ->format('%H Jam %I Menit')
                                }}

                            @elseif($teknisi->absensi)

                                Sedang Bekerja

                            @else

                                -

                            @endif

                        </td>

                        <td>

                            @if($teknisi->absensi)

                                <a href="#"
                                   class="btn btn-primary btn-sm">

                                    <i class="fas fa-eye"></i>

                                    Detail

                                </a>

                            @else

                                -

                            @endif

                        </td>

                    </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    </div>
    <div class="d-flex justify-content-end mb-3">

    <a href="{{ route('admin.absensi.pdf') }}"
       class="btn btn-danger mr-2">

        <i class="fas fa-file-pdf"></i>

        Export PDF

    </a>

    <a href="{{ route('admin.absensi.excel') }}"
       class="btn btn-success">

        <i class="fas fa-file-excel"></i>

        Export Excel

    </a>

</div>

</div>

    
</div>


@endsection