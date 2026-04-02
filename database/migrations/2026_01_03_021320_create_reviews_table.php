<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('booking_id')->constrained()->onDelete('cascade');
            $table->foreignId('kendaraan_id')->constrained()->onDelete('cascade');
            $table->tinyInteger('rating')->comment('1-5 stars');
            $table->text('comment');
            $table->enum('status', ['pending', 'published', 'rejected'])->default('pending');
            $table->text('admin_response')->nullable();
            $table->timestamp('responded_at')->nullable();
            $table->foreignId('responded_by')->nullable()->constrained('users');
            $table->timestamps();

            // Indexes
            $table->index('kendaraan_id');
            $table->index('status');
            $table->index('rating');
        });
    }

    public function down()
    {
        Schema::dropIfExists('reviews');
    }
};
