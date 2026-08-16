@extends('layoutsAdmin.master')

@section('content')

<h1 class="h3 mb-4 text-gray-800">Data Teknisi</h1>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


{{-- ============================= --}}
{{-- TOMBOL TAMBAH --}}
{{-- ============================= --}}

<button type="button"
        class="btn btn-primary mb-3"
        data-toggle="modal"
        data-target="#modalTambah">

    <i class="fas fa-plus"></i>
    Tambah Teknisi

</button>


{{-- ============================= --}}
{{-- TABEL TEKNISI --}}
{{-- ============================= --}}

<div class="table-responsive">

    <table class="table table-bordered table-hover">

        <thead class="thead-dark">

            <tr>

                <th>No</th>
                <th>NIK</th>
                <th>Nama</th>
                <th>Divisi</th>
                <th>No HP</th>
                <th>Alamat</th>
                <th>Status</th>
                <th width="120">Aksi</th>

            </tr>

        </thead>

        <tbody>

        @forelse($teknisis as $item)

            <tr>

                <td>
                    {{ $loop->iteration }}
                </td>

                <td>
                    {{ $item->nik }}
                </td>

                <td>
                    {{ $item->user->nama }}
                </td>

                <td>
                    {{ $item->divisi->nama_divisi }}
                </td>

                <td>
                    {{ $item->no_hp }}
                </td>

                <td>
                    {{ $item->alamat ?? '-' }}
                </td>

                <td>

                    @if($item->status == 'Aktif')

                        <span class="badge badge-success">
                            Aktif
                        </span>

                    @else

                        <span class="badge badge-danger">
                            Nonaktif
                        </span>

                    @endif

                </td>

                <td>

                    {{-- EDIT --}}
                    <a href="{{ route('admin.teknisi.edit', $item->id) }}"
                       class="btn btn-warning btn-sm">

                        <i class="fas fa-edit"></i>

                    </a>


                    {{-- RESET PASSWORD --}}
                    <button type="button"
                            class="btn btn-info btn-sm"
                            data-toggle="modal"
                            data-target="#modalResetPassword{{ $item->id }}">

                        <i class="fas fa-key"></i>

                    </button>


                    {{-- HAPUS --}}
                    <form action="{{ route('admin.teknisi.destroy', $item->id) }}"
                          method="POST"
                          class="d-inline">

                        @csrf
                        @method('DELETE')

                        <button type="submit"
                                class="btn btn-danger btn-sm"
                                onclick="return confirm('Yakin ingin menghapus data ini?')">

                            <i class="fas fa-trash"></i>

                        </button>

                    </form>

                </td>

            </tr>

        @empty

            <tr>

                <td colspan="8"
                    class="text-center">

                    Belum ada data teknisi.

                </td>

            </tr>

        @endforelse

        </tbody>

    </table>

</div>


{{-- ========================================================== --}}
{{-- MODAL TAMBAH TEKNISI --}}
{{-- ========================================================== --}}

<div class="modal fade"
     id="modalTambah"
     tabindex="-1"
     role="dialog"
     aria-hidden="true">

    <div class="modal-dialog modal-lg">

        <form action="{{ route('admin.teknisi.store') }}"
              method="POST">

            @csrf

            <div class="modal-content">


                {{-- HEADER --}}
                <div class="modal-header">

                    <h5 class="modal-title">
                        Tambah Teknisi
                    </h5>

                    <button type="button"
                            class="close"
                            data-dismiss="modal">

                        <span>&times;</span>

                    </button>

                </div>


                {{-- BODY --}}
                <div class="modal-body">

                    {{-- NAMA --}}
                    <div class="form-group">

                        <label>
                            Nama
                        </label>

                        <input type="text"
                               name="nama"
                               class="form-control"
                               value="{{ old('nama') }}"
                               required>

                    </div>


                    {{-- PASSWORD + NIK --}}
                    <div class="row">

                        <div class="col-md-6">

                            <div class="form-group">

                                <label>
                                    Password
                                </label>

                                <div class="input-group">

                                    <input type="password"
                                           name="password"
                                           id="password"
                                           class="form-control"
                                           minlength="6"
                                           required>

                                    <div class="input-group-append">

                                        <button type="button"
                                                class="btn btn-outline-secondary"
                                                onclick="togglePassword('password', 'passwordIcon')"
                                                title="Lihat password">

                                            <i class="fas fa-eye"
                                               id="passwordIcon"></i>

                                        </button>

                                    </div>

                                </div>

                            </div>

                        </div>


                        <div class="col-md-6">

                            <div class="form-group">

                                <label>
                                    NIK
                                </label>

                                <input type="text"
                                       name="nik"
                                       class="form-control"
                                       value="{{ old('nik') }}"
                                       required>

                            </div>

                        </div>

                    </div>


                    {{-- DIVISI + NO HP --}}
                    <div class="row">

                        <div class="col-md-6">

                            <div class="form-group">

                                <label>
                                    Divisi
                                </label>

                                <select name="divisi_id"
                                        class="form-control"
                                        required>

                                    <option value="">
                                        -- Pilih Divisi --
                                    </option>

                                    @foreach($divisis as $divisi)

                                        <option value="{{ $divisi->id }}"
                                            {{ old('divisi_id') == $divisi->id ? 'selected' : '' }}>

                                            {{ $divisi->nama_divisi }}

                                        </option>

                                    @endforeach

                                </select>

                            </div>

                        </div>


                        <div class="col-md-6">

                            <div class="form-group">

                                <label>
                                    No HP
                                </label>

                                <input type="text"
                                       name="no_hp"
                                       class="form-control"
                                       value="{{ old('no_hp') }}"
                                       required>

                            </div>

                        </div>

                    </div>


                    {{-- ALAMAT --}}
                    <div class="form-group">

                        <label>
                            Alamat
                        </label>

                        <textarea name="alamat"
                                  class="form-control"
                                  rows="3">{{ old('alamat') }}</textarea>

                    </div>

                </div>


                {{-- FOOTER --}}
                <div class="modal-footer">

                    <button type="button"
                            class="btn btn-secondary"
                            data-dismiss="modal">

                        Batal

                    </button>

                    <button type="submit"
                            class="btn btn-primary">

                        Simpan

                    </button>

                </div>

            </div>

        </form>

    </div>

</div>


{{-- ========================================================== --}}
{{-- MODAL RESET PASSWORD --}}
{{-- ========================================================== --}}

@foreach($teknisis as $item)

<div class="modal fade"
     id="modalResetPassword{{ $item->id }}"
     tabindex="-1"
     role="dialog"
     aria-hidden="true">

    <div class="modal-dialog">

        <form action="{{ route('admin.teknisi.resetPassword', $item->id) }}"
              method="POST">

            @csrf
            @method('PUT')

            <div class="modal-content">


                {{-- HEADER --}}
                <div class="modal-header">

                    <h5 class="modal-title">
                        Reset Password Teknisi
                    </h5>

                    <button type="button"
                            class="close"
                            data-dismiss="modal">

                        <span>&times;</span>

                    </button>

                </div>


                {{-- BODY --}}
                <div class="modal-body">

                    <p>

                        Reset password untuk teknisi

                        <strong>
                            {{ $item->user->nama }}
                        </strong>.

                    </p>


                    {{-- PASSWORD BARU --}}
                    <div class="form-group">

                        <label>
                            Password Baru
                        </label>

                        <div class="input-group">

                            <input type="password"
                                   name="password"
                                   id="resetPassword{{ $item->id }}"
                                   class="form-control"
                                   minlength="6"
                                   required>

                            <div class="input-group-append">

                                <button type="button"
                                        class="btn btn-outline-secondary"
                                        onclick="togglePassword('resetPassword{{ $item->id }}', 'iconReset{{ $item->id }}')"
                                        title="Lihat password">

                                    <i class="fas fa-eye"
                                       id="iconReset{{ $item->id }}"></i>

                                </button>

                            </div>

                        </div>

                    </div>


                    {{-- KONFIRMASI PASSWORD --}}
                    <div class="form-group">

                        <label>
                            Konfirmasi Password Baru
                        </label>

                        <input type="password"
                               name="password_confirmation"
                               class="form-control"
                               minlength="6"
                               required>

                    </div>

                </div>


                {{-- FOOTER --}}
                <div class="modal-footer">

                    <button type="button"
                            class="btn btn-secondary"
                            data-dismiss="modal">

                        Batal

                    </button>

                    <button type="submit"
                            class="btn btn-primary">

                        <i class="fas fa-key"></i>
                        Reset Password

                    </button>

                </div>

            </div>

        </form>

    </div>

</div>

@endforeach


{{-- ========================================================== --}}
{{-- MODAL EDIT TEKNISI --}}
{{-- ========================================================== --}}

<div class="modal fade"
     id="modalEdit"
     tabindex="-1"
     role="dialog"
     aria-hidden="true">

    <div class="modal-dialog modal-lg">

        <form id="formEdit"
              method="POST">

            @csrf
            @method('PUT')

            <div class="modal-content">


                {{-- HEADER --}}
                <div class="modal-header">

                    <h5 class="modal-title">
                        Edit Teknisi
                    </h5>

                    <button type="button"
                            class="close"
                            data-dismiss="modal">

                        <span>&times;</span>

                    </button>

                </div>


                {{-- BODY --}}
                <div class="modal-body">

                    {{-- NAMA --}}
                    <div class="form-group">

                        <label>
                            Nama
                        </label>

                        <input type="text"
                               id="edit_nama"
                               name="nama"
                               class="form-control"
                               required>

                    </div>


                    {{-- NIK + NO HP --}}
                    <div class="row">

                        <div class="col-md-6">

                            <div class="form-group">

                                <label>
                                    NIK
                                </label>

                                <input type="text"
                                       id="edit_nik"
                                       name="nik"
                                       class="form-control"
                                       required>

                            </div>

                        </div>


                        <div class="col-md-6">

                            <div class="form-group">

                                <label>
                                    No HP
                                </label>

                                <input type="text"
                                       id="edit_no_hp"
                                       name="no_hp"
                                       class="form-control"
                                       required>

                            </div>

                        </div>

                    </div>


                    {{-- DIVISI --}}
                    <div class="form-group">

                        <label>
                            Divisi
                        </label>

                        <select id="edit_divisi_id"
                                name="divisi_id"
                                class="form-control"
                                required>

                            @foreach($divisis as $divisi)

                                <option value="{{ $divisi->id }}">

                                    {{ $divisi->nama_divisi }}

                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- ALAMAT --}}
                    <div class="form-group">

                        <label>
                            Alamat
                        </label>

                        <textarea id="edit_alamat"
                                  name="alamat"
                                  rows="3"
                                  class="form-control"></textarea>

                    </div>

                </div>


                {{-- FOOTER --}}
                <div class="modal-footer">

                    <button type="button"
                            class="btn btn-secondary"
                            data-dismiss="modal">

                        Batal

                    </button>

                    <button type="submit"
                            class="btn btn-primary">

                        Update

                    </button>

                </div>

            </div>

        </form>

    </div>

</div>


@endsection


{{-- ========================================================== --}}
{{-- JAVASCRIPT PASSWORD --}}
{{-- ========================================================== --}}

@push('scripts')

<script>

function togglePassword(inputId, iconId)
{
    const input = document.getElementById(inputId);
    const icon = document.getElementById(iconId);

    if (!input || !icon) {
        return;
    }

    if (input.type === 'password') {

        input.type = 'text';

        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');

    } else {

        input.type = 'password';

        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');

    }
}

</script>

@endpush