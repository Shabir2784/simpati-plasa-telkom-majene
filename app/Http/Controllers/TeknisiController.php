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
use Illuminate\Support\Facades\Storage;

class TeknisiController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();

        $absensiLama = Absensi::where('user_id', $user->id)
            ->where('status', 'aktif')
            ->whereDate('tanggal', '<', today())
            ->first();

        if ($absensiLama) {
            $absensiLama->update([
                'jam_keluar' => '17:00:00',
                'status' => 'offline'
            ]);
        }

        $absensi = Absensi::where('user_id', $user->id)
            ->whereDate('tanggal', today())
            ->first();

        $jumlahPekerjaan = Pekerjaan::where('user_id', $user->id)
            ->whereDate('tanggal', today())
            ->count();

        $target = TargetProduktivitas::where(
            'divisi_id',
            $user->teknisi->divisi_id
        )->first();

        $targetHarian = $target ? $target->target : 5;

        $persentase = $targetHarian > 0
            ? min(($jumlahPekerjaan / $targetHarian) * 100, 100)
            : 0;

        $bolehCheckIn = now()->format('H:i') >= '07:00';

        // Check Out baru diperbolehkan mulai pukul 17:00
        $bolehCheckOut = now()->format('H:i') >= '17:00';

        return view('teknisi.dashboardTeknisi', compact(
            'user',
            'absensi',
            'jumlahPekerjaan',
            'target',
            'targetHarian',
            'persentase',
            'bolehCheckIn',
            'bolehCheckOut'
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
        $teknisi = Teknisi::with('user', 'divisi')
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('teknisi.editProfil', compact('teknisi'));
    }

    public function updateProfil(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'no_hp' => 'required',
            'alamat' => 'required',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $user = User::findOrFail(Auth::id());

        $dataUser = [
            'nama' => $request->nama,
        ];

        if ($request->hasFile('foto')) {

            if ($user->foto && Storage::disk('public')->exists($user->foto)) {
                Storage::disk('public')->delete($user->foto);
            }

            $dataUser['foto'] = $request->file('foto')->store('foto-teknisi', 'public');
        }

        $user->update($dataUser);

        $user->teknisi->update([
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
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
        $user = Auth::user();

        // =========================================================
        // CEK LOKASI TEKNISI MASIH AKTIF
        // =========================================================

        $lokasi = LokasiTeknisi::where('user_id', $user->id)
            ->latest('waktu_update')
            ->first();

        if (!$lokasi) {
            return back()
                ->with('error', 'Lokasi tidak tersedia. Aktifkan GPS terlebih dahulu.')
                ->withInput();
        }

        // Lokasi dianggap aktif jika update terakhir maksimal 1 menit
        $batasWaktu = now()->subMinutes(5);

        if ($lokasi->waktu_update < $batasWaktu) {
            return back()
                ->with('error', 'Lokasi tidak aktif. Pastikan GPS aktif dan tunggu lokasi diperbarui.')
                ->withInput();
        }

        // =========================================================
        // CEK DIVISI
        // =========================================================

        $divisi = $user->divisi->nama_divisi;

        if ($divisi == 'Assurance') {

            $request->validate([
                'nomor_tiket' => 'required|unique:pekerjaans,nomor_tiket',
                'nama_pelanggan' => 'required',
                'alamat_pelanggan' => 'required',
                'jenis_pekerjaan' => 'required',
                'jenis_pekerjaan_lainnya' => 'required_if:jenis_pekerjaan,Lainnya',
                'deskripsi' => 'required',
                'alpro' => 'required',
                'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            ]);

            $nomorTiket = $request->nomor_tiket;
            $nomorWo = null;
            $scOrder = null;
            $segmen = null;

        } elseif ($divisi == 'Provisioning') {

            $request->validate([
                'nomor_wo' => 'required|unique:pekerjaans,nomor_wo',
                'sc_order' => 'required',
                'nama_pelanggan' => 'required',
                'alamat_pelanggan' => 'required',
                'jenis_pekerjaan' => 'required',
                'jenis_pekerjaan_lainnya' => 'required_if:jenis_pekerjaan,Lainnya',
                'deskripsi' => 'required',
                'alpro' => 'required',
                'segmen' => 'required',
                'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            ]);

            $nomorTiket = null;
            $nomorWo = $request->nomor_wo;
            $scOrder = $request->sc_order;
            $segmen = $request->segmen;

        } else {

            return back()
                ->withErrors([
                    'divisi' => 'Divisi teknisi tidak valid.'
                ])
                ->withInput();
        }

        // =========================================================
        // JENIS PEKERJAAN
        // =========================================================

        $jenisPekerjaan = $request->jenis_pekerjaan;

        if ($jenisPekerjaan === 'Lainnya') {
            $jenisPekerjaan = $request->jenis_pekerjaan_lainnya;
        }

        // =========================================================
        // FOTO
        // =========================================================

        $foto = null;

        if ($request->hasFile('foto')) {
            $foto = $request->file('foto')->store('pekerjaan', 'public');
        }

        // =========================================================
        // SIMPAN PEKERJAAN
        // =========================================================

        Pekerjaan::create([
            'user_id' => $user->id,
            'nomor_tiket' => $nomorTiket,
            'nomor_wo' => $nomorWo,
            'sc_order' => $scOrder,
            'alpro' => $request->alpro,
            'segmen' => $segmen,
            'nama_pelanggan' => $request->nama_pelanggan,
            'alamat_pelanggan' => $request->alamat_pelanggan,
            'jenis_pekerjaan' => $jenisPekerjaan,
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
        if (now()->format('H:i') < '17:00') {
            return back()->with('error', 'Check Out baru dapat dilakukan mulai pukul 17.00.');
        }

        $absensi = Absensi::where('user_id', Auth::id())
            ->whereDate('tanggal', today())
            ->first();

        if (!$absensi) {
            return back()->with('error', 'Anda belum Check In.');
        }

        if ($absensi->jam_keluar) {
            return back()->with('error', 'Anda sudah Check Out.');
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
