@extends('layoutsAdmin.master')

@section('content')

<div class="container-fluid">

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

    <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#modalTambah">
        <i class="fas fa-plus"></i> Tambah Teknisi
    </button>

    <div class="table-responsive">

        <table class="table table-bordered table-hover">

            <thead class="thead-dark">
                <tr>
                    <th>No</th>
                    <th>NIK</th>
                    <th>Nama</th>
                    <th>Divisi</th>
                    <th>No HP</th>
                    <th>Status</th>
                    <th width="120">Aksi</th>
                </tr>
            </thead>

            <tbody>

            @forelse($teknisis as $item)

                <tr>

                    <td>{{ $loop->iteration }}</td>

                    <td>{{ $item->nik }}</td>

                    <td>{{ $item->user->nama }}</td>

                    <td>{{ $item->divisi->nama_divisi }}</td>

                    <td>{{ $item->no_hp }}</td>

                    <td>
                        @if($item->status == 'Aktif')
                            <span class="badge badge-success">Aktif</span>
                        @else
                            <span class="badge badge-danger">Nonaktif</span>
                        @endif
                    </td>

                    <td>
                        <a href="{{ route('admin.teknisi.edit', $item->id) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i>
                        </a>

                        <form action="{{ route('admin.teknisi.destroy', $item->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
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

{{-- Modal Tambah Teknisi --}}

<div class="modal fade" id="modalTambah" tabindex="-1">

    <div class="modal-dialog modal-lg">

        <form action="{{ route('admin.teknisi.store') }}" method="POST">

            @csrf

            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Tambah Teknisi</h5>

                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>

                </div>

                <div class="modal-body">

                    <div class="row">

                        <div class="col-md-6">

                            <div class="form-group">
                                <label>Nama</label>
                                <input type="text" name="nama" class="form-control" value="{{ old('nama') }}" required>
                            </div>

                        </div>

                        <div class="col-md-6">

                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                            </div>

                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-6">

                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>

                        </div>

                        <div class="col-md-6">

                            <div class="form-group">
                                <label>NIK</label>
                                <input type="text" name="nik" class="form-control" value="{{ old('nik') }}" required>
                            </div>

                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-6">

                            <div class="form-group">

                                <label>Divisi</label>

                                <select name="divisi_id" class="form-control" required>

                                    <option value="">-- Pilih Divisi --</option>

                                    @foreach($divisis as $divisi)

                                        <option value="{{ $divisi->id }}" {{ old('divisi_id')==$divisi->id?'selected':'' }}>
                                            {{ $divisi->nama_divisi }}
                                        </option>

                                    @endforeach

                                </select>

                            </div>

                        </div>

                        <div class="col-md-6">

                            <div class="form-group">
                                <label>No HP</label>
                                <input type="text" name="no_hp" class="form-control" value="{{ old('no_hp') }}" required>
                            </div>

                        </div>

                    </div>

                    <div class="form-group">

                        <label>Alamat</label>

                        <textarea name="alamat" class="form-control" rows="3">{{ old('alamat') }}</textarea>

                    </div>

                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Batal
                    </button>

                    <button type="submit" class="btn btn-primary">
                        Simpan
                    </button>

                </div>

            </div>

        </form>

    </div>

</div>


<!-- Modal edit Teknisi -->
<div class="modal fade" id="modalEdit" tabindex="-1">

    <div class="modal-dialog modal-lg">

        <form id="formEdit" method="POST">

            @csrf
            @method('PUT')

            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Edit Teknisi</h5>

                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>

                </div>

                <div class="modal-body">

                    <div class="row">

                        <div class="col-md-6">

                            <div class="form-group">
                                <label>Nama</label>
                                <input type="text" id="edit_nama" name="nama" class="form-control" required>
                            </div>

                        </div>

                        <div class="col-md-6">

                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" id="edit_email" name="email" class="form-control" required>
                            </div>

                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-6">

                            <div class="form-group">
                                <label>NIK</label>
                                <input type="text" id="edit_nik" name="nik" class="form-control" required>
                            </div>

                        </div>

                        <div class="col-md-6">

                            <div class="form-group">
                                <label>No HP</label>
                                <input type="text" id="edit_no_hp" name="no_hp" class="form-control" required>
                            </div>

                        </div>

                    </div>

                    <div class="form-group">

                        <label>Divisi</label>

                        <select id="edit_divisi_id" name="divisi_id" class="form-control">

                            @foreach($divisis as $divisi)
                                <option value="{{ $divisi->id }}">
                                    {{ $divisi->nama_divisi }}
                                </option>
                            @endforeach

                        </select>

                    </div>

                    <div class="form-group">

                        <label>Alamat</label>

                        <textarea id="edit_alamat" name="alamat" rows="3" class="form-control"></textarea>

                    </div>

                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Batal
                    </button>

                    <button type="submit" class="btn btn-primary">
                        Update
                    </button>

                </div>

            </div>

        </form>

    </div>

</div>

@if($errors->any())
<script>
    $(document).ready(function () {
        $('#modalTambah').modal('show');
    });
</script>
@endif
<script>
$(document).ready(function () {

    alert('Javascript jalan');

    $('.btn-edit').click(function (e) {

        alert('Tombol Edit diklik');

        e.preventDefault();

        let id = $(this).data('id');

        $.ajax({
            url: '/admin/teknisi/' + id + '/edit',
            type: 'GET',
            success: function (response) {

                alert('AJAX berhasil');

                $('#edit_nama').val(response.teknisi.user.nama);

                $('#modalEdit').modal('show');
            },
            error: function (xhr) {
                alert('AJAX gagal');
                console.log(xhr.responseText);
            }
        });

    });

});
</script>
@endsection

