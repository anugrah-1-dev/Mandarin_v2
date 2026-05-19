<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('logos', 'name')) {
            DB::statement('ALTER TABLE logos MODIFY name VARCHAR(255) NULL DEFAULT NULL');
        }
    }

    public function down(): void
    {
        //
    }
};
