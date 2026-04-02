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
                        <span class="mr-2"><a href="{{ route('returns.show', $return->id) }}">Pengembalian <i
                                    class="ion-ios-arrow-forward"></i></a></span>
                        <span>Pembayaran Denda <i class="ion-ios-arrow-forward"></i></span>
                    </p>
                    <h1 class="mb-3 bread">Pembayaran Denda</h1>
                </div>
            </div>
        </div>
    </section>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


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

                    @if (session('error_terms'))
                        <div class="alert alert-warning alert-dismissible fade show">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <i class="fa fa-exclamation-triangle mr-2"></i>{{ session('error_terms') }}
                        </div>
                    @endif

                    <div class="row">
                        {{-- Informasi Denda --}}
                        <div class="col-md-5 mb-4">
                            <div class="card shadow-sm border-0">
                                <div class="card-header bg-danger text-white">
                                    <h5 class="mb-0"><i class="fa fa-exclamation-circle mr-2"></i>Rincian Denda</h5>
                                </div>
                                <div class="card-body">
                                    @php
                                        $primaryImage = $return->booking->kendaraan->images->where('is_primary', 1)->first();
                                        $imageUrl = $primaryImage 
                                            ? asset('storage/' . $primaryImage->image_path)
                                            : asset('frontend/images/car-1.jpg');
                                    @endphp
                                    <div class="mb-3 rounded overflow-hidden" style="height:180px; background:#f8f9fa;">
                                        <img src="{{ $imageUrl }}"
                                            alt="{{ $return->booking->kendaraan->brand }}" class="w-100 h-100"
                                            style="object-fit:cover;">
                                    </div>

                                    <h4 class="mb-3">{{ $return->booking->kendaraan->brand }}
                                        {{ $return->booking->kendaraan->model }}</h4>

                                    <div class="border-bottom pb-2 mb-2">
                                        <small class="text-muted">ID Pengembalian</small>
                                        <br><strong>#{{ str_pad($return->id, 6, '0', STR_PAD_LEFT) }}</strong>
                                    </div>

                                    <div class="border-bottom pb-2 mb-2">
                                        <small class="text-muted">ID Booking</small>
                                        <br><strong>#{{ str_pad($return->booking->id, 6, '0', STR_PAD_LEFT) }}</strong>
                                    </div>

                                    <hr class="my-3">

                                    <h6 class="font-weight-bold mb-3">Rincian Biaya:</h6>

                                    @if ($return->late_fee > 0)
                                        <div class="d-flex justify-content-between mb-2">
                                            <span><i class="fa fa-clock text-warning mr-1"></i>Denda Keterlambatan</span>
                                            <strong class="text-warning">Rp
                                                {{ number_format($return->late_fee, 0, ',', '.') }}</strong>
                                        </div>
                                        <small class="text-muted d-block mb-3">{{ $return->late_days }} hari terlambat
                                            × 20%</small>
                                    @endif

                                    @if ($return->damage_fee > 0)
                                        <div class="d-flex justify-content-between mb-2">
                                            <span><i class="fa fa-wrench text-danger mr-1"></i>Biaya Perbaikan</span>
                                            <strong class="text-danger">Rp
                                                {{ number_format($return->damage_fee, 0, ',', '.') }}</strong>
                                        </div>
                                    @endif

                                    <hr class="my-3">

                                    <div class="d-flex justify-content-between align-items-center p-3 bg-danger text-white rounded">
                                        <h5 class="mb-0">Total Denda</h5>
                                        <h3 class="mb-0">Rp {{ number_format($return->total_penalty, 0, ',', '.') }}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Form Pembayaran --}}
                        <div class="col-md-7">
                            <div class="card shadow-sm border-0">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="mb-0"><i class="fa fa-credit-card mr-2"></i>Metode Pembayaran</h5>
                                </div>
                                <div class="card-body">
                                    {{-- Midtrans --}}
                                    <div class="card border-primary mb-3">
                                        <div class="card-header bg-light">
                                            <h6 class="mb-0"><i class="fa fa-wallet mr-2"></i>Pembayaran Digital (Midtrans)
                                            </h6>
                                        </div>
                                        <div class="card-body">
                                            <p class="mb-3">Bayar menggunakan berbagai metode digital:</p>
                                            <ul class="mb-3">
                                                <li>E-Wallet (GoPay, OVO, DANA, ShopeePay)</li>
                                                <li>Transfer Bank (BCA, Mandiri, BNI, BRI)</li>
                                                <li>Kartu Kredit/Debit</li>
                                                <li>Indomaret/Alfamart</li>
                                            </ul>
                                            <form action="{{ route('payments.penalty.midtrans.redirect', $return->id) }}"
                                                method="POST">
                                                @csrf
                                                <div class="custom-control custom-checkbox mb-3">
                                                    <input type="checkbox" class="custom-control-input" id="agree_terms_midtrans"
                                                        name="agree_terms" value="1" required>
                                                    <label class="custom-control-label" for="agree_terms_midtrans">
                                                        Saya setuju dengan syarat dan ketentuan pembayaran denda
                                                    </label>
                                                </div>
                                                <button type="submit" class="btn btn-primary btn-block btn-lg">
                                                    <i class="fa fa-arrow-right mr-2"></i>Bayar dengan Midtrans
                                                </button>
                                            </form>
                                        </div>
                                    </div>

                                    {{-- Manual Payment --}}
                                    <div class="card border-secondary">
                                        <div class="card-header bg-light">
                                            <h6 class="mb-0"><i class="fa fa-money-bill mr-2"></i>Pembayaran Manual</h6>
                                        </div>
                                        <div class="card-body">
                                            <form action="{{ route('payments.penalty.store') }}" method="POST"
                                                enctype="multipart/form-data">
                                                @csrf
                                                <input type="hidden" name="return_id" value="{{ $return->id }}">
                                                <input type="hidden" name="amount" value="{{ $return->total_penalty }}">

                                                <div class="form-group">
                                                    <label>Metode Pembayaran *</label>
                                                    <select name="payment_method" class="form-control" required>
                                                        <option value="">Pilih Metode</option>
                                                        <option value="cash">Tunai</option>
                                                        <option value="transfer">Transfer Bank</option>
                                                        <option value="e_wallet">E-Wallet</option>
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label>Bukti Pembayaran (Opsional)</label>
                                                    <input type="file" name="payment_proof" class="form-control"
                                                        accept="image/*">
                                                    <small class="text-muted">Format: JPG, PNG (Max: 2MB)</small>
                                                </div>

                                                <div class="custom-control custom-checkbox mb-3">
                                                    <input type="checkbox" class="custom-control-input"
                                                        id="agree_terms_manual" name="agree_terms" value="1" required>
                                                    <label class="custom-control-label" for="agree_terms_manual">
                                                        Saya setuju dengan syarat dan ketentuan pembayaran denda
                                                    </label>
                                                </div>

                                                <button type="submit" class="btn btn-secondary btn-block btn-lg">
                                                    <i class="fa fa-check mr-2"></i>Kirim Pembayaran Manual
                                                </button>
                                            </form>
                                        </div>
                                    </div>

                                    <div class="text-center mt-3">
                                        <a href="{{ route('returns.show', $return->id) }}" class="btn btn-link">
                                            <i class="fa fa-arrow-left mr-1"></i>Kembali ke Bukti Pengembalian
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection