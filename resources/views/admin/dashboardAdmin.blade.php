@extends('layoutsAdmin.master')

@section('content')

<div class="container-fluid">

    <!-- ============================= -->
    <!-- HEADER -->
    <!-- ============================= -->

    <div class="card shadow-lg border-0 mb-4">

        <div class="card-body">

            <div class="row align-items-center">

                <div class="col-lg-8">

                    <h2 class="font-weight-bold text-primary mb-2">
                        Dashboard Monitoring Produktivitas
                    </h2>

                    <h5 class="text-secondary mb-3">
                        PLASA TELKOM MAJENE
                    </h5>

                    <p class="mb-0 text-muted">

                        Selamat datang,

                        <strong>{{ Auth::user()->nama }}</strong>

                        <br>

                        Pantau produktivitas teknisi, absensi, pekerjaan,
                        target harian, serta lokasi teknisi secara real-time.

                    </p>

                </div>

                <div class="col-lg-4 text-center">

                    <i class="fas fa-chart-line text-primary"
                       style="font-size:90px"></i>

                    <h6 class="mt-3 mb-1">
                        {{ now()->translatedFormat('l') }}
                    </h6>

                    <h5>
                        {{ now()->translatedFormat('d F Y') }}
                    </h5>

                    <span class="badge badge-success px-3 py-2">
                        {{ now()->format('H:i') }} WITA
                    </span>

                </div>

            </div>

        </div>

    </div>


    <!-- ============================= -->
    <!-- KPI -->
    <!-- ============================= -->

    <div class="row">

        <!-- TOTAL TEKNISI -->

        <div class="col-xl-3 col-md-6 mb-4">

            <div class="card border-left-primary shadow h-100 py-2">

                <div class="card-body">

                    <div class="row no-gutters align-items-center">

                        <div class="col mr-2">

                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Teknisi
                            </div>

                            <div class="h3 mb-0 font-weight-bold text-gray-800">
                                {{ $totalTeknisi }}
                            </div>

                        </div>

                        <div class="col-auto">

                            <i class="fas fa-users fa-3x text-gray-300"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        <!-- ONLINE -->

        <div class="col-xl-3 col-md-6 mb-4">

            <div class="card border-left-success shadow h-100 py-2">

                <div class="card-body">

                    <div class="row no-gutters align-items-center">

                        <div class="col mr-2">

                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Teknisi Online
                            </div>

                            <div class="h3 mb-0 font-weight-bold text-gray-800">
                                {{ $online }}
                            </div>

                        </div>

                        <div class="col-auto">

                            <i class="fas fa-user-check fa-3x text-gray-300"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        <!-- PEKERJAAN -->

        <div class="col-xl-3 col-md-6 mb-4">

            <div class="card border-left-warning shadow h-100 py-2">

                <div class="card-body">

                    <div class="row no-gutters align-items-center">

                        <div class="col mr-2">

                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Pekerjaan Hari Ini
                            </div>

                            <div class="h3 mb-0 font-weight-bold text-gray-800">
                                {{ $totalPekerjaan }}
                            </div>

                        </div>

                        <div class="col-auto">

                            <i class="fas fa-clipboard-check fa-3x text-gray-300"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        <!-- TARGET -->

        <div class="col-xl-3 col-md-6 mb-4">

            <div class="card border-left-danger shadow h-100 py-2">

                <div class="card-body">

                    <div class="row no-gutters align-items-center">

                        <div class="col mr-2">

                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Target Tercapai
                            </div>

                            <div class="h3 mb-0 font-weight-bold text-gray-800">
                                {{ $targetTercapai }}
                            </div>

                        </div>

                        <div class="col-auto">

                            <i class="fas fa-bullseye fa-3x text-gray-300"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>


    <!-- ============================= -->
    <!-- MONITORING TEKNISI PER DIVISI -->
    <!-- ============================= -->

    @forelse($monitoringDivisi as $namaDivisi => $teknisiDivisi)

        <div class="card shadow mb-4">

            <!-- HEADER DIVISI -->

            <div class="card-header py-3 d-flex justify-content-between align-items-center">

                <h6 class="m-0 font-weight-bold text-primary">

                    <i class="fas fa-users mr-2"></i>

                    Monitoring Teknisi - {{ $namaDivisi }}

                </h6>

                <span class="badge badge-primary">

                    {{ $teknisiDivisi->count() }} Teknisi

                </span>

            </div>


            <!-- BODY -->

            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-hover table-bordered align-middle">

                        <thead class="thead-light">

                            <tr>

                                <th>
                                    Teknisi
                                </th>

                                <th>
                                    Divisi
                                </th>

                                <th>
                                    Status
                                </th>

                                <th>
                                    Pekerjaan
                                </th>

                                <th>
                                    Target
                                </th>

                                <th width="220">
                                    Progress
                                </th>

                                <th width="100">
                                    Lokasi
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                        @foreach($teknisiDivisi as $item)

                            <tr>

                                <!-- TEKNISI -->

                                <td>

                                    <strong>
                                        {{ $item->user->nama }}
                                    </strong>

                                    <br>

                                    <small class="text-muted">
                                        NIK: {{ $item->nik }}
                                    </small>

                                </td>


                                <!-- DIVISI -->

                                <td>

                                    <span class="badge badge-info">

                                        {{ $item->divisi->nama_divisi }}

                                    </span>

                                </td>


                                <!-- STATUS -->

                                <td>

                                    @if(optional($item->user->absensiTerakhir)->status == 'aktif')

                                        <span class="badge badge-success">

                                            <i class="fas fa-circle mr-1"></i>

                                            Online

                                        </span>

                                    @else

                                        <span class="badge badge-secondary">

                                            <i class="fas fa-circle mr-1"></i>

                                            Offline

                                        </span>

                                    @endif

                                </td>


                                <!-- PEKERJAAN -->

                                <td>

                                    {{ $item->jumlahPekerjaan }}

                                </td>


                                <!-- TARGET -->

                                <td>

                                    {{ $item->target }}

                                </td>


                                <!-- PROGRESS -->

                                <td>

                                    <div class="progress"
                                         style="height:20px;">

                                        <div
                                            class="progress-bar
                                            @if($item->persentase >= 100)
                                                bg-success
                                            @elseif($item->persentase >= 50)
                                                bg-warning
                                            @else
                                                bg-danger
                                            @endif"
                                            role="progressbar"
                                            style="width: {{ $item->persentase }}%;"
                                        >

                                            {{ round($item->persentase) }}%

                                        </div>

                                    </div>

                                </td>


                                <!-- LOKASI -->

                                <td class="text-center">

                                    @if($item->user->lokasiTerakhir)

                                        <a
                                            href="{{ route('admin.divisi.detail', $item->divisi_id) }}"
                                            class="btn btn-sm btn-primary"
                                            title="Lihat lokasi"
                                        >

                                            <i class="fas fa-map-marker-alt"></i>

                                        </a>

                                    @else

                                        <span class="badge badge-light">

                                            -

                                        </span>

                                    @endif

                                </td>

                            </tr>

                        @endforeach

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    @empty

        <div class="card shadow mb-4">

            <div class="card-body text-center text-muted">

                <i class="fas fa-users fa-3x mb-3"></i>

                <p class="mb-0">
                    Belum ada data teknisi.
                </p>

            </div>

        </div>

    @endforelse


    <!-- ============================= -->
    <!-- PETA LOKASI TEKNISI -->
    <!-- ============================= -->

    <div class="card shadow mb-4">

        <div class="card-header py-3 d-flex justify-content-between align-items-center">

            <h5 class="m-0 font-weight-bold text-danger">

                <i class="fas fa-map-marked-alt mr-2"></i>

                Peta Lokasi Teknisi

            </h5>

            <span
                class="badge badge-success"
                id="statusMap"
            >

                <i class="fas fa-circle mr-1"></i>

                Live

            </span>

        </div>


        <div class="card-body">

            <div
                id="map"
                style="height:550px;width:100%;border-radius:10px;"
            ></div>

        </div>

    </div>

</div>


<!-- ============================= -->
<!-- LEAFLET MAP -->
<!-- ============================= -->

@push('scripts')

<script>

document.addEventListener('DOMContentLoaded', function () {

    const lokasiTeknisi = @json($lokasiTeknisi);


    // =============================
    // INISIALISASI PETA
    // =============================

    const map = L.map('map').setView(
        [-3.5402, 118.9707],
        13
    );


    // =============================
    // OPEN STREET MAP
    // =============================

    L.tileLayer(
        'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
        {
            maxZoom: 19,

            attribution:
                '&copy; OpenStreetMap contributors'
        }
    ).addTo(map);


    // =============================
    // PENYIMPAN MARKER
    // =============================

    const markers = [];


    // =============================
    // TAMPILKAN LOKASI TEKNISI
    // =============================

    lokasiTeknisi.forEach(function (lokasi) {

        if (!lokasi.latitude || !lokasi.longitude) {
            return;
        }


        const latitude = parseFloat(
            lokasi.latitude
        );

        const longitude = parseFloat(
            lokasi.longitude
        );


        if (
            isNaN(latitude) ||
            isNaN(longitude)
        ) {
            return;
        }


        // =============================
        // DATA TEKNISI
        // =============================

        const nama = lokasi.user
            ? lokasi.user.nama
            : 'Teknisi';


        const divisi =
            lokasi.user &&
            lokasi.user.divisi
                ? lokasi.user.divisi.nama_divisi
                : '-';


        const status =
            lokasi.user &&
            lokasi.user.absensi_terakhir
                ? lokasi.user.absensi_terakhir.status
                : '-';


        const waktu =
            lokasi.waktu_update
                ? lokasi.waktu_update
                : '-';


        // =============================
        // MARKER
        // =============================

        const marker = L.marker([
            latitude,
            longitude
        ]).addTo(map);


        // =============================
        // POPUP
        // =============================

        marker.bindPopup(`

            <div style="min-width:220px;">

                <h6 class="font-weight-bold mb-2">
                    ${nama}
                </h6>

                <div class="mb-1">

                    <strong>Divisi:</strong>

                    ${divisi}

                </div>

                <div class="mb-1">

                    <strong>Status:</strong>

                    ${status}

                </div>

                <div class="mb-1">

                    <strong>Latitude:</strong>

                    ${latitude}

                </div>

                <div class="mb-1">

                    <strong>Longitude:</strong>

                    ${longitude}

                </div>

                <div class="text-muted mt-2">

                    <small>

                        Update:

                        ${waktu}

                    </small>

                </div>

            </div>

        `);


        markers.push(marker);

    });


    // =============================
    // ZOOM OTOMATIS
    // =============================

    if (markers.length > 0) {

        const group =
            L.featureGroup(markers);

        map.fitBounds(
            group.getBounds(),
            {
                padding: [40, 40]
            }
        );

    }


    // =============================
    // PERBAIKI UKURAN PETA
    // =============================

    setTimeout(function () {

        map.invalidateSize();

    }, 500);

});

</script>

@endpush


@endsection