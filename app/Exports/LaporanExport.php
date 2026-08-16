<?php

namespace App\Exports;

use App\Models\Pekerjaan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LaporanExport implements FromCollection, WithHeadings
{
    protected $divisiId;
    protected $periode;
    protected $tanggalAwal;
    protected $tanggalAkhir;
    protected $status;
    protected $namaDivisi;

    public function __construct(
        $divisiId,
        $periode = 'harian',
        $tanggalAwal = null,
        $tanggalAkhir = null,
        $status = null
    ) {
        $this->divisiId = $divisiId;
        $this->periode = $periode;
        $this->tanggalAwal = $tanggalAwal;
        $this->tanggalAkhir = $tanggalAkhir;
        $this->status = $status;

        $this->namaDivisi = \App\Models\Divisi::findOrFail($divisiId)->nama_divisi;
    }

    public function collection()
    {
        $query = Pekerjaan::with([
            'user',
            'user.teknisi.divisi'
        ])
        ->whereHas('user.teknisi', function ($q) {
            $q->where('divisi_id', $this->divisiId);
        });

        /*
        |--------------------------------------------------------------------------
        | PERIODE
        |--------------------------------------------------------------------------
        */

        if ($this->periode === 'harian') {

            $query->whereDate('tanggal', today());

        } elseif ($this->periode === 'mingguan') {

            $query->whereBetween('tanggal', [
                now()->startOfWeek()->toDateString(),
                now()->endOfWeek()->toDateString()
            ]);

        } elseif ($this->periode === 'bulanan') {

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

        if ($this->tanggalAwal) {
            $query->whereDate(
                'tanggal',
                '>=',
                $this->tanggalAwal
            );
        }

        if ($this->tanggalAkhir) {
            $query->whereDate(
                'tanggal',
                '<=',
                $this->tanggalAkhir
            );
        }

        /*
        |--------------------------------------------------------------------------
        | FILTER STATUS
        |--------------------------------------------------------------------------
        */

        if ($this->status) {
            $query->where(
                'status',
                $this->status
            );
        }

        return $query
            ->latest('tanggal')
            ->get()
            ->map(function ($item) {

                if ($this->namaDivisi === 'Assurance') {

                    return [

                        'Tanggal' => $item->tanggal,

                        'Teknisi' => optional($item->user)->nama ?? '-',

                        'Nomor Tiket' => $item->nomor_tiket ?? '-',

                        'ALPRO' => $item->alpro ?? '-',

                        'Pelanggan' => $item->nama_pelanggan ?? '-',

                        'Jenis Pekerjaan' => $item->jenis_pekerjaan ?? '-',

                        'Jam Selesai' => $item->jam_selesai ?? '-',

                        'Status' => ucfirst($item->status),

                    ];
                }

                return [

                    'Tanggal' => $item->tanggal,

                    'Teknisi' => optional($item->user)->nama ?? '-',

                    'Nomor WO' => $item->nomor_wo ?? '-',

                    'SC Order' => $item->sc_order ?? '-',

                    'ALPRO' => $item->alpro ?? '-',

                    'Segmen' => $item->segmen ?? '-',

                    'Pelanggan' => $item->nama_pelanggan ?? '-',

                    'Jenis Pekerjaan' => $item->jenis_pekerjaan ?? '-',

                    'Jam Selesai' => $item->jam_selesai ?? '-',

                    'Status' => ucfirst($item->status),

                ];
            });
    }

    public function headings(): array
    {
        if ($this->namaDivisi === 'Assurance') {

            return [
                'Tanggal',
                'Teknisi',
                'Nomor Tiket',
                'ALPRO',
                'Pelanggan',
                'Jenis Pekerjaan',
                'Jam Selesai',
                'Status',
            ];
        }

        return [
            'Tanggal',
            'Teknisi',
            'Nomor WO',
            'SC Order',
            'ALPRO',
            'Segmen',
            'Pelanggan',
            'Jenis Pekerjaan',
            'Jam Selesai',
            'Status',
        ];
    }
}