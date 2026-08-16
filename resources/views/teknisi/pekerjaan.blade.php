@extends('layoutsTeknisi.master')

@section('content')

<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800">
        Input Hasil Pekerjaan
    </h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
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

    @php
        $divisi = optional(Auth::user()->divisi)->nama_divisi;
        $isProvisioning = $divisi === 'Provisioning';
        $isAssurance = $divisi === 'Assurance';
    @endphp

    {{-- STATUS LOKASI --}}

    <div id="statusLokasi" class="alert alert-warning">
        <i class="fas fa-spinner fa-spin"></i>
        Memeriksa status lokasi...
    </div>

    <div class="card shadow">

        <div class="card-header bg-primary text-white">
            <strong>
                Form Input Pekerjaan - {{ $divisi }}
            </strong>
        </div>

        <div class="card-body">

            <form
                action="{{ route('teknisi.pekerjaan.store') }}"
                method="POST"
                enctype="multipart/form-data"
                id="formPekerjaan">

                @csrf

                {{-- ================================================= --}}
                {{-- PROVISIONING --}}
                {{-- ================================================= --}}

                @if($isProvisioning)

                    <div class="form-group">
                        <label>Nomor WO</label>

                        <input
                            type="text"
                            name="nomor_wo"
                            class="form-control"
                            placeholder="Masukkan Nomor WO"
                            value="{{ old('nomor_wo') }}"
                            required>
                    </div>

                    <div class="form-group">
                        <label>SC Order</label>

                        <input
                            type="text"
                            name="sc_order"
                            class="form-control"
                            placeholder="Masukkan SC Order"
                            value="{{ old('sc_order') }}"
                            required>
                    </div>

                    <div class="form-group">
                        <label>Nama Pelanggan</label>

                        <input
                            type="text"
                            name="nama_pelanggan"
                            class="form-control"
                            placeholder="Masukkan Nama Pelanggan"
                            value="{{ old('nama_pelanggan') }}"
                            required>
                    </div>

                    <div class="form-group">
                        <label>Alamat Pelanggan</label>

                        <textarea
                            name="alamat_pelanggan"
                            class="form-control"
                            rows="3"
                            placeholder="Masukkan Alamat Pelanggan"
                            required>{{ old('alamat_pelanggan') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label>ALPRO</label>

                        <input
                            type="text"
                            name="alpro"
                            class="form-control"
                            placeholder="Contoh: CDP-MAJ-FIB/01"
                            value="{{ old('alpro') }}"
                            required>
                    </div>

                    <div class="form-group">
                        <label>Segmen</label>

                        <input
                            type="text"
                            name="segmen"
                            class="form-control"
                            placeholder="Masukkan Segmen"
                            value="{{ old('segmen') }}"
                            required>
                    </div>

                    <div class="form-group">

                        <label>Jenis Pekerjaan</label>

                        <select
                            name="jenis_pekerjaan"
                            id="jenis_pekerjaan_provisioning"
                            class="form-control"
                            required>

                            <option value="">
                                -- Pilih Jenis Pekerjaan --
                            </option>

                            <option value="Pasang Baru"
                                {{ old('jenis_pekerjaan') == 'Pasang Baru' ? 'selected' : '' }}>
                                Pasang Baru
                            </option>

                            <option value="Migrasi"
                                {{ old('jenis_pekerjaan') == 'Migrasi' ? 'selected' : '' }}>
                                Migrasi
                            </option>

                            <option value="Upgrade/Downgrade"
                                {{ old('jenis_pekerjaan') == 'Upgrade/Downgrade' ? 'selected' : '' }}>
                                Upgrade/Downgrade
                            </option>

                            <option value="Aktivasi"
                                {{ old('jenis_pekerjaan') == 'Aktivasi' ? 'selected' : '' }}>
                                Aktivasi
                            </option>

                            <option value="Lainnya"
                                {{ old('jenis_pekerjaan') == 'Lainnya' ? 'selected' : '' }}>
                                Lainnya
                            </option>

                        </select>

                    </div>

                    <div
                        class="form-group"
                        id="jenis_lainnya_provisioning"
                        style="display: {{ old('jenis_pekerjaan') == 'Lainnya' ? 'block' : 'none' }};">

                        <label>Pekerjaan Lainnya</label>

                        <input
                            type="text"
                            name="jenis_pekerjaan_lainnya"
                            id="input_jenis_lainnya_provisioning"
                            class="form-control"
                            placeholder="Masukkan pekerjaan"
                            value="{{ old('jenis_pekerjaan_lainnya') }}"
                            {{ old('jenis_pekerjaan') == 'Lainnya' ? 'required' : '' }}>

                    </div>

                {{-- ================================================= --}}
                {{-- ASSURANCE --}}
                {{-- ================================================= --}}

                @elseif($isAssurance)

                    <div class="form-group">
                        <label>Nomor Tiket</label>

                        <input
                            type="text"
                            name="nomor_tiket"
                            class="form-control"
                            placeholder="Masukkan Nomor Tiket"
                            value="{{ old('nomor_tiket') }}"
                            required>
                    </div>

                    <div class="form-group">
                        <label>Nama Pelanggan</label>

                        <input
                            type="text"
                            name="nama_pelanggan"
                            class="form-control"
                            placeholder="Masukkan Nama Pelanggan"
                            value="{{ old('nama_pelanggan') }}"
                            required>
                    </div>

                    <div class="form-group">
                        <label>Alamat Pelanggan</label>

                        <textarea
                            name="alamat_pelanggan"
                            class="form-control"
                            rows="3"
                            placeholder="Masukkan Alamat Pelanggan"
                            required>{{ old('alamat_pelanggan') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label>ALPRO</label>

                        <input
                            type="text"
                            name="alpro"
                            class="form-control"
                            placeholder="Contoh: CDP-MAJ-FIB/01"
                            value="{{ old('alpro') }}"
                            required>
                    </div>

                    <div class="form-group">

                        <label>Jenis Pekerjaan</label>

                        <select
                            name="jenis_pekerjaan"
                            id="jenis_pekerjaan_assurance"
                            class="form-control"
                            required>

                            <option value="">
                                -- Pilih Jenis Pekerjaan --
                            </option>

                            <option value="Gangguan Internet"
                                {{ old('jenis_pekerjaan') == 'Gangguan Internet' ? 'selected' : '' }}>
                                Gangguan Internet
                            </option>

                            <option value="Gangguan IndiHome"
                                {{ old('jenis_pekerjaan') == 'Gangguan IndiHome' ? 'selected' : '' }}>
                                Gangguan IndiHome
                            </option>

                            <option value="Perbaikan Jaringan"
                                {{ old('jenis_pekerjaan') == 'Perbaikan Jaringan' ? 'selected' : '' }}>
                                Perbaikan Jaringan
                            </option>

                            <option value="Maintenance"
                                {{ old('jenis_pekerjaan') == 'Maintenance' ? 'selected' : '' }}>
                                Maintenance
                            </option>

                            <option value="Lainnya"
                                {{ old('jenis_pekerjaan') == 'Lainnya' ? 'selected' : '' }}>
                                Lainnya
                            </option>

                        </select>

                    </div>

                    <div
                        class="form-group"
                        id="jenis_lainnya_assurance"
                        style="display: {{ old('jenis_pekerjaan') == 'Lainnya' ? 'block' : 'none' }};">

                        <label>Pekerjaan Lainnya</label>

                        <input
                            type="text"
                            name="jenis_pekerjaan_lainnya"
                            id="input_jenis_lainnya_assurance"
                            class="form-control"
                            placeholder="Masukkan pekerjaan"
                            value="{{ old('jenis_pekerjaan_lainnya') }}"
                            {{ old('jenis_pekerjaan') == 'Lainnya' ? 'required' : '' }}>

                    </div>

                @endif

                {{-- ================================================= --}}
                {{-- DESKRIPSI --}}
                {{-- ================================================= --}}

                @if($isProvisioning || $isAssurance)

                    <div class="form-group">

                        <label>Deskripsi Pekerjaan</label>

                        <textarea
                            name="deskripsi"
                            class="form-control"
                            rows="5"
                            placeholder="Masukkan deskripsi pekerjaan"
                            required>{{ old('deskripsi') }}</textarea>

                    </div>

                    {{-- FOTO --}}

                    <div class="form-group">

                        <label>Foto Bukti</label>

                        <input
                            type="file"
                            name="foto"
                            class="form-control-file"
                            accept=".jpg,.jpeg,.png">

                        <small class="form-text text-muted">
                            Format JPG, JPEG, PNG. Maksimal 2 MB.
                        </small>

                    </div>

                    {{-- TOMBOL SIMPAN --}}

                    <button
                        type="submit"
                        id="btnSimpanPekerjaan"
                        class="btn btn-primary"
                        disabled>

                        <i class="fas fa-save"></i>
                        Simpan Pekerjaan

                    </button>

                @else

                    <div class="alert alert-warning">
                        Divisi teknisi tidak valid.
                    </div>

                @endif

            </form>

        </div>

    </div>

</div>


{{-- ========================================================= --}}
{{-- JAVASCRIPT --}}
{{-- ========================================================= --}}

<script>

document.addEventListener('DOMContentLoaded', function () {

    /* =========================================================
       PEKERJAAN LAINNYA - PROVISIONING
       ========================================================= */

    const provisioning =
        document.getElementById('jenis_pekerjaan_provisioning');

    const assurance =
        document.getElementById('jenis_pekerjaan_assurance');


    if (provisioning) {

        provisioning.addEventListener('change', function () {

            const container =
                document.getElementById('jenis_lainnya_provisioning');

            const input =
                document.getElementById('input_jenis_lainnya_provisioning');


            if (this.value === 'Lainnya') {

                container.style.display = 'block';

                input.required = true;

                input.focus();

            } else {

                container.style.display = 'none';

                input.required = false;

                input.value = '';

            }

        });

    }


    /* =========================================================
       PEKERJAAN LAINNYA - ASSURANCE
       ========================================================= */

    if (assurance) {

        assurance.addEventListener('change', function () {

            const container =
                document.getElementById('jenis_lainnya_assurance');

            const input =
                document.getElementById('input_jenis_lainnya_assurance');


            if (this.value === 'Lainnya') {

                container.style.display = 'block';

                input.required = true;

                input.focus();

            } else {

                container.style.display = 'none';

                input.required = false;

                input.value = '';

            }

        });

    }


    /* =========================================================
       STATUS LOKASI TEKNISI
       ========================================================= */

    const statusLokasi =
        document.getElementById('statusLokasi');

    const btnSimpan =
        document.getElementById('btnSimpanPekerjaan');


    if (!statusLokasi || !btnSimpan) {
        return;
    }


    /* =========================================================
       KIRIM LOKASI TERBARU KE SERVER
       ========================================================= */

    function updateLokasiKeServer(position) {

        fetch("{{ route('teknisi.updateLokasi') }}", {

            method: "POST",

            headers: {

                "Content-Type": "application/json",

                "X-CSRF-TOKEN":
                    "{{ csrf_token() }}",

                "Accept":
                    "application/json"

            },

            body: JSON.stringify({

                latitude:
                    position.coords.latitude,

                longitude:
                    position.coords.longitude

            })

        })

        .then(function (response) {

            if (!response.ok) {
                throw new Error(
                    'Gagal mengirim lokasi ke server.'
                );
            }

            return response.json();

        })

        .then(function (data) {

            if (data.success) {

                statusLokasi.className =
                    'alert alert-success';

                statusLokasi.innerHTML =
                    '<i class="fas fa-map-marker-alt"></i> ' +
                    '<strong>Lokasi aktif.</strong> ' +
                    'Lokasi berhasil diperbarui.';

                btnSimpan.disabled = false;

            } else {

                statusLokasi.className =
                    'alert alert-danger';

                statusLokasi.innerHTML =
                    '<i class="fas fa-exclamation-triangle"></i> ' +
                    '<strong>Lokasi gagal diperbarui.</strong>';

                btnSimpan.disabled = true;

            }

        })

        .catch(function (error) {

            console.error(error);

            statusLokasi.className =
                'alert alert-danger';

            statusLokasi.innerHTML =
                '<i class="fas fa-exclamation-triangle"></i> ' +
                '<strong>Lokasi gagal diperbarui ke server.</strong>';

            btnSimpan.disabled = true;

        });

    }


    /* =========================================================
       CEK LOKASI
       ========================================================= */

    function cekLokasi() {

        if (!navigator.geolocation) {

            statusLokasi.className =
                'alert alert-danger';

            statusLokasi.innerHTML =
                '<i class="fas fa-times-circle"></i> ' +
                'Perangkat tidak mendukung GPS. ' +
                'Anda tidak dapat menginput pekerjaan.';

            btnSimpan.disabled = true;

            return;
        }


        statusLokasi.className =
            'alert alert-warning';

        statusLokasi.innerHTML =
            '<i class="fas fa-spinner fa-spin"></i> ' +
            'Memeriksa dan memperbarui lokasi...';

        btnSimpan.disabled = true;


        navigator.geolocation.getCurrentPosition(

            function (position) {

                updateLokasiKeServer(position);

            },

            function (error) {

                statusLokasi.className =
                    'alert alert-danger';

                statusLokasi.innerHTML =
                    '<i class="fas fa-exclamation-triangle"></i> ' +
                    '<strong>Lokasi tidak aktif.</strong> ' +
                    'Aktifkan GPS/lokasi perangkat terlebih dahulu ' +
                    'untuk menginput pekerjaan.';

                btnSimpan.disabled = true;

                console.log(
                    'GPS Error: ' + error.message
                );

            },

            {

                enableHighAccuracy: true,

                timeout: 10000,

                maximumAge: 0

            }

        );

    }


    /* =========================================================
       CEK PERTAMA KALI
       ========================================================= */

    cekLokasi();


    /* =========================================================
       UPDATE SETIAP 30 DETIK
       ========================================================= */

    setInterval(function () {

        cekLokasi();

    }, 30000);


});

</script>

@endsection