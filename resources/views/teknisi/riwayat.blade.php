@extends('layoutsTeknisi.master')

@section('content')

<div class="container-fluid">

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
            <strong>Daftar Pekerjaan Teknisi</strong>
        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-hover">

                    <thead class="thead-light">

                        <tr>
                            <th>No</th>
                            <th>No Tiket</th>
                            <th>Pelanggan</th>
                            <th>Jenis</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>Foto</th>
                            <th>Aksi</th>
                        </tr>

                    </thead>

                    <tbody>

                    @forelse($pekerjaans as $pekerjaan)

                        <tr>

                            <td>{{ $loop->iteration }}</td>

                            <td>
                                {{ $pekerjaan->nomor_tiket }}
                            </td>

                            <td>
                                {{ $pekerjaan->nama_pelanggan }}
                            </td>

                            <td>
                                {{ $pekerjaan->jenis_pekerjaan }}
                            </td>

                            <td>
                                {{ $pekerjaan->tanggal }}
                            </td>

                            <td>

                                @if($pekerjaan->status=='selesai')

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

                                @if($pekerjaan->foto)

                                    <img src="{{ asset('storage/'.$pekerjaan->foto) }}"
                                         width="70"
                                         class="img-thumbnail">

                                @else

                                    -

                                @endif

                            </td>

                            <td>

                                <a href="{{ route('teknisi.detailPekerjaan',$pekerjaan->id) }}"
                                    class="btn btn-info btn-sm">

                                    <i class="fas fa-eye"></i>

                                    Detail

                                </a>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="8" class="text-center text-muted">

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

</div>

@endsection