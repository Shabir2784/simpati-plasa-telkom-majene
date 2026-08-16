@extends('layoutsAdmin.master')

@section('content')

<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800">
        Monitoring Teknisi Assurance
    </h1>

    <div class="row mb-4">

        <div class="col-xl-3 col-md-6 mb-3">

            <div class="card border-left-primary shadow h-100">

                <div class="card-body">

                    <div class="row align-items-center">

                        <div class="col">

                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Teknisi
                            </div>

                            <div class="h2 font-weight-bold">
                                {{ $teknisis->count() }}
                            </div>

                        </div>

                        <div class="col-auto">

                            <i class="fas fa-users fa-3x text-gray-300"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        <div class="col-xl-3 col-md-6 mb-3">

            <div class="card border-left-success shadow h-100">

                <div class="card-body">

                    <div class="row align-items-center">

                        <div class="col">

                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Online
                            </div>

                            <div class="h2 font-weight-bold">
                                {{ $totalOnline }}
                            </div>

                        </div>

                        <div class="col-auto">

                            <i class="fas fa-signal fa-3x text-gray-300"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        <div class="col-xl-3 col-md-6 mb-3">

            <div class="card border-left-danger shadow h-100">

                <div class="card-body">

                    <div class="row align-items-center">

                        <div class="col">

                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Offline
                            </div>

                            <div class="h2 font-weight-bold">
                                {{ $totalOffline }}
                            </div>

                        </div>

                        <div class="col-auto">

                            <i class="fas fa-user-slash fa-3x text-gray-300"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        <div class="col-xl-3 col-md-6 mb-3">

            <div class="card border-left-warning shadow h-100">

                <div class="card-body">

                    <div class="row align-items-center">

                        <div class="col">

                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Target Tercapai
                            </div>

                            <div class="h2 font-weight-bold">
                                {{ $targetTercapai }}
                            </div>

                        </div>

                        <div class="col-auto">

                            <i class="fas fa-award fa-3x text-gray-300"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>


    <div class="card shadow mb-4">

        <div class="card-header bg-primary text-white">

            <strong>
                Monitoring Teknisi Assurance
            </strong>

        </div>


        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-hover">

                    <thead class="thead-light">

                        <tr>

                            <th>No</th>
                            <th>Nama Teknisi</th>
                            <th>Divisi</th>
                            <th>Status</th>
                            <th>Pekerjaan</th>
                            <th>Target</th>
                            <th>Progress</th>
                            <th>Lokasi</th>

                        </tr>

                    </thead>


                    <tbody>

                    @forelse($teknisis as $teknisi)

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

                                @php
                                    $absensi = $teknisi->user->absensiTerakhir;
                                @endphp

                                @if($absensi && $absensi->status == 'aktif' && !$absensi->jam_keluar)

                                    <span class="badge badge-success">
                                        Online
                                    </span>

                                @else

                                    <span class="badge badge-secondary">
                                        Offline
                                    </span>

                                @endif

                            </td>


                            <td>
                                {{ $teknisi->jumlah }}
                            </td>


                            <td>
                                {{ $teknisi->target }}
                            </td>


                            <td width="220">

                                <div class="progress">

                                    <div class="progress-bar bg-success"
                                         role="progressbar"
                                         style="width: {{ $teknisi->persen }}%">

                                        {{ round($teknisi->persen) }}%

                                    </div>

                                </div>

                            </td>


                            <td>

                                <a href="{{ route('admin.monitoring.detail', $teknisi->id) }}"
                                   class="btn btn-primary btn-sm">

                                    <i class="fas fa-user"></i>
                                    Detail

                                </a>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="8" class="text-center">

                                Tidak ada teknisi Assurance.

                            </td>

                        </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

@endsection