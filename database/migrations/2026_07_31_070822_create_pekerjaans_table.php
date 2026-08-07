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

            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            $table->string('nomor_tiket')->unique();

            $table->string('nama_pelanggan');

            $table->text('alamat_pelanggan');

            $table->string('jenis_pekerjaan');

            $table->text('deskripsi')->nullable();

            $table->string('foto')->nullable();

            $table->date('tanggal')->index();

            $table->time('jam_selesai')->nullable();

            $table->integer('durasi')->nullable()->comment('Durasi pekerjaan dalam menit');

            $table->enum('status', ['pending', 'selesai'])->default('pending')->index();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pekerjaan');
    }
};
