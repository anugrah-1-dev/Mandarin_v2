<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('catering_packages', function (Blueprint $table) {
            $table->id();
            $table->string('nama_paket'); // contoh: "2x makan", "3x makan"
            $table->integer('harga');
            $table->integer('periode'); // 1 periode = 5 hari
            // $table->string('jam_pengantaran')->nullable();
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->text('deskripsi')->nullable();
            $table->string('thumbnail')->nullable(); // ✅ untuk simpan path gambar
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('catering_packages');
    }
};
