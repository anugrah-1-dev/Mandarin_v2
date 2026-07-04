<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('program_online', function (Blueprint $table) {
            $table->unsignedBigInteger('biaya_admin')->default(0)->after('harga');
        });

        Schema::table('program_offline', function (Blueprint $table) {
            $table->unsignedBigInteger('biaya_admin')->default(0)->after('harga');
        });

        Schema::table('program_camp', function (Blueprint $table) {
            $table->unsignedBigInteger('biaya_admin')->default(0)->after('harga_satu_tahun');
        });
    }

    public function down(): void
    {
        Schema::table('program_online', function (Blueprint $table) {
            $table->dropColumn('biaya_admin');
        });

        Schema::table('program_offline', function (Blueprint $table) {
            $table->dropColumn('biaya_admin');
        });

        Schema::table('program_camp', function (Blueprint $table) {
            $table->dropColumn('biaya_admin');
        });
    }
};
