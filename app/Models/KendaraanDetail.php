<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KendaraanDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'kendaraan_id', 'engine_capacity', 'fuel_type',
        'transmission', 'seat_count',
    ];

    public function kendaraan()
    {
        return $this->belongsTo(Kendaraan::class);
    }
}

