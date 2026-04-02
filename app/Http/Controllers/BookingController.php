<?php
namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Kendaraan;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with('user', 'kendaraan')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('bookings.index', compact('bookings'));
    }

    public function history()
    {
        $bookings = Booking::with([
            'kendaraan.images',
            'kendaraan.detail',
            'payment',
            'user',
            'pengembalian',
        ])
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('bookings.history', compact('bookings'));
    }

    public function create(Kendaraan $kendaraan)
    {
        $kendaraan->load([
            'detail',
            'images',
        ]);

        if ($kendaraan->status != 'available') {
            return redirect()->route('welcome')
                ->with('error', 'Kendaraan tidak tersedia untuk disewa.');
        }

        return view('bookings.create', compact('kendaraan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kendaraan_id'    => 'required|exists:kendaraans,id',
            'start_date'      => 'required|date|after_or_equal:today',
            'end_date'        => 'required|date|after:start_date',
            'pickup_location' => 'nullable|string|max:255',
            'notes'           => 'nullable|string|max:1000',
        ]);

        $startDate = Carbon::parse($request->start_date);
        $endDate   = Carbon::parse($request->end_date);
        $days      = $startDate->diffInDays($endDate) + 1;

        $kendaraan = Kendaraan::findOrFail($request->kendaraan_id);

        if ($kendaraan->status != 'available') {
            return back()
                ->with('error', 'Kendaraan tidak tersedia untuk tanggal yang dipilih.')
                ->withInput();
        }

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
            return back()
                ->with('error', 'Kendaraan sudah dibooking untuk tanggal tersebut.')
                ->withInput();
        }

        $booking = Booking::create([
            'user_id'         => auth()->id(),
            'kendaraan_id'    => $kendaraan->id,
            'start_date'      => $request->start_date,
            'end_date'        => $request->end_date,
            'total_days'      => $days,
            'total_price'     => $days * $kendaraan->price_per_day,
            'pickup_location' => $request->pickup_location,
            'notes'           => $request->notes,
            'status'          => 'pending',
        ]);

        return redirect()->route('payments.create', $booking->id)
            ->with('success', 'Booking berhasil dibuat. Silakan lakukan pembayaran.');
    }

    public function show(Booking $booking)
    {
        if ($booking->user_id != auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke booking ini.');
        }

        $booking->load([
            'kendaraan.images',
            'kendaraan.detail',
            'payment',
            'user',
            'pengembalian',
        ]);

        return view('bookings.show', compact('booking'));
    }

    public function updateStatus(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);

        $allowedStatuses = ['pending', 'confirmed', 'completed', 'cancelled'];

        $status = $request->input('status');

        if (! in_array($status, $allowedStatuses)) {
            return back()->with('error', 'Status tidak valid.');
        }

        $booking->update(['status' => $status]);

        if ($status == 'confirmed') {
            $booking->kendaraan->update(['status' => 'rented']);
        } elseif ($status == 'completed' || $status == 'cancelled') {
            $booking->kendaraan->update(['status' => 'available']);
        }

        return back()->with('success', 'Status booking berhasil diperbarui.');
    }

    public function cancel(Booking $booking)
    {
        if ($booking->user_id != auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke booking ini.');
        }

        if ($booking->payment && $booking->payment->payment_status === 'paid') {
            return back()->with('error', 'Tidak dapat membatalkan booking yang sudah dibayar. Silakan hubungi customer service untuk pengembalian dana.');
        }

        if ($booking->status === 'completed') {
            return back()->with('error', 'Tidak dapat membatalkan booking yang sudah selesai.');
        }

        if ($booking->status === 'cancelled') {
            return back()->with('info', 'Booking ini sudah dibatalkan sebelumnya.');
        }

        $booking->update(['status' => 'cancelled']);

        $booking->kendaraan->update(['status' => 'available']);

        return redirect()->route('bookings.history')
            ->with('success', 'Booking berhasil dibatalkan. Kendaraan telah tersedia kembali.');
    }

    // Di dalam BookingController, tambahkan method ini:

    public function adminIndex(Request $request)
    {
        $query = Booking::with([
            'user',
            'kendaraan.images',
            'kendaraan.detail',
            'payment',
            'pengembalian',
        ]);

        // Filter by status if provided
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $bookings = $query->latest()->paginate(15);

        return view('admin.bookings.index', compact('bookings'));
    }

    public function adminShow(Booking $booking)
    {
        $booking->load([
            'user',
            'kendaraan.images',
            'kendaraan.detail',
            'payment',
            'pengembalian',
        ]);

        return view('admin.bookings.show', compact('booking'));
    }
}
