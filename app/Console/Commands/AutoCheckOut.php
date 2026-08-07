<?php

namespace App\Console\Commands;

use App\Models\Absensi;
use Illuminate\Console\Command;

class AutoCheckOut extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'app:auto-check-out';

    /**
     * The console command description.
     */
    protected $description = 'Auto Check Out teknisi yang lupa Check Out';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $jumlah = Absensi::where('status', 'aktif')
            ->whereDate('tanggal', '<', today())
            ->update([
                'jam_keluar' => '07:00:00',
                'status' => 'selesai',
            ]);

        $this->info("Berhasil Auto Check Out {$jumlah} teknisi.");

        return self::SUCCESS;
    }
}