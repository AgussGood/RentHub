<?php
namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\ReturnKendaraan;
use Illuminate\Http\Request;

class ReturnController extends Controller
{
    /**
     * CUSTOMER: Schedule return form
     */
    public function create($bookingId)
    {
        $booking = Booking::with(['kendaraan.images', 'user'])
            ->findOrFail($bookingId);

        if ($booking->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke booking ini.');
        }

        if ($booking->status !== 'confirmed') {
            return redirect()->route('bookings.history')
                ->with('error', 'Hanya booking yang dikonfirmasi yang bisa dijadwalkan pengembalian.');
        }

        if ($booking->return) {
            return redirect()->route('bookings.show', $booking->id)
                ->with('info', 'Jadwal pengembalian sudah dibuat.');
        }

        return view('returns.create', compact('booking'));
    }

    /**
     * CUSTOMER: Submit schedule return
     */
    public function store(Request $request)
    {
        $request->validate([
            'booking_id'            => 'required|exists:bookings,id',
            'return_scheduled_date' => 'required|date',
            'return_scheduled_time' => 'required|date_format:H:i',
            'customer_notes'        => 'nullable|string|max:1000',
        ]);

        $booking = Booking::with('kendaraan')->findOrFail($request->booking_id);

        if ($booking->user_id !== auth()->id()) {
            return back()->with('error', 'Anda tidak memiliki akses ke booking ini.');
        }

        if ($booking->return) {
            return back()->with('error', 'Jadwal pengembalian sudah dibuat sebelumnya.');
        }

        $return = ReturnKendaraan::create([
            'booking_id'            => $booking->id,
            'return_scheduled_date' => $request->return_scheduled_date,
            'return_scheduled_time' => $request->return_scheduled_time,
            'customer_notes'        => $request->customer_notes,
            'status'                => 'return_pending',
        ]);

        $booking->update(['status' => 'return_pending']);

        return redirect()->route('returns.show', $return->id)
            ->with('success', 'Jadwal pengembalian berhasil dibuat. Mohon datang sesuai jadwal yang ditentukan.');
    }

    /**
     * ADMIN: Form untuk konfirmasi return & inspeksi
     */
    public function adminInspect($returnId)
    {
        $return = ReturnKendaraan::with([
            'booking.kendaraan.images',
            'booking.user',
        ])->findOrFail($returnId);

        if (! auth()->user()->hasRole('admin')) {
            abort(403, 'Hanya admin yang bisa melakukan inspeksi.');
        }

        if ($return->status === 'completed') {
            return redirect()->route('admin.returns.index')
                ->with('info', 'Return ini sudah di-complete.');
        }

        return view('admin.returns.inspect', compact('return'));
    }

    /**
     * ✅ ADMIN: Konfirmasi return setelah inspeksi - FIXED VERSION
     */
    public function adminComplete(Request $request, $returnId)
    {
        $request->validate([
            'condition'          => 'required|in:excellent,good,fair,poor',
            'damage_description' => 'nullable|string',
            'damage_photos.*'    => 'nullable|image|max:2048',
            'damage_fee'         => 'required|numeric|min:0',
            'admin_notes'        => 'nullable|string',
            'return_actual_date' => 'required|date',
        ]);

        $return = ReturnKendaraan::with('booking.kendaraan')->findOrFail($returnId);

        $damagePhotosPaths = [];
        if ($request->hasFile('damage_photos')) {
            foreach ($request->file('damage_photos') as $photo) {
                $damagePhotosPaths[] = $photo->store('damage_photos', 'public');
            }
        }

        $expectedDate = \Carbon\Carbon::parse($return->booking->end_date);
        $actualDate   = \Carbon\Carbon::parse($request->return_actual_date);

// Hitung keterlambatan
        if ($actualDate->gt($expectedDate)) {
            $lateDays = $expectedDate->diffInDays($actualDate);
        } else {
            $lateDays = 0;
        }

// Hitung denda keterlambatan (20% per hari dari harga sewa harian)
        $lateFee = 0;
        if ($lateDays > 0) {
            $lateFee = $return->booking->kendaraan->price_per_day * 0.2 * $lateDays;
        }

// Denda kerusakan
        $damageFee = $request->damage_fee ?? 0;

// Total
        $totalPenalty = $lateFee + $damageFee;

        $return->update([
            'status'             => 'completed',
            'condition'          => $request->condition,
            'return_actual_date' => $request->return_actual_date,
            'damage_description' => $request->damage_description,
            'damage_photos'      => $damagePhotosPaths ? json_encode($damagePhotosPaths) : null,
            'damage_fee'         => $request->damage_fee,
            'late_days'          => $lateDays,
            'late_fee'           => $lateFee,
            'total_penalty'      => $totalPenalty,
            'admin_notes'        => $request->admin_notes,
            'inspected_by'       => auth()->id(),
            'inspected_at'       => now(),
            'penalty_paid'       => $totalPenalty <= 0,
        ]);

        if ($totalPenalty <= 0) {

            $return->booking->update(['status' => 'completed']);
            $return->booking->kendaraan->update(['status' => 'available']);

            $message = 'Inspeksi selesai. Tidak ada denda. Status booking telah diubah menjadi selesai.';
        } else {

            $return->booking->update(['status' => 'confirmed']);

            $message = 'Inspeksi selesai. Menunggu pembayaran denda sebesar Rp ' . number_format($totalPenalty, 0, ',', '.');
        }

        return redirect()->route('admin.returns.show', $return->id)
            ->with('success', $message);
    }

    /**
     * SHOW: Customer & Admin bisa lihat detail return
     */
    public function show($returnId)
    {
        $return = ReturnKendaraan::with([
            'booking.kendaraan.images',
            'booking.user',
            'booking.penalties',
            'inspector',
        ])->findOrFail($returnId);

        if (! auth()->user()->hasRole('admin') && $return->booking->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        return view('returns.show', compact('return'));
    }

    /**
     * ADMIN: List semua return yang pending
     */
    public function adminIndex()
    {
        if (! auth()->user()->hasRole('admin')) {
            abort(403);
        }

        $returns = ReturnKendaraan::with([
            'booking.kendaraan.images',
            'booking.user',
        ])
            ->orderBy('created_at', 'desc')
            ->orderBy('return_scheduled_date', 'desc')
            ->paginate(15);

        return view('admin.returns.index', compact('returns'));
    }

    public function adminShow($returnId)
    {
        if (! auth()->user()->hasRole('admin')) {
            abort(403);
        }

        $return = ReturnKendaraan::with([
            'booking.kendaraan.images',
            'booking.user',
            'booking.penalties',
            'inspector',
        ])->findOrFail($returnId);

        return view('admin.returns.show', compact('return'));
    }
}
