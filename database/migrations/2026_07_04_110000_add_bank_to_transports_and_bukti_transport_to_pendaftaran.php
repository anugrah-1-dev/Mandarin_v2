<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tambah info rekening bank ke tabel transports
        Schema::table('transports', function (Blueprint $table) {
            $table->string('bank_name')->nullable()->after('price');
            $table->string('bank_number')->nullable()->after('bank_name');
            $table->string('bank_owner')->nullable()->after('bank_number');
        });

        // Tambah bukti transfer transport ke tabel pendaftaran_program_offline
        Schema::table('pendaftaran_program_offline', function (Blueprint $table) {
            $table->string('bukti_pembayaran_transport')->nullable()->after('bukti_pembayaran');
        });
    }

    public function down(): void
    {
        Schema::table('transports', function (Blueprint $table) {
            $table->dropColumn(['bank_name', 'bank_number', 'bank_owner']);
        });

        Schema::table('pendaftaran_program_offline', function (Blueprint $table) {
            $table->dropColumn('bukti_pembayaran_transport');
        });
    }
};
