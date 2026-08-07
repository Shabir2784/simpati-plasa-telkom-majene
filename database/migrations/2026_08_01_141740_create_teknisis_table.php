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
        Schema::create('teknisis', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();

            $table->foreignId('divisi_id')->constrained('divisis')->restrictOnDelete();

            $table->string('nik', 16)->unique();
            $table->string('no_hp');
            $table->text('alamat')->nullable();

            $table->enum('status', ['Aktif', 'Nonaktif'])
                ->default('Aktif');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teknisis');
    }
};
