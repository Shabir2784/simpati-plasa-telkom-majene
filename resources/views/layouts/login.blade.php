
<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>SIMPATI | Login</title>

    <link href="{{ asset('admin/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">

    <link href="{{ asset('admin/css/sb-admin-2.min.css') }}" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900" rel="stylesheet">

    <style>

        body {
            background: linear-gradient(135deg, #ffffff, #f4f6f9);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Nunito', sans-serif;
        }

        .login-card {
            width: 420px;
            border: none;
            border-radius: 18px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, .12);
            overflow: hidden;
            animation: fade .7s;
        }

        @keyframes fade {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .login-header {
            background: #E2001A;
            color: white;
            text-align: center;
            padding: 15px 20px 25px;
        }

        .login-header img {
            width: 170px;
            margin-bottom: 20px;
        }

        .login-header h2 {
            font-weight: 800;
            margin-bottom: 5px;
        }

        .login-header p {
            margin: 0;
            font-size: 14px;
            opacity: .9;
        }

        .card-body {
            padding: 35px;
        }

        .form-control {
            height: 48px;
            border-radius: 10px;
        }

        .form-control:focus {
            border-color: #E2001A;
            box-shadow: 0 0 0 .2rem rgba(226, 0, 26, .15);
        }

        .btn-login {
            background: #E2001A;
            color: white;
            height: 48px;
            border-radius: 10px;
            font-weight: 700;
        }

        .btn-login:hover {
            background: #C60017;
            color: white;
        }

        .footer {
            text-align: center;
            color: #888;
            font-size: 13px;
            margin-top: 25px;
        }

        /* NOTIFIKASI LOGIN */
        .login-alert {
            border-radius: 10px;
            font-size: 14px;
            padding: 12px 15px;
            margin-bottom: 20px;
            animation: alertFade .4s ease-in-out;
        }

        @keyframes alertFade {
            from {
                opacity: 0;
                transform: translateY(-8px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

    </style>

</head>

<body>

<div class="card login-card">

    <div class="login-header">

        <img src="{{ asset('images/logo-telkom.png') }}"
             alt="Logo Telkom"
             style="width:170px; margin-bottom:20px;">

        <h2>SIMPATI</h2>

        <p>Sistem Informasi Monitoring Produktivitas dan Absensi Teknisi</p>

    </div>

    <div class="card-body">

        {{-- NOTIFIKASI JIKA LOGIN GAGAL --}}
        @if ($errors->any())
            <div class="alert alert-danger login-alert" role="alert">

                <i class="fas fa-exclamation-circle mr-2"></i>

                <strong>Login gagal!</strong>

                <br>

                NIK atau password yang Anda masukkan salah.

            </div>
        @endif

        @yield('content')

    </div>

</div>

<script src="{{ asset('admin/vendor/jquery/jquery.min.js') }}"></script>

<script src="{{ asset('admin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

</body>

</html>

