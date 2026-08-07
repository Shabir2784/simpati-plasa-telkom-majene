@extends('layoutsAdmin.master')

@section('content')

<div class="container-fluid">

    <!-- Judul -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">

        <div>

            <h1 class="h3 text-gray-800 font-weight-bold">

                Detail Teknisi

            </h1>

            <small class="text-muted">

                Informasi lengkap teknisi

            </small>

        </div>

        <a href="{{ route('admin.monitoring') }}"
           class="btn btn-secondary">

            <i class="fas fa-arrow-left"></i>

            Kembali

        </a>

    </div>

    <div class="row">

        <!-- Profil -->
        <div class="col-lg-4">

            <div class="card shadow mb-4">

                <div class="card-body text-center">

                    <img src="https://ui-avatars.com/api/?name={{ urlencode($teknisi->user->nama) }}&background=0D8ABC&color=fff&size=150"
                        class="rounded-circle mb-3">

                    <h4 class="font-weight-bold">

                        {{ $teknisi->user->nama }}

                    </h4>

                    <span class="badge badge-primary">

                        {{ $teknisi->divisi->nama_divisi }}

                    </span>

                    <hr>

                    <table class="table table-borderless text-left">

                        <tr>

                            <th width="40%">NIK</th>

                            <td>{{ $teknisi->nik }}</td>

                        </tr>

                        <tr>

                            <th>Email</th>

                            <td>{{ $teknisi->user->email }}</td>

                        </tr>

                        <tr>

                            <th>No HP</th>

                            <td>{{ $teknisi->no_hp }}</td>

                        </tr>

                        <tr>

                            <th>Status</th>

                            <td>

                                @if(optional($teknisi->user->absensiTerakhir)->status=='aktif')

                                    <span class="badge badge-success">

                                        Online

                                    </span>

                                @else

                                    <span class="badge badge-danger">

                                        Offline

                                    </span>

                                @endif

                            </td>

                        </tr>

                    </table>

                </div>

            </div>

        </div>

        <!-- Statistik -->
        <div class="col-lg-8">

            <div class="row">

                <div class="col-md-4">

                    <div class="card border-left-primary shadow mb-4">

                        <div class="card-body">

                            <h6 class="text-primary">

                                Target Hari Ini

                            </h6>

                            <h2>

                                {{ $target }}

                            </h2>

                        </div>

                    </div>

                </div>

                <div class="col-md-4">

                    <div class="card border-left-success shadow mb-4">

                        <div class="card-body">

                            <h6 class="text-success">

                                Pekerjaan

                            </h6>

                            <h2>

                                {{ $jumlahPekerjaan }}

                            </h2>

                        </div>

                    </div>

                </div>

                <div class="col-md-4">

                    <div class="card border-left-warning shadow mb-4">

                        <div class="card-body">

                            <h6 class="text-warning">

                                Progress

                            </h6>

                            <h2>

                                {{ round($persen) }}%

                            </h2>

                        </div>

                    </div>

                </div>

            </div>

            <!-- Progress -->

            <div class="card shadow mb-4">

                <div class="card-header">

                    <h6 class="font-weight-bold text-success">

                        Progress Target Hari Ini

                    </h6>

                </div>

                <div class="card-body">

                    <div class="progress" style="height:25px;">

                        <div class="progress-bar bg-success"

                            style="width: {{ $persen }}%;">

                            {{ round($persen) }}%

                        </div>

                    </div>

                </div>

            </div>

            <!-- Lokasi -->

            <div class="card shadow">

                <div class="card-header">

                    <h6 class="font-weight-bold text-danger">

                        Lokasi Terakhir

                    </h6>

                </div>

                <div class="card-body">

                    @if($teknisi->user->lokasiTerakhir)

                        <table class="table">

                            <tr>

                                <th>Latitude</th>

                                <td>

                                    {{ $teknisi->user->lokasiTerakhir->latitude }}

                                </td>

                            </tr>

                            <tr>

                                <th>Longitude</th>

                                <td>

                                    {{ $teknisi->user->lokasiTerakhir->longitude }}

                                </td>

                            </tr>

                            <tr>

                                <th>Alamat</th>

                                <td>

                                    {{ $teknisi->user->lokasiTerakhir->alamat }}

                                </td>

                            </tr>

                        </table>

                    @else

                        <div class="alert alert-warning">

                            Belum ada lokasi yang dikirim teknisi.

                        </div>

                    @endif

                </div>

            </div>

            <div class="card shadow mt-4">

                <div class="card-header">

                    <h6 class="font-weight-bold text-primary">

                        <i class="fas fa-history"></i>

                        Riwayat Pekerjaan Teknisi

                    </h6>

                </div>

                <div class="card-body">

                    @if($riwayatPekerjaan->count())

                    <div class="table-responsive">

                        <table class="table table-bordered table-hover">

                            <thead class="thead-light">

                                <tr>

                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>No Tiket</th>
                                    <th>Pelanggan</th>
                                    <th>Jenis</th>
                                    <th>Status</th>

                                </tr>

                            </thead>

                            <tbody>

                                @foreach($riwayatPekerjaan as $item)

                                <tr>

                                    <td>{{ $loop->iteration }}</td>

                                    <td>

                                        {{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}

                                    </td>

                                    <td>

                                        {{ $item->nomor_tiket }}

                                    </td>

                                    <td>

                                        {{ $item->nama_pelanggan }}

                                    </td>

                                    <td>

                                        {{ $item->jenis_pekerjaan }}

                                    </td>

                                    <td>

                                        @if($item->status=='Selesai')

                                            <span class="badge badge-success">

                                                Selesai

                                            </span>

                                        @elseif($item->status=='Proses')

                                            <span class="badge badge-warning">

                                                Proses

                                            </span>

                                        @else

                                            <span class="badge badge-secondary">

                                                {{ $item->status }}

                                            </span>

                                        @endif

                                    </td>

                                </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                    @else

                        <div class="alert alert-warning mb-0">

                            Teknisi belum memiliki riwayat pekerjaan.

                        </div>

                    @endif

                </div>

            </div>

        </div>

    </div>

</div>

@endsection