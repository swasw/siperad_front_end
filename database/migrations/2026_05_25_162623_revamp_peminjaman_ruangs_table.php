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
        Schema::table('peminjaman_ruangs', function (Blueprint $table) {
            $table->dropColumn(['matkul_id', 'dosen_id', 'prodi_id', 'angkatan_id']);
            $table->string('mata_kuliah')->nullable();
            $table->string('dosen')->nullable();
            $table->string('prodi')->nullable();
            $table->string('angkatan')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('peminjaman_ruangs', function (Blueprint $table) {
            $table->unsignedBigInteger('matkul_id')->nullable();
            $table->unsignedBigInteger('dosen_id')->nullable();
            $table->unsignedBigInteger('prodi_id')->nullable();
            $table->unsignedBigInteger('angkatan_id')->nullable();
            $table->dropColumn(['mata_kuliah', 'dosen', 'prodi', 'angkatan']);
        });
    }
};
