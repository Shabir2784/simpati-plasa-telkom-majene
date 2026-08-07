@extends('layoutsTeknisi.master')

@section('content')

<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800">
        Dashboard Teknisi
    </h1>

    {{-- Notifikasi --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button class="close" data-dismiss="alert">&times;</button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button class="close" data-dismiss="alert">&times;</button>
        </div>
    @endif


    <div class="row">

        <!-- Status Kerja -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">

                <div class="card-body">

                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                        Status Kerja
                    </div>

                    <div class="h5 mb-0 font-weight-bold text-gray-800">

                        @if($absensi && $absensi->status == 'aktif')
                            Online
                        @else
                            Offline
                        @endif

                    </div>

                </div>

            </div>
        </div>


        <!-- Status Absensi -->
        <div class="col-xl-3 col-md-6 mb-4">

            <div class="card border-left-success shadow h-100 py-2">

                <div class="card-body">

                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                        Status Absensi
                    </div>

                    <div class="h5 mb-0 font-weight-bold text-gray-800">

                        @if($absensi)
                            Sudah Check In
                        @else
                            Belum Check In
                        @endif

                    </div>

                </div>

            </div>

        </div>


        <!-- Jumlah Pekerjaan -->
        <div class="col-xl-3 col-md-6 mb-4">

            <div class="card border-left-warning shadow h-100 py-2">

                <div class="card-body">

                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                        Pekerjaan Hari Ini
                    </div>

                    <div class="h5 mb-0 font-weight-bold text-gray-800">

                        {{ $jumlahPekerjaan }}

                    </div>

                </div>

            </div>

        </div>


        <!-- Target -->
        <div class="col-xl-3 col-md-6 mb-4">

            <div class="card border-left-info shadow">
                <div class="card-body">

                    <h6>Target Hari Ini</h6>

                    <h3>{{ $jumlahPekerjaan }} / {{ $targetHarian }}</h3>

                    <div class="progress mt-3">

                        <div class="progress-bar bg-success"
                            role="progressbar"
                            style="width: {{ $persentase }}%">

                            {{ number_format($persentase,0) }}%

                        </div>

                    </div>

                </div>
            </div>

        </div>

    </div>


    <!-- CHECK IN / CHECK OUT -->
    <div class="card shadow mb-4">

        <div class="card-header bg-success text-white">
            <h6 class="m-0 font-weight-bold">
                Absensi Teknisi
            </h6>
        </div>

        <div class="card-body text-center">

            <h5>

                Status :

                @if(!$absensi)

                    <span class="badge badge-secondary">
                        Belum Check In
                    </span>

                @elseif($absensi->jam_keluar)

                    <span class="badge badge-dark">
                        Sudah Check Out
                    </span>

                @else

                    <span class="badge badge-success">
                        Sedang Bekerja
                    </span>

                @endif

            </h5>

            {{-- BELUM CHECK IN --}}
            @if(!$absensi)

                @if($bolehCheckIn)

                    <form action="{{ route('teknisi.checkin') }}" method="POST" id="checkinForm">

                        @csrf

                        <input type="hidden" name="latitude" id="latitude">
                        <input type="hidden" name="longitude" id="longitude">

                        <button class="btn btn-success btn-lg mt-3">

                            <i class="fas fa-sign-in-alt"></i>

                            Check In

                        </button>

                    </form>

                @else

                    <button class="btn btn-secondary btn-lg mt-3" disabled>

                        <i class="fas fa-clock"></i>

                        Check In Dibuka Pukul 07.00

                    </button>

                @endif

            @elseif(!$absensi->jam_keluar)

            <form action="{{ route('teknisi.checkout') }}" method="POST" id="checkoutForm">

                @csrf

                <input type="hidden" name="latitude" id="latitude_out">
                <input type="hidden" name="longitude" id="longitude_out">

                <button class="btn btn-danger btn-lg mt-3">

                    <i class="fas fa-sign-out-alt"></i>

                    Check Out

                </button>

            </form>

            {{-- SUDAH CHECK OUT --}}
            @else

            <button class="btn btn-secondary btn-lg mt-3" disabled>

                <i class="fas fa-check-circle"></i>

                Absensi Selesai

            </button>

            @endif

        </div>

    </div>

</div>


@if(!$absensi)

<script>

document.getElementById('checkinForm').addEventListener('submit', function(e){

    e.preventDefault();

    navigator.geolocation.getCurrentPosition(function(position){

        document.getElementById('latitude').value = position.coords.latitude;
        document.getElementById('longitude').value = position.coords.longitude;

        document.getElementById('checkinForm').submit();

    }, function(error){

        alert(error.message);

    });

});

</script>

@endif


@if($absensi && !$absensi->jam_keluar)

<script>

// Update lokasi setiap 30 detik
setInterval(function () {

    navigator.geolocation.getCurrentPosition(function (position) {

        fetch("{{ route('teknisi.updateLokasi') }}", {

            method: "POST",

            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },

            body: JSON.stringify({

                latitude: position.coords.latitude,

                longitude: position.coords.longitude

            })

        });

    });

}, 30000);


// Script Check Out
document.getElementById('checkoutForm').addEventListener('submit', function(e){

    e.preventDefault();

    navigator.geolocation.getCurrentPosition(function(position){

        document.getElementById('latitude_out').value = position.coords.latitude;
        document.getElementById('longitude_out').value = position.coords.longitude;

        document.getElementById('checkoutForm').submit();

    }, function(error){

        alert(error.message);

    });

});

</script>

@endif

@endsection