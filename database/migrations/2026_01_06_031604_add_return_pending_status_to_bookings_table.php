<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Ubah enum status untuk menambahkan 'return_pending'
        DB::statement("
            ALTER TABLE bookings
            MODIFY COLUMN status ENUM(
                'pending',
                'confirmed',
                'return_pending',
                'completed',
                'cancelled'
            ) DEFAULT 'pending'
        ");
    }

    public function down(): void
    {
        // Kembalikan ke enum sebelumnya (hapus return_pending)
        DB::statement("
            ALTER TABLE bookings
            MODIFY COLUMN status ENUM(
                'pending',
                'confirmed',
                'ongoing',
                'completed',
                'cancelled'
            ) DEFAULT 'pending'
        ");
    }
};
