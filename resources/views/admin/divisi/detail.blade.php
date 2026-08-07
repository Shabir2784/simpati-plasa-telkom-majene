@extends('layoutsAdmin.master')

@section('content')

<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800">
        Divisi {{ $divisi->nama_divisi }}
    </h1>

    <div class="row">

        <!-- Daftar Teknisi -->
        <div class="col-md-4">

            <div class="card shadow">

                <div class="card-header bg-primary text-white">
                    <strong>Daftar Teknisi</strong>
                </div>

                <div class="card-body p-0">

                    @php

                    $online = collect();

                    $offline = collect();

                    foreach ($divisi->teknisis as $teknisi) {

                        $absensi = $teknisi->user->absensiTerakhir;

                        if ($absensi && $absensi->status == 'aktif') {

                            $online->push($teknisi);

                        } else {

                            $offline->push($teknisi);

                        }

                    }

                    @endphp

                    {{-- ONLINE --}}
                    @foreach($online as $teknisi)

                    <a href="#"
                        class="list-group-item list-group-item-action btn-lokasi"
                        data-lat="{{ optional($teknisi->user->lokasiTerakhir)->latitude }}"
                        data-lng="{{ optional($teknisi->user->lokasiTerakhir)->longitude }}">

                        <strong>{{ $teknisi->user->nama }}</strong>

                        <span class="badge badge-success float-right">
                            ● Online
                        </span>

                    </a>

                    @endforeach

                    {{-- OFFLINE --}}
                    @foreach($offline as $teknisi)

                    <a href="#"
                        class="list-group-item list-group-item-action btn-lokasi"
                        data-lat="{{ optional($teknisi->user->lokasiTerakhir)->latitude }}"
                        data-lng="{{ optional($teknisi->user->lokasiTerakhir)->longitude }}">

                        <strong>{{ $teknisi->user->nama }}</strong>

                        <span class="badge badge-dark float-right">
                            ● Offline
                        </span>

                    </a>

                    @endforeach

                </div>

            </div>

        </div>

        <!-- MAP -->
        <div class="col-md-8">

            <div class="card shadow">

                <div class="card-header bg-success text-white">

                    <strong>Lokasi Teknisi</strong>

                </div>

                <div class="card-body">

                    <div id="map" style="height:550px; width:100%; border-radius:10px;"></div>

                </div>

            </div>

        </div>

    </div>

</div>

@push('scripts')
<script>

document.addEventListener("DOMContentLoaded", function () {

    var map = L.map('map').setView([-2.5489,118.0149],5);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',{
        attribution:'© OpenStreetMap',
        maxZoom:19
    }).addTo(map);

    // Marker semua teknisi
    @foreach($divisi->teknisis as $teknisi)

        @if($teknisi->user->lokasiTerakhir)

            L.marker([
                {{ $teknisi->user->lokasiTerakhir->latitude }},
                {{ $teknisi->user->lokasiTerakhir->longitude }}
            ])
            .addTo(map)
            .bindPopup("<b>{{ $teknisi->user->nama }}</b>");

        @endif

    @endforeach

    // Klik nama teknisi
    document.querySelectorAll('.btn-lokasi').forEach(function(btn){

        btn.addEventListener('click', function(e){

            e.preventDefault();

            let lat = this.dataset.lat;
            let lng = this.dataset.lng;

            if(lat && lng){

                map.setView([parseFloat(lat), parseFloat(lng)], 18);

            }else{

                alert('Lokasi teknisi belum tersedia.');

            }

        });

    });

});

</script>
@endpush
@endsection