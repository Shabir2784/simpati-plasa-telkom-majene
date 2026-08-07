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
       Schema::create('users', function (Blueprint $table) {
            $table->id();

            $table->string('nama');
            $table->string('nik')->unique();
            $table->string('email')->unique();
            $table->string('password');

            $table->enum('role', ['admin', 'teknisi'])->default('teknisi');

            $table->foreignId('divisi_id')->constrained('divisis')->cascadeOnUpdate()->restrictOnDelete();

            $table->string('no_hp')->nullable();
            $table->string('foto')->nullable();

            $table->boolean('is_active')->default(true);

            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
