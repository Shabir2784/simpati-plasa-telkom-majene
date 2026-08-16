<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Divisi;

class DivisiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       Divisi::updateOrCreate(
            ['nama_divisi' => 'Provisioning'],
            [
                'target_default' => 2,
                'keterangan' => 'Menangani pemasangan layanan baru.'
            ]
        );

        Divisi::updateOrCreate(
            ['nama_divisi' => 'Assurance'],
            [
                'target_default' => 5,
                'keterangan' => 'Menangani gangguan dan perbaikan layanan.'
            ]
        );
    }
}
