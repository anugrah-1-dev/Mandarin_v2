<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; // <-- Tambahkan ini

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Menggunakan perintah SQL mentah untuk mengubah tipe kolom ke MEDIUMBLOB
        DB::statement("ALTER TABLE pendaftaran_program_offline MODIFY COLUMN bukti_pembayaran MEDIUMBLOB NULL");
        DB::statement("ALTER TABLE pendaftaran_program_online MODIFY COLUMN bukti_pembayaran MEDIUMBLOB NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Mengembalikan ke string jika di-rollback
        Schema::table('pendaftaran_program_offline', function (Blueprint $table) {
            $table->string('bukti_pembayaran')->nullable()->change();
        });
        Schema::table('pendaftaran_program_online', function (Blueprint $table) {
            $table->string('bukti_pembayaran')->nullable()->change();
        });
    }
};