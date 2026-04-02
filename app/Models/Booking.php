<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'kendaraan_id', 'start_date', 'end_date',
        'total_days', 'total_price', 'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kendaraan()
    {
        return $this->belongsTo(Kendaraan::class);
    }

    public function payment()
    {
        return $this->hasOne(Payments::class);
    }

    public function pengembalian ()
    {
        return $this->hasOne(ReturnKendaraan::class);
    }

    public function penalties()
    {
        return $this->hasMany(Penalty::class);
    }
    
    public function review()
    {
        return $this->hasOne(Review::class);
    }
}
