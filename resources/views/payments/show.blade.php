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
                        <span>Detail Pembayaran <i class="ion-ios-arrow-forward"></i></span>
                    </p>
                    <h1 class="mb-3 bread">Detail Pembayaran</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="ftco-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">

                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <i class="fa fa-check-circle mr-2"></i>{{ session('success') }}
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

                    <div class="card shadow">
                        <div
                            class="card-header {{ $payment->payment_status === 'paid' ? 'bg-success' : ($payment->payment_status === 'pending' ? 'bg-warning' : 'bg-danger') }} text-white text-center">
                            <h4>
                                <i
                                    class="fa {{ $payment->payment_status === 'paid' ? 'fa-check-circle' : ($payment->payment_status === 'pending' ? 'fa-clock' : 'fa-times-circle') }} mr-2"></i>
                                {{ $payment->payment_status === 'paid' ? 'Pembayaran Berhasil' : ($payment->payment_status === 'pending' ? 'Pembayaran Pending' : 'Pembayaran Gagal') }}
                            </h4>
                        </div>
                        <div class="card-body">

                            @if ($payment->payment_status === 'paid')
                                <div class="text-center mb-4">
                                    <i class="fa fa-check-circle text-success" style="font-size: 80px;"></i>
                                    <h5 class="mt-3">Terima kasih! Pembayaran Anda telah diterima</h5>
                                </div>
                            @elseif($payment->payment_status === 'pending')
                                <div class="text-center mb-4">
                                    <i class="fa fa-clock text-warning" style="font-size: 80px;"></i>
                                    <h5 class="mt-3">Pembayaran Anda sedang diproses</h5>
                                </div>
                            @endif

                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tr>
                                        <th width="40%">ID Pembayaran</th>
                                        <td>#{{ str_pad($payment->id, 6, '0', STR_PAD_LEFT) }}</td>
                                    </tr>
                                    <tr>
                                        <th>ID Pemesanan</th>
                                        <td>
                                            <a href="{{ route('bookings.show', $payment->booking->id) }}">
                                                #{{ str_pad($payment->booking->id, 6, '0', STR_PAD_LEFT) }}
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Kendaraan</th>
                                        <td>{{ $payment->booking->kendaraan->brand }}
                                            {{ $payment->booking->kendaraan->model }}</td>
                                    </tr>
                                    <tr>
                                        <th>Metode Pembayaran</th>
                                        <td>
                                            @if ($payment->payment_method === 'midtrans')
                                                <span class="badge badge-primary">Midtrans Online</span>
                                            @elseif($payment->payment_method === 'transfer')
                                                <span class="badge badge-info">Transfer Bank</span>
                                            @elseif($payment->payment_method === 'e_wallet')
                                                <span class="badge badge-warning">E-Wallet</span>
                                            @else
                                                <span class="badge badge-secondary">Tunai</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Jumlah Pembayaran</th>
                                        <td><strong class="text-success">Rp
                                                {{ number_format($payment->amount, 0, ',', '.') }}</strong></td>
                                    </tr>
                                    <tr>
                                        <th>Status Pembayaran</th>
                                        <td>
                                            @if ($payment->payment_status === 'paid')
                                                <span class="badge badge-success">Lunas</span>
                                            @elseif($payment->payment_status === 'pending')
                                                <span class="badge badge-warning">Pending</span>
                                            @else
                                                <span class="badge badge-danger">Gagal</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Tanggal Pembayaran</th>
                                        <td>
                                            {{ $payment->payment_date ? $payment->payment_date->format('d M Y') . ' WIB' : '-' }}
                                        </td>

                                    </tr>
                                    @if ($payment->midtrans_order_id)
                                        <tr>
                                            <th>Order ID Midtrans</th>
                                            <td><code>{{ $payment->midtrans_order_id }}</code></td>
                                        </tr>
                                    @endif
                                    @if ($payment->midtrans_transaction_id)
                                        <tr>
                                            <th>ID Transaksi Midtrans</th>
                                            <td><code>{{ $payment->midtrans_transaction_id }}</code></td>
                                        </tr>
                                    @endif
                                </table>
                            </div>

                            <div class="text-center mt-4">
                                <a href="{{ route('bookings.show', $payment->booking->id) }}"
                                    class="btn btn-primary btn-lg">
                                    <i class="fa fa-eye mr-2"></i>Lihat Detail Pemesanan
                                </a>
                                <a href="{{ route('welcome') }}" class="btn btn-outline-secondary btn-lg ml-2">
                                    <i class="fa fa-home mr-2"></i>Kembali ke Beranda
                                </a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
