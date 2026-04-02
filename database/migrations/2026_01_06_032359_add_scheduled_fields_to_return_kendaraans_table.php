<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('return_kendaraans', function (Blueprint $table) {
            // Customer Schedule (tambahkan setelah booking_id)
            $table->date('return_scheduled_date')->nullable()->after('booking_id');
            $table->time('return_scheduled_time')->nullable()->after('return_scheduled_date');
            $table->text('customer_notes')->nullable()->after('return_scheduled_time');

            // Admin Complete (tambahkan sebelum return_date)
            $table->date('return_actual_date')->nullable()->after('customer_notes');
            $table->time('return_actual_time')->nullable()->after('return_actual_date');

            // Make return_date nullable (jika belum)
            $table->date('return_date')->nullable()->change();

            // Admin notes (tambahkan setelah damage_description)
            if (! Schema::hasColumn('return_kendaraans', 'admin_notes')) {
                $table->text('admin_notes')->nullable()->after('damage_description');
            }

            // Damage photos JSON (tambahkan setelah admin_notes)
            if (! Schema::hasColumn('return_kendaraans', 'damage_photos')) {
                $table->json('damage_photos')->nullable()->after('admin_notes');
            }

            // Status (tambahkan setelah damage_photos)
            if (! Schema::hasColumn('return_kendaraans', 'status')) {
                $table->enum('status', ['return_pending', 'completed'])
                    ->default('return_pending')
                    ->after('damage_photos');
            }

            // Inspector info (tambahkan di akhir)
            if (! Schema::hasColumn('return_kendaraans', 'inspected_by')) {
                $table->foreignId('inspected_by')->nullable()
                    ->constrained('users')
                    ->after('status');
            }

            if (! Schema::hasColumn('return_kendaraans', 'inspected_at')) {
                $table->timestamp('inspected_at')->nullable()->after('inspected_by');
            }
        });
    }

    public function down(): void
    {
        Schema::table('return_kendaraans', function (Blueprint $table) {
            $table->dropColumn([
                'return_scheduled_date',
                'return_scheduled_time',
                'customer_notes',
                'return_actual_date',
                'return_actual_time',
                'admin_notes',
                'damage_photos',
                'status',
                'inspected_by',
                'inspected_at',
            ]);
        });
    }
};
