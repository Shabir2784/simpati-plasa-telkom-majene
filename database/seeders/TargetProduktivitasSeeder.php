<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Divisi;
use App\Models\TargetProduktivitas;

class TargetProduktivitasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $provisioning = Divisi::where('nama_divisi', 'Provisioning')->first();

        $assurance = Divisi::where('nama_divisi', 'Assurance')->first();

        TargetProduktivitas::create([
            'divisi_id' => $provisioning->id,
            'target' => 2
        ]);

        TargetProduktivitas::create([
            'divisi_id' => $assurance->id,
            'target' => 5
        ]);
    }
}
