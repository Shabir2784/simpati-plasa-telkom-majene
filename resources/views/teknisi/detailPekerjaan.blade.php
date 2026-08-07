@extends('layoutsTeknisi.master')

@section('content')

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
            <strong>Informasi Pekerjaan</strong>
        </div>

        <div class="card-body">

            <div class="row">

                <div class="col-md-6">

                    <table class="table table-borderless">

                        <tr>
                            <th width="180">Nomor Tiket</th>
                            <td>{{ $pekerjaan->nomor_tiket }}</td>
                        </tr>

                        <tr>
                            <th>Nama Pelanggan</th>
                            <td>{{ $pekerjaan->nama_pelanggan }}</td>
                        </tr>

                        <tr>
                            <th>Alamat</th>
                            <td>{{ $pekerjaan->alamat_pelanggan }}</td>
                        </tr>

                        <tr>
                            <th>Jenis Pekerjaan</th>
                            <td>{{ $pekerjaan->jenis_pekerjaan }}</td>
                        </tr>

                        <tr>
                            <th>Tanggal</th>
                            <td>{{ $pekerjaan->tanggal }}</td>
                        </tr>

                        <tr>
                            <th>Jam Selesai</th>
                            <td>{{ $pekerjaan->jam_selesai }}</td>
                        </tr>

                        <tr>
                            <th>Status</th>
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
                        </tr>

                    </table>

                </div>

                <div class="col-md-6 text-center">

                    @if($pekerjaan->foto)

                        <img src="{{ asset('storage/'.$pekerjaan->foto) }}"
                             class="img-fluid rounded shadow">

                    @else

                        <img src="https://via.placeholder.com/400x300?text=Tidak+Ada+Foto"
                             class="img-fluid rounded shadow">

                    @endif

                </div>

            </div>

            <hr>

            <h5>Deskripsi Pekerjaan</h5>

            <div class="border rounded p-3 bg-light">

                {{ $pekerjaan->deskripsi }}

            </div>

        </div>

    </div>

</div>

@endsection