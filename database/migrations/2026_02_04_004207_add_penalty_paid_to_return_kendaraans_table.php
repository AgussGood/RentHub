<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('return_kendaraans', function (Blueprint $table) {
            $table->boolean('penalty_paid')->default(false)->after('inspected_at');
        });
    }

    public function down(): void
    {
        Schema::table('return_kendaraans', function (Blueprint $table) {
            $table->dropColumn('penalty_paid');
        });
    }
};
