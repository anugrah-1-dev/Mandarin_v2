<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Menambahkan kolom DP ke tabel pendaftaran_program_offline:
     * - tipe_bayar_dp : enum 'dp'|'lunas' — pilihan user saat mendaftar
     * - jumlah_dp     : nominal DP yang dibayar (sama dengan dp_nominal program jika pilih DP)
     * - sisa_tagihan  : sisa yang harus dilunasi (subtotal - jumlah_dp)
     */
    public function up(): void
    {
        Schema::table('pendaftaran_program_offline', function (Blueprint $table) {
            $table->enum('tipe_bayar_dp', ['dp', 'lunas'])->default('lunas')->after('subtotal')
                ->comment('Pilihan user: bayar DP atau langsung lunas');
            $table->unsignedBigInteger('jumlah_dp')->nullable()->default(null)->after('tipe_bayar_dp')
                ->comment('Nominal DP yang dibayar. Null jika lunas penuh.');
            $table->unsignedBigInteger('sisa_tagihan')->nullable()->default(null)->after('jumlah_dp')
                ->comment('Sisa tagihan yang harus dilunasi. Null jika sudah lunas.');
        });
    }

    public function down(): void
    {
        Schema::table('pendaftaran_program_offline', function (Blueprint $table) {
            $table->dropColumn(['tipe_bayar_dp', 'jumlah_dp', 'sisa_tagihan']);
        });
    }
};
