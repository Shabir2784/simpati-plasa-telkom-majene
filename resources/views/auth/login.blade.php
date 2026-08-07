@extends('layouts.login')

@section('content')

@if(session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif

<form method="POST" action="{{ route('login') }}" id="loginForm">

    @csrf

    <div class="form-group">

        <label>NIK</label>

        <div class="input-group">

            <div class="input-group-prepend">

                <span class="input-group-text">

                    <i class="fas fa-envelope"></i>

                </span>

            </div>

            <input type="text"
                name="nik"
                class="form-control @error('nik') is-invalid @enderror"
                value="{{ old('nik') }}"
                placeholder="Masukkan NIK"
                required
                autofocus>

        </div>

        @error('nik')

            <small class="text-danger">

                {{ $message }}

            </small>

        @enderror

    </div>

    <div class="form-group">

        <label>Password</label>

        <div class="input-group">

            <div class="input-group-prepend">

                <span class="input-group-text">

                    <i class="fas fa-lock"></i>

                </span>

            </div>

            <input type="password"
                   id="password"
                   name="password"
                   class="form-control @error('password') is-invalid @enderror"
                   placeholder="Masukkan password"
                   required>

            <div class="input-group-append">

                <button type="button"
                        class="btn btn-light"
                        onclick="togglePassword()">

                    <i class="fas fa-eye" id="eyeIcon"></i>

                </button>

            </div>

        </div>

        @error('password')

            <small class="text-danger">

                {{ $message }}

            </small>

        @enderror

    </div>

    <div class="form-group">

        <div class="custom-control custom-checkbox">

            <input type="checkbox"
                   class="custom-control-input"
                   id="remember"
                   name="remember">

            <label class="custom-control-label"
                   for="remember">

                Ingat Saya

            </label>

        </div>

    </div>

    <button type="submit"
            class="btn btn-login btn-block"
            id="btnLogin">

        <i class="fas fa-sign-in-alt"></i>

        Masuk ke Sistem

    </button>

    <div class="footer">

        <hr>

        <strong>PT Telkom Indonesia</strong>

        <br>

        Regional Sulawesi

        <br>

        <small>Versi 1.0</small>

    </div>

</form>

<script>

function togglePassword(){

    let password=document.getElementById('password');

    let eye=document.getElementById('eyeIcon');

    if(password.type==="password"){

        password.type="text";

        eye.classList.remove('fa-eye');

        eye.classList.add('fa-eye-slash');

    }else{

        password.type="password";

        eye.classList.remove('fa-eye-slash');

        eye.classList.add('fa-eye');

    }

}

document.getElementById('loginForm').addEventListener('submit',function(){

    document.getElementById('btnLogin').innerHTML=

        '<i class="fas fa-spinner fa-spin"></i> Memproses...';

});

</script>

@endsection