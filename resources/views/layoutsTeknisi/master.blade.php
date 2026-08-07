<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard Teknisi</title>

    <link href="{{ asset('admin/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">

    <link href="{{ asset('admin/css/sb-admin-2.min.css') }}" rel="stylesheet">

    <link rel="stylesheet"href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
</head>

<body id="page-top">

<div id="wrapper">

    @include('layoutsTeknisi.sidebar')

    <div id="content-wrapper" class="d-flex flex-column">

        <div id="content">

            @include('layoutsTeknisi.navbar')

            <div class="container-fluid">

                @yield('content')

            </div>

        </div>

    </div>

</div>
<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1">

    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title">

                    Konfirmasi Logout

                </h5>

                <button class="close" data-dismiss="modal">

                    <span>&times;</span>

                </button>

            </div>

            <div class="modal-body">

                Apakah Anda yakin ingin keluar dari sistem?

            </div>

            <div class="modal-footer">

                <button class="btn btn-secondary"
                        data-dismiss="modal">

                    Batal

                </button>

                <form action="{{ route('logout') }}" method="POST">

                    @csrf

                    <button class="btn btn-danger">

                        Logout

                    </button>

                </form>

            </div>

        </div>

    </div>

</div>

<script src="{{ asset('admin/vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('admin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('admin/js/sb-admin-2.min.js') }}"></script>


@stack('scripts')

</body>

</html>