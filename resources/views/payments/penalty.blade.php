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
        <div class="container mt-3">
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
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

                                    {{-- Gambar Kendaraan: tidak terpotong di HP --}}
                                    <div class="penalty-img-wrapper mb-3">
                                        <img src="{{ $imageUrl }}"
                                            alt="{{ $return->booking->kendaraan->brand }}"
                                            class="penalty-img-responsive">
                                    </div>

                                    <h4 class="mb-3 vehicle-name">
                                        {{ $return->booking->kendaraan->brand }}
                                        {{ $return->booking->kendaraan->model }}
                                    </h4>

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
                                        <div class="fee-row mb-2">
                                            <span><i class="fa fa-clock text-warning mr-1"></i>Denda Keterlambatan</span>
                                            <strong class="text-warning">Rp {{ number_format($return->late_fee, 0, ',', '.') }}</strong>
                                        </div>
                                        <small class="text-muted d-block mb-3">
                                            {{ $return->late_days }} hari terlambat × 20%
                                        </small>
                                    @endif

                                    @if ($return->damage_fee > 0)
                                        <div class="fee-row mb-2">
                                            <span><i class="fa fa-wrench text-danger mr-1"></i>Biaya Perbaikan</span>
                                            <strong class="text-danger">Rp {{ number_format($return->damage_fee, 0, ',', '.') }}</strong>
                                        </div>
                                    @endif

                                    <hr class="my-3">

                                    {{-- Total Denda --}}
                                    <div class="total-denda-box">
                                        <span class="total-denda-label">Total Denda</span>
                                        <span class="total-denda-amount">Rp {{ number_format($return->total_penalty, 0, ',', '.') }}</span>
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
                                            <h6 class="mb-0"><i class="fa fa-wallet mr-2"></i>Pembayaran Digital (Midtrans)</h6>
                                        </div>
                                        <div class="card-body">
                                            <p class="mb-2">Bayar menggunakan berbagai metode digital:</p>
                                            <ul class="payment-list mb-3">
                                                <li>E-Wallet (GoPay, OVO, DANA, ShopeePay)</li>
                                                <li>Transfer Bank (BCA, Mandiri, BNI, BRI)</li>
                                                <li>Kartu Kredit/Debit</li>
                                                <li>Indomaret/Alfamart</li>
                                            </ul>
                                            <form action="{{ route('payments.penalty.midtrans.redirect', $return->id) }}"
                                                method="POST">
                                                @csrf
                                                <div class="custom-control custom-checkbox mb-3">
                                                    <input type="checkbox" class="custom-control-input"
                                                        id="agree_terms_midtrans" name="agree_terms" value="1" required>
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
                                                    <input type="file" name="payment_proof" class="form-control-file"
                                                        accept="image/*">
                                                    <small class="text-muted">Format: JPG, PNG (Maks: 2MB)</small>
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

@push('styles')
<style>
    /* ===== GAMBAR KENDARAAN - TIDAK TERPOTONG ===== */
    .penalty-img-wrapper {
        width: 100%;
        border-radius: 8px;
        overflow: hidden;
        background: #f8f9fa;
        box-shadow: 0 2px 6px rgba(0,0,0,0.08);
    }

    /* Mobile: tinggi otomatis, gambar utuh */
    .penalty-img-responsive {
        width: 100%;
        height: auto;
        display: block;
        object-fit: contain;
        max-height: 260px;
    }

    /* Desktop: cover dengan tinggi tetap */
    @media (min-width: 768px) {
        .penalty-img-responsive {
            height: 180px;
            object-fit: cover;
        }
    }

    /* ===== NAMA KENDARAAN ===== */
    .vehicle-name {
        font-size: 1.15rem;
        word-break: break-word;
        line-height: 1.4;
    }

    /* ===== BARIS BIAYA (mengganti d-flex justify-content-between) ===== */
    .fee-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 4px;
    }

    .fee-row span {
        font-size: 0.9rem;
    }

    /* ===== TOTAL DENDA BOX ===== */
    .total-denda-box {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 8px;
        background: #dc3545;
        color: #fff;
        padding: 14px 16px;
        border-radius: 8px;
    }

    .total-denda-label {
        font-size: 1.05rem;
        font-weight: 600;
    }

    .total-denda-amount {
        font-size: 1.3rem;
        font-weight: 700;
        word-break: break-all;
    }

    /* Di HP sangat kecil: stack vertikal */
    @media (max-width: 400px) {
        .total-denda-box {
            flex-direction: column;
            align-items: flex-start;
        }

        .total-denda-amount {
            font-size: 1.15rem;
        }
    }

    /* ===== LIST METODE PEMBAYARAN ===== */
    .payment-list {
        padding-left: 1.2rem;
        margin-bottom: 0;
    }

    .payment-list li {
        font-size: 0.9rem;
        margin-bottom: 4px;
    }

    /* ===== CARD BODY & FORM DI HP ===== */
    @media (max-width: 576px) {
        .card-body {
            padding: 1rem !important;
        }

        .card-header h5,
        .card-header h6 {
            font-size: 0.95rem;
        }

        /* Mencegah auto-zoom di iOS */
        .form-control,
        select.form-control {
            font-size: 16px;
        }

        .btn-lg {
            font-size: 1rem;
            padding: 0.6rem 1rem;
        }

        /* Checkbox label lebih rapi */
        .custom-control-label {
            font-size: 0.88rem;
            line-height: 1.5;
        }

        /* Error list rapi */
        .alert ul {
            padding-left: 1.2rem;
            margin-bottom: 0;
        }

        .vehicle-name {
            font-size: 1rem;
        }
    }

    /* ===== CONTAINER PADDING DI HP ===== */
    @media (max-width: 576px) {
        .ftco-section .container {
            padding-left: 12px;
            padding-right: 12px;
        }
    }

    /* ===== PASTIKAN GAMBAR TIDAK OVERFLOW ===== */
    .penalty-img-wrapper img {
        max-width: 100%;
    }

    /* ===== FILE INPUT LEBIH RAPI ===== */
    .form-control-file {
        display: block;
        width: 100%;
        font-size: 0.9rem;
        padding: 4px 0;
    }
</style>
@endpush