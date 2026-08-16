@extends('layoutsTeknisi.master')

@section('content')

@php
    $divisi = optional(Auth::user()->divisi)->nama_divisi;
    $isProvisioning = strtolower($divisi) === 'provisioning';
@endphp

<div class="container-fluid">

    <div class="d-sm-flex justify-content-between align-items-center mb-4">

        <h1 class="h3 text-gray-800">
            Detail Pekerjaan
        </h1>

        <a href="{{ route('teknisi.riwayat') }}" class="btn btn-secondary">

            <i class="fas fa-arrow-left"></i>

            Kembali

        </a>

    </div>


    <div class="card shadow">

        <div class="card-header bg-primary text-white">

            <strong>
                Informasi Pekerjaan
            </strong>

        </div>


        <div class="card-body">

            <div class="row">


                {{-- ========================= --}}
                {{-- INFORMASI PEKERJAAN --}}
                {{-- ========================= --}}

                <div class="col-md-6">

                    <table class="table table-borderless">


                        {{-- NOMOR WO / NOMOR TIKET --}}

                        @if($isProvisioning)

                            <tr>

                                <th width="180">
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

                        @else

                            <tr>

                                <th width="180">
                                    Nomor Tiket
                                </th>

                                <td>
                                    {{ $pekerjaan->nomor_tiket ?? '-' }}
                                </td>

                            </tr>

                        @endif


                        {{-- ALPRO --}}

                        <tr>

                            <th>
                                ALPRO
                            </th>

                            <td>
                                {{ $pekerjaan->alpro ?? '-' }}
                            </td>

                        </tr>


                        {{-- SEGMENT --}}

                        @if($isProvisioning)

                            <tr>

                                <th>
                                    Segmen
                                </th>

                                <td>
                                    {{ $pekerjaan->segmen ?? '-' }}
                                </td>

                            </tr>

                        @endif


                        {{-- PELANGGAN --}}

                        <tr>

                            <th>
                                Nama Pelanggan
                            </th>

                            <td>
                                {{ $pekerjaan->nama_pelanggan ?? '-' }}
                            </td>

                        </tr>


                        {{-- ALAMAT --}}

                        <tr>

                            <th>
                                Alamat
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


                        {{-- TANGGAL --}}

                        <tr>

                            <th>
                                Tanggal
                            </th>

                            <td>
                                {{ $pekerjaan->tanggal ?? '-' }}
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


                    </table>

                </div>


                {{-- ========================= --}}
                {{-- FOTO --}}
                {{-- ========================= --}}

                <div class="col-md-6 text-center">

                    @if($pekerjaan->foto)

                        <img
                            src="{{ asset('storage/' . $pekerjaan->foto) }}"
                            class="img-fluid rounded shadow"
                            style="max-height:500px;"
                        >

                    @else

                        <img
                            src="https://via.placeholder.com/400x300?text=Tidak+Ada+Foto"
                            class="img-fluid rounded shadow"
                        >

                    @endif

                </div>


            </div>


            <hr>


            {{-- ========================= --}}
            {{-- DESKRIPSI --}}
            {{-- ========================= --}}

            <h5>
                Deskripsi Pekerjaan
            </h5>


            <div class="border rounded p-3 bg-light">

                {{ $pekerjaan->deskripsi ?? '-' }}

            </div>


        </div>

    </div>

</div>

@endsection