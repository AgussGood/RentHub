<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Payments;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;
use Throwable;

class PaymentApiController extends Controller
{
    protected function configureMidtrans(bool $useFallbackCurlOptions = false): void
    {
        Config::$serverKey    = trim((string) config('midtrans.server_key'));
        Config::$clientKey    = trim((string) config('midtrans.client_key'));
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized  = config('midtrans.is_sanitized', true);
        Config::$is3ds        = config('midtrans.is_3ds', true);
        Config::$curlOptions  = $useFallbackCurlOptions
            ? config('midtrans.curl_options_fallback', [])
            : config('midtrans.curl_options', []);
    }

    protected function executeMidtransRequestWithRetry(callable $callback, string $operation)
    {
        try {
            return $callback();
        } catch (Throwable $e) {
            if (! $this->isMidtransHandshakeError($e)) {
                throw $e;
            }

            \Log::warning("Midtrans API {$operation} handshake error. Retrying with fallback cURL options.", [
                'message' => $e->getMessage(),
            ]);

            $this->configureMidtrans(true);
            return $callback();
        }
    }

    protected function isMidtransHandshakeError(Throwable $e): bool
    {
        $message = strtolower($e->getMessage());

        return str_contains($message, 'handshake failure')
            || str_contains($message, 'sslv3 alert handshake failure')
            || (str_contains($message, 'curl error') && str_contains($message, 'ssl'));
    }

    /**
     * Bayar manual (cash / transfer / e_wallet)
     * POST /api/payments
     */
    public function store(Request $request)
    {
        // Validasi agree_terms dari Flutter (bool)
        if (! $request->boolean('agree_terms')) {
            return response()->json([
                'success' => false,
                'message' => 'Anda harus menyetujui syarat & ketentuan.',
            ], 422);
        }

        $request->validate([
            'booking_id'     => 'required|exists:bookings,id',
            'payment_method' => 'required|in:cash,transfer,e_wallet',
            'amount'         => 'required|numeric|min:0',
        ]);

        $booking = Booking::with('kendaraan')->findOrFail($request->booking_id);

        // Pastikan booking milik user yang login
        if ($booking->user_id !== auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak memiliki akses ke booking ini.',
            ], 403);
        }

        // Cek sudah dibayar
        if ($booking->payment && $booking->payment->payment_status === 'paid') {
            return response()->json([
                'success'    => false,
                'message'    => 'Booking ini sudah dibayar.',
                'booking_id' => $booking->id,
            ], 409);
        }

        // Buat payment record
        $payment = Payments::create([
            'booking_id'     => $booking->id,
            'payment_method' => $request->payment_method,
            'amount'         => $request->amount,
            'payment_date'   => now(),
            'payment_status' => 'paid',
        ]);

        // Update status booking & kendaraan
        $booking->update(['status' => 'confirmed']);
        $booking->kendaraan->update(['status' => 'rented']);

        return response()->json([
            'success'    => true,
            'message'    => 'Pembayaran berhasil dikonfirmasi. Booking Anda sudah aktif.',
            'booking_id' => $booking->id,
            'payment_id' => $payment->id,
        ], 201);
    }

    /**
     * Dapatkan Snap Token Midtrans
     * POST /api/payments/midtrans/{bookingId}
     */
    public function midtransToken(Request $request, $bookingId)
    {
        if (! $request->boolean('agree_terms')) {
            return response()->json([
                'success' => false,
                'message' => 'Anda harus menyetujui syarat & ketentuan.',
            ], 422);
        }

        try {
            $this->configureMidtrans();

            $booking = Booking::with(['kendaraan', 'user'])->findOrFail($bookingId);

            if ($booking->user_id !== auth()->id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Akses ditolak.',
                ], 403);
            }

            if ($booking->payment && $booking->payment->payment_status === 'paid') {
                return response()->json([
                    'success'    => false,
                    'message'    => 'Booking ini sudah dibayar.',
                    'booking_id' => $booking->id,
                ], 409);
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
                // Callback URL untuk Flutter WebView — sesuaikan domain Anda
                'callbacks'           => [
                    'finish' => config('app.url') . '/api/payments/midtrans/' . $booking->id . '/success',
                ],
            ];

            $snapToken = $this->executeMidtransRequestWithRetry(
                fn () => Snap::getSnapToken($params),
                'create snap token'
            );

            // Simpan order_id ke session/db agar bisa diverifikasi
            \Cache::put('midtrans_order_' . $booking->id, $orderId, now()->addHour());

            \Log::info('Midtrans API Token Generated', [
                'booking_id' => $booking->id,
                'order_id'   => $orderId,
                'snap_token' => substr($snapToken, 0, 20) . '...',
            ]);

            return response()->json([
                'success'      => true,
                'snap_token'   => $snapToken,
                'order_id'     => $orderId,
                'booking_id'   => $booking->id,
                // URL Snap Midtrans untuk WebView Flutter
                'redirect_url' => 'https://app.sandbox.midtrans.com/snap/v2/vtweb/' . $snapToken,
            ]);

        } catch (\Exception $e) {
            \Log::error('Midtrans API Token Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat token Midtrans: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Cek status pembayaran booking
     * GET /api/payments/{bookingId}
     */
    public function show($bookingId)
    {
        $booking = Booking::with(['payment', 'kendaraan'])->findOrFail($bookingId);

        if ($booking->user_id !== auth()->id()) {
            return response()->json(['success' => false, 'message' => 'Akses ditolak.'], 403);
        }

        return response()->json([
            'success'        => true,
            'booking_id'     => $booking->id,
            'booking_status' => $booking->status,
            'payment'        => $booking->payment ? [
                'id'             => $booking->payment->id,
                'payment_method' => $booking->payment->payment_method,
                'amount'         => $booking->payment->amount,
                'payment_status' => $booking->payment->payment_status,
                'payment_date'   => $booking->payment->payment_date,
            ] : null,
        ]);
    }
}
