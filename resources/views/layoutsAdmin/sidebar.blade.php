<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.dashboard') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">ADMIN</div>
    </a>

    <hr class="sidebar-divider">

    <!-- Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="{{ route('admin.dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <hr class="sidebar-divider">

    <!-- Master Data -->
    <div class="sidebar-heading">
        Master Data
    </div>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseMaster" aria-expanded="false" aria-controls="collapseMaster">
            <i class="fas fa-database"></i>
            <span>Master Data</span>
        </a>

        <div id="collapseMaster" class="collapse" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">

                <a class="collapse-item" href="{{ route('admin.teknisi') }}">
                    <i class="fas fa-users mr-2"></i> Teknisi
                </a>

                <a class="collapse-item" href="{{ route('admin.divisi') }}">
                    <i class="fas fa-building mr-2"></i> Divisi
                </a>

            </div>
        </div>
    </li>

    <!-- Target Produktivitas -->
    <div class="sidebar-heading">Target Produktivitas</div>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTarget" aria-expanded="false" aria-controls="collapseTarget">
            <i class="fas fa-bullseye"></i>
            <span>Target Produktivitas</span>
        </a>

        <div id="collapseTarget" class="collapse" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Pilih Divisi</h6>

                <a class="collapse-item" href="{{ route('admin.target.assurance') }}">
                    <i class="fas fa-network-wired mr-2"></i> Assurance
                </a>

                <a class="collapse-item" href="{{ route('admin.target.provisioning') }}">
                    <i class="fas fa-tools mr-2"></i> Provisioning
                </a>
            </div>
        </div>
    </li>


    {{-- ============================= --}}
    {{-- MONITORING --}}
    {{-- ============================= --}}

    <li class="nav-item">

        <a class="nav-link collapsed"
        href="#"
        data-toggle="collapse"
        data-target="#collapseMonitoring">

            <i class="fas fa-chart-line"></i>

            <span>Monitoring</span>

        </a>

        <div id="collapseMonitoring"
            class="collapse"
            data-parent="#accordionSidebar">

            <div class="bg-white py-2 collapse-inner rounded">

                <a class="collapse-item"
                href="{{ route('admin.monitoring.assurance') }}">

                    <i class="fas fa-users mr-2"></i>
                    Assurance

                </a>

                <a class="collapse-item"
                href="{{ route('admin.monitoring.provisioning') }}">

                    <i class="fas fa-users mr-2"></i>
                    Provisioning

                </a> 

            </div>

        </div>

    </li>


    {{-- ============================= --}}
    {{-- ABSENSI --}}
    {{-- ============================= --}}

    <li class="nav-item">

        <a class="nav-link collapsed"
        href="#"
        data-toggle="collapse"
        data-target="#collapseAbsensi">

            <i class="fas fa-user-check"></i>

            <span>Absensi</span>

        </a>

        <div id="collapseAbsensi"
            class="collapse"
            data-parent="#accordionSidebar">

            <div class="bg-white py-2 collapse-inner rounded">

                <a class="collapse-item"
                href="{{ route('admin.absensi.assurance') }}">

                    <i class="fas fa-user-check mr-2"></i>
                    Assurance

                </a>

                <a class="collapse-item"
                href="{{ route('admin.absensi.provisioning') }}">

                    <i class="fas fa-user-check mr-2"></i>
                    Provisioning

                </a>

            </div>

        </div>

    </li>

    <hr class="sidebar-divider">

    <!-- Laporan -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLaporan">
            <i class="fas fa-file-alt"></i>
            <span>Laporan</span>
        </a>

        <div id="collapseLaporan" class="collapse" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">
                Laporan Produktivitas
                </h6>

                <a class="collapse-item"
                href="{{ route('admin.laporan.assurance') }}">

                    <i class="fas fa-tools mr-2"></i>
                    Laporan Assurance

                </a>

                <a class="collapse-item"
                href="{{ route('admin.laporan.provisioning') }}">

                    <i class="fas fa-network-wired mr-2"></i>
                    Laporan Provisioning

                </a>

            </div>
        </div>
    </li>

    
    <hr class="sidebar-divider">

    <!-- Logout -->
    <li class="nav-item">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="nav-link btn btn-link text-left w-100 border-0">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </button>
        </form>
    </li>

</ul>