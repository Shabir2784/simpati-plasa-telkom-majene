@extends('layoutsAdmin.master')

@section('content')

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Laporan</h1>

    <div class="row">

        <div class="col-xl-3 col-md-6 mb-4">

            <div class="card border-left-primary shadow h-100">

                <div class="card-body">

                    <div class="row align-items-center">

                        <div class="col">

                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-2">
                                Total Pekerjaan
                            </div>

                            <div class="h2 font-weight-bold">
                                {{ $totalPekerjaan }}
                            </div>

                        </div>

                        <div class="col-auto">

                            <i class="fas fa-briefcase fa-3x text-gray-300"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-xl-3 col-md-6 mb-4">

            <div class="card border-left-success shadow h-100">

                <div class="card-body">

                    <div class="row align-items-center">

                        <div class="col">

                            <div class="text-xs font-weight-bold text-success text-uppercase mb-2">
                                Pekerjaan Selesai
                            </div>

                            <div class="h2 font-weight-bold">
                                {{ $selesai }}
                            </div>

                        </div>

                        <div class="col-auto">

                            <i class="fas fa-check-circle fa-3x text-gray-300"></i>

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
                                Pending
                            </div>

                            <div class="h2 font-weight-bold">
                                {{ $pending }}
                            </div>

                        </div>

                        <div class="col-auto">

                            <i class="fas fa-hourglass-half fa-3x text-gray-300"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-xl-3 col-md-6 mb-4">

            <div class="card border-left-info shadow h-100">

                <div class="card-body">

                    <div class="row align-items-center">

                        <div class="col">

                            <div class="text-xs font-weight-bold text-info text-uppercase mb-2">
                                Total Teknisi
                            </div>

                            <div class="h2 font-weight-bold">
                                {{ $totalTeknisi }}
                            </div>

                        </div>

                        <div class="col-auto">

                            <i class="fas fa-users fa-3x text-gray-300"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <div class="card shadow mb-4">

        <div class="card-header">

            <h6 class="font-weight-bold text-primary">

                Filter Laporan

            </h6>

        </div>

        <div class="card-body">

            <form method="GET">

                <div class="row">

                    <div class="col-md-3">

                        <label>Tanggal Awal</label>

                        <input type="date"
                            name="tanggal_awal"
                            class="form-control"
                            value="{{ request('tanggal_awal') }}">

                    </div>

                    <div class="col-md-3">

                        <label>Tanggal Akhir</label>

                        <input type="date"
                            name="tanggal_akhir"
                            class="form-control"
                            value="{{ request('tanggal_akhir') }}">

                    </div>

                    <div class="col-md-2">

                        <label>Divisi</label>

                        <select
                            name="divisi"
                            class="form-control">

                            <option value="">Semua</option>

                            @foreach($divisis as $divisi)

                            <option
                                value="{{ $divisi->id }}"
                                {{ request('divisi')==$divisi->id ? 'selected' : '' }}>

                                {{ $divisi->nama_divisi }}

                            </option>

                            @endforeach

                        </select>

                    </div>

                    <div class="col-md-2">

                        <label>Status</label>

                        <select
                            name="status"
                            class="form-control">

                            <option value="">Semua</option>

                            <option value="pending"
                                {{ request('status')=='pending' ? 'selected' : '' }}>

                                Pending

                            </option>

                            <option value="selesai"
                                {{ request('status')=='selesai' ? 'selected' : '' }}>

                                Selesai

                            </option>

                        </select>

                    </div>

                    <div class="col-md-2 d-flex align-items-end">

                        <button
                            class="btn btn-primary btn-block">

                            <i class="fas fa-search"></i>

                            Filter

                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>

    <div class="card shadow mb-4">

        <div class="card-header py-3 d-flex justify-content-between align-items-center">

            <h6 class="m-0 font-weight-bold text-success">

                Data Laporan Produktivitas

            </h6>

            <div>

                <a href="{{ route('admin.laporan.pdf') }}"
                class="btn btn-danger btn-sm">

                    <i class="fas fa-file-pdf"></i>

                    Export PDF

                </a>

                <a href="{{ route('admin.laporan.excel') }}"
                class="btn btn-success btn-sm">

                    <i class="fas fa-file-excel"></i>

                    Export Excel

                </a>

            </div>

        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-hover">

                    <thead class="thead-light">

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

                            <th>Aksi</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($laporans as $laporan)

                        <tr>

                            <td>

                                {{ $laporans->firstItem() + $loop->index }}

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

                                {{ $laporan->durasi ?? '-' }}

                                @if($laporan->durasi)

                                    Menit

                                @endif

                            </td>

                            <td>

                                @if($laporan->status=='selesai')

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

                                <a href="#"

                                class="btn btn-info btn-sm">

                                    <i class="fas fa-eye"></i>

                                    Detail

                                </a>

                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td colspan="10" class="text-center">

                                Tidak ada data.

                            </td>

                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            <div class="mt-3">

                {{ $laporans->links() }}

            </div>

        </div>

    </div>

    <div class="card shadow mb-4">

        <div class="card-header py-3">

            <h6 class="m-0 font-weight-bold text-primary">

                Ringkasan Produktivitas per Divisi

            </h6>

        </div>

        <div class="card-body">

            @foreach($progressDivisi as $divisi)

            <div class="mb-4">

                <div class="d-flex justify-content-between mb-2">

                    <strong>

                        {{ $divisi['nama'] }}

                    </strong>

                    <span>

                        {{ $divisi['selesai'] }}

                        /

                        {{ $divisi['target'] }}

                        Pekerjaan

                    </span>

                </div>

                <div class="progress" style="height:25px;">

                    <div class="progress-bar

                        @if($divisi['persentase']>=80)

                            bg-success

                        @elseif($divisi['persentase']>=60)

                            bg-warning

                        @else

                            bg-danger

                        @endif"

                        role="progressbar"

                        style="width: {{ $divisi['persentase'] }}%;">

                        {{ $divisi['persentase'] }}%

                    </div>

                </div>

                <small class="text-muted">

                    Target Divisi :
                    {{ $divisi['target'] }}
                    pekerjaan

                    |

                    Tercapai :
                    {{ $divisi['selesai'] }}
                    pekerjaan

                </small>

            </div>

            @endforeach

        </div>

    </div>
</div>

@endsection