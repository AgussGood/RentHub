@extends('layouts.admin')

@section('content')
    <style>
        * {
            box-sizing: border-box;
        }

        .rs-wrap {
            padding: 1.5rem 2rem 2rem 2rem;
            font-family: inherit;
            max-width: 1200px;
        }

        /* Header Card */
        .rs-header-card {
            background: linear-gradient(135deg, #4f5fd5 0%, #6366f1 100%);
            border-radius: 14px;
            padding: 22px 28px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .rs-header-icon {
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

        .rs-header-title {
            font-size: 20px;
            font-weight: 600;
            color: #fff;
            margin: 0;
        }

        .rs-header-sub {
            font-size: 12px;
            color: rgba(255, 255, 255, 0.65);
            margin: 3px 0 0;
        }

        .rs-btn-back {
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

        .rs-btn-back:hover {
            background: rgba(255, 255, 255, 0.25);
            color: #fff;
            text-decoration: none;
        }

        /* Grid */
        .rs-grid {
            display: grid;
            grid-template-columns: 1fr 320px;
            gap: 20px;
            align-items: start;
        }

        .rs-col {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        /* Cards */
        .rs-card {
            background: #fff;
            border: 1px solid #e9ecef;
            border-radius: 14px;
            overflow: hidden;
        }

        .rs-card-header {
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

        .rs-card-body {
            padding: 20px 22px;
        }

        /* Badges */
        .rs-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 5px 12px;
            border-radius: 99px;
            font-size: 12px;
            font-weight: 600;
        }

        .rs-badge-pending {
            background: #fef3c7;
            color: #92400e;
        }

        .rs-badge-completed {
            background: #d1fae5;
            color: #065f46;
        }

        .rs-badge-cancelled {
            background: #fee2e2;
            color: #991b1b;
        }

        .rs-badge-scheduled {
            background: #dbeafe;
            color: #1e40af;
        }

        /* Info grid */
        .rs-info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .rs-info-item {}

        .rs-info-label {
            font-size: 11px;
            color: #6c757d;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            margin-bottom: 4px;
        }

        .rs-info-val {
            font-size: 14px;
            font-weight: 500;
            color: #212529;
        }

        /* Plate */
        .rs-plate {
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

        /* ID pill */
        .rs-id {
            font-size: 12px;
            font-weight: 600;
            color: #6366f1;
            background: #eef2ff;
            border-radius: 6px;
            padding: 3px 8px;
            font-family: monospace;
        }

        /* Status notice */
        .rs-notice {
            padding: 11px 14px;
            border-radius: 8px;
            font-size: 13px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .rs-notice-success {
            background: #d1fae5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }

        .rs-notice-warning {
            background: #fef3c7;
            color: #92400e;
            border: 1px solid #fde68a;
        }

        .rs-notice-danger {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        /* Divider */
        .rs-divider {
            border: none;
            border-top: 1px solid #e9ecef;
            margin: 16px 0;
        }

        /* Condition badge */
        .rs-condition {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 99px;
            font-size: 12px;
            font-weight: 600;
        }

        .rs-cond-excellent {
            background: #d1fae5;
            color: #065f46;
        }

        .rs-cond-good {
            background: #dbeafe;
            color: #1e40af;
        }

        .rs-cond-fair {
            background: #fef3c7;
            color: #92400e;
        }

        .rs-cond-poor {
            background: #fee2e2;
            color: #991b1b;
        }

        /* Quote block */
        .rs-quote {
            background: #f8f9fa;
            border-left: 3px solid #6366f1;
            border-radius: 0 8px 8px 0;
            padding: 12px 14px;
            font-size: 13px;
            line-height: 1.7;
            color: #495057;
        }

        .rs-quote-danger {
            background: #fff1f2;
            border-left: 3px solid #e11d48;
            border-radius: 0 8px 8px 0;
            padding: 12px 14px;
            font-size: 13px;
            line-height: 1.7;
            color: #9f1239;
        }

        /* Damage photos */
        .rs-photos {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
            margin-top: 12px;
        }

        .rs-photo-link {
            display: block;
            border-radius: 8px;
            overflow: hidden;
            border: 1px solid #fecaca;
        }

        .rs-photo-link img {
            width: 100%;
            height: 80px;
            object-fit: cover;
            display: block;
            transition: opacity 0.15s;
        }

        .rs-photo-link:hover img {
            opacity: 0.85;
        }

        /* Financial rows */
        .rs-fin-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 0;
        }

        .rs-fin-row+.rs-fin-row {
            border-top: 1px solid #f1f3f5;
        }

        .rs-fin-label {
            font-size: 13px;
            color: #6c757d;
        }

        .rs-fin-val {
            font-size: 13px;
            font-weight: 600;
            color: #212529;
        }

        .rs-fin-total {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0 0;
            border-top: 2px solid #e9ecef;
            margin-top: 4px;
        }

        .rs-fin-total-label {
            font-size: 14px;
            font-weight: 700;
            color: #212529;
        }

        .rs-fin-total-val {
            font-size: 18px;
            font-weight: 700;
        }

        /* Action buttons */
        .rs-btn-primary {
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

        .rs-btn-primary:hover {
            background: #4f46e5;
            color: #fff;
            text-decoration: none;
        }

        .rs-btn-danger {
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

        .rs-btn-danger:hover {
            background: #ffe4e6;
        }

        /* Booking ref */
        .rs-booking-ref {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 12px 14px;
            background: #f8f9ff;
            border: 1px solid #e0e7ff;
            border-radius: 10px;
        }

        .rs-booking-icon {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            background: #eef2ff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            flex-shrink: 0;
        }

        .rs-btn-link {
            margin-left: auto;
            padding: 6px 12px;
            border-radius: 7px;
            background: #eef2ff;
            color: #6366f1;
            border: 1px solid #c7d2fe;
            font-size: 12px;
            font-weight: 600;
            text-decoration: none;
            white-space: nowrap;
            flex-shrink: 0;
        }

        .rs-btn-link:hover {
            background: #e0e7ff;
            color: #4f46e5;
            text-decoration: none;
        }

        /* Alert */
        .rs-alert {
            padding: 12px 16px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 16px;
        }

        .rs-alert-success {
            background: #d1fae5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }

        /* Vehicle image */
        .rs-vehicle-img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            border-radius: 10px;
            border: 1px solid #e9ecef;
            display: block;
        }

        .rs-vehicle-fallback {
            width: 100%;
            height: 120px;
            background: #f1f3f5;
            border-radius: 10px;
            border: 1px solid #e9ecef;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 40px;
        }

        @media (max-width: 900px) {
            .rs-grid {
                grid-template-columns: 1fr;
            }

            .rs-info-grid {
                grid-template-columns: 1fr 1fr;
            }

            .rs-photos {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (max-width: 600px) {
            .rs-wrap {
                padding: 1rem;
            }

            .rs-info-grid {
                grid-template-columns: 1fr;
            }

            .rs-header-card {
                flex-direction: column;
                align-items: flex-start;
                gap: 12px;
            }
        }
    </style>

    <div class="rs-wrap">

        {{-- Header Card --}}
        <div class="rs-header-card">
            <div style="display:flex; align-items:center; gap:16px;">
                <div class="rs-header-icon">🔄</div>
                <div>
                    <p class="rs-header-sub">Pengembalian Kendaraan · Detail</p>
                    <h4 class="rs-header-title">
                        Return #{{ str_pad($return->id, 6, '0', STR_PAD_LEFT) }}
                    </h4>
                </div>
            </div>
            <a href="{{ route('admin.returns.index') }}" class="rs-btn-back">← Kembali</a>
        </div>

        {{-- Alert --}}
        @if (session('success'))
            <div class="rs-alert rs-alert-success">✔ {{ session('success') }}</div>
        @endif

        <div class="rs-grid">

            {{-- LEFT COLUMN --}}
            <div class="rs-col">

                {{-- Status & Info Utama --}}
                <div class="rs-card">
                    <div class="rs-card-header">📋 Informasi Pengembalian</div>
                    <div class="rs-card-body">

                        {{-- Status Row --}}
                        <div
                            style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:14px;">
                            <div>
                                <p style="font-size:11px; color:#6c757d; margin-bottom:4px;">ID Pengembalian</p>
                                <span class="rs-id">#{{ str_pad($return->id, 6, '0', STR_PAD_LEFT) }}</span>
                            </div>
                            @php
                                $badgeMap = [
                                    'return_pending' => [
                                        'class' => 'rs-badge-pending',
                                        'label' => '⏳ Menunggu Inspeksi',
                                    ],
                                    'completed' => ['class' => 'rs-badge-completed', 'label' => '✔ Selesai'],
                                    'cancelled' => ['class' => 'rs-badge-cancelled', 'label' => '✖ Dibatalkan'],
                                    'scheduled' => ['class' => 'rs-badge-scheduled', 'label' => '📅 Terjadwal'],
                                ];
                                $badge = $badgeMap[$return->status] ?? [
                                    'class' => 'rs-badge-scheduled',
                                    'label' => ucfirst($return->status),
                                ];
                            @endphp
                            <span class="rs-badge {{ $badge['class'] }}">{{ $badge['label'] }}</span>
                        </div>

                        {{-- Notice --}}
                        @if ($return->status === 'completed')
                            <div class="rs-notice rs-notice-success" style="margin-bottom:16px;">
                                ✔ Inspeksi selesai pada
                                {{ \Carbon\Carbon::parse($return->inspected_at)->translatedFormat('d M Y, H:i') }}
                            </div>
                        @elseif($return->status === 'cancelled')
                            <div class="rs-notice rs-notice-danger" style="margin-bottom:16px;">
                                ✖ Pengembalian ini telah dibatalkan
                            </div>
                        @else
                            @php $isOverdue = \Carbon\Carbon::parse($return->return_scheduled_date)->isPast(); @endphp
                            <div class="rs-notice {{ $isOverdue ? 'rs-notice-danger' : 'rs-notice-warning' }}"
                                style="margin-bottom:16px;">
                                {{ $isOverdue ? '⚠ Jadwal pengembalian telah lewat!' : '⏳ Dijadwalkan' }}
                                pada {{ \Carbon\Carbon::parse($return->return_scheduled_date)->translatedFormat('d M Y') }}
                                pukul
                                {{ \Carbon\Carbon::createFromFormat('H:i:s', $return->return_scheduled_time)->format('H:i') }}
                                WIB
                            </div>
                        @endif

                        {{-- Booking Reference --}}
                        <div class="rs-booking-ref" style="margin-bottom:16px;">
                            <div class="rs-booking-icon">📄</div>
                            <div style="min-width:0;">
                                <div style="font-size:13px; font-weight:600; color:#212529;">
                                    Booking #{{ str_pad($return->booking->id, 6, '0', STR_PAD_LEFT) }}
                                </div>
                                <div style="font-size:12px; color:#6c757d;">{{ $return->booking->user->name }}</div>
                            </div>
                            <a href="{{ route('admin.bookings.show', $return->booking_id) }}" class="rs-btn-link">
                                Lihat Booking →
                            </a>
                        </div>

                        {{-- Jadwal --}}
                        <hr class="rs-divider">
                        <p
                            style="font-size:11px; font-weight:700; color:#6c757d; text-transform:uppercase; letter-spacing:0.05em; margin-bottom:12px;">
                            Jadwal</p>
                        <div class="rs-info-grid">
                            <div class="rs-info-item">
                                <p class="rs-info-label">Mulai Sewa</p>
                                <p class="rs-info-val">
                                    {{ \Carbon\Carbon::parse($return->booking->start_date)->translatedFormat('d M Y') }}
                                </p>
                            </div>
                            <div class="rs-info-item">
                                <p class="rs-info-label">Seharusnya Kembali</p>
                                <p class="rs-info-val">
                                    {{ \Carbon\Carbon::parse($return->booking->end_date)->translatedFormat('d M Y') }}</p>
                            </div>
                            <div class="rs-info-item">
                                <p class="rs-info-label">Jadwal Pengembalian</p>
                                <p class="rs-info-val" style="color:#6366f1;">
                                    {{ \Carbon\Carbon::parse($return->return_scheduled_date)->translatedFormat('d M Y') }}
                                    <span style="font-size:12px; color:#6c757d;">
                                        {{ \Carbon\Carbon::createFromFormat('H:i:s', $return->return_scheduled_time)->format('H:i') }}
                                        WIB
                                    </span>
                                </p>
                            </div>
                            @if ($return->return_actual_date)
                                <div class="rs-info-item">
                                    <p class="rs-info-label">Pengembalian Aktual</p>
                                    <p class="rs-info-val" style="color:#065f46;">
                                        {{ \Carbon\Carbon::parse($return->return_actual_date)->translatedFormat('d M Y') }}
                                        <span style="font-size:12px; color:#6c757d;">
                                            @if ($return->return_scheduled_time)
                                                {{ \Carbon\Carbon::parse($return->return_scheduled_time)->format('H:i') }}
                                                WIB
                                            @else
                                                -
                                            @endif
                                        </span>
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Kendaraan --}}
                <div class="rs-card">
                    <div class="rs-card-header">🚗 Informasi Kendaraan</div>
                    <div class="rs-card-body">
                        <div style="display:flex; gap:16px; align-items:flex-start;">
                            <div style="flex-shrink:0; width:160px;">
                                @if ($return->booking->kendaraan->images->first())
                                    <img src="{{ Storage::url($return->booking->kendaraan->images->first()->image_path) }}"
                                        alt="{{ $return->booking->kendaraan->brand }}" class="rs-vehicle-img"
                                        style="height:120px;">
                                @else
                                    <div class="rs-vehicle-fallback">🚗</div>
                                @endif
                            </div>
                            <div style="flex:1; min-width:0;">
                                <p style="font-size:16px; font-weight:600; color:#212529; margin-bottom:6px;">
                                    {{ $return->booking->kendaraan->brand }} {{ $return->booking->kendaraan->model }}
                                </p>
                                <span class="rs-plate">{{ $return->booking->kendaraan->plate_number }}</span>
                                <div style="display:flex; gap:14px; margin-top:12px; flex-wrap:wrap;">
                                    <div>
                                        <p class="rs-info-label">Tahun</p>
                                        <p class="rs-info-val">{{ $return->booking->kendaraan->year }}</p>
                                    </div>
                                    <div>
                                        <p class="rs-info-label">Bahan Bakar</p>
                                        <p class="rs-info-val">{{ ucfirst($return->booking->kendaraan->fuel_type) }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Catatan Pelanggan --}}
                @if ($return->customer_notes)
                    <div class="rs-card">
                        <div class="rs-card-header">💬 Catatan Pelanggan</div>
                        <div class="rs-card-body">
                            <div class="rs-quote">{{ $return->customer_notes }}</div>
                        </div>
                    </div>
                @endif

                {{-- Hasil Inspeksi --}}
                @if ($return->status === 'completed')
                    <div class="rs-card">
                        <div class="rs-card-header">🔍 Hasil Inspeksi</div>
                        <div class="rs-card-body">

                            <div class="rs-info-grid" style="margin-bottom:16px;">
                                <div class="rs-info-item">
                                    <p class="rs-info-label">Kondisi Kendaraan</p>
                                    @php
                                        $condMap = [
                                            'excellent' => ['class' => 'rs-cond-excellent', 'label' => 'Sangat Baik'],
                                            'good' => ['class' => 'rs-cond-good', 'label' => 'Baik'],
                                            'fair' => ['class' => 'rs-cond-fair', 'label' => 'Cukup'],
                                            'poor' => ['class' => 'rs-cond-poor', 'label' => 'Buruk'],
                                        ];
                                        $cond = $condMap[$return->condition] ?? [
                                            'class' => 'rs-cond-fair',
                                            'label' => ucfirst($return->condition ?? '-'),
                                        ];
                                    @endphp
                                    <span class="rs-condition {{ $cond['class'] }}">{{ $cond['label'] }}</span>
                                </div>
                                <div class="rs-info-item">
                                    <p class="rs-info-label">Diperiksa Oleh</p>
                                    <p class="rs-info-val">{{ $return->inspected_by_user->name ?? 'Admin' }}</p>
                                    <p style="font-size:11px; color:#6c757d;">
                                        {{ \Carbon\Carbon::parse($return->inspected_at)->translatedFormat('d M Y, H:i') }}
                                    </p>
                                </div>
                            </div>

                            @if ($return->admin_notes)
                                <hr class="rs-divider">
                                <p class="rs-info-label" style="margin-bottom:8px;">Catatan Inspektor</p>
                                <div class="rs-quote">{{ $return->admin_notes }}</div>
                            @endif

                            @if ($return->damage_description)
                                <hr class="rs-divider">
                                <p class="rs-info-label" style="margin-bottom:8px; color:#be123c;">⚠ Laporan Kerusakan</p>
                                <div class="rs-quote-danger" style="white-space:pre-line;">
                                    {{ $return->damage_description }}</div>

                                @if ($return->damage_photos)
                                    <div class="rs-photos">
                                        @foreach (json_decode($return->damage_photos) as $photo)
                                            <a href="{{ asset('storage/' . $photo) }}" target="_blank"
                                                class="rs-photo-link">
                                                <img src="{{ asset('storage/' . $photo) }}" alt="Foto kerusakan">
                                            </a>
                                        @endforeach
                                    </div>
                                @endif
                            @endif

                        </div>
                    </div>
                @endif

            </div>

            {{-- RIGHT COLUMN --}}
            <div class="rs-col">

                {{-- Ringkasan Keuangan --}}
                <div class="rs-card">
                    <div class="rs-card-header">💰 Ringkasan Keuangan</div>
                    <div class="rs-card-body">
                        <div class="rs-fin-row">
                            <span class="rs-fin-label">Biaya Sewa</span>
                            <span class="rs-fin-val">Rp
                                {{ number_format($return->booking->total_price, 0, ',', '.') }}</span>
                        </div>
                        <div style="padding: 4px 0 8px; border-top: 1px solid #f1f3f5;">
                            <span style="font-size:11px; color:#6c757d;">{{ $return->booking->total_days }} hari</span>
                        </div>

                        @if ($return->late_fee > 0)
                            <div class="rs-fin-row">
                                <span class="rs-fin-label" style="color:#92400e;">⏰ Denda Keterlambatan</span>
                                <span class="rs-fin-val" style="color:#92400e;">Rp
                                    {{ number_format($return->late_fee, 0, ',', '.') }}</span>
                            </div>
                            <div style="font-size:11px; color:#6c757d; padding-bottom:8px; border-top:1px solid #f1f3f5;">
                                {{ $return->late_days }} hari × 20%
                            </div>
                        @endif

                        @if ($return->damage_fee > 0)
                            <div class="rs-fin-row">
                                <span class="rs-fin-label" style="color:#991b1b;">🔧 Biaya Perbaikan</span>
                                <span class="rs-fin-val" style="color:#991b1b;">Rp
                                    {{ number_format($return->damage_fee, 0, ',', '.') }}</span>
                            </div>
                        @endif

                        <div class="rs-fin-total">
                            <span class="rs-fin-total-label">Total Denda</span>
                            <span class="rs-fin-total-val {{ $return->total_penalty > 0 ? 'text' : '' }}"
                                style="color: {{ $return->total_penalty > 0 ? '#dc2626' : '#059669' }}">
                                Rp {{ number_format($return->total_penalty, 0, ',', '.') }}
                            </span>
                        </div>

                        <hr class="rs-divider">
                        @if ($return->total_penalty > 0)
                            <div class="rs-notice rs-notice-warning">
                                ⚠ Pelanggan dikenakan denda <strong>Rp
                                    {{ number_format($return->total_penalty, 0, ',', '.') }}</strong>
                            </div>
                        @else
                            <div class="rs-notice rs-notice-success">
                                ✔ Tidak ada denda yang dikenakan
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Aksi --}}
                @if (in_array($return->status, ['return_pending', 'scheduled']))
                    <div class="rs-card">
                        <div class="rs-card-header">⚙ Aksi</div>
                        <div class="rs-card-body">
                            <a href="{{ route('admin.returns.inspect', $return->id) }}" class="rs-btn-primary">
                                📋 Proses Inspeksi
                            </a>
                            <form action="{{ route('admin.returns.cancel', $return->id) }}" method="POST"
                                onsubmit="return confirm('Yakin ingin membatalkan pengembalian ini?')">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="rs-btn-danger">✖ Batalkan Pengembalian</button>
                            </form>
                        </div>
                    </div>
                @endif

                {{-- Info --}}
                <div class="rs-card" style="background:#f8f9ff; border-color:#e0e7ff;">
                    <div class="rs-card-body">
                        <div style="display:flex; align-items:center; gap:10px; margin-bottom:10px;">
                            <div
                                style="width:36px; height:36px; border-radius:8px; background:#eef2ff; display:flex; align-items:center; justify-content:center; font-size:16px;">
                                ℹ</div>
                            <span style="font-size:13px; font-weight:600; color:#212529;">Informasi</span>
                        </div>
                        <p style="font-size:12px; color:#6c757d; line-height:1.7; margin:0;">
                            Pengembalian ini terhubung dengan Booking
                            <strong
                                style="color:#6366f1;">#{{ str_pad($return->booking->id, 6, '0', STR_PAD_LEFT) }}</strong>.
                            Pastikan kondisi kendaraan diperiksa dengan teliti sebelum menyelesaikan inspeksi.
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        @if (session('success'))
            setTimeout(function() {
                const el = document.querySelector('.rs-alert');
                if (el) {
                    el.style.transition = 'opacity 0.5s';
                    el.style.opacity = '0';
                    setTimeout(() => el.remove(), 500);
                }
            }, 4000);
        @endif
    </script>
@endpush
