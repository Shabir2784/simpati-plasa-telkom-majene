<?php

namespace App\Exports;

use App\Models\Absensi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AbsensiExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Absensi::with('user')
            ->whereDate('tanggal', today())
            ->get()
            ->map(function ($item) {

                return [
                    $item->user->nama,
                    $item->tanggal,
                    $item->jam_masuk,
                    $item->jam_keluar,
                    $item->status,
                    $item->latitude_masuk,
                    $item->longitude_masuk,
                ];

            });
    }

    public function headings(): array
    {
        return [
            'Nama Teknisi',
            'Tanggal',
            'Jam Masuk',
            'Jam Keluar',
            'Status',
            'Latitude',
            'Longitude',
        ];
    }
}