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
        {{-- ❌ ADA DENDA & BELUM BAYAR → JANGAN TAMPILKAN SELESAI --}}
        <div class="alert alert-danger border-0 shadow-sm mb-4">
            <div class="d-flex align-items-center">
                <i class="fa fa-exclamation-circle mr-3" style="font-size: 2rem;"></i>
                <div>
                    <h5 class="mb-1">Menunggu Pembayaran Denda</h5>
                    <p class="mb-0">
                        Total denda: Rp {{ number_format($return->total_penalty, 0, ',', '.') }}
                    </p>
                </div>
            </div>
        </div>

    @elseif ($return->total_penalty > 0 && $return->penalty_paid)
        {{-- ✅ SUDAH BAYAR DENDA --}}
        <div class="alert alert-success border-0 shadow-sm mb-4">
            <div class="d-flex align-items-center">
                <i class="fa fa-check-circle mr-3" style="font-size: 2rem;"></i>
                <div>
                    <h5 class="mb-1">Transaksi Selesai!</h5>
                    <p class="mb-0">
                        Pengembalian dan pembayaran denda telah selesai pada
                        {{ \Carbon\Carbon::parse($return->inspected_at)->isoFormat('D MMM Y, HH:mm') }}
                    </p>
                </div>
            </div>
        </div>

    @else
        {{-- ✅ TIDAK ADA DENDA --}}
        <div class="alert alert-success border-0 shadow-sm mb-4">
            <div class="d-flex align-items-center">
                <i class="fa fa-check-circle mr-3" style="font-size: 2rem;"></i>
                <div>
                    <h5 class="mb-1">Pengembalian Selesai!</h5>
                    <p class="mb-0">
                        Pengembalian kendaraan selesai pada
                        {{ \Carbon\Carbon::parse($return->inspected_at)->isoFormat('D MMM Y, HH:mm') }}
                    </p>
                </div>
            </div>
        </div>
    @endif

@else
    {{-- BELUM SELESAI --}}
    <div class="alert alert-warning border-0 shadow-sm mb-4">
        <div class="d-flex align-items-center">
            <i class="fa fa-clock mr-3" style="font-size: 2rem;"></i>
            <div>
                <h5 class="mb-1">Pengembalian Dijadwalkan - Menunggu Inspeksi</h5>
                <p class="mb-0">
                    Dijadwalkan pada:
                    {{ \Carbon\Carbon::parse($return->return_scheduled_date)->isoFormat('D MMM Y') }}
                </p>
            </div>
        </div>
    </div>
@endif

                    {{-- Receipt Card --}}
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-primary text-white py-4">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <h4 class="mb-0"><i class="fa fa-file-invoice mr-2"></i>Bukti Pengembalian</h4>
                                </div>
                                <div class="col-md-6 text-md-right">
                                    <h5 class="mb-0">#{{ str_pad($return->id, 6, '0', STR_PAD_LEFT) }}</h5>
                                    <small>ID Pengembalian</small>
                                </div>
                            </div>
                        </div>

                        <div class="card-body p-4">
                            {{-- Booking & Vehicle Info --}}
                            <div class="row mb-4">
                                <div class="col-md-4">
                                    <div class="text-center">
                                        @php
                                            $primaryImage = $return->booking->kendaraan->images
                                                ->where('is_primary', 1)
                                                ->first();
                                            $imageUrl = $primaryImage
                                                ? asset('storage/' . $primaryImage->image_path)
                                                : asset('frontend/images/car-1.jpg');
                                        @endphp
                                        <img src="{{ $imageUrl }}" alt="Kendaraan" class="img-fluid rounded shadow-sm"
                                            style="max-height: 200px; object-fit: cover;">
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <h4 class="font-weight-bold mb-2">{{ $return->booking->kendaraan->brand }}
                                        {{ $return->booking->kendaraan->model }}</h4>
                                    <p class="text-muted mb-3">{{ $return->booking->kendaraan->plate_number }}</p>

                                    <div class="row">
                                        <div class="col-6">
                                            <small class="text-muted d-block">ID Booking</small>
                                            <strong>#{{ str_pad($return->booking->id, 6, '0', STR_PAD_LEFT) }}</strong>
                                        </div>
                                        <div class="col-6">
                                            <small class="text-muted d-block">Pelanggan</small>
                                            <strong>{{ $return->booking->user->name }}</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr>

                            {{-- Schedule Details --}}
                            <h5 class="font-weight-bold mb-3"><i class="fa fa-calendar-alt mr-2"></i>Detail Jadwal</h5>
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <div class="p-3 bg-light rounded mb-3">
                                        <small class="text-muted d-block mb-1">Mulai Sewa</small>
                                        <strong>{{ \Carbon\Carbon::parse($return->booking->start_date)->isoFormat('D MMM Y') }}</strong>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="p-3 bg-light rounded mb-3">
                                        <small class="text-muted d-block mb-1">Pengembalian yang Diharapkan</small>
                                        <strong>{{ \Carbon\Carbon::parse($return->booking->end_date)->isoFormat('D MMM Y') }}</strong>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="p-3 bg-info text-white rounded mb-3">
                                        <small class="d-block mb-1">Pengembalian Dijadwalkan</small>
                                        <strong>{{ \Carbon\Carbon::parse($return->return_scheduled_date)->isoFormat('D MMM Y, HH:mm') }}</strong>
                                    </div>
                                </div>
                                @if ($return->return_actual_date)
                                    <div class="col-md-6">
                                        <div class="p-3 bg-success text-white rounded mb-3">
                                            <small class="d-block mb-1">Pengembalian Aktual</small>
                                            {{ $return->return_scheduled_time
                                                ? \Carbon\Carbon::parse($return->return_scheduled_time)->format('H:i') . ' WIB'
                                                : '-' }}
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

                                {{-- Inspection Results --}}
                                <h5 class="font-weight-bold mb-3"><i class="fa fa-clipboard-check mr-2"></i>Hasil Inspeksi
                                </h5>

                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <div class="card border-0 bg-light">
                                            <div class="card-body">
                                                <small class="text-muted d-block mb-2">Kondisi Kendaraan</small>
                                                <h4 class="mb-0">
                                                    @php
                                                        $conditionMap = [
                                                            'excellent' => [
                                                                'badge' => 'success',
                                                                'label' => 'Sangat Baik',
                                                            ],
                                                            'good' => ['badge' => 'info', 'label' => 'Baik'],
                                                            'fair' => ['badge' => 'warning', 'label' => 'Cukup'],
                                                            'poor' => ['badge' => 'danger', 'label' => 'Buruk'],
                                                        ];
                                                        $condition = $conditionMap[$return->condition] ?? [
                                                            'badge' => 'secondary',
                                                            'label' => ucfirst($return->condition),
                                                        ];
                                                    @endphp
                                                    <span
                                                        class="badge badge-{{ $condition['badge'] }} badge-lg px-3 py-2">
                                                        {{ $condition['label'] }}
                                                    </span>
                                                </h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card border-0 bg-light">
                                            <div class="card-body">
                                                <small class="text-muted d-block mb-2">Diperiksa Oleh</small>
                                                <h5 class="mb-0">{{ $return->inspected_by_user->name ?? 'Admin' }}</h5>
                                                <small
                                                    class="text-muted">{{ \Carbon\Carbon::parse($return->inspected_at)->isoFormat('D MMM Y, HH:mm') }}</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @if ($return->damage_description)
                                    <div class="card border-danger mb-4">
                                        <div class="card-header bg-danger text-white">
                                            <h6 class="mb-0"><i class="fa fa-exclamation-triangle mr-2"></i>Laporan
                                                Kerusakan</h6>
                                        </div>
                                        <div class="card-body">
                                            <p class="mb-0" style="white-space: pre-line;">
                                                {{ $return->damage_description }}</p>

                                            @if ($return->damage_photos)
                                                <hr>
                                                <h6 class="mb-3">Foto Kerusakan:</h6>
                                                <div class="row">
                                                    @php
                                                        $damagePhotos = json_decode($return->damage_photos);
                                                    @endphp
                                                    @foreach ($damagePhotos as $index => $photo)
                                                        <div class="col-md-3 mb-3">
                                                            <a href="{{ asset('storage/' . $photo) }}" target="_blank">
                                                                <img src="{{ asset('storage/' . $photo) }}"
                                                                    class="img-fluid rounded shadow-sm damage-photo"
                                                                    style="height: 150px; width: 100%; object-fit: cover; cursor: pointer;"
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

                                {{-- Financial Summary --}}
                                <h5 class="font-weight-bold mb-3"><i class="fa fa-money-bill-wave mr-2"></i>Ringkasan
                                    Keuangan</h5>
                                <div class="card border-0 bg-light">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-borderless mb-0">
                                                <tr>
                                                    <td class="text-nowrap">Biaya Sewa ({{ $return->booking->total_days }}
                                                        hari)</td>
                                                    <td class="text-right text-nowrap"><strong>Rp
                                                            {{ number_format($return->booking->total_price, 0, ',', '.') }}</strong>
                                                    </td>
                                                </tr>
                                                @if ($return->late_fee > 0)
                                                    <tr class="text-warning">
                                                        <td class="text-nowrap">
                                                            <i class="fa fa-clock mr-1"></i>Biaya Keterlambatan
                                                            <br><small class="text-muted">{{ $return->late_days }} hari ×
                                                                20%</small>
                                                        </td>
                                                        <td class="text-right text-nowrap"><strong>Rp
                                                                {{ number_format($return->late_fee, 0, ',', '.') }}</strong>
                                                        </td>
                                                    </tr>
                                                @endif
                                                @if ($return->damage_fee > 0)
                                                    <tr class="text-danger">
                                                        <td class="text-nowrap"><i class="fa fa-wrench mr-1"></i>Biaya
                                                            Perbaikan Kerusakan</td>
                                                        <td class="text-right text-nowrap"><strong>Rp
                                                                {{ number_format($return->damage_fee, 0, ',', '.') }}</strong>
                                                        </td>
                                                    </tr>
                                                @endif
                                                <tr class="border-top font-weight-bold">
                                                    <td class="text-nowrap" style="font-size: 1.1rem;">Total Denda</td>
                                                    <td class="text-right text-danger text-nowrap">
                                                        <h4 class="mb-0 text-danger" style="font-size: 1.5rem;">Rp
                                                            {{ number_format($return->total_penalty, 0, ',', '.') }}</h4>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="card-footer bg-light text-center py-3">
                            <div class="row">
                                <div class="col-md-3 mb-2 mb-md-0">
                                    <a href="{{ route('bookings.history') }}" class="btn btn-secondary btn-block">
                                        <i class="fa fa-arrow-left mr-2"></i>Kembali ke Riwayat
                                    </a>
                                </div>

                                @if ($return->status === 'completed' && $return->total_penalty > 0 && !$return->penalty_paid)
                                    <div class="col-md-3 mb-2 mb-md-0">
                                        <a href="{{ route('payments.penalty.create', $return->id) }}"
                                            class="btn btn-danger btn-block">
                                            <i class="fa fa-money-bill-wave mr-2"></i>Bayar Denda
                                        </a>
                                    </div>
                                @endif

                                <div class="col-md-3 mb-2 mb-md-0">
                                    <button onclick="window.print()" class="btn btn-primary btn-block">
                                        <i class="fa fa-print mr-2"></i>Cetak Bukti
                                    </button>
                                </div>
                                <div class="col-md-3">
                                    <a href="{{ route('bookings.show', $return->booking_id) }}"
                                        class="btn btn-info btn-block">
                                        <i class="fa fa-file-invoice mr-2"></i>Lihat Booking
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Help Section --}}
                    <div class="card border-0 shadow-sm">
                        <div class="card-body text-center py-4">
                            <h5 class="mb-2">Butuh Bantuan?</h5>
                            <p class="text-muted mb-3">Jika Anda memiliki pertanyaan tentang pengembalian ini atau
                                memerlukan bantuan, silakan hubungi kami:</p>
                            <div class="d-flex justify-content-center flex-wrap">
                                <a href="mailto:support@carrental.com" class="btn btn-outline-primary m-2">
                                    <i class="fa fa-envelope mr-2"></i>Email Dukungan
                                </a>
                                <a href="tel:+6281234567890" class="btn btn-outline-success m-2">
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
        .badge-lg {
            font-size: 1rem;
            font-weight: 600;
        }

        .card {
            border-radius: 10px;
        }

        .bg-light {
            background-color: #f8f9fa !important;
        }

        .damage-photo {
            transition: transform 0.2s;
        }

        .damage-photo:hover {
            transform: scale(1.05);
        }

        /* Print Styles */
       @media print {

    body {
        font-size: 12px;
        color: #000;
    }

    .hero-wrap,
    .card-footer,
    .btn,
    nav,
    footer {
        display: none !important;
    }

    .container {
        max-width: 100% !important;
        padding: 0 !important;
    }

    .card {
        border: none !important;
        box-shadow: none !important;
    }

    .card-header {
        background: #000 !important;
        color: #fff !important;
        padding: 10px !important;
    }

    .card-body {
        padding: 10px !important;
    }

    h4, h5 {
        margin-bottom: 5px !important;
    }

    table {
        width: 100%;
        font-size: 12px;
    }

    .table td {
        padding: 5px !important;
    }

    .badge {
        border: 1px solid #000;
        color: #000 !important;
        background: none !important;
    }

    img {
        max-height: 120px !important;
    }

    /* Tambahan garis pemisah */
    hr {
        border-top: 1px solid #000;
        margin: 10px 0;
    }

    /* Supaya tidak kepotong */
    .card, .row, .col-md-6 {
        page-break-inside: avoid;
    }

    /* Judul besar */
    .print-title {
        text-align: center;
        margin-bottom: 10px;
    }

    .print-title h2 {
        margin: 0;
        font-size: 18px;
    }

    .print-title p {
        margin: 0;
        font-size: 12px;
    }
}
    </style>
@endpush
