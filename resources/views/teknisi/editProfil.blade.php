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

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row">

        {{-- FORM EDIT --}}
        <div class="col-lg-8">

            <div class="card shadow">

                <div class="card-header bg-warning text-white">
                    Edit Data Profil
                </div>

                <div class="card-body">

                    <form action="{{ route('teknisi.profil.update') }}"
                          method="POST"
                          enctype="multipart/form-data">

                        @csrf
                        @method('PUT')


                        {{-- NAMA --}}
                        <div class="form-group">

                            <label>
                                Nama
                            </label>

                            <input type="text"
                                   name="nama"
                                   class="form-control"
                                   value="{{ old('nama', Auth::user()->nama) }}"
                                   required>

                        </div>


                        {{-- NIK --}}
                        <div class="form-group">

                            <label>
                                NIK
                            </label>

                            <input type="text"
                                   class="form-control"
                                   value="{{ $teknisi->nik }}"
                                   readonly>

                            <small class="form-text text-muted">
                                NIK tidak dapat diubah.
                            </small>

                        </div>


                        {{-- DIVISI --}}
                        <div class="form-group">

                            <label>
                                Divisi
                            </label>

                            <input type="text"
                                   class="form-control"
                                   value="{{ $teknisi->divisi->nama_divisi }}"
                                   readonly>

                            <small class="form-text text-muted">
                                Divisi tidak dapat diubah.
                            </small>

                        </div>


                        {{-- NO HP --}}
                        <div class="form-group">

                            <label>
                                No HP
                            </label>

                            <input type="text"
                                   name="no_hp"
                                   class="form-control"
                                   value="{{ old('no_hp', $teknisi->no_hp) }}"
                                   required>

                        </div>


                        {{-- ALAMAT --}}
                        <div class="form-group">

                            <label>
                                Alamat
                            </label>

                            <textarea name="alamat"
                                      class="form-control"
                                      rows="4"
                                      required>{{ old('alamat', $teknisi->alamat) }}</textarea>

                        </div>


                        {{-- FOTO --}}
                        <div class="form-group">

                            <label>
                                Foto Profil
                            </label>

                            <input type="file"
                                   name="foto"
                                   class="form-control-file"
                                   accept="image/jpeg,image/png,image/jpg,image/webp">

                            <small class="form-text text-muted">
                                Format: JPG, JPEG, PNG, WEBP. Maksimal 2 MB.
                            </small>

                        </div>


                        {{-- TOMBOL --}}
                        <button type="submit"
                                class="btn btn-success">

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


        {{-- PREVIEW PROFIL --}}
        <div class="col-lg-4">

            <div class="card shadow">

                <div class="card-body text-center">

                    @if(Auth::user()->foto)

                        <img src="{{ asset('storage/' . Auth::user()->foto) }}"
                             class="rounded-circle mb-3"
                             width="160"
                             height="160"
                             style="object-fit: cover;">

                    @else

                        <img src="{{ asset('admin/img/undraw_profile.svg') }}"
                             class="rounded-circle mb-3"
                             width="160"
                             height="160">

                    @endif


                    <h5>
                        {{ Auth::user()->nama }}
                    </h5>

                    <p class="text-muted mb-1">
                        {{ $teknisi->nik }}
                    </p>

                    <p class="text-muted">
                        {{ $teknisi->divisi->nama_divisi }}
                    </p>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection