@extends('layoutsTeknisi.master')

@section('content')

<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800">
        Ubah Password
    </h1>

    @if(session('success'))

        <div class="alert alert-success">

            {{ session('success') }}

        </div>

    @endif

    @if(session('error'))

        <div class="alert alert-danger">

            {{ session('error') }}

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

    <div class="row justify-content-center">

        <div class="col-lg-6">

            <div class="card shadow">

                <div class="card-header bg-primary text-white">

                    <h6 class="m-0 font-weight-bold">
                        Form Ubah Password
                    </h6>

                </div>

                <div class="card-body">

                    <form action="{{ route('password.update') }}" method="POST">

                        @csrf
                        @method('PUT')

                        <div class="form-group">

                            <label>Password Lama</label>

                            <input type="password"
                                   name="password_lama"
                                   class="form-control"
                                   required>

                        </div>

                        <div class="form-group">

                            <label>Password Baru</label>

                            <input type="password"
                                   name="password_baru"
                                   class="form-control"
                                   required>

                        </div>

                        <div class="form-group">

                            <label>Konfirmasi Password Baru</label>

                            <input type="password"
                                   name="password_baru_confirmation"
                                   class="form-control"
                                   required>

                        </div>

                        <hr>

                        <button type="submit"
                                class="btn btn-success">

                            <i class="fas fa-save"></i>

                            Simpan Password

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

    </div>

</div>

@endsection