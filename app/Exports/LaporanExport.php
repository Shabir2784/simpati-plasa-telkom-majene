<?php

namespace App\Exports;

use App\Models\Pekerjaan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LaporanExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Pekerjaan::with([
            'user',
            'user.teknisi.divisi'
        ])
        ->get()
        ->map(function ($item) {

            return [

                'Tanggal' => $item->tanggal,

                'Teknisi' => $item->user->nama,

                'Divisi' => optional($item->user->teknisi->divisi)->nama_divisi,

                'Nomor Tiket' => $item->nomor_tiket,

                'Pelanggan' => $item->nama_pelanggan,

                'Jenis Pekerjaan' => $item->jenis_pekerjaan,

                'Durasi (Menit)' => $item->durasi,

                'Status' => ucfirst($item->status),

            ];

        });
    }

    public function headings(): array
    {
        return [

            'Tanggal',

            'Teknisi',

            'Divisi',

            'Nomor Tiket',

            'Pelanggan',

            'Jenis Pekerjaan',

            'Durasi (Menit)',

            'Status',

        ];
    }
}