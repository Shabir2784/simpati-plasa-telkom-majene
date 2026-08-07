@extends('layoutsAdmin.master')

@section('content')

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

                    Pantau produktivitas teknisi, absensi, pekerjaan, target harian,
                    serta lokasi teknisi secara real-time.

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

<div class="row">

    <!-- Total Teknisi -->
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

    <!-- Online -->
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

    <!-- Pekerjaan -->
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

    <!-- Target -->
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

<div class="row">

    <!-- Grafik Produktivitas -->
    <div class="col-xl-8 col-lg-7">

        <div class="card shadow mb-4">

            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">

                <h6 class="m-0 font-weight-bold text-primary">
                    Grafik Produktivitas Mingguan
                </h6>

                <i class="fas fa-chart-area text-primary"></i>

            </div>

            <div class="card-body">

                <canvas id="chartProduktivitas" height="110"></canvas>

            </div>

        </div>

    </div>

    <!-- Ringkasan -->
    <div class="col-xl-4 col-lg-5">

        <div class="card shadow mb-4">

            <div class="card-header py-3">

                <h6 class="m-0 font-weight-bold text-success">

                    Ringkasan Hari Ini

                </h6>

            </div>

            <div class="card-body">

                <div class="mb-4">

                    <h6>

                        Target Produktivitas

                        <span class="float-right">
                            {{ $targetTercapai }}/{{ $totalTeknisi }}
                        </span>

                    </h6>

                    <div class="progress">

                        <div class="progress-bar bg-success"
                            style="width: {{ $totalTeknisi > 0 ? ($targetTercapai / $totalTeknisi) * 100 : 0 }}%">

                            {{ $totalTeknisi > 0 ? number_format(($targetTercapai / $totalTeknisi) * 100, 0) : 0 }}%

                        </div>

                    </div>

                </div>

                <hr>

                <div class="d-flex justify-content-between mb-2">

                    <span>

                        <i class="fas fa-users text-primary"></i>

                        Total Teknisi

                    </span>

                    <strong>{{ $totalTeknisi }}</strong>

                </div>

                <div class="d-flex justify-content-between mb-2">

                    <span>

                        <i class="fas fa-wifi text-success"></i>

                        Online

                    </span>

                    <strong>{{ $online }}</strong>

                </div>

                <div class="d-flex justify-content-between mb-2">

                    <span>

                        <i class="fas fa-power-off text-danger"></i>

                        Offline

                    </span>

                    <strong>{{ $offline }}</strong>

                </div>

                <div class="d-flex justify-content-between">

                    <span>

                        <i class="fas fa-clipboard-check text-warning"></i>

                        Tiket Hari Ini

                    </span>

                    <strong>{{ $totalPekerjaan }}</strong>

                </div>

            </div>

        </div>

    </div>

</div>

<div class="card shadow mb-4">

    <div class="card-header py-3 d-flex justify-content-between align-items-center">

        <h6 class="m-0 font-weight-bold text-primary">
            Monitoring Teknisi Hari Ini
        </h6>

        <span class="badge badge-primary">
            {{ $monitoring->count() }} Teknisi
        </span>

    </div>

    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-hover table-bordered align-middle">

                <thead class="thead-light">

                    <tr>

                        <th>Teknisi</th>

                        <th>Divisi</th>

                        <th>Status</th>

                        <th>Pekerjaan</th>

                        <th>Target</th>

                        <th width="220">Progress</th>

                        <th>Lokasi</th>

                    </tr>

                </thead>

                <tbody>

                @forelse($monitoring as $item)

                    <tr>

                        <td>

                            <strong>{{ $item->user->nama }}</strong><br>

                            <small class="text-muted">

                                {{ $item->user->email }}

                            </small>

                        </td>

                        <td>

                            <span class="badge badge-info">

                                {{ $item->divisi->nama_divisi }}

                            </span>

                        </td>

                        <td>

                            @if(optional($item->user->absensiTerakhir)->status=='aktif')

                                <span class="badge badge-success">

                                    <i class="fas fa-circle"></i>

                                    Online

                                </span>

                            @else

                                <span class="badge badge-secondary">

                                    Offline

                                </span>

                            @endif

                        </td>

                        <td>

                            {{ $item->jumlahPekerjaan }}

                        </td>

                        <td>

                            {{ $item->target }}

                        </td>

                        <td>

                            <div class="progress">

                                <div class="progress-bar
                                @if($item->persentase>=100)
                                    bg-success
                                @elseif($item->persentase>=50)
                                    bg-warning
                                @else
                                    bg-danger
                                @endif"

                                style="width: {{ $item->persentase }}%">

                                    {{ round($item->persentase) }}%

                                </div>

                            </div>

                        </td>

                        <td class="text-center">

                            @if($item->user->lokasiTerakhir)

                                <a href="{{ route('admin.divisi.detail',$item->divisi_id) }}"
                                   class="btn btn-sm btn-primary">

                                    <i class="fas fa-map-marker-alt"></i>

                                </a>

                            @else

                                <span class="badge badge-light">

                                    -

                                </span>

                            @endif

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="7" class="text-center">

                            Belum ada data teknisi.

                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>



<div class="row">

    <!-- ===================== Progress Divisi ===================== -->
    <div class="col-lg-8">

        <div class="card shadow mb-4 border-0">

            <div class="card-header bg-white py-3 d-flex align-items-center">

                <h5 class="m-0 font-weight-bold text-success">
                    <i class="fas fa-chart-line mr-2"></i>
                    Progress Produktivitas Divisi
                </h5>

            </div>

            <div class="card-body">

                @foreach($progressDivisi as $divisi)

                    <div class="mb-4">

                        <div class="d-flex justify-content-between mb-2">

                            <strong class="text-dark">
                                {{ $divisi['nama'] }}
                            </strong>

                            <strong class="text-primary">

                                {{ $divisi['pekerjaan'] }}
                                /
                                {{ $divisi['target'] }}

                            </strong>

                        </div>

                        <div class="progress" style="height:24px;border-radius:20px;">

                            <div class="progress-bar
                                @if($divisi['persentase']>=100)
                                    bg-success
                                @elseif($divisi['persentase']>=70)
                                    bg-info
                                @elseif($divisi['persentase']>=40)
                                    bg-warning
                                @else
                                    bg-danger
                                @endif"

                                role="progressbar"

                                style="width:{{ $divisi['persentase'] }}%;font-weight:bold;">

                                {{ $divisi['persentase'] }}%

                            </div>

                        </div>

                    </div>

                @endforeach

            </div>

        </div>

    </div>

    <!-- ===================== Top Teknisi ===================== -->
    <div class="col-lg-4">

        <div class="card shadow mb-4 border-0">

            <div class="card-header bg-white py-3">

                <h5 class="m-0 font-weight-bold text-warning">

                    <i class="fas fa-trophy mr-2"></i>

                    Top 5 Teknisi Hari Ini

                </h5>

            </div>

            <div class="card-body p-0">

                @forelse($topTeknisi as $index => $item)

                <div class="border-bottom px-3 py-3">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <h6 class="font-weight-bold mb-1">

                                @if($index==0)
                                    🥇
                                @elseif($index==1)
                                    🥈
                                @elseif($index==2)
                                    🥉
                                @else
                                    #{{ $index+1 }}
                                @endif

                                {{ $item->user->nama }}

                            </h6>

                            <small class="text-muted">

                                {{ $item->divisi->nama_divisi }}

                            </small>

                        </div>

                        <div class="text-center">

                            <div style="
                                width:65px;
                                height:65px;
                                border-radius:50%;
                                background:#28c76f;
                                color:white;
                                display:flex;
                                align-items:center;
                                justify-content:center;
                                flex-direction:column;
                                font-weight:bold;
                            ">

                                {{ $item->jumlah }}

                                <small style="font-size:11px">
                                    Tiket
                                </small>

                            </div>

                        </div>

                    </div>

                </div>

                @empty

                <div class="text-center py-5 text-muted">

                    Belum ada pekerjaan hari ini.

                </div>

                @endforelse

            </div>

        </div>

    </div>

</div>

<div class="card shadow mb-4">

    <div class="card-header py-3">

        <h5 class="m-0 font-weight-bold text-danger">

            <i class="fas fa-map-marked-alt mr-2"></i>

            Peta Lokasi Teknisi

        </h5>

    </div>

    <div class="card-body">

        <div id="map" style="height:550px;border-radius:10px;"></div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

const ctx = document.getElementById('chartProduktivitas');

new Chart(ctx, {

    type:'line',

    data:{

        labels:['Sen','Sel','Rab','Kam','Jum','Sab','Min'],

        datasets:[{

            label:'Pekerjaan',

            data:[12,19,15,22,18,25,20],

            borderWidth:3,

            fill:true,

            tension:0.4

        }]

    },

    options:{

        responsive:true,

        plugins:{

            legend:{

                display:false

            }

        }

    }

});

</script>

@endsection

