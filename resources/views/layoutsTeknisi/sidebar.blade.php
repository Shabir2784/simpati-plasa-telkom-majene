<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">

        <div class="sidebar-brand-text">
            Teknisi
        </div>

    </a>

    <hr class="sidebar-divider">

    <li class="nav-item">

        <a class="nav-link"
        href="{{ route('teknisi.dashboard') }}">

            <i class="fas fa-home"></i>

            <span>Dashboard</span>

        </a>

    </li>

    <li class="nav-item">

        <a class="nav-link" href="{{ route('teknisi.pekerjaan') }}">

            <i class="fas fa-clipboard-list"></i>

            <span>Input Pekerjaan</span>

        </a>

    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('teknisi.riwayat') }}">
            <i class="fas fa-history"></i>
            <span>Riwayat Pekerjaan</span>
        </a>
    </li>

</ul>