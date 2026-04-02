<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnKendaraan extends Model
{
    use HasFactory;

    protected $table = 'return_kendaraans'; // ✅ Pastikan nama tabel benar

    protected $fillable = [
        'booking_id',
        'return_scheduled_date',
        'return_scheduled_time',
        'customer_notes',
        'return_actual_date',
        'return_actual_time',
        'return_date',
        'condition',
        'late_days',
        'late_fee',
        'damage_fee',
        'total_penalty',
        'damage_description',
        'admin_notes',
        'damage_photos',
        'status',
        'inspected_by',
        'inspected_at',
        'penalty_paid', 
    ];

    protected $casts = [
        'return_scheduled_date' => 'date',
        'return_actual_date'    => 'date',
        'return_date'           => 'date',
        'late_fee'              => 'decimal:2',
        'damage_fee'            => 'decimal:2',
        'total_penalty'         => 'decimal:2',
        'damage_photos'         => 'array',
        'inspected_at'          => 'datetime',
        'penalty_paid'          => 'boolean',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function inspector()
    {
        return $this->belongsTo(User::class, 'inspected_by');
    }

    public function inspected_by_user()
    {
        return $this->belongsTo(User::class, 'inspected_by');
    }

    public function penaltyPayment()
    {
        return $this->hasOne(PenaltyPayment::class, 'return_id');
    }

    public function calculateLateFee()
    {
        if ($this->late_days > 0 && $this->booking && $this->booking->kendaraan) {
            return $this->booking->kendaraan->price_per_day * $this->late_days * 0.20;
        }
        return 0;
    }

    public function isLate()
    {
        return $this->late_days > 0;
    }

    public function isDamaged()
    {
        return in_array($this->condition, ['fair', 'poor']) && $this->damage_fee > 0;
    }

    public function hasPenalty()
    {
        return $this->total_penalty > 0;
    }
}
