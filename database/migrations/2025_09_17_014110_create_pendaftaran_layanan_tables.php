<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        /**
         * Tabel Pendaftaran Catering
         */
        Schema::create('pendaftaran_catering', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pendaftaran_id')
                ->constrained('pendaftaran_program_offline')
                ->onDelete('cascade');
            $table->foreignId('catering_package_id')
                ->constrained('catering_packages')
                ->onDelete('cascade');
            $table->integer('jumlah_porsi')->default(1);
            $table->text('catatan')->nullable();
            $table->timestamps();
        });

        /**
         * Tabel Pendaftaran Laundry
         */
        Schema::create('pendaftaran_laundry', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pendaftaran_id')
                ->constrained('pendaftaran_program_offline')
                ->onDelete('cascade');
            $table->foreignId('laundry_package_id')
                ->constrained('laundry_packages')
                ->onDelete('cascade');
            $table->integer('jumlah')->default(1);
            $table->text('catatan')->nullable();
            $table->timestamps();
        });

        /**
         * Tabel Pendaftaran Holiday
         */
        Schema::create('pendaftaran_holiday', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pendaftaran_id')
                ->constrained('pendaftaran_program_offline')
                ->onDelete('cascade');
            $table->foreignId('holiday_package_id')
                ->constrained('holiday_packages')
                ->onDelete('cascade');
            $table->integer('jumlah_peserta')->default(1);
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pendaftaran_catering');
        Schema::dropIfExists('pendaftaran_laundry');
        Schema::dropIfExists('pendaftaran_holiday');
    }
};
