@extends('layoutsTeknisi.master')

@section('content')

@php
    $divisi = optional(Auth::user()->divisi)->nama_divisi;
    $isProvisioning = strtolower($divisi) === 'provisioning';
@endphp

<div class="d-sm-flex align-items-center justify-content-between mb-4">

    <h1 class="h3 text-gray-800">
        Riwayat Pekerjaan
    </h1>

    <a href="{{ route('teknisi.pekerjaan') }}" class="btn btn-primary">

        <i class="fas fa-plus"></i>

        Input Pekerjaan

    </a>

</div>


@if(session('success'))

    <div class="alert alert-success">

        {{ session('success') }}

    </div>

@endif


<div class="card shadow">

    <div class="card-header bg-primary text-white">

        <strong>
            Daftar Pekerjaan Teknisi
        </strong>

    </div>


    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-bordered table-hover">

                <thead class="thead-light">

                    <tr>

                        <th>No</th>

                        <th>
                            {{ $isProvisioning ? 'No WO' : 'No Tiket' }}
                        </th>


                        @if($isProvisioning)

                            <th>
                                SC Order
                            </th>

                        @endif


                        <th>
                            ALPRO
                        </th>


                        @if($isProvisioning)

                            <th>
                                Segmen
                            </th>

                        @endif


                        <th>
                            Pelanggan
                        </th>

                        <th>
                            Jenis
                        </th>

                        <th>
                            Tanggal
                        </th>

                        <th>
                            Status
                        </th>

                        <th>
                            Foto
                        </th>

                        <th>
                            Aksi
                        </th>

                    </tr>

                </thead>


                <tbody>

                @forelse($pekerjaans as $pekerjaan)

                    <tr>

                        <td>
                            {{ $loop->iteration }}
                        </td>


                        {{-- NOMOR WO / NOMOR TIKET --}}

                        <td>

                            @if($isProvisioning)

                                {{ $pekerjaan->nomor_wo ?? '-' }}

                            @else

                                {{ $pekerjaan->nomor_tiket ?? '-' }}

                            @endif

                        </td>


                        {{-- SC ORDER KHUSUS PROVISIONING --}}

                        @if($isProvisioning)

                            <td>
                                {{ $pekerjaan->sc_order ?? '-' }}
                            </td>

                        @endif


                        {{-- ALPRO --}}

                        <td>
                            {{ $pekerjaan->alpro ?? '-' }}
                        </td>


                        {{-- SEGMEN KHUSUS PROVISIONING --}}

                        @if($isProvisioning)

                            <td>
                                {{ $pekerjaan->segmen ?? '-' }}
                            </td>

                        @endif


                        {{-- PELANGGAN --}}

                        <td>
                            {{ $pekerjaan->nama_pelanggan ?? '-' }}
                        </td>


                        {{-- JENIS PEKERJAAN --}}

                        <td>
                            {{ $pekerjaan->jenis_pekerjaan ?? '-' }}
                        </td>


                        {{-- TANGGAL --}}

                        <td>
                            {{ $pekerjaan->tanggal ?? '-' }}
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


                        {{-- FOTO --}}

                        <td class="text-center">

                            @if($pekerjaan->foto)

                                <img
                                    src="{{ asset('storage/' . $pekerjaan->foto) }}"
                                    width="70"
                                    class="img-thumbnail"
                                >

                            @else

                                -

                            @endif

                        </td>


                        {{-- AKSI --}}

                        <td>

                            <a
                                href="{{ route('teknisi.detailPekerjaan', $pekerjaan->id) }}"
                                class="btn btn-info btn-sm"
                            >

                                <i class="fas fa-eye"></i>

                                Detail

                            </a>

                        </td>

                    </tr>


                @empty

                    <tr>

                        <td
                            colspan="{{ $isProvisioning ? 11 : 9 }}"
                            class="text-center text-muted"
                        >

                            Belum ada pekerjaan.

                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>


        <div class="mt-3">

            {{ $pekerjaans->links() }}

        </div>

    </div>

</div>

@endsection