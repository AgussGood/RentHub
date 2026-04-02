@extends('layouts.front')
@section('content')
    <section class="hero-wrap hero-wrap-2 js-fullheight"
        style="background-image: url('{{ asset('frontend/images/bg_3.jpg') }}');" data-stellar-background-ratio="0.5">
        <div class="overlay"></div>
        <div class="container">
            <div class="row no-gutters slider-text js-fullheight align-items-end justify-content-start">
                <div class="col-md-9 ftco-animate pb-5">
                    <p class="breadcrumbs">
                        <span class="mr-2"><a href="{{ route('welcome') }}">Beranda <i
                                    class="ion-ios-arrow-forward"></i></a></span>
                        <span>Bukti Booking <i class="ion-ios-arrow-forward"></i></span>
                    </p>
                    <h1 class="mb-3 bread">Konfirmasi Booking</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="ftco-section bg-light">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show shadow-sm">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <i class="fa fa-check-circle mr-2"></i>{{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show shadow-sm">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <i class="fa fa-exclamation-circle mr-2"></i>{{ session('error') }}
                        </div>
                    @endif

                    @if (session('info'))
                        <div class="alert alert-info alert-dismissible fade show shadow-sm">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <i class="fa fa-info-circle mr-2"></i>{{ session('info') }}
                        </div>
                    @endif

                    {{-- Banner Sukses (hanya tampil jika status confirmed dan ada payment) --}}
                    @if ($booking->status === 'confirmed' && $booking->payment)
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-body text-center py-5"
                                style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                <div class="success-icon mb-3">
                                    <i class="fa fa-check-circle text-white" style="font-size: 64px;"></i>
                                </div>
                                <h2 class="text-white mb-2">Pembayaran Berhasil!</h2>
                                <p class="text-white mb-0 lead">Booking Anda telah dikonfirmasi. Terima kasih telah menggunakan layanan kami.</p>
                            </div>
                        </div>
                    @endif

                    {{-- Banner Dibatalkan --}}
                    @if ($booking->status === 'cancelled')
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-body text-center py-5"
                                style="background: linear-gradient(135deg, #f56565 0%, #c53030 100%);">
                                <div class="success-icon mb-3">
                                    <i class="fa fa-times-circle text-white" style="font-size: 64px;"></i>
                                </div>
                                <h2 class="text-white mb-2">Booking Dibatalkan</h2>
                                <p class="text-white mb-0 lead">Booking ini telah dibatalkan.</p>
                            </div>
                        </div>
                    @endif

                    {{-- Kartu Bukti --}}
                    <div class="card border-0 shadow-lg">
                        {{-- Header --}}
                        <div class="card-header bg-white border-0 pt-4 pb-3">
                            <div class="text-center">
                                <h3 class="mb-2 font-weight-bold">Bukti Booking</h3>
                                <div class="d-inline-block px-4 py-2 bg-light rounded">
                                    <span class="text-muted">ID Booking:</span>
                                    <strong class="text-primary ml-2"
                                        style="font-size: 1.1rem;">#{{ str_pad($booking->id, 6, '0', STR_PAD_LEFT) }}</strong>
                                </div>
                            </div>
                        </div>

                        <div class="card-body px-4 px-md-5 py-4">
                            {{-- Informasi Pelanggan & Rental --}}
                            <div class="row mb-4">
                                <div class="col-md-6 mb-4 mb-md-0">
                                    <div class="info-section">
                                        <h5 class="section-title mb-3">
                                            <i class="fa fa-user-circle text-primary mr-2"></i>Informasi Pelanggan
                                        </h5>
                                        <div class="pl-4">
                                            <div class="info-row mb-2">
                                                <small class="text-muted d-block">Nama Lengkap</small>
                                                <strong>{{ $booking->user->name }}</strong>
                                            </div>
                                            <div class="info-row mb-2">
                                                <small class="text-muted d-block">Alamat Email</small>
                                                <strong>{{ $booking->user->email }}</strong>
                                            </div>
                                            <div class="info-row">
                                                <small class="text-muted d-block">Nomor Telepon</small>
                                                <strong>{{ $booking->user->phone ?? 'Tidak tersedia' }}</strong>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="info-section">
                                        <h5 class="section-title mb-3">
                                            <i class="fa fa-calendar-alt text-success mr-2"></i>Periode Sewa
                                        </h5>
                                        <div class="pl-4">
                                            <div class="info-row mb-2">
                                                <small class="text-muted d-block">Tanggal Mulai</small>
                                                <strong>{{ \Carbon\Carbon::parse($booking->start_date)->isoFormat('D MMMM Y') }}</strong>
                                            </div>
                                            <div class="info-row mb-2">
                                                <small class="text-muted d-block">Tanggal Selesai</small>
                                                <strong>{{ \Carbon\Carbon::parse($booking->end_date)->isoFormat('D MMMM Y') }}</strong>
                                            </div>
                                            <div class="info-row mb-2">
                                                <small class="text-muted d-block">Durasi</small>
                                                <span class="badge badge-primary px-3 py-2">{{ $booking->total_days }} hari</span>
                                            </div>
                                            @if ($booking->pickup_location)
                                                <div class="info-row">
                                                    <small class="text-muted d-block">Lokasi Pengambilan</small>
                                                    <strong>{{ $booking->pickup_location }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr class="my-4">

                            {{-- Informasi Kendaraan --}}
                            <div class="info-section mb-4">
                                <h5 class="section-title mb-3">
                                    <i class="fa fa-car text-info mr-2"></i>Informasi Kendaraan
                                </h5>
                                <div class="row align-items-center pl-4">
                                    <div class="col-md-5 mb-3 mb-md-0">
                                        <div class="vehicle-image rounded overflow-hidden shadow-sm"
                                            style="height: 200px; background: #f8f9fa;">
                                            @php
                                                $primaryImage = $booking->kendaraan->images->where('is_primary', 1)->first();
                                                $imageUrl = $primaryImage 
                                                    ? asset('storage/' . $primaryImage->image_path)
                                                    : asset('frontend/images/car-1.jpg');
                                            @endphp
                                            <img src="{{ $imageUrl }}"
                                                alt="{{ $booking->kendaraan->brand }}"
                                                style="width: 100%; height: 100%; object-fit: cover;">
                                        </div>
                                    </div>
                                    <div class="col-md-7">
                                        <h4 class="font-weight-bold mb-3">{{ $booking->kendaraan->brand }}
                                            {{ $booking->kendaraan->model }}</h4>
                                        <div class="row">
                                            <div class="col-6 mb-3">
                                                <small class="text-muted d-block">Tahun</small>
                                                <strong>{{ $booking->kendaraan->year }}</strong>
                                            </div>
                                            <div class="col-6 mb-3">
                                                <small class="text-muted d-block">Tipe</small>
                                                <span class="badge badge-info">
                                                    @php
                                                        $typeTranslations = [
                                                            'car' => 'Mobil',
                                                            'motorcycle' => 'Motor',
                                                            'suv' => 'SUV',
                                                            'mpv' => 'MPV',
                                                            'sedan' => 'Sedan'
                                                        ];
                                                        echo $typeTranslations[$booking->kendaraan->type] ?? ucfirst($booking->kendaraan->type);
                                                    @endphp
                                                </span>
                                            </div>
                                            <div class="col-6 mb-3">
                                                <small class="text-muted d-block">Nomor Plat</small>
                                                <span class="badge badge-dark">{{ $booking->kendaraan->plate_number }}</span>
                                            </div>
                                            <div class="col-6 mb-3">
                                                <small class="text-muted d-block">Warna</small>
                                                <strong>{{ $booking->kendaraan->color ?? 'N/A' }}</strong>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr class="my-4">

                            {{-- Detail Pembayaran & Status --}}
                            <div class="row mb-4">
                                <div class="col-md-6 mb-4 mb-md-0">
                                    <div class="info-section">
                                        <h5 class="section-title mb-3">
                                            <i class="fa fa-credit-card text-warning mr-2"></i>Detail Pembayaran
                                        </h5>
                                        @if ($booking->payment)
                                            <div class="pl-4">
                                                <div class="info-row mb-2">
                                                    <small class="text-muted d-block">Metode Pembayaran</small>
                                                    <strong class="text-capitalize">
                                                        @php
                                                            $methodTranslations = [
                                                                'cash' => 'Tunai',
                                                                'transfer' => 'Transfer Bank',
                                                                'e_wallet' => 'E-Wallet',
                                                                'midtrans' => 'Midtrans'
                                                            ];
                                                            echo $methodTranslations[$booking->payment->payment_method] ?? str_replace('_', ' ', $booking->payment->payment_method);
                                                        @endphp
                                                    </strong>
                                                </div>
                                                <div class="info-row mb-2">
                                                    <small class="text-muted d-block">Tanggal Pembayaran</small>
                                                    <strong>{{ \Carbon\Carbon::parse($booking->payment->payment_date)->isoFormat('D MMMM Y, HH:mm') }}</strong>
                                                </div>
                                                <div class="info-row">
                                                    <small class="text-muted d-block">Status</small>
                                                    @php
                                                        $statusTranslations = [
                                                            'paid' => 'Lunas',
                                                            'pending' => 'Menunggu',
                                                            'failed' => 'Gagal'
                                                        ];
                                                        $statusText = $statusTranslations[$booking->payment->payment_status] ?? ucfirst($booking->payment->payment_status);
                                                        $statusBadge = $booking->payment->payment_status === 'paid' ? 'success' : ($booking->payment->payment_status === 'pending' ? 'warning' : 'danger');
                                                    @endphp
                                                    <span class="badge badge-{{ $statusBadge }} px-3 py-2">{{ $statusText }}</span>
                                                </div>
                                            </div>
                                        @else
                                            <div class="pl-4">
                                                <div class="alert alert-warning mb-0">
                                                    <i class="fa fa-exclamation-triangle mr-2"></i>
                                                    <strong>Pembayaran Menunggu</strong>
                                                    <p class="mb-0 mt-2 small">Silakan selesaikan pembayaran untuk mengkonfirmasi booking ini.</p>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="info-section">
                                        <h5 class="section-title mb-3">
                                            <i class="fa fa-clipboard-check text-danger mr-2"></i>Status Booking
                                        </h5>
                                        <div class="pl-4">
                                            <div class="info-row mb-2">
                                                <small class="text-muted d-block">Status Saat Ini</small>
                                                @php
                                                    $bookingStatusTranslations = [
                                                        'confirmed' => 'Dikonfirmasi',
                                                        'pending' => 'Menunggu',
                                                        'completed' => 'Selesai',
                                                        'cancelled' => 'Dibatalkan'
                                                    ];
                                                    $bookingStatusText = $bookingStatusTranslations[$booking->status] ?? ucfirst($booking->status);
                                                    
                                                    $statusBadgeClass = 'secondary';
                                                    $statusIcon = 'clock';
                                                    
                                                    if ($booking->status == 'confirmed') {
                                                        $statusBadgeClass = 'success';
                                                        $statusIcon = 'check-circle';
                                                    } elseif ($booking->status == 'pending') {
                                                        $statusBadgeClass = 'warning';
                                                        $statusIcon = 'clock';
                                                    } elseif ($booking->status == 'completed') {
                                                        $statusBadgeClass = 'info';
                                                        $statusIcon = 'check-circle';
                                                    } elseif ($booking->status == 'cancelled') {
                                                        $statusBadgeClass = 'secondary';
                                                        $statusIcon = 'times-circle';
                                                    }
                                                @endphp
                                                <span class="badge px-3 py-2 badge-{{ $statusBadgeClass }}">
                                                    <i class="fa fa-{{ $statusIcon }} mr-1"></i>
                                                    {{ $bookingStatusText }}
                                                </span>
                                            </div>
                                            <div class="info-row">
                                                <small class="text-muted d-block">Tanggal Booking</small>
                                                <strong>{{ $booking->created_at->isoFormat('D MMMM Y, HH:mm') }}</strong>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr class="my-4">

                            {{-- Rincian Harga --}}
                            <div class="info-section mb-4">
                                <h5 class="section-title mb-3">
                                    <i class="fa fa-file-invoice-dollar text-success mr-2"></i>Rincian Harga
                                </h5>
                                <div class="table-responsive">
                                    <table class="table table-bordered mb-0">
                                        <tbody>
                                            <tr>
                                                <td class="py-3">
                                                    <strong>Harga Sewa</strong>
                                                    <br><small class="text-muted">{{ $booking->total_days }} hari × Rp
                                                        {{ number_format($booking->kendaraan->price_per_day, 0, ',', '.') }}/hari</small>
                                                </td>
                                                <td class="text-right py-3" width="30%">
                                                    <strong>Rp
                                                        {{ number_format($booking->total_price, 0, ',', '.') }}</strong>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="py-3">
                                                    <strong>Biaya Admin</strong>
                                                    <br><small class="text-muted">Biaya layanan</small>
                                                </td>
                                                <td class="text-right py-3">
                                                    <strong>Rp 0</strong>
                                                </td>
                                            </tr>
                                            <tr class="bg-light">
                                                <td class="py-3">
                                                    <h5 class="mb-0 font-weight-bold">Total {{ $booking->payment ? 'Dibayar' : 'Tagihan' }}</h5>
                                                </td>
                                                <td class="text-right py-3">
                                                    <h4 class="mb-0 {{ $booking->payment ? 'text-success' : 'text-warning' }} font-weight-bold">
                                                        Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                                                    </h4>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            @if ($booking->notes)
                                <div class="alert alert-info border-0 shadow-sm">
                                    <h6 class="mb-2">
                                        <i class="fa fa-sticky-note mr-2"></i>Catatan Tambahan
                                    </h6>
                                    <p class="mb-0">{{ $booking->notes }}</p>
                                </div>
                            @endif

                            {{-- Informasi Penting --}}
                            @if ($booking->status !== 'cancelled')
                                <div class="alert alert-warning border-0 shadow-sm mb-0">
                                    <h6 class="font-weight-bold mb-3">
                                        <i class="fa fa-exclamation-triangle mr-2"></i>Informasi Penting
                                    </h6>
                                    <ul class="mb-0 pl-4">
                                        <li class="mb-2">Harap membawa KTP dan SIM yang masih berlaku saat mengambil kendaraan</li>
                                        <li class="mb-2">Kendaraan harus dikembalikan sesuai tanggal dan waktu yang dijadwalkan untuk menghindari biaya tambahan</li>
                                        <li class="mb-2">Hubungi layanan pelanggan kami segera jika mengalami kendala</li>
                                        <li>Simpan bukti ini untuk catatan dan referensi Anda</li>
                                    </ul>
                                </div>
                            @endif
                        </div>

                        {{-- Tombol Aksi --}}
                        <div class="card-footer bg-white border-0 text-center py-4">
                            <div class="action-buttons-wrapper">
                                <button onclick="window.print()" class="btn btn-outline-primary btn-lg px-5 action-btn">
                                    <i class="fa fa-print mr-2"></i>Cetak Bukti
                                </button>

                                @if ($booking->status === 'pending' && !$booking->payment)
                                    <a href="{{ route('payments.create', $booking->id) }}"
                                        class="btn btn-success btn-lg px-5 action-btn">
                                        <i class="fa fa-credit-card mr-2"></i>Bayar Sekarang
                                    </a>

                                    <form action="{{ route('bookings.cancel', $booking->id) }}" method="POST" 
                                          onsubmit="return confirm('Apakah Anda yakin ingin membatalkan booking ini? Tindakan ini tidak dapat dibatalkan!')"
                                          style="display: inline;">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-danger btn-lg px-5 action-btn">
                                            <i class="fa fa-times-circle mr-2"></i>Batalkan Booking
                                        </button>
                                    </form>
                                @endif

                                @if ($booking->status === 'confirmed' && !$booking->pengembalian)
                                    <a href="{{ route('returns.create', $booking->id) }}"
                                        class="btn btn-warning btn-lg px-5 action-btn">
                                        <i class="fa fa-undo mr-2"></i>Kembalikan Kendaraan
                                    </a>
                                @endif

                                @if ($booking->pengembalian)
                                    <a href="{{ route('returns.show', $booking->pengembalian->id) }}"
                                        class="btn btn-info btn-lg px-5 action-btn">
                                        <i class="fa fa-file-invoice mr-2"></i>Lihat Bukti Pengembalian
                                    </a>
                                @endif

                                <a href="{{ route('bookings.history') }}"
                                    class="btn btn-secondary btn-lg px-5 action-btn">
                                    <i class="fa fa-history mr-2"></i>Lihat Riwayat
                                </a>

                                <a href="{{ route('welcome') }}" class="btn btn-primary btn-lg px-5 action-btn">
                                    <i class="fa fa-home mr-2"></i>Kembali ke Beranda
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- Pemberitahuan Email Konfirmasi --}}
                    @if ($booking->payment)
                        <div class="text-center mt-4 p-3 bg-white rounded shadow-sm">
                            <p class="mb-0 text-muted">
                                <i class="fa fa-envelope mr-2 text-primary"></i>
                                Salinan bukti ini telah dikirim ke
                                <strong class="text-dark">{{ $booking->user->email }}</strong>
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection

@push('styles')
    <style>
        .action-buttons-wrapper {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 12px;
            align-items: center;
        }

        .action-btn {
            margin: 0 !important;
        }

        @media (max-width: 768px) {
            .action-buttons-wrapper {
                gap: 10px;
            }

            .action-btn {
                flex: 1 1 calc(50% - 10px);
                min-width: 150px;
            }
        }

        @media (max-width: 576px) {
            .action-buttons-wrapper {
                gap: 8px;
                flex-direction: column;
            }

            .action-btn {
                width: 100%;
                flex: 1 1 100%;
            }
        }

        @media print {
            .card-footer {
                display: none !important;
            }
        }

        .section-title {
            font-weight: 600;
            font-size: 1.1rem;
            border-bottom: 2px solid #f0f0f0;
            padding-bottom: 8px;
        }

        .info-section {
            margin-bottom: 1rem;
        }

        .info-row {
            padding: 8px 0;
        }

        .info-row small {
            font-size: 0.85rem;
            letter-spacing: 0.3px;
            font-weight: 500;
        }

        .info-row strong {
            font-size: 0.95rem;
            color: #2d3748;
        }

        .vehicle-image {
            transition: transform 0.3s ease;
        }

        .vehicle-image:hover {
            transform: scale(1.02);
        }

        .badge {
            font-weight: 500;
            letter-spacing: 0.3px;
        }

        .table-bordered td {
            border-color: #e2e8f0;
        }

        @media print {
            body * {
                visibility: hidden;
            }

            .card,
            .card * {
                visibility: visible;
            }

            .card {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                box-shadow: none !important;
            }

            .hero-wrap,
            .card-footer,
            .breadcrumbs,
            nav,
            footer,
            .btn,
            button {
                display: none !important;
            }

            .card-body {
                padding: 20px !important;
            }

            .alert {
                border: 1px solid #ddd !important;
                page-break-inside: avoid;
            }
        }

        @media (max-width: 768px) {
            .card-body {
                padding: 1.5rem 1rem !important;
            }

            .pl-4 {
                padding-left: 1rem !important;
            }

            .section-title {
                font-size: 1rem;
            }
        }
    </style>
@endpush