<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Kendaraan;
use App\Models\Review;

class FrontController extends Controller
{
    public function index()
    {
        $kendaraans = Kendaraan::with(['images' => function ($query) {
            $query->where('is_primary', 1);
        }, 'detail'])
            ->where('status', 'available')
            ->distinct()
            ->latest()
            ->get();

        $reviews = Review::with(['user', 'kendaraan.images'])
            ->where('status', 'published')
            ->latest()
            ->take(6) 
            ->paginate(6);


        return view('welcome', compact('kendaraans', 'reviews'));
    }

    public function cars()
    {
        $kendaraans = Kendaraan::with(['images' => function ($query) {
            $query->where('is_primary', 1);
        }, 'detail'])
            ->where('status', 'available')
            ->latest()
            ->paginate(12); 

        return view('cars', compact('kendaraans'));
    }

    public function show(Kendaraan $kendaraan)
    {
        // Load semua relasi yang dibutuhkan
        $kendaraan->load(['detail', 'images', 'reviews.user']);

        // Ambil kendaraan terkait (same type atau same brand)
        $relatedCars = Kendaraan::with(['images' => function ($query) {
            $query->where('is_primary', 1);
        }])
            ->where('id', '!=', $kendaraan->id)
            ->where(function ($query) use ($kendaraan) {
                $query->where('type', $kendaraan->type)
                    ->orWhere('brand', $kendaraan->brand);
            })
            ->where('status', 'available')
            ->limit(3)
            ->get();

        $averageRating = $kendaraan->reviews->avg('rating') ?? 0;
        $totalReviews  = $kendaraan->reviews->count();

        return view('kendaraandetail', compact('kendaraan', 'relatedCars', 'averageRating', 'totalReviews'));
    }
}
