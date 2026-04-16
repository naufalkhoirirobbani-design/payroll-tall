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
        Schema::create('penggajian', function (Blueprint $table) {
            $table->id();

            $table->foreignId('karyawan_id')->contrained('karyawan')->Ondelete();
            $table->string('bulan', 2); // 01, 02, dst 
            $table->string('tahun', 4); // 2026, dst
            $table->date('tanggal_proses');
            $table->integer('gaji_pokok');
            $table->integer('tunjangan');
            $table->integer('potonagan');
            $table->integer('total_gaji');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penggajian');
    }
};
