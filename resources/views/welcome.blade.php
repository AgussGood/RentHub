@extends('layouts.front')
@section('content')

<style>
/* ================================================================
   HERO - Base (desktop)
   ================================================================ */
.hero-wrap {
    position: relative;
    background-size: cover !important;
    background-position: center center !important;
    background-attachment: fixed;
    background-repeat: no-repeat !important;
}

/* ================================================================
   MOBILE  ≤ 767px
   ================================================================ */
@media (max-width: 767.98px) {

    /* ── HERO ── */
    .hero-wrap {
        min-height: 100svh !important;
        min-height: 100vh !important; /* fallback */
        padding: 0 !important;
        background-size: cover !important;
        background-position: center center !important;
        background-attachment: scroll !important; /* WAJIB di iOS/Android */
        display: flex !important;
        align-items: center !important;
    }

    .hero-wrap .overlay {
        position: absolute !important;
        inset: 0 !important;
        background: rgba(0, 0, 0, 0.55) !important;
        z-index: 1 !important;
    }

    .hero-wrap .container {
        position: relative !important;
        z-index: 2 !important;
        padding-top: 90px !important;
        padding-bottom: 60px !important;
    }

    .hero-wrap .text h1 {
        font-size: 26px !important;
        line-height: 1.35 !important;
        margin-bottom: 14px !important;
        color: #fff !important;
    }

    .hero-wrap .text p {
        font-size: 14px !important;
        line-height: 1.65 !important;
        color: rgba(255,255,255,.85) !important;
    }

    /* ── PLAY BUTTON WRAP ── */
    .hero-wrap .icon-wrap {
        flex-direction: column !important;
        align-items: center !important;
        gap: 8px !important;
        margin-top: 20px !important;
    }

    .hero-wrap .icon-wrap .icon {
        width: 56px !important;
        height: 56px !important;
        min-width: 56px !important;
    }

    .hero-wrap .icon-wrap .heading-title {
        margin-left: 0 !important;
        text-align: center !important;
        font-size: 13px !important;
    }

    /* ── FORM RENCANAKAN ── */
    .request-form {
        border-radius: 8px !important;
        padding: 20px 16px !important;
        margin: 0 !important;
    }

    .request-form h2 {
        font-size: 18px !important;
        margin-bottom: 16px !important;
    }

    .request-form .d-flex {
        flex-direction: column !important;
        gap: 0 !important;
    }

    .request-form .d-flex .form-group {
        margin-right: 0 !important;
        margin-left: 0 !important;
        width: 100% !important;
    }

    /* ── SERVICES WRAP ── */
    .services-wrap {
        padding: 24px 16px !important;
        border-radius: 0 !important;
    }

    .services-wrap h3 {
        font-size: 16px !important;
        line-height: 1.4 !important;
    }

    .services-wrap .row.d-flex {
        flex-direction: column !important;
        gap: 12px !important;
        margin-bottom: 0 !important;
    }

    .services-wrap .col-md-4 {
        width: 100% !important;
        max-width: 100% !important;
        flex: 0 0 100% !important;
        padding: 0 !important;
    }

    .services-wrap .services {
        padding: 14px 12px !important;
    }

    .services-wrap .services .icon {
        width: 50px !important;
        height: 50px !important;
        margin: 0 auto 8px !important;
        font-size: 20px !important;
    }

    /* ── CARD KENDARAAN ── */
    .car-wrap .img {
        height: 200px !important;
    }

    .car-wrap .text {
        padding: 14px 12px !important;
    }

    .car-wrap .text h2 {
        font-size: 15px !important;
        margin-bottom: 4px !important;
    }

    .car-wrap .text .d-flex {
        flex-wrap: wrap !important;
        gap: 4px !important;
        align-items: center !important;
    }

    .car-wrap .text p.d-flex {
        flex-direction: row !important;
        gap: 8px !important;
        margin-top: 8px !important;
    }

    .car-wrap .text .btn {
        flex: 1 !important;
        text-align: center !important;
        padding: 8px 6px !important;
        font-size: 13px !important;
    }

    .car-wrap .text .price {
        font-size: 14px !important;
        margin-left: auto !important;
    }

    /* ── ABOUT ── */
    .ftco-about .col-md-6.img.img-2 {
        min-height: 240px !important;
        width: 100% !important;
        max-width: 100% !important;
        flex: 0 0 100% !important;
        background-attachment: scroll !important;
        background-size: cover !important;
        background-position: center !important;
    }

    .ftco-about .wrap-about {
        padding: 28px 20px !important;
    }

    .ftco-about .heading-section h2 {
        font-size: 20px !important;
    }

    /* ── LAYANAN 4 ICON ── */
    .services.services-2 {
        padding: 18px 14px !important;
        margin-bottom: 14px !important;
    }

    .services.services-2 .icon {
        width: 60px !important;
        height: 60px !important;
        margin: 0 auto 10px !important;
        font-size: 22px !important;
    }

    .services.services-2 .heading {
        font-size: 14px !important;
        margin-bottom: 6px !important;
    }

    .services.services-2 p {
        font-size: 12px !important;
        line-height: 1.5 !important;
    }

    /* ── INTRO CTA ── */
    .ftco-intro {
        padding: 50px 0 !important;
        background-attachment: scroll !important;
        background-size: cover !important;
        background-position: center !important;
    }

    .ftco-intro .heading-section-white h2 {
        font-size: 18px !important;
        line-height: 1.5 !important;
        margin-bottom: 20px !important;
    }

    .ftco-intro .btn-lg {
        font-size: 14px !important;
        padding: 10px 24px !important;
        display: inline-block !important;
    }

    /* ── ULASAN / REVIEW ── */
    .blog-entry {
        margin-bottom: 28px !important;
        width: 100% !important;
    }

    .blog-entry .block-20 {
        height: 180px !important;
        background-size: cover !important;
        background-position: center !important;
    }

    .blog-entry .text {
        padding: 12px 0 !important;
    }

    .blog-entry .text h3 {
        font-size: 15px !important;
    }

    .blog-entry .text p {
        font-size: 12px !important;
        line-height: 1.5 !important;
    }

    .blog-entry .meta {
        font-size: 12px !important;
    }

    .admin-response {
        font-size: 11px !important;
    }

    /* ── COUNTER ── */
    .ftco-counter .block-18 {
        margin-bottom: 20px !important;
        justify-content: center !important;
    }

    .ftco-counter .number {
        font-size: 38px !important;
    }

    .ftco-counter span {
        font-size: 12px !important;
    }

    /* ── PAGINATION ── */
    .pagination {
        flex-wrap: wrap !important;
        justify-content: center !important;
        gap: 4px !important;
    }

    .page-link {
        padding: 5px 9px !important;
        font-size: 12px !important;
    }

    /* ── SECTION SPACING ── */
    .ftco-section {
        padding: 36px 0 !important;
    }

    .featured-top {
        margin-top: 0 !important;
    }

    /* ── HEADING GLOBAL ── */
    .heading-section h2 {
        font-size: 20px !important;
        line-height: 1.3 !important;
    }

    .heading-section .subheading {
        font-size: 11px !important;
        letter-spacing: 1px !important;
    }

    /* ── COL FULL WIDTH FIX ── */
    .col-md-3,
    .col-md-4,
    .col-md-6,
    .col-md-8 {
        padding-left: 12px !important;
        padding-right: 12px !important;
    }

    /* ── CONTAINER PADDING ── */
    .container {
        padding-left: 14px !important;
        padding-right: 14px !important;
    }
}

/* ================================================================
   TABLET  768–991px
   ================================================================ */
@media (min-width: 768px) and (max-width: 991.98px) {

    .hero-wrap {
        background-attachment: scroll !important;
        background-size: cover !important;
        background-position: center center !important;
    }

    .hero-wrap .text h1 {
        font-size: 30px !important;
    }

    .hero-wrap .text p {
        font-size: 15px !important;
    }

    .car-wrap .img {
        height: 230px !important;
    }

    .services-wrap .col-md-4 {
        margin-bottom: 12px !important;
    }

    .ftco-about .col-md-6.img.img-2 {
        min-height: 300px !important;
        background-attachment: scroll !important;
        background-size: cover !important;
    }

    .ftco-intro {
        background-attachment: scroll !important;
        background-size: cover !important;
    }

    .blog-entry .block-20 {
        height: 210px !important;
    }

    .ftco-counter .number {
        font-size: 42px !important;
    }

    .services.services-2 {
        margin-bottom: 20px !important;
    }

    .ftco-intro .heading-section-white h2 {
        font-size: 22px !important;
    }
}
</style>

    {{-- ============================================================
         HERO
         ============================================================ --}}
    <div class="hero-wrap ftco-degree-bg"
         style="background-image: url('{{ asset('frontend/images/bg_1.jpg') }}');
                background-size: cover;
                background-position: center center;
                background-attachment: scroll;
                position: relative;"
         data-stellar-background-ratio="0.5">
        <div class="overlay"></div>
        <div class="container">
            <div class="row no-gutters slider-text justify-content-start align-items-center justify-content-center">
                <div class="col-lg-8 ftco-animate">
                    <div class="text w-100 text-center mb-md-5 pb-md-5">
                        <h1 class="mb-4">Cara Cepat &amp; Mudah Untuk Menyewa Kendaraan</h1>
                        <p style="font-size: 18px;">Temukan berbagai pilihan kendaraan sewa terbaik dengan harga yang
                            terjangkau dan layanan yang memuaskan untuk kebutuhan perjalanan Anda.</p>
                        <a href="https://vimeo.com/45830194"
                            class="icon-wrap popup-vimeo d-flex align-items-center mt-4 justify-content-center">
                            <div class="icon d-flex align-items-center justify-content-center">
                                <span class="ion-ios-play"></span>
                            </div>
                            <div class="heading-title ml-5">
                                <span>Langkah mudah untuk menyewa kendaraan</span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ============================================================
         FORM + STEPS
         ============================================================ --}}
    <section class="ftco-section ftco-no-pt bg-light">
        <div class="container">
            <div class="row no-gutters">
                <div class="col-md-12 featured-top">
                    <div class="row no-gutters">
                        <div class="col-md-4 d-flex align-items-center">
                            <form action="#" class="request-form ftco-animate bg-primary">
                                <h2>Rencanakan Perjalanan Anda</h2>
                                <div class="form-group">
                                    <label class="label">Lokasi Penjemputan</label>
                                    <input type="text" class="form-control" placeholder="Kota, Bandara, Stasiun, dll">
                                </div>
                                <div class="form-group">
                                    <label class="label">Lokasi Pengantaran</label>
                                    <input type="text" class="form-control" placeholder="Kota, Bandara, Stasiun, dll">
                                </div>
                                <div class="d-flex">
                                    <div class="form-group mr-2">
                                        <label class="label">Tanggal Penjemputan</label>
                                        <input type="text" class="form-control" id="book_pick_date" placeholder="Tanggal">
                                    </div>
                                    <div class="form-group ml-2">
                                        <label class="label">Tanggal Pengantaran</label>
                                        <input type="text" class="form-control" id="book_off_date" placeholder="Tanggal">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="label">Waktu Penjemputan</label>
                                    <input type="text" class="form-control" id="time_pick" placeholder="Waktu">
                                </div>
                                <div class="form-group">
                                    <input type="submit" value="Sewa Kendaraan Sekarang" class="btn btn-secondary py-3 px-4">
                                </div>
                            </form>
                        </div>
                        <div class="col-md-8 d-flex align-items-center">
                            <div class="services-wrap rounded-right w-100">
                                <h3 class="heading-section mb-4">Cara Lebih Baik untuk Menyewa Kendaraan Impian Anda</h3>
                                <div class="row d-flex mb-4">
                                    <div class="col-md-4 d-flex align-self-stretch ftco-animate">
                                        <div class="services w-100 text-center">
                                            <div class="icon d-flex align-items-center justify-content-center">
                                                <span class="flaticon-route"></span>
                                            </div>
                                            <div class="text w-100">
                                                <h3 class="heading mb-2">Pilih Lokasi Penjemputan Anda</h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 d-flex align-self-stretch ftco-animate">
                                        <div class="services w-100 text-center">
                                            <div class="icon d-flex align-items-center justify-content-center">
                                                <span class="flaticon-handshake"></span>
                                            </div>
                                            <div class="text w-100">
                                                <h3 class="heading mb-2">Pilih Penawaran Terbaik</h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 d-flex align-self-stretch ftco-animate">
                                        <div class="services w-100 text-center">
                                            <div class="icon d-flex align-items-center justify-content-center">
                                                <span class="flaticon-rent"></span>
                                            </div>
                                            <div class="text w-100">
                                                <h3 class="heading mb-2">Reservasi Kendaraan Sewa Anda</h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <p><a href="#" class="btn btn-primary py-3 px-4">Reservasi Kendaraan Impian Anda</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ============================================================
         KENDARAAN UNGGULAN
         ============================================================ --}}
    <section class="ftco-section ftco-no-pt bg-light">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12 heading-section text-center ftco-animate mb-5">
                    <span class="subheading">Apa yang Kami Tawarkan</span>
                    <h2 class="mb-2">Kendaraan Unggulan</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    @if ($kendaraans->count() > 0)
                        @php
                            $useCarousel    = $kendaraans->count() > 3;
                            $itemsPerPage   = 3;
                            $currentPage    = request()->get('halaman_kendaraan', 1);
                            $totalItems     = $kendaraans->count();
                            $totalPages     = (int) ceil($totalItems / $itemsPerPage);
                            $currentPage    = max(1, min($currentPage, $totalPages));
                            $offset         = ($currentPage - 1) * $itemsPerPage;
                            $paginatedKendaraans = $kendaraans->slice($offset, $itemsPerPage);
                        @endphp

                        {{-- ── Tampil langsung (≤ 3 kendaraan) ── --}}
                        @if (!$useCarousel)
                            <div class="row">
                                @foreach ($kendaraans as $kendaraan)
                                    <div class="col-md-4 mb-4">
                                        <div class="car-wrap rounded ftco-animate">
                                            <div class="img rounded d-flex align-items-end overflow-hidden"
                                                 style="height: 300px; position: relative;">
                                                <img src="{{ $kendaraan->images->where('is_primary', 1)->first()
                                                        ? asset('storage/' . $kendaraan->images->where('is_primary', 1)->first()->image_path)
                                                        : asset('frontend/images/car-1.jpg') }}"
                                                     alt="{{ $kendaraan->brand }} {{ $kendaraan->model }}"
                                                     style="width:100%; height:100%; object-fit:contain;
                                                            object-position:center; background-color:#f8f9fa;">
                                            </div>
                                            <div class="text">
                                                <h2 class="mb-0">
                                                    <a href="#">{{ $kendaraan->brand }} {{ $kendaraan->model }}</a>
                                                </h2>
                                                <div class="d-flex mb-3">
                                                    <span class="cat">{{ $kendaraan->type }} - {{ $kendaraan->year }}</span>
                                                    <p class="price ml-auto">
                                                        Rp {{ number_format($kendaraan->price_per_day, 0, ',', '.') }}
                                                        <span>/hari</span>
                                                    </p>
                                                </div>
                                                <p class="d-flex mb-0 d-block">
                                                    <a href="{{ route('bookings.create', $kendaraan->id) }}"
                                                       class="btn btn-primary py-2 mr-1">Booking</a>
                                                    <a href="{{ route('kendaraan.show', $kendaraan->id) }}"
                                                       class="btn btn-secondary py-2 ml-1">Detail</a>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                        {{-- ── Paginasi (> 3 kendaraan) ── --}}
                        @else
                            <div class="row">
                                @foreach ($paginatedKendaraans as $kendaraan)
                                    <div class="col-md-4 mb-4">
                                        <div class="car-wrap rounded ftco-animate">
                                            <div class="img rounded d-flex align-items-end overflow-hidden"
                                                 style="height: 300px; position: relative;">
                                                <img src="{{ $kendaraan->images->where('is_primary', 1)->first()
                                                        ? asset('storage/' . $kendaraan->images->where('is_primary', 1)->first()->image_path)
                                                        : asset('frontend/images/car-1.jpg') }}"
                                                     alt="{{ $kendaraan->brand }} {{ $kendaraan->model }}"
                                                     style="width:100%; height:100%; object-fit:contain;
                                                            object-position:center; background-color:#f8f9fa;">
                                            </div>
                                            <div class="text">
                                                <h2 class="mb-0">
                                                    <a href="#">{{ $kendaraan->brand }} {{ $kendaraan->model }}</a>
                                                </h2>
                                                <div class="d-flex mb-3">
                                                    <span class="cat">{{ $kendaraan->type }} - {{ $kendaraan->year }}</span>
                                                    <p class="price ml-auto">
                                                        Rp {{ number_format($kendaraan->price_per_day, 0, ',', '.') }}
                                                        <span>/hari</span>
                                                    </p>
                                                </div>
                                                <p class="d-flex mb-0 d-block">
                                                    <a href="{{ route('bookings.create', $kendaraan->id) }}"
                                                       class="btn btn-primary py-2 mr-1">Booking</a>
                                                    <a href="{{ route('kendaraan.show', $kendaraan->id) }}"
                                                       class="btn btn-secondary py-2 ml-1">Detail</a>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            @if ($totalPages > 1)
                                <div class="row mt-4">
                                    <div class="col text-center">
                                        <nav>
                                            <ul class="pagination justify-content-center">
                                                <li class="page-item {{ $currentPage <= 1 ? 'disabled' : '' }}">
                                                    <a class="page-link" href="?halaman_kendaraan={{ $currentPage - 1 }}">
                                                        <span class="ion-ios-arrow-back"></span> Sebelumnya
                                                    </a>
                                                </li>
                                                @for ($i = 1; $i <= $totalPages; $i++)
                                                    <li class="page-item {{ $i === $currentPage ? 'active' : '' }}">
                                                        <a class="page-link" href="?halaman_kendaraan={{ $i }}">{{ $i }}</a>
                                                    </li>
                                                @endfor
                                                <li class="page-item {{ $currentPage >= $totalPages ? 'disabled' : '' }}">
                                                    <a class="page-link" href="?halaman_kendaraan={{ $currentPage + 1 }}">
                                                        Berikutnya <span class="ion-ios-arrow-forward"></span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </nav>
                                    </div>
                                </div>
                            @endif
                        @endif

                    @else
                        <div class="alert alert-info text-center">
                            <p class="mb-0">Belum ada kendaraan tersedia saat ini.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    {{-- ============================================================
         TENTANG KAMI
         ============================================================ --}}
    <section class="ftco-section ftco-about">
        <div class="container">
            <div class="row no-gutters">
                <div class="col-md-6 p-md-5 img img-2 d-flex justify-content-center align-items-center"
                     style="background-image: url('{{ asset('frontend/images/about.jpg') }}');
                            background-size: cover;
                            background-position: center;
                            background-attachment: scroll;">
                </div>
                <div class="col-md-6 wrap-about ftco-animate">
                    <div class="heading-section heading-section-white pl-md-5">
                        <span class="subheading">Tentang Kami</span>
                        <h2 class="mb-4">Selamat Datang di RentHub</h2>
                        <p>Kami adalah perusahaan penyewaan kendaraan terpercaya yang telah melayani ribuan pelanggan
                            dengan dedikasi tinggi dan komitmen terhadap kenyamanan perjalanan Anda.</p>
                        <p>Dengan armada kendaraan modern dan layanan pelanggan yang profesional, kami siap membantu
                            Anda menemukan solusi transportasi yang tepat untuk setiap kebutuhan. Dari perjalanan bisnis
                            hingga liburan keluarga, RentHub selalu hadir sebagai mitra perjalanan terpercaya Anda.</p>
                        <p><a href="#" class="btn btn-primary py-3 px-4">Cari Kendaraan</a></p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ============================================================
         LAYANAN
         ============================================================ --}}
    <section class="ftco-section">
        <div class="container">
            <div class="row justify-content-center mb-5">
                <div class="col-md-7 text-center heading-section ftco-animate">
                    <span class="subheading">Layanan</span>
                    <h2 class="mb-3">Layanan Terbaru Kami</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="services services-2 w-100 text-center">
                        <div class="icon d-flex align-items-center justify-content-center">
                            <span class="flaticon-wedding-car"></span>
                        </div>
                        <div class="text w-100">
                            <h3 class="heading mb-2">Upacara Pernikahan</h3>
                            <p>Layanan transportasi mewah khusus untuk hari istimewa Anda dengan armada kendaraan elegan pilihan.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="services services-2 w-100 text-center">
                        <div class="icon d-flex align-items-center justify-content-center">
                            <span class="flaticon-transportation"></span>
                        </div>
                        <div class="text w-100">
                            <h3 class="heading mb-2">Transfer Antar Kota</h3>
                            <p>Perjalanan nyaman dan aman dari satu kota ke kota lain dengan pengemudi profesional kami.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="services services-2 w-100 text-center">
                        <div class="icon d-flex align-items-center justify-content-center">
                            <span class="flaticon-car"></span>
                        </div>
                        <div class="text w-100">
                            <h3 class="heading mb-2">Transfer Bandara</h3>
                            <p>Layanan penjemputan dan pengantaran bandara yang tepat waktu dan dapat Anda andalkan.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="services services-2 w-100 text-center">
                        <div class="icon d-flex align-items-center justify-content-center">
                            <span class="flaticon-transportation"></span>
                        </div>
                        <div class="text w-100">
                            <h3 class="heading mb-2">Tur Keliling Kota</h3>
                            <p>Jelajahi keindahan kota dengan paket wisata lengkap dan pemandu yang berpengalaman.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ============================================================
         INTRO CTA
         ============================================================ --}}
    <section class="ftco-section ftco-intro"
             style="background-image: url('{{ asset('frontend/images/bg_3.jpg') }}');
                    background-size: cover;
                    background-position: center;
                    background-attachment: scroll;">
        <div class="overlay"></div>
        <div class="container">
            <div class="row justify-content-end">
                <div class="col-md-6 heading-section heading-section-white ftco-animate">
                    <h2 class="mb-3">Ingin Mendapatkan Penghasilan Bersama Kami? Jangan Lewatkan Kesempatan Ini.</h2>
                    <a href="#" class="btn btn-primary btn-lg">Jadilah Pengemudi</a>
                </div>
            </div>
        </div>
    </section>

    {{-- ============================================================
         ULASAN PELANGGAN
         ============================================================ --}}
    <section class="ftco-section">
        <div class="container">
            <div class="row justify-content-center mb-5">
                <div class="col-md-7 heading-section text-center ftco-animate">
                    <span class="subheading">Ulasan</span>
                    <h2>Ulasan Pelanggan</h2>
                </div>
            </div>
            <div class="row d-flex">
                @forelse ($reviews as $review)
                    <div class="col-md-4 d-flex ftco-animate">
                        <div class="blog-entry justify-content-end">
                            @if ($review->kendaraan && $review->kendaraan->images->isNotEmpty())
                                <a href="#" class="block-20"
                                   style="background-image: url('{{ asset('storage/' . $review->kendaraan->images->first()->image_path) }}');
                                          background-size: cover; background-position: center;">
                                </a>
                            @else
                                <a href="#" class="block-20"
                                   style="background-image: url('{{ asset('frontend/images/image_1.jpg') }}');
                                          background-size: cover; background-position: center;">
                                </a>
                            @endif
                            <div class="text pt-4">
                                <div class="meta mb-3">
                                    <div><a href="#">{{ $review->created_at->format('d M Y') }}</a></div>
                                    <div><a href="#">{{ $review->user->name }}</a></div>
                                    <div>
                                        @for ($i = 1; $i <= 5; $i++)
                                            <span class="icon-star{{ $i <= $review->rating ? '' : '-o' }}"
                                                  style="color: #f7c408;"></span>
                                        @endfor
                                        <span class="ml-1">({{ $review->rating }}/5)</span>
                                    </div>
                                </div>
                                <h3 class="heading mt-2">
                                    <a href="#">{{ $review->kendaraan->brand ?? 'N/A' }} {{ $review->kendaraan->model ?? '' }}</a>
                                </h3>
                                <p>{{ Str::limit($review->comment, 100) }}</p>
                                @if ($review->admin_response)
                                    <div class="admin-response mt-2 p-2"
                                         style="background-color:#f8f9fa; border-left:3px solid #01d28e;">
                                        <small><strong>Respons Admin:</strong></small>
                                        <p class="mb-0"><small>{{ Str::limit($review->admin_response, 80) }}</small></p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-md-12 text-center">
                        <p>Belum ada ulasan yang tersedia saat ini.</p>
                    </div>
                @endforelse
            </div>
            @if ($reviews->hasPages())
                <div class="row mt-5">
                    <div class="col text-center">
                        {{ $reviews->links() }}
                    </div>
                </div>
            @endif
        </div>
    </section>

    {{-- ============================================================
         COUNTER
         ============================================================ --}}
    <section class="ftco-counter ftco-section img bg-light" id="section-counter">
        <div class="overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-lg-3 justify-content-center counter-wrap ftco-animate">
                    <div class="block-18">
                        <div class="text text-border d-flex align-items-center">
                            <strong class="number" data-number="60">0</strong>
                            <span>Tahun <br>Pengalaman</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 justify-content-center counter-wrap ftco-animate">
                    <div class="block-18">
                        <div class="text text-border d-flex align-items-center">
                            <strong class="number" data-number="1090">0</strong>
                            <span>Total <br>Kendaraan</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 justify-content-center counter-wrap ftco-animate">
                    <div class="block-18">
                        <div class="text text-border d-flex align-items-center">
                            <strong class="number" data-number="2590">0</strong>
                            <span>Pelanggan <br>Puas</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 justify-content-center counter-wrap ftco-animate">
                    <div class="block-18">
                        <div class="text d-flex align-items-center">
                            <strong class="number" data-number="67">0</strong>
                            <span>Total <br>Cabang</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection