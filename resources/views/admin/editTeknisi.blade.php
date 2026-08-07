@extends('layoutsAdmin.master')

@section('content')

<div class="container-fluid">

<h1 class="h3 mb-4">
    Edit Teknisi
</h1>


<form action="{{ route('admin.teknisi.update',$teknisi->id) }}"
      method="POST">

@csrf
@method('PUT')


<div class="form-group">
<label>Nama</label>

<input type="text"
name="nama"
class="form-control"
value="{{ $teknisi->user->nama }}">
</div>


<div class="form-group">
<label>Email</label>

<input type="email"
name="email"
class="form-control"
value="{{ $teknisi->user->email }}">
</div>


<div class="form-group">
<label>NIK</label>

<input type="text"
name="nik"
class="form-control"
value="{{ $teknisi->nik }}">
</div>


<div class="form-group">
<label>No HP</label>

<input type="text"
name="no_hp"
class="form-control"
value="{{ $teknisi->no_hp }}">
</div>


<div class="form-group">

<label>Divisi</label>

<select name="divisi_id"
class="form-control">

@foreach($divisis as $divisi)

<option value="{{ $divisi->id }}"
@if($divisi->id==$teknisi->divisi_id)
selected
@endif>

{{ $divisi->nama_divisi }}

</option>

@endforeach

</select>

</div>


<button class="btn btn-primary">
Update
</button>


<a href="{{ route('admin.teknisi') }}"
class="btn btn-secondary">
Kembali
</a>


</form>

</div>


@endsection