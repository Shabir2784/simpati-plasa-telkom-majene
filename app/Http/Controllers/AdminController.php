<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Divisi;
use App\Models\LogAktivitas;
use App\Models\TargetProduktivitas;
use App\Models\Teknisi;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Pekerjaan;
use Carbon\Carbon;
use App\Models\Absensi;
use App\Models\LokasiTeknisi;
use App\Exports\AbsensiExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\LaporanExport;



class AdminController extends Controller
{

    public function dashboard()
    {
        $today = now()->toDateString();

        // Total Teknisi
        $totalTeknisi = Teknisi::count();

        // Teknisi Online
        $online = Absensi::whereDate('tanggal', $today)
            ->where('status', 'aktif')
            ->count();

        // Teknisi Offline
        $offline = $totalTeknisi - $online;

        // Total Pekerjaan Hari Ini
        $totalPekerjaan = Pekerjaan::whereDate('tanggal', $today)->count();

        // Target Tercapai
        $targetTercapai = 0;

        $teknisis = Teknisi::all();

        foreach ($teknisis as $teknisi) {

            $target = TargetProduktivitas::where('divisi_id', $teknisi->divisi_id)
                ->value('target') ?? 4;

            $jumlah = Pekerjaan::where('user_id', $teknisi->user_id)
                ->whereDate('tanggal', $today)
                ->count();

            if ($jumlah >= $target) {
                $targetTercapai++;
            }
        }

        // Grafik Produktivitas 7 Hari
        $grafikLabel = [];
        $grafikData = [];

        for ($i = 6; $i >= 0; $i--) {

            $tanggal = now()->subDays($i);

            $grafikLabel[] = $tanggal->translatedFormat('D');

            $grafikData[] = Pekerjaan::whereDate('tanggal', $tanggal)
                ->count();
        }
        $monitoring = Teknisi::with([
            'user',
            'divisi',
            'user.absensiTerakhir',
            'user.lokasiTerakhir'
        ])->get();

        foreach ($monitoring as $item) {

            $item->jumlahPekerjaan = Pekerjaan::where('user_id', $item->user_id)
                ->whereDate('tanggal', $today)
                ->count();

            $item->target = TargetProduktivitas::where('divisi_id', $item->divisi_id)
                ->value('target') ?? 4;

            $item->persentase = min(
                ($item->jumlahPekerjaan / $item->target) * 100,
                100
            );
        }
        $topTeknisi = Teknisi::with(['user', 'divisi'])
        ->get()
        ->map(function ($teknisi) use ($today) {

            $teknisi->jumlah = Pekerjaan::where('user_id', $teknisi->user_id)
                ->whereDate('tanggal', $today)
                ->count();

            return $teknisi;

        })
        ->sortByDesc('jumlah')
        ->take(5);

        $progressDivisi = Divisi::with('teknisis')->get()->map(function ($divisi) use ($today) {

    $target = TargetProduktivitas::where('divisi_id', $divisi->id)
        ->value('target') ?? 4;

            $jumlahTeknisi = $divisi->teknisis->count();

            $targetTotal = $target * $jumlahTeknisi;

            $totalPekerjaan = Pekerjaan::whereIn(
                    'user_id',
                    $divisi->teknisis->pluck('user_id')
                )
                ->whereDate('tanggal', $today)
                ->count();

            $persentase = $targetTotal > 0
                ? min(($totalPekerjaan / $targetTotal) * 100, 100)
                : 0;

            return [
                'nama' => $divisi->nama_divisi,
                'target' => $targetTotal,
                'pekerjaan' => $totalPekerjaan,
                'persentase' => round($persentase)
            ];

        });

        $lokasiTeknisi = LokasiTeknisi::with([
            'user',
            'user.absensiTerakhir',
            'user.divisi'
        ])
        ->latest('waktu_update')
        ->get();

        return view('admin.dashboardAdmin', compact(
            'totalTeknisi',
            'online',
            'offline',
            'totalPekerjaan',
            'targetTercapai',
            'grafikLabel',
            'grafikData',
            'monitoring',
            'topTeknisi',
            'progressDivisi',
            'lokasiTeknisi'
        ));
    }

    // TEKNISI TEKNISI TEKNISI
    public function teknisi()
    {
        $teknisis = Teknisi::with(['user', 'divisi'])->get();
        $divisis = Divisi::all();

        return view('admin.teknisi', compact('teknisis', 'divisis'));
    }

    public function storeTeknisi(Request $request)
    {
        $user = User::create([
            'nama' => $request->nama,
            'nik' => $request->nik,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'teknisi',
            'divisi_id' => $request->divisi_id,
            'no_hp' => $request->no_hp,
        ]);

    $teknisi = Teknisi::create([
        'user_id' => $user->id,
        'divisi_id' => $request->divisi_id,
        'nik' => $request->nik,
        'no_hp' => $request->no_hp,
        'alamat' => $request->alamat,
        'status' => 'Aktif',
    ]);
        
        return redirect()->route('admin.teknisi')
            ->with('success', 'Data teknisi berhasil ditambahkan.');
    }
    public function editTeknisi($id)
    {
        $teknisi = Teknisi::with(['user','divisi'])
            ->findOrFail($id);

        $divisis = Divisi::all();

        return view('admin.editTeknisi', compact(
            'teknisi',
            'divisis'
        ));
    }
    public function updateTeknisi(Request $request, $id)
    {
        $request->validate([
            'nik' => 'required|unique:teknisis,nik,' . $id,
            'nama' => 'required',
            'email' => 'required|email',
            'divisi_id' => 'required',
            'no_hp' => 'required',
        ]);

        $teknisi = Teknisi::findOrFail($id);

        $teknisi->user->update([
            'nama' => $request->nama,
            'email' => $request->email,
            'divisi_id' => $request->divisi_id,
            'no_hp' => $request->no_hp,
        ]);

        $teknisi->update([
            'divisi_id' => $request->divisi_id,
            'nik' => $request->nik,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
        ]);

        return redirect()->route('admin.teknisi')
            ->with('success', 'Data teknisi berhasil diperbarui.');
    }
    public function destroyTeknisi($id)
    {
        $teknisi = Teknisi::findOrFail($id);

        // Hapus akun user yang berelasi
        $teknisi->user()->delete();

        // Hapus data teknisi
        $teknisi->delete();

        return redirect()->route('admin.teknisi')
            ->with('success', 'Data teknisi berhasil dihapus.');
    }
    public function lokasiTeknisi($id)
{
    return response()->json([
        'nama' => 'Ahmad',
        'latitude' => -3.5402,
        'longitude' => 118.9707
    ]);
}

    // public function lokasiTeknisi($id)
    // {
    //     $absensi = \App\Models\Absensi::with([
    //         'user',
    //         'lokasiTerakhir',
    //         'user.teknisi.divisi'
    //     ])->findOrFail($id);

    //     return response()->json([
    //         'nama'       => $absensi->user->nama,
    //         'divisi'     => $absensi->user->teknisi->divisi->nama_divisi,
    //         'status'     => $absensi->status,
    //         'jam_masuk'  => $absensi->jam_masuk,
    //         'latitude'   => optional($absensi->lokasiTerakhir)->latitude,
    //         'longitude'  => optional($absensi->lokasiTerakhir)->longitude,
    //         'alamat'     => optional($absensi->lokasiTerakhir)->alamat,
    //         'update'     => optional($absensi->lokasiTerakhir)->waktu_update,
    //     ]);
    // }
    
    public function detailTeknisi($id)
    {
        $teknisi = Teknisi::with([
            'user',
            'divisi',
            'user.absensiTerakhir',
            'user.lokasiTerakhir'
        ])->findOrFail($id);

        $target = TargetProduktivitas::where(
            'divisi_id',
            $teknisi->divisi_id
        )->value('target') ?? 4;

        $jumlahPekerjaan = Pekerjaan::where(
            'user_id',
            $teknisi->user_id
        )
        ->whereDate('tanggal', today())
        ->count();

        $persen = min(($jumlahPekerjaan / $target) * 100, 100);
        $riwayatPekerjaan = Pekerjaan::where('user_id', $teknisi->user_id)
        ->orderByDesc('tanggal')
        ->orderByDesc('created_at')
        ->get();

        return view('admin.detailTeknisi', compact(
            'teknisi',
            'jumlahPekerjaan',
            'target',
            'persen',
            'riwayatPekerjaan'
        ));
    }
    

    public function divisi()
    {
        $divisis = Divisi::with('teknisis')->get();

        return view('admin.divisi.divisi', compact('divisis'));
    }
    public function assurance()
    {
        $teknisis = Teknisi::with('user')
            ->whereHas('divisi', function ($q) {
                $q->where('nama_divisi', 'Assurance');
            })
            ->orderByDesc('status')
            ->get();

        return view('admin.divisi.assurance', compact('teknisis'));
    }
    public function detailDivisi($id)
    {
        $divisi = Divisi::with([
            'teknisis.user.absensiTerakhir',
            'teknisis.user.lokasiTerakhir'
        ])->findOrFail($id);

        return view('admin.divisi.detail', compact('divisi'));
    }

    public function provisioning()
    {
        $teknisis = Teknisi::with('user')
            ->whereHas('divisi', function ($q) {
                $q->where('nama_divisi', 'Provisioning');
            })
            ->orderByDesc('status')
            ->get();

        return view('admin.divisi.provisioning', compact('teknisis'));
    }

    //target target target
    public function target()
    {
        $targets = TargetProduktivitas::with('divisi')->get();
        $divisis = Divisi::all();

        return view('admin.target', compact('targets', 'divisis'));
    }
    public function targetAssurance()
    {
        $divisi = Divisi::where('nama_divisi', 'Assurance')->first();

        $teknisis = Teknisi::with('user')
                    ->where('divisi_id', $divisi->id)
                    ->get();

        $target = TargetProduktivitas::where('divisi_id', $divisi->id)
                    ->value('target');

        return view('admin.target', [
            'judul' => 'Target Produktivitas - Assurance',
            'divisi' => $divisi,
            'teknisis' => $teknisis,
            'target' => $target
        ]);
    }
    public function targetProvisioning()
    {
        $divisi = Divisi::where('nama_divisi', 'Provisioning')->first();

        $teknisis = Teknisi::with('user')
                    ->where('divisi_id', $divisi->id)
                    ->get();

        $target = TargetProduktivitas::where('divisi_id', $divisi->id)
                    ->value('target');

        return view('admin.target', [
            'judul' => 'Target Produktivitas - Provisioning',
            'divisi' => $divisi,
            'teknisis' => $teknisis,
            'target' => $target
        ]);
    }

    public function pekerjaan()
    {
        return view('admin.pekerjaan');
    }


    public function monitoring()
    {
        $teknisis = Teknisi::with([
            'user',
            'divisi',
            'user.absensiTerakhir',
            'user.lokasiTerakhir'
        ])->get();

        $totalOnline = 0;
        $totalOffline = 0;
        $targetTercapai = 0;
        $totalPekerjaan = 0;

        foreach ($teknisis as $teknisi) {

            $jumlah = Pekerjaan::where('user_id', $teknisi->user_id)
                ->whereDate('tanggal', today())
                ->count();

            $target = TargetProduktivitas::where('divisi_id', $teknisi->divisi_id)->first();

            $targetHarian = $target ? $target->target : 4;

            $persen = $targetHarian > 0
                ? min(($jumlah / $targetHarian) * 100, 100)
                : 0;

            $teknisi->jumlah = $jumlah;
            $teknisi->target = $targetHarian;
            $teknisi->persen = $persen;

            $totalPekerjaan += $jumlah;

            if ($jumlah >= $targetHarian) {
                $targetTercapai++;
            }

            if (
                optional($teknisi->user->absensiTerakhir)->status == 'aktif'
                && !$teknisi->user->absensiTerakhir->jam_keluar
            ) {
                $totalOnline++;
            } else {
                $totalOffline++;
            }
        }

        return view('admin.monitoring', compact(
            'teknisis',
            'totalOnline',
            'totalOffline',
            'targetTercapai',
            'totalPekerjaan'
        ));
    }
    
    public function absensi()
    {
        $today = today();

        $teknisis = Teknisi::with([
            'user',
            'divisi'
        ])->get();

        foreach ($teknisis as $teknisi) {

            $teknisi->absensi = Absensi::where('user_id', $teknisi->user_id)
                ->whereDate('tanggal', $today)
                ->first();

        }

        $totalHadir = $teknisis->filter(function ($item) {
            return $item->absensi != null;
        })->count();

        $sudahPulang = $teknisis->filter(function ($item) {
            return $item->absensi && $item->absensi->jam_keluar;
        })->count();

        $belumPulang = $teknisis->filter(function ($item) {
            return $item->absensi && !$item->absensi->jam_keluar;
        })->count();
    
        $terlambat = $teknisis->filter(function ($item) {
            return $item->absensi &&
                $item->absensi->jam_masuk > '08:00:00';
        })->count();

        return view('admin.absensi', compact(
            'teknisis',
            'totalHadir',
            'sudahPulang',
            'belumPulang',
            'terlambat'
        ));
    }
    public function exportAbsensiExcel()
    {
        return Excel::download(
            new AbsensiExport,
            'Absensi_' . now()->format('Y-m-d') . '.xlsx'
        );
    }
    public function exportAbsensiPdf()
    {
        $absensis = Absensi::with('user')
            ->whereDate('tanggal', today())
            ->get();

        $pdf = Pdf::loadView('admin.pdf.absensi', compact('absensis'));

        return $pdf->download(
            'Absensi_' . now()->format('Y-m-d') . '.pdf'
        );
    }

    public function laporan()
    {
        $today = now()->toDateString();

        $laporans = Pekerjaan::with([
            'user',
            'user.teknisi.divisi'
        ])
        ->latest('tanggal')
        ->paginate(10);

        $totalPekerjaan = Pekerjaan::count();

        $selesai = Pekerjaan::where('status', 'selesai')->count();

        $pending = Pekerjaan::where('status', 'pending')->count();

        $totalTeknisi = Teknisi::count();

        $progressDivisi = Divisi::with('teknisis')->get()->map(function ($divisi) {

            $target = TargetProduktivitas::where('divisi_id', $divisi->id)
                ->value('target') ?? 0;

            $jumlahTeknisi = $divisi->teknisis->count();

            $targetTotal = $target * $jumlahTeknisi;

            $pekerjaan = Pekerjaan::whereIn(
                    'user_id',
                    $divisi->teknisis->pluck('user_id')
                )
                ->where('status', 'selesai')
                ->count();

            $persentase = $targetTotal > 0
                ? round(($pekerjaan / $targetTotal) * 100)
                : 0;

            return [

                'nama' => $divisi->nama_divisi,

                'target' => $targetTotal,

                'selesai' => $pekerjaan,

                'persentase' => min($persentase,100)

            ];

        });
        $tanggalAwal = request('tanggal_awal');
        $tanggalAkhir = request('tanggal_akhir');
        $divisi = request('divisi');
        $status = request('status');

        $query = Pekerjaan::with([
            'user',
            'user.teknisi.divisi'
        ]);

        if ($tanggalAwal) {
            $query->whereDate('tanggal', '>=', $tanggalAwal);
        }

        if ($tanggalAkhir) {
            $query->whereDate('tanggal', '<=', $tanggalAkhir);
        }

        if ($divisi) {

            $query->whereHas('user.teknisi', function ($q) use ($divisi) {

                $q->where('divisi_id', $divisi);

            });

        }

        if ($status) {

            $query->where('status', $status);

        }

        $laporans = $query
            ->latest('tanggal')
            ->paginate(10);

        $divisis = Divisi::all();

        return view('admin.laporan', compact(

            'laporans',

            'totalPekerjaan',

            'selesai',

            'pending',

            'totalTeknisi',

            'progressDivisi',
            'divisis'

        ));
    }
    public function exportLaporanPdf()
    {
        $laporans = Pekerjaan::with([
            'user',
            'user.teknisi.divisi'
        ])
        ->latest('tanggal')
        ->get();

        $pdf = Pdf::loadView(
            'admin.pdf.laporan',
            compact('laporans')
        );

        return $pdf->download('Laporan_Produktivitas.pdf');
    }
    public function exportLaporanExcel()
    {
        return Excel::download(
            new LaporanExport,
            'Laporan_Produktivitas.xlsx'
        );
    }
    
    public function profil()
    {
        return view('admin.profil');
    }
}
