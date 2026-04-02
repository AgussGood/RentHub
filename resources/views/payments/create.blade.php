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
                        <span>Pemesanan <i class="ion-ios-arrow-forward"></i></span>
                        <span>Pembayaran <i class="ion-ios-arrow-forward"></i></span>
                    </p>
                    <h1 class="mb-3 bread">Selesaikan Pembayaran Anda</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="ftco-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-10">

                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            {{ session('error') }}
                        </div>
                    @endif

                    {{-- Validasi checkbox dari server --}}
                    @if (session('error_terms'))
                        <div class="alert alert-danger alert-dismissible fade show">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            {{ session('error_terms') }}
                        </div>
                    @endif

                    @php
                        // Tentukan metode yang dipilih dari query param atau old input
                        $selectedMethod = request()->get('payment_method') ?? old('payment_method', '');

                        // Flag visibilitas per metode
                        $showTransferInfo = ($selectedMethod === 'transfer');
                        $showEwalletInfo  = ($selectedMethod === 'e_wallet');
                        $showProofUpload  = in_array($selectedMethod, ['transfer', 'e_wallet']);
                        $showMidtransInfo = ($selectedMethod === 'midtrans');
                    @endphp

                    <div class="row">
                        {{-- Ringkasan Pemesanan --}}
                        <div class="col-md-5 mb-4">
                            <div class="card shadow-sm">
                                <div class="card-header bg-info text-white">
                                    <h5 class="mb-0">
                                        <i class="fa fa-file-invoice mr-2"></i>Ringkasan Pemesanan
                                    </h5>
                                </div>

                                <div class="card-body">

                                    {{-- Foto Kendaraan --}}
                                    <div class="img-wrapper mb-3 overflow-hidden rounded"
                                        style="height:180px; background:#f8f9fa;">
                                        <img src="{{ $booking->kendaraan->images->where('is_primary', 1)->first()
                                            ? asset('storage/' . $booking->kendaraan->images->where('is_primary', 1)->first()->image_path)
                                            : asset('frontend/images/car-1.jpg') }}"
                                            alt="{{ $booking->kendaraan->brand }}" class="w-100 h-100"
                                            style="object-fit:contain;">
                                    </div>

                                    <h5 class="mb-3">
                                        {{ $booking->kendaraan->brand }} {{ $booking->kendaraan->model }}
                                    </h5>

                                    {{-- Detail Pemesanan --}}
                                    <div class="booking-info">

                                        <div class="d-flex justify-content-between py-2 border-bottom">
                                            <span><i class="fa fa-user mr-2"></i>Pelanggan</span>
                                            <strong>{{ $booking->user->name }}</strong>
                                        </div>

                                        <div class="d-flex justify-content-between py-2 border-bottom">
                                            <span><i class="fa fa-hashtag mr-2"></i>ID Pemesanan</span>
                                            <strong>#{{ str_pad($booking->id, 6, '0', STR_PAD_LEFT) }}</strong>
                                        </div>

                                        <div class="d-flex justify-content-between py-2 border-bottom">
                                            <span><i class="fa fa-calendar-check mr-2"></i>Tanggal Mulai</span>
                                            <strong>{{ \Carbon\Carbon::parse($booking->start_date)->format('d M Y') }}</strong>
                                        </div>

                                        <div class="d-flex justify-content-between py-2 border-bottom">
                                            <span><i class="fa fa-calendar-times mr-2"></i>Tanggal Selesai</span>
                                            <strong>{{ \Carbon\Carbon::parse($booking->end_date)->format('d M Y') }}</strong>
                                        </div>

                                        <div class="d-flex justify-content-between py-2 border-bottom">
                                            <span><i class="fa fa-clock mr-2"></i>Durasi</span>
                                            <strong>{{ $booking->total_days }} hari</strong>
                                        </div>

                                        @if ($booking->pickup_location)
                                            <div class="d-flex justify-content-between py-2 border-bottom">
                                                <span><i class="fa fa-map-marker-alt mr-2"></i>Lokasi Penjemputan</span>
                                                <strong>{{ $booking->pickup_location }}</strong>
                                            </div>
                                        @endif

                                    </div>

                                    {{-- Jumlah Pembayaran --}}
                                    <div class="alert alert-warning mt-3">
                                        <small class="text-muted d-block mb-1">Jumlah Pembayaran</small>
                                        <h3 class="text-dark mb-0">
                                            Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                                        </h3>
                                    </div>

                                    {{-- Catatan --}}
                                    @if ($booking->notes)
                                        <div class="alert alert-light">
                                            <small class="text-muted">Catatan:</small><br>
                                            <small>{{ $booking->notes }}</small>
                                        </div>
                                    @endif

                                </div>
                            </div>
                        </div>


                        {{-- Form Pembayaran --}}
                        <div class="col-md-7">
                            <div class="card shadow-sm">
                                <div class="card-header bg-success text-white">
                                    <h5 class="mb-0"><i class="fa fa-credit-card mr-2"></i>Informasi Pembayaran</h5>
                                </div>
                                <div class="card-body">

                                    {{-- Form pilihan metode (GET) untuk refresh tampilan --}}
                                    <form action="{{ route('payments.create', $booking->id) }}" method="GET">
                                        <div class="form-group">
                                            <label for="payment_method">
                                                <i class="fa fa-wallet mr-1"></i>Metode Pembayaran *
                                            </label>
                                            <select class="form-control @error('payment_method') is-invalid @enderror"
                                                id="payment_method" name="payment_method" required>
                                                <option value="">-- Pilih Metode Pembayaran --</option>
                                                <option value="cash"       {{ $selectedMethod === 'cash'       ? 'selected' : '' }}>Tunai</option>
                                                <option value="transfer"   {{ $selectedMethod === 'transfer'   ? 'selected' : '' }}>Transfer Bank</option>
                                                <option value="e_wallet"   {{ $selectedMethod === 'e_wallet'   ? 'selected' : '' }}>E-Wallet</option>
                                                <option value="midtrans"   {{ $selectedMethod === 'midtrans'   ? 'selected' : '' }}>Pembayaran Online (Midtrans)</option>
                                            </select>
                                            @error('payment_method')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <button type="submit" class="btn btn-outline-primary btn-sm mb-3">
                                            <i class="fa fa-sync-alt mr-1"></i>Pilih Metode
                                        </button>
                                    </form>

                                    <hr>

                                    {{-- Info Transfer Bank (tampil hanya saat transfer dipilih) --}}
                                    @if ($showTransferInfo)
                                        <div class="card bg-light mb-3">
                                            <div class="card-body">
                                                <h6 class="mb-3"><i class="fa fa-university mr-2"></i>Detail Rekening Bank</h6>
                                                <div class="row">
                                                    <div class="col-md-6 mb-2">
                                                        <strong>Bank BCA</strong><br>
                                                        <small>1234567890</small><br>
                                                        <small>PT. Car Rental</small>
                                                    </div>
                                                    <div class="col-md-6 mb-2">
                                                        <strong>Bank Mandiri</strong><br>
                                                        <small>0987654321</small><br>
                                                        <small>PT. Car Rental</small>
                                                    </div>
                                                </div>
                                                <small class="text-muted">* Unggah bukti pembayaran setelah melakukan transfer</small>
                                            </div>
                                        </div>
                                    @endif

                                    {{-- Info E-Wallet (tampil hanya saat e_wallet dipilih) --}}
                                    @if ($showEwalletInfo)
                                        <div class="card bg-light mb-3">
                                            <div class="card-body">
                                                <h6 class="mb-3"><i class="fa fa-mobile-alt mr-2"></i>Detail E-Wallet</h6>
                                                <p><strong>GoPay / OVO / Dana:</strong> 081234567890</p>
                                                <small class="text-muted">* Unggah bukti pembayaran setelah melakukan transfer</small>
                                            </div>
                                        </div>
                                    @endif

                                    {{-- Info Midtrans (tampil hanya saat midtrans dipilih) --}}
                                    @if ($showMidtransInfo)
                                        <div class="alert alert-info">
                                            <i class="fa fa-info-circle mr-2"></i>
                                            Anda akan diarahkan ke halaman pembayaran <strong>Midtrans</strong> untuk menyelesaikan transaksi.
                                            Midtrans mendukung pembayaran dengan <strong>kartu kredit, transfer bank, e-wallet, dan QRIS</strong>.
                                        </div>
                                    @endif

                                    {{-- Upload Bukti Pembayaran (tampil untuk transfer & e_wallet) --}}
                                    @if ($showProofUpload)
                                        <form action="{{ route('payments.store') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="booking_id"     value="{{ $booking->id }}">
                                            <input type="hidden" name="amount"        value="{{ $booking->total_price }}">
                                            <input type="hidden" name="payment_method" value="{{ $selectedMethod }}">
                                            <input type="hidden" name="agree_terms"   value="1">

                                            <div class="form-group">
                                                <label for="payment_proof">
                                                    <i class="fa fa-image mr-1"></i>Unggah Bukti Pembayaran
                                                </label>
                                                <input type="file"
                                                    class="form-control-file @error('payment_proof') is-invalid @enderror"
                                                    id="payment_proof" name="payment_proof" accept="image/*">
                                                <small class="form-text text-muted">
                                                    Unggah screenshot atau foto bukti pembayaran (JPG, PNG, maks 2MB)
                                                </small>
                                                @error('payment_proof')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            {{-- Ringkasan Pembayaran --}}
                                            <div class="card bg-light mb-3">
                                                <div class="card-body">
                                                    <h6 class="mb-3">Ringkasan Pembayaran</h6>
                                                    <div class="d-flex justify-content-between py-2 border-bottom">
                                                        <span>Subtotal</span>
                                                        <strong>Rp {{ number_format($booking->total_price, 0, ',', '.') }}</strong>
                                                    </div>
                                                    <div class="d-flex justify-content-between py-2 border-bottom">
                                                        <span>Biaya Admin</span>
                                                        <strong>Rp 0</strong>
                                                    </div>
                                                    <div class="d-flex justify-content-between align-items-center pt-3 mt-2 border-top">
                                                        <h6 class="mb-0">Total Pembayaran</h6>
                                                        <h5 class="text-success mb-0">
                                                            Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                                                        </h5>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="custom-control custom-checkbox mb-3">
                                                <input type="checkbox" class="custom-control-input" id="agreeTerms" name="agree_terms" value="1" required>
                                                <label class="custom-control-label" for="agreeTerms">
                                                    Saya menyetujui <a href="#" data-toggle="modal" data-target="#termsModal">syarat dan ketentuan</a>
                                                </label>
                                            </div>

                                            <div class="form-group mb-0">
                                                <button type="submit" class="btn btn-success btn-block btn-lg">
                                                    <i class="fa fa-check-circle mr-2"></i>Selesaikan Pembayaran
                                                </button>
                                                <a href="{{ route('welcome') }}" class="btn btn-secondary btn-block mt-2">
                                                    <i class="fa fa-times mr-2"></i>Batalkan
                                                </a>
                                            </div>
                                        </form>
                                    @endif

                                    {{-- Form untuk Tunai --}}
                                    @if ($selectedMethod === 'cash')
                                        <div class="alert alert-info">
                                            <i class="fa fa-info-circle mr-2"></i>
                                            Pembayaran tunai akan dilakukan <strong>pada saat pengambilan kendaraan</strong>.
                                            Pastikan Anda membawa uang sejumlah yang tertera.
                                        </div>

                                        <form action="{{ route('payments.store') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="booking_id"     value="{{ $booking->id }}">
                                            <input type="hidden" name="amount"        value="{{ $booking->total_price }}">
                                            <input type="hidden" name="payment_method" value="cash">

                                            {{-- Ringkasan Pembayaran --}}
                                            <div class="card bg-light mb-3">
                                                <div class="card-body">
                                                    <h6 class="mb-3">Ringkasan Pembayaran</h6>
                                                    <div class="d-flex justify-content-between py-2 border-bottom">
                                                        <span>Subtotal</span>
                                                        <strong>Rp {{ number_format($booking->total_price, 0, ',', '.') }}</strong>
                                                    </div>
                                                    <div class="d-flex justify-content-between py-2 border-bottom">
                                                        <span>Biaya Admin</span>
                                                        <strong>Rp 0</strong>
                                                    </div>
                                                    <div class="d-flex justify-content-between align-items-center pt-3 mt-2 border-top">
                                                        <h6 class="mb-0">Total Pembayaran</h6>
                                                        <h5 class="text-success mb-0">
                                                            Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                                                        </h5>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="custom-control custom-checkbox mb-3">
                                                <input type="checkbox" class="custom-control-input" id="agreeTermsCash" name="agree_terms" value="1" required>
                                                <label class="custom-control-label" for="agreeTermsCash">
                                                    Saya menyetujui <a href="#" data-toggle="modal" data-target="#termsModal">syarat dan ketentuan</a>
                                                </label>
                                            </div>

                                            <div class="form-group mb-0">
                                                <button type="submit" class="btn btn-success btn-block btn-lg">
                                                    <i class="fa fa-check-circle mr-2"></i>Konfirmasi Pemesanan
                                                </button>
                                                <a href="{{ route('welcome') }}" class="btn btn-secondary btn-block mt-2">
                                                    <i class="fa fa-times mr-2"></i>Batalkan
                                                </a>
                                            </div>
                                        </form>
                                    @endif

                                    {{-- Form untuk Midtrans --}}
                                    @if ($showMidtransInfo)
                                        <form action="{{ route('payments.midtrans.redirect', $booking->id) }}" method="POST">
                                            @csrf

                                            {{-- Ringkasan Pembayaran --}}
                                            <div class="card bg-light mb-3">
                                                <div class="card-body">
                                                    <h6 class="mb-3">Ringkasan Pembayaran</h6>
                                                    <div class="d-flex justify-content-between py-2 border-bottom">
                                                        <span>Subtotal</span>
                                                        <strong>Rp {{ number_format($booking->total_price, 0, ',', '.') }}</strong>
                                                    </div>
                                                    <div class="d-flex justify-content-between py-2 border-bottom">
                                                        <span>Biaya Admin</span>
                                                        <strong>Rp 0</strong>
                                                    </div>
                                                    <div class="d-flex justify-content-between align-items-center pt-3 mt-2 border-top">
                                                        <h6 class="mb-0">Total Pembayaran</h6>
                                                        <h5 class="text-success mb-0">
                                                            Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                                                        </h5>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="custom-control custom-checkbox mb-3">
                                                <input type="checkbox" class="custom-control-input" id="agreeTermsMidtrans" name="agree_terms" value="1" required>
                                                <label class="custom-control-label" for="agreeTermsMidtrans">
                                                    Saya menyetujui <a href="#" data-toggle="modal" data-target="#termsModal">syarat dan ketentuan</a>
                                                </label>
                                            </div>

                                            <div class="form-group mb-0">
                                                <button type="submit" class="btn btn-success btn-block btn-lg">
                                                    <i class="fa fa-credit-card mr-2"></i>Lanjutkan ke Pembayaran Midtrans
                                                </button>
                                                <a href="{{ route('welcome') }}" class="btn btn-secondary btn-block mt-2">
                                                    <i class="fa fa-times mr-2"></i>Batalkan
                                                </a>
                                            </div>
                                        </form>
                                    @endif

                                    {{-- Pesan default jika belum pilih metode --}}
                                    @if (!$selectedMethod)
                                        <div class="alert alert-info">
                                            <i class="fa fa-info-circle mr-2"></i>
                                            Silakan pilih metode pembayaran di atas untuk melanjutkan.
                                        </div>
                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Modal Syarat & Ketentuan --}}
    <div class="modal fade" id="termsModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Syarat dan Ketentuan</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h6>Ketentuan Sewa Mobil:</h6>
                    <ul>
                        <li>Diperlukan SIM yang masih berlaku</li>
                        <li>Usia minimum 21 tahun</li>
                        <li>Pembayaran penuh diperlukan sebelum pengambilan kendaraan</li>
                        <li>Kendaraan harus dikembalikan tepat waktu</li>
                        <li>Tidak ada pengembalian dana untuk pengembalian lebih awal</li>
                        <li>Biaya tambahan akan dikenakan untuk pengembalian yang terlambat</li>
                        <li>Pelanggan bertanggung jawab atas segala kerusakan</li>
                        <li>Kendaraan harus dikembalikan dengan tangki bahan bakar penuh</li>
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Saya Memahami</button>
                </div>
            </div>
        </div>
    </div>
@endsection