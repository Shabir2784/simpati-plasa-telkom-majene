@extends('layoutsTeknisi.master')

@section('content')

<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800">
        Ubah Password
    </h1>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fas fa-check-circle mr-2"></i>
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="fas fa-exclamation-circle mr-2"></i>
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <strong>
                <i class="fas fa-exclamation-triangle mr-2"></i>
                Periksa kembali:
            </strong>

            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row justify-content-center">

        <div class="col-lg-6 col-md-8">

            <div class="card shadow">

                <div class="card-header bg-primary text-white">

                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-lock mr-2"></i>
                        Form Ubah Password
                    </h6>

                </div>

                <div class="card-body">

                    <div class="alert alert-info">
                        <i class="fas fa-info-circle mr-2"></i>
                        Gunakan password baru minimal <strong>6 karakter</strong>.
                    </div>

                    <form action="{{ route('teknisi.password.update') }}" method="POST">

                        @csrf
                        @method('PUT')

                        {{-- Password Lama --}}
                        <div class="form-group">

                            <label class="font-weight-bold">
                                Password Lama
                            </label>

                            <div class="input-group">

                                <input
                                    type="password"
                                    name="password_lama"
                                    id="password_lama"
                                    class="form-control"
                                    placeholder="Masukkan password lama"
                                    required>

                                <div class="input-group-append">

                                    <button
                                        type="button"
                                        class="btn btn-outline-secondary toggle-password"
                                        data-target="password_lama"
                                        title="Lihat password">

                                        <i class="fas fa-eye"></i>

                                    </button>

                                </div>

                            </div>

                            <small class="text-muted">
                                Masukkan password yang sedang digunakan.
                            </small>

                        </div>

                        {{-- Password Baru --}}
                        <div class="form-group">

                            <label class="font-weight-bold">
                                Password Baru
                            </label>

                            <div class="input-group">

                                <input
                                    type="password"
                                    name="password_baru"
                                    id="password_baru"
                                    class="form-control"
                                    placeholder="Masukkan password baru"
                                    minlength="6"
                                    required>

                                <div class="input-group-append">

                                    <button
                                        type="button"
                                        class="btn btn-outline-secondary toggle-password"
                                        data-target="password_baru"
                                        title="Lihat password">

                                        <i class="fas fa-eye"></i>

                                    </button>

                                </div>

                            </div>

                            <small class="text-muted">
                                Minimal 6 karakter.
                            </small>

                        </div>

                        {{-- Konfirmasi Password --}}
                        <div class="form-group">

                            <label class="font-weight-bold">
                                Konfirmasi Password Baru
                            </label>

                            <div class="input-group">

                                <input
                                    type="password"
                                    name="password_baru_confirmation"
                                    id="password_baru_confirmation"
                                    class="form-control"
                                    placeholder="Masukkan kembali password baru"
                                    minlength="6"
                                    required>

                                <div class="input-group-append">

                                    <button
                                        type="button"
                                        class="btn btn-outline-secondary toggle-password"
                                        data-target="password_baru_confirmation"
                                        title="Lihat password">

                                        <i class="fas fa-eye"></i>

                                    </button>

                                </div>

                            </div>

                            <small id="passwordMatch" class="text-muted">
                                Pastikan password konfirmasi sama dengan password baru.
                            </small>

                        </div>

                        <hr>

                        <div class="d-flex justify-content-between">

                            <a
                                href="{{ route('teknisi.profil') }}"
                                class="btn btn-secondary">

                                <i class="fas fa-arrow-left mr-1"></i>
                                Kembali

                            </a>

                            <button
                                type="submit"
                                class="btn btn-success">

                                <i class="fas fa-save mr-1"></i>
                                Simpan Password

                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

<script>

document.addEventListener('DOMContentLoaded', function () {

    // Tampilkan / sembunyikan password
    document.querySelectorAll('.toggle-password').forEach(function (button) {

        button.addEventListener('click', function () {

            const targetId = this.getAttribute('data-target');

            const input = document.getElementById(targetId);

            const icon = this.querySelector('i');

            if (input.type === 'password') {

                input.type = 'text';

                icon.classList.remove('fa-eye');

                icon.classList.add('fa-eye-slash');

                this.setAttribute('title', 'Sembunyikan password');

            } else {

                input.type = 'password';

                icon.classList.remove('fa-eye-slash');

                icon.classList.add('fa-eye');

                this.setAttribute('title', 'Lihat password');

            }

        });

    });


    // Cek kesamaan password baru dan konfirmasi
    const passwordBaru = document.getElementById('password_baru');

    const passwordKonfirmasi = document.getElementById('password_baru_confirmation');

    const passwordMatch = document.getElementById('passwordMatch');


    function checkPassword() {

        if (passwordKonfirmasi.value === '') {

            passwordMatch.textContent =
                'Pastikan password konfirmasi sama dengan password baru.';

            passwordMatch.className = 'text-muted';

            return;

        }


        if (passwordBaru.value === passwordKonfirmasi.value) {

            passwordMatch.innerHTML =
                '<i class="fas fa-check-circle mr-1"></i>Password cocok.';

            passwordMatch.className = 'text-success';

        } else {

            passwordMatch.innerHTML =
                '<i class="fas fa-times-circle mr-1"></i>Password belum cocok.';

            passwordMatch.className = 'text-danger';

        }

    }


    passwordBaru.addEventListener('input', checkPassword);

    passwordKonfirmasi.addEventListener('input', checkPassword);

});

</script>

@endsection