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

        // Monitoring Teknisi
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

            $item->persentase = $item->target > 0
                ? min(($item->jumlahPekerjaan / $item->target) * 100, 100)
                : 0;
        }

        // Monitoring berdasarkan divisi
        $monitoringDivisi = $monitoring->groupBy(function ($item) {
            return $item->divisi->nama_divisi;
        });

        // Top Teknisi
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

        // Progress Divisi
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

        // Lokasi Teknisi
        $lokasiTeknisi = LokasiTeknisi::with([
            'user',
            'user.absensiTerakhir',
            'user.divisi'
        ])
            ->whereIn('id', function ($query) {
                $query->selectRaw('MAX(id)')
                    ->from('lokasi_teknisis')
                    ->groupBy('user_id');
            })
            ->get();

        return view('admin.dashboardAdmin', compact(
            'totalTeknisi',
            'online',
            'offline',
            'totalPekerjaan',
            'targetTercapai',
            'monitoring',
            'monitoringDivisi',
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
        $request->validate([
            'nama' => 'required',
            'password' => 'required|min:6',
            'nik' => 'required|unique:users,nik|unique:teknisis,nik',
            'divisi_id' => 'required',
            'no_hp' => 'required',
            'alamat' => 'nullable|string',
        ]);

        $user = User::create([
            'nama' => $request->nama,
            'nik' => $request->nik,
            'email' => null,
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
        $teknisi = Teknisi::findOrFail($id);

        $request->validate([
            'nama' => 'required',
            'nik' => 'required|unique:teknisis,nik,' . $id,
            'divisi_id' => 'required',
            'no_hp' => 'required',
            'alamat' => 'nullable|string',
        ]);

        $teknisi->user->update([
            'nama' => $request->nama,
            'nik' => $request->nik,
            'divisi_id' => $request->divisi_id,
            'no_hp' => $request->no_hp,
        ]);

        $teknisi->update([
            'divisi_id' => $request->divisi_id,
            'nik' => $request->nik,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
        ]);

        return redirect()
            ->route('admin.teknisi')
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
        $teknisi = Teknisi::with('user')->findOrFail($id);

        $lokasi = LokasiTeknisi::where('user_id', $teknisi->user_id)
            ->latest('waktu_update')
            ->first();

        if (!$lokasi) {
            return response()->json([
                'success' => false,
                'message' => 'Lokasi teknisi belum tersedia.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'nama' => $teknisi->user->nama,
            'latitude' => (float) $lokasi->latitude,
            'longitude' => (float) $lokasi->longitude,
            'waktu_update' => $lokasi->waktu_update
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

        foreach ($teknisis as $teknisi) {
            $teknisi->realisasi = Pekerjaan::where('user_id', $teknisi->user_id)
                ->whereDate('tanggal', today())
                ->where('status', 'selesai')
                ->count();
        }

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

        foreach ($teknisis as $teknisi) {
            $teknisi->realisasi = Pekerjaan::where('user_id', $teknisi->user_id)
                ->whereDate('tanggal', today())
                ->where('status', 'selesai')
                ->count();
        }

        return view('admin.target', [
            'judul' => 'Target Produktivitas - Provisioning',
            'divisi' => $divisi,
            'teknisis' => $teknisis,
            'target' => $target
        ]);
    }
    public function detailTarget($id)
    {
        $teknisi = Teknisi::with('user', 'divisi')->findOrFail($id);

        $target = TargetProduktivitas::where('divisi_id', $teknisi->divisi_id)
            ->value('target');

        $pekerjaans = Pekerjaan::where('user_id', $teknisi->user_id)
            ->whereDate('tanggal', today())
            ->where('status', 'selesai')
            ->orderBy('jam_selesai')
            ->get();

        $realisasi = $pekerjaans->count();

        $persentase = $target > 0
            ? min(($realisasi / $target) * 100, 100)
            : 0;

        return view('admin.detailTarget', compact(
            'teknisi',
            'target',
            'pekerjaans',
            'realisasi',
            'persentase'
        ));
    }
    public function resetPassword(Request $request, $id)
    {
        $request->validate([
            'password' => 'required|min:6|confirmed',
        ]);

        $teknisi = Teknisi::findOrFail($id);

        $teknisi->user->password = Hash::make($request->password);
        $teknisi->user->save();

        return back()->with('success', 'Password teknisi berhasil direset.');
    }

   public function monitoringAssurance()
    {
        $teknisis = Teknisi::with([
            'user',
            'divisi',
            'user.absensiTerakhir',
            'user.lokasiTerakhir'
        ])
        ->whereHas('divisi', function ($query) {
            $query->where('nama_divisi', 'Assurance');
        })
        ->get();

        $totalOnline = 0;
        $totalOffline = 0;
        $targetTercapai = 0;
        $totalPekerjaan = 0;

        foreach ($teknisis as $teknisi) {

            $jumlah = Pekerjaan::where('user_id', $teknisi->user_id)
                ->whereDate('tanggal', today())
                ->count();

            $target = TargetProduktivitas::where('divisi_id', $teknisi->divisi_id)
                ->value('target') ?? 4;

            $persen = $target > 0
                ? min(($jumlah / $target) * 100, 100)
                : 0;

            $teknisi->jumlah = $jumlah;
            $teknisi->target = $target;
            $teknisi->persen = $persen;

            $totalPekerjaan += $jumlah;

            if ($jumlah >= $target) {
                $targetTercapai++;
            }

            $absensi = $teknisi->user->absensiTerakhir;

            if ($absensi && $absensi->status == 'aktif' && !$absensi->jam_keluar) {
                $totalOnline++;
            } else {
                $totalOffline++;
            }
        }

        return view('admin.monitoringAssurance', compact(
            'teknisis',
            'totalOnline',
            'totalOffline',
            'targetTercapai',
            'totalPekerjaan'
        ));
    }


    public function monitoringProvisioning()
    {
        $teknisis = Teknisi::with([
            'user',
            'divisi',
            'user.absensiTerakhir',
            'user.lokasiTerakhir'
        ])
        ->whereHas('divisi', function ($query) {
            $query->where('nama_divisi', 'Provisioning');
        })
        ->get();

        $totalOnline = 0;
        $totalOffline = 0;
        $targetTercapai = 0;
        $totalPekerjaan = 0;

        foreach ($teknisis as $teknisi) {

            $jumlah = Pekerjaan::where('user_id', $teknisi->user_id)
                ->whereDate('tanggal', today())
                ->count();

            $target = TargetProduktivitas::where('divisi_id', $teknisi->divisi_id)
                ->value('target') ?? 4;

            $persen = $target > 0
                ? min(($jumlah / $target) * 100, 100)
                : 0;

            $teknisi->jumlah = $jumlah;
            $teknisi->target = $target;
            $teknisi->persen = $persen;

            $totalPekerjaan += $jumlah;

            if ($jumlah >= $target) {
                $targetTercapai++;
            }

            $absensi = $teknisi->user->absensiTerakhir;

            if ($absensi && $absensi->status == 'aktif' && !$absensi->jam_keluar) {
                $totalOnline++;
            } else {
                $totalOffline++;
            }
        }

        return view('admin.monitoringProvisioning', compact(
            'teknisis',
            'totalOnline',
            'totalOffline',
            'targetTercapai',
            'totalPekerjaan'
        ));
    }
    public function detailMonitoring($id)
    {
        $teknisi = Teknisi::with(['user', 'divisi'])->findOrFail($id);

        $pekerjaans = Pekerjaan::where('user_id', $teknisi->user_id)
            ->whereDate('tanggal', today())
            ->latest()
            ->get();

        $target = TargetProduktivitas::where('divisi_id', $teknisi->divisi_id)
            ->value('target') ?? 0;

        $jumlah = $pekerjaans->count();

        $persen = $target > 0
            ? min(($jumlah / $target) * 100, 100)
            : 0;

        return view('admin.detailMonitoring', compact(
            'teknisi',
            'pekerjaans',
            'target',
            'jumlah',
            'persen'
        ));
    }
    
    public function absensiAssurance()
    {
    $teknisis = Teknisi::with([
        'user',
        'divisi',
        'absensiHariIni'
    ])
    ->whereHas('divisi', function ($query) {
        $query->where('nama_divisi', 'Assurance');
    })
    ->get();

    $totalHadir = $teknisis->filter(function ($teknisi) {
        return $teknisi->absensiHariIni;
    })->count();

    $sudahPulang = $teknisis->filter(function ($teknisi) {
        return $teknisi->absensiHariIni &&
               $teknisi->absensiHariIni->jam_keluar;
    })->count();

    $belumPulang = $teknisis->filter(function ($teknisi) {
        return $teknisi->absensiHariIni &&
               !$teknisi->absensiHariIni->jam_keluar;
    })->count();

    $terlambat = $teknisis->filter(function ($teknisi) {
        return $teknisi->absensiHariIni &&
               $teknisi->absensiHariIni->status == 'terlambat';
    })->count();

    return view('admin.absensiAssurance', compact(
        'teknisis',
        'totalHadir',
        'sudahPulang',
        'belumPulang',
        'terlambat'
    ));
}


    public function absensiProvisioning()
    {
        $teknisis = Teknisi::with([
            'user',
            'divisi',
            'absensiHariIni'
        ])
        ->whereHas('divisi', function ($query) {
            $query->where('nama_divisi', 'Provisioning');
        })
        ->get();

        $totalHadir = $teknisis->filter(function ($teknisi) {
            return $teknisi->absensiHariIni;
        })->count();

        $sudahPulang = $teknisis->filter(function ($teknisi) {
            return $teknisi->absensiHariIni &&
                $teknisi->absensiHariIni->jam_keluar;
        })->count();

        $belumPulang = $teknisis->filter(function ($teknisi) {
            return $teknisi->absensiHariIni &&
                !$teknisi->absensiHariIni->jam_keluar;
        })->count();

        $terlambat = $teknisis->filter(function ($teknisi) {
            return $teknisi->absensiHariIni &&
                $teknisi->absensiHariIni->status == 'terlambat';
        })->count();

        return view('admin.absensiProvisioning', compact(
            'teknisis',
            'totalHadir',
            'sudahPulang',
            'belumPulang',
            'terlambat'
        ));
    }
    public function exportAbsensiExcelAssurance()
{
    return Excel::download(
        new AbsensiExport('Assurance'),
        'Absensi_Assurance_' . now()->format('Y-m-d') . '.xlsx'
    );
}

public function exportAbsensiExcelProvisioning()
{
    return Excel::download(
        new AbsensiExport('Provisioning'),
        'Absensi_Provisioning_' . now()->format('Y-m-d') . '.xlsx'
    );
}

    public function exportAbsensiPdfAssurance()
    {
        $absensis = Absensi::with([
            'user.teknisi.divisi'
        ])
        ->whereDate('tanggal', today())
        ->whereHas('user.teknisi.divisi', function ($query) {
            $query->where('nama_divisi', 'Assurance');
        })
        ->get();

        $divisi = 'Assurance';

        $pdf = Pdf::loadView(
            'admin.pdf.absensi',
            compact('absensis', 'divisi')
        );

        return $pdf->download(
            'Absensi_Assurance_' . now()->format('Y-m-d') . '.pdf'
        );
    }

    public function exportAbsensiPdfProvisioning()
    {
        $absensis = Absensi::with([
            'user.teknisi.divisi'
        ])
        ->whereDate('tanggal', today())
        ->whereHas('user.teknisi.divisi', function ($query) {
            $query->where('nama_divisi', 'Provisioning');
        })
        ->get();

        $divisi = 'Provisioning';

        $pdf = Pdf::loadView(
            'admin.pdf.absensi',
            compact('absensis', 'divisi')
        );

        return $pdf->download(
            'Absensi_Provisioning_' . now()->format('Y-m-d') . '.pdf'
        );
    }

    public function laporan()
    {
        $totalPekerjaan = Pekerjaan::count();

        $selesai = Pekerjaan::where('status', 'selesai')->count();

        $pending = Pekerjaan::where('status', 'pending')->count();

        $totalTeknisi = Teknisi::count();

        $tanggalAwal = request('tanggal_awal');
        $tanggalAkhir = request('tanggal_akhir');
        $divisi = request('divisi');
        $status = request('status');

        /*
        |--------------------------------------------------------------------------
        | QUERY DASAR
        |--------------------------------------------------------------------------
        */

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

        /*
        |--------------------------------------------------------------------------
        | DATA ASSURANCE
        |--------------------------------------------------------------------------
        */

        $assurance = (clone $query)
            ->whereHas('user.teknisi.divisi', function ($q) {
                $q->where('nama_divisi', 'Assurance');
            })
            ->latest('tanggal')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | DATA PROVISIONING
        |--------------------------------------------------------------------------
        */

        $provisioning = (clone $query)
            ->whereHas('user.teknisi.divisi', function ($q) {
                $q->where('nama_divisi', 'Provisioning');
            })
            ->latest('tanggal')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | DATA DIVISI
        |--------------------------------------------------------------------------
        */

        $divisis = Divisi::all();

        /*
        |--------------------------------------------------------------------------
        | PROGRESS DIVISI
        |--------------------------------------------------------------------------
        */

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
                'persentase' => min($persentase, 100)
            ];
        });

        return view('admin.laporan', compact(
            'assurance',
            'provisioning',
            'totalPekerjaan',
            'selesai',
            'pending',
            'totalTeknisi',
            'progressDivisi',
            'divisis'
        ));
    }
    public function laporanDivisi($namaDivisi)
    {
        $divisi = Divisi::where('nama_divisi', $namaDivisi)->firstOrFail();

        $periode = request('periode', 'harian');

        $query = Pekerjaan::with([
            'user',
            'user.teknisi.divisi'
        ])->whereHas('user.teknisi', function ($q) use ($divisi) {
            $q->where('divisi_id', $divisi->id);
        });

        if ($periode == 'harian') {

            $query->whereDate('tanggal', today());

        } elseif ($periode == 'mingguan') {

            $query->whereBetween('tanggal', [
                now()->startOfWeek()->toDateString(),
                now()->endOfWeek()->toDateString()
            ]);

        } elseif ($periode == 'bulanan') {

            $query->whereMonth('tanggal', now()->month)
                ->whereYear('tanggal', now()->year);
        }

        if (request('tanggal_awal')) {
            $query->whereDate('tanggal', '>=', request('tanggal_awal'));
        }

        if (request('tanggal_akhir')) {
            $query->whereDate('tanggal', '<=', request('tanggal_akhir'));
        }

        if (request('status')) {
            $query->where('status', request('status'));
        }

        $laporans = $query
            ->latest('tanggal')
            ->get();

        $total = $laporans->count();

        $selesai = $laporans
            ->where('status', 'selesai')
            ->count();

        $pending = $laporans
            ->where('status', 'pending')
            ->count();

        $teknisi = Teknisi::where('divisi_id', $divisi->id)->count();

        return view('admin.laporanDivisi', compact(
            'divisi',
            'laporans',
            'periode',
            'total',
            'selesai',
            'pending',
            'teknisi'
        ));
    }
    public function laporanAssurance(Request $request)
    {
        $divisi = Divisi::where('nama_divisi', 'Assurance')->firstOrFail();

        $periode = $request->periode ?? 'harian';

        $query = Pekerjaan::with([
            'user',
            'user.teknisi.divisi'
        ])->whereHas('user.teknisi', function ($q) use ($divisi) {
            $q->where('divisi_id', $divisi->id);
        });

        /*
        |--------------------------------------------------------------------------
        | PERIODE
        |--------------------------------------------------------------------------
        */

        if ($periode === 'harian') {

            $query->whereDate('tanggal', today());

        } elseif ($periode === 'mingguan') {

            $query->whereBetween('tanggal', [
                now()->startOfWeek()->toDateString(),
                now()->endOfWeek()->toDateString()
            ]);

        } elseif ($periode === 'bulanan') {

            $query->whereBetween('tanggal', [
                now()->startOfMonth()->toDateString(),
                now()->endOfMonth()->toDateString()
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | FILTER TANGGAL MANUAL
        |--------------------------------------------------------------------------
        */

        if ($request->tanggal_awal) {
            $query->whereDate('tanggal', '>=', $request->tanggal_awal);
        }

        if ($request->tanggal_akhir) {
            $query->whereDate('tanggal', '<=', $request->tanggal_akhir);
        }

        /*
        |--------------------------------------------------------------------------
        | FILTER STATUS
        |--------------------------------------------------------------------------
        */

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $laporans = $query
            ->latest('tanggal')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | RINGKASAN
        |--------------------------------------------------------------------------
        */

        $total = $laporans->count();

        $selesai = $laporans
            ->where('status', 'selesai')
            ->count();

        $pending = $laporans
            ->where('status', 'pending')
            ->count();

        $teknisi = $divisi->teknisis()->count();

        return view('admin.laporanDivisi', compact(
            'divisi',
            'periode',
            'laporans',
            'total',
            'selesai',
            'pending',
            'teknisi'
        ));
    }


    public function laporanProvisioning(Request $request)
    {
        $divisi = Divisi::where('nama_divisi', 'Provisioning')->firstOrFail();

        $periode = $request->periode ?? 'harian';

        $query = Pekerjaan::with([
            'user',
            'user.teknisi.divisi'
        ])->whereHas('user.teknisi', function ($q) use ($divisi) {
            $q->where('divisi_id', $divisi->id);
        });

        /*
        |--------------------------------------------------------------------------
        | PERIODE
        |--------------------------------------------------------------------------
        */

        if ($periode === 'harian') {

            $query->whereDate('tanggal', today());

        } elseif ($periode === 'mingguan') {

            $query->whereBetween('tanggal', [
                now()->startOfWeek()->toDateString(),
                now()->endOfWeek()->toDateString()
            ]);

        } elseif ($periode === 'bulanan') {

            $query->whereBetween('tanggal', [
                now()->startOfMonth()->toDateString(),
                now()->endOfMonth()->toDateString()
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | FILTER TANGGAL MANUAL
        |--------------------------------------------------------------------------
        */

        if ($request->tanggal_awal) {
            $query->whereDate('tanggal', '>=', $request->tanggal_awal);
        }

        if ($request->tanggal_akhir) {
            $query->whereDate('tanggal', '<=', $request->tanggal_akhir);
        }

        /*
        |--------------------------------------------------------------------------
        | FILTER STATUS
        |--------------------------------------------------------------------------
        */

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $laporans = $query
            ->latest('tanggal')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | RINGKASAN
        |--------------------------------------------------------------------------
        */

        $total = $laporans->count();

        $selesai = $laporans
            ->where('status', 'selesai')
            ->count();

        $pending = $laporans
            ->where('status', 'pending')
            ->count();

        $teknisi = $divisi->teknisis()->count();

        return view('admin.laporanDivisi', compact(
            'divisi',
            'periode',
            'laporans',
            'total',
            'selesai',
            'pending',
            'teknisi'
        ));
    }
    private function laporanPerDivisi(Request $request, $namaDivisi)
    {
        $divisi = Divisi::where('nama_divisi', $namaDivisi)->firstOrFail();

        $periode = $request->periode ?? 'harian';

        $query = Pekerjaan::with([
            'user',
            'user.teknisi.divisi'
        ])->whereHas('user.teknisi', function ($q) use ($divisi) {
            $q->where('divisi_id', $divisi->id);
        });

        /*
        |--------------------------------------------------------------------------
        | PERIODE
        |--------------------------------------------------------------------------
        */

        if ($periode == 'harian') {

            $query->whereDate('tanggal', today());

        } elseif ($periode == 'mingguan') {

            $query->whereBetween('tanggal', [
                now()->startOfWeek()->toDateString(),
                now()->endOfWeek()->toDateString()
            ]);

        } elseif ($periode == 'bulanan') {

            $query->whereMonth('tanggal', now()->month)
                ->whereYear('tanggal', now()->year);
        }

        /*
        |--------------------------------------------------------------------------
        | FILTER TANGGAL CUSTOM
        |--------------------------------------------------------------------------
        */

        if ($request->tanggal_awal) {

            $query->whereDate(
                'tanggal',
                '>=',
                $request->tanggal_awal
            );
        }

        if ($request->tanggal_akhir) {

            $query->whereDate(
                'tanggal',
                '<=',
                $request->tanggal_akhir
            );
        }

        /*
        |--------------------------------------------------------------------------
        | FILTER STATUS
        |--------------------------------------------------------------------------
        */

        if ($request->status) {

            $query->where(
                'status',
                $request->status
            );
        }

        $laporans = $query
            ->latest('tanggal')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | RINGKASAN
        |--------------------------------------------------------------------------
        */

        $total = $laporans->count();

        $selesai = $laporans
            ->where('status', 'selesai')
            ->count();

        $pending = $laporans
            ->where('status', 'pending')
            ->count();

        $teknisi = Teknisi::where(
            'divisi_id',
            $divisi->id
        )->count();

        return view(
            'admin.laporanDivisi',
            compact(
                'divisi',
                'laporans',
                'periode',
                'total',
                'selesai',
                'pending',
                'teknisi'
            )
        );
    }

    public function detailLaporan($id)
    {
        $pekerjaan = Pekerjaan::with([
            'user',
            'user.teknisi.divisi'
        ])->findOrFail($id);

        return view('admin.detailLaporan', compact('pekerjaan'));
    }
    
    public function exportLaporanPdf(Request $request)
    {
        $divisi = Divisi::findOrFail($request->divisi);

        $periode = $request->periode ?? 'harian';

        $query = Pekerjaan::with([
            'user',
            'user.teknisi.divisi'
        ])->whereHas('user.teknisi', function ($q) use ($divisi) {
            $q->where('divisi_id', $divisi->id);
        });

        /*
        |--------------------------------------------------------------------------
        | PERIODE
        |--------------------------------------------------------------------------
        */

        if ($periode === 'harian') {

            $query->whereDate('tanggal', today());

        } elseif ($periode === 'mingguan') {

            $query->whereBetween('tanggal', [
                now()->startOfWeek()->toDateString(),
                now()->endOfWeek()->toDateString()
            ]);

        } elseif ($periode === 'bulanan') {

            $query->whereBetween('tanggal', [
                now()->startOfMonth()->toDateString(),
                now()->endOfMonth()->toDateString()
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | FILTER TANGGAL
        |--------------------------------------------------------------------------
        */

        if ($request->tanggal_awal) {
            $query->whereDate('tanggal', '>=', $request->tanggal_awal);
        }

        if ($request->tanggal_akhir) {
            $query->whereDate('tanggal', '<=', $request->tanggal_akhir);
        }

        /*
        |--------------------------------------------------------------------------
        | FILTER STATUS
        |--------------------------------------------------------------------------
        */

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $laporans = $query
            ->latest('tanggal')
            ->get();

        $pdf = Pdf::loadView(
            'admin.pdf.laporan',
            compact(
                'laporans',
                'divisi',
                'periode'
            )
        );

        $namaFile = 'Laporan_' . $divisi->nama_divisi . '_' . $periode . '.pdf';

        return $pdf->download($namaFile);
    }
    public function exportLaporanExcel(Request $request)
    {
        $divisi = Divisi::findOrFail($request->divisi);

        $periode = $request->periode ?? 'harian';

        return Excel::download(
            new LaporanExport(
                $divisi->id,
                $periode,
                $request->tanggal_awal,
                $request->tanggal_akhir,
                $request->status
            ),
            'Laporan_' . $divisi->nama_divisi . '_' . $periode . '.xlsx'
        );
    }
    
    public function profil()
    {
        return view('admin.profil');
    }
}
