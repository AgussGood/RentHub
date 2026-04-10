<?php
namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Payments;
use App\Models\PenaltyPayment;
use App\Models\ReturnKendaraan;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;

class PaymentController extends Controller
{
    /**
     * Konfigurasi Midtrans
     */
    protected function configureMidtrans(): void
    {
        \Midtrans\Config::$serverKey    = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = config('midtrans.is_production');
        \Midtrans\Config::$isSanitized  = true;
        \Midtrans\Config::$is3ds        = true;

        \Midtrans\Config::$curlOptions = [
            CURLOPT_SSLVERSION     => CURL_SSLVERSION_TLSv1_2,
            CURLOPT_SSL_VERIFYHOST => 2,
            CURLOPT_SSL_VERIFYPEER => true,
        ];

    }

    /**
     * Halaman pembayaran
     */
    public function create($bookingId)
    {
        try {
            $booking = Booking::with(['kendaraan.images', 'user'])
                ->findOrFail($bookingId);

            if ($booking->user_id !== auth()->id()) {
                abort(403);
            }

            if ($booking->payment) {
                return redirect()
                    ->route('bookings.show', $booking->id)
                    ->with('info', 'Booking ini sudah dibayar.');
            }

            if (! $booking->kendaraan) {
                return back()->with('error', 'Data kendaraan tidak ditemukan.');
            }

            return view('payments.create', compact('booking'));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Simpan pembayaran manual
     */
    /**
     * Simpan pembayaran manual
     */
    public function store(Request $request)
    {
        if (! $request->boolean('agree_terms')) {
            return back()->with('error_terms', 'Anda harus menyetujui syarat & ketentuan.');
        }

        $request->validate([
            'booking_id'     => 'required|exists:bookings,id',
            'payment_method' => 'required|in:cash,transfer,e_wallet',
            'amount'         => 'required|numeric|min:0',
            'payment_proof'  => 'nullable|image|max:2048',
        ]);

        $booking = Booking::with('kendaraan')->findOrFail($request->booking_id);

        if ($booking->user_id !== auth()->id()) {
            abort(403);
        }

        if ($booking->payment) {
            return redirect()->route('bookings.show', $booking->id)
                ->with('info', 'Booking ini sudah dibayar.');
        }

        $proofPath = null;
        if ($request->hasFile('payment_proof')) {
            $proofPath = $request->file('payment_proof')
                ->store('payment_proofs', 'public');
        }

        $payment = Payments::create([
            'booking_id'     => $booking->id,
            'payment_method' => $request->payment_method,
            'amount'         => $request->amount,
            'payment_date'   => now(),
            'payment_status' => 'paid', // ✅ Ubah dari 'pending' ke 'paid'
            'payment_proof'  => $proofPath,
        ]);

        $booking->update(['status' => 'confirmed']);
        $booking->kendaraan->update(['status' => 'rented']);

        // ✅ Redirect ke bookings.show instead of payments.show
        return redirect()->route('bookings.show', $booking->id)
            ->with('success', 'Pembayaran berhasil dikonfirmasi. Booking Anda sudah aktif.');
    }

    /**
     * Redirect ke Midtrans Snap
     */
    public function midtransRedirect(Request $request, $bookingId)
    {
        if (! $request->boolean('agree_terms')) {
            return back()->with('error_terms', 'Anda harus menyetujui syarat & ketentuan.');
        }

        try {
            $this->configureMidtrans();

            $booking = Booking::with(['kendaraan', 'user'])->findOrFail($bookingId);

            if ($booking->user_id !== auth()->id()) {
                abort(403);
            }

            if ($booking->payment) {
                return redirect()->route('bookings.show', $booking->id)
                    ->with('info', 'Booking ini sudah dibayar.');
            }

            $total   = (int) ($booking->kendaraan->price_per_day * $booking->total_days);
            $orderId = 'BOOKING-' . str_pad($booking->id, 6, '0', STR_PAD_LEFT) . '-' . time();

            $params = [
                'transaction_details' => [
                    'order_id'     => $orderId,
                    'gross_amount' => $total,
                ],
                'item_details'        => [
                    [
                        'id'       => $booking->kendaraan->id,
                        'price'    => (int) $booking->kendaraan->price_per_day,
                        'quantity' => (int) $booking->total_days,
                        'name'     => 'Sewa ' . $booking->kendaraan->brand . ' ' . $booking->kendaraan->model,
                    ],
                ],
                'customer_details'    => [
                    'first_name' => $booking->user->name,
                    'email'      => $booking->user->email,
                    'phone'      => $booking->user->phone ?? '',
                ],
            ];

            $snapToken = Snap::getSnapToken($params);

            // ✅ Simpan ke session
            session([
                'midtrans_snap_token' => $snapToken,
                'midtrans_order_id'   => $orderId,
                'midtrans_booking_id' => $booking->id,
            ]);

            // ✅ Log untuk debugging
            \Log::info('Midtrans Redirect - Session Saved:', [
                'booking_id' => $booking->id,
                'order_id'   => $orderId,
                'snap_token' => substr($snapToken, 0, 20) . '...',
            ]);

            return view('payments.midtrans', [
                'snapToken' => $snapToken,
                'booking'   => $booking,
                'orderId'   => $orderId, // ✅ Pass ke view
            ]);

        } catch (\Exception $e) {
            \Log::error('Midtrans Redirect Error: ' . $e->getMessage());
            return back()->with(
                'error',
                'Terjadi kesalahan saat menghubungkan ke Midtrans: ' . $e->getMessage()
            );
        }
    }

    /**
     * Webhook Midtrans
     */
    public function midtransNotification(Request $request)
    {
        try {
            $this->configureMidtrans();

            $notif = new \Midtrans\Notification();

            $orderId       = $notif->order_id;
            $transactionId = $notif->transaction_id;
            $transaction   = $notif->transaction_status;
            $fraudStatus   = $notif->fraud_status ?? 'accept';

            \Log::info('Midtrans Notification:', [
                'order_id'     => $orderId,
                'transaction'  => $transaction,
                'fraud_status' => $fraudStatus,
                'payment_type' => $notif->payment_type ?? null,
            ]);

            // Parse booking ID dari order_id
            $parts     = explode('-', $orderId);
            $bookingId = (int) ltrim($parts[1] ?? 0, '0');

            $booking = Booking::with('kendaraan')->findOrFail($bookingId);

            $paymentStatus = 'pending';

            // Logika status Midtrans
            if ($transaction == 'capture') {
                $paymentStatus = ($fraudStatus == 'accept') ? 'paid' : 'failed';
            } elseif ($transaction == 'settlement') {
                $paymentStatus = 'paid';
            } elseif ($transaction == 'pending') {
                $paymentStatus = 'pending';
            } elseif (in_array($transaction, ['deny', 'expire', 'cancel'])) {
                $paymentStatus = 'failed';
            }

            // Simpan/update payment
            $payment = Payments::updateOrCreate(
                ['booking_id' => $bookingId],
                [
                    'payment_method'          => 'midtrans',
                    'amount'                  => $booking->kendaraan->price_per_day * $booking->total_days,
                    'payment_date'            => now(),
                    'payment_status'          => $paymentStatus,
                    'midtrans_order_id'       => $orderId,
                    'midtrans_transaction_id' => $transactionId,
                ]
            );

            // Update status booking & kendaraan
            if ($paymentStatus === 'paid') {
                $booking->update(['status' => 'confirmed']);
                $booking->kendaraan->update(['status' => 'rented']);

                \Log::info("Booking #{$bookingId} confirmed via Midtrans");
            } elseif ($paymentStatus === 'failed') {
                $booking->update(['status' => 'cancelled']);
                \Log::info("Booking #{$bookingId} cancelled - payment failed");
            }

            return response()->json(['status' => 'ok']);

        } catch (\Exception $e) {
            \Log::error('Midtrans Notification Error: ' . $e->getMessage());

            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * ✅ PERBAIKAN UTAMA: Success Callback
     */
    /**
     * ✅ PERBAIKAN UTAMA: Success Callback
     */
    public function midtransSuccess($bookingId)
    {
        try {
            \Log::info('=== MIDTRANS SUCCESS CALLBACK START ===');
            \Log::info('Booking ID: ' . $bookingId);

            $this->configureMidtrans();

            $booking = Booking::with(['payment', 'kendaraan'])->findOrFail($bookingId);

            \Log::info('Booking loaded:', [
                'booking_id'  => $booking->id,
                'has_payment' => $booking->payment ? 'yes' : 'no',
            ]);

            // ✅ Ambil order_id dari session
            $orderId = session('midtrans_order_id');

            \Log::info('Session check:', [
                'order_id'     => $orderId,
                'session_keys' => array_keys(session()->all()),
            ]);

            if (! $orderId) {
                \Log::error('❌ No order_id in session!');

                // ✅ Coba cari dari database jika ada payment
                if ($booking->payment && $booking->payment->midtrans_order_id) {
                    $orderId = $booking->payment->midtrans_order_id;
                    \Log::info('Order ID retrieved from database: ' . $orderId);
                } else {
                    \Log::error('No payment record found in database');
                    return redirect()->route('bookings.show', $bookingId)
                        ->with('warning', 'Order ID tidak ditemukan. Silakan hubungi customer service.');
                }
            }

            try {
                \Log::info('Checking transaction status for: ' . $orderId);

                // ✅ Cek status ke Midtrans API
                $status = \Midtrans\Transaction::status($orderId);

                \Log::info('Midtrans API Response:', [
                    'order_id'           => $orderId,
                    'transaction_status' => $status->transaction_status,
                    'fraud_status'       => $status->fraud_status ?? 'accept',
                    'transaction_id'     => $status->transaction_id ?? null,
                    'payment_type'       => $status->payment_type ?? null,
                ]);

                $transactionStatus = $status->transaction_status;
                $fraudStatus       = $status->fraud_status ?? 'accept';
                $transactionId     = $status->transaction_id ?? null;

                // Tentukan payment status
                $paymentStatus = 'pending';

                if ($transactionStatus == 'capture') {
                    $paymentStatus = ($fraudStatus == 'accept') ? 'paid' : 'failed';
                } elseif ($transactionStatus == 'settlement') {
                    $paymentStatus = 'paid';
                } elseif ($transactionStatus == 'pending') {
                    $paymentStatus = 'pending';
                } elseif (in_array($transactionStatus, ['deny', 'expire', 'cancel'])) {
                    $paymentStatus = 'failed';
                }

                \Log::info('Determined Payment Status: ' . $paymentStatus);

                // ✅ Simpan/update payment record
                $payment = Payments::updateOrCreate(
                    ['booking_id' => $bookingId],
                    [
                        'payment_method'          => 'midtrans',
                        'amount'                  => $booking->kendaraan->price_per_day * $booking->total_days,
                        'payment_date'            => now(),
                        'payment_status'          => $paymentStatus,
                        'midtrans_order_id'       => $orderId,
                        'midtrans_transaction_id' => $transactionId,
                    ]
                );

                \Log::info('Payment Record Saved:', [
                    'payment_id'           => $payment->id,
                    'payment_status'       => $payment->payment_status,
                    'was_recently_created' => $payment->wasRecentlyCreated,
                ]);

                // ✅ Update booking & kendaraan status
                if ($paymentStatus === 'paid') {
                    $booking->update(['status' => 'confirmed']);
                    $booking->kendaraan->update(['status' => 'rented']);

                    \Log::info("✅ SUCCESS: Booking #{$bookingId} confirmed, status = paid");

                    // Clear session
                    session()->forget(['midtrans_snap_token', 'midtrans_order_id', 'midtrans_booking_id']);

                    \Log::info('=== MIDTRANS SUCCESS CALLBACK END (SUCCESS) ===');

                    // ✅ UBAH: Redirect ke bookings.show instead of payments.show
                    return redirect()->route('bookings.show', $booking->id)
                        ->with('success', 'Pembayaran berhasil! Booking Anda telah dikonfirmasi.');

                } elseif ($paymentStatus === 'pending') {
                    \Log::info('⏳ Payment still pending');
                    \Log::info('=== MIDTRANS SUCCESS CALLBACK END (PENDING) ===');

                    // ✅ UBAH: Redirect ke bookings.show untuk pending juga
                    return redirect()->route('bookings.show', $booking->id)
                        ->with('info', 'Pembayaran sedang diproses. Silakan tunggu konfirmasi.');

                } else {
                    \Log::warning('❌ Payment failed or cancelled');
                    \Log::info('=== MIDTRANS SUCCESS CALLBACK END (FAILED) ===');

                    return redirect()->route('payments.create', $bookingId)
                        ->with('error', 'Pembayaran gagal. Silakan coba lagi.');
                }

            } catch (\Midtrans\Exception\ApiException $e) {
                \Log::error('Midtrans API Error:', [
                    'message' => $e->getMessage(),
                    'code'    => $e->getCode(),
                ]);

                return redirect()->route('bookings.show', $bookingId)
                    ->with('warning', 'Tidak dapat memverifikasi pembayaran: ' . $e->getMessage());
            }

        } catch (\Exception $e) {
            \Log::error('Midtrans Success Callback Error:', [
                'message' => $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
            ]);

            return redirect()->route('bookings.show', $bookingId)
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function midtransError($bookingId)
    {
        return redirect()->route('payments.create', $bookingId)
            ->with('error', 'Pembayaran gagal. Silakan coba lagi.');
    }

    public function midtransPending($bookingId)
    {
        $booking = Booking::with('payment')->findOrFail($bookingId);

        if ($booking->payment) {
            return redirect()->route('payments.show', $booking->payment->id)
                ->with('info', 'Pembayaran masih dalam proses.');
        }

        return redirect()->route('bookings.show', $bookingId)
            ->with('info', 'Pembayaran masih pending.');
    }

    /**
     * ✅ Method untuk show payment detail
     */
    public function show($paymentId)
    {
        $payment = Payments::with(['booking.kendaraan.images', 'booking.user'])
            ->findOrFail($paymentId);

        // Cek kepemilikan
        if ($payment->booking->user_id !== auth()->id()) {
            abort(403);
        }

        return view('payments.show', compact('payment'));
    }

    // ... method penalty tetap sama ...

    public function createPenalty($returnId)
    {
        try {
            $return = ReturnKendaraan::with([
                'booking.kendaraan.images',
                'booking.user',
            ])->findOrFail($returnId);

            if ($return->booking->user_id !== auth()->id()) {
                abort(403);
            }

            if ($return->status !== 'completed') {
                return back()->with('error', 'Pengembalian belum selesai.');
            }

            if ($return->total_penalty <= 0) {
                return back()->with('info', 'Tidak ada denda yang perlu dibayar.');
            }

            if ($return->penalty_paid) {
                return back()->with('info', 'Denda sudah dibayar.');
            }

            return view('payments.penalty', compact('return'));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function storePenalty(Request $request)
    {
        if (! $request->boolean('agree_terms')) {
            return back()->with('error_terms', 'Anda harus menyetujui syarat & ketentuan.');
        }

        $request->validate([
            'return_id'      => 'required|exists:return_kendaraans,id',
            'payment_method' => 'required|in:cash,transfer,e_wallet',
            'payment_proof'  => 'nullable|image|max:2048',
        ]);

        $return = ReturnKendaraan::with('booking.kendaraan')->findOrFail($request->return_id);

        if ($return->booking->user_id !== auth()->id()) {
            abort(403);
        }

        if ($return->penalty_paid) {
            return redirect()->route('returns.show', $return->id)
                ->with('info', 'Denda sudah dibayar.');
        }

        $proofPath = null;
        if ($request->hasFile('payment_proof')) {
            $proofPath = $request->file('payment_proof')
                ->store('penalty_proofs', 'public');
        }

        PenaltyPayment::create([
            'return_id'      => $return->id,
            'payment_method' => $request->payment_method,
            'amount'         => $return->total_penalty,
            'payment_date'   => now(),
            'payment_status' => 'paid',
            'payment_proof'  => $proofPath,
        ]);

        $return->penalty_paid = true;
        $return->save();

        $return->refresh();

        $return->booking->update(['status' => 'completed']);

        $return->booking->kendaraan->update(['status' => 'available']);

        return redirect()->route('bookings.show', $return->booking_id)
            ->with('success', 'Pembayaran denda berhasil dikonfirmasi. Status booking telah diubah menjadi selesai.');
    }

    public function midtransPenaltyNotification(Request $request)
    {
        try {
            $this->configureMidtrans();

            $notif = new \Midtrans\Notification();

            $orderId       = $notif->order_id;
            $transactionId = $notif->transaction_id;
            $transaction   = $notif->transaction_status;
            $fraudStatus   = $notif->fraud_status ?? 'accept';

            \Log::info('Midtrans Penalty Notification:', [
                'order_id'     => $orderId,
                'transaction'  => $transaction,
                'fraud_status' => $fraudStatus,
            ]);

            $parts    = explode('-', $orderId);
            $returnId = (int) ltrim($parts[1] ?? 0, '0');

            $return = ReturnKendaraan::with('booking.kendaraan')->findOrFail($returnId);

            $paymentStatus = 'pending';

            if ($transaction == 'capture') {
                $paymentStatus = ($fraudStatus == 'accept') ? 'paid' : 'failed';
            } elseif ($transaction == 'settlement') {
                $paymentStatus = 'paid';
            } elseif ($transaction == 'pending') {
                $paymentStatus = 'pending';
            } elseif (in_array($transaction, ['deny', 'expire', 'cancel'])) {
                $paymentStatus = 'failed';
            }

            PenaltyPayment::updateOrCreate(
                ['return_id' => $returnId],
                [
                    'payment_method'          => 'midtrans',
                    'amount'                  => $return->total_penalty,
                    'payment_date'            => now(),
                    'payment_status'          => $paymentStatus,
                    'midtrans_order_id'       => $orderId,
                    'midtrans_transaction_id' => $transactionId,
                ]
            );

            if ($paymentStatus === 'paid') {
                $return->update(['penalty_paid' => true]);

                // ✅ Update status booking menjadi completed
                $return->booking->update(['status' => 'completed']);

                // ✅ Update status kendaraan menjadi available
                $return->booking->kendaraan->update(['status' => 'available']);

                \Log::info("Penalty for Return #{$returnId} paid via Midtrans - Booking completed");
            }

            return response()->json(['status' => 'ok']);

        } catch (\Exception $e) {
            \Log::error('Midtrans Penalty Notification Error: ' . $e->getMessage());

            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function midtransPenaltySuccess($returnId)
    {
        try {
            \Log::info('=== MIDTRANS PENALTY SUCCESS CALLBACK START ===');
            \Log::info('Return ID: ' . $returnId);

            $this->configureMidtrans();

            $return = ReturnKendaraan::with(['booking.kendaraan', 'penaltyPayment'])->findOrFail($returnId);

            \Log::info('Return loaded:', [
                'return_id'           => $return->id,
                'has_penalty_payment' => $return->penaltyPayment ? 'yes' : 'no',
            ]);

            // ✅ Coba ambil order_id dari payment record dulu
            $orderId = null;

            if ($return->penaltyPayment && $return->penaltyPayment->midtrans_order_id) {
                $orderId = $return->penaltyPayment->midtrans_order_id;
                \Log::info('Order ID retrieved from database: ' . $orderId);
            }

            if (! $orderId) {
                \Log::error('❌ No order_id found!');
                return redirect()->route('returns.show', $returnId)
                    ->with('warning', 'Order ID tidak ditemukan. Silakan hubungi customer service.');
            }

            try {
                \Log::info('Checking transaction status for: ' . $orderId);

                // ✅ Cek status ke Midtrans API
                $status = \Midtrans\Transaction::status($orderId);

                \Log::info('Midtrans API Response:', [
                    'order_id'           => $orderId,
                    'transaction_status' => $status->transaction_status,
                    'fraud_status'       => $status->fraud_status ?? 'accept',
                    'transaction_id'     => $status->transaction_id ?? null,
                ]);

                $transactionStatus = $status->transaction_status;
                $fraudStatus       = $status->fraud_status ?? 'accept';
                $transactionId     = $status->transaction_id ?? null;

                // Tentukan payment status
                $paymentStatus = 'pending';

                if ($transactionStatus == 'capture') {
                    $paymentStatus = ($fraudStatus == 'accept') ? 'paid' : 'failed';
                } elseif ($transactionStatus == 'settlement') {
                    $paymentStatus = 'paid';
                } elseif ($transactionStatus == 'pending') {
                    $paymentStatus = 'pending';
                } elseif (in_array($transactionStatus, ['deny', 'expire', 'cancel'])) {
                    $paymentStatus = 'failed';
                }

                \Log::info('Determined Payment Status: ' . $paymentStatus);

                // ✅ Simpan/update penalty payment record
                $penaltyPayment = PenaltyPayment::updateOrCreate(
                    ['return_id' => $returnId],
                    [
                        'payment_method'          => 'midtrans',
                        'amount'                  => $return->total_penalty,
                        'payment_date'            => now(),
                        'payment_status'          => $paymentStatus,
                        'midtrans_order_id'       => $orderId,
                        'midtrans_transaction_id' => $transactionId,
                    ]
                );

                \Log::info('Penalty Payment Record Saved:', [
                    'penalty_payment_id' => $penaltyPayment->id,
                    'payment_status'     => $penaltyPayment->payment_status,
                ]);

                // ✅ Update status jika pembayaran berhasil
                if ($paymentStatus === 'paid') {
                    $return->update(['penalty_paid' => true]);
                    $return->booking->update(['status' => 'completed']);
                    $return->booking->kendaraan->update(['status' => 'available']);

                    \Log::info("✅ SUCCESS: Penalty for Return #{$returnId} paid - Booking completed");
                    \Log::info('=== MIDTRANS PENALTY SUCCESS CALLBACK END (SUCCESS) ===');

                    return redirect()->route('returns.show', $returnId)
                        ->with('success', 'Pembayaran denda berhasil! Transaksi pengembalian telah selesai.');

                } elseif ($paymentStatus === 'pending') {
                    \Log::info('⏳ Penalty payment still pending');
                    \Log::info('=== MIDTRANS PENALTY SUCCESS CALLBACK END (PENDING) ===');

                    return redirect()->route('returns.show', $returnId)
                        ->with('info', 'Pembayaran denda sedang diproses. Silakan tunggu konfirmasi.');

                } else {
                    \Log::warning('❌ Penalty payment failed or cancelled');
                    \Log::info('=== MIDTRANS PENALTY SUCCESS CALLBACK END (FAILED) ===');

                    return redirect()->route('payments.penalty.create', $returnId)
                        ->with('error', 'Pembayaran denda gagal. Silakan coba lagi.');
                }

            } catch (\Midtrans\Exception\ApiException $e) {
                \Log::error('Midtrans API Error:', [
                    'message' => $e->getMessage(),
                    'code'    => $e->getCode(),
                ]);

                return redirect()->route('returns.show', $returnId)
                    ->with('warning', 'Tidak dapat memverifikasi pembayaran: ' . $e->getMessage());
            }

        } catch (\Exception $e) {
            \Log::error('Midtrans Penalty Success Callback Error:', [
                'message' => $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
            ]);

            return redirect()->route('returns.show', $returnId)
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function midtransPenaltyRedirect(Request $request, $returnId)
    {
        if (! $request->boolean('agree_terms')) {
            return back()->with('error_terms', 'Anda harus menyetujui syarat & ketentuan.');
        }

        try {
            $this->configureMidtrans();

            $return = ReturnKendaraan::with(['booking.kendaraan', 'booking.user'])
                ->findOrFail($returnId);

            if ($return->booking->user_id !== auth()->id()) {
                abort(403);
            }

            if ($return->penalty_paid) {
                return redirect()->route('returns.show', $return->id)
                    ->with('info', 'Denda sudah dibayar.');
            }

            $total = (int) $return->total_penalty;

            if ($total <= 0) {
                return back()->with('error', 'Tidak ada denda yang perlu dibayar.');
            }

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

            // ✅ Simpan order_id langsung ke database
            PenaltyPayment::updateOrCreate(
                ['return_id' => $returnId],
                [
                    'payment_method'    => 'midtrans',
                    'amount'            => $total,
                    'payment_date'      => now(),
                    'payment_status'    => 'pending',
                    'midtrans_order_id' => $orderId,
                ]
            );

            \Log::info('Midtrans Penalty Redirect - Order Created:', [
                'return_id' => $return->id,
                'order_id'  => $orderId,
            ]);

            return view('payments.midtrans-penalty', [
                'snapToken' => $snapToken,
                'return'    => $return,
            ]);

        } catch (\Exception $e) {
            \Log::error('Midtrans Penalty Redirect Error: ' . $e->getMessage());
            return back()->with(
                'error',
                'Terjadi kesalahan saat menghubungkan ke Midtrans: ' . $e->getMessage()
            );
        }
    }

    public function midtransPenaltyError($returnId)
    {
        return redirect()->route('payments.penalty.create', $returnId)
            ->with('error', 'Pembayaran denda gagal.');
    }

    public function midtransPenaltyPending($returnId)
    {
        return redirect()->route('returns.show', $returnId)
            ->with('info', 'Pembayaran denda masih pending.');
    }
}
