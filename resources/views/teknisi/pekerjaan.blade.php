@extends('layoutsTeknisi.master')

@section('content')

<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800">
        Input Hasil Pekerjaan
    </h1>

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

    <div class="card shadow">

        <div class="card-header bg-primary text-white">
            <strong>Form Input Pekerjaan</strong>
        </div>

        <div class="card-body">

            <form action="{{ route('teknisi.pekerjaan.store') }}" method="POST" enctype="multipart/form-data">

                @csrf

                @php
                    $divisi = Auth::user()->divisi->nama_divisi;
                @endphp

                <div class="form-group">
                    <label>
                        {{ $divisi == 'Provisioning' ? 'Nomor WO' : 'Nomor Tiket' }}
                    </label>

                    <input
                        type="text"
                        name="nomor_referensi"
                        class="form-control"
                        placeholder="{{ $divisi == 'Provisioning' ? 'Masukkan Nomor WO' : 'Masukkan Nomor Tiket' }}"
                        required>
                </div>

                <div class="form-group">
                    <label>Nama Pelanggan</label>
                    <input type="text" name="nama_pelanggan" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Alamat Pelanggan</label>
                    <textarea name="alamat_pelanggan" class="form-control" rows="3" required></textarea>
                </div>

                <div class="form-group">
                    <label>Jenis Pekerjaan</label>
                    <select name="jenis_pekerjaan" class="form-control" required>
                        <option value="">-- Pilih --</option>
                        <option value="Gangguan Internet">Gangguan Internet</option>
                        <option value="Pasang Baru">Pasang Baru</option>
                        <option value="Migrasi">Migrasi</option>
                        <option value="Maintenance">Maintenance</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Deskripsi Pekerjaan</label>
                    <textarea name="deskripsi" class="form-control" rows="5" required></textarea>
                </div>

                <div class="form-group">
                    <label>Foto Bukti</label>
                    <input type="file" name="foto" class="form-control-file">
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i>
                    Simpan Pekerjaan
                </button>

            </form>

        </div>

    </div>

</div>

@endsection