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
                        <span class="mr-2"><a href="{{ route('bookings.history') }}">Riwayat <i
                                    class="ion-ios-arrow-forward"></i></a></span>
                        <span>Jadwalkan Pengembalian <i class="ion-ios-arrow-forward"></i></span>
                    </p>
                    <h1 class="mb-3 bread">Jadwalkan Pengembalian Kendaraan</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="ftco-section bg-light">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <i class="fa fa-exclamation-circle mr-2"></i>{{ session('error') }}
                        </div>
                    @endif

                    <div class="row">
                        {{-- Kartu Info Booking --}}
                        <div class="col-md-5 mb-4">
                            <div class="card shadow-sm border-0">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="mb-0">
                                        <i class="fa fa-info-circle mr-2"></i>Informasi Booking
                                    </h5>
                                </div>

                                <div class="card-body">

                                    {{-- Gambar Kendaraan --}}
                                    @php
                                        $primaryImage = $booking->kendaraan->images->where('is_primary', 1)->first();
                                        $imageUrl = $primaryImage
                                            ? asset('storage/' . $primaryImage->image_path)
                                            : asset('frontend/images/car-1.jpg');
                                    @endphp
                                    <div class="vehicle-img-wrapper mb-3">
                                        <img src="{{ $imageUrl }}" alt="{{ $booking->kendaraan->brand }}"
                                            class="vehicle-img-responsive">
                                    </div>

                                    <h4 class="mb-3 vehicle-name">
                                        {{ $booking->kendaraan->brand }} {{ $booking->kendaraan->model }}
                                    </h4>

                                    {{-- Detail Booking --}}
                                    <div class="booking-details">

                                        <div class="detail-row">
                                            <span class="text-muted detail-label">ID Booking</span>
                                            <strong>#{{ str_pad($booking->id, 6, '0', STR_PAD_LEFT) }}</strong>
                                        </div>

                                        <div class="detail-row">
                                            <span class="text-muted detail-label">Tanggal Mulai</span>
                                            <strong>{{ \Carbon\Carbon::parse($booking->start_date)->isoFormat('D MMM Y') }}</strong>
                                        </div>

                                        <div class="detail-row">
                                            <span class="text-muted detail-label">Tgl. Pengembalian</span>
                                            <strong class="text-danger">
                                                {{ \Carbon\Carbon::parse($booking->end_date)->isoFormat('D MMM Y') }}
                                            </strong>
                                        </div>

                                        <div class="detail-row border-0">
                                            <span class="text-muted detail-label">Durasi</span>
                                            <span class="badge badge-primary">
                                                {{ $booking->total_days }} hari
                                            </span>
                                        </div>

                                    </div>

                                    {{-- Alert Info --}}
                                    <div class="alert alert-info mb-0 mt-3">
                                        <small>
                                            <i class="fa fa-info-circle mr-1"></i>
                                            <strong>Penting:</strong>
                                            Harap datang tepat waktu. Keterlambatan pengembalian dapat dikenakan denda.
                                        </small>
                                    </div>

                                </div>
                            </div>
                        </div>


                        {{-- Form Jadwalkan Pengembalian --}}
                        <div class="col-md-7">
                            <div class="card shadow-sm border-0">
                                <div class="card-header bg-success text-white">
                                    <h5 class="mb-0"><i class="fa fa-calendar-check mr-2"></i>Jadwalkan Pengembalian</h5>
                                </div>
                                <div class="card-body">
                                    <div class="alert alert-warning">
                                        <h6 class="mb-2"><i class="fa fa-exclamation-triangle mr-2"></i>Cara Kerja</h6>
                                        <ol class="mb-0 pl-3">
                                            <li>Pilih tanggal dan waktu pengembalian</li>
                                            <li>Admin kami akan menerima notifikasi</li>
                                            <li>Datang ke lokasi kami sesuai jadwal</li>
                                            <li>Admin akan memeriksa kondisi kendaraan</li>
                                            <li>Anda akan menerima bukti pengembalian</li>
                                        </ol>
                                    </div>

                                    <form action="{{ route('returns.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="booking_id" value="{{ $booking->id }}">

                                        <div class="form-group">
                                            <label for="return_scheduled_date">
                                                <i class="fa fa-calendar mr-1"></i>Tanggal Pengembalian *
                                            </label>
                                            <input type="date"
                                                class="form-control @error('return_scheduled_date') is-invalid @enderror"
                                                id="return_scheduled_date" name="return_scheduled_date"
                                                value="{{ old('return_scheduled_date', $booking->end_date) }}"
                                                min="{{ date('Y-m-d') }}" required>
                                            @error('return_scheduled_date')
                                                <div class="invalid-feedback d-block">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                            <small class="text-muted">Tanggal yang diharapkan:
                                                {{ \Carbon\Carbon::parse($booking->end_date)->isoFormat('D MMM Y') }}</small>
                                        </div>

                                        <div class="form-group">
                                            <label for="return_scheduled_time">
                                                <i class="fa fa-clock mr-1"></i>Waktu Pengembalian *
                                            </label>
                                            <select
                                                class="form-control @error('return_scheduled_time') is-invalid @enderror"
                                                id="return_scheduled_time" name="return_scheduled_time">
                                                @error('return_scheduled_time')
                                                    <div class="invalid-feedback d-block">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                                <option value="">Pilih Waktu</option>
                                                @php
                                                    $timeSlots = [
                                                        '09:00' => '09:00 - 10:00 Pagi',
                                                        '10:00' => '10:00 - 11:00 Pagi',
                                                        '11:00' => '11:00 - 12:00 Siang',
                                                        '13:00' => '01:00 - 02:00 Siang',
                                                        '14:00' => '02:00 - 03:00 Sore',
                                                        '15:00' => '03:00 - 04:00 Sore',
                                                        '16:00' => '04:00 - 05:00 Sore',
                                                    ];
                                                    $oldTime = old('return_scheduled_time');
                                                @endphp
                                                @foreach ($timeSlots as $value => $label)
                                                    <option value="{{ $value }}"
                                                        {{ $oldTime == $value ? 'selected' : '' }}>
                                                        {{ $label }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('return_scheduled_time')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="text-muted">Pilih waktu yang sesuai untuk Anda</small>
                                        </div>

                                        <div class="form-group">
                                            <label for="customer_notes">
                                                <i class="fa fa-sticky-note mr-1"></i>Catatan Tambahan (Opsional)
                                            </label>
                                            <textarea class="form-control @error('customer_notes') is-invalid @enderror" id="customer_notes" name="customer_notes"
                                                rows="3" placeholder="Permintaan khusus atau informasi yang perlu kami ketahui...">{{ old('customer_notes') }}</textarea>
                                            @error('customer_notes')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="alert alert-light border">
                                            <h6 class="mb-2"><i class="fa fa-map-marker-alt text-danger mr-2"></i>Lokasi
                                                Pengembalian</h6>
                                            <p class="mb-0"><strong>Kantor Kami</strong><br>
                                                Jl. Cibedug hilir No. 123, Bandung<br>
                                                <small class="text-muted">Pastikan Anda datang tepat waktu ke lokasi
                                                    ini</small>
                                            </p>
                                        </div>

                                        <div class="form-group mb-0">
                                            <button type="submit" class="btn btn-success btn-block btn-lg">
                                                <i class="fa fa-check-circle mr-2"></i>Jadwalkan Pengembalian
                                            </button>
                                            <a href="{{ route('bookings.show', $booking->id) }}"
                                                class="btn btn-secondary btn-block mt-2">
                                                <i class="fa fa-arrow-left mr-2"></i>Batal
                                            </a>
                                        </div>
                                    </form>
                                </div>
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
        /* ===== GAMBAR KENDARAAN - TIDAK TERPOTONG ===== */
        .vehicle-img-wrapper {
            width: 100%;
            border-radius: 8px;
            overflow: hidden;
            background: #f8f9fa;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
        }

        /* Gambar mengisi lebar penuh, tinggi otomatis, tidak terpotong */
        .vehicle-img-responsive {
            width: 100%;
            height: auto;
            display: block;
            object-fit: contain;
            max-height: 260px;
        }

        /* Di layar besar: sedikit lebih tinggi dengan cover agar proporsional */
        @media (min-width: 768px) {
            .vehicle-img-responsive {
                height: 180px;
                object-fit: cover;
            }
        }

        /* ===== NAMA KENDARAAN ===== */
        .vehicle-name {
            font-size: 1.2rem;
            word-break: break-word;
        }

        /* ===== DETAIL ROW - mengganti d-flex justify-content-between ===== */
        .detail-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            /* Agar tidak overflow di HP kecil */
            gap: 4px;
            padding: 10px 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .detail-label {
            font-size: 0.85rem;
            flex-shrink: 0;
            margin-right: 8px;
        }

        /* Di HP kecil: label dan nilai stack vertikal jika terlalu panjang */
        @media (max-width: 400px) {
            .detail-row {
                flex-direction: column;
                align-items: flex-start;
            }
        }

        /* ===== CARD BODY PADDING DI HP ===== */
        @media (max-width: 576px) {
            .card-body {
                padding: 1rem !important;
            }

            .card-header h5 {
                font-size: 1rem;
            }

            /* Form controls lebih nyaman di HP */
            .form-control {
                font-size: 16px;
                /* Mencegah zoom otomatis di iOS */
            }

            /* Alert cara kerja lebih ringkas */
            .alert ol {
                padding-left: 1.2rem;
            }

            .alert ol li {
                font-size: 0.9rem;
                margin-bottom: 4px;
            }

            /* Tombol submit */
            .btn-lg {
                font-size: 1rem;
                padding: 0.6rem 1rem;
            }

            .vehicle-name {
                font-size: 1.05rem;
            }
        }

        /* ===== CONTAINER SECTION ===== */
        @media (max-width: 576px) {
            .ftco-section .container {
                padding-left: 12px;
                padding-right: 12px;
            }
        }

        /* ===== PASTIKAN GAMBAR TIDAK OVERFLOW ===== */
        .vehicle-img-wrapper img {
            max-width: 100%;
        }

        /* ===== ALERT LOKASI ===== */
        .alert-light p {
            font-size: 0.9rem;
            line-height: 1.6;
        }
    </style>
@endpush
