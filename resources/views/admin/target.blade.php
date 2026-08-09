@extends('layoutsAdmin.master')

@section('content')

<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800">{{ $judul }}</h1>

    {{-- Card Informasi --}}
    <div class="row">

        <div class="col-md-4">

            <div class="card border-left-primary shadow mb-4">

                <div class="card-body">

                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-2">
                        Divisi
                    </div>

                    <div class="h4 mb-0 font-weight-bold text-gray-800">
                        {{ $divisi->nama_divisi }}
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

                    <div class="h4 mb-0 font-weight-bold text-gray-800">
                        {{ $target }} Pekerjaan
                    </div>

                </div>

            </div>

        </div>

        <div class="col-md-4">

            <div class="card border-left-info shadow mb-4">

                <div class="card-body">

                    <div class="text-xs font-weight-bold text-info text-uppercase mb-2">
                        Jumlah Teknisi
                    </div>

                    <div class="h4 mb-0 font-weight-bold text-gray-800">
                        {{ $teknisis->count() }}
                    </div>

                </div>

            </div>

        </div>

    </div>

    {{-- Tabel --}}
    <div class="card shadow mb-4">

        <div class="card-header py-3">

            <h6 class="m-0 font-weight-bold text-primary">
                Data Target Produktivitas Teknisi
            </h6>

        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-hover">

                    <thead class="thead-dark">

                        <tr>

                            <th width="5%">No</th>
                            <th>Nama Teknisi</th>
                            <th>NIK</th>
                            <th>No HP</th>
                            <th>Target Harian</th>
                            <th>Realisasi</th>
                            <th>Produktivitas</th>
                            <th>Status</th>
                            <th width="10%">Aksi</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($teknisis as $item)

                        <tr>

                            <td>{{ $loop->iteration }}</td>

                            <td>{{ $item->user->nama }}</td>

                            <td>{{ $item->nik }}</td>

                            <td>{{ $item->no_hp }}</td>

                            <td class="text-center">
                                <span class="badge badge-primary p-2">
                                    {{ $target }}
                                </span>
                            </td>

                            <td class="text-center">
                                {{ $item->realisasi }}
                            </td>

                            <td class="text-center">

                                <div class="progress">

                                    @php
                                        $persentase = $target > 0
                                            ? min(($item->realisasi / $target) * 100, 100)
                                            : 0;
                                    @endphp

                                    <div class="progress-bar bg-success"
                                        role="progressbar"
                                        style="width: {{ $persentase }}%">

                                        {{ number_format($persentase, 0) }}%

                                    </div>

                                </div>

                            </td>

                            <td class="text-center">

                                @if($item->realisasi >= $target)
                                    <span class="badge badge-success">
                                        Target Tercapai
                                    </span>
                                @elseif($item->realisasi > 0)
                                    <span class="badge badge-warning">
                                        Belum Mencapai Target
                                    </span>
                                @else
                                    <span class="badge badge-secondary">
                                        Belum Ada
                                    </span>
                                @endif

                            </td>

                            <td class="text-center">

                                <a href="{{ route('admin.target.detail', $item->id) }}"
                                class="btn btn-info btn-sm"
                                title="Lihat Detail">

                                    <i class="fas fa-eye"></i>

                                </a>

                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td colspan="9" class="text-center">

                                Tidak ada data teknisi.

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