@extends('layouts.front')

@section('content')
    {{-- Hero Section --}}
    <section class="hero-wrap hero-wrap-2 js-fullheight"
        style="background-image: url('{{ asset('frontend/images/bg_3.jpg') }}');" data-stellar-background-ratio="0.5">
        <div class="overlay"></div>
        <div class="container">
            <div class="row no-gutters slider-text js-fullheight align-items-end justify-content-start">
                <div class="col-md-9 ftco-animate pb-5">
                    <p class="breadcrumbs">
                        <span class="mr-2"><a href="{{ route('welcome') }}">Beranda <i
                                    class="ion-ios-arrow-forward"></i></a></span>
                        <span>Riwayat Booking <i class="ion-ios-arrow-forward"></i></span>
                    </p>
                    <h1 class="mb-3 bread">Riwayat Booking Saya</h1>
                </div>
            </div>
        </div>
    </section>

    {{-- History Section --}}
    <section class="ftco-section bg-light">
        <div class="container">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <i class="fa fa-check-circle mr-2"></i>{{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <i class="fa fa-exclamation-circle mr-2"></i>{{ session('error') }}
                </div>
            @endif
            @if (session('info'))
                <div class="alert alert-info alert-dismissible fade show">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <i class="fa fa-info-circle mr-2"></i>{{ session('info') }}
                </div>
            @endif
            @if (session('warning'))
                <div class="alert alert-warning alert-dismissible fade show">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <i class="fa fa-exclamation-triangle mr-2"></i>{{ session('warning') }}
                </div>
            @endif

            {{-- Stats Cards: 2 kolom di HP, 4 kolom di desktop --}}
            <div class="row mb-4">
                <div class="col-6 col-md-3 mb-3">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body text-center py-3">
                            <i class="fa fa-calendar-check text-primary mb-2 stat-icon"></i>
                            <h3 class="mb-1 font-weight-bold">{{ $bookings->where('status', 'confirmed')->count() }}</h3>
                            <p class="mb-0 text-muted stat-label">Dikonfirmasi</p>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3 mb-3">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body text-center py-3">
                            <i class="fa fa-clock text-warning mb-2 stat-icon"></i>
                            <h3 class="mb-1 font-weight-bold">{{ $bookings->where('status', 'pending')->count() }}</h3>
                            <p class="mb-0 text-muted stat-label">Menunggu</p>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3 mb-3">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body text-center py-3">
                            <i class="fa fa-check-double text-success mb-2 stat-icon"></i>
                            <h3 class="mb-1 font-weight-bold">{{ $bookings->where('status', 'completed')->count() }}</h3>
                            <p class="mb-0 text-muted stat-label">Selesai</p>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3 mb-3">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body text-center py-3">
                            <i class="fa fa-ban text-danger mb-2 stat-icon"></i>
                            <h3 class="mb-1 font-weight-bold">{{ $bookings->where('status', 'cancelled')->count() }}</h3>
                            <p class="mb-0 text-muted stat-label">Dibatalkan</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Booking List --}}
            @if ($bookings->count() > 0)
                <div class="row">
                    @foreach ($bookings as $booking)
                        <div class="col-12 mb-4">
                            <div class="card border-0 shadow-sm booking-card">
                                <div class="card-body p-3 p-md-4">

                                    {{-- MOBILE LAYOUT: Stack vertikal --}}
                                    {{-- DESKTOP LAYOUT: row 3 kolom --}}

                                    @php
                                        $vehicleImg = $booking->kendaraan->images->where('is_primary', 1)->first()
                                            ? asset('storage/' . $booking->kendaraan->images->where('is_primary', 1)->first()->image_path)
                                            : asset('frontend/images/car-1.jpg');

                                        $statusLabels = [
                                            'confirmed' => 'Dikonfirmasi',
                                            'pending'   => 'Menunggu',
                                            'completed' => 'Selesai',
                                            'cancelled' => 'Dibatalkan',
                                        ];
                                        $statusColors = [
                                            'confirmed' => 'success',
                                            'pending'   => 'warning',
                                            'completed' => 'info',
                                            'cancelled' => 'secondary',
                                        ];
                                        $paymentLabels = [
                                            'paid'    => 'Lunas',
                                            'pending' => 'Menunggu',
                                            'failed'  => 'Gagal',
                                        ];
                                        $paymentColors = [
                                            'paid'    => 'success',
                                            'pending' => 'warning',
                                            'failed'  => 'danger',
                                        ];
                                        $methodLabels = [
                                            'cash'     => 'Tunai',
                                            'transfer' => 'Transfer Bank',
                                            'e_wallet' => 'E-Wallet',
                                            'midtrans' => 'Midtrans',
                                        ];
                                    @endphp

                                    <div class="booking-layout">
                                        {{-- [1] Gambar Kendaraan --}}
                                        <div class="booking-img-col">
                                            <div class="bk-img-wrapper">
                                                <img src="{{ $vehicleImg }}"
                                                    alt="{{ $booking->kendaraan->brand }}"
                                                    class="bk-img">
                                            </div>
                                        </div>

                                        {{-- [2] Detail Booking --}}
                                        <div class="booking-detail-col">
                                            {{-- Nama + Badge Status --}}
                                            <div class="bk-title-row">
                                                <div>
                                                    <h5 class="font-weight-bold mb-1 bk-vehicle-name">
                                                        {{ $booking->kendaraan->brand }} {{ $booking->kendaraan->model }}
                                                    </h5>
                                                    <p class="text-muted mb-0 small">
                                                        <i class="fa fa-hashtag mr-1"></i>ID:
                                                        <strong>#{{ str_pad($booking->id, 6, '0', STR_PAD_LEFT) }}</strong>
                                                    </p>
                                                </div>
                                                <span class="badge badge-{{ $statusColors[$booking->status] ?? 'secondary' }} status-badge">
                                                    {{ $statusLabels[$booking->status] ?? ucfirst($booking->status) }}
                                                </span>
                                            </div>

                                            {{-- Tanggal & Durasi --}}
                                            <div class="row mt-2">
                                                <div class="col-6 col-md-4 mb-2">
                                                    <small class="text-muted d-block"><i class="fa fa-calendar mr-1"></i>Mulai</small>
                                                    <strong class="small-date">{{ \Carbon\Carbon::parse($booking->start_date)->locale('id')->isoFormat('D MMM Y') }}</strong>
                                                </div>
                                                <div class="col-6 col-md-4 mb-2">
                                                    <small class="text-muted d-block"><i class="fa fa-calendar mr-1"></i>Selesai</small>
                                                    <strong class="small-date">{{ \Carbon\Carbon::parse($booking->end_date)->locale('id')->isoFormat('D MMM Y') }}</strong>
                                                </div>
                                                <div class="col-6 col-md-4 mb-2">
                                                    <small class="text-muted d-block"><i class="fa fa-clock mr-1"></i>Durasi</small>
                                                    <strong>{{ $booking->total_days }} hari</strong>
                                                </div>
                                                @if ($booking->payment)
                                                    <div class="col-6 col-md-4 mb-2">
                                                        <small class="text-muted d-block"><i class="fa fa-credit-card mr-1"></i>Pembayaran</small>
                                                        <span class="badge badge-{{ $paymentColors[$booking->payment->payment_status] ?? 'secondary' }}">
                                                            {{ $paymentLabels[$booking->payment->payment_status] ?? ucfirst($booking->payment->payment_status) }}
                                                        </span>
                                                    </div>
                                                @endif
                                            </div>

                                            @if ($booking->pickup_location)
                                                <div class="mt-2 p-2 bg-light rounded">
                                                    <small class="text-muted">
                                                        <i class="fa fa-map-marker-alt mr-1"></i>Lokasi Penjemputan:
                                                    </small>
                                                    <strong class="small">{{ $booking->pickup_location }}</strong>
                                                </div>
                                            @endif
                                        </div>

                                        {{-- [3] Harga & Aksi --}}
                                        <div class="booking-action-col">
                                            {{-- Total Harga --}}
                                            <div class="price-section mb-3">
                                                <small class="text-muted d-block mb-1">Total Harga</small>
                                                <h4 class="text-primary font-weight-bold mb-0 price-text">
                                                    Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                                                </h4>
                                            </div>

                                            {{-- Tombol Aksi --}}
                                            <div class="bk-action-btns">
                                                <a href="{{ route('bookings.show', $booking->id) }}"
                                                    class="btn btn-primary btn-sm bk-btn">
                                                    <i class="fa fa-file-invoice mr-1"></i>Lihat Bukti
                                                </a>

                                                @if ($booking->status == 'pending' && !$booking->payment)
                                                    <a href="{{ route('payments.create', $booking->id) }}"
                                                        class="btn btn-success btn-sm bk-btn">
                                                        <i class="fa fa-credit-card mr-1"></i>Bayar
                                                    </a>
                                                    <button type="button" class="btn btn-danger btn-sm bk-btn"
                                                        onclick="confirmCancel({{ $booking->id }})">
                                                        <i class="fa fa-times-circle mr-1"></i>Batalkan
                                                    </button>
                                                @endif

                                                @if ($booking->status == 'completed' && !$booking->review)
                                                    <a href="{{ route('reviews.create', $booking->id) }}"
                                                        class="btn btn-warning btn-sm bk-btn">
                                                        <i class="fa fa-star mr-1"></i>Ulasan
                                                    </a>
                                                @endif

                                                @if ($booking->review)
                                                    <div class="badge badge-success p-2 d-block text-center">
                                                        <i class="fa fa-check-circle mr-1"></i>Ulasan Terkirim
                                                    </div>
                                                @endif
                                            </div>

                                            {{-- Hidden form cancel --}}
                                            <form id="cancelForm{{ $booking->id }}"
                                                action="{{ route('bookings.cancel', $booking->id) }}" method="POST"
                                                style="display:none;">
                                                @csrf
                                                @method('PUT')
                                            </form>
                                        </div>
                                    </div>

                                    {{-- Footer Info --}}
                                    <div class="border-top pt-2 mt-3">
                                        <div class="bk-footer-row text-muted small">
                                            <span>
                                                <i class="fa fa-clock mr-1"></i>
                                                Dibuat: {{ $booking->created_at->locale('id')->isoFormat('D MMM Y, HH:mm') }}
                                            </span>
                                            @if ($booking->payment)
                                                <span>
                                                    <i class="fa fa-money-bill-wave mr-1"></i>
                                                    {{ $methodLabels[$booking->payment->payment_method] ?? ucfirst(str_replace('_', ' ', $booking->payment->payment_method)) }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="row">
                    <div class="col-12">
                        <div class="d-flex justify-content-center">
                            {{ $bookings->links() }}
                        </div>
                    </div>
                </div>
            @else
                {{-- Empty State --}}
                <div class="row">
                    <div class="col-12">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body text-center py-5">
                                <i class="fa fa-inbox text-muted mb-3" style="font-size: 4rem;"></i>
                                <h4 class="mb-3">Belum Ada Riwayat Booking</h4>
                                <p class="text-muted mb-4">Anda belum melakukan booking apapun. Mulai jelajahi kendaraan kami!</p>
                                <a href="{{ route('welcome') }}" class="btn btn-primary px-5">
                                    <i class="fa fa-car mr-2"></i>Lihat Kendaraan
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection

@push('styles')
<style>
    /* ===== STATS CARD ===== */
    .stat-icon { font-size: 1.6rem; display: block; }
    .stat-label { font-size: 0.82rem; }

    @media (max-width: 400px) {
        .stat-icon  { font-size: 1.3rem; }
        .stat-label { font-size: 0.75rem; }
        .card-body.py-3 { padding-top: 10px !important; padding-bottom: 10px !important; }
        .card-body h3 { font-size: 1.3rem; }
    }

    /* ===== BOOKING CARD LAYOUT ===== */
    /* Mobile-first: stack vertikal */
    .booking-layout {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    /* Desktop: 3 kolom berdampingan */
    @media (min-width: 768px) {
        .booking-layout {
            flex-direction: row;
            align-items: flex-start;
            gap: 16px;
        }
        .booking-img-col    { flex: 0 0 22%; max-width: 22%; }
        .booking-detail-col { flex: 1; }
        .booking-action-col { flex: 0 0 22%; max-width: 22%; text-align: right; }
    }

    /* ===== GAMBAR KENDARAAN - TIDAK TERPOTONG ===== */
    .bk-img-wrapper {
        width: 100%;
        border-radius: 8px;
        overflow: hidden;
        background: #f8f9fa;
    }

    /* Mobile: gambar melebar penuh, tinggi otomatis */
    .bk-img {
        width: 100%;
        height: auto;
        display: block;
        object-fit: contain;
        max-height: 220px;
        transition: transform 0.3s ease;
    }

    /* Desktop: tinggi tetap dengan cover */
    @media (min-width: 768px) {
        .bk-img {
            height: 160px;
            object-fit: cover;
        }
        .booking-card:hover .bk-img {
            transform: scale(1.05);
        }
    }

    /* ===== NAMA KENDARAAN & TITLE ROW ===== */
    .bk-title-row {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 8px;
        flex-wrap: wrap;
    }

    .bk-vehicle-name {
        font-size: 1rem;
        word-break: break-word;
        line-height: 1.3;
    }

    .status-badge {
        white-space: nowrap;
        font-size: 0.78rem;
        padding: 5px 10px;
        flex-shrink: 0;
    }

    /* ===== TANGGAL - TIDAK OVERFLOW ===== */
    .small-date {
        font-size: 0.85rem;
        word-break: break-word;
    }

    /* ===== HARGA ===== */
    .price-section {
        padding: 12px;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-radius: 8px;
    }

    .price-text {
        font-size: 1.1rem;
        word-break: break-all;
    }

    @media (min-width: 768px) {
        .price-text { font-size: 1.2rem; }
    }

    /* ===== TOMBOL AKSI ===== */
    /* Mobile: tombol wrap horizontal */
    .bk-action-btns {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
    }

    .bk-btn {
        flex: 1 1 auto;
        min-width: 80px;
        font-size: 0.82rem;
        padding: 6px 10px;
        margin: 0 !important;
        white-space: nowrap;
    }

    /* Desktop: stack vertikal, full lebar */
    @media (min-width: 768px) {
        .bk-action-btns {
            flex-direction: column;
        }
        .bk-btn {
            width: 100%;
            flex: none;
        }
    }

    /* ===== FOOTER ROW INFO ===== */
    .bk-footer-row {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        justify-content: space-between;
    }

    .bk-footer-row span {
        font-size: 0.8rem;
    }

    /* ===== BOOKING CARD HOVER ===== */
    .booking-card {
        border-radius: 10px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    @media (min-width: 768px) {
        .booking-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 28px rgba(0,0,0,0.12) !important;
        }
    }

    /* ===== PADDING CONTAINER DI HP ===== */
    @media (max-width: 576px) {
        .ftco-section .container {
            padding-left: 12px;
            padding-right: 12px;
        }
        .card-body.p-3 { padding: 12px !important; }
    }

    /* ===== PAGINATION ===== */
    .pagination { margin-top: 1.5rem; }

    .page-link {
        color: #1089ff;
        border: 1px solid #dee2e6;
        padding: 7px 14px;
        margin: 0 2px;
        border-radius: 5px;
    }

    .page-link:hover {
        background-color: #1089ff;
        color: white;
        border-color: #1089ff;
    }

    .page-item.active .page-link {
        background-color: #1089ff;
        border-color: #1089ff;
    }

    /* Badge umum */
    .badge { font-weight: 500; letter-spacing: 0.3px; }

    .card { border-radius: 10px; }
</style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmCancel(bookingId) {
            Swal.fire({
                title: 'Batalkan Booking?',
                html: `
                    <p>Apakah Anda yakin ingin membatalkan booking ini?</p>
                    <p class="text-danger mb-0"><strong>Tindakan ini tidak dapat dibatalkan!</strong></p>
                `,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Batalkan',
                cancelButtonText: 'Tidak',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('cancelForm' + bookingId).submit();
                }
            });
        }
    </script>
@endpush