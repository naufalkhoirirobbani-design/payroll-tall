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
        Schema::create('karyawan', function (Blueprint $table) {
            $table->id();

            // Data karyawan
            $table->string('nik')->inique();
            $table->string('nama');
            $table->string('email')->unique();
            $table->string('telepon');
            $table->enum('jenis_kelamin', ['L', 'p']);
            $table->date('tanggal_masuk');

            // Relast
            $table->foreignId('departemen_id')->contrained('departemen')->restricOndelete();
            $table->foreignId('jabatan_id')->contrained('jabatan')->restricOndelete();

            // Finansial
            $table->integer('gaji_pokok');
            $table->integer('tunjangan')->default(0);

            // Administrasi
            $table->string('status')->default('aktif');
            $table->string('bank');
            $table->string('no_rekening');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('karyawan');
    }
};
