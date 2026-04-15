<?php
namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\PenaltyPayment;
use App\Models\ReturnKendaraan;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;

class ReturnController extends Controller
{
    public function index()
    {
        $returns = ReturnKendaraan::with(['booking.kendaraan.images', 'booking.user'])
            ->whereHas('booking', fn($q) => $q->where('user_id', auth()->id()))
            ->latest()
            ->get();

        return response()->json(['data' => $returns]);
    }
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

    public function apiStore(Request $request)
    {
        $request->validate([
            'booking_id'            => 'required|exists:bookings,id',
            'return_scheduled_date' => 'required|date',
            'return_scheduled_time' => 'required|date_format:H:i',
            'customer_notes'        => 'nullable|string|max:1000',
        ]);

        $booking = Booking::with('kendaraan')->findOrFail($request->booking_id);

        if ($booking->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized.'], 403);
        }

        if ($booking->status !== 'confirmed') {
            return response()->json([
                'message' => 'Hanya booking yang dikonfirmasi yang bisa dijadwalkan pengembalian.',
            ], 422);
        }

        if ($booking->return) {
            return response()->json([
                'message' => 'Jadwal pengembalian sudah dibuat sebelumnya.',
            ], 422);
        }

        $return = ReturnKendaraan::create([
            'booking_id'            => $booking->id,
            'return_scheduled_date' => $request->return_scheduled_date,
            'return_scheduled_time' => $request->return_scheduled_time,
            'customer_notes'        => $request->customer_notes,
            'status'                => 'return_pending',
        ]);

        $booking->update(['status' => 'return_pending']);

        return response()->json([
            'message' => 'Jadwal pengembalian berhasil dibuat.',
            'data'    => $return->load(['booking.kendaraan.images', 'booking.user']),
        ], 201);
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
        ], [
            'condition.required'          => 'Kondisi kendaraan wajib dipilih.',
            'condition.in'                => 'Kondisi kendaraan tidak valid.',

            'damage_fee.required'         => 'Biaya perbaikan wajib diisi.',
            'damage_fee.numeric'          => 'Biaya perbaikan harus berupa angka.',
            'damage_fee.min'              => 'Biaya perbaikan tidak boleh kurang dari 0.',

            'damage_photos.*.image'       => 'File harus berupa gambar (JPG/PNG).',
            'damage_photos.*.max'         => 'Ukuran gambar maksimal 2MB.',

            'return_actual_date.required' => 'Tanggal pengembalian wajib diisi.',
            'return_actual_date.date'     => 'Format tanggal tidak valid.',

            'damage_description.string'   => 'Deskripsi kerusakan harus berupa teks.',
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

    /**
     * API: Bayar denda dari Flutter
     */
    public function payPenalty(Request $request, $id)
    {
        $request->validate([
            'method'        => 'required|string',
            'total_penalty' => 'nullable|numeric|min:0',
        ]);

        $return = ReturnKendaraan::with(['booking.kendaraan', 'booking.user'])
            ->findOrFail($id);

        // Pastikan user yang login adalah pemilik booking
        if ($return->booking->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized.'], 403);
        }

        if ($return->penalty_paid) {
            return response()->json([
                'message' => 'Denda sudah dibayar.',
                'data'    => $return,
            ], 200);
        }

        if ($return->total_penalty <= 0) {
            return response()->json(['message' => 'Tidak ada denda yang perlu dibayar.'], 400);
        }

        $method = $request->input('method') ?? $request->input('payment_method');

        // ✅ Map nilai dari Flutter ke nilai ENUM yang ada di database
        $methodMap = [
            'tunai'         => 'cash',
            'transfer_bank' => 'transfer',
            'e_wallet'      => 'e_wallet',
            'midtrans'      => 'midtrans',
            // Nilai yang sudah sesuai (fallback)
            'cash'          => 'cash',
            'transfer'      => 'transfer',
        ];
        $mappedMethod = $methodMap[$method] ?? 'cash';

        // Handle Midtrans
        if ($mappedMethod === 'midtrans') {
            try {
                Config::$serverKey    = trim((string) config('midtrans.server_key'));
                Config::$clientKey    = trim((string) config('midtrans.client_key'));
                Config::$isProduction = config('midtrans.is_production');
                Config::$isSanitized  = config('midtrans.is_sanitized', true);
                Config::$is3ds        = config('midtrans.is_3ds', true);

                $total   = (int) $return->total_penalty;
                $orderId = 'PENALTY-' . str_pad($return->id, 6, '0', STR_PAD_LEFT) . '-' . time();

                $params = [
                    'transaction_details' => [
                        'order_id'     => $orderId,
                        'gross_amount' => $total,
                    ],
                    'item_details'        => [],
                    'customer_details'    => [
                        'first_name' => $return->booking->user->name,
                        'email'      => $return->booking->user->email,
                        'phone'      => $return->booking->user->phone ?? '',
                    ],
                ];

                if ($return->late_fee > 0) {
                    $params['item_details'][] = [
                        'id'       => 'late_fee_' . $return->id,
                        'price'    => (int) $return->late_fee,
                        'quantity' => 1,
                        'name'     => 'Denda Keterlambatan ' . $return->late_days . ' hari',
                    ];
                }

                if ($return->damage_fee > 0) {
                    $params['item_details'][] = [
                        'id'       => 'damage_fee_' . $return->id,
                        'price'    => (int) $return->damage_fee,
                        'quantity' => 1,
                        'name'     => 'Biaya Perbaikan Kerusakan',
                    ];
                }

                $snapToken = Snap::getSnapToken($params);
                $snapUrl   = 'https://app' . (config('midtrans.is_production') ? '' : '.sandbox') . '.midtrans.com/snap/v2/vtweb/' . $snapToken;

                // Simpan record pending
                PenaltyPayment::updateOrCreate(
                    ['return_id' => $return->id],
                    [
                        'payment_method'    => 'midtrans',
                        'amount'            => $total,
                        'payment_date'      => now(),
                        'payment_status'    => 'pending',
                        'midtrans_order_id' => $orderId,
                    ]
                );

                return response()->json([
                    'message'    => 'Silakan selesaikan pembayaran melalui Midtrans.',
                    'snap_url'   => $snapUrl,
                    'snap_token' => $snapToken,
                    'data'       => $return->fresh(),
                ], 200);

            } catch (\Exception $e) {
                \Log::error('Midtrans Penalty API Error: ' . $e->getMessage());
                return response()->json([
                    'message' => 'Gagal menghubungkan ke Midtrans: ' . $e->getMessage(),
                ], 500);
            }
        }

        // Handle metode non-Midtrans (cash, transfer, e_wallet)
        PenaltyPayment::updateOrCreate(
            ['return_id' => $return->id],
            [
                'payment_method' => $mappedMethod, // ✅ pakai nilai yang sudah di-map
                'amount'         => $return->total_penalty,
                'payment_date'   => now(),
                'payment_status' => 'paid',
            ]
        );

        $return->update(['penalty_paid' => true]);
        $return->booking->update(['status' => 'completed']);
        $return->booking->kendaraan->update(['status' => 'available']);

        return response()->json([
            'message' => 'Pembayaran denda berhasil dikonfirmasi. Status booking telah diubah menjadi selesai.',
            'data'    => $return->fresh(['booking.kendaraan', 'booking.user']),
        ], 200);
    }

    /**
     * API: Detail return untuk Flutter
     */
    public function apiShow($id)
    {
        $return = ReturnKendaraan::with([
            'booking.kendaraan.images',
            'booking.user',
            'booking.penalties',
        ])->findOrFail($id);

        if ($return->booking->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized.'], 403);
        }

        return response()->json([
            'message' => 'success',
            'data'    => $return,
        ]);
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
