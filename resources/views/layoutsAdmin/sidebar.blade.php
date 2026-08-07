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

    <!-- Operasional -->
    <div class="sidebar-heading">
        Operasional
    </div>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseOperasional">
            <i class="fas fa-tools"></i>
            <span>Operasional</span>
        </a>

        <div id="collapseOperasional" class="collapse" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">

                <a class="collapse-item" href="{{ route('admin.pekerjaan') }}">
                    <i class="fas fa-clipboard-list mr-2"></i> Pekerjaan
                </a>

                <a class="collapse-item" href="{{ route('admin.monitoring') }}">
                    <i class="fas fa-chart-line mr-2"></i> Monitoring
                </a>

                <a class="collapse-item" href="{{ route('admin.absensi') }}">
                    <i class="fas fa-user-check mr-2"></i> Absensi
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
                <h6 class="collapse-header">Laporan</h6>

                <a class="collapse-item" href="{{ route('admin.laporan') }}">
                    Kelola Laporan
                </a>

            </div>
        </div>
    </li>

    <!-- Profil -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseProfil">
            <i class="fas fa-user-circle"></i>
            <span>Profil</span>
        </a>

        <div id="collapseProfil" class="collapse" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Profil</h6>

                <a class="collapse-item" href="{{ route('admin.profil') }}">
                    Kelola Profil
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