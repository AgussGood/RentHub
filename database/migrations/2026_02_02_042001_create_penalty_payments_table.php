<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penalty_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('return_id')->constrained('return_kendaraans')->onDelete('cascade');
            $table->enum('payment_method', ['cash', 'transfer', 'e_wallet', 'midtrans']);
            $table->decimal('amount', 15, 2);
            $table->datetime('payment_date');
            $table->enum('payment_status', ['pending', 'paid', 'failed'])->default('pending');
            $table->string('payment_proof')->nullable();
            $table->string('midtrans_order_id')->nullable();
            $table->string('midtrans_transaction_id')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penalty_payments');
    }
};
