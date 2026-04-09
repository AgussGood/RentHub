@extends('layouts.admin')

@section('content')
<style>
* { box-sizing: border-box; }

.kd-wrap { padding: 1.5rem 2rem 2rem 2rem; font-family: inherit; max-width: 1300px; }

/* ── Header Card ─────────────────────────────────────────── */
.kd-header-card {
    background: linear-gradient(135deg, #4f5fd5 0%, #6366f1 100%);
    border-radius: 14px;
    padding: 22px 28px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}
.kd-header-icon {
    width: 46px; height: 46px;
    background: rgba(255,255,255,0.15);
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    font-size: 20px; flex-shrink: 0;
}
.kd-header-title { font-size: 20px; font-weight: 600; color: #fff; margin: 0; }
.kd-header-sub   { font-size: 12px; color: rgba(255,255,255,0.65); margin: 3px 0 0; }
.kd-btn-add {
    display: inline-flex; align-items: center; gap: 7px;
    padding: 9px 18px; border-radius: 9px;
    background: rgba(255,255,255,0.18); border: 1px solid rgba(255,255,255,0.35);
    color: #fff; font-size: 13px; font-weight: 600;
    text-decoration: none; transition: background 0.15s; cursor: pointer;
}
.kd-btn-add:hover { background: rgba(255,255,255,0.28); color: #fff; text-decoration: none; }

/* ── Alert ───────────────────────────────────────────────── */
.kd-alert {
    padding: 12px 16px; border-radius: 10px;
    font-size: 13px; font-weight: 500;
    display: flex; align-items: center; gap: 8px;
    margin-bottom: 16px;
}
.kd-alert-success { background: #d1fae5; color: #065f46; border: 1px solid #a7f3d0; }
.kd-alert-error   { background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }

/* ── Stats ───────────────────────────────────────────────── */
.kd-stats {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 12px;
    margin-bottom: 20px;
}
.kd-stat {
    background: #fff; border: 1px solid #e9ecef;
    border-radius: 12px; padding: 16px 18px;
    display: flex; align-items: center; gap: 14px;
}
.kd-stat-icon {
    width: 42px; height: 42px; border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    font-size: 18px; flex-shrink: 0;
}
.kd-icon-total       { background: #eef2ff; }
.kd-icon-available   { background: #d1fae5; }
.kd-icon-rented      { background: #dbeafe; }
.kd-icon-maintenance { background: #fef3c7; }
.kd-stat-num   { font-size: 22px; font-weight: 700; color: #212529; line-height: 1; }
.kd-stat-label { font-size: 11px; color: #6c757d; margin-top: 3px; }

/* ── Main card ───────────────────────────────────────────── */
.kd-card {
    background: #fff;
    border: 1px solid #e9ecef;
    border-radius: 14px;
    overflow: hidden;
}
.kd-card-toolbar {
    padding: 14px 20px;
    border-bottom: 1px solid #e9ecef;
    display: flex; align-items: center;
    justify-content: space-between; gap: 12px;
    flex-wrap: wrap;
}

/* ── Filter tabs ─────────────────────────────────────────── */
.kd-tabs { display: flex; gap: 6px; flex-wrap: wrap; }
.kd-tab {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 6px 14px; border-radius: 8px;
    font-size: 12px; font-weight: 600;
    text-decoration: none; transition: all 0.15s;
    border: 1px solid transparent; cursor: pointer;
}
.kd-tab-all         { background: #f1f3f5;  color: #495057; border-color: #e9ecef; }
.kd-tab-all.active  { background: #6366f1;  color: #fff;    border-color: #6366f1; }
.kd-tab-all:hover:not(.active) { background: #e9ecef; color: #212529; }

.kd-tab-available         { background: #d1fae5; color: #065f46; border-color: #a7f3d0; }
.kd-tab-available.active  { background: #059669; color: #fff;    border-color: #059669; }

.kd-tab-rented         { background: #dbeafe; color: #1e40af; border-color: #bfdbfe; }
.kd-tab-rented.active  { background: #2563eb; color: #fff;    border-color: #2563eb; }

.kd-tab-maintenance         { background: #fef3c7; color: #92400e; border-color: #fde68a; }
.kd-tab-maintenance.active  { background: #d97706; color: #fff;    border-color: #d97706; }

/* ── Search ──────────────────────────────────────────────── */
.kd-search-wrap { position: relative; display: flex; align-items: center; }
.kd-search-icon { position: absolute; left: 10px; font-size: 13px; color: #9ca3af; }
.kd-search {
    padding: 7px 12px 7px 32px;
    border: 1px solid #e9ecef; border-radius: 8px;
    font-size: 13px; color: #212529; outline: none;
    transition: border-color 0.15s, box-shadow 0.15s; width: 210px;
}
.kd-search:focus { border-color: #6366f1; box-shadow: 0 0 0 3px rgba(99,102,241,0.1); }

/* ── Table ───────────────────────────────────────────────── */
.kd-table { width: 100%; border-collapse: collapse; }
.kd-table thead tr { background: #f8f9fa; border-bottom: 1px solid #e9ecef; }
.kd-table thead th {
    padding: 11px 16px;
    font-size: 11px; font-weight: 700;
    color: #6c757d; text-transform: uppercase;
    letter-spacing: 0.05em; white-space: nowrap;
}
.kd-table thead th.center { text-align: center; }

.kd-table tbody tr {
    border-bottom: 1px solid #f1f3f5;
    transition: background 0.12s;
}
.kd-table tbody tr:last-child { border-bottom: none; }
.kd-table tbody tr:hover { background: #fafbff; }
.kd-table td { padding: 13px 16px; vertical-align: middle; }
.kd-table td.center { text-align: center; }

/* ── Vehicle image ───────────────────────────────────────── */
.kd-thumb-wrap { position: relative; display: inline-block; }
.kd-thumb {
    width: 80px; height: 56px; border-radius: 9px;
    object-fit: cover; border: 1px solid #e9ecef;
    display: block; transition: transform 0.15s;
}
.kd-thumb-wrap:hover .kd-thumb { transform: scale(1.04); }
.kd-thumb-fallback {
    width: 80px; height: 56px; border-radius: 9px;
    background: #f1f3f5; border: 1px solid #e9ecef;
    display: flex; align-items: center; justify-content: center;
    font-size: 22px;
}
.kd-thumb-count {
    position: absolute; bottom: -5px; right: -5px;
    background: #6366f1; color: #fff;
    font-size: 10px; font-weight: 700;
    padding: 2px 6px; border-radius: 99px;
    border: 1.5px solid #fff; line-height: 1.4;
}

/* ── Plate / pills ───────────────────────────────────────── */
.kd-plate {
    font-size: 11px; font-weight: 700;
    background: #f8f9fa; border: 1px solid #dee2e6;
    border-radius: 5px; padding: 2px 7px;
    font-family: monospace; letter-spacing: 0.06em;
    color: #495057; display: inline-block;
}
.kd-pill {
    display: inline-flex; align-items: center; gap: 3px;
    padding: 3px 8px; border-radius: 99px;
    font-size: 11px; font-weight: 600;
}
.kd-pill-year  { background: #f1f3f5;  color: #495057; }
.kd-pill-color { background: #f3e8ff;  color: #6b21a8; }
.kd-pill-type  { background: #eef2ff;  color: #4338ca; }

/* ── Spec rows ───────────────────────────────────────────── */
.kd-spec { font-size: 12px; color: #6c757d; display: flex; align-items: center; gap: 5px; margin-bottom: 3px; }
.kd-spec:last-child { margin-bottom: 0; }
.kd-spec strong { color: #212529; }

/* ── Status badge ────────────────────────────────────────── */
.kd-badge {
    display: inline-flex; align-items: center; gap: 4px;
    padding: 5px 12px; border-radius: 99px;
    font-size: 11px; font-weight: 700; white-space: nowrap;
}
.kd-badge-available   { background: #d1fae5; color: #065f46; }
.kd-badge-rented      { background: #dbeafe; color: #1e40af; }
.kd-badge-maintenance { background: #fef3c7; color: #92400e; }

/* ── Price ───────────────────────────────────────────────── */
.kd-price { font-size: 14px; font-weight: 700; color: #6366f1; }
.kd-price-sub { font-size: 11px; color: #9ca3af; margin-top: 2px; }

/* ── Action buttons ──────────────────────────────────────── */
.kd-btn {
    width: 32px; height: 32px; border-radius: 8px;
    display: inline-flex; align-items: center; justify-content: center;
    font-size: 13px; cursor: pointer;
    transition: opacity 0.15s, transform 0.1s;
    border: none; text-decoration: none;
}
.kd-btn:hover { opacity: 0.82; transform: scale(1.08); text-decoration: none; }
.kd-btn-view   { background: #eef2ff; color: #6366f1; }
.kd-btn-edit   { background: #fef3c7; color: #92400e; }
.kd-btn-delete { background: #fee2e2; color: #991b1b; }

/* ── Empty state ─────────────────────────────────────────── */
.kd-empty { padding: 60px 24px; text-align: center; color: #9ca3af; }
.kd-empty-icon  { font-size: 48px; margin-bottom: 14px; }
.kd-empty-title { font-size: 15px; font-weight: 600; color: #6c757d; margin-bottom: 6px; }
.kd-empty-sub   { font-size: 13px; margin-bottom: 18px; }
.kd-empty-btn {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 9px 20px; border-radius: 9px;
    background: #6366f1; color: #fff; font-size: 13px;
    font-weight: 600; text-decoration: none;
    transition: background 0.15s;
}
.kd-empty-btn:hover { background: #4f46e5; color: #fff; text-decoration: none; }

/* ── Footer ──────────────────────────────────────────────── */
.kd-footer {
    padding: 14px 20px;
    border-top: 1px solid #e9ecef;
    display: flex; align-items: center;
    justify-content: space-between; gap: 12px; flex-wrap: wrap;
}
.kd-footer-info { font-size: 12px; color: #6c757d; display: flex; align-items: center; gap: 18px; flex-wrap: wrap; }
.kd-dot { width: 8px; height: 8px; border-radius: 50%; display: inline-block; flex-shrink: 0; }
.kd-dot-available   { background: #059669; }
.kd-dot-rented      { background: #2563eb; }
.kd-dot-maintenance { background: #d97706; }

/* ── Responsive ──────────────────────────────────────────── */
@media (max-width: 1000px) { .kd-stats { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 768px) {
    .kd-wrap { padding: 1rem; }
    .kd-header-card { flex-direction: column; align-items: flex-start; gap: 12px; }
    .kd-search { width: 160px; }
}
</style>

<div class="kd-wrap">

    {{-- ── Header ──────────────────────────────────────────── --}}
    <div class="kd-header-card">
        <div style="display:flex; align-items:center; gap:16px;">
            <div class="kd-header-icon">🚗</div>
            <div>
                <p class="kd-header-sub">Panel Admin · Manajemen</p>
                <h4 class="kd-header-title">Data Kendaraan</h4>
            </div>
        </div>
        <a href="{{ route('admin.kendaraan.create') }}" class="kd-btn-add">
            ＋ Tambah Kendaraan
        </a>
    </div>

    {{-- ── Alert ───────────────────────────────────────────── --}}
    @if(session('success'))
        <div class="kd-alert kd-alert-success" id="kdAlert">✔ {{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="kd-alert kd-alert-error" id="kdAlert">✖ {{ session('error') }}</div>
    @endif

    {{-- ── Deteksi tipe koleksi (paginator atau collection biasa) --}}
    @php
        $isPaginated  = $kendaraan instanceof \Illuminate\Pagination\AbstractPaginator;
        $allItems     = $isPaginated ? $kendaraan->getCollection() : $kendaraan;
        $totalCount   = $isPaginated ? $kendaraan->total() : $kendaraan->count();
        $cntAvailable = $allItems->where('status','available')->count();
        $cntRented    = $allItems->where('status','rented')->count();
        $cntMaint     = $allItems->where('status','maintenance')->count();
    @endphp

    {{-- ── Stats ───────────────────────────────────────────── --}}
    <div class="kd-stats">
        <div class="kd-stat">
            <div class="kd-stat-icon kd-icon-total">🚗</div>
            <div>
                <div class="kd-stat-num">{{ $totalCount }}</div>
                <div class="kd-stat-label">Total Kendaraan</div>
            </div>
        </div>
        <div class="kd-stat">
            <div class="kd-stat-icon kd-icon-available">✔</div>
            <div>
                <div class="kd-stat-num" style="color:#059669;">
                    {{ $cntAvailable }}
                </div>
                <div class="kd-stat-label">Tersedia</div>
            </div>
        </div>
        <div class="kd-stat">
            <div class="kd-stat-icon kd-icon-rented">🔑</div>
            <div>
                <div class="kd-stat-num" style="color:#2563eb;">
                    {{ $cntRented }}
                </div>
                <div class="kd-stat-label">Sedang Disewa</div>
            </div>
        </div>
        <div class="kd-stat">
            <div class="kd-stat-icon kd-icon-maintenance">🔧</div>
            <div>
                <div class="kd-stat-num" style="color:#d97706;">
                    {{ $cntMaint }}
                </div>
                <div class="kd-stat-label">Maintenance</div>
            </div>
        </div>
    </div>

    {{-- ── Main Card ────────────────────────────────────────── --}}
    <div class="kd-card">

        {{-- Toolbar --}}
        <div class="kd-card-toolbar">

            {{-- Filter Tabs --}}
            <div class="kd-tabs">
                <a href="{{ route('admin.kendaraan.index') }}"
                   class="kd-tab kd-tab-all {{ !request('status') ? 'active' : '' }}">
                    🚗 Semua
                </a>
                <a href="{{ route('admin.kendaraan.index', ['status' => 'available']) }}"
                   class="kd-tab kd-tab-available {{ request('status') == 'available' ? 'active' : '' }}">
                    ✔ Tersedia
                </a>
                <a href="{{ route('admin.kendaraan.index', ['status' => 'rented']) }}"
                   class="kd-tab kd-tab-rented {{ request('status') == 'rented' ? 'active' : '' }}">
                    🔑 Disewa
                </a>
                <a href="{{ route('admin.kendaraan.index', ['status' => 'maintenance']) }}"
                   class="kd-tab kd-tab-maintenance {{ request('status') == 'maintenance' ? 'active' : '' }}">
                    🔧 Maintenance
                </a>
            </div>

            {{-- Search --}}
            <form method="GET" action="{{ route('admin.kendaraan.index') }}" style="display:flex; align-items:center; gap:8px;">
                @if(request('status'))
                    <input type="hidden" name="status" value="{{ request('status') }}">
                @endif
                <div class="kd-search-wrap">
                    <span class="kd-search-icon">🔍</span>
                    <input type="text" name="search" class="kd-search"
                           placeholder="Cari merk, model, plat..."
                           value="{{ request('search') }}">
                </div>
            </form>

        </div>

        {{-- ── Table ───────────────────────────────────────── --}}
        <div style="overflow-x:auto;">
            <table class="kd-table">
                <thead>
                    <tr>
                        <th>Foto</th>
                        <th>Kendaraan</th>
                        <th>Spesifikasi</th>
                        <th class="center">Status</th>
                        <th class="center">Harga / Hari</th>
                        <th class="center">Aksi</th>
                    </tr>
                </thead>
                <tbody>

                @forelse($kendaraan as $item)
                <tr>

                    {{-- Foto --}}
                    <td style="width:100px;">
                        @if($item->images->first())
                            <div class="kd-thumb-wrap">
                                <img src="{{ asset('storage/' . $item->images->first()->image_path) }}"
                                     class="kd-thumb"
                                     alt="{{ $item->brand }} {{ $item->model }}"
                                     onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                <div class="kd-thumb-fallback" style="display:none;">🚗</div>
                                @if($item->images->count() > 1)
                                    <span class="kd-thumb-count">+{{ $item->images->count() - 1 }}</span>
                                @endif
                            </div>
                        @else
                            <div class="kd-thumb-fallback">🚗</div>
                        @endif
                    </td>

                    {{-- Kendaraan --}}
                    <td>
                        <p style="font-size:14px; font-weight:700; color:#212529; margin:0 0 6px;">
                            {{ $item->brand }} {{ $item->model }}
                        </p>
                        <div style="display:flex; flex-wrap:wrap; gap:5px;">
                            <span class="kd-plate">{{ $item->plate_number }}</span>
                            <span class="kd-pill kd-pill-year">{{ $item->year }}</span>
                            @if($item->color)
                                <span class="kd-pill kd-pill-color">{{ $item->color }}</span>
                            @endif
                        </div>
                    </td>

                    {{-- Spesifikasi --}}
                    <td>
                        <div class="kd-spec">
                            <span>🏷</span>
                            <strong>{{ ucfirst($item->type) }}</strong>
                        </div>
                        @if($item->detail)
                            <div class="kd-spec">
                                <span>⚙</span>
                                {{ $item->detail->transmission ?? '-' }}
                            </div>
                            <div class="kd-spec">
                                <span>👥</span>
                                {{ $item->detail->seat_count ?? '-' }} kursi
                            </div>
                        @else
                            <div class="kd-spec" style="color:#d1d5db;">—</div>
                        @endif
                    </td>

                    {{-- Status --}}
                    <td class="center">
                        @if($item->status === 'available')
                            <span class="kd-badge kd-badge-available">✔ Tersedia</span>
                        @elseif($item->status === 'rented')
                            <span class="kd-badge kd-badge-rented">🔑 Disewa</span>
                        @else
                            <span class="kd-badge kd-badge-maintenance">🔧 Maintenance</span>
                        @endif
                    </td>

                    {{-- Harga --}}
                    <td class="center">
                        <p class="kd-price">Rp {{ number_format($item->price_per_day, 0, ',', '.') }}</p>
                        <p class="kd-price-sub">per hari</p>
                    </td>

                    {{-- Aksi --}}
                    <td class="center">
                        <div style="display:flex; align-items:center; justify-content:center; gap:6px;">
                            <a href="{{ route('admin.kendaraan.show', $item->id) }}"
                               class="kd-btn kd-btn-view" title="Lihat Detail">👁</a>
                            <a href="{{ route('admin.kendaraan.edit', $item->id) }}"
                               class="kd-btn kd-btn-edit" title="Edit">✏</a>
                            <form action="{{ route('admin.kendaraan.destroy', $item->id) }}" method="POST"
                                  onsubmit="return confirm('Yakin ingin menghapus {{ $item->brand }} {{ $item->model }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="kd-btn kd-btn-delete" title="Hapus">🗑</button>
                            </form>
                        </div>
                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="6">
                        <div class="kd-empty">
                            <div class="kd-empty-icon">🚗</div>
                            <p class="kd-empty-title">Belum Ada Kendaraan</p>
                            <p class="kd-empty-sub">
                                @if(request('status') || request('search'))
                                    Tidak ada kendaraan yang cocok dengan filter saat ini.
                                @else
                                    Tambahkan kendaraan pertama untuk mulai mengelola armada Anda.
                                @endif
                            </p>
                            @if(!request('status') && !request('search'))
                                <a href="{{ route('admin.kendaraan.create') }}" class="kd-empty-btn">
                                    ＋ Tambah Kendaraan
                                </a>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforelse

                </tbody>
            </table>
        </div>

        {{-- ── Footer ───────────────────────────────────────── --}}
        <div class="kd-footer">
            <div class="kd-footer-info">
                <span>
                    Total <strong style="color:#212529;">{{ $totalCount }}</strong> kendaraan
                </span>
                <span style="display:flex; align-items:center; gap:5px;">
                    <span class="kd-dot kd-dot-available"></span>
                    Tersedia: <strong style="color:#212529;">{{ $cntAvailable }}</strong>
                </span>
                <span style="display:flex; align-items:center; gap:5px;">
                    <span class="kd-dot kd-dot-rented"></span>
                    Disewa: <strong style="color:#212529;">{{ $cntRented }}</strong>
                </span>
                <span style="display:flex; align-items:center; gap:5px;">
                    <span class="kd-dot kd-dot-maintenance"></span>
                    Maintenance: <strong style="color:#212529;">{{ $cntMaint }}</strong>
                </span>
            </div>
            <div>
                @if($isPaginated)
                    {{ $kendaraan->appends(request()->query())->links() }}
                @endif
            </div>
        </div>

    </div>{{-- /kd-card --}}

</div>{{-- /kd-wrap --}}

@push('scripts')
<script>
    const kdAlert = document.getElementById('kdAlert');
    if (kdAlert) {
        setTimeout(function () {
            kdAlert.style.transition = 'opacity 0.5s';
            kdAlert.style.opacity = '0';
            setTimeout(() => kdAlert.remove(), 500);
        }, 4000);
    }

    const searchInput = document.querySelector('.kd-search');
    if (searchInput) {
        let timer;
        searchInput.addEventListener('input', function () {
            clearTimeout(timer);
            timer = setTimeout(() => this.closest('form').submit(), 600);
        });
    }
</script>
@endpush

@endsection 