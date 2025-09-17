<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('holiday_packages', function (Blueprint $table) {
            $table->id();
            $table->string('nama_paket');
            $table->text('deskripsi')->nullable();
            $table->json('fasilitas')->nullable(); // list fasilitas fleksibel
            $table->integer('harga');
            $table->integer('harga_promo')->nullable();
            $table->integer('minimal_orang')->nullable();
            $table->integer('durasi_hari')->nullable();
            $table->string('gambar_cover')->nullable();
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('holiday_packages');
    }
};
