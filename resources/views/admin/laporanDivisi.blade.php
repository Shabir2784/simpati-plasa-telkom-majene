@extends('layoutsAdmin.master')

@section('content')

<div class="container-fluid">

    {{-- HEADER --}}
    <div class="d-sm-flex align-items-center justify-content-between mb-4">

        <div>
            <h1 class="h3 mb-1 text-gray-800">
                Laporan {{ $divisi->nama_divisi }}
            </h1>

            <p class="mb-0 text-muted">
                Laporan produktivitas teknisi
                {{ $divisi->nama_divisi }}
            </p>
        </div>

        {{-- <a href="{{ route('admin.laporan') }}"
           class="btn btn-secondary btn-sm">

            <i class="fas fa-arrow-left mr-1"></i>
            Kembali

        </a> --}}

    </div>


    {{-- ====================================================== --}}
    {{-- PILIH PERIODE --}}
    {{-- ====================================================== --}}

    <div class="card shadow mb-4">

        <div class="card-header py-3">

            <h6 class="m-0 font-weight-bold text-primary">

                <i class="fas fa-calendar-alt mr-2"></i>

                Periode Laporan

            </h6>

        </div>

        <div class="card-body">

            <div class="row">

                {{-- HARIAN --}}
                <div class="col-md-4 mb-3">

                    <a href="{{ route(
                        'admin.laporan.' . strtolower($divisi->nama_divisi)
                    ) }}?periode=harian"
                       class="text-decoration-none">

                        <div class="card h-100 border-left-primary shadow-sm
                            {{ $periode == 'harian' ? 'bg-primary text-white' : '' }}">

                            <div class="card-body text-center">

                                <i class="fas fa-calendar-day fa-2x mb-3
                                    {{ $periode == 'harian' ? 'text-white' : 'text-primary' }}">
                                </i>

                                <h6 class="font-weight-bold">
                                    Harian
                                </h6>

                                <small>
                                    Pekerjaan hari ini
                                </small>

                            </div>

                        </div>

                    </a>

                </div>


                {{-- MINGGUAN --}}
                <div class="col-md-4 mb-3">

                    <a href="{{ route(
                        'admin.laporan.' . strtolower($divisi->nama_divisi)
                    ) }}?periode=mingguan"
                       class="text-decoration-none">

                        <div class="card h-100 border-left-success shadow-sm
                            {{ $periode == 'mingguan' ? 'bg-success text-white' : '' }}">

                            <div class="card-body text-center">

                                <i class="fas fa-calendar-week fa-2x mb-3
                                    {{ $periode == 'mingguan' ? 'text-white' : 'text-success' }}">
                                </i>

                                <h6 class="font-weight-bold">
                                    Mingguan
                                </h6>

                                <small>
                                    Pekerjaan minggu ini
                                </small>

                            </div>

                        </div>

                    </a>

                </div>


                {{-- BULANAN --}}
                <div class="col-md-4 mb-3">

                    <a href="{{ route(
                        'admin.laporan.' . strtolower($divisi->nama_divisi)
                    ) }}?periode=bulanan"
                       class="text-decoration-none">

                        <div class="card h-100 border-left-info shadow-sm
                            {{ $periode == 'bulanan' ? 'bg-info text-white' : '' }}">

                            <div class="card-body text-center">

                                <i class="fas fa-calendar-alt fa-2x mb-3
                                    {{ $periode == 'bulanan' ? 'text-white' : 'text-info' }}">
                                </i>

                                <h6 class="font-weight-bold">
                                    Bulanan
                                </h6>

                                <small>
                                    Pekerjaan bulan ini
                                </small>

                            </div>

                        </div>

                    </a>

                </div>

            </div>

        </div>

    </div>


    {{-- ====================================================== --}}
    {{-- RINGKASAN --}}
    {{-- ====================================================== --}}

    <div class="row">

        {{-- TOTAL --}}
        <div class="col-xl-3 col-md-6 mb-4">

            <div class="card border-left-primary shadow h-100">

                <div class="card-body">

                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">

                        Total Pekerjaan

                    </div>

                    <div class="h3 mb-0 font-weight-bold text-gray-800">

                        {{ $total }}

                    </div>

                </div>

            </div>

        </div>


        {{-- SELESAI --}}
        <div class="col-xl-3 col-md-6 mb-4">

            <div class="card border-left-success shadow h-100">

                <div class="card-body">

                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">

                        Pekerjaan Selesai

                    </div>

                    <div class="h3 mb-0 font-weight-bold text-gray-800">

                        {{ $selesai }}

                    </div>

                </div>

            </div>

        </div>


        {{-- PENDING --}}
        <div class="col-xl-3 col-md-6 mb-4">

            <div class="card border-left-warning shadow h-100">

                <div class="card-body">

                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">

                        Pending

                    </div>

                    <div class="h3 mb-0 font-weight-bold text-gray-800">

                        {{ $pending }}

                    </div>

                </div>

            </div>

        </div>


        {{-- TEKNISI --}}
        <div class="col-xl-3 col-md-6 mb-4">

            <div class="card border-left-info shadow h-100">

                <div class="card-body">

                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">

                        Total Teknisi

                    </div>

                    <div class="h3 mb-0 font-weight-bold text-gray-800">

                        {{ $teknisi }}

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- ====================================================== --}}
    {{-- FILTER --}}
    {{-- ====================================================== --}}

    <div class="card shadow mb-4">

        <div class="card-header py-3">

            <h6 class="m-0 font-weight-bold text-primary">

                <i class="fas fa-filter mr-2"></i>

                Filter Laporan

            </h6>

        </div>

        <div class="card-body">

            <form method="GET"
                  action="{{ $divisi->nama_divisi == 'Assurance'
                      ? route('admin.laporan.assurance')
                      : route('admin.laporan.provisioning') }}">

                <input type="hidden"
                       name="periode"
                       value="{{ $periode }}">


                <div class="row">

                    {{-- TANGGAL AWAL --}}
                    <div class="col-md-4 mb-3">

                        <label class="font-weight-bold">
                            Tanggal Awal
                        </label>

                        <input
                            type="date"
                            name="tanggal_awal"
                            class="form-control"
                            value="{{ request('tanggal_awal') }}"
                        >

                    </div>


                    {{-- TANGGAL AKHIR --}}
                    <div class="col-md-4 mb-3">

                        <label class="font-weight-bold">
                            Tanggal Akhir
                        </label>

                        <input
                            type="date"
                            name="tanggal_akhir"
                            class="form-control"
                            value="{{ request('tanggal_akhir') }}"
                        >

                    </div>


                    {{-- STATUS --}}
                    <div class="col-md-4 mb-3">

                        <label class="font-weight-bold">
                            Status
                        </label>

                        <select name="status"
                                class="form-control">

                            <option value="">
                                Semua Status
                            </option>

                            <option value="selesai"
                                {{ request('status') == 'selesai'
                                    ? 'selected'
                                    : '' }}>

                                Selesai

                            </option>

                            <option value="pending"
                                {{ request('status') == 'pending'
                                    ? 'selected'
                                    : '' }}>

                                Pending

                            </option>

                        </select>

                    </div>

                </div>


                <div class="row">

                    <div class="col-md-6 mb-2">

                        <button type="submit"
                                class="btn btn-primary btn-block">

                            <i class="fas fa-search mr-1"></i>

                            Terapkan Filter

                        </button>

                    </div>


                    <div class="col-md-6 mb-2">

                        <a href="{{ $divisi->nama_divisi == 'Assurance'
                            ? route('admin.laporan.assurance')
                            : route('admin.laporan.provisioning') }}"

                           class="btn btn-secondary btn-block">

                            <i class="fas fa-sync-alt mr-1"></i>

                            Reset Filter

                        </a>

                    </div>

                </div>

            </form>

        </div>

    </div>


    {{-- ====================================================== --}}
    {{-- EXPORT --}}
    {{-- ====================================================== --}}

    <div class="card shadow mb-4">

        <div class="card-body">

            <div class="row align-items-center">

                <div class="col-md-6 mb-3 mb-md-0">

                    <h6 class="font-weight-bold text-gray-800 mb-1">

                        Export Laporan

                    </h6>

                    <small class="text-muted">

                        Download laporan
                        {{ $divisi->nama_divisi }}
                        sesuai periode dan filter.

                    </small>

                </div>


                <div class="col-md-6 text-md-right">

                    {{-- PDF --}}

                    <a href="{{ route('admin.laporan.pdf', [
                        'divisi' => $divisi->id,
                        'periode' => $periode,
                        'tanggal_awal' => request('tanggal_awal'),
                        'tanggal_akhir' => request('tanggal_akhir'),
                        'status' => request('status')
                    ]) }}"

                       class="btn btn-danger mr-2">

                        <i class="fas fa-file-pdf mr-1"></i>

                        PDF

                    </a>


                    {{-- EXCEL --}}

                    <a href="{{ route('admin.laporan.excel', [
                        'divisi' => $divisi->id,
                        'periode' => $periode,
                        'tanggal_awal' => request('tanggal_awal'),
                        'tanggal_akhir' => request('tanggal_akhir'),
                        'status' => request('status')
                    ]) }}"

                       class="btn btn-success">

                        <i class="fas fa-file-excel mr-1"></i>

                        Excel

                    </a>

                </div>

            </div>

        </div>

    </div>


    {{-- ====================================================== --}}
    {{-- TABEL --}}
    {{-- ====================================================== --}}

    <div class="card shadow mb-4">

        <div class="card-header py-3">

            <div class="d-flex justify-content-between align-items-center">

                <h6 class="m-0 font-weight-bold text-primary">

                    Data Pekerjaan
                    {{ $divisi->nama_divisi }}

                </h6>

                <span class="badge badge-primary">

                    {{ ucfirst($periode) }}

                </span>

            </div>

        </div>


        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-hover">

                    <thead class="thead-dark">

                        <tr>

                            <th>No</th>

                            <th>Tanggal</th>

                            <th>Teknisi</th>


                            @if($divisi->nama_divisi == 'Assurance')

                                <th>Nomor Tiket</th>

                            @else

                                <th>Nomor WO</th>

                                <th>SC Order</th>

                            @endif


                            <th>ALPRO</th>


                            @if($divisi->nama_divisi == 'Provisioning')

                                <th>Segmen</th>

                            @endif


                            <th>Pelanggan</th>

                            <th>Jenis Pekerjaan</th>

                            <th>Jam Selesai</th>

                            <th>Status</th>

                            <th>Aksi</th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($laporans as $laporan)

                            <tr>

                                <td>
                                    {{ $loop->iteration }}
                                </td>


                                <td>

                                    {{ $laporan->tanggal
                                        ? \Carbon\Carbon::parse(
                                            $laporan->tanggal
                                        )->format('d-m-Y')
                                        : '-' }}

                                </td>


                                <td>

                                    {{ optional($laporan->user)->nama ?? '-' }}

                                </td>


                                {{-- ASSURANCE --}}

                                @if($divisi->nama_divisi == 'Assurance')

                                    <td>

                                        {{ $laporan->nomor_tiket ?? '-' }}

                                    </td>

                                @else

                                    {{-- PROVISIONING --}}

                                    <td>

                                        {{ $laporan->nomor_wo ?? '-' }}

                                    </td>

                                    <td>

                                        {{ $laporan->sc_order ?? '-' }}

                                    </td>

                                @endif


                                <td>

                                    {{ $laporan->alpro ?? '-' }}

                                </td>


                                @if($divisi->nama_divisi == 'Provisioning')

                                    <td>

                                        {{ $laporan->segmen ?? '-' }}

                                    </td>

                                @endif


                                <td>

                                    {{ $laporan->nama_pelanggan ?? '-' }}

                                </td>


                                <td>

                                    {{ $laporan->jenis_pekerjaan ?? '-' }}

                                </td>


                                <td>

                                    {{ $laporan->jam_selesai ?? '-' }}

                                </td>


                                <td>

                                    @if($laporan->status == 'selesai')

                                        <span class="badge badge-success">

                                            Selesai

                                        </span>

                                    @else

                                        <span class="badge badge-warning">

                                            Pending

                                        </span>

                                    @endif

                                </td>


                                <td class="text-center">

                                    <a href="{{ route(
                                        'admin.laporan.detail',
                                        $laporan->id
                                    ) }}"

                                       class="btn btn-info btn-sm"
                                       title="Detail">

                                        <i class="fas fa-eye"></i>

                                    </a>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="{{ $divisi->nama_divisi == 'Assurance' ? 10 : 11 }}"
                                    class="text-center text-muted py-5">

                                    <i class="fas fa-folder-open fa-2x mb-2"></i>

                                    <div>
                                        Tidak ada data pekerjaan.
                                    </div>

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