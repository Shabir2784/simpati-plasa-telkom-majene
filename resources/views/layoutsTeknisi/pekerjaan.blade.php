@extends('layoutsTeknisi.master')

@section('content')

<div class="container-fluid">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">

        <h1 class="h3 mb-0 text-gray-800">

            Input Pekerjaan

        </h1>

    </div>

    @if(session('success'))

        <div class="alert alert-success">

            {{ session('success') }}

        </div>

    @endif

    @if($errors->any())

        <div class="alert alert-danger">

            <ul class="mb-0">

                @foreach($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif

    <div class="card shadow mb-4">

        <div class="card-header bg-primary text-white">

            <strong>

                Form Input Produktivitas Teknisi

            </strong>

        </div>

        <div class="card-body">

            <form
                action="{{ route('teknisi.pekerjaan.store') }}"
                method="POST"
                enctype="multipart/form-data">

                @csrf

                <div class="row">

                    <div class="col-lg-6">

                        <div class="form-group">

                            <label>

                                Nomor Tiket

                            </label>

                            <input
                                type="text"
                                class="form-control"
                                name="nomor_tiket"
                                placeholder="Contoh : IN123456789">

                        </div>

                    </div>

                    <div class="col-lg-6">

                        <div class="form-group">

                            <label>

                                Nama Pelanggan

                            </label>

                            <input
                                type="text"
                                class="form-control"
                                name="nama_pelanggan">

                        </div>

                    </div>

                </div>

                <div class="row">

                    <div class="col-lg-6">

                        <div class="form-group">

                            <label>

                                Jenis Pekerjaan

                            </label>

                            <select
                                class="form-control"
                                name="jenis_pekerjaan">

                                <option value="">

                                    -- Pilih --

                                </option>

                                <option>

                                    Gangguan Internet

                                </option>

                                <option>

                                    Pasang Baru

                                </option>

                                <option>

                                    Migrasi

                                </option>

                                <option>

                                    Upgrade

                                </option>

                                <option>

                                    Maintenance

                                </option>

                                <option>

                                    Lainnya

                                </option>

                            </select>

                        </div>

                    </div>

                    <div class="col-lg-6">

                        <div class="form-group">

                            <label>

                                Upload Foto Bukti

                            </label>

                            <input
                                type="file"
                                class="form-control-file"
                                name="foto">

                        </div>

                    </div>

                </div>

                <div class="form-group">

                    <label>

                        Alamat Pelanggan

                    </label>

                    <textarea
                        class="form-control"
                        rows="3"
                        name="alamat_pelanggan"></textarea>

                </div>

                <div class="form-group">

                    <label>

                        Deskripsi Pekerjaan

                    </label>

                    <textarea
                        class="form-control"
                        rows="5"
                        name="deskripsi"
                        placeholder="Jelaskan pekerjaan yang telah dilakukan..."></textarea>

                </div>

                <hr>

                <div class="text-right">

                    <button
                        type="reset"
                        class="btn btn-secondary">

                        <i class="fas fa-undo"></i>

                        Reset

                    </button>

                    <button
                        type="submit"
                        class="btn btn-primary">

                        <i class="fas fa-save"></i>

                        Simpan Pekerjaan

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection