@extends('layouts.front')
@section('content')
    <section class="hero-wrap hero-wrap-2 js-fullheight" style="background-image: url('{{ asset('frontend/images/bg_3.jpg') }}');"
        data-stellar-background-ratio="0.5">
        <div class="overlay"></div>
        <div class="container">
            <div class="row no-gutters slider-text js-fullheight align-items-end justify-content-start">
                <div class="col-md-9 ftco-animate pb-5">
                    <p class="breadcrumbs">
                        <span class="mr-2">
                            <a href="{{ route('welcome') }}">Beranda <i class="ion-ios-arrow-forward"></i></a>
                        </span> 
                        <span>Kendaraan <i class="ion-ios-arrow-forward"></i></span>
                    </p>
                    <h1 class="mb-3 bread">Pilih kendaraan mu</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="ftco-section bg-light">
        <div class="container">
            <div class="row">
                @forelse($kendaraans as $kendaraan)
                    <div class="col-md-4">
                        <div class="car-wrap rounded ftco-animate">
                            <div class="img rounded d-flex align-items-end" 
                                style="background-image: url('{{ $kendaraan->images->first() 
                                    ? asset('storage/' . $kendaraan->images->first()->image_path) 
                                    : asset('images/car-default.jpg') }}');">
                            </div>
                            <div class="text">
                                <h2 class="mb-0">
                                    <a href="{{ route('car.show', $kendaraan) }}">
                                        {{ $kendaraan->brand }} {{ $kendaraan->model }}
                                    </a>
                                </h2>
                                <div class="d-flex mb-3">
                                    <span class="cat">{{ $kendaraan->type }}</span>
                                    <p class="price ml-auto">
                                        Rp {{ number_format($kendaraan->price_per_day, 0, ',', '.') }} 
                                        <span>/day</span>
                                    </p>
                                </div>
                                <p class="d-flex mb-0 d-block">
                                    @auth
                                        <a href="{{ route('bookings.create', $kendaraan->id) }}" class="btn btn-primary py-2 mr-1">Booking</a>
                                    @else
                                        <a href="{{ route('login') }}" class="btn btn-primary py-2 mr-1">Booking</a>
                                    @endauth
                                    <a href="{{ route('car.show', $kendaraan) }}" class="btn btn-secondary py-2 ml-1">Detail</a>
                                </p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-md-12 text-center py-5">
                        <div class="alert alert-info">
                            <h4>Belum Ada Kendaraan Tersedia</h4>
                            <p class="mb-0">Silakan cek kembali nanti atau hubungi admin untuk informasi lebih lanjut.</p>
                        </div>
                    </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            @if($kendaraans->hasPages())
                <div class="row mt-5">
                    <div class="col text-center">
                        <div class="block-27">
                            <ul>
                                {{-- Previous Page Link --}}
                                @if ($kendaraans->onFirstPage())
                                    <li class="disabled"><span>&lt;</span></li>
                                @else
                                    <li><a href="{{ $kendaraans->previousPageUrl() }}">&lt;</a></li>
                                @endif

                                {{-- Pagination Elements --}}
                                @foreach ($kendaraans->getUrlRange(1, $kendaraans->lastPage()) as $page => $url)
                                    @if ($page == $kendaraans->currentPage())
                                        <li class="active"><span>{{ $page }}</span></li>
                                    @else
                                        <li><a href="{{ $url }}">{{ $page }}</a></li>
                                    @endif
                                @endforeach

                                {{-- Next Page Link --}}
                                @if ($kendaraans->hasMorePages())
                                    <li><a href="{{ $kendaraans->nextPageUrl() }}">&gt;</a></li>
                                @else
                                    <li class="disabled"><span>&gt;</span></li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection