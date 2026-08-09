<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\LokasiTeknisi;
use App\Models\Pekerjaan;
use App\Models\TargetProduktivitas;
use App\Models\Teknisi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class TeknisiController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();

        /*
        |-------------------------------------------------------
        | AUTO CHECK OUT
        |-------------------------------------------------------
        | Jika masih ada absensi aktif sebelum hari ini,
        | otomatis dianggap Check Out.
        |
        */

        $absensiLama = Absensi::where('user_id', $user->id)
            ->where('status', 'aktif')
            ->whereDate('tanggal', '<', today())
            ->first();

        if ($absensiLama) {

            $absensiLama->update([
                'jam_keluar' => '07:00:00',
                'status' => 'offline'
            ]);

        }

        /*
        |-------------------------------------------------------
        | ABSENSI HARI INI
        |-------------------------------------------------------
        */

        $absensi = Absensi::where('user_id', $user->id)
            ->whereDate('tanggal', today())
            ->first();

        /*
        |-------------------------------------------------------
        | JUMLAH PEKERJAAN HARI INI
        |-------------------------------------------------------
        */

        $jumlahPekerjaan = Pekerjaan::where('user_id', $user->id)
            ->whereDate('tanggal', today())
            ->count();

        /*
        |-------------------------------------------------------
        | TARGET HARIAN
        |-------------------------------------------------------
        */

        $target = TargetProduktivitas::where(
            'divisi_id',
            $user->teknisi->divisi_id
        )->first();

        $targetHarian = $target ? $target->target : 5;

        $persentase = min(
            ($jumlahPekerjaan / $targetHarian) * 100,
            100
        );
        $bolehCheckIn = now()->format('H:i') >= '07:00';

        return view('teknisi.dashboardTeknisi', compact(
            'user',
            'absensi',
            'jumlahPekerjaan',
            'target',
            'targetHarian',
            'persentase',
            'bolehCheckIn'
        ));
    }
    public function checkIn(Request $request)
    {
        $absensi = Absensi::create([

            'user_id' => Auth::user()->id,

            'tanggal' => now()->toDateString(),

            'jam_masuk' => now()->format('H:i:s'),

            'latitude_masuk' => $request->latitude,

            'longitude_masuk' => $request->longitude,

            'status' => 'aktif',

        ]);

        LokasiTeknisi::create([

            'user_id' => Auth::user()->id,

            'absensi_id' => $absensi->id,

            'latitude' => $request->latitude,

            'longitude' => $request->longitude,

            'alamat' => null,

            'waktu_update' => now(),

        ]);

        return redirect()
            ->route('teknisi.dashboard')
            ->with('success', 'Check In berhasil.');
    }
    public function updateLokasi(Request $request)
    {
        $request->validate([
            'latitude'  => 'required',
            'longitude' => 'required',
        ]);

        $lokasi = LokasiTeknisi::where('user_id', Auth::id())
        ->latest('id')
        ->first();

        if ($lokasi) {

            $lokasi->update([
                'latitude'      => $request->latitude,
                'longitude'     => $request->longitude,
                'waktu_update'  => now(),
            ]);

        } else {

            LokasiTeknisi::create([
                'user_id' => Auth::id(),
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'waktu_update' => now(),
            ]);

        }

        return response()->json([
            'success' => true
        ]);
    }
    public function profil()
    {
        $teknisi = Teknisi::with('user', 'divisi')
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('teknisi.profil', compact('teknisi'));
    }
    public function editProfil()
    {
        $teknisi = Teknisi::where('user_id', Auth::id())->first();

        return view('teknisi.editProfil', compact('teknisi'));
    }
    public function updateProfil(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email',
            'no_hp' => 'required',
            'alamat' => 'required'
        ]);

        $user = User::find(Auth::id());

        $user->update([
            'nama' => $request->nama,
            'email' => $request->email,
        ]);

        $user->teknisi->update([
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat
        ]);

        return redirect()
            ->route('teknisi.profil')
            ->with('success', 'Profil berhasil diperbarui.');
    }

    public function pekerjaan()
    {
        return view('teknisi.pekerjaan');
    }

    public function storePekerjaan(Request $request)
    {
        $divisi = Auth::user()->divisi->nama_divisi;

        // Ambil nomor berdasarkan divisi
        if ($divisi == 'Assurance') {
            $nomorTiket = $request->input('nomor_tiket') ?? $request->input('nomor_referensi');
            $nomorWo = null;
        } elseif ($divisi == 'Provisioning') {
            $nomorTiket = null;
            $nomorWo = $request->input('nomor_wo') ?? $request->input('nomor_referensi');
        } else {
            return back()->withErrors([
                'divisi' => 'Divisi teknisi tidak valid.'
            ])->withInput();
        }

        $request->merge([
            'nomor_tiket' => $nomorTiket,
            'nomor_wo' => $nomorWo,
        ]);

        $request->validate([
            'nomor_tiket' => $divisi == 'Assurance'
                ? 'required|unique:pekerjaans,nomor_tiket'
                : 'nullable',

            'nomor_wo' => $divisi == 'Provisioning'
                ? 'required|unique:pekerjaans,nomor_wo'
                : 'nullable',

            'nama_pelanggan' => 'required',

            'alamat_pelanggan' => 'required',

            'jenis_pekerjaan' => 'required',

            'deskripsi' => 'required',

            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $foto = null;

        if ($request->hasFile('foto')) {
            $foto = $request->file('foto')->store('pekerjaan', 'public');
        }

        Pekerjaan::create([
            'user_id' => Auth::id(),

            'nomor_tiket' => $nomorTiket,

            'nomor_wo' => $nomorWo,

            'nama_pelanggan' => $request->nama_pelanggan,

            'alamat_pelanggan' => $request->alamat_pelanggan,

            'jenis_pekerjaan' => $request->jenis_pekerjaan,

            'deskripsi' => $request->deskripsi,

            'foto' => $foto,

            'tanggal' => now()->toDateString(),

            'status' => 'selesai',

            'jam_selesai' => now()->format('H:i:s'),
        ]);

        return redirect()
            ->route('teknisi.pekerjaan')
            ->with('success', 'Pekerjaan berhasil disimpan.');
    }

    public function riwayat()
    {
        $pekerjaans = Pekerjaan::where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('teknisi.riwayat', compact('pekerjaans'));
    }
    public function detailPekerjaan($id)
    {
        $pekerjaan = Pekerjaan::where('user_id', Auth::id())
            ->findOrFail($id);

        return view('teknisi.detailPekerjaan', compact('pekerjaan'));
    }
    public function checkOut(Request $request)
    {
        $absensi = Absensi::where('user_id', Auth::id())
            ->whereDate('tanggal', today())
            ->first();

        if (!$absensi) {
            return back()->with('error', 'Anda belum Check In.');
        }

        $absensi->update([
            'jam_keluar' => now()->format('H:i:s'),
            'latitude_keluar' => $request->latitude,
            'longitude_keluar' => $request->longitude,
            'status' => 'offline',
        ]);

        LokasiTeknisi::create([
            'user_id' => Auth::id(),
            'absensi_id' => $absensi->id,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'alamat' => null,
            'waktu_update' => now(),
        ]);

        return redirect()
            ->route('teknisi.dashboard')
            ->with('success', 'Check Out berhasil.');
    }
    public function password()
    {
        return view('teknisi.password');
    }

    public function updatePassword(Request $request)
{
        $request->validate([
            'password_lama' => 'required',
            'password_baru' => 'required|min:6|confirmed',
        ], [
            'password_lama.required' => 'Password lama wajib diisi.',
            'password_baru.required' => 'Password baru wajib diisi.',
            'password_baru.min' => 'Password baru minimal 6 karakter.',
            'password_baru.confirmed' => 'Konfirmasi password baru tidak sama.',
        ]);

        $user = User::find(Auth::id());

        if (!$user) {
            return back()->with('error', 'Data pengguna tidak ditemukan.');
        }

        if (!Hash::check($request->password_lama, $user->password)) {
            return back()->with('error', 'Password lama tidak sesuai.');
        }

        User::where('id', $user->id)->update([
            'password' => Hash::make($request->password_baru),
        ]);

        return back()->with('success', 'Password berhasil diubah.');
    }
}
