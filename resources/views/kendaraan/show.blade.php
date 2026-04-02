@extends('layouts.admin')

@section('content')
<style>
* { box-sizing: border-box; }

.ks-wrap { padding: 1.5rem 2rem 2rem 2rem; font-family: inherit; max-width: 1200px; }

/* Header Card */
.ks-header-card {
    background: linear-gradient(135deg, #4f5fd5 0%, #6366f1 100%);
    border-radius: 14px;
    padding: 22px 28px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}
.ks-header-icon {
    width: 46px; height: 46px;
    background: rgba(255,255,255,0.15);
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    font-size: 20px; flex-shrink: 0;
}
.ks-header-title { font-size: 20px; font-weight: 600; color: #fff; margin: 0; }
.ks-header-sub   { font-size: 12px; color: rgba(255,255,255,0.65); margin: 3px 0 0; }
.ks-btn-back {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 8px 16px; border-radius: 8px;
    background: rgba(255,255,255,0.15); border: 1px solid rgba(255,255,255,0.3);
    color: #fff; font-size: 13px; cursor: pointer; text-decoration: none;
    transition: background 0.15s;
}
.ks-btn-back:hover { background: rgba(255,255,255,0.25); color: #fff; text-decoration: none; }

/* Grid */
.ks-grid { display: grid; grid-template-columns: 1fr 320px; gap: 20px; align-items: start; }
.ks-col  { display: flex; flex-direction: column; gap: 16px; }

/* Cards */
.ks-card {
    background: #fff;
    border: 1px solid #e9ecef;
    border-radius: 14px;
    overflow: hidden;
}
.ks-card-header {
    padding: 14px 22px;
    border-bottom: 1px solid #e9ecef;
    font-size: 12px; font-weight: 700;
    color: #6c757d; text-transform: uppercase; letter-spacing: 0.06em;
    display: flex; align-items: center; gap: 8px;
}
.ks-card-body { padding: 20px 22px; }

/* Gallery */
.ks-gallery-main {
    width: 100%; height: 220px;
    object-fit: cover; display: block;
    border-bottom: 1px solid #e9ecef;
}
.ks-gallery-main-placeholder {
    width: 100%; height: 220px;
    background: #f1f3f5;
    display: flex; align-items: center; justify-content: center;
    font-size: 60px;
    border-bottom: 1px solid #e9ecef;
}
.ks-thumbs {
    display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px;
    padding: 14px 22px; border-bottom: 1px solid #e9ecef;
}
.ks-thumb {
    height: 70px; object-fit: cover;
    border-radius: 8px; border: 1px solid #e9ecef;
    width: 100%; display: block; cursor: pointer;
    transition: opacity 0.15s;
}
.ks-thumb:hover { opacity: 0.8; }

/* Info grid */
.ks-info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
.ks-info-label {
    font-size: 11px; font-weight: 700; color: #6c757d;
    text-transform: uppercase; letter-spacing: 0.04em; margin-bottom: 4px;
}
.ks-info-val { font-size: 14px; font-weight: 500; color: #212529; }

/* Badges */
.ks-badge { display: inline-flex; align-items: center; gap: 4px; padding: 5px 12px; border-radius: 99px; font-size: 12px; font-weight: 600; }
.ks-badge-available   { background: #d1fae5; color: #065f46; }
.ks-badge-rented      { background: #dbeafe; color: #1e40af; }
.ks-badge-maintenance { background: #fef3c7; color: #92400e; }

/* Plate */
.ks-plate {
    font-size: 15px; font-weight: 700;
    background: #f8f9fa; border: 1px solid #dee2e6;
    border-radius: 7px; padding: 5px 12px;
    font-family: monospace; letter-spacing: 0.1em;
    color: #212529; display: inline-block;
}

/* Divider */
.ks-divider { border: none; border-top: 1px solid #e9ecef; margin: 16px 0; }

/* Spec row */
.ks-spec-row {
    display: flex; justify-content: space-between; align-items: center;
    padding: 9px 0; border-bottom: 1px solid #f1f3f5; font-size: 13px;
}
.ks-spec-row:last-child { border-bottom: none; }
.ks-spec-label { color: #6c757d; }
.ks-spec-val   { font-weight: 600; color: #212529; }

/* Action buttons */
.ks-btn-edit {
    flex: 1; padding: 11px; border-radius: 8px;
    background: #6366f1; color: #fff; border: none;
    font-size: 13px; font-weight: 600; cursor: pointer;
    display: inline-flex; align-items: center; justify-content: center; gap: 7px;
    text-decoration: none; transition: background 0.15s;
}
.ks-btn-edit:hover { background: #4f46e5; color: #fff; text-decoration: none; }
.ks-btn-delete {
    padding: 11px 18px; border-radius: 8px;
    background: #fff1f2; color: #be123c;
    border: 1px solid #fecdd3; font-size: 13px; font-weight: 600;
    cursor: pointer; display: inline-flex; align-items: center; gap: 7px;
    transition: background 0.15s;
}
.ks-btn-delete:hover { background: #ffe4e6; }

/* Stars */
.ks-star-on  { color: #f0a500; font-size: 13px; }
.ks-star-off { color: #dee2e6; font-size: 13px; }

/* Review item */
.ks-review {
    padding: 12px 0;
    border-bottom: 1px solid #f1f3f5;
}
.ks-review:last-child { border-bottom: none; padding-bottom: 0; }

/* Stat card */
.ks-stat {
    background: #f8f9fa; border-radius: 8px; padding: 14px 16px;
    display: flex; align-items: center; gap: 14px;
    margin-bottom: 10px;
}
.ks-stat:last-child { margin-bottom: 0; }
.ks-stat-icon {
    width: 38px; height: 38px; border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    font-size: 16px; flex-shrink: 0;
}
.ks-stat-num { font-size: 18px; font-weight: 700; color: #212529; line-height: 1; }
.ks-stat-lbl { font-size: 11px; color: #6c757d; margin-top: 2px; }

/* Price highlight */
.ks-price {
    font-size: 22px; font-weight: 700; color: #6366f1;
}

/* Info box */
.ks-card-info { background: #f8f9ff; border-color: #e0e7ff; }

@media (max-width: 900px) {
    .ks-grid     { grid-template-columns: 1fr; }
    .ks-info-grid { grid-template-columns: 1fr 1fr; }
    .ks-thumbs  { grid-template-columns: repeat(4, 1fr); }
}
@media (max-width: 600px) {
    .ks-wrap     { padding: 1rem; }
    .ks-header-card { flex-direction: column; align-items: flex-start; gap: 12px; }
    .ks-info-grid { grid-template-columns: 1fr; }
    .ks-thumbs  { grid-template-columns: repeat(3, 1fr); }
}
</style>

<div class="ks-wrap">

    {{-- Header Card --}}
    <div class="ks-header-card">
        <div style="display:flex; align-items:center; gap:16px;">
            <div class="ks-header-icon">🚗</div>
            <div>
                <p class="ks-header-sub">Manajemen Kendaraan · Detail</p>
                <h4 class="ks-header-title">{{ $kendaraan->brand }} {{ $kendaraan->model }}</h4>
            </div>
        </div>
        <a href="{{ route('admin.kendaraan.index') }}" class="ks-btn-back">← Kembali</a>
    </div>

    <div class="ks-grid">

        {{-- ════════════════════ KOLOM KIRI ════════════════════ --}}
        <div class="ks-col">

            {{-- Foto Kendaraan --}}
            <div class="ks-card">
                @if($kendaraan->images->count() > 0)
                    <img src="{{ asset('storage/' . $kendaraan->images->first()->image_path) }}"
                         alt="{{ $kendaraan->brand }}"
                         class="ks-gallery-main"
                         id="mainPhoto">
                    @if($kendaraan->images->count() > 1)
                        <div class="ks-thumbs">
                            @foreach($kendaraan->images as $img)
                                <img src="{{ asset('storage/' . $img->image_path) }}"
                                     alt="{{ $kendaraan->brand }}"
                                     class="ks-thumb"
                                     onclick="document.getElementById('mainPhoto').src='{{ asset('storage/' . $img->image_path) }}'">
                            @endforeach
                        </div>
                    @endif
                @else
                    <div class="ks-gallery-main-placeholder">🚗</div>
                @endif

                <div class="ks-card-body" style="padding-top:16px;">
                    <div style="display:flex; justify-content:space-between; align-items:flex-start; flex-wrap:wrap; gap:10px;">
                        <div>
                            <p style="font-size:20px; font-weight:700; color:#212529; margin:0 0 6px;">
                                {{ $kendaraan->brand }} {{ $kendaraan->model }}
                            </p>
                            <span class="ks-plate">{{ $kendaraan->plate_number }}</span>
                        </div>
                        <div style="text-align:right;">
                            <p style="font-size:11px; color:#6c757d; margin-bottom:4px;">Harga Sewa</p>
                            <span class="ks-price">Rp {{ number_format($kendaraan->price_per_day, 0, ',', '.') }}</span>
                            <span style="font-size:12px; color:#6c757d;"> / hari</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Informasi Dasar --}}
            <div class="ks-card">
                <div class="ks-card-header">📋 Informasi Dasar</div>
                <div class="ks-card-body">
                    <div class="ks-info-grid">
                        <div>
                            <p class="ks-info-label">Tipe Kendaraan</p>
                            <p class="ks-info-val">{{ ucfirst($kendaraan->type) }}</p>
                        </div>
                        <div>
                            <p class="ks-info-label">Merek</p>
                            <p class="ks-info-val">{{ $kendaraan->brand }}</p>
                        </div>
                        <div>
                            <p class="ks-info-label">Model</p>
                            <p class="ks-info-val">{{ $kendaraan->model }}</p>
                        </div>
                        <div>
                            <p class="ks-info-label">Tahun</p>
                            <p class="ks-info-val">{{ $kendaraan->year }}</p>
                        </div>
                        <div>
                            <p class="ks-info-label">Warna</p>
                            <p class="ks-info-val">{{ $kendaraan->color ?? '—' }}</p>
                        </div>
                        <div>
                            <p class="ks-info-label">Status</p>
                            @if($kendaraan->status == 'available')
                                <span class="ks-badge ks-badge-available">✔ Tersedia</span>
                            @elseif($kendaraan->status == 'rented')
                                <span class="ks-badge ks-badge-rented">🔑 Disewa</span>
                            @else
                                <span class="ks-badge ks-badge-maintenance">🔧 Maintenance</span>
                            @endif
                        </div>
                        <div>
                            <p class="ks-info-label">Ditambahkan</p>
                            <p class="ks-info-val">{{ $kendaraan->created_at->format('d M Y') }}</p>
                        </div>
                        <div>
                            <p class="ks-info-label">Terakhir Diperbarui</p>
                            <p class="ks-info-val">{{ $kendaraan->updated_at->format('d M Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Spesifikasi Teknis --}}
            @if($kendaraan->detail)
            <div class="ks-card">
                <div class="ks-card-header">⚙ Spesifikasi Teknis</div>
                <div class="ks-card-body">
                    @if($kendaraan->detail->fuel_type)
                    <div class="ks-spec-row">
                        <span class="ks-spec-label">Bahan Bakar</span>
                        <span class="ks-spec-val">{{ $kendaraan->detail->fuel_type }}</span>
                    </div>
                    @endif
                    @if($kendaraan->detail->transmission)
                    <div class="ks-spec-row">
                        <span class="ks-spec-label">Transmisi</span>
                        <span class="ks-spec-val">{{ $kendaraan->detail->transmission }}</span>
                    </div>
                    @endif
                    @if($kendaraan->detail->engine_capacity)
                    <div class="ks-spec-row">
                        <span class="ks-spec-label">Kapasitas Mesin</span>
                        <span class="ks-spec-val">{{ number_format($kendaraan->detail->engine_capacity) }} cc</span>
                    </div>
                    @endif
                    @if($kendaraan->detail->seat_count)
                    <div class="ks-spec-row">
                        <span class="ks-spec-label">Jumlah Kursi</span>
                        <span class="ks-spec-val">{{ $kendaraan->detail->seat_count }} kursi</span>
                    </div>
                    @endif
                    @if(!$kendaraan->detail->fuel_type && !$kendaraan->detail->transmission && !$kendaraan->detail->engine_capacity && !$kendaraan->detail->seat_count)
                        <p style="font-size:13px; color:#6c757d; margin:0;">Spesifikasi belum diisi.</p>
                    @endif
                </div>
            </div>
            @endif

            {{-- Tombol Aksi --}}
            <div style="display:flex; gap:10px;">
                <a href="{{ route('admin.kendaraan.edit', $kendaraan->id) }}" class="ks-btn-edit">
                    ✏ Edit Kendaraan
                </a>
                <form action="{{ route('admin.kendaraan.destroy', $kendaraan->id) }}" method="POST"
                      onsubmit="return confirm('Yakin ingin menghapus kendaraan ini? Tindakan ini tidak dapat dibatalkan.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="ks-btn-delete">🗑 Hapus</button>
                </form>
            </div>

        </div>{{-- /kiri --}}


        {{-- ════════════════════ KOLOM KANAN ════════════════════ --}}
        <div class="ks-col">

            {{-- Statistik --}}
            <div class="ks-card">
                <div class="ks-card-header">📊 Statistik</div>
                <div class="ks-card-body">
                    <div class="ks-stat">
                        <div class="ks-stat-icon" style="background:#eef2ff;">⭐</div>
                        <div>
                            <div class="ks-stat-num">
                                @if($kendaraan->reviews && $kendaraan->reviews->count() > 0)
                                    {{ number_format($kendaraan->reviews->avg('rating'), 1) }}
                                @else
                                    —
                                @endif
                            </div>
                            <div class="ks-stat-lbl">Rating Rata-rata</div>
                        </div>
                    </div>
                    <div class="ks-stat">
                        <div class="ks-stat-icon" style="background:#d1fae5;">💬</div>
                        <div>
                            <div class="ks-stat-num">{{ $kendaraan->reviews ? $kendaraan->reviews->count() : 0 }}</div>
                            <div class="ks-stat-lbl">Total Review</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Review Pelanggan --}}
            @if($kendaraan->reviews && $kendaraan->reviews->count() > 0)
            <div class="ks-card">
                <div class="ks-card-header">💬 Review Pelanggan</div>
                <div class="ks-card-body">
                    @foreach($kendaraan->reviews->take(5) as $review)
                    <div class="ks-review">
                        <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:5px;">
                            <div style="display:flex; align-items:center; gap:8px;">
                                <div style="width:30px; height:30px; border-radius:50%; background:#eef2ff; display:flex; align-items:center; justify-content:center; font-size:12px; font-weight:700; color:#6366f1; flex-shrink:0;">
                                    {{ substr($review->user->name ?? 'A', 0, 1) }}
                                </div>
                                <p style="font-size:13px; font-weight:600; color:#212529; margin:0;">
                                    {{ $review->user->name ?? 'Anonim' }}
                                </p>
                            </div>
                            <div style="display:flex; gap:1px;">
                                @for($i = 1; $i <= 5; $i++)
                                    <span class="{{ $i <= $review->rating ? 'ks-star-on' : 'ks-star-off' }}">★</span>
                                @endfor
                            </div>
                        </div>
                        <p style="font-size:12px; color:#495057; margin:0 0 4px; line-height:1.6;">
                            {{ Str::limit($review->comment, 100) }}
                        </p>
                        <p style="font-size:11px; color:#9ca3af; margin:0;">
                            {{ $review->created_at->diffForHumans() }}
                        </p>
                    </div>
                    @endforeach

                    @if($kendaraan->reviews->count() > 5)
                    <div style="margin-top:10px; text-align:center;">
                        <a href="{{ route('admin.reviews.index') }}?kendaraan={{ $kendaraan->id }}"
                           style="font-size:12px; color:#6366f1; text-decoration:none; font-weight:600;">
                            Lihat semua {{ $kendaraan->reviews->count() }} review →
                        </a>
                    </div>
                    @endif
                </div>
            </div>
            @else
            <div class="ks-card ks-card-info">
                <div class="ks-card-body" style="text-align:center; padding:30px 22px;">
                    <div style="font-size:32px; margin-bottom:10px; opacity:0.3;">⭐</div>
                    <p style="font-size:13px; color:#6c757d; margin:0;">Belum ada review untuk kendaraan ini</p>
                </div>
            </div>
            @endif

            {{-- Info --}}
            <div class="ks-card ks-card-info">
                <div class="ks-card-body">
                    <div style="display:flex; align-items:center; gap:10px; margin-bottom:10px;">
                        <div style="width:36px; height:36px; border-radius:8px; background:#eef2ff; display:flex; align-items:center; justify-content:center; font-size:16px;">ℹ</div>
                        <span style="font-size:13px; font-weight:600; color:#212529;">Informasi</span>
                    </div>
                    <p style="font-size:12px; color:#6c757d; line-height:1.7; margin:0;">
                        Perubahan status kendaraan akan langsung mempengaruhi ketersediaan di halaman pemesanan pelanggan.
                        Gunakan tombol <strong>Edit</strong> untuk memperbarui data.
                    </p>
                </div>
            </div>

        </div>{{-- /kanan --}}

    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.querySelector('form[action*="destroy"]')?.addEventListener('submit', function(e) {
    e.preventDefault();
    const form = this;
    Swal.fire({
        title: 'Hapus Kendaraan?',
        html: '<p style="color:#6c757d;font-size:14px;">Data kendaraan beserta semua foto akan dihapus permanen. Tindakan ini tidak dapat dibatalkan.</p>',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#6c757d',
        confirmButtonText: '🗑 Ya, Hapus',
        cancelButtonText: 'Batal',
        reverseButtons: true,
    }).then((result) => {
        if (result.isConfirmed) form.submit();
    });
});
</script>
@endpush