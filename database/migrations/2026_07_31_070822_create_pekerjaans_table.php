<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pekerjaans', function (Blueprint $table) {

            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            // Identitas pekerjaan berdasarkan divisi
            $table->string('nomor_tiket')->nullable()->unique();
            $table->string('nomor_wo')->nullable()->unique();
            $table->string('sc_order')->nullable();

            // Data teknis
            $table->string('alpro')->nullable();
            $table->string('segmen')->nullable();

            // Data pelanggan
            $table->string('nama_pelanggan');
            $table->text('alamat_pelanggan');

            // Data pekerjaan
            $table->string('jenis_pekerjaan');
            $table->text('deskripsi')->nullable();

            // Bukti pekerjaan
            $table->string('foto')->nullable();

            // Waktu pekerjaan
            $table->date('tanggal')->index();
            $table->time('jam_selesai')->nullable();

            // Durasi dalam menit
            $table->integer('durasi')
                ->nullable()
                ->comment('Durasi pekerjaan dalam menit');

            // Status pekerjaan
            $table->enum('status', ['pending', 'selesai'])
                ->default('pending')
                ->index();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
       Schema::dropIfExists('pekerjaans');
    }
};
