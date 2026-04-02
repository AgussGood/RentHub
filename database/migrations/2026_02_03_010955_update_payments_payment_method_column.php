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
        // Install doctrine/dbal jika belum
        Schema::table('payments', function (Blueprint $table) {
            // Ubah dari ENUM ke VARCHAR untuk support 'midtrans'
            $table->string('payment_method', 50)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            // Kembalikan ke ENUM jika rollback
            $table->enum('payment_method', ['cash', 'transfer', 'e_wallet'])->change();
        });
    }
};