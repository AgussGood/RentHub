<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'booking_id',
        'kendaraan_id',
        'rating',
        'comment',
        'status',
        'admin_response',
        'responded_at',
        'responded_by',
    ];

    protected $casts = [
        'rating'       => 'integer',
        'responded_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function kendaraan()
    {
        return $this->belongsTo(Kendaraan::class);
    }

    public function respondedBy()
    {
        return $this->belongsTo(User::class, 'responded_by');
    }

    // Scope untuk filter
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    // Helper untuk rating average
    public static function averageRatingForKendaraan($kendaraanId)
    {
        return self::where('kendaraan_id', $kendaraanId)
            ->where('status', 'published')
            ->avg('rating');
    }
}
