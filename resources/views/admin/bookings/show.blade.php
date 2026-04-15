@extends('layouts.admin')

@section('content')
    <style>
        * {
            box-sizing: border-box;
        }

        .bk-wrap {
            padding: 1.5rem 2rem 2rem 2rem;
            font-family: inherit;
            max-width: 1200px;
        }

        /* ── Header Card ─────────────────────────────────────────── */
        .bk-header-card {
            background: linear-gradient(135deg, #4f5fd5 0%, #6366f1 100%);
            border-radius: 14px;
            padding: 22px 28px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .bk-header-icon {
            width: 46px;
            height: 46px;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            flex-shrink: 0;
        }

        .bk-header-title {
            font-size: 20px;
            font-weight: 600;
            color: #fff;
            margin: 0;
        }

        .bk-header-sub {
            font-size: 12px;
            color: rgba(255, 255, 255, 0.65);
            margin: 3px 0 0;
        }

        .bk-btn-back {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: #fff;
            font-size: 13px;
            cursor: pointer;
            text-decoration: none;
            transition: background 0.15s;
        }

        .bk-btn-back:hover {
            background: rgba(255, 255, 255, 0.25);
            color: #fff;
            text-decoration: none;
        }

        /* ── Alert ───────────────────────────────────────────────── */
        .bk-alert {
            padding: 12px 16px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 16px;
        }

        .bk-alert-success {
            background: #d1fae5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }

        /* ── Grid ────────────────────────────────────────────────── */
        .bk-grid {
            display: grid;
            grid-template-columns: 1fr 300px;
            gap: 20px;
            align-items: start;
        }

        .bk-col {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        /* ── Cards ───────────────────────────────────────────────── */
        .bk-card {
            background: #fff;
            border: 1px solid #e9ecef;
            border-radius: 14px;
            overflow: hidden;
        }

        .bk-card-header {
            padding: 14px 22px;
            border-bottom: 1px solid #e9ecef;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 12px;
            font-weight: 700;
            color: #6c757d;
            text-transform: uppercase;
            letter-spacing: 0.06em;
        }

        .bk-card-body {
            padding: 20px 22px;
        }

        /* ── Badges ──────────────────────────────────────────────── */
        .bk-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 5px 12px;
            border-radius: 99px;
            font-size: 12px;
            font-weight: 600;
        }

        .bk-badge-pending {
            background: #fef3c7;
            color: #92400e;
        }

        .bk-badge-confirmed {
            background: #d1fae5;
            color: #065f46;
        }

        .bk-badge-completed {
            background: #dbeafe;
            color: #1e40af;
        }

        .bk-badge-cancelled {
            background: #fee2e2;
            color: #991b1b;
        }

        .bk-badge-paid {
            background: #d1fae5;
            color: #065f46;
        }

        .bk-badge-unpaid {
            background: #fee2e2;
            color: #991b1b;
        }

        /* ── ID pill ─────────────────────────────────────────────── */
        .bk-id {
            font-size: 12px;
            font-weight: 600;
            color: #6366f1;
            background: #eef2ff;
            border-radius: 6px;
            padding: 3px 8px;
            font-family: monospace;
        }

        /* ── Plate ───────────────────────────────────────────────── */
        .bk-plate {
            font-size: 12px;
            font-weight: 700;
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 6px;
            padding: 3px 9px;
            font-family: monospace;
            letter-spacing: 0.08em;
            color: #495057;
            display: inline-block;
        }

        /* ── Info grid ───────────────────────────────────────────── */
        .bk-info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 16px;
        }

        .bk-info-grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .bk-info-label {
            font-size: 11px;
            color: #6c757d;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            margin-bottom: 4px;
        }

        .bk-info-val {
            font-size: 14px;
            font-weight: 500;
            color: #212529;
            margin: 0;
        }

        /* ── Divider ─────────────────────────────────────────────── */
        .bk-divider {
            border: none;
            border-top: 1px solid #e9ecef;
            margin: 18px 0;
        }

        /* ── Section title ───────────────────────────────────────── */
        .bk-section-title {
            font-size: 11px;
            font-weight: 700;
            color: #6c757d;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 14px;
        }

        /* ── Avatar ──────────────────────────────────────────────── */
        .bk-avatar {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: linear-gradient(135deg, #6366f1, #4f46e5);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 16px;
            font-weight: 700;
            flex-shrink: 0;
        }

        /* ── Vehicle image ───────────────────────────────────────── */
        .bk-vehicle-img {
            width: 100%;
            max-height: 220px;
            object-fit: contain;
            border-radius: 10px;
            border: 1px solid #e9ecef;
            display: block;
            margin-bottom: 16px;
        }

        .bk-vehicle-fallback {
            width: 100%;
            height: 140px;
            background: #f1f3f5;
            border-radius: 10px;
            border: 1px solid #e9ecef;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 48px;
            margin-bottom: 16px;
        }

        /* ── Quote / note block ──────────────────────────────────── */
        .bk-quote {
            background: #f8f9fa;
            border-left: 3px solid #6366f1;
            border-radius: 0 8px 8px 0;
            padding: 12px 14px;
            font-size: 13px;
            line-height: 1.7;
            color: #495057;
        }

        .bk-quote-danger {
            background: #fff1f2;
            border-left: 3px solid #e11d48;
            border-radius: 0 8px 8px 0;
            padding: 12px 14px;
            font-size: 13px;
            line-height: 1.7;
            color: #9f1239;
        }

        /* ── Notice ──────────────────────────────────────────────── */
        .bk-notice {
            padding: 11px 14px;
            border-radius: 8px;
            font-size: 13px;
            display: flex;
            align-items: flex-start;
            gap: 8px;
        }

        .bk-notice-success {
            background: #d1fae5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }

        .bk-notice-warning {
            background: #fef3c7;
            color: #92400e;
            border: 1px solid #fde68a;
        }

        .bk-notice-danger {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        /* ── Condition badge ─────────────────────────────────────── */
        .bk-cond {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 99px;
            font-size: 12px;
            font-weight: 600;
        }

        .bk-cond-excellent {
            background: #d1fae5;
            color: #065f46;
        }

        .bk-cond-good {
            background: #dbeafe;
            color: #1e40af;
        }

        .bk-cond-fair {
            background: #fef3c7;
            color: #92400e;
        }

        .bk-cond-poor {
            background: #fee2e2;
            color: #991b1b;
        }

        /* ── Financial rows ──────────────────────────────────────── */
        .bk-fin-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 0;
        }

        .bk-fin-row+.bk-fin-row {
            border-top: 1px solid #f1f3f5;
        }

        .bk-fin-label {
            font-size: 13px;
            color: #6c757d;
        }

        .bk-fin-sub {
            font-size: 11px;
            color: #9ca3af;
            margin-top: 2px;
        }

        .bk-fin-val {
            font-size: 13px;
            font-weight: 600;
            color: #212529;
        }

        .bk-fin-total {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0 0;
            border-top: 2px solid #e9ecef;
            margin-top: 4px;
        }

        .bk-fin-total-label {
            font-size: 14px;
            font-weight: 700;
            color: #212529;
        }

        .bk-fin-total-val {
            font-size: 20px;
            font-weight: 700;
        }

        /* ── Action buttons ──────────────────────────────────────── */
        .bk-btn-primary {
            width: 100%;
            padding: 11px;
            border-radius: 8px;
            background: #6366f1;
            color: #fff;
            border: none;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            text-decoration: none;
            transition: background 0.15s;
        }

        .bk-btn-primary:hover {
            background: #4f46e5;
            color: #fff;
            text-decoration: none;
        }

        .bk-btn-success {
            width: 100%;
            padding: 11px;
            border-radius: 8px;
            background: #d1fae5;
            color: #065f46;
            border: 1px solid #a7f3d0;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: background 0.15s;
        }

        .bk-btn-success:hover {
            background: #a7f3d0;
        }

        .bk-btn-danger {
            width: 100%;
            padding: 11px;
            border-radius: 8px;
            background: #fff1f2;
            color: #be123c;
            border: 1px solid #fecdd3;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            margin-top: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: background 0.15s;
        }

        .bk-btn-danger:hover {
            background: #ffe4e6;
        }

        /* ── Info card (right sidebar) ───────────────────────────── */
        .bk-card-info {
            background: #f8f9ff;
            border-color: #e0e7ff;
        }

        /* ── Proof link ──────────────────────────────────────────── */
        .bk-proof-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 14px;
            border-radius: 8px;
            background: #eef2ff;
            color: #6366f1;
            border: 1px solid #c7d2fe;
            font-size: 12px;
            font-weight: 600;
            text-decoration: none;
            margin-top: 12px;
            transition: background 0.15s;
        }

        .bk-proof-link:hover {
            background: #e0e7ff;
            color: #4f46e5;
            text-decoration: none;
        }

        /* ── Timeline (return steps) ─────────────────────────────── */
        .bk-timeline {
            display: flex;
            flex-direction: column;
            gap: 0;
        }

        .bk-timeline-item {
            display: flex;
            gap: 12px;
        }

        .bk-timeline-item+.bk-timeline-item {
            margin-top: 0;
        }

        .bk-tl-line {
            display: flex;
            flex-direction: column;
            align-items: center;
            flex-shrink: 0;
        }

        .bk-tl-dot {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            flex-shrink: 0;
        }

        .bk-tl-dot-done {
            background: #d1fae5;
        }

        .bk-tl-dot-active {
            background: #eef2ff;
        }

        .bk-tl-dot-idle {
            background: #f1f3f5;
        }

        .bk-tl-connector {
            width: 2px;
            flex: 1;
            background: #e9ecef;
            margin: 2px 0;
            min-height: 16px;
        }

        .bk-tl-body {
            padding-bottom: 16px;
            flex: 1;
        }

        .bk-tl-title {
            font-size: 13px;
            font-weight: 600;
            color: #212529;
            line-height: 28px;
        }

        .bk-tl-detail {
            font-size: 12px;
            color: #6c757d;
            margin-top: 2px;
        }

        /* ── Responsive ──────────────────────────────────────────── */
        @media (max-width: 900px) {
            .bk-grid {
                grid-template-columns: 1fr;
            }

            .bk-info-grid {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 600px) {
            .bk-wrap {
                padding: 1rem;
            }

            .bk-header-card {
                flex-direction: column;
                align-items: flex-start;
                gap: 12px;
            }

            .bk-info-grid {
                grid-template-columns: 1fr;
            }

            .bk-info-grid-2 {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <div class="bk-wrap">

        {{-- ── Header ──────────────────────────────────────────── --}}
        <div class="bk-header-card">
            <div style="display:flex; align-items:center; gap:16px;">
                <div class="bk-header-icon">📋</div>
                <div>
                    <p class="bk-header-sub">Manajemen Booking · Detail</p>
                    <h4 class="bk-header-title">
                        Booking #{{ str_pad($booking->id, 6, '0', STR_PAD_LEFT) }}
                    </h4>
                </div>
            </div>
            <a href="{{ route('admin.bookings.index') }}" class="bk-btn-back">← Kembali</a>
        </div>

        {{-- ── Alert ───────────────────────────────────────────── --}}
        @if (session('success'))
            <div class="bk-alert bk-alert-success" id="bkAlert">
                ✔ {{ session('success') }}
            </div>
        @endif

        <div class="bk-grid">

            {{-- ════════════════════════════════════════════════════
             KOLOM KIRI
             ════════════════════════════════════════════════════ --}}
            <div class="bk-col">

                {{-- 1. Status & Pelanggan --}}
                <div class="bk-card">
                    <div class="bk-card-header">👤 Informasi Booking</div>
                    <div class="bk-card-body">

                        {{-- ID + Badge --}}
                        <div
                            style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:16px;">
                            <div>
                                <p class="bk-info-label" style="margin-bottom:4px;">ID Booking</p>
                                <span class="bk-id">#{{ str_pad($booking->id, 6, '0', STR_PAD_LEFT) }}</span>
                            </div>
                            @php
                                $badgeMap = [
                                    'pending' => ['class' => 'bk-badge-pending', 'label' => '⏳ Menunggu'],
                                    'confirmed' => ['class' => 'bk-badge-confirmed', 'label' => '✔ Dikonfirmasi'],
                                    'completed' => ['class' => 'bk-badge-completed', 'label' => '🏁 Selesai'],
                                    'cancelled' => ['class' => 'bk-badge-cancelled', 'label' => '✖ Dibatalkan'],
                                ];
                                $badge = $badgeMap[$booking->status] ?? [
                                    'class' => 'bk-badge-pending',
                                    'label' => ucfirst($booking->status),
                                ];
                            @endphp
                            <span class="bk-badge {{ $badge['class'] }}">{{ $badge['label'] }}</span>
                        </div>

                        {{-- Pelanggan --}}
                        <div
                            style="display:flex; align-items:center; gap:14px; padding:14px; background:#f8f9ff; border:1px solid #e0e7ff; border-radius:10px; margin-bottom:18px;">
                            <div class="bk-avatar">{{ strtoupper(substr($booking->user->name, 0, 1)) }}</div>
                            <div style="min-width:0;">
                                <p style="font-size:14px; font-weight:600; color:#212529; margin:0;">
                                    {{ $booking->user->name }}
                                </p>
                                <p style="font-size:12px; color:#6c757d; margin:3px 0 0;">
                                    {{ $booking->user->email }}
                                </p>
                            </div>
                            <div style="margin-left:auto; text-align:right; flex-shrink:0;">
                                <p class="bk-info-label" style="margin-bottom:2px;">Dibuat</p>
                                <p style="font-size:12px; color:#212529; font-weight:500;">
                                    {{ $booking->created_at->translatedFormat('d M Y, H:i') }}
                                </p>
                            </div>
                        </div>

                        {{-- Periode Sewa --}}
                        <p class="bk-section-title">Periode Sewa</p>
                        <div class="bk-info-grid">
                            <div>
                                <p class="bk-info-label">Mulai Sewa</p>
                                <p class="bk-info-val">
                                    {{ \Carbon\Carbon::parse($booking->start_date)->translatedFormat('d M Y') }}</p>
                            </div>
                            <div>
                                <p class="bk-info-label">Selesai Sewa</p>
                                <p class="bk-info-val">
                                    {{ \Carbon\Carbon::parse($booking->end_date)->translatedFormat('d M Y') }}</p>
                            </div>
                            <div>
                                <p class="bk-info-label">Durasi</p>
                                <p class="bk-info-val">{{ $booking->total_days }} hari</p>
                            </div>
                        </div>

                        {{-- Info tambahan --}}
                        @if ($booking->pickup_location || $booking->notes)
                            <hr class="bk-divider">
                            <p class="bk-section-title">Informasi Tambahan</p>
                            @if ($booking->pickup_location)
                                <div style="margin-bottom:10px;">
                                    <p class="bk-info-label">Lokasi Pickup</p>
                                    <p class="bk-info-val" style="font-size:13px;">{{ $booking->pickup_location }}</p>
                                </div>
                            @endif
                            @if ($booking->notes)
                                <p class="bk-info-label" style="margin-bottom:8px;">Catatan</p>
                                <div class="bk-quote">{{ $booking->notes }}</div>
                            @endif
                        @endif

                    </div>
                </div>

                {{-- 2. Kendaraan --}}
                <div class="bk-card">
                    <div class="bk-card-header">🚗 Informasi Kendaraan</div>
                    <div class="bk-card-body">

                        @if ($booking->kendaraan->images->first())
                            <img src="{{ Storage::url($booking->kendaraan->images->first()->image_path) }}"
                                alt="{{ $booking->kendaraan->brand }}" class="bk-vehicle-img">
                        @else
                            <div class="bk-vehicle-fallback">🚗</div>
                        @endif

                        <p style="font-size:16px; font-weight:600; color:#212529; margin-bottom:4px;">
                            {{ $booking->kendaraan->brand }} {{ $booking->kendaraan->model }}
                            <span
                                style="font-size:13px; color:#6c757d; font-weight:400;">({{ $booking->kendaraan->year }})</span>
                        </p>
                        <span class="bk-plate" style="margin-bottom:16px; display:inline-block;">
                            {{ $booking->kendaraan->plate_number }}
                        </span>

                        <div class="bk-info-grid" style="margin-top:8px;">
                            <div>
                                <p class="bk-info-label">Bahan Bakar</p>
                                <p class="bk-info-val">{{ ucfirst($booking->kendaraan->detail->fuel_type) }}</p>
                            </div>
                            <div>
                                <p class="bk-info-label">Harga per Hari</p>
                                <p class="bk-info-val">Rp
                                    {{ number_format($booking->kendaraan->price_per_day, 0, ',', '.') }}</p>
                            </div>
                            <div>
                                <p class="bk-info-label">Kapasitas</p>
                                <p class="bk-info-val">{{ $booking->kendaraan->detail->seat_count ?? '-' }} orang</p>
                            </div>
                        </div>

                    </div>
                </div>

                {{-- 3. Pembayaran --}}
                <div class="bk-card">
                    <div class="bk-card-header">💳 Pembayaran</div>
                    <div class="bk-card-body">

                        @if ($booking->payment)
                            <div
                                style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:16px;">
                                <div>
                                    <p class="bk-info-label" style="margin-bottom:4px;">Status Pembayaran</p>
                                    @if ($booking->payment->payment_status === 'paid')
                                        <span class="bk-badge bk-badge-paid">✔ Lunas</span>
                                    @else
                                        <span class="bk-badge bk-badge-unpaid">✖ Belum Lunas</span>
                                    @endif
                                </div>
                                <div style="text-align:right;">
                                    <p class="bk-info-label" style="margin-bottom:4px;">Tanggal Bayar</p>
                                    <p class="bk-info-val" style="font-size:13px;">
                                        {{ \Carbon\Carbon::parse($booking->payment->payment_date)->translatedFormat('d M Y') }}
                                    </p>
                                </div>
                            </div>

                            <div class="bk-info-grid-2">
                                <div>
                                    <p class="bk-info-label">Metode Pembayaran</p>
                                    <p class="bk-info-val" style="font-size:13px;">
                                        {{ ucwords(str_replace('_', ' ', $booking->payment->payment_method)) }}
                                    </p>
                                </div>
                                <div>
                                    <p class="bk-info-label">Jumlah Dibayar</p>
                                    <p class="bk-info-val" style="font-size:15px; color:#059669;">
                                        Rp
                                        {{ number_format($booking->payment->amount ?? $booking->total_price, 0, ',', '.') }}
                                    </p>
                                </div>
                            </div>

                            @if ($booking->payment->payment_proof)
                                <a href="{{ Storage::url($booking->payment->payment_proof) }}" target="_blank"
                                    class="bk-proof-link">
                                    🖼 Lihat Bukti Pembayaran
                                </a>
                            @endif
                        @else
                            <div class="bk-notice bk-notice-warning">
                                <span style="font-size:16px; flex-shrink:0;">⚠</span>
                                <div>
                                    <strong style="display:block; margin-bottom:2px;">Belum Ada Pembayaran</strong>
                                    Pelanggan belum melakukan pembayaran untuk booking ini.
                                </div>
                            </div>
                        @endif

                    </div>
                </div>

                {{-- 4. Pengembalian (jika ada) --}}
                @if ($booking->pengembalian)
                    <div class="bk-card">
                        <div class="bk-card-header">🔄 Pengembalian Kendaraan</div>
                        <div class="bk-card-body">

                            @php
                                $ret = $booking->pengembalian;
                                $condMap = [
                                    'excellent' => ['class' => 'bk-cond-excellent', 'label' => 'Sangat Baik'],
                                    'good' => ['class' => 'bk-cond-good', 'label' => 'Baik'],
                                    'fair' => ['class' => 'bk-cond-fair', 'label' => 'Rusak'],
                                ];
                                $cond = $condMap[$ret->condition] ?? [
                                    'class' => 'bk-cond-fair',
                                    'label' => ucfirst($ret->condition ?? '-'),
                                ];
                            @endphp

                            <div class="bk-info-grid">
                                <div>
                                    <p class="bk-info-label">Tanggal Kembali</p>
                                    <p class="bk-info-val">
                                        @if ($booking->pengembalian && $booking->pengembalian->return_actual_date)
                                            {{ \Carbon\Carbon::parse($booking->pengembalian->return_actual_date)->translatedFormat('d M Y') }}
                                        @else
                                            <span style="color:#9ca3af;">Belum dikembalikan</span>
                                        @endif
                                    </p>
                                </div>
                                <div>
                                    <p class="bk-info-label">Kondisi Kendaraan</p>
                                    <span class="bk-cond {{ $cond['class'] }}">{{ $cond['label'] }}</span>
                                </div>
                                <div>
                                    <p class="bk-info-label">Status Inspeksi</p>
                                    @if ($ret->status === 'completed')
                                        <span class="bk-badge bk-badge-confirmed">✔ Selesai</span>
                                    @else
                                        <span class="bk-badge bk-badge-pending">⏳ Menunggu</span>
                                    @endif
                                </div>
                            </div>

                            @if ($ret->admin_notes)
                                <hr class="bk-divider">
                                <p class="bk-info-label" style="margin-bottom:8px;">Catatan Inspektor</p>
                                <div class="bk-quote">{{ $ret->admin_notes }}</div>
                            @endif

                            @if ($ret->damage_description)
                                <hr class="bk-divider">
                                <p class="bk-info-label" style="margin-bottom:8px; color:#be123c;">⚠ Laporan Kerusakan</p>
                                <div class="bk-quote-danger" style="white-space:pre-line;">{{ $ret->damage_description }}
                                </div>
                            @endif

                            <div style="margin-top:14px;">
                                <a href="{{ route('admin.returns.show', $ret->id) }}"
                                    style="display:inline-flex; align-items:center; gap:6px; padding:7px 14px; border-radius:8px; background:#eef2ff; color:#6366f1; border:1px solid #c7d2fe; font-size:12px; font-weight:600; text-decoration:none;">
                                    Detail Pengembalian →
                                </a>
                            </div>

                        </div>
                    </div>
                @endif

            </div>{{-- /kiri --}}


            {{-- ════════════════════════════════════════════════════
             KOLOM KANAN (300 px)
             ════════════════════════════════════════════════════ --}}
            <div class="bk-col">

                {{-- Ringkasan Keuangan --}}
                <div class="bk-card">
                    <div class="bk-card-header">💰 Ringkasan Keuangan</div>
                    <div class="bk-card-body">

                        <div class="bk-fin-row">
                            <div>
                                <p class="bk-fin-label">Biaya Sewa</p>
                                <p class="bk-fin-sub">{{ $booking->total_days }} hari</p>
                            </div>
                            <span class="bk-fin-val">
                                Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                            </span>
                        </div>

                        @if ($booking->pengembalian && ($booking->pengembalian->late_fee ?? 0) > 0)
                            <div class="bk-fin-row">
                                <div>
                                    <p class="bk-fin-label" style="color:#92400e;">⏰ Denda Keterlambatan</p>
                                    <p class="bk-fin-sub">{{ $booking->pengembalian->late_days }} hari × 20%</p>
                                </div>
                                <span class="bk-fin-val" style="color:#92400e;">
                                    Rp {{ number_format($booking->pengembalian->late_fee, 0, ',', '.') }}
                                </span>
                            </div>
                        @endif

                        @if ($booking->pengembalian && ($booking->pengembalian->damage_fee ?? 0) > 0)
                            <div class="bk-fin-row">
                                <p class="bk-fin-label" style="color:#991b1b;">🔧 Biaya Perbaikan</p>
                                <span class="bk-fin-val" style="color:#991b1b;">
                                    Rp {{ number_format($booking->pengembalian->damage_fee, 0, ',', '.') }}
                                </span>
                            </div>
                        @endif

                        @php
                            $totalPenalty = $booking->pengembalian->total_penalty ?? 0;
                            $grandTotal = $booking->total_price + $totalPenalty;
                        @endphp

                        <div class="bk-fin-total">
                            <span class="bk-fin-total-label">Grand Total</span>
                            <span class="bk-fin-total-val" style="color:#6366f1;">
                                Rp {{ number_format($grandTotal, 0, ',', '.') }}
                            </span>
                        </div>

                        <hr class="bk-divider">

                        @if ($totalPenalty > 0)
                            <div class="bk-notice bk-notice-warning" style="font-size:12px;">
                                ⚠ Termasuk denda <strong>Rp {{ number_format($totalPenalty, 0, ',', '.') }}</strong>
                            </div>
                        @elseif($booking->payment && $booking->payment->payment_status === 'paid')
                            <div class="bk-notice bk-notice-success" style="font-size:12px;">
                                ✔ Pembayaran telah lunas
                            </div>
                        @else
                            <div class="bk-notice bk-notice-warning" style="font-size:12px;">
                                ⚠ Menunggu pembayaran dari pelanggan
                            </div>
                        @endif

                    </div>
                </div>

                {{-- Aksi Admin --}}
                @if (in_array($booking->status, ['pending', 'confirmed']))
                    <div class="bk-card">
                        <div class="bk-card-header">⚙ Aksi</div>
                        <div class="bk-card-body">

                            {{-- Konfirmasi (pending + sudah bayar) --}}
                            @if ($booking->status === 'pending' && $booking->payment)
                                <form action="{{ route('admin.bookings.updateStatus', $booking->id) }}" method="POST"
                                    onsubmit="return confirm('Konfirmasi booking ini?')">
                                    @csrf
                                    <input type="hidden" name="status" value="confirmed">
                                    <button type="submit" class="bk-btn-success">
                                        ✔ Konfirmasi Booking
                                    </button>
                                </form>
                            @elseif($booking->status === 'pending')
                                <div class="bk-notice bk-notice-warning" style="margin-bottom:10px; font-size:12px;">
                                    ⚠ Booking belum bisa dikonfirmasi karena pelanggan belum membayar.
                                </div>
                            @endif

                            {{-- Selesaikan (confirmed + ada return) --}}
                            @if ($booking->status === 'confirmed' && $booking->pengembalian)
                                <form action="{{ route('admin.bookings.updateStatus', $booking->id) }}" method="POST"
                                    onsubmit="return confirm('Tandai booking ini sebagai selesai?')"
                                    style="margin-top:8px;">
                                    @csrf
                                    <input type="hidden" name="status" value="completed">
                                    <button type="submit" class="bk-btn-primary">
                                        🏁 Tandai Selesai
                                    </button>
                                </form>
                            @endif

                            {{-- Batalkan --}}
                            <form action="{{ route('admin.bookings.updateStatus', $booking->id) }}" method="POST"
                                onsubmit="return confirm('Yakin ingin membatalkan booking ini?')">
                                @csrf
                                <input type="hidden" name="status" value="cancelled">
                                <button type="submit" class="bk-btn-danger">✖ Batalkan Booking</button>
                            </form>

                        </div>
                    </div>
                @endif

                {{-- Timeline Status --}}
                <div class="bk-card">
                    <div class="bk-card-header">🕐 Riwayat Status</div>
                    <div class="bk-card-body">
                        @php
                            $steps = [
                                [
                                    'key' => 'pending',
                                    'icon' => '📋',
                                    'label' => 'Booking Dibuat',
                                    'detail' => $booking->created_at->translatedFormat('d M Y, H:i'),
                                ],
                                [
                                    'key' => 'payment',
                                    'icon' => '💳',
                                    'label' => 'Pembayaran',
                                    'detail' => $booking->payment
                                        ? $booking->payment->created_at->translatedFormat('d M Y')
                                        : 'Menunggu pembayaran',
                                ],
                                [
                                    'key' => 'confirmed',
                                    'icon' => '✔',
                                    'label' => 'Dikonfirmasi',
                                    'detail' =>
                                        $booking->status === 'confirmed' || $booking->status === 'completed'
                                            ? 'Booking telah dikonfirmasi'
                                            : 'Belum dikonfirmasi',
                                ],
                                [
                                    'key' => 'pengembalian',
                                    'icon' => '🔄',
                                    'label' => 'Pengembalian',
                                    'detail' => $booking->pengembalian
                                        ? 'Kendaraan telah dikembalikan'
                                        : 'Belum ada pengembalian',
                                ],
                                [
                                    'key' => 'completed',
                                    'icon' => '🏁',
                                    'label' => 'Selesai',
                                    'detail' =>
                                        $booking->status === 'completed' ? 'Booking selesai' : 'Menunggu penyelesaian',
                                ],
                            ];
                            $activeIdx = match ($booking->status) {
                                'pending' => 0,
                                'confirmed' => $booking->pengembalian ? 3 : 2,
                                'completed' => 4,
                                default => 0,
                            };
                            if ($booking->payment) {
                                $activeIdx = max($activeIdx, 1);
                            }
                        @endphp

                        <div class="bk-timeline">
                            @foreach ($steps as $i => $step)
                                <div class="bk-timeline-item">
                                    <div class="bk-tl-line">
                                        <div
                                            class="bk-tl-dot {{ $i <= $activeIdx ? 'bk-tl-dot-done' : 'bk-tl-dot-idle' }}">
                                            {{ $step['icon'] }}
                                        </div>
                                        @if (!$loop->last)
                                            <div class="bk-tl-connector"></div>
                                        @endif
                                    </div>
                                    <div class="bk-tl-body">
                                        <p class="bk-tl-title"
                                            style="color: {{ $i <= $activeIdx ? '#212529' : '#9ca3af' }};">
                                            {{ $step['label'] }}
                                        </p>
                                        <p class="bk-tl-detail">{{ $step['detail'] }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Info Card --}}
                <div class="bk-card bk-card-info">
                    <div class="bk-card-body">
                        <div style="display:flex; align-items:center; gap:10px; margin-bottom:10px;">
                            <div
                                style="width:36px; height:36px; border-radius:8px; background:#eef2ff; display:flex; align-items:center; justify-content:center; font-size:16px;">
                                ℹ</div>
                            <span style="font-size:13px; font-weight:600; color:#212529;">Informasi</span>
                        </div>
                        <p style="font-size:12px; color:#6c757d; line-height:1.7; margin:0;">
                            Booking ini tercatat atas nama
                            <strong style="color:#212529;">{{ $booking->user->name }}</strong>
                            untuk kendaraan
                            <strong style="color:#212529;">{{ $booking->kendaraan->brand }}
                                {{ $booking->kendaraan->model }}</strong>
                            selama <strong style="color:#6366f1;">{{ $booking->total_days }} hari</strong>.
                        </p>
                    </div>
                </div>

            </div>{{-- /kanan --}}

        </div>{{-- /bk-grid --}}

    </div>{{-- /bk-wrap --}}

    @push('scripts')
        <script>
            const bkAlert = document.getElementById('bkAlert');
            if (bkAlert) {
                setTimeout(function() {
                    bkAlert.style.transition = 'opacity 0.5s';
                    bkAlert.style.opacity = '0';
                    setTimeout(() => bkAlert.remove(), 500);
                }, 4000);
            }
        </script>
    @endpush

@endsection
