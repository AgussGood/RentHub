<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('kendaraan_id')->constrained()->cascadeOnDelete();
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('total_days');
            $table->decimal('total_price', 10, 2);

            // Kolom tambahan (sudah ada dari awal)
            $table->string('pickup_location')->nullable();
            $table->text('notes')->nullable();

            // Status dengan return_pending
            $table->enum('status', [
                'pending',
                'confirmed',
                'return_pending',
                'completed',
                'cancelled',
            ])->default('pending');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
