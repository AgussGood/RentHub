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
                    </p>
                    <h1 class="mb-3 bread">Pesan Mobil Anda</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="ftco-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            {{ session('error') }}
                        </div>
                    @endif

                    @php
                        $startDate = request()->get('start_date') ?? old('start_date', date('Y-m-d'));
                        $endDate   = request()->get('end_date') ?? old('end_date', '');

                        $totalDays  = 1;
                        $totalPrice = $kendaraan->price_per_day;

                        if ($startDate && $endDate) {
                            $start = new DateTime($startDate);
                            $end   = new DateTime($endDate);
                            $diff  = $start->diff($end);
                            $totalDays = max(1, $diff->days + 1);
                        }

                        $totalPrice = $totalDays * $kendaraan->price_per_day;
                    @endphp

                    <div class="row">
                        <div class="col-md-5 mb-4">
                            <div class="card shadow-sm">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="mb-0"><i class="fa fa-car mr-2"></i>Detail Kendaraan</h5>
                                </div>
                                <div class="card-body">
                                    <div class="img-wrapper mb-3 overflow-hidden rounded"
                                        style="height: 200px; background-color: #f8f9fa;">
                                        <img src="{{ $kendaraan->images->where('is_primary', 1)->first()
                                            ? asset('storage/' . $kendaraan->images->where('is_primary', 1)->first()->image_path)
                                            : asset('frontend/images/car-1.jpg') }}"
                                            alt="{{ $kendaraan->brand }} {{ $kendaraan->model }}"
                                            style="width: 100%; height: 100%; object-fit: contain;">
                                    </div>
                                    <h4 class="mb-3">{{ $kendaraan->brand }} {{ $kendaraan->model }}</h4>

                                    <div class="vehicle-details">
                                        <div class="detail-row d-flex justify-content-between py-2 border-bottom">
                                            <span><i class="fa fa-calendar mr-2"></i>Tahun</span>
                                            <strong>{{ $kendaraan->year }}</strong>
                                        </div>
                                        <div class="detail-row d-flex justify-content-between py-2 border-bottom">
                                            <span><i class="fa fa-car mr-2"></i>Jenis</span>
                                            <strong>{{ ucfirst($kendaraan->type) }}</strong>
                                        </div>
                                        <div class="detail-row d-flex justify-content-between py-2 border-bottom">
                                            <span><i class="fa fa-cog mr-2"></i>Transmisi</span>
                                            <strong>{{ $kendaraan->detail->transmission ?? 'N/A' }}</strong>
                                        </div>
                                        <div class="detail-row d-flex justify-content-between py-2 border-bottom">
                                            <span><i class="fa fa-gas-pump mr-2"></i>Bahan Bakar</span>
                                            <strong>{{ $kendaraan->detail->fuel_type ?? 'N/A' }}</strong>
                                        </div>
                                        <div class="detail-row d-flex justify-content-between py-2">
                                            <span><i class="fa fa-users mr-2"></i>Kursi</span>
                                            <strong>{{ $kendaraan->detail->seat_count ?? 'N/A' }} Kursi</strong>
                                        </div>
                                    </div>

                                    <div class="alert alert-success mt-3">
                                        <h5 class="mb-2">Harga Sewa</h5>
                                        <h3 class="text-primary mb-0">
                                            Rp {{ number_format($kendaraan->price_per_day, 0, ',', '.') }}
                                            <small class="text-muted">/hari</small>
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-7">
                            <div class="card shadow-sm">
                                <div class="card-header bg-success text-white">
                                    <h5 class="mb-0"><i class="fa fa-edit mr-2"></i>Informasi Pemesanan</h5>
                                </div>
                                <div class="card-body">

                                    <form action="{{ route('bookings.create', $kendaraan->id) }}" method="GET">
                                        <div class="form-group">
                                            <label for="start_date">
                                                <i class="fa fa-calendar-check mr-1"></i>Tanggal Mulai *
                                            </label>
                                            <input type="date"
                                                class="form-control @error('start_date') is-invalid @enderror"
                                                id="start_date" name="start_date"
                                                value="{{ $startDate }}"
                                                min="{{ date('Y-m-d') }}"
                                                required>
                                            @error('start_date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="end_date">
                                                <i class="fa fa-calendar-times mr-1"></i>Tanggal Selesai *
                                            </label>
                                            <input type="date"
                                                class="form-control @error('end_date') is-invalid @enderror"
                                                id="end_date" name="end_date"
                                                value="{{ $endDate }}"
                                                min="{{ $startDate }}"
                                                required>
                                            @error('end_date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <button type="submit" class="btn btn-outline-primary btn-sm">
                                                <i class="fa fa-sync-alt mr-1"></i>Hitung Ulang Harga
                                            </button>
                                        </div>
                                    </form>

                                    <hr>

                                    <form action="{{ route('bookings.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="kendaraan_id"   value="{{ $kendaraan->id }}">
                                        <input type="hidden" name="start_date"    value="{{ $startDate }}">
                                        <input type="hidden" name="end_date"      value="{{ $endDate }}">

                                        <div class="form-group">
                                            <label for="pickup_location">
                                                <i class="fa fa-map-marker-alt mr-1"></i>Lokasi Penjemputan
                                            </label>
                                            <input type="text"
                                                class="form-control @error('pickup_location') is-invalid @enderror"
                                                id="pickup_location" name="pickup_location"
                                                value="{{ old('pickup_location') }}"
                                                placeholder="Misal: Bandara Soekarno-Hatta, Nama Hotel, dll.">
                                            @error('pickup_location')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="notes">
                                                <i class="fa fa-sticky-note mr-1"></i>Catatan Tambahan
                                            </label>
                                            <textarea
                                                class="form-control @error('notes') is-invalid @enderror"
                                                id="notes" name="notes" rows="3"
                                                placeholder="Permintaan khusus atau informasi tambahan...">{{ old('notes') }}</textarea>
                                            @error('notes')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="card bg-light mb-3">
                                            <div class="card-body">
                                                <h6 class="mb-3">Ringkasan Pemesanan</h6>

                                                <div class="d-flex justify-content-between py-2 border-bottom">
                                                    <span><i class="fa fa-tag mr-2"></i>Harga per hari</span>
                                                    <strong>
                                                        Rp {{ number_format($kendaraan->price_per_day, 0, ',', '.') }}
                                                    </strong>
                                                </div>

                                                <div class="d-flex justify-content-between py-2 border-bottom">
                                                    <span><i class="fa fa-clock mr-2"></i>Jumlah hari</span>
                                                    <strong>
                                                        {{ $totalDays }} hari
                                                    </strong>
                                                </div>

                                                <div class="d-flex justify-content-between py-2 border-bottom">
                                                    <span><i class="fa fa-calendar-check mr-2"></i>Tanggal Mulai</span>
                                                    <strong>
                                                        @if ($startDate)
                                                            {{ (new DateTime($startDate))->format('d M Y') }}
                                                        @else
                                                            -
                                                        @endif
                                                    </strong>
                                                </div>

                                                <div class="d-flex justify-content-between py-2 border-bottom">
                                                    <span><i class="fa fa-calendar-times mr-2"></i>Tanggal Selesai</span>
                                                    <strong>
                                                        @if ($endDate)
                                                            {{ (new DateTime($endDate))->format('d M Y') }}
                                                        @else
                                                            -
                                                        @endif
                                                    </strong>
                                                </div>

                                                <div class="d-flex justify-content-between py-3 mt-2 border-top">
                                                    <h6 class="mb-0">Total Harga</h6>
                                                    <h5 class="text-primary mb-0">
                                                        Rp {{ number_format($totalPrice, 0, ',', '.') }}
                                                    </h5>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group mb-0">
                                            <button type="submit" class="btn btn-primary btn-block btn-lg">
                                                <i class="fa fa-arrow-right mr-2"></i>Lanjutkan ke Pembayaran
                                            </button>
                                            <a href="{{ route('kendaraan.show', $kendaraan->id) }}"
                                                class="btn btn-secondary btn-block mt-2">
                                                <i class="fa fa-arrow-left mr-2"></i>Kembali ke Detail Kendaraan
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