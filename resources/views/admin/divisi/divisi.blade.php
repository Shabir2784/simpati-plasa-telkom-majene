@extends('layoutsAdmin.master')

@section('content')

<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800">
        Data Divisi
    </h1>

    <div class="row">

        @foreach($divisis as $divisi)

        <div class="col-md-6">

            <div class="card shadow mb-4 border-left-primary">

                <div class="card-body text-center">

                    <h3 class="font-weight-bold">
                        {{ $divisi->nama_divisi }}
                    </h3>

                    <hr>

                    <h5>
                        Jumlah Teknisi
                    </h5>

                    <h2>
                        {{ $divisi->teknisis->count() }}
                    </h2>

                    <a href="{{ route('admin.divisi.detail',$divisi->id) }}"
                        class="btn btn-primary mt-3">

                        Lihat Teknisi

                    </a>

                </div>

            </div>

        </div>

        @endforeach

    </div>

</div>

@endsection