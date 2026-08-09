<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <title>Dashboard Admin</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- FontAwesome -->
    <link href="{{ asset('admin/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,700" rel="stylesheet">

    <!-- SB Admin 2 -->
    <link href="{{ asset('admin/css/sb-admin-2.min.css') }}" rel="stylesheet">

    <!-- Leaflet CSS -->
    <link
        rel="stylesheet"
        href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    >

</head>

<body id="page-top">

<div id="wrapper">

    <!-- Sidebar -->
    @include('layoutsAdmin.sidebar')

    <div id="content-wrapper" class="d-flex flex-column">

        <div id="content">

            <!-- Navbar -->
            @include('layoutsAdmin.navbar')

            <!-- Content -->
            <div class="container-fluid">

                @yield('content')

            </div>

        </div>

        <!-- Footer -->
        @include('layoutsAdmin.footer')

    </div>

</div>


<!-- Scroll to Top -->
<a class="scroll-to-top rounded" href="#page-top">

    <i class="fas fa-angle-up"></i>

</a>


<!-- Logout Modal -->
<div
    class="modal fade"
    id="logoutModal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
>

    <div class="modal-dialog" role="document">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title" id="exampleModalLabel">
                    Ready to Leave?
                </h5>

                <button
                    class="close"
                    type="button"
                    data-dismiss="modal"
                    aria-label="Close"
                >

                    <span aria-hidden="true">
                        &times;
                    </span>

                </button>

            </div>

            <div class="modal-body">

                Select "Logout" below if you are ready to end your current session.

            </div>

            <div class="modal-footer">

                <button
                    class="btn btn-secondary"
                    type="button"
                    data-dismiss="modal"
                >
                    Cancel
                </button>

                <form method="POST" action="{{ route('logout') }}">

                    @csrf

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >
                        Logout
                    </button>

                </form>

            </div>

        </div>

    </div>

</div>


<!-- jQuery -->
<script src="{{ asset('admin/vendor/jquery/jquery.min.js') }}"></script>

<!-- Bootstrap -->
<script src="{{ asset('admin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<!-- jQuery Easing -->
<script src="{{ asset('admin/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

<!-- SB Admin 2 -->
<script src="{{ asset('admin/js/sb-admin-2.min.js') }}"></script>

<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>


<script>

    function fixSidebarState() {

        if (window.innerWidth >= 768) {

            document.body.classList.remove("sidebar-toggled");

            const sidebar = document.querySelector(".sidebar");

            if (
                sidebar &&
                sidebar.classList.contains("toggled")
            ) {

                sidebar.classList.remove("toggled");

            }

        }

    }


    document.addEventListener(
        "DOMContentLoaded",
        fixSidebarState
    );


    window.addEventListener(
        "resize",
        fixSidebarState
    );

</script>


<!-- Script dari halaman -->
@stack('scripts')


</body>

</html>