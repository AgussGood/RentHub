
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
                        <span>Detail Kendaraan <i class="ion-ios-arrow-forward"></i></span>
                    </p>
                    <h1 class="mb-3 bread">Detail Kendaraan</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="ftco-section ftco-car-details">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="car-details">
                        <div class="img rounded overflow-hidden"
                            style="height: 400px; position: relative; background-color: #000;">
                            <div class="img rounded overflow-hidden"
                                style="height: 400px; position: relative; background-color: #f8f9fa;">
                                <img src="{{ $kendaraan->images->where('is_primary', 1)->first()
                                    ? asset('storage/' . $kendaraan->images->where('is_primary', 1)->first()->image_path)
                                    : asset('frontend/images/bg_1.jpg') }}"
                                    alt="{{ $kendaraan->brand }} {{ $kendaraan->model }}"
                                    style="width: 100%; height: 100%; object-fit: cover; object-position: center;">
                            </div>
                        </div>
                    </div>
                    <div class="text text-center">
                        <span class="subheading">{{ $kendaraan->brand }} - {{ $kendaraan->year }}</span>
                        <h2>{{ $kendaraan->model }}</h2>
                    </div>
                </div>

                {{-- Specifications --}}
                <div class="row">
                    <div class="col-md d-flex align-self-stretch ftco-animate">
                        <div class="media block-6 services">
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
                        <div class="media block-6 services">
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
                        <div class="media block-6 services">
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
                        <div class="media block-6 services">
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

                {{-- Tabs --}}
                <div class="row">
                    <div class="col-md-12 pills">
                        <div class="bd-example bd-example-tabs">
                            <div class="d-flex justify-content-center">
                                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="pills-description-tab" data-toggle="pill"
                                            href="#pills-description" role="tab" aria-controls="pills-description"
                                            aria-expanded="true">Spesifikasi</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="pills-review-tab" data-toggle="pill" href="#pills-review"
                                            role="tab" aria-controls="pills-review" aria-expanded="true">Reviews
                                            ({{ $totalReviews }})</a>
                                    </li>
                                </ul>
                            </div>

                            <div class="tab-content" id="pills-tabContent">
                                {{-- Specifications Tab --}}
                                <div class="tab-pane fade show active" id="pills-description" role="tabpanel"
                                    aria-labelledby="pills-description-tab">

                                    {{-- Vehicle Information Card --}}
                                    <div class="card mb-4 shadow-sm">
                                        <div class="card-header bg-primary text-white">
                                            <h5 class="mb-0"><i class="fa fa-car mr-2"></i>Informasi Kendaraan</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <div class="info-item d-flex align-items-center py-2 border-bottom">
                                                        <div class="info-label"
                                                            style="width: 150px; font-weight: 600; color: #666;">
                                                            Brand
                                                        </div>
                                                        <div class="info-value" style="flex: 1; color: #333;">
                                                            {{ $kendaraan->brand }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <div class="info-item d-flex align-items-center py-2 border-bottom">
                                                        <div class="info-label"
                                                            style="width: 150px; font-weight: 600; color: #666;">
                                                            Model
                                                        </div>
                                                        <div class="info-value" style="flex: 1; color: #333;">
                                                            {{ $kendaraan->model }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <div class="info-item d-flex align-items-center py-2 border-bottom">
                                                        <div class="info-label"
                                                            style="width: 150px; font-weight: 600; color: #666;">
                                                            Tahun
                                                        </div>
                                                        <div class="info-value" style="flex: 1; color: #333;">
                                                            {{ $kendaraan->year }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <div class="info-item d-flex align-items-center py-2 border-bottom">
                                                        <div class="info-label"
                                                            style="width: 150px; font-weight: 600; color: #666;">
                                                            Type
                                                        </div>
                                                        <div class="info-value" style="flex: 1; color: #333;">
                                                            <span
                                                                class="badge badge-info">{{ ucfirst($kendaraan->type) }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <div class="info-item d-flex align-items-center py-2 border-bottom">
                                                        <div class="info-label"
                                                            style="width: 150px; font-weight: 600; color: #666;">
                                                            Warna
                                                        </div>
                                                        <div class="info-value" style="flex: 1; color: #333;">
                                                            {{ $kendaraan->color ?? 'N/A' }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <div class="info-item d-flex align-items-center py-2 border-bottom">
                                                        <div class="info-label"
                                                            style="width: 150px; font-weight: 600; color: #666;">
                                                            Plate Number
                                                        </div>
                                                        <div class="info-value" style="flex: 1; color: #333;">
                                                            <span
                                                                class="badge badge-dark">{{ $kendaraan->plate_number }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Technical Details Card --}}
                                    <div class="card mb-4 shadow-sm">
                                        <div class="card-header bg-success text-white">
                                            <h5 class="mb-0"><i class="fa fa-cog mr-2"></i>Technical Details</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <div class="info-item d-flex align-items-center py-2 border-bottom">
                                                        <div class="info-label"
                                                            style="width: 150px; font-weight: 600; color: #666;">
                                                            Engine Capacity
                                                        </div>
                                                        <div class="info-value" style="flex: 1; color: #333;">
                                                            {{ $kendaraan->detail->engine_capacity ?? 'N/A' }} CC
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <div class="info-item d-flex align-items-center py-2 border-bottom">
                                                        <div class="info-label"
                                                            style="width: 150px; font-weight: 600; color: #666;">
                                                            Fuel Type
                                                        </div>
                                                        <div class="info-value" style="flex: 1; color: #333;">
                                                            {{ $kendaraan->detail->fuel_type ?? 'N/A' }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <div class="info-item d-flex align-items-center py-2 border-bottom">
                                                        <div class="info-label"
                                                            style="width: 150px; font-weight: 600; color: #666;">
                                                            Transmission
                                                        </div>
                                                        <div class="info-value" style="flex: 1; color: #333;">
                                                            {{ $kendaraan->detail->transmission ?? 'N/A' }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <div class="info-item d-flex align-items-center py-2 border-bottom">
                                                        <div class="info-label"
                                                            style="width: 150px; font-weight: 600; color: #666;">
                                                            Seat Count
                                                        </div>
                                                        <div class="info-value" style="flex: 1; color: #333;">
                                                            {{ $kendaraan->detail->seat_count ?? 'N/A' }} Seats
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <div class="info-item d-flex align-items-center py-2 border-bottom">
                                                        <div class="info-label"
                                                            style="width: 150px; font-weight: 600; color: #666;">
                                                            Status
                                                        </div>
                                                        <div class="info-value" style="flex: 1; color: #333;">
                                                            <span
                                                                class="badge badge-{{ $kendaraan->status == 'available' ? 'success' : 'warning' }} px-3 py-2">
                                                                <i
                                                                    class="fa fa-circle mr-1"></i>{{ ucfirst($kendaraan->status) }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <div class="info-item d-flex align-items-center py-2 border-bottom">
                                                        <div class="info-label"
                                                            style="width: 150px; font-weight: 600; color: #666;">
                                                            Price per Day
                                                        </div>
                                                        <div class="info-value" style="flex: 1;">
                                                            <span class="text-primary font-weight-bold"
                                                                style="font-size: 20px;">
                                                                Rp
                                                                {{ number_format($kendaraan->price_per_day, 0, ',', '.') }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Price Summary Card --}}
                                    <div class="card mb-4 shadow-sm border-primary">
                                        <div class="card-body text-center py-4">
                                            <h5 class="text-muted mb-3">Harga Harian Rental</h5>
                                            <h2 class="text-primary mb-0" style="font-size: 42px; font-weight: bold;">
                                                Rp {{ number_format($kendaraan->price_per_day, 0, ',', '.') }}
                                            </h2>
                                            <p class="text-muted mb-4">/hari</p>
                                            <a href="{{ route('bookings.create', $kendaraan->id) }}"
                                                class="btn btn-primary btn-lg px-5 py-3 shadow">
                                                <i class="fa fa-calendar-check mr-2"></i>Booking
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                {{-- Reviews Tab --}}
                                <div class="tab-pane fade" id="pills-review" role="tabpanel"
                                    aria-labelledby="pills-review-tab">
                                    <div class="row">
                                        <div class="col-md-7">
                                            <h3 class="head mb-4">{{ $totalReviews }} Review</h3>
                                            @forelse($kendaraan->reviews as $review)
                                                <div class="card mb-3 shadow-sm">
                                                    <div class="card-body">
                                                        <div class="review d-flex">
                                                            <div class="user-img"
                                                                style="background-image: url({{ asset('frontend/images/person_1.jpg') }}); 
                                                       width: 60px; 
                                                       height: 60px; 
                                                       border-radius: 50%; 
                                                       background-size: cover;
                                                       flex-shrink: 0;">
                                                            </div>
                                                            <div class="desc ml-3 flex-grow-1">
                                                                <div
                                                                    class="d-flex justify-content-between align-items-start mb-2">
                                                                    <h5 class="mb-0">
                                                                        {{ $review->user->name ?? 'Anonymous' }}</h5>
                                                                    <small
                                                                        class="text-muted">{{ $review->created_at->format('d M Y') }}</small>
                                                                </div>
                                                                <p class="star mb-2">
                                                                    @for ($i = 1; $i <= 5; $i++)
                                                                        <i class="ion-ios-star{{ $i <= $review->rating ? '' : '-outline' }}"
                                                                            style="color: #ffc107;"></i>
                                                                    @endfor
                                                                    <span
                                                                        class="ml-2 text-muted">({{ $review->rating }}/5)</span>
                                                                </p>
                                                                <p class="mb-0">{{ $review->comment }}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @empty
                                                <div class="alert alert-info">
                                                    <i class="fa fa-info-circle mr-2"></i>
                                                    Belum ada review sekarang
                                                </div>
                                            @endforelse
                                        </div>
                                        <div class="col-md-5">
                                            <div class="card shadow-sm">
                                                <div class="card-header bg-warning text-white">
                                                    <h5 class="mb-0"><i class="fa fa-star mr-2"></i>Average Rating</h5>
                                                </div>
                                                <div class="card-body text-center">
                                                    <div class="mb-4">
                                                        <div
                                                            style="font-size: 64px; color: #01d28e; font-weight: bold; line-height: 1;">
                                                            {{ number_format($averageRating, 1) }}
                                                        </div>
                                                        <div class="mt-2">
                                                            @for ($i = 1; $i <= 5; $i++)
                                                                <i class="ion-ios-star{{ $i <= round($averageRating) ? '' : '-outline' }}"
                                                                    style="color: #ffc107; font-size: 24px;"></i>
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
                                                                <span style="width: 30px;">{{ $i }}</span>
                                                                <i class="ion-ios-star mr-2" style="color: #ffc107;"></i>
                                                                <div class="progress flex-grow-1 mr-2"
                                                                    style="height: 20px;">
                                                                    <div class="progress-bar bg-warning"
                                                                        role="progressbar"
                                                                        style="width: {{ $totalReviews > 0 ? ($ratingCounts[$i] / $totalReviews) * 100 : 0 }}%"
                                                                        aria-valuenow="{{ $totalReviews > 0 ? ($ratingCounts[$i] / $totalReviews) * 100 : 0 }}"
                                                                        aria-valuemin="0" aria-valuemax="100">
                                                                    </div>
                                                                </div>
                                                                <span class="text-muted"
                                                                    style="width: 50px;">{{ $ratingCounts[$i] }}</span>
                                                            </div>
                                                        @endfor
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>

    {{-- Related Cars --}}
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
                                    style="height: 250px; position: relative; background-color: #f8f9fa;">
                                    <img src="{{ $car->images->where('is_primary', 1)->first()
                                        ? asset('storage/' . $car->images->where('is_primary', 1)->first()->image_path)
                                        : asset('frontend/images/car-1.jpg') }}"
                                        alt="{{ $car->brand }} {{ $car->model }}"
                                        style="width: 100%; height: 100%; object-fit: contain; object-position: center;">
                                </div>
                                <div class="text">
                                    <h2 class="mb-0">
                                        <a href="{{ route('kendaraan.show', $car->id) }}">{{ $car->brand }}
                                            {{ $car->model }}</a>
                                    </h2>
                                    <div class="d-flex mb-3">
                                        <span class="cat">{{ $car->type }} - {{ $car->year }}</span>
                                        <p class="price ml-auto">Rp {{ number_format($car->price_per_day, 0, ',', '.') }}
                                            <span>/day</span>
                                        </p>
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

        
<style>
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
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}
</style>
    @endif
@endsection
