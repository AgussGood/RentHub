@extends('layouts.front')
@section('content')

    <style>
        /* ================================================================
       MOBILE  ≤ 767px
       ================================================================ */
        @media (max-width: 767.98px) {

            /* ── HERO BANNER ── */
            .hero-wrap.hero-wrap-2 {
                background-attachment: scroll !important;
                background-size: cover !important;
                background-position: center center !important;
                min-height: 200px !important;
            }

            .hero-wrap.hero-wrap-2 .slider-text {
                min-height: 200px !important;
                padding-bottom: 24px !important;
            }

            .hero-wrap.hero-wrap-2 h1.bread {
                font-size: 22px !important;
                margin-bottom: 8px !important;
            }

            .hero-wrap.hero-wrap-2 .breadcrumbs {
                font-size: 12px !important;
            }

            /* ── FOTO UTAMA KENDARAAN ── */
            .car-details>.img {
                height: auto !important;
                min-height: 220px !important;
                max-height: 300px !important;
            }

            .car-details>.img>.img {
                height: auto !important;
                min-height: 220px !important;
                max-height: 300px !important;
            }

            .car-details>.img img,
            .car-details>.img>.img img {
                width: 100% !important;
                height: auto !important;
                max-height: 300px !important;
                object-fit: contain !important;
                object-position: center !important;
                background-color: #f8f9fa !important;
                display: block !important;
            }

            /* ── JUDUL KENDARAAN ── */
            .text.text-center .subheading {
                font-size: 13px !important;
            }

            .text.text-center h2 {
                font-size: 20px !important;
                margin-bottom: 8px !important;
            }

            /* ── SPESIFIKASI ICON ROW ── */
            .ftco-car-details .row .col-md {
                flex: 0 0 50% !important;
                max-width: 50% !important;
                padding: 6px 8px !important;
            }

            .ftco-car-details .media.block-6.services {
                padding: 10px 8px !important;
            }

            .ftco-car-details .media.block-6 .icon {
                width: 40px !important;
                height: 40px !important;
                min-width: 40px !important;
                font-size: 18px !important;
            }

            .ftco-car-details .media.block-6 h3.heading {
                font-size: 12px !important;
                line-height: 1.4 !important;
            }

            .ftco-car-details .media.block-6 h3.heading span {
                font-size: 11px !important;
                display: block !important;
            }

            /* ── TABS ── */
            .nav-pills .nav-item {
                margin-bottom: 4px !important;
            }

            .nav-pills .nav-link {
                font-size: 13px !important;
                padding: 8px 14px !important;
            }

            /* ── CARD INFO ── */
            .card {
                margin-bottom: 16px !important;
            }

            .card-header h5 {
                font-size: 14px !important;
            }

            .info-item {
                flex-direction: column !important;
                align-items: flex-start !important;
                gap: 2px !important;
                padding: 8px 0 !important;
            }

            .info-label {
                width: 100% !important;
                font-size: 11px !important;
                color: #888 !important;
                margin-bottom: 2px !important;
            }

            .info-value {
                font-size: 13px !important;
            }

            /* ── PRICE SUMMARY CARD ── */
            .card.border-primary .card-body h2 {
                font-size: 30px !important;
            }

            .card.border-primary .btn-lg {
                font-size: 14px !important;
                padding: 10px 24px !important;
                width: 100% !important;
            }

            /* ── REVIEW SECTION ── */
            .review .user-img {
                width: 44px !important;
                height: 44px !important;
            }

            .review .desc h5 {
                font-size: 13px !important;
            }

            .review .desc p {
                font-size: 12px !important;
            }

            .review .desc small {
                font-size: 10px !important;
            }

            /* Rating summary - full width on mobile */
            .col-md-7,
            .col-md-5 {
                flex: 0 0 100% !important;
                max-width: 100% !important;
                padding: 0 12px !important;
            }

            .col-md-5 {
                margin-top: 20px !important;
            }

            /* Average rating number */
            .card-body [style*="font-size: 64px"] {
                font-size: 48px !important;
            }

            /* ── RELATED CARS ── */
            .car-wrap .img {
                height: auto !important;
                min-height: 180px !important;
            }

            .car-wrap .img img {
                width: 100% !important;
                height: auto !important;
                min-height: 180px !important;
                max-height: 220px !important;
                object-fit: contain !important;
                background-color: #f8f9fa !important;
            }

            .car-wrap .text {
                padding: 12px 10px !important;
            }

            .car-wrap .text h2 {
                font-size: 14px !important;
            }

            .car-wrap .text .cat {
                font-size: 12px !important;
            }

            .car-wrap .text .price {
                font-size: 13px !important;
            }

            .car-wrap .text .btn {
                flex: 1 !important;
                font-size: 12px !important;
                padding: 7px 6px !important;
                text-align: center !important;
            }

            /* ── SECTION SPACING ── */
            .ftco-section {
                padding: 30px 0 !important;
            }

            .ftco-car-details {
                padding-top: 24px !important;
            }

            /* ── CONTAINER ── */
            .container {
                padding-left: 14px !important;
                padding-right: 14px !important;
            }

            /* ── HEADING ── */
            .heading-section h2 {
                font-size: 18px !important;
            }

            .heading-section .subheading {
                font-size: 11px !important;
            }

            /* ── BADGE ── */
            .badge {
                font-size: 12px !important;
            }
        }

        /* ================================================================
       TABLET  768–991px
       ================================================================ */
        @media (min-width: 768px) and (max-width: 991.98px) {

            .hero-wrap.hero-wrap-2 {
                background-attachment: scroll !important;
                background-size: cover !important;
                background-position: center !important;
            }

            .car-details>.img,
            .car-details>.img>.img {
                height: 320px !important;
            }

            .ftco-car-details .row .col-md {
                flex: 0 0 50% !important;
                max-width: 50% !important;
                margin-bottom: 8px !important;
            }

            .car-wrap .img {
                height: 200px !important;
            }
        }

        /* ================================================================
       SHARED FIXES (all screens)
       ================================================================ */
        .info-item:hover {
            background-color: #f8f9fa;
            border-radius: 5px;
        }

        .card {
            border-radius: 10px;
        }

        .card-header {
            border-radius: 10px 10px 0 0 !important;
        }

        .badge {
            font-size: 14px;
        }

        .btn-lg {
            border-radius: 50px;
            transition: all 0.3s ease;
        }

        .btn-lg:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        /* Ensure images never overflow */
        .car-details img,
        .car-wrap img {
            max-width: 100%;
            display: block;
        }
    </style>

    {{-- ============================================================
         HERO BANNER
         ============================================================ --}}
    <section class="hero-wrap hero-wrap-2 js-fullheight"
        style="background-image: url('{{ asset('frontend/images/bg_3.jpg') }}');
               background-size: cover;
               background-position: center;
               background-attachment: scroll;"
        data-stellar-background-ratio="0.5">
        <div class="overlay"></div>
        <div class="container">
            <div class="row no-gutters slider-text js-fullheight align-items-end justify-content-start">
                <div class="col-md-9 ftco-animate pb-5">
                    <p class="breadcrumbs">
                        <span class="mr-2">
                            <a href="{{ route('welcome') }}">Beranda <i class="ion-ios-arrow-forward"></i></a>
                        </span>
                        <span>Detail Kendaraan <i class="ion-ios-arrow-forward"></i></span>
                    </p>
                    <h1 class="mb-3 bread">Detail Kendaraan</h1>
                </div>
            </div>
        </div>
    </section>

    {{-- ============================================================
         DETAIL KENDARAAN
         ============================================================ --}}
    <section class="ftco-section ftco-car-details">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">

                    {{-- Foto Utama --}}
<div class="car-details mb-3">
    <img src="{{ $kendaraan->images->where('is_primary', 1)->first()
            ? asset('storage/' . $kendaraan->images->where('is_primary', 1)->first()->image_path)
            : asset('frontend/images/bg_1.jpg') }}"
         alt="{{ $kendaraan->brand }} {{ $kendaraan->model }}"
         class="img-fluid rounded"
         style="width: 100%;
                height: auto;
                max-height: 420px;
                object-fit: cover;
                object-position: center;
                display: block;">
</div>

                    {{-- Judul --}}
                    <div class="text text-center mt-3 mb-4">
                        <span class="subheading">{{ $kendaraan->brand }} - {{ $kendaraan->year }}</span>
                        <h2>{{ $kendaraan->model }}</h2>
                    </div>
                </div>

                {{-- ── Spesifikasi Ikon ── --}}
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md d-flex align-self-stretch ftco-animate">
                            <div class="media block-6 services w-100">
                                <div class="media-body py-md-4">
                                    <div class="d-flex mb-3 align-items-center">
                                        <div class="icon d-flex align-items-center justify-content-center">
                                            <span class="flaticon-dashboard"></span>
                                        </div>
                                        <div class="text">
                                            <h3 class="heading mb-0 pl-3">
                                                Engine
                                                <span>{{ $kendaraan->detail->engine_capacity ?? 'N/A' }} CC</span>
                                            </h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md d-flex align-self-stretch ftco-animate">
                            <div class="media block-6 services w-100">
                                <div class="media-body py-md-4">
                                    <div class="d-flex mb-3 align-items-center">
                                        <div class="icon d-flex align-items-center justify-content-center">
                                            <span class="flaticon-pistons"></span>
                                        </div>
                                        <div class="text">
                                            <h3 class="heading mb-0 pl-3">
                                                Transmission
                                                <span>{{ $kendaraan->detail->transmission ?? 'N/A' }}</span>
                                            </h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md d-flex align-self-stretch ftco-animate">
                            <div class="media block-6 services w-100">
                                <div class="media-body py-md-4">
                                    <div class="d-flex mb-3 align-items-center">
                                        <div class="icon d-flex align-items-center justify-content-center">
                                            <span class="flaticon-car-seat"></span>
                                        </div>
                                        <div class="text">
                                            <h3 class="heading mb-0 pl-3">
                                                Seats
                                                <span>{{ $kendaraan->detail->seat_count ?? 'N/A' }}</span>
                                            </h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md d-flex align-self-stretch ftco-animate">
                            <div class="media block-6 services w-100">
                                <div class="media-body py-md-4">
                                    <div class="d-flex mb-3 align-items-center">
                                        <div class="icon d-flex align-items-center justify-content-center">
                                            <span class="flaticon-diesel"></span>
                                        </div>
                                        <div class="text">
                                            <h3 class="heading mb-0 pl-3">
                                                Fuel
                                                <span>{{ $kendaraan->detail->fuel_type ?? 'N/A' }}</span>
                                            </h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ── Tabs ── --}}
                <div class="col-md-12 mt-4">
                    <div class="pills">
                        <div class="bd-example bd-example-tabs">
                            <div class="d-flex justify-content-center">
                                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="pills-description-tab" data-toggle="pill"
                                            href="#pills-description" role="tab">Spesifikasi</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="pills-review-tab" data-toggle="pill" href="#pills-review"
                                            role="tab">
                                            Reviews ({{ $totalReviews }})
                                        </a>
                                    </li>
                                </ul>
                            </div>

                            <div class="tab-content" id="pills-tabContent">

                                {{-- ── Tab Spesifikasi ── --}}
                                <div class="tab-pane fade show active" id="pills-description" role="tabpanel">

                                    {{-- Informasi Kendaraan --}}
                                    <div class="card mb-4 shadow-sm">
                                        <div class="card-header bg-primary text-white">
                                            <h5 class="mb-0"><i class="fa fa-car mr-2"></i>Informasi Kendaraan</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-6 col-md-6 mb-3">
                                                    <div class="info-item d-flex align-items-center py-2 border-bottom">
                                                        <div class="info-label"
                                                            style="width:150px; font-weight:600; color:#666;">Brand</div>
                                                        <div class="info-value" style="flex:1; color:#333;">
                                                            {{ $kendaraan->brand }}</div>
                                                    </div>
                                                </div>
                                                <div class="col-6 col-md-6 mb-3">
                                                    <div class="info-item d-flex align-items-center py-2 border-bottom">
                                                        <div class="info-label"
                                                            style="width:150px; font-weight:600; color:#666;">Model</div>
                                                        <div class="info-value" style="flex:1; color:#333;">
                                                            {{ $kendaraan->model }}</div>
                                                    </div>
                                                </div>
                                                <div class="col-6 col-md-6 mb-3">
                                                    <div class="info-item d-flex align-items-center py-2 border-bottom">
                                                        <div class="info-label"
                                                            style="width:150px; font-weight:600; color:#666;">Tahun</div>
                                                        <div class="info-value" style="flex:1; color:#333;">
                                                            {{ $kendaraan->year }}</div>
                                                    </div>
                                                </div>
                                                <div class="col-6 col-md-6 mb-3">
                                                    <div class="info-item d-flex align-items-center py-2 border-bottom">
                                                        <div class="info-label"
                                                            style="width:150px; font-weight:600; color:#666;">Type</div>
                                                        <div class="info-value" style="flex:1; color:#333;">
                                                            <span
                                                                class="badge badge-info">{{ ucfirst($kendaraan->type) }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-6 col-md-6 mb-3">
                                                    <div class="info-item d-flex align-items-center py-2 border-bottom">
                                                        <div class="info-label"
                                                            style="width:150px; font-weight:600; color:#666;">Warna</div>
                                                        <div class="info-value" style="flex:1; color:#333;">
                                                            {{ $kendaraan->color ?? 'N/A' }}</div>
                                                    </div>
                                                </div>
                                                <div class="col-6 col-md-6 mb-3">
                                                    <div class="info-item d-flex align-items-center py-2 border-bottom">
                                                        <div class="info-label"
                                                            style="width:150px; font-weight:600; color:#666;">Plate Number
                                                        </div>
                                                        <div class="info-value" style="flex:1; color:#333;">
                                                            <span
                                                                class="badge badge-dark">{{ $kendaraan->plate_number }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Technical Details --}}
                                    <div class="card mb-4 shadow-sm">
                                        <div class="card-header bg-success text-white">
                                            <h5 class="mb-0"><i class="fa fa-cog mr-2"></i>Technical Details</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-6 col-md-6 mb-3">
                                                    <div class="info-item d-flex align-items-center py-2 border-bottom">
                                                        <div class="info-label"
                                                            style="width:150px; font-weight:600; color:#666;">Engine
                                                            Capacity</div>
                                                        <div class="info-value" style="flex:1; color:#333;">
                                                            {{ $kendaraan->detail->engine_capacity ?? 'N/A' }} CC</div>
                                                    </div>
                                                </div>
                                                <div class="col-6 col-md-6 mb-3">
                                                    <div class="info-item d-flex align-items-center py-2 border-bottom">
                                                        <div class="info-label"
                                                            style="width:150px; font-weight:600; color:#666;">Fuel Type
                                                        </div>
                                                        <div class="info-value" style="flex:1; color:#333;">
                                                            {{ $kendaraan->detail->fuel_type ?? 'N/A' }}</div>
                                                    </div>
                                                </div>
                                                <div class="col-6 col-md-6 mb-3">
                                                    <div class="info-item d-flex align-items-center py-2 border-bottom">
                                                        <div class="info-label"
                                                            style="width:150px; font-weight:600; color:#666;">Transmission
                                                        </div>
                                                        <div class="info-value" style="flex:1; color:#333;">
                                                            {{ $kendaraan->detail->transmission ?? 'N/A' }}</div>
                                                    </div>
                                                </div>
                                                <div class="col-6 col-md-6 mb-3">
                                                    <div class="info-item d-flex align-items-center py-2 border-bottom">
                                                        <div class="info-label"
                                                            style="width:150px; font-weight:600; color:#666;">Seat Count
                                                        </div>
                                                        <div class="info-value" style="flex:1; color:#333;">
                                                            {{ $kendaraan->detail->seat_count ?? 'N/A' }} Seats</div>
                                                    </div>
                                                </div>
                                                <div class="col-6 col-md-6 mb-3">
                                                    <div class="info-item d-flex align-items-center py-2 border-bottom">
                                                        <div class="info-label"
                                                            style="width:150px; font-weight:600; color:#666;">Status</div>
                                                        <div class="info-value" style="flex:1; color:#333;">
                                                            <span
                                                                class="badge badge-{{ $kendaraan->status == 'available' ? 'success' : 'warning' }} px-3 py-2">
                                                                <i
                                                                    class="fa fa-circle mr-1"></i>{{ ucfirst($kendaraan->status) }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-6 col-md-6 mb-3">
                                                    <div class="info-item d-flex align-items-center py-2 border-bottom">
                                                        <div class="info-label"
                                                            style="width:150px; font-weight:600; color:#666;">Price per Day
                                                        </div>
                                                        <div class="info-value" style="flex:1;">
                                                            <span class="text-primary font-weight-bold"
                                                                style="font-size:18px;">
                                                                Rp
                                                                {{ number_format($kendaraan->price_per_day, 0, ',', '.') }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Price Summary --}}
                                    <div class="card mb-4 shadow-sm border-primary">
                                        <div class="card-body text-center py-4">
                                            <h5 class="text-muted mb-3">Harga Harian Rental</h5>
                                            <h2 class="text-primary mb-0" style="font-weight: bold;">
                                                Rp {{ number_format($kendaraan->price_per_day, 0, ',', '.') }}
                                            </h2>
                                            <p class="text-muted mb-4">/hari</p>
                                            <a href="{{ route('bookings.create', $kendaraan->id) }}"
                                                class="btn btn-primary btn-lg px-5 py-3 shadow">
                                                <i class="fa fa-calendar-check mr-2"></i>Booking Sekarang
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                {{-- ── Tab Reviews ── --}}
                                <div class="tab-pane fade" id="pills-review" role="tabpanel">
                                    <div class="row">
                                        <div class="col-md-7">
                                            <h3 class="head mb-4">{{ $totalReviews }} Review</h3>
                                            @forelse($kendaraan->reviews as $review)
                                                <div class="card mb-3 shadow-sm">
                                                    <div class="card-body">
                                                        <div class="review d-flex">
                                                            <div class="user-img flex-shrink-0"
                                                                style="background-image: url('{{ asset('frontend/images/person_1.jpg') }}');
                                                                        width: 50px; height: 50px;
                                                                        border-radius: 50%;
                                                                        background-size: cover;
                                                                        background-position: center;">
                                                            </div>
                                                            <div class="desc ml-3 flex-grow-1" style="min-width:0;">
                                                                <div
                                                                    class="d-flex justify-content-between align-items-start mb-1 flex-wrap">
                                                                    <h5 class="mb-0" style="font-size:14px;">
                                                                        {{ $review->user->name ?? 'Anonymous' }}</h5>
                                                                    <small
                                                                        class="text-muted">{{ $review->created_at->format('d M Y') }}</small>
                                                                </div>
                                                                <p class="star mb-2">
                                                                    @for ($i = 1; $i <= 5; $i++)
                                                                        <i class="ion-ios-star{{ $i <= $review->rating ? '' : '-outline' }}"
                                                                            style="color: #ffc107;"></i>
                                                                    @endfor
                                                                    <span class="ml-1 text-muted"
                                                                        style="font-size:12px;">({{ $review->rating }}/5)</span>
                                                                </p>
                                                                <p class="mb-0"
                                                                    style="font-size:13px; word-break:break-word;">
                                                                    {{ $review->comment }}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @empty
                                                <div class="alert alert-info">
                                                    <i class="fa fa-info-circle mr-2"></i>Belum ada review sekarang
                                                </div>
                                            @endforelse
                                        </div>

                                        <div class="col-md-5 mt-4 mt-md-0">
                                            <div class="card shadow-sm">
                                                <div class="card-header bg-warning text-white">
                                                    <h5 class="mb-0"><i class="fa fa-star mr-2"></i>Average Rating</h5>
                                                </div>
                                                <div class="card-body text-center">
                                                    <div class="mb-4">
                                                        <div
                                                            style="font-size: 56px; color: #01d28e; font-weight: bold; line-height: 1;">
                                                            {{ number_format($averageRating, 1) }}
                                                        </div>
                                                        <div class="mt-2">
                                                            @for ($i = 1; $i <= 5; $i++)
                                                                <i class="ion-ios-star{{ $i <= round($averageRating) ? '' : '-outline' }}"
                                                                    style="color: #ffc107; font-size: 22px;"></i>
                                                            @endfor
                                                        </div>
                                                        <p class="text-muted mt-2 mb-0">Based on {{ $totalReviews }}
                                                            reviews</p>
                                                    </div>

                                                    @php
                                                        $ratingCounts = [5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0];
                                                        foreach ($kendaraan->reviews as $review) {
                                                            $ratingCounts[$review->rating]++;
                                                        }
                                                    @endphp

                                                    <div class="text-left">
                                                        @for ($i = 5; $i >= 1; $i--)
                                                            <div class="d-flex align-items-center mb-2">
                                                                <span
                                                                    style="width:24px; font-size:12px;">{{ $i }}</span>
                                                                <i class="ion-ios-star mr-2"
                                                                    style="color:#ffc107; font-size:12px;"></i>
                                                                <div class="progress flex-grow-1 mr-2"
                                                                    style="height:14px;">
                                                                    <div class="progress-bar bg-warning"
                                                                        role="progressbar"
                                                                        style="width: {{ $totalReviews > 0 ? ($ratingCounts[$i] / $totalReviews) * 100 : 0 }}%"
                                                                        aria-valuenow="{{ $totalReviews > 0 ? ($ratingCounts[$i] / $totalReviews) * 100 : 0 }}"
                                                                        aria-valuemin="0" aria-valuemax="100">
                                                                    </div>
                                                                </div>
                                                                <span class="text-muted"
                                                                    style="width:30px; font-size:12px;">{{ $ratingCounts[$i] }}</span>
                                                            </div>
                                                        @endfor
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>{{-- end tab-content --}}
                        </div>
                    </div>
                </div>
            </div>{{-- end row --}}
        </div>
    </section>

    {{-- ============================================================
         KENDARAAN TERKAIT
         ============================================================ --}}
    @if ($relatedCars->count() > 0)
        <section class="ftco-section ftco-no-pt bg-light">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-12 heading-section text-center ftco-animate mb-5">
                        <span class="subheading">Pilih Kendaraan</span>
                        <h2 class="mb-2">Kendaraan Terkait</h2>
                    </div>
                </div>
                <div class="row">
                    @foreach ($relatedCars as $car)
                        <div class="col-md-4 mb-4">
                            <div class="car-wrap rounded ftco-animate">
                                <div class="img rounded overflow-hidden"
                                    style="position: relative; background-color: #f8f9fa;">
                                    <img src="{{ $car->images->where('is_primary', 1)->first()
                                        ? asset('storage/' . $car->images->where('is_primary', 1)->first()->image_path)
                                        : asset('frontend/images/car-1.jpg') }}"
                                        alt="{{ $car->brand }} {{ $car->model }}"
                                        style="width: 100%;
                                                height: auto;
                                                max-height: 220px;
                                                object-fit: contain;
                                                object-position: center;
                                                display: block;
                                                background-color: #f8f9fa;">
                                </div>
                                <div class="text">
                                    <h2 class="mb-0">
                                        <a href="{{ route('kendaraan.show', $car->id) }}">{{ $car->brand }}
                                            {{ $car->model }}</a>
                                    </h2>
                                    <div class="d-flex mb-3">
                                        <span class="cat">{{ $car->type }} - {{ $car->year }}</span>
                                        <p class="price ml-auto">Rp {{ number_format($car->price_per_day, 0, ',', '.') }}
                                            <span>/hari</span></p>
                                    </div>
                                    <p class="d-flex mb-0 d-block">
                                        <a href="{{ route('bookings.create', $car->id) }}"
                                            class="btn btn-primary py-2 mr-1">Booking</a>
                                        <a href="{{ route('kendaraan.show', $car->id) }}"
                                            class="btn btn-secondary py-2 ml-1">Detail</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

@endsection
