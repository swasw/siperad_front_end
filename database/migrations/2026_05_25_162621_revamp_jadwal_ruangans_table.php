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
        Schema::table('jadwal_ruangans', function (Blueprint $table) {
            $table->dropColumn(['matkul_id', 'dosen_id', 'prodi_id', 'angkatan_id', 'jam_mulai_id', 'jam_selesai_id']);
            $table->string('mata_kuliah')->nullable();
            $table->string('dosen')->nullable();
            $table->string('prodi')->nullable();
            $table->string('angkatan')->nullable();
            $table->string('kelas')->nullable();
            $table->integer('jam_mulai_ke')->nullable();
            $table->integer('jam_selesai_ke')->nullable();
            $table->time('jam_mulai')->nullable();
            $table->time('jam_selesai')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jadwal_ruangans', function (Blueprint $table) {
            $table->unsignedBigInteger('matkul_id')->nullable();
            $table->unsignedBigInteger('dosen_id')->nullable();
            $table->unsignedBigInteger('prodi_id')->nullable();
            $table->unsignedBigInteger('angkatan_id')->nullable();
            $table->unsignedBigInteger('jam_mulai_id')->nullable();
            $table->unsignedBigInteger('jam_selesai_id')->nullable();
            $table->dropColumn(['mata_kuliah', 'dosen', 'prodi', 'angkatan', 'kelas', 'jam_mulai_ke', 'jam_selesai_ke', 'jam_mulai', 'jam_selesai']);
        });
    }
};
