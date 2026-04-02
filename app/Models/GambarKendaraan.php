<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GambarKendaraan extends Model
{
    use HasFactory;

    protected $fillable = ['kendaraan_id', 'image_path', 'is_primary'];

    public function kendaraan()
    {
        return $this->belongsTo(Kendaraan::class);
    }
}

