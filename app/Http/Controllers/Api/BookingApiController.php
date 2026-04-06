<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Kendaraan;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BookingApiController extends Controller
{
    /**
     * Buat booking baru
     * POST /api/bookings
     */
    public function store(Request $request)
    {
        $request->validate([
            'kendaraan_id'    => 'required|exists:kendaraans,id',
            'start_date'      => 'required|date|after_or_equal:today',
            'end_date'        => 'required|date|after_or_equal:start_date',
            'pickup_location' => 'nullable|string|max:255',
            'notes'           => 'nullable|string|max:1000',
        ]);

        $kendaraan = Kendaraan::findOrFail($request->kendaraan_id);

        // Cek ketersediaan kendaraan
        if ($kendaraan->status !== 'available') {
            return response()->json([
                'success' => false,
                'message' => 'Kendaraan tidak tersedia untuk disewa.',
            ], 422);
        }

        $startDate = Carbon::parse($request->start_date);
        $endDate   = Carbon::parse($request->end_date);
        $days      = $startDate->diffInDays($endDate) + 1;

        // Cek konflik tanggal booking
        $hasConflict = Booking::where('kendaraan_id', $kendaraan->id)
            ->where('status', '!=', 'cancelled')
            ->where(function ($query) use ($startDate, $endDate) {
                $query->whereBetween('start_date', [$startDate, $endDate])
                    ->orWhereBetween('end_date', [$startDate, $endDate])
                    ->orWhere(function ($q) use ($startDate, $endDate) {
                        $q->where('start_date', '<=', $startDate)
                            ->where('end_date', '>=', $endDate);
                    });
            })
            ->exists();

        if ($hasConflict) {
            return response()->json([
                'success' => false,
                'message' => 'Kendaraan sudah dibooking untuk tanggal tersebut.',
            ], 422);
        }

        $booking = Booking::create([
            'user_id'         => auth()->id(),
            'kendaraan_id'    => $kendaraan->id,
            'start_date'      => $request->start_date,
            'end_date'        => $request->end_date,
            'total_days'      => $days,
            'total_price'     => $days * $kendaraan->price_per_day,
            'pickup_location' => $request->pickup_location ?? '',
            'notes'           => $request->notes ?? '',
            'status'          => 'pending',
        ]);

        return response()->json([
            'success'    => true,
            'message'    => 'Booking berhasil dibuat. Silakan lakukan pembayaran.',
            'booking_id' => $booking->id,
            'booking'    => $booking,
        ], 201);
    }

    /**
     * Riwayat booking user
     * GET /api/bookings/history
     */
    public function history()
    {
        $bookings = Booking::with(['kendaraan.images', 'payment'])
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data'    => $bookings,
        ]);
    }

    /**
     * Detail booking
     * GET /api/bookings/{id}
     */
    public function show($id)
    {
        $booking = Booking::with([
            'kendaraan.images',
            'kendaraan.detail',
            'payment',
            'user',
        ])->where('user_id', auth()->id())->findOrFail($id);

        return response()->json([
            'success' => true,
            'booking' => $booking,
        ]);
    }

    /**
     * Batalkan booking
     * POST /api/bookings/{id}/cancel
     */
    public function cancel($id)
    {
        $booking = Booking::where('user_id', auth()->id())->findOrFail($id);

        if ($booking->payment && $booking->payment->payment_status === 'paid') {
            return response()->json([
                'success' => false,
                'message' => 'Tidak dapat membatalkan booking yang sudah dibayar. Hubungi customer service.',
            ], 422);
        }

        if ($booking->status === 'completed') {
            return response()->json([
                'success' => false,
                'message' => 'Tidak dapat membatalkan booking yang sudah selesai.',
            ], 422);
        }

        if ($booking->status === 'cancelled') {
            return response()->json([
                'success' => false,
                'message' => 'Booking ini sudah dibatalkan sebelumnya.',
            ], 422);
        }

        $booking->update(['status' => 'cancelled']);
        $booking->kendaraan->update(['status' => 'available']);

        return response()->json([
            'success' => true,
            'message' => 'Booking berhasil dibatalkan.',
        ]);
    }
}
