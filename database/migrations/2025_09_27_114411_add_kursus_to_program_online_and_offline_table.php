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
        Schema::table('program_online', function (Blueprint $table) {
            $table->enum('kursus', ['brilliant', 'bieplus'])
                ->default('brilliant')
                ->after('program_bahasa');
        });

        Schema::table('program_offline', function (Blueprint $table) {
            $table->enum('kursus', ['brilliant', 'bieplus'])
                ->default('brilliant')
                ->after('program_bahasa');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('program_online', function (Blueprint $table) {
            $table->dropColumn('kursus');
        });

        Schema::table('program_offline', function (Blueprint $table) {
            $table->dropColumn('kursus');
        });
    }
};
