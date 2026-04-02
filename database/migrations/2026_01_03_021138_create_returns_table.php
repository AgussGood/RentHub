<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('returns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained('bookings')->cascadeOnDelete();

            // Schedule fields
            $table->date('return_scheduled_date');
            $table->time('return_scheduled_time');
            $table->text('customer_notes')->nullable();

            // Actual return fields
            $table->date('return_actual_date')->nullable();
            $table->time('return_actual_time')->nullable();

            // Status
            $table->enum('status', ['return_pending', 'completed'])->default('return_pending');

            // Inspection fields
            $table->enum('condition', ['excellent', 'good', 'fair', 'poor'])->nullable();
            $table->text('damage_description')->nullable();
            $table->json('damage_photos')->nullable();
            $table->text('admin_notes')->nullable();

            // Penalty fields
            $table->integer('late_days')->default(0);
            $table->decimal('late_fee', 15, 2)->default(0);
            $table->decimal('damage_fee', 15, 2)->default(0);
            $table->decimal('total_penalty', 15, 2)->default(0);

            // Inspector
            $table->foreignId('inspected_by')->nullable()->constrained('users');
            $table->timestamp('inspected_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('returns');
    }
};
