@extends('layoutsAdmin.master')

@section('content')

<div class="container-fluid">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">

        <h1 class="h3 mb-0 text-gray-800">
            Detail Produktivitas Teknisi
        </h1>

        <a href="{{ url()->previous() }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i>
            Kembali
        </a>

    </div>


    {{-- INFORMASI TEKNISI --}}

    <div class="row">

        <div class="col-md-4">

            <div class="card border-left-primary shadow mb-4">

                <div class="card-body">

                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-2">
                        Teknisi
                    </div>

                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                        {{ $teknisi->user->nama }}
                    </div>

                </div>

            </div>

        </div>


        <div class="col-md-4">

            <div class="card border-left-success shadow mb-4">

                <div class="card-body">

                    <div class="text-xs font-weight-bold text-success text-uppercase mb-2">
                        Target Harian
                    </div>

                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                        {{ $target }} Pekerjaan
                    </div>

                </div>

            </div>

        </div>


        <div class="col-md-4">

            <div class="card border-left-info shadow mb-4">

                <div class="card-body">

                    <div class="text-xs font-weight-bold text-info text-uppercase mb-2">
                        Realisasi
                    </div>

                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                        {{ $realisasi }} Pekerjaan
                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- PRODUKTIVITAS --}}

    <div class="card shadow mb-4">

        <div class="card-header py-3">

            <h6 class="m-0 font-weight-bold text-primary">
                Produktivitas Hari Ini
            </h6>

        </div>

        <div class="card-body">

            <div class="progress mb-3" style="height:25px;">

                <div
                    class="progress-bar bg-success"
                    role="progressbar"
                    style="width: {{ $persentase }}%;"
                >

                    {{ number_format($persentase, 0) }}%

                </div>

            </div>


            @if($realisasi >= $target)

                <span class="badge badge-success">
                    Target Tercapai
                </span>

            @elseif($realisasi > 0)

                <span class="badge badge-warning">
                    Belum Mencapai Target
                </span>

            @else

                <span class="badge badge-secondary">
                    Belum Ada Pekerjaan
                </span>

            @endif

        </div>

    </div>


    {{-- DAFTAR PEKERJAAN --}}

    <div class="card shadow mb-4">

        <div class="card-header py-3">

            <h6 class="m-0 font-weight-bold text-primary">
                Daftar Pekerjaan Hari Ini
            </h6>

        </div>


        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-hover">

                    <thead class="thead-dark">

                        {{-- ========================= --}}
                        {{-- ASSURANCE --}}
                        {{-- ========================= --}}

                        @if($teknisi->divisi->nama_divisi == 'Assurance')

                            <tr>

                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Nomor Tiket</th>
                                <th>User</th>
                                <th>Nama Pelanggan</th>
                                <th>ALPRO</th>
                                <th>Jenis Pekerjaan</th>
                                <th>Foto</th>
                                <th>Jam Selesai</th>
                                <th>Status</th>

                            </tr>


                        {{-- ========================= --}}
                        {{-- PROVISIONING --}}
                        {{-- ========================= --}}

                        @else

                            <tr>

                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Nomor WO</th>
                                <th>SC Order</th>
                                <th>ALPRO</th>
                                <th>Segmen</th>
                                <th>Nama Pelanggan</th>
                                <th>Jenis Pekerjaan</th>
                                <th>Jam Selesai</th>
                                <th>Status</th>
                                <th>Foto</th>

                            </tr>

                        @endif

                    </thead>


                    <tbody>

                        @forelse($pekerjaans as $pekerjaan)


                            {{-- ========================= --}}
                            {{-- ASSURANCE --}}
                            {{-- ========================= --}}

                            @if($teknisi->divisi->nama_divisi == 'Assurance')

                                <tr>

                                    <td>
                                        {{ $loop->iteration }}
                                    </td>


                                    <td>
                                        {{ $pekerjaan->tanggal
                                            ? \Carbon\Carbon::parse($pekerjaan->tanggal)->format('d-m-Y')
                                            : '-' }}
                                    </td>


                                    <td>
                                        {{ $pekerjaan->nomor_tiket ?? '-' }}
                                    </td>


                                    <td>
                                        {{ $teknisi->user->nama }}
                                    </td>


                                    <td>
                                        {{ $pekerjaan->nama_pelanggan ?? '-' }}
                                    </td>


                                    <td>
                                        {{ $pekerjaan->alpro ?? '-' }}
                                    </td>


                                    <td>
                                        {{ $pekerjaan->jenis_pekerjaan ?? '-' }}
                                    </td>


                                    {{-- FOTO ASSURANCE --}}

                                    <td class="text-center">

                                        @if($pekerjaan->foto)

                                            <a
                                                href="{{ asset('storage/' . $pekerjaan->foto) }}"
                                                target="_blank"
                                                class="btn btn-info btn-sm"
                                                title="Lihat Foto"
                                            >

                                                <i class="fas fa-image"></i>
                                                Lihat Foto

                                            </a>

                                        @else

                                            <span class="text-muted">
                                                Tidak ada
                                            </span>

                                        @endif

                                    </td>


                                    {{-- JAM SELESAI --}}

                                    <td>
                                        {{ $pekerjaan->jam_selesai ?? '-' }}
                                    </td>


                                    {{-- STATUS --}}

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


                            {{-- ========================= --}}
                            {{-- PROVISIONING --}}
                            {{-- ========================= --}}

                            @else

                                <tr>

                                    <td>
                                        {{ $loop->iteration }}
                                    </td>


                                    <td>
                                        {{ $pekerjaan->tanggal
                                            ? \Carbon\Carbon::parse($pekerjaan->tanggal)->format('d-m-Y')
                                            : '-' }}
                                    </td>


                                    <td>
                                        {{ $pekerjaan->nomor_wo ?? '-' }}
                                    </td>


                                    <td>
                                        {{ $pekerjaan->sc_order ?? '-' }}
                                    </td>


                                    <td>
                                        {{ $pekerjaan->alpro ?? '-' }}
                                    </td>


                                    <td>
                                        {{ $pekerjaan->segmen ?? '-' }}
                                    </td>


                                    <td>
                                        {{ $pekerjaan->nama_pelanggan ?? '-' }}
                                    </td>


                                    <td>
                                        {{ $pekerjaan->jenis_pekerjaan ?? '-' }}
                                    </td>


                                    <td>
                                        {{ $pekerjaan->jam_selesai ?? '-' }}
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


                                    {{-- FOTO PROVISIONING --}}

                                    <td class="text-center">

                                        @if($pekerjaan->foto)

                                            <a
                                                href="{{ asset('storage/' . $pekerjaan->foto) }}"
                                                target="_blank"
                                                class="btn btn-info btn-sm"
                                                title="Lihat Foto"
                                            >

                                                <i class="fas fa-image"></i>
                                                Lihat Foto

                                            </a>

                                        @else

                                            <span class="text-muted">
                                                Tidak ada
                                            </span>

                                        @endif

                                    </td>

                                </tr>

                            @endif


                        @empty

                            <tr>

                                @if($teknisi->divisi->nama_divisi == 'Assurance')

                                    <td
                                        colspan="10"
                                        class="text-center text-muted py-4"
                                    >

                                        Belum ada pekerjaan hari ini.

                                    </td>

                                @else

                                    <td
                                        colspan="11"
                                        class="text-center text-muted py-4"
                                    >

                                        Belum ada pekerjaan hari ini.

                                    </td>

                                @endif

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

@endsection