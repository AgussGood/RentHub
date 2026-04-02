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

            {{-- Stats Cards --}}
            <div class="row mb-4">
                <div class="col-md-3 mb-3">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body text-center py-4">
                            <i class="fa fa-calendar-check text-primary mb-2" style="font-size: 2rem;"></i>
                            <h3 class="mb-1 font-weight-bold">{{ $bookings->where('status', 'confirmed')->count() }}</h3>
                            <p class="mb-0 text-muted">Dikonfirmasi</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body text-center py-4">
                            <i class="fa fa-clock text-warning mb-2" style="font-size: 2rem;"></i>
                            <h3 class="mb-1 font-weight-bold">{{ $bookings->where('status', 'pending')->count() }}</h3>
                            <p class="mb-0 text-muted">Menunggu</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body text-center py-4">
                            <i class="fa fa-check-double text-success mb-2" style="font-size: 2rem;"></i>
                            <h3 class="mb-1 font-weight-bold">{{ $bookings->where('status', 'completed')->count() }}</h3>
                            <p class="mb-0 text-muted">Selesai</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body text-center py-4">
                            <i class="fa fa-ban text-danger mb-2" style="font-size: 2rem;"></i>
                            <h3 class="mb-1 font-weight-bold">{{ $bookings->where('status', 'cancelled')->count() }}</h3>
                            <p class="mb-0 text-muted">Dibatalkan</p>
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
                                <div class="card-body p-4">
                                    <div class="row">
                                        {{-- Vehicle Image --}}
                                        <div class="col-md-3 mb-3 mb-md-0">
                                            <div class="vehicle-image-wrapper rounded overflow-hidden"
                                                style="height: 180px;">
                                                <img src="{{ $booking->kendaraan->images->where('is_primary', 1)->first()
                                                    ? asset('storage/' . $booking->kendaraan->images->where('is_primary', 1)->first()->image_path)
                                                    : asset('frontend/images/car-1.jpg') }}"
                                                    alt="{{ $booking->kendaraan->brand }}"
                                                    style="width: 100%; height: 100%; object-fit: cover;">
                                            </div>
                                        </div>

                                        {{-- Booking Details --}}
                                        <div class="col-md-6">
                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                <div>
                                                    <h4 class="font-weight-bold mb-2">
                                                        {{ $booking->kendaraan->brand }} {{ $booking->kendaraan->model }}
                                                    </h4>
                                                    <p class="text-muted mb-2">
                                                        <i class="fa fa-hashtag mr-1"></i>
                                                        ID Booking:
                                                        <strong>#{{ str_pad($booking->id, 6, '0', STR_PAD_LEFT) }}</strong>
                                                    </p>
                                                </div>
                                                @php
                                                    $statusLabels = [
                                                        'confirmed' => 'Dikonfirmasi',
                                                        'pending' => 'Menunggu',
                                                        'completed' => 'Selesai',
                                                        'cancelled' => 'Dibatalkan'
                                                    ];
                                                    $statusColors = [
                                                        'confirmed' => 'success',
                                                        'pending' => 'warning',
                                                        'completed' => 'info',
                                                        'cancelled' => 'secondary'
                                                    ];
                                                @endphp
                                                <span class="badge px-3 py-2 badge-{{ $statusColors[$booking->status] ?? 'secondary' }}">
                                                    {{ $statusLabels[$booking->status] ?? ucfirst($booking->status) }}
                                                </span>
                                            </div>

                                            <div class="row mb-3">
                                                <div class="col-6">
                                                    <small class="text-muted d-block mb-1">
                                                        <i class="fa fa-calendar mr-1"></i>Tanggal Mulai
                                                    </small>
                                                    <strong>{{ \Carbon\Carbon::parse($booking->start_date)->locale('id')->isoFormat('D MMM Y') }}</strong>
                                                </div>
                                                <div class="col-6">
                                                    <small class="text-muted d-block mb-1">
                                                        <i class="fa fa-calendar mr-1"></i>Tanggal Selesai
                                                    </small>
                                                    <strong>{{ \Carbon\Carbon::parse($booking->end_date)->locale('id')->isoFormat('D MMM Y') }}</strong>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-6">
                                                    <small class="text-muted d-block mb-1">
                                                        <i class="fa fa-clock mr-1"></i>Durasi
                                                    </small>
                                                    <strong>{{ $booking->total_days }} hari</strong>
                                                </div>
                                                @if ($booking->payment)
                                                    <div class="col-6">
                                                        <small class="text-muted d-block mb-1">
                                                            <i class="fa fa-credit-card mr-1"></i>Pembayaran
                                                        </small>
                                                        @php
                                                            $paymentLabels = [
                                                                'paid' => 'Lunas',
                                                                'pending' => 'Menunggu',
                                                                'failed' => 'Gagal'
                                                            ];
                                                            $paymentColors = [
                                                                'paid' => 'success',
                                                                'pending' => 'warning',
                                                                'failed' => 'danger'
                                                            ];
                                                        @endphp
                                                        <span class="badge badge-{{ $paymentColors[$booking->payment->payment_status] ?? 'secondary' }}">
                                                            {{ $paymentLabels[$booking->payment->payment_status] ?? ucfirst($booking->payment->payment_status) }}
                                                        </span>
                                                    </div>
                                                @endif
                                            </div>

                                            @if ($booking->pickup_location)
                                                <div class="mt-3 p-2 bg-light rounded">
                                                    <small class="text-muted">
                                                        <i class="fa fa-map-marker-alt mr-1"></i>Lokasi Penjemputan:
                                                    </small>
                                                    <strong>{{ $booking->pickup_location }}</strong>
                                                </div>
                                            @endif
                                        </div>

                                        {{-- Price & Actions --}}
                                        <div class="col-md-3 text-md-right">
                                            <div class="price-section mb-3">
                                                <small class="text-muted d-block mb-1">Total Harga</small>
                                                <h3 class="text-primary font-weight-bold mb-0">
                                                    Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                                                </h3>
                                            </div>

                                            <div class="d-flex flex-column">
                                                <a href="{{ route('bookings.show', $booking->id) }}"
                                                    class="btn btn-primary btn-sm mb-2">
                                                    <i class="fa fa-file-invoice mr-1"></i>Lihat Bukti
                                                </a>

                                                @if ($booking->status == 'pending' && !$booking->payment)
                                                    <a href="{{ route('payments.create', $booking->id) }}"
                                                        class="btn btn-success btn-sm mb-2">
                                                        <i class="fa fa-credit-card mr-1"></i>Bayar Sekarang
                                                    </a>
                                                @endif

                                                @if ($booking->status == 'pending' && !$booking->payment)
                                                    <button type="button" class="btn btn-danger btn-sm mb-2"
                                                        onclick="confirmCancel({{ $booking->id }})">
                                                        <i class="fa fa-times-circle mr-1"></i>Batalkan Booking
                                                    </button>
                                                @endif

                                                {{-- REVIEW BUTTON: Show jika completed dan belum ada review --}}
                                                @if ($booking->status == 'completed' && !$booking->review)
                                                    <a href="{{ route('reviews.create', $booking->id) }}"
                                                        class="btn btn-warning btn-sm mb-2">
                                                        <i class="fa fa-star mr-1"></i>Tulis Ulasan
                                                    </a>
                                                @endif

                                                {{-- Show badge jika sudah review --}}
                                                @if ($booking->review)
                                                    <div class="alert alert-success p-2 mb-2 text-center">
                                                        <i class="fa fa-check-circle mr-1"></i>
                                                        <small>Ulasan Terkirim</small>
                                                    </div>
                                                @endif
                                            </div>

                                            {{-- Hidden form untuk cancel --}}
                                            <form id="cancelForm{{ $booking->id }}"
                                                action="{{ route('bookings.cancel', $booking->id) }}" method="POST"
                                                style="display: none;">
                                                @csrf
                                                @method('PUT')
                                            </form>
                                        </div>
                                    </div>

                                    {{-- Footer Info --}}
                                    <div class="border-top pt-3 mt-3">
                                        <div class="row text-muted small">
                                            <div class="col-md-6">
                                                <i class="fa fa-clock mr-1"></i>
                                                Dibuat pada: {{ $booking->created_at->locale('id')->isoFormat('D MMM Y, HH:mm') }}
                                            </div>
                                            @if ($booking->payment)
                                                <div class="col-md-6 text-md-right">
                                                    <i class="fa fa-money-bill-wave mr-1"></i>
                                                    @php
                                                        $methodLabels = [
                                                            'cash' => 'Tunai',
                                                            'transfer' => 'Transfer Bank',
                                                            'e_wallet' => 'E-Wallet',
                                                            'midtrans' => 'Midtrans'
                                                        ];
                                                    @endphp
                                                    Metode Pembayaran: <strong>{{ $methodLabels[$booking->payment->payment_method] ?? ucfirst(str_replace('_', ' ', $booking->payment->payment_method)) }}</strong>
                                                </div>
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
                                <p class="text-muted mb-4">Anda belum melakukan booking apapun. Mulai jelajahi kendaraan kami!
                                </p>
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
        .booking-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .booking-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15) !important;
        }

        .vehicle-image-wrapper {
            position: relative;
            overflow: hidden;
        }

        .vehicle-image-wrapper img {
            transition: transform 0.3s ease;
        }

        .booking-card:hover .vehicle-image-wrapper img {
            transform: scale(1.05);
        }

        .price-section {
            padding: 15px;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 8px;
        }

        .badge {
            font-weight: 500;
            letter-spacing: 0.3px;
        }

        .btn-sm {
            padding: 8px 16px;
            font-size: 0.875rem;
        }

        .card {
            border-radius: 10px;
        }

        @media (max-width: 768px) {
            .booking-card .col-md-3.text-md-right {
                text-align: center !important;
                margin-top: 1rem;
            }

            .booking-card .d-flex.flex-column {
                flex-direction: row !important;
                justify-content: center;
                gap: 8px;
            }

            .booking-card .btn-sm {
                flex: 1;
                margin-bottom: 0 !important;
            }

            .price-section {
                text-align: center;
                margin-bottom: 1rem;
            }
        }

        /* Pagination styling */
        .pagination {
            margin-top: 2rem;
        }

        .page-link {
            color: #1089ff;
            border: 1px solid #dee2e6;
            padding: 8px 16px;
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