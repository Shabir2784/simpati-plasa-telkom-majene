@extends('layoutsAdmin.master')

@section('content')

<div class="container-fluid">

    <h1 class="h3 mb-4">
        Edit Teknisi
    </h1>


    <form action="{{ route('admin.teknisi.update', $teknisi->id) }}"
          method="POST">

        @csrf
        @method('PUT')


        {{-- NAMA --}}
        <div class="form-group">

            <label>
                Nama
            </label>

            <input type="text"
                   name="nama"
                   class="form-control"
                   value="{{ $teknisi->user->nama }}"
                   required>

        </div>


       


        {{-- NIK --}}
        <div class="form-group">

            <label>
                NIK
            </label>

            <input type="text"
                   name="nik"
                   class="form-control"
                   value="{{ $teknisi->nik }}"
                   required>

        </div>


        {{-- NO HP --}}
        <div class="form-group">

            <label>
                No HP
            </label>

            <input type="text"
                   name="no_hp"
                   class="form-control"
                   value="{{ $teknisi->no_hp }}"
                   required>

        </div>


        {{-- ALAMAT --}}
        <div class="form-group">

            <label>
                Alamat
            </label>

            <textarea name="alamat"
                      class="form-control"
                      rows="3">{{ $teknisi->alamat }}</textarea>

        </div>


        {{-- DIVISI --}}
        <div class="form-group">

            <label>
                Divisi
            </label>

            <select name="divisi_id"
                    class="form-control"
                    required>

                @foreach($divisis as $divisi)

                    <option value="{{ $divisi->id }}"
                        @if($divisi->id == $teknisi->divisi_id)
                            selected
                        @endif>

                        {{ $divisi->nama_divisi }}

                    </option>

                @endforeach

            </select>

        </div>


        {{-- TOMBOL --}}
        <button type="submit"
                class="btn btn-primary">

            Update

        </button>


        <a href="{{ route('admin.teknisi') }}"
           class="btn btn-secondary">

            Kembali

        </a>


    </form>

</div>

@endsection