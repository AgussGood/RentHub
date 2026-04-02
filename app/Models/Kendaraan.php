<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kendaraan extends Model
{
    use HasFactory;

    protected $table = 'kendaraans';

    protected $fillable = [
        'type',
        'brand',
        'model',
        'year',
        'plate_number',
        'price_per_day',
        'color',
        'status',
    ];

    protected $casts = [
        'price_per_day' => 'decimal:2',
        'year'          => 'integer',
    ];

    // Relasi ke KendaraanDetail
    public function detail()
    {
        return $this->hasOne(KendaraanDetail::class);
    }

    // Relasi ke KendaraanImage
    public function images()
    {
        return $this->hasMany(GambarKendaraan::class)->orderBy('is_primary', 'desc');
    }

    // Relasi ke Booking
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    // Relasi ke Review
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function averageRating()
    {
        return $this->reviews()
            ->where('status', 'published')
            ->avg('rating');
    }

    public function totalReviews()
    {
        return $this->reviews()
            ->where('status', 'published')
            ->count();
    }

    // Accessor untuk mendapatkan gambar utama
    public function getPrimaryImageAttribute()
    {
        return $this->images()->where('is_primary', true)->first();
    }

    // Accessor untuk mendapatkan URL gambar utama
    public function getPrimaryImageUrlAttribute()
    {
        $primaryImage = $this->primaryImage;
        return $primaryImage ? asset('storage/' . $primaryImage->image_path) : asset('images/no-image.png');
    }
}
