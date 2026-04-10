<?php
namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function create($bookingId)
    {
        $booking = Booking::with(['kendaraan', 'review'])
            ->where('user_id', auth()->id())
            ->findOrFail($bookingId);

        if ($booking->review) {
            return redirect()->route('bookings.show', $booking->id)
                ->with('error', 'You have already reviewed this booking');
        }

        if ($booking->status !== 'completed') {
            return redirect()->route('bookings.history')
                ->with('error', 'You can only review completed bookings');
        }

        return view('reviews.create', compact('booking'));
    }

    public function apiIndex(Request $request)
    {
        $query = Review::with(['user:id,name', 'kendaraan:id,brand,model'])
            ->where('status', 'published');

        // Filter opsional berdasarkan rating minimum
        if ($request->filled('min_rating')) {
            $query->where('rating', '>=', $request->min_rating);
        }

        // Urutkan: rating tertinggi dulu, lalu terbaru
        $query->orderByDesc('rating')->orderByDesc('created_at');

        $limit   = min((int) ($request->limit ?? 10), 50);
        $reviews = $query->take($limit)->get();

        // Hitung rata-rata dari semua ulasan published
        $avgRating = Review::where('status', 'published')->avg('rating');

        return response()->json([
            'success'    => true,
            'data'       => $reviews,
            'avg_rating' => round((float) $avgRating, 1),
            'total'      => $reviews->count(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'rating'     => 'required|integer|min:1|max:5',
            'comment'    => 'required|string|min:10|max:1000',
        ]);

        $booking = Booking::where('id', $request->booking_id)
            ->where('user_id', auth()->id())
            ->where('status', 'completed')
            ->firstOrFail();

        if ($booking->review) {
            return back()->with('error', 'You have already reviewed this booking');
        }

        Review::create([
            'user_id'      => auth()->id(),
            'booking_id'   => $booking->id,
            'kendaraan_id' => $booking->kendaraan_id,
            'rating'       => $request->rating,
            'comment'      => $request->comment,
            'status'       => 'pending',
        ]);

        return redirect()->route('bookings.history')
            ->with('success', 'Thank you for your review! It will be published after admin approval.');
    }

    public function adminIndex(Request $request)
    {
        $query = Review::with(['user', 'kendaraan', 'booking']);

        // Filter by status
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Filter by rating
        if ($request->has('rating') && $request->rating !== 'all') {
            $query->where('rating', $request->rating);
        }

        // Search
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('comment', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('kendaraan', function ($q) use ($search) {
                        $q->where('brand', 'like', "%{$search}%")
                            ->orWhere('model', 'like', "%{$search}%");
                    });
            });
        }

        $reviews = $query->latest()->paginate(15);

        // Statistics
        $stats = [
            'total'          => Review::count(),
            'pending'        => Review::where('status', 'pending')->count(),
            'published'      => Review::where('status', 'published')->count(),
            'rejected'       => Review::where('status', 'rejected')->count(),
            'average_rating' => Review::where('status', 'published')->avg('rating'),
        ];

        return view('admin.reviews.index', compact('reviews', 'stats'));
    }

    /**
     * Admin: Show detail review
     */
    public function adminShow(Review $review)
    {
        $review->load(['user', 'kendaraan.images', 'booking', 'respondedBy']);
        return view('admin.reviews.show', compact('review'));
    }

    /**
     * Admin: Update status review
     */
    public function updateStatus(Request $request, Review $review)
    {
        $request->validate([
            'status'         => 'required|in:pending,published,rejected',
            'admin_response' => 'nullable|string|max:500',
        ]);

        $review->update([
            'status'         => $request->status,
            'admin_response' => $request->admin_response,
            'responded_at'   => now(),
            'responded_by'   => auth()->id(),
        ]);

        return redirect()->route('admin.reviews.index')
            ->with('success', 'Review status updated successfully');
    }

    /**
     * Admin: Delete review
     */
    public function destroy(Review $review)
    {
        $review->delete();

        return redirect()->route('admin.reviews.index')
            ->with('success', 'Review deleted successfully');
    }
}
