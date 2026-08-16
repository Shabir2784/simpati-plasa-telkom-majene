@extends('layoutsTeknisi.master')

@section('content')

<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800">
        Dashboard Teknisi
    </h1>


    {{-- NOTIFIKASI SUCCESS --}}
    @if(session('success'))

        <div class="alert alert-success alert-dismissible fade show">

            {{ session('success') }}

            <button
                class="close"
                data-dismiss="alert"
            >
                &times;
            </button>

        </div>

    @endif


    {{-- NOTIFIKASI ERROR --}}
    @if(session('error'))

        <div class="alert alert-danger alert-dismissible fade show">

            {{ session('error') }}

            <button
                class="close"
                data-dismiss="alert"
            >
                &times;
            </button>

        </div>

    @endif


    {{-- ========================================================= --}}
    {{-- INFORMASI DASHBOARD --}}
    {{-- ========================================================= --}}

    <div class="row">


        {{-- STATUS KERJA --}}
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


        {{-- STATUS ABSENSI --}}
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


        {{-- JUMLAH PEKERJAAN --}}
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


        {{-- TARGET --}}
        <div class="col-xl-3 col-md-6 mb-4">

            <div class="card border-left-info shadow">

                <div class="card-body">

                    <h6>
                        Target Hari Ini
                    </h6>

                    <h3>
                        {{ $jumlahPekerjaan }} / {{ $targetHarian }}
                    </h3>

                    <div class="progress mt-3">

                        <div
                            class="progress-bar bg-success"
                            role="progressbar"
                            style="width: {{ $persentase }}%"
                        >

                            {{ number_format($persentase, 0) }}%

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- CHECK IN / CHECK OUT --}}
    {{-- ========================================================= --}}

    <div class="card shadow mb-4">

        <div class="card-header bg-success text-white">

            <h6 class="m-0 font-weight-bold">
                Absensi Teknisi
            </h6>

        </div>


        <div class="card-body text-center">


            {{-- STATUS --}}
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


            {{-- ================================================= --}}
            {{-- BELUM CHECK IN --}}
            {{-- ================================================= --}}

            @if(!$absensi)


                @if($bolehCheckIn)

                    <form
                        action="{{ route('teknisi.checkin') }}"
                        method="POST"
                        id="checkinForm"
                    >

                        @csrf

                        <input
                            type="hidden"
                            name="latitude"
                            id="latitude"
                        >

                        <input
                            type="hidden"
                            name="longitude"
                            id="longitude"
                        >


                        <button
                            type="submit"
                            class="btn btn-success btn-lg mt-3"
                        >

                            <i class="fas fa-sign-in-alt"></i>

                            Check In

                        </button>

                    </form>


                @else

                    <button
                        type="button"
                        class="btn btn-secondary btn-lg mt-3"
                        disabled
                    >

                        <i class="fas fa-clock"></i>

                        Check In Dibuka Pukul 07.00

                    </button>

                @endif



            {{-- ================================================= --}}
            {{-- SUDAH CHECK IN, BELUM CHECK OUT --}}
            {{-- ================================================= --}}

            @elseif(!$absensi->jam_keluar)


                @if($bolehCheckOut)


                    <form
                        action="{{ route('teknisi.checkout') }}"
                        method="POST"
                        id="checkoutForm"
                    >

                        @csrf

                        <input
                            type="hidden"
                            name="latitude"
                            id="latitude_out"
                        >

                        <input
                            type="hidden"
                            name="longitude"
                            id="longitude_out"
                        >


                        <button
                            type="submit"
                            class="btn btn-danger btn-lg mt-3"
                        >

                            <i class="fas fa-sign-out-alt"></i>

                            Check Out

                        </button>

                    </form>


                @else


                    <button
                        type="button"
                        class="btn btn-secondary btn-lg mt-3"
                        disabled
                    >

                        <i class="fas fa-clock"></i>

                        Check Out Dibuka Pukul 17.00

                    </button>


                @endif



            {{-- ================================================= --}}
            {{-- SUDAH CHECK OUT --}}
            {{-- ================================================= --}}

            @else


                <button
                    type="button"
                    class="btn btn-secondary btn-lg mt-3"
                    disabled
                >

                    <i class="fas fa-check-circle"></i>

                    Absensi Selesai

                </button>


            @endif


        </div>

    </div>

</div>


{{-- ========================================================= --}}
{{-- JAVASCRIPT CHECK IN --}}
{{-- ========================================================= --}}

@if(!$absensi && $bolehCheckIn)

<script>

document.addEventListener('DOMContentLoaded', function () {

    const checkinForm = document.getElementById('checkinForm');

    if (checkinForm) {

        checkinForm.addEventListener('submit', function(e) {

            e.preventDefault();

            navigator.geolocation.getCurrentPosition(

                function(position) {

                    document.getElementById('latitude').value =
                        position.coords.latitude;

                    document.getElementById('longitude').value =
                        position.coords.longitude;

                    checkinForm.submit();

                },

                function(error) {

                    alert(
                        'Lokasi tidak dapat diperoleh: ' +
                        error.message
                    );

                }

            );

        });

    }

});

</script>

@endif


{{-- ========================================================= --}}
{{-- JAVASCRIPT UPDATE LOKASI + CHECK OUT --}}
{{-- ========================================================= --}}

@if($absensi && !$absensi->jam_keluar)

<script>

document.addEventListener('DOMContentLoaded', function () {


    /*
    |------------------------------------------------------------
    | UPDATE LOKASI SETIAP 30 DETIK
    |------------------------------------------------------------
    */

    setInterval(function () {

        navigator.geolocation.getCurrentPosition(

            function (position) {

                fetch(
                    "{{ route('teknisi.updateLokasi') }}",
                    {

                        method: "POST",

                        headers: {

                            "Content-Type": "application/json",

                            "X-CSRF-TOKEN":
                                "{{ csrf_token() }}"

                        },

                        body: JSON.stringify({

                            latitude:
                                position.coords.latitude,

                            longitude:
                                position.coords.longitude

                        })

                    }
                );

            },

            function (error) {

                console.log(
                    'Lokasi tidak dapat diperbarui: ' +
                    error.message
                );

            }

        );

    }, 30000);


    /*
    |------------------------------------------------------------
    | CHECK OUT
    |------------------------------------------------------------
    */

    const checkoutForm =
        document.getElementById('checkoutForm');


    if (checkoutForm) {

        checkoutForm.addEventListener('submit', function(e) {

            e.preventDefault();


            navigator.geolocation.getCurrentPosition(

                function(position) {

                    document.getElementById('latitude_out').value =
                        position.coords.latitude;

                    document.getElementById('longitude_out').value =
                        position.coords.longitude;


                    checkoutForm.submit();

                },

                function(error) {

                    alert(
                        'Lokasi tidak dapat diperoleh: ' +
                        error.message
                    );

                }

            );

        });

    }

});

</script>

@endif


@endsection