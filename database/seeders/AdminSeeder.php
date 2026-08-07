<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Divisi;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $divisi = Divisi::first();

        User::create([
            'nama' => 'Admin',
            'nik' => 'ADM001',
            'email' => 'admin@telkom.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'divisi_id' => $divisi->id,
            'no_hp' => '081234567890',
            'foto' => null,
            'is_active' => true,
        ]);
    }
}
