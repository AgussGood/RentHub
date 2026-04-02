@extends('layouts.admin')

@section('content')
<style>
* { box-sizing: border-box; }

.bk-wrap { padding: 1.5rem 2rem 2rem 2rem; font-family: inherit; max-width: 1400px; }

/* ── Header Card ─────────────────────────────────────────── */
.bk-header-card {
    background: linear-gradient(135deg, #4f5fd5 0%, #6366f1 100%);
    border-radius: 14px;
    padding: 22px 28px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}
.bk-header-icon {
    width: 46px; height: 46px;
    background: rgba(255,255,255,0.15);
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    font-size: 20px; flex-shrink: 0;
}
.bk-header-title { font-size: 20px; font-weight: 600; color: #fff; margin: 0; }
.bk-header-sub   { font-size: 12px; color: rgba(255,255,255,0.65); margin: 3px 0 0; }

/* ── Alert ───────────────────────────────────────────────── */
.bk-alert {
    padding: 12px 16px; border-radius: 10px;
    font-size: 13px; font-weight: 500;
    display: flex; align-items: center; gap: 8px;
    margin-bottom: 16px;
}
.bk-alert-success { background: #d1fae5; color: #065f46; border: 1px solid #a7f3d0; }
.bk-alert-error   { background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }

/* ── Stats row ───────────────────────────────────────────── */
.bk-stats {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 12px;
    margin-bottom: 20px;
}
.bk-stat {
    background: #fff;
    border: 1px solid #e9ecef;
    border-radius: 12px;
    padding: 16px 18px;
    display: flex; align-items: center; gap: 14px;
}
.bk-stat-icon {
    width: 40px; height: 40px; border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    font-size: 18px; flex-shrink: 0;
}
.bk-stat-icon-all       { background: #eef2ff; }
.bk-stat-icon-pending   { background: #fef3c7; }
.bk-stat-icon-confirmed { background: #d1fae5; }
.bk-stat-icon-completed { background: #dbeafe; }
.bk-stat-icon-cancelled { background: #fee2e2; }
.bk-stat-num  { font-size: 20px; font-weight: 700; color: #212529; line-height: 1; }
.bk-stat-label{ font-size: 11px; color: #6c757d; margin-top: 3px; }

/* ── Main card ───────────────────────────────────────────── */
.bk-card {
    background: #fff;
    border: 1px solid #e9ecef;
    border-radius: 14px;
    overflow: hidden;
}
.bk-card-toolbar {
    padding: 16px 22px;
    border-bottom: 1px solid #e9ecef;
    display: flex; align-items: center;
    justify-content: space-between; gap: 12px;
    flex-wrap: wrap;
}

/* ── Filter tabs ─────────────────────────────────────────── */
.bk-tabs { display: flex; gap: 6px; flex-wrap: wrap; }
.bk-tab {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 6px 14px; border-radius: 8px;
    font-size: 12px; font-weight: 600;
    text-decoration: none; transition: all 0.15s;
    border: 1px solid transparent;
}
.bk-tab-all       { background: #f1f3f5; color: #495057; border-color: #e9ecef; }
.bk-tab-all:hover { background: #e9ecef; color: #212529; text-decoration: none; }
.bk-tab-all.active{ background: #6366f1; color: #fff; border-color: #6366f1; }

.bk-tab-pending       { background: #fef3c7; color: #92400e; border-color: #fde68a; }
.bk-tab-pending.active{ background: #d97706; color: #fff;    border-color: #d97706; }

.bk-tab-confirmed       { background: #d1fae5; color: #065f46; border-color: #a7f3d0; }
.bk-tab-confirmed.active{ background: #059669; color: #fff;    border-color: #059669; }

.bk-tab-completed       { background: #dbeafe; color: #1e40af; border-color: #bfdbfe; }
.bk-tab-completed.active{ background: #2563eb; color: #fff;    border-color: #2563eb; }

.bk-tab-cancelled       { background: #fee2e2; color: #991b1b; border-color: #fecaca; }
.bk-tab-cancelled.active{ background: #dc2626; color: #fff;    border-color: #dc2626; }

/* ── Search box ──────────────────────────────────────────── */
.bk-search-wrap {
    position: relative; display: flex; align-items: center;
}
.bk-search-icon {
    position: absolute; left: 10px; font-size: 13px; color: #9ca3af;
}
.bk-search {
    padding: 7px 12px 7px 32px;
    border: 1px solid #e9ecef; border-radius: 8px;
    font-size: 13px; color: #212529; outline: none;
    transition: border-color 0.15s, box-shadow 0.15s;
    width: 220px;
}
.bk-search:focus {
    border-color: #6366f1;
    box-shadow: 0 0 0 3px rgba(99,102,241,0.1);
}

/* ── Table ───────────────────────────────────────────────── */
.bk-table { width: 100%; border-collapse: collapse; }
.bk-table thead tr {
    background: #f8f9fa;
    border-bottom: 1px solid #e9ecef;
}
.bk-table thead th {
    padding: 11px 18px;
    font-size: 11px; font-weight: 700;
    color: #6c757d; text-transform: uppercase;
    letter-spacing: 0.05em; white-space: nowrap;
}
.bk-table thead th.center { text-align: center; }

.bk-table tbody tr {
    border-bottom: 1px solid #f1f3f5;
    transition: background 0.12s;
}
.bk-table tbody tr:last-child { border-bottom: none; }
.bk-table tbody tr:hover { background: #fafbff; }
.bk-table td { padding: 14px 18px; vertical-align: middle; }
.bk-table td.center { text-align: center; }

/* ── Avatar ──────────────────────────────────────────────── */
.bk-avatar {
    width: 36px; height: 36px; border-radius: 50%;
    background: linear-gradient(135deg, #6366f1, #4f46e5);
    display: flex; align-items: center; justify-content: center;
    color: #fff; font-size: 13px; font-weight: 700;
    flex-shrink: 0;
}

/* ── Vehicle thumb ───────────────────────────────────────── */
.bk-thumb {
    width: 44px; height: 44px; border-radius: 8px;
    object-fit: cover; border: 1px solid #e9ecef;
    flex-shrink: 0;
}
.bk-thumb-fallback {
    width: 44px; height: 44px; border-radius: 8px;
    background: #f1f3f5; border: 1px solid #e9ecef;
    display: flex; align-items: center; justify-content: center;
    font-size: 18px; flex-shrink: 0;
}

/* ── Plate ───────────────────────────────────────────────── */
.bk-plate {
    font-size: 11px; font-weight: 700;
    background: #f8f9fa; border: 1px solid #dee2e6;
    border-radius: 5px; padding: 2px 7px;
    font-family: monospace; letter-spacing: 0.06em;
    color: #495057; display: inline-block;
}

/* ── Badges / status ─────────────────────────────────────── */
.bk-badge {
    display: inline-flex; align-items: center; gap: 4px;
    padding: 4px 10px; border-radius: 99px;
    font-size: 11px; font-weight: 600; white-space: nowrap;
}
.bk-badge-pending   { background: #fef3c7; color: #92400e; }
.bk-badge-confirmed { background: #d1fae5; color: #065f46; }
.bk-badge-completed { background: #dbeafe; color: #1e40af; }
.bk-badge-cancelled { background: #fee2e2; color: #991b1b; }

.bk-pay-paid   { background: #d1fae5; color: #065f46; }
.bk-pay-unpaid { background: #fee2e2; color: #991b1b; }

/* ── Action buttons ──────────────────────────────────────── */
.bk-btn-icon {
    width: 32px; height: 32px; border-radius: 8px;
    display: inline-flex; align-items: center; justify-content: center;
    font-size: 13px; cursor: pointer; transition: opacity 0.15s, transform 0.1s;
    border: none; text-decoration: none;
}
.bk-btn-icon:hover { opacity: 0.85; transform: scale(1.08); text-decoration: none; }
.bk-btn-view    { background: #eef2ff; color: #6366f1; }
.bk-btn-confirm { background: #d1fae5; color: #059669; }
.bk-btn-done    { background: #dbeafe; color: #2563eb; }

/* ── Empty state ─────────────────────────────────────────── */
.bk-empty {
    padding: 56px 24px;
    text-align: center; color: #9ca3af;
}
.bk-empty-icon { font-size: 44px; margin-bottom: 12px; }
.bk-empty-title { font-size: 15px; font-weight: 600; color: #6c757d; margin-bottom: 6px; }
.bk-empty-sub   { font-size: 13px; }

/* ── Footer / Pagination ─────────────────────────────────── */
.bk-footer {
    padding: 14px 22px;
    border-top: 1px solid #e9ecef;
    display: flex; align-items: center;
    justify-content: space-between; gap: 12px;
    flex-wrap: wrap;
}
.bk-pagination-info { font-size: 12px; color: #6c757d; }
.bk-pagination-info strong { color: #212529; }

/* ── Responsive ──────────────────────────────────────────── */
@media (max-width: 1100px) {
    .bk-stats { grid-template-columns: repeat(3, 1fr); }
}
@media (max-width: 768px) {
    .bk-stats { grid-template-columns: repeat(2, 1fr); }
    .bk-wrap  { padding: 1rem; }
    .bk-header-card { flex-direction: column; align-items: flex-start; gap: 10px; }
    .bk-search { width: 160px; }
}
@media (max-width: 480px) {
    .bk-stats { grid-template-columns: 1fr 1fr; }
}
</style>

<div class="bk-wrap">

    {{-- ── Header ──────────────────────────────────────────── --}}
    <div class="bk-header-card">
        <div style="display:flex; align-items:center; gap:16px;">
            <div class="bk-header-icon">📋</div>
            <div>
                <p class="bk-header-sub">Panel Admin · Manajemen</p>
                <h4 class="bk-header-title">Manajemen Booking</h4>
            </div>
        </div>
        <div style="font-size:12px; color:rgba(255,255,255,0.7);">
            Total <strong style="color:#fff; font-size:18px;">{{ $bookings->total() }}</strong> booking
        </div>
    </div>

    {{-- ── Alert ───────────────────────────────────────────── --}}
    @if(session('success'))
        <div class="bk-alert bk-alert-success" id="bkAlert">
            ✔ {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="bk-alert bk-alert-error" id="bkAlert">
            ✖ {{ session('error') }}
        </div>
    @endif

    {{-- ── Stats Cards ─────────────────────────────────────── --}}
    <div class="bk-stats">
        <div class="bk-stat">
            <div class="bk-stat-icon bk-stat-icon-all">📋</div>
            <div>
                <div class="bk-stat-num">{{ $bookings->total() }}</div>
                <div class="bk-stat-label">Semua Booking</div>
            </div>
        </div>
        <div class="bk-stat">
            <div class="bk-stat-icon bk-stat-icon-pending">⏳</div>
            <div>
                <div class="bk-stat-num" style="color:#d97706;">
                    {{ $bookings->getCollection()->where('status','pending')->count() }}
                </div>
                <div class="bk-stat-label">Menunggu</div>
            </div>
        </div>
        <div class="bk-stat">
            <div class="bk-stat-icon bk-stat-icon-confirmed">✔</div>
            <div>
                <div class="bk-stat-num" style="color:#059669;">
                    {{ $bookings->getCollection()->where('status','confirmed')->count() }}
                </div>
                <div class="bk-stat-label">Dikonfirmasi</div>
            </div>
        </div>
        <div class="bk-stat">
            <div class="bk-stat-icon bk-stat-icon-completed">🏁</div>
            <div>
                <div class="bk-stat-num" style="color:#2563eb;">
                    {{ $bookings->getCollection()->where('status','completed')->count() }}
                </div>
                <div class="bk-stat-label">Selesai</div>
            </div>
        </div>
        <div class="bk-stat">
            <div class="bk-stat-icon bk-stat-icon-cancelled">✖</div>
            <div>
                <div class="bk-stat-num" style="color:#dc2626;">
                    {{ $bookings->getCollection()->where('status','cancelled')->count() }}
                </div>
                <div class="bk-stat-label">Dibatalkan</div>
            </div>
        </div>
    </div>

    {{-- ── Main Card ────────────────────────────────────────── --}}
    <div class="bk-card">

        {{-- Toolbar: Tabs + Search --}}
        <div class="bk-card-toolbar">

            {{-- Filter Tabs --}}
            <div class="bk-tabs">
                <a href="{{ route('admin.bookings.index') }}"
                   class="bk-tab bk-tab-all {{ !request('status') ? 'active' : '' }}">
                    📋 Semua
                </a>
                <a href="{{ route('admin.bookings.index', ['status' => 'pending']) }}"
                   class="bk-tab bk-tab-pending {{ request('status') == 'pending' ? 'active' : '' }}">
                    ⏳ Menunggu
                </a>
                <a href="{{ route('admin.bookings.index', ['status' => 'confirmed']) }}"
                   class="bk-tab bk-tab-confirmed {{ request('status') == 'confirmed' ? 'active' : '' }}">
                    ✔ Dikonfirmasi
                </a>
                <a href="{{ route('admin.bookings.index', ['status' => 'completed']) }}"
                   class="bk-tab bk-tab-completed {{ request('status') == 'completed' ? 'active' : '' }}">
                    🏁 Selesai
                </a>
                <a href="{{ route('admin.bookings.index', ['status' => 'cancelled']) }}"
                   class="bk-tab bk-tab-cancelled {{ request('status') == 'cancelled' ? 'active' : '' }}">
                    ✖ Dibatalkan
                </a>
            </div>

            {{-- Search --}}
            <form method="GET" action="{{ route('admin.bookings.index') }}" style="display:flex; gap:8px; align-items:center;">
                @if(request('status'))
                    <input type="hidden" name="status" value="{{ request('status') }}">
                @endif
                <div class="bk-search-wrap">
                    <span class="bk-search-icon">🔍</span>
                    <input type="text" name="search" class="bk-search"
                           placeholder="Cari booking, pelanggan..."
                           value="{{ request('search') }}">
                </div>
            </form>

        </div>

        {{-- ── Table ───────────────────────────────────────── --}}
        <div style="overflow-x: auto;">
            <table class="bk-table">
                <thead>
                    <tr>
                        <th>Booking ID</th>
                        <th>Pelanggan</th>
                        <th>Kendaraan</th>
                        <th class="center">Periode Sewa</th>
                        <th class="center">Total Biaya</th>
                        <th class="center">Status</th>
                        <th class="center">Pembayaran</th>
                        <th class="center">Aksi</th>
                    </tr>
                </thead>
                <tbody>

                @forelse($bookings as $booking)
                <tr>

                    {{-- Booking ID --}}
                    <td>
                        <span style="font-size:13px; font-weight:700; color:#212529; font-family:monospace;">
                            #{{ str_pad($booking->id, 6, '0', STR_PAD_LEFT) }}
                        </span>
                        <p style="font-size:11px; color:#9ca3af; margin:3px 0 0;">
                            {{ $booking->created_at->translatedFormat('d M Y') }}
                        </p>
                    </td>

                    {{-- Pelanggan --}}
                    <td>
                        <div style="display:flex; align-items:center; gap:10px;">
                            <div class="bk-avatar">{{ strtoupper(substr($booking->user->name, 0, 1)) }}</div>
                            <div>
                                <p style="font-size:13px; font-weight:600; color:#212529; margin:0;">
                                    {{ $booking->user->name }}
                                </p>
                                <p style="font-size:11px; color:#9ca3af; margin:2px 0 0;">
                                    {{ $booking->user->email }}
                                </p>
                            </div>
                        </div>
                    </td>

                    {{-- Kendaraan --}}
                    <td>
                        <div style="display:flex; align-items:center; gap:10px;">
                            @if($booking->kendaraan->images->first())
                                <img src="{{ Storage::url($booking->kendaraan->images->first()->image_path) }}"
                                     alt="{{ $booking->kendaraan->brand }}"
                                     class="bk-thumb">
                            @else
                                <div class="bk-thumb-fallback">🚗</div>
                            @endif
                            <div>
                                <p style="font-size:13px; font-weight:600; color:#212529; margin:0;">
                                    {{ $booking->kendaraan->brand }} {{ $booking->kendaraan->model }}
                                </p>
                                <span class="bk-plate" style="margin-top:4px; display:inline-block;">
                                    {{ $booking->kendaraan->plate_number }}
                                </span>
                            </div>
                        </div>
                    </td>

                    {{-- Periode Sewa --}}
                    <td class="center">
                        <p style="font-size:13px; font-weight:600; color:#212529; margin:0; white-space:nowrap;">
                            {{ \Carbon\Carbon::parse($booking->start_date)->translatedFormat('d M') }}
                            —
                            {{ \Carbon\Carbon::parse($booking->end_date)->translatedFormat('d M Y') }}
                        </p>
                        <p style="font-size:11px; color:#9ca3af; margin:3px 0 0;">
                            {{ $booking->total_days }} hari
                        </p>
                    </td>

                    {{-- Total --}}
                    <td class="center">
                        <span style="font-size:14px; font-weight:700; color:#6366f1;">
                            Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                        </span>
                    </td>

                    {{-- Status Booking --}}
                    <td class="center">
                        @php
                            $statusMap = [
                                'pending'   => ['class' => 'bk-badge-pending',   'icon' => '⏳', 'label' => 'Menunggu'],
                                'confirmed' => ['class' => 'bk-badge-confirmed', 'icon' => '✔',  'label' => 'Dikonfirmasi'],
                                'completed' => ['class' => 'bk-badge-completed', 'icon' => '🏁', 'label' => 'Selesai'],
                                'cancelled' => ['class' => 'bk-badge-cancelled', 'icon' => '✖',  'label' => 'Dibatalkan'],
                            ];
                            $st = $statusMap[$booking->status] ?? $statusMap['pending'];
                        @endphp
                        <span class="bk-badge {{ $st['class'] }}">
                            {{ $st['icon'] }} {{ $st['label'] }}
                        </span>
                    </td>

                    {{-- Payment --}}
                    <td class="center">
                        @if($booking->payment && $booking->payment->payment_status === 'paid')
                            <span class="bk-badge bk-pay-paid">✔ Lunas</span>
                        @else
                            <span class="bk-badge bk-pay-unpaid">✖ Belum Bayar</span>
                        @endif
                    </td>

                    {{-- Aksi --}}
                    <td class="center">
                        <div style="display:flex; justify-content:center; align-items:center; gap:6px;">

                            {{-- Detail --}}
                            <a href="{{ route('admin.bookings.show', $booking->id) }}"
                               class="bk-btn-icon bk-btn-view"
                               title="Lihat Detail">👁</a>

                            {{-- Konfirmasi (pending + sudah bayar) --}}
                            @if($booking->status === 'pending' && $booking->payment)
                                <form action="{{ route('admin.bookings.updateStatus', $booking->id) }}"
                                      method="POST" style="display:inline;"
                                      onsubmit="return confirm('Konfirmasi booking #{{ str_pad($booking->id,6,'0',STR_PAD_LEFT) }}?')">
                                    @csrf
                                    <input type="hidden" name="status" value="confirmed">
                                    <button type="submit" class="bk-btn-icon bk-btn-confirm" title="Konfirmasi">✔</button>
                                </form>
                            @endif

                            {{-- Selesaikan (confirmed + sudah ada return) --}}
                            @if($booking->status === 'confirmed' && $booking->return)
                                <form action="{{ route('admin.bookings.updateStatus', $booking->id) }}"
                                      method="POST" style="display:inline;"
                                      onsubmit="return confirm('Tandai booking ini sebagai selesai?')">
                                    @csrf
                                    <input type="hidden" name="status" value="completed">
                                    <button type="submit" class="bk-btn-icon bk-btn-done" title="Tandai Selesai">🏁</button>
                                </form>
                            @endif

                        </div>
                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="8">
                        <div class="bk-empty">
                            <div class="bk-empty-icon">📭</div>
                            <p class="bk-empty-title">Tidak ada data booking</p>
                            <p class="bk-empty-sub">
                                @if(request('status'))
                                    Tidak ada booking dengan status
                                    <strong>{{ $statusMap[request('status')]['label'] ?? request('status') }}</strong>
                                    saat ini.
                                @else
                                    Belum ada booking yang masuk.
                                @endif
                            </p>
                        </div>
                    </td>
                </tr>
                @endforelse

                </tbody>
            </table>
        </div>

        {{-- ── Footer Pagination ────────────────────────────── --}}
        <div class="bk-footer">
            <p class="bk-pagination-info">
                Menampilkan
                <strong>{{ $bookings->firstItem() ?? 0 }}–{{ $bookings->lastItem() ?? 0 }}</strong>
                dari <strong>{{ $bookings->total() }}</strong> booking
            </p>
            <div>
                {{ $bookings->appends(request()->query())->links() }}
            </div>
        </div>

    </div>{{-- /bk-card --}}

</div>{{-- /bk-wrap --}}

@push('scripts')
<script>
    // Auto-dismiss alert
    const bkAlert = document.getElementById('bkAlert');
    if (bkAlert) {
        setTimeout(function () {
            bkAlert.style.transition = 'opacity 0.5s';
            bkAlert.style.opacity = '0';
            setTimeout(() => bkAlert.remove(), 500);
        }, 4000);
    }

    // Live search on Enter / input delay
    const searchInput = document.querySelector('.bk-search');
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