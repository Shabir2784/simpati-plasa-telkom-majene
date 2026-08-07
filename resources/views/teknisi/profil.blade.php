@extends('layoutsTeknisi.master')

@section('content')

<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800">
        Profil Teknisi
    </h1>

    <div class="row">

        <!-- FOTO -->
        <div class="col-xl-4 col-lg-5 col-md-12 mb-4">

            <div class="card shadow h-100">

                <div class="card-body text-center">

                    <img
                        src="https://ui-avatars.com/api/?name={{ urlencode($teknisi->user->nama) }}&background=0D8ABC&color=fff&size=220"
                        class="rounded-circle img-fluid mb-3"
                        style="max-width:180px;">

                    <h4 class="font-weight-bold">
                        {{ $teknisi->user->nama }}
                    </h4>

                    <p class="text-muted mb-2">
                        {{ $teknisi->divisi->nama_divisi }}
                    </p>

                    @if($teknisi->status=="Aktif")

                        <span class="badge badge-success px-3 py-2">
                            Aktif
                        </span>

                    @else

                        <span class="badge badge-secondary px-3 py-2">
                            Tidak Aktif
                        </span>

                    @endif

                </div>

            </div>

        </div>

        <!-- DATA -->
        <div class="col-xl-8 col-lg-7 col-md-12">

            <div class="card shadow">

                <div class="card-header bg-primary text-white">

                    <strong>Informasi Teknisi</strong>

                </div>

                <div class="card-body">

                    <div class="table-responsive">

                        <table class="table table-bordered">

                            <tr>
                                <th width="30%">Nama</th>
                                <td>{{ $teknisi->user->nama }}</td>
                            </tr>

                            <tr>
                                <th>Email</th>
                                <td>{{ $teknisi->user->email }}</td>
                            </tr>

                            <tr>
                                <th>NIK</th>
                                <td>{{ $teknisi->nik }}</td>
                            </tr>

                            <tr>
                                <th>Divisi</th>
                                <td>{{ $teknisi->divisi->nama_divisi }}</td>
                            </tr>

                            <tr>
                                <th>No HP</th>
                                <td>{{ $teknisi->no_hp }}</td>
                            </tr>

                            <tr>
                                <th>Alamat</th>
                                <td>{{ $teknisi->alamat }}</td>
                            </tr>

                            <tr>
                                <th>Status</th>

                                <td>

                                    @if($teknisi->status=="Aktif")

                                        <span class="badge badge-success">
                                            Aktif
                                        </span>

                                    @else

                                        <span class="badge badge-secondary">
                                            Tidak Aktif
                                        </span>

                                    @endif

                                </td>

                            </tr>

                        </table>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection