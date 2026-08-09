@extends('layoutsAdmin.master')

@section('content')

<h1 class="h3 mb-4 text-gray-800">
    Divisi {{ $divisi->nama_divisi }}
</h1>

<div class="row">

    {{-- DAFTAR TEKNISI --}}
    <div class="col-md-4">

        <div class="card shadow">

            <div class="card-header bg-primary text-white">
                <strong>Daftar Teknisi</strong>
            </div>

            <div class="card-body p-0">

                @forelse($divisi->teknisis as $teknisi)

                    @php
                        $absensi = $teknisi->user->absensiTerakhir;
                        $lokasi = $teknisi->user->lokasiTerakhir;

                        $online = $absensi
                            && $absensi->status == 'aktif'
                            && !$absensi->jam_keluar;
                    @endphp

                    <a href="javascript:void(0)"
                       class="list-group-item list-group-item-action btn-lokasi"
                       data-id="{{ $teknisi->id }}"
                       data-nama="{{ $teknisi->user->nama }}"
                       data-divisi="{{ $divisi->nama_divisi }}"
                       data-status="{{ $online ? 'Online' : 'Offline' }}"
                       data-lat="{{ optional($lokasi)->latitude }}"
                       data-lng="{{ optional($lokasi)->longitude }}"
                       data-waktu="{{ optional($lokasi)->waktu_update ? \Carbon\Carbon::parse($lokasi->waktu_update)->format('Y-m-d H:i:s') : '-' }}">

                        <strong>
                            {{ $teknisi->user->nama }}
                        </strong>

                        @if($online)

                            <span class="badge badge-success float-right">
                                ● Online
                            </span>

                        @else

                            <span class="badge badge-dark float-right">
                                ● Offline
                            </span>

                        @endif

                    </a>

                @empty

                    <div class="text-center text-muted p-4">
                        Belum ada teknisi pada divisi ini.
                    </div>

                @endforelse

            </div>

        </div>

    </div>


    {{-- MAP --}}
    <div class="col-md-8">

        <div class="card shadow">

            <div class="card-header bg-success text-white">

                <strong>
                    Lokasi Teknisi
                </strong>

            </div>

            <div class="card-body">

                <div id="map"
                     style="height:550px;width:100%;border-radius:10px;">
                </div>

            </div>

        </div>

    </div>

</div>

@endsection


@push('scripts')

<script>

document.addEventListener('DOMContentLoaded', function () {

    // ==========================================
    // INISIALISASI MAP
    // ==========================================

    const map = L.map('map').setView(
        [-3.5402, 118.9707],
        13
    );


    // ==========================================
    // OPEN STREET MAP
    // ==========================================

    L.tileLayer(
        'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
        {
            maxZoom: 19,
            attribution: '&copy; OpenStreetMap contributors'
        }
    ).addTo(map);


    // ==========================================
    // MARKER AKTIF
    // ==========================================

    let markerAktif = null;


    // ==========================================
    // KLIK TEKNISI
    // ==========================================

    document.querySelectorAll('.btn-lokasi').forEach(function (teknisi) {

        teknisi.addEventListener('click', function () {

            const nama = this.dataset.nama;
            const divisi = this.dataset.divisi;
            const status = this.dataset.status;
            const lat = parseFloat(this.dataset.lat);
            const lng = parseFloat(this.dataset.lng);
            const waktu = this.dataset.waktu;


            // ==================================
            // CEK LOKASI
            // ==================================

            if (isNaN(lat) || isNaN(lng)) {

                alert(
                    'Lokasi teknisi ' +
                    nama +
                    ' belum tersedia.'
                );

                return;
            }


            // ==================================
            // HAPUS MARKER SEBELUMNYA
            // ==================================

            if (markerAktif) {

                map.removeLayer(markerAktif);

                markerAktif = null;
            }


            // ==================================
            // STATUS BADGE
            // ==================================

            let badgeStatus = '';

            if (status === 'Online') {

                badgeStatus =
                    '<span style="' +
                    'background:#1cc88a;' +
                    'color:white;' +
                    'padding:3px 7px;' +
                    'border-radius:4px;' +
                    'font-size:12px;' +
                    'font-weight:bold;' +
                    '">' +
                    '● Online' +
                    '</span>';

            } else {

                badgeStatus =
                    '<span style="' +
                    'background:#5a5c69;' +
                    'color:white;' +
                    'padding:3px 7px;' +
                    'border-radius:4px;' +
                    'font-size:12px;' +
                    'font-weight:bold;' +
                    '">' +
                    '● Offline' +
                    '</span>';
            }


            // ==================================
            // POPUP
            // ==================================

            const popupContent = `

                <div style="min-width:230px;">

                    <h5 style="
                        margin-bottom:8px;
                        font-weight:bold;
                    ">
                        ${nama}
                    </h5>

                    <div style="margin-bottom:5px;">
                        <strong>Divisi:</strong>
                        ${divisi}
                    </div>

                    <div style="margin-bottom:5px;">
                        <strong>Status:</strong>
                        ${badgeStatus}
                    </div>

                    <div style="margin-bottom:5px;">
                        <strong>Latitude:</strong>
                        ${lat}
                    </div>

                    <div style="margin-bottom:5px;">
                        <strong>Longitude:</strong>
                        ${lng}
                    </div>

                    <div style="
                        margin-top:8px;
                        color:#858796;
                        font-size:12px;
                    ">
                        Update: ${waktu}
                    </div>

                </div>

            `;


            // ==================================
            // BUAT MARKER
            // ==================================

            markerAktif = L.marker([
                lat,
                lng
            ])
            .addTo(map);


            // ==================================
            // POPUP MARKER
            // ==================================

            markerAktif
                .bindPopup(popupContent)
                .openPopup();


            // ==================================
            // FOKUS KE LOKASI TEKNISI
            // ==================================

            map.setView(
                [
                    lat,
                    lng
                ],
                17,
                {
                    animate: true
                }
            );


            // ==================================
            // PERBAIKI UKURAN MAP
            // ==================================

            setTimeout(function () {

                map.invalidateSize();

            }, 300);

        });

    });


    // ==========================================
    // PERBAIKI UKURAN MAP SAAT LOAD
    // ==========================================

    setTimeout(function () {

        map.invalidateSize();

    }, 500);

});

</script>

@endpush