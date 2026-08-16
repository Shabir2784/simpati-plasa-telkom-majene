@extends('layoutsAdmin.master')

@section('content')

<div class="container-fluid">

    @php
        $namaDivisi = optional(optional($pekerjaan->user)->teknisi->divisi)->nama_divisi;
        $isAssurance = $namaDivisi === 'Assurance';
        $isProvisioning = $namaDivisi === 'Provisioning';
    @endphp


    {{-- HEADER --}}
    <div class="d-sm-flex align-items-center justify-content-between mb-4">

        <div>
            <h1 class="h3 mb-1 text-gray-800">
                Detail Laporan Pekerjaan
            </h1>

            <p class="mb-0 text-muted">
                {{ $namaDivisi }} —
                Detail pekerjaan teknisi
            </p>
        </div>


        {{-- KEMBALI KE LAPORAN DIVISI --}}
        <a href="{{ $isAssurance
            ? route('admin.laporan.assurance')
            : route('admin.laporan.provisioning') }}"
           class="btn btn-secondary btn-sm">

            <i class="fas fa-arrow-left mr-1"></i>
            Kembali

        </a>

    </div>


    {{-- ====================================================== --}}
    {{-- INFORMASI PEKERJAAN --}}
    {{-- ====================================================== --}}

    <div class="card shadow mb-4">

        <div class="card-header bg-primary text-white">

            <strong>
                <i class="fas fa-briefcase mr-2"></i>
                Informasi Pekerjaan
            </strong>

        </div>


        <div class="card-body">

            <div class="row">

                {{-- KOLOM KIRI --}}
                <div class="col-md-6">

                    <table class="table table-borderless mb-0">

                        {{-- NO --}}
                        <tr>
                            <th width="180">
                                No
                            </th>

                            <td>
                                {{ $pekerjaan->id }}
                            </td>
                        </tr>


                        {{-- TANGGAL --}}
                        <tr>
                            <th>
                                Tanggal
                            </th>

                            <td>
                                {{ $pekerjaan->tanggal
                                    ? \Carbon\Carbon::parse($pekerjaan->tanggal)->format('d-m-Y')
                                    : '-' }}
                            </td>
                        </tr>


                        {{-- TEKNISI --}}
                        <tr>
                            <th>
                                Teknisi
                            </th>

                            <td>
                                {{ optional($pekerjaan->user)->nama ?? '-' }}
                            </td>
                        </tr>


                        {{-- DIVISI --}}
                        <tr>
                            <th>
                                Divisi
                            </th>

                            <td>

                                @if($isAssurance)

                                    <span class="badge badge-primary">
                                        Assurance
                                    </span>

                                @elseif($isProvisioning)

                                    <span class="badge badge-success">
                                        Provisioning
                                    </span>

                                @else

                                    <span class="badge badge-secondary">
                                        {{ $namaDivisi ?? '-' }}
                                    </span>

                                @endif

                            </td>
                        </tr>


                        {{-- ASSURANCE --}}
                        @if($isAssurance)

                            <tr>
                                <th>
                                    Nomor Tiket
                                </th>

                                <td>
                                    {{ $pekerjaan->nomor_tiket ?? '-' }}
                                </td>
                            </tr>


                            <tr>
                                <th>
                                    ALPRO
                                </th>

                                <td>
                                    {{ $pekerjaan->alpro ?? '-' }}
                                </td>
                            </tr>

                        @endif


                        {{-- PROVISIONING --}}
                        @if($isProvisioning)

                            <tr>
                                <th>
                                    Nomor WO
                                </th>

                                <td>
                                    {{ $pekerjaan->nomor_wo ?? '-' }}
                                </td>
                            </tr>


                            <tr>
                                <th>
                                    SC Order
                                </th>

                                <td>
                                    {{ $pekerjaan->sc_order ?? '-' }}
                                </td>
                            </tr>


                            <tr>
                                <th>
                                    ALPRO
                                </th>

                                <td>
                                    {{ $pekerjaan->alpro ?? '-' }}
                                </td>
                            </tr>


                            <tr>
                                <th>
                                    Segmen
                                </th>

                                <td>
                                    {{ $pekerjaan->segmen ?? '-' }}
                                </td>
                            </tr>

                        @endif

                    </table>

                </div>


                {{-- KOLOM KANAN --}}
                <div class="col-md-6">

                    <table class="table table-borderless mb-0">

                        {{-- PELANGGAN --}}
                        <tr>
                            <th width="180">
                                Pelanggan
                            </th>

                            <td>
                                {{ $pekerjaan->nama_pelanggan ?? '-' }}
                            </td>
                        </tr>


                        {{-- ALAMAT --}}
                        <tr>
                            <th>
                                Alamat Pelanggan
                            </th>

                            <td>
                                {{ $pekerjaan->alamat_pelanggan ?? '-' }}
                            </td>
                        </tr>


                        {{-- JENIS PEKERJAAN --}}
                        <tr>
                            <th>
                                Jenis Pekerjaan
                            </th>

                            <td>
                                {{ $pekerjaan->jenis_pekerjaan ?? '-' }}
                            </td>
                        </tr>


                        {{-- JAM SELESAI --}}
                        <tr>
                            <th>
                                Jam Selesai
                            </th>

                            <td>
                                {{ $pekerjaan->jam_selesai ?? '-' }}
                            </td>
                        </tr>


                        {{-- STATUS --}}
                        <tr>
                            <th>
                                Status
                            </th>

                            <td>

                                @if($pekerjaan->status === 'selesai')

                                    <span class="badge badge-success">
                                        <i class="fas fa-check-circle mr-1"></i>
                                        Selesai
                                    </span>

                                @else

                                    <span class="badge badge-warning">
                                        <i class="fas fa-hourglass-half mr-1"></i>
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


    {{-- ====================================================== --}}
    {{-- DESKRIPSI --}}
    {{-- ====================================================== --}}

    <div class="card shadow mb-4">

        <div class="card-header bg-info text-white">

            <strong>
                <i class="fas fa-align-left mr-2"></i>
                Deskripsi Pekerjaan
            </strong>

        </div>


        <div class="card-body">

            @if($pekerjaan->deskripsi)

                <p class="mb-0">
                    {{ $pekerjaan->deskripsi }}
                </p>

            @else

                <span class="text-muted">
                    Tidak ada deskripsi pekerjaan.
                </span>

            @endif

        </div>

    </div>


    {{-- ====================================================== --}}
    {{-- FOTO PEKERJAAN --}}
    {{-- ====================================================== --}}

    @if($pekerjaan->foto)

        <div class="card shadow mb-4">

            <div class="card-header bg-success text-white">

                <strong>
                    <i class="fas fa-camera mr-2"></i>
                    Bukti Foto Pekerjaan
                </strong>

            </div>


            <div class="card-body text-center">

                <img
                    src="{{ asset('storage/' . $pekerjaan->foto) }}"
                    alt="Foto pekerjaan"
                    class="img-fluid rounded shadow-sm"
                    style="max-height:500px; max-width:100%;"
                >

            </div>

        </div>

    @else

        <div class="card shadow mb-4">

            <div class="card-header bg-secondary text-white">

                <strong>
                    <i class="fas fa-camera mr-2"></i>
                    Bukti Foto Pekerjaan
                </strong>

            </div>


            <div class="card-body text-center text-muted py-5">

                <i class="fas fa-image fa-3x mb-3"></i>

                <p class="mb-0">
                    Tidak ada foto pekerjaan.
                </p>

            </div>

        </div>

    @endif


    {{-- ====================================================== --}}
    {{-- FOOTER --}}
    {{-- ====================================================== --}}

    <div class="text-right mb-4">

        {{-- <a href="{{ $isAssurance
            ? route('admin.laporan.assurance')
            : route('admin.laporan.provisioning') }}"
           class="btn btn-secondary">

            <i class="fas fa-arrow-left mr-1"></i>
            Kembali ke Laporan {{ $namaDivisi }}

        </a> --}}

    </div>

</div>

@endsection