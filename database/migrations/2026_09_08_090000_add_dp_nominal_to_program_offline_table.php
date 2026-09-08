<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Menambahkan kolom dp_nominal ke tabel program_offline.
     * dp_nominal adalah nominal DP yang ditetapkan admin per-program.
     * Jika null atau 0, berarti program tidak menyediakan opsi DP.
     */
    public function up(): void
    {
        Schema::table('program_offline', function (Blueprint $table) {
            $table->unsignedBigInteger('dp_nominal')->nullable()->default(null)->after('biaya_admin')
                ->comment('Nominal DP per-program yang ditentukan admin. Null = tidak ada opsi DP.');
        });
    }

    public function down(): void
    {
        Schema::table('program_offline', function (Blueprint $table) {
            $table->dropColumn('dp_nominal');
        });
    }
};
