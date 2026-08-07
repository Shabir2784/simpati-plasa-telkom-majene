@extends('layoutsTeknisi.master')

@section('content')

<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800">
        Edit Profil
    </h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="row">

        <div class="col-lg-8">

            <div class="card shadow">

                <div class="card-header bg-warning text-white">

                    Edit Data Profil

                </div>

                <div class="card-body">

                    <form action="{{ route('teknisi.profil.update') }}" method="POST">

                        @csrf
                        @method('PUT')

                        <div class="form-group">

                            <label>Nama</label>

                            <input type="text"
                                   name="nama"
                                   class="form-control"
                                   value="{{ old('nama', Auth::user()->nama) }}"
                                   required>

                        </div>

                        <div class="form-group">

                            <label>Email</label>

                            <input type="email"
                                   name="email"
                                   class="form-control"
                                   value="{{ old('email', Auth::user()->email) }}"
                                   required>

                        </div>

                        <div class="form-group">

                            <label>NIK</label>

                            <input type="text"
                                   class="form-control"
                                   value="{{ $teknisi->nik }}"
                                   readonly>

                        </div>

                        <div class="form-group">

                            <label>Divisi</label>

                            <input type="text"
                                   class="form-control"
                                   value="{{ $teknisi->divisi->nama_divisi }}"
                                   readonly>

                        </div>

                        <div class="form-group">

                            <label>No HP</label>

                            <input type="text"
                                   name="no_hp"
                                   class="form-control"
                                   value="{{ old('no_hp', $teknisi->no_hp) }}"
                                   required>

                        </div>

                        <div class="form-group">

                            <label>Alamat</label>

                            <textarea name="alamat"
                                      class="form-control"
                                      rows="4"
                                      required>{{ old('alamat', $teknisi->alamat) }}</textarea>

                        </div>

                        <button type="submit" class="btn btn-success">

                            <i class="fas fa-save"></i>

                            Simpan Perubahan

                        </button>

                        <a href="{{ route('teknisi.profil') }}"
                           class="btn btn-secondary">

                            <i class="fas fa-arrow-left"></i>

                            Kembali

                        </a>

                    </form>

                </div>

            </div>

        </div>

        <div class="col-lg-4">

            <div class="card shadow">

                <div class="card-body text-center">

                    <img src="{{ asset('admin/img/undraw_profile.svg') }}"
                         class="rounded-circle mb-3"
                         width="160">

                    <h5>{{ Auth::user()->nama }}</h5>

                    <p class="text-muted">

                        {{ $teknisi->divisi->nama_divisi }}

                    </p>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection