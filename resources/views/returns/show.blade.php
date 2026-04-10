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
                        <span class="mr-2"><a href="{{ route('bookings.history') }}">Booking <i
                                    class="ion-ios-arrow-forward"></i></a></span>
                        <span>Bukti Pengembalian <i class="ion-ios-arrow-forward"></i></span>
                    </p>
                    <h1 class="mb-3 bread">Bukti Pengembalian Kendaraan</h1>
                </div>
            </div>
        </div>
    </section>

    {{-- Receipt Content --}}
    <section class="ftco-section bg-light">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">

                    {{-- Status Alert --}}
                    @if ($return->status === 'completed')
                        @if ($return->total_penalty > 0 && !$return->penalty_paid)
                            <div class="status-alert alert-danger-custom mb-4">
                                <i class="fa fa-exclamation-circle status-icon"></i>
                                <div>
                                    <h5 class="mb-1">Menunggu Pembayaran Denda</h5>
                                    <p class="mb-0">Total denda: Rp {{ number_format($return->total_penalty, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        @elseif ($return->total_penalty > 0 && $return->penalty_paid)
                            <div class="status-alert alert-success-custom mb-4">
                                <i class="fa fa-check-circle status-icon"></i>
                                <div>
                                    <h5 class="mb-1">Transaksi Selesai!</h5>
                                    <p class="mb-0">Pengembalian dan pembayaran denda selesai pada
                                        {{ \Carbon\Carbon::parse($return->inspected_at)->isoFormat('D MMM Y, HH:mm') }}</p>
                                </div>
                            </div>
                        @else
                            <div class="status-alert alert-success-custom mb-4">
                                <i class="fa fa-check-circle status-icon"></i>
                                <div>
                                    <h5 class="mb-1">Pengembalian Selesai!</h5>
                                    <p class="mb-0">Pengembalian kendaraan selesai pada
                                        {{ \Carbon\Carbon::parse($return->inspected_at)->isoFormat('D MMM Y, HH:mm') }}</p>
                                </div>
                            </div>
                        @endif
                    @else
                        <div class="status-alert alert-warning-custom mb-4">
                            <i class="fa fa-clock status-icon"></i>
                            <div>
                                <h5 class="mb-1">Pengembalian Dijadwalkan - Menunggu Inspeksi</h5>
                                <p class="mb-0">Dijadwalkan pada:
                                    {{ \Carbon\Carbon::parse($return->return_scheduled_date)->isoFormat('D MMM Y') }}</p>
                            </div>
                        </div>
                    @endif

                    {{-- Receipt Card --}}
                    <div class="card border-0 shadow-sm mb-4">

                        {{-- Card Header --}}
                        <div class="card-header bg-primary text-white py-3">
                            <div class="receipt-header">
                                <div>
                                    <h4 class="mb-0"><i class="fa fa-file-invoice mr-2"></i>Bukti Pengembalian</h4>
                                </div>
                                <div class="receipt-header-id">
                                    <h5 class="mb-0">#{{ str_pad($return->id, 6, '0', STR_PAD_LEFT) }}</h5>
                                    <small>ID Pengembalian</small>
                                </div>
                            </div>
                        </div>

                        <div class="card-body p-3 p-md-4">

                            {{-- Kendaraan Info --}}
                            <div class="vehicle-info-block mb-4">
                                {{-- Gambar --}}
                                @php
                                    $primaryImage = $return->booking->kendaraan->images->where('is_primary', 1)->first();
                                    $imageUrl = $primaryImage
                                        ? asset('storage/' . $primaryImage->image_path)
                                        : asset('frontend/images/car-1.jpg');
                                @endphp
                                <div class="vehicle-img-wrapper">
                                    <img src="{{ $imageUrl }}" alt="Kendaraan" class="vehicle-img-responsive">
                                </div>

                                {{-- Detail --}}
                                <div class="vehicle-info-detail">
                                    <h4 class="font-weight-bold mb-1">
                                        {{ $return->booking->kendaraan->brand }} {{ $return->booking->kendaraan->model }}
                                    </h4>
                                    <p class="text-muted mb-3">{{ $return->booking->kendaraan->plate_number }}</p>
                                    <div class="row">
                                        <div class="col-6 mb-2">
                                            <small class="text-muted d-block">ID Booking</small>
                                            <strong>#{{ str_pad($return->booking->id, 6, '0', STR_PAD_LEFT) }}</strong>
                                        </div>
                                        <div class="col-6 mb-2">
                                            <small class="text-muted d-block">Pelanggan</small>
                                            <strong class="word-break">{{ $return->booking->user->name }}</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr>

                            {{-- Detail Jadwal --}}
                            <h5 class="font-weight-bold mb-3"><i class="fa fa-calendar-alt mr-2"></i>Detail Jadwal</h5>
                            <div class="row mb-4">
                                <div class="col-6 col-md-6 mb-3">
                                    <div class="p-3 bg-light rounded h-100">
                                        <small class="text-muted d-block mb-1">Mulai Sewa</small>
                                        <strong>{{ \Carbon\Carbon::parse($return->booking->start_date)->isoFormat('D MMM Y') }}</strong>
                                    </div>
                                </div>
                                <div class="col-6 col-md-6 mb-3">
                                    <div class="p-3 bg-light rounded h-100">
                                        <small class="text-muted d-block mb-1">Pengembalian Diharapkan</small>
                                        <strong>{{ \Carbon\Carbon::parse($return->booking->end_date)->isoFormat('D MMM Y') }}</strong>
                                    </div>
                                </div>
                                <div class="col-6 col-md-6 mb-3">
                                    <div class="p-3 bg-info text-white rounded h-100">
                                        <small class="d-block mb-1">Pengembalian Dijadwalkan</small>
                                        <strong>{{ \Carbon\Carbon::parse($return->return_scheduled_date)->isoFormat('D MMM Y, HH:mm') }}</strong>
                                    </div>
                                </div>
                                @if ($return->return_actual_date)
                                    <div class="col-6 col-md-6 mb-3">
                                        <div class="p-3 bg-success text-white rounded h-100">
                                            <small class="d-block mb-1">Pengembalian Aktual</small>
                                            <strong>
                                                {{ $return->return_scheduled_time
                                                    ? \Carbon\Carbon::parse($return->return_scheduled_time)->format('H:i') . ' WIB'
                                                    : '-' }}
                                            </strong>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            @if ($return->customer_notes)
                                <div class="alert alert-info mb-4">
                                    <h6 class="mb-2"><i class="fa fa-sticky-note mr-2"></i>Catatan Anda</h6>
                                    <p class="mb-0">{{ $return->customer_notes }}</p>
                                </div>
                            @endif

                            @if ($return->status === 'completed')
                                <hr>

                                {{-- Hasil Inspeksi --}}
                                <h5 class="font-weight-bold mb-3"><i class="fa fa-clipboard-check mr-2"></i>Hasil Inspeksi</h5>

                                <div class="row mb-4">
                                    <div class="col-md-6 mb-3">
                                        <div class="card border-0 bg-light h-100">
                                            <div class="card-body">
                                                <small class="text-muted d-block mb-2">Kondisi Kendaraan</small>
                                                @php
                                                    $conditionMap = [
                                                        'excellent' => ['badge' => 'success', 'label' => 'Sangat Baik'],
                                                        'good'      => ['badge' => 'info',    'label' => 'Baik'],
                                                        'fair'      => ['badge' => 'warning',  'label' => 'Cukup'],
                                                        'poor'      => ['badge' => 'danger',   'label' => 'Buruk'],
                                                    ];
                                                    $condition = $conditionMap[$return->condition] ?? [
                                                        'badge' => 'secondary',
                                                        'label' => ucfirst($return->condition),
                                                    ];
                                                @endphp
                                                <span class="badge badge-{{ $condition['badge'] }} badge-lg px-3 py-2">
                                                    {{ $condition['label'] }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="card border-0 bg-light h-100">
                                            <div class="card-body">
                                                <small class="text-muted d-block mb-2">Diperiksa Oleh</small>
                                                <h5 class="mb-0">{{ $return->inspected_by_user->name ?? 'Admin' }}</h5>
                                                <small class="text-muted">
                                                    {{ \Carbon\Carbon::parse($return->inspected_at)->isoFormat('D MMM Y, HH:mm') }}
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @if ($return->damage_description)
                                    <div class="card border-danger mb-4">
                                        <div class="card-header bg-danger text-white">
                                            <h6 class="mb-0"><i class="fa fa-exclamation-triangle mr-2"></i>Laporan Kerusakan</h6>
                                        </div>
                                        <div class="card-body">
                                            <p class="mb-0" style="white-space: pre-line;">{{ $return->damage_description }}</p>

                                            @if ($return->damage_photos)
                                                <hr>
                                                <h6 class="mb-3">Foto Kerusakan:</h6>
                                                <div class="row">
                                                    @php $damagePhotos = json_decode($return->damage_photos); @endphp
                                                    @foreach ($damagePhotos as $index => $photo)
                                                        <div class="col-6 col-md-3 mb-3">
                                                            <a href="{{ asset('storage/' . $photo) }}" target="_blank">
                                                                <img src="{{ asset('storage/' . $photo) }}"
                                                                    class="img-fluid rounded shadow-sm damage-photo"
                                                                    alt="Foto Kerusakan {{ $index + 1 }}">
                                                            </a>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endif

                                @if ($return->admin_notes)
                                    <div class="alert alert-secondary">
                                        <h6 class="mb-2"><i class="fa fa-user-shield mr-2"></i>Catatan Inspektur</h6>
                                        <p class="mb-0">{{ $return->admin_notes }}</p>
                                    </div>
                                @endif

                                <hr>

                                {{-- Ringkasan Keuangan --}}
                                <h5 class="font-weight-bold mb-3"><i class="fa fa-money-bill-wave mr-2"></i>Ringkasan Keuangan</h5>
                                <div class="card border-0 bg-light">
                                    <div class="card-body p-2 p-md-3">
                                        <div class="table-responsive">
                                            <table class="table table-borderless mb-0 finance-table">
                                                <tr>
                                                    <td>Biaya Sewa ({{ $return->booking->total_days }} hari)</td>
                                                    <td class="text-right">
                                                        <strong>Rp {{ number_format($return->booking->total_price, 0, ',', '.') }}</strong>
                                                    </td>
                                                </tr>
                                                @if ($return->late_fee > 0)
                                                    <tr class="text-warning">
                                                        <td>
                                                            <i class="fa fa-clock mr-1"></i>Biaya Keterlambatan
                                                            <br><small class="text-muted">{{ $return->late_days }} hari × 20%</small>
                                                        </td>
                                                        <td class="text-right">
                                                            <strong>Rp {{ number_format($return->late_fee, 0, ',', '.') }}</strong>
                                                        </td>
                                                    </tr>
                                                @endif
                                                @if ($return->damage_fee > 0)
                                                    <tr class="text-danger">
                                                        <td><i class="fa fa-wrench mr-1"></i>Biaya Perbaikan Kerusakan</td>
                                                        <td class="text-right">
                                                            <strong>Rp {{ number_format($return->damage_fee, 0, ',', '.') }}</strong>
                                                        </td>
                                                    </tr>
                                                @endif
                                                <tr class="border-top font-weight-bold">
                                                    <td style="font-size: 1rem;">Total Denda</td>
                                                    <td class="text-right text-danger">
                                                        <h4 class="mb-0 text-danger">Rp {{ number_format($return->total_penalty, 0, ',', '.') }}</h4>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        {{-- Footer Tombol --}}
                        <div class="card-footer bg-light py-3">
                            <div class="action-btn-grid">
                                <a href="{{ route('bookings.history') }}" class="btn btn-secondary btn-block">
                                    <i class="fa fa-arrow-left mr-2"></i>Kembali ke Riwayat
                                </a>

                                @if ($return->status === 'completed' && $return->total_penalty > 0 && !$return->penalty_paid)
                                    <a href="{{ route('payments.penalty.create', $return->id) }}" class="btn btn-danger btn-block">
                                        <i class="fa fa-money-bill-wave mr-2"></i>Bayar Denda
                                    </a>
                                @endif

                                <button onclick="window.print()" class="btn btn-primary btn-block">
                                    <i class="fa fa-print mr-2"></i>Cetak Bukti
                                </button>

                                <a href="{{ route('bookings.show', $return->booking_id) }}" class="btn btn-info btn-block">
                                    <i class="fa fa-file-invoice mr-2"></i>Lihat Booking
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- Help Section --}}
                    <div class="card border-0 shadow-sm">
                        <div class="card-body text-center py-4">
                            <h5 class="mb-2">Butuh Bantuan?</h5>
                            <p class="text-muted mb-3">Jika Anda memiliki pertanyaan atau memerlukan bantuan, silakan hubungi kami:</p>
                            <div class="help-btn-group">
                                <a href="mailto:support@carrental.com" class="btn btn-outline-primary">
                                    <i class="fa fa-envelope mr-2"></i>Email Dukungan
                                </a>
                                <a href="tel:+6281234567890" class="btn btn-outline-success">
                                    <i class="fa fa-phone mr-2"></i>Hubungi Kami
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection

@push('styles')
<style>
    /* ===== STATUS ALERT ===== */
    .status-alert {
        display: flex;
        align-items: flex-start;
        gap: 14px;
        padding: 16px 18px;
        border-radius: 8px;
        border: none;
        box-shadow: 0 2px 8px rgba(0,0,0,0.07);
    }

    .alert-success-custom { background: #d4edda; color: #155724; }
    .alert-danger-custom  { background: #f8d7da; color: #721c24; }
    .alert-warning-custom { background: #fff3cd; color: #856404; }

    .status-icon {
        font-size: 1.8rem;
        flex-shrink: 0;
        margin-top: 2px;
    }

    .status-alert h5 { font-size: 1rem; }
    .status-alert p  { font-size: 0.9rem; }

    /* ===== RECEIPT HEADER ===== */
    .receipt-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 8px;
    }

    .receipt-header-id {
        text-align: right;
    }

    @media (max-width: 480px) {
        .receipt-header {
            flex-direction: column;
            align-items: flex-start;
        }
        .receipt-header-id {
            text-align: left;
        }
    }

    /* ===== GAMBAR KENDARAAN ===== */
    .vehicle-info-block {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .vehicle-img-wrapper {
        width: 100%;
        border-radius: 8px;
        overflow: hidden;
        background: #f8f9fa;
        box-shadow: 0 2px 6px rgba(0,0,0,0.08);
    }

    /* Mobile: tinggi otomatis agar tidak terpotong */
    .vehicle-img-responsive {
        width: 100%;
        height: auto;
        display: block;
        object-fit: contain;
        max-height: 260px;
    }

    /* Desktop: berdampingan, cover */
    @media (min-width: 768px) {
        .vehicle-info-block {
            flex-direction: row;
            align-items: flex-start;
        }

        .vehicle-img-wrapper {
            flex: 0 0 35%;
            max-width: 35%;
        }

        .vehicle-img-responsive {
            height: 200px;
            object-fit: cover;
        }

        .vehicle-info-detail {
            flex: 1;
        }
    }

    .word-break {
        word-break: break-word;
    }

    /* ===== FOTO KERUSAKAN - 2 kolom di HP ===== */
    .damage-photo {
        width: 100%;
        height: 120px;
        object-fit: cover;
        border-radius: 6px;
        transition: transform 0.2s;
        display: block;
    }

    .damage-photo:hover { transform: scale(1.03); }

    /* ===== TABEL KEUANGAN ===== */
    .finance-table td {
        padding: 8px 6px;
        vertical-align: middle;
        font-size: 0.9rem;
        /* Hapus text-nowrap agar tidak overflow di HP */
        white-space: normal;
        word-break: break-word;
    }

    .finance-table td.text-right {
        min-width: 110px;
        text-align: right;
    }

    .finance-table h4 {
        font-size: 1.2rem;
    }

    @media (max-width: 400px) {
        .finance-table td { font-size: 0.82rem; }
        .finance-table h4 { font-size: 1rem; }
    }

    /* ===== ACTION BUTTONS FOOTER ===== */
    .action-btn-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        justify-content: center;
    }

    .action-btn-grid .btn {
        flex: 1 1 calc(50% - 8px);
        min-width: 140px;
        margin: 0 !important;
    }

    @media (max-width: 480px) {
        .action-btn-grid .btn {
            flex: 1 1 100%;
        }
    }

    /* ===== HELP BUTTONS ===== */
    .help-btn-group {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 10px;
    }

    .help-btn-group .btn {
        flex: 1 1 auto;
        min-width: 160px;
        max-width: 220px;
    }

    /* ===== JADWAL BOXES DI HP ===== */
    @media (max-width: 576px) {
        .card-body {
            padding: 1rem !important;
        }

        .card-header h4 {
            font-size: 1rem;
        }

        /* Kolom jadwal: 2 per baris sudah ditangani col-6 */
        .col-6 .p-3 {
            padding: 10px !important;
            font-size: 0.85rem;
        }

        .col-6 .p-3 strong {
            font-size: 0.82rem;
            word-break: break-word;
        }

        .badge-lg {
            font-size: 0.9rem !important;
        }
    }

    /* ===== BADGE ===== */
    .badge-lg {
        font-size: 1rem;
        font-weight: 600;
    }

    .card {
        border-radius: 10px;
    }

    /* ===== PRINT ===== */
    @media print {
        body { font-size: 12px; color: #000; }

        .hero-wrap, .card-footer, .btn, nav, footer { display: none !important; }

        .container { max-width: 100% !important; padding: 0 !important; }

        .card { border: none !important; box-shadow: none !important; }

        .card-header { background: #000 !important; color: #fff !important; padding: 10px !important; }

        .card-body { padding: 10px !important; }

        h4, h5 { margin-bottom: 5px !important; }

        table { width: 100%; font-size: 12px; }

        .table td { padding: 5px !important; }

        .badge { border: 1px solid #000; color: #000 !important; background: none !important; }

        img { max-height: 120px !important; }

        hr { border-top: 1px solid #000; margin: 10px 0; }

        .card, .row, .col-md-6 { page-break-inside: avoid; }

        /* Gambar saat print */
        .vehicle-img-responsive { height: 120px !important; object-fit: cover !important; }
    }
</style>
@endpush