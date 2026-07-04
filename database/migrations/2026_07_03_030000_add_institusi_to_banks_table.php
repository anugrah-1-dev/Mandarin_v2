<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Menambah kolom 'institusi' untuk membedakan bank
     * antara Brilliant English Course (brilliant) dan
     * Brilliant International Education (bieplus).
     * Nilai 'semua' berarti bank tampil untuk semua institusi.
     */
    public function up(): void
    {
        if (!Schema::hasColumn('banks', 'institusi')) {
            Schema::table('banks', function (Blueprint $table) {
                $table->enum('institusi', ['semua', 'brilliant', 'bieplus'])
                      ->default('semua')
                      ->after('status')
                      ->comment('Filter bank berdasarkan institusi: semua, brilliant (BEC), bieplus (BIE)');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('banks', function (Blueprint $table) {
            $table->dropColumn('institusi');
        });
    }
};
