<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('laundry_packages', function (Blueprint $table) {
            $table->id();
            $table->string('nama_paket'); // contoh: "Paket 1", "Paket 2"
            $table->integer('harga');
            $table->string('jenis')->nullable(); // tambahan misal: kiloan, satuan, express
            $table->integer('periode')->nullable(); // contoh: minggu
            // $table->date('tanggal_penjemputan')->nullable();
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->text('deskripsi')->nullable();
            $table->string('thumbnail')->nullable(); // ✅ untuk simpan path gambar
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laundry_packages');
    }
};
