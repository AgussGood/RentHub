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
        Schema::create('return_kendaraans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained()->cascadeOnDelete();
            $table->date('return_date');
            $table->enum('condition', ['excellent', 'good', 'fair', 'damaged'])->default('good');
            $table->integer('late_days')->default(0);
            $table->decimal('late_fee', 10, 2)->default(0);
            $table->decimal('damage_fee', 10, 2)->default(0);
            $table->decimal('total_penalty', 10, 2)->default(0);
            $table->text('damage_description')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('return_kendaraans');
    }
};
