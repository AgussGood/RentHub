@extends('layouts.admin')

@section('breadcrumb', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

* { box-sizing: border-box; }

.dash {
    padding: 24px 28px 40px;
    font-family: 'Plus Jakarta Sans', sans-serif;
    background: transparent;
    min-height: calc(100vh - 60px);
}

/* ── HERO BANNER ── */
.dash-hero {
    position: relative;
    border-radius: 18px;
    padding: 28px 32px;
    margin-bottom: 22px;
    background: linear-gradient(120deg, #4338ca 0%, #6366f1 50%, #818cf8 100%);
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
}

.dash-hero::before {
    content: '';
    position: absolute;
    inset: 0;
    background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Ccircle cx='30' cy='30' r='28' fill='none' stroke='rgba(255,255,255,0.06)' stroke-width='1'/%3E%3C/svg%3E") repeat;
    pointer-events: none;
}

/* decorative orbs */
.dash-hero::after {
    content: '';
    position: absolute;
    width: 260px;
    height: 260px;
    border-radius: 50%;
    background: rgba(255,255,255,0.07);
    right: -60px;
    top: -80px;
    pointer-events: none;
}

.dash-hero-text { position: relative; z-index: 1; }

.dash-hero-greeting {
    font-size: 12px;
    font-weight: 600;
    letter-spacing: .08em;
    color: rgba(255,255,255,.65);
    text-transform: uppercase;
    margin-bottom: 4px;
}

.dash-hero-title {
    font-size: 24px;
    font-weight: 800;
    color: #fff;
    letter-spacing: -0.03em;
    margin-bottom: 4px;
}

.dash-hero-sub {
    font-size: 13px;
    color: rgba(255,255,255,.6);
}

.dash-hero-date {
    position: relative;
    z-index: 1;
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    gap: 3px;
    flex-shrink: 0;
}

.dash-hero-date-day {
    font-size: 36px;
    font-weight: 800;
    color: rgba(255,255,255,.9);
    line-height: 1;
    letter-spacing: -0.04em;
}

.dash-hero-date-month {
    font-size: 13px;
    font-weight: 500;
    color: rgba(255,255,255,.55);
}

/* ── STAT GRID ── */
.dash-stats {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 14px;
    margin-bottom: 22px;
}

.dash-stat {
    background: #fff;
    border-radius: 14px;
    border: 1.5px solid #eef0f6;
    padding: 18px 20px;
    display: flex;
    flex-direction: column;
    gap: 12px;
    transition: box-shadow .2s, transform .2s;
}

.dash-stat:hover {
    box-shadow: 0 8px 24px rgba(99,102,241,.08);
    transform: translateY(-2px);
}

.dash-stat-top {
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.dash-stat-label {
    font-size: 11.5px;
    font-weight: 600;
    color: #6b7280;
    letter-spacing: .02em;
}

.dash-stat-icon {
    width: 36px;
    height: 36px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
}

.dash-stat-value {
    font-size: 22px;
    font-weight: 800;
    color: #111827;
    letter-spacing: -0.03em;
    line-height: 1;
}

.dash-stat-footer {
    display: flex;
    align-items: center;
    gap: 5px;
    font-size: 11px;
}

.dash-stat-trend {
    display: inline-flex;
    align-items: center;
    gap: 2px;
    font-weight: 700;
    padding: 2px 6px;
    border-radius: 6px;
}

.dash-stat-trend.up { background: #dcfce7; color: #16a34a; }
.dash-stat-trend.down { background: #fee2e2; color: #dc2626; }
.dash-stat-trend.neutral { background: #f3f4f6; color: #6b7280; }

.dash-stat-trend-desc { color: #9ca3af; }

/* ── 2-COL LAYOUT ── */
.dash-row {
    display: grid;
    grid-template-columns: 1fr 340px;
    gap: 16px;
    margin-bottom: 16px;
}

/* ── CARD ── */
.dash-card {
    background: #fff;
    border-radius: 14px;
    border: 1.5px solid #eef0f6;
    overflow: hidden;
}

.dash-card-hd {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 16px 20px 12px;
    border-bottom: 1px solid #f3f4f6;
}

.dash-card-hd-title {
    font-size: 13.5px;
    font-weight: 700;
    color: #111827;
    letter-spacing: -0.01em;
}

.dash-card-hd-link {
    font-size: 11.5px;
    font-weight: 600;
    color: #6366f1;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 3px;
    transition: opacity .15s;
}

.dash-card-hd-link:hover { opacity: .75; }

.dash-card-body { padding: 16px 20px; }

/* ── CHART ── */
#admChart { display: block; width: 100% !important; }

/* ── TABLE ── */
.dash-table { width: 100%; border-collapse: collapse; }

.dash-table thead tr th {
    font-size: 10.5px;
    font-weight: 700;
    letter-spacing: .06em;
    text-transform: uppercase;
    color: #9ca3af;
    padding: 0 10px 10px;
    text-align: left;
    white-space: nowrap;
}

.dash-table tbody tr {
    border-top: 1px solid #f3f4f6;
    transition: background .14s;
}

.dash-table tbody tr:hover { background: #fafafa; }

.dash-table tbody td {
    padding: 11px 10px;
    font-size: 12.5px;
    color: #374151;
    white-space: nowrap;
}

.dash-table .t-name { font-weight: 600; color: #111827; }

.dash-table .t-car {
    max-width: 140px;
    overflow: hidden;
    text-overflow: ellipsis;
}

/* status badge */
.s-badge {
    display: inline-block;
    padding: 3px 9px;
    border-radius: 99px;
    font-size: 10.5px;
    font-weight: 700;
}

.s-pending   { background: #fef9c3; color: #a16207; }
.s-confirmed { background: #dcfce7; color: #166534; }
.s-active    { background: #dbeafe; color: #1e40af; }
.s-completed { background: #f3f4f6; color: #374151; }
.s-cancelled { background: #fee2e2; color: #dc2626; }

/* ── ACTIVITY LIST ── */
.act-list { display: flex; flex-direction: column; gap: 0; }

.act-item {
    display: flex;
    align-items: flex-start;
    gap: 11px;
    padding: 11px 0;
    border-bottom: 1px solid #f3f4f6;
}

.act-item:last-child { border-bottom: none; }

.act-ico {
    width: 32px;
    height: 32px;
    border-radius: 9px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    flex-shrink: 0;
}

.act-text { min-width: 0; }

.act-text-main {
    font-size: 12.5px;
    font-weight: 500;
    color: #374151;
    line-height: 1.4;
}

.act-text-main strong { color: #111827; font-weight: 700; }

.act-text-time { font-size: 10.5px; color: #9ca3af; margin-top: 2px; }

/* ── VEHICLE STATUS ── */
.veh-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 10px 0;
    border-bottom: 1px solid #f3f4f6;
    gap: 10px;
}

.veh-row:last-child { border-bottom: none; }

.veh-name {
    font-size: 12.5px;
    font-weight: 600;
    color: #111827;
    flex: 1;
    min-width: 0;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.veh-bar-wrap {
    flex: 1;
    height: 6px;
    background: #f3f4f6;
    border-radius: 99px;
    overflow: hidden;
}

.veh-bar-fill {
    height: 100%;
    border-radius: 99px;
    background: linear-gradient(90deg, #6366f1, #818cf8);
    transition: width .6s ease;
}

.veh-pct {
    font-size: 11px;
    font-weight: 700;
    color: #6366f1;
    min-width: 32px;
    text-align: right;
}

/* responsive */
@media(max-width:1100px){
    .dash-stats { grid-template-columns: repeat(2,1fr); }
    .dash-row   { grid-template-columns: 1fr; }
}
@media(max-width:640px){
    .dash { padding: 14px 14px 32px; }
    .dash-stats { grid-template-columns: 1fr 1fr; }
    .dash-hero { flex-direction: column; align-items: flex-start; }
    .dash-hero-date { align-items: flex-start; }
}
</style>

<div class="dash">

    {{-- ── HERO ── --}}
    <div class="dash-hero">
        <div class="dash-hero-text">
            <div class="dash-hero-greeting">Selamat datang kembali</div>
            <div class="dash-hero-title">{{ Auth::user()->name }} 👋</div>
            <div class="dash-hero-sub">Monitoring sistem rental kendaraan RentHub</div>
        </div>
        <div class="dash-hero-date">
            <div class="dash-hero-date-day">{{ now()->format('d') }}</div>
            <div class="dash-hero-date-month">{{ now()->translatedFormat('F Y') }}</div>
        </div>
    </div>

    {{-- ── STATS ── --}}
    <div class="dash-stats">

        <div class="dash-stat">
            <div class="dash-stat-top">
                <div class="dash-stat-label">Pendapatan Hari Ini</div>
                <div class="dash-stat-icon" style="background:#eef2ff;">💰</div>
            </div>
            <div class="dash-stat-value" style="font-size:17px;">
                Rp {{ number_format($todayRevenue,0,',','.') }}
            </div>
            <div class="dash-stat-footer">
                <span class="dash-stat-trend {{ $todayRevenue > 0 ? 'up' : 'neutral' }}">
                    {{ $todayRevenue > 0 ? '↑' : '—' }}
                </span>
                <span class="dash-stat-trend-desc">hari ini</span>
            </div>
        </div>

        <div class="dash-stat">
            <div class="dash-stat-top">
                <div class="dash-stat-label">Booking Aktif</div>
                <div class="dash-stat-icon" style="background:#dcfce7;">📅</div>
            </div>
            <div class="dash-stat-value">{{ $todayActiveBookings }}</div>
            <div class="dash-stat-footer">
                @php $pendingCount = \App\Models\Booking::where('status','pending')->count(); @endphp
                <span class="dash-stat-trend {{ $pendingCount > 0 ? 'neutral' : 'up' }}">
                    {{ $pendingCount }}
                </span>
                <span class="dash-stat-trend-desc">pending persetujuan</span>
            </div>
        </div>

        <div class="dash-stat">
            <div class="dash-stat-top">
                <div class="dash-stat-label">Customer Baru</div>
                <div class="dash-stat-icon" style="background:#fce7f3;">👥</div>
            </div>
            <div class="dash-stat-value">{{ $newCustomersThisMonth }}</div>
            <div class="dash-stat-footer">
                <span class="dash-stat-trend up">↑</span>
                <span class="dash-stat-trend-desc">bulan ini</span>
            </div>
        </div>

        <div class="dash-stat">
            <div class="dash-stat-top">
                <div class="dash-stat-label">Penjualan Bulan Ini</div>
                <div class="dash-stat-icon" style="background:#fef9c3;">📊</div>
            </div>
            <div class="dash-stat-value" style="font-size:17px;">
                Rp {{ number_format($totalSalesThisMonth,0,',','.') }}
            </div>
            <div class="dash-stat-footer">
                <span class="dash-stat-trend up">↑</span>
                <span class="dash-stat-trend-desc">{{ now()->translatedFormat('F') }}</span>
            </div>
        </div>

    </div>

    {{-- ── ROW 1: Chart + Activity ── --}}
    <div class="dash-row" style="margin-bottom:16px;">

        <div class="dash-card">
            <div class="dash-card-hd">
                <span class="dash-card-hd-title">Revenue 6 Bulan Terakhir</span>
            </div>
            <div class="dash-card-body">
                <canvas id="admChart" height="90"></canvas>
            </div>
        </div>

        <div class="dash-card">
            <div class="dash-card-hd">
                <span class="dash-card-hd-title">Aktivitas Terbaru</span>
            </div>
            <div class="dash-card-body" style="padding-top:4px;padding-bottom:4px;">
                <div class="act-list">
                    @php
                        $acts = \App\Models\Booking::with('user','kendaraan')
                            ->latest()->take(5)->get();
                    @endphp
                    @forelse($acts as $act)
                    <div class="act-item">
                        <div class="act-ico" style="background:#eef2ff;">📋</div>
                        <div class="act-text">
                            <div class="act-text-main">
                                <strong>{{ $act->user->name ?? 'User' }}</strong>
                                booking {{ $act->kendaraan->brand ?? '' }} {{ $act->kendaraan->model ?? '' }}
                            </div>
                            <div class="act-text-time">{{ $act->created_at->diffForHumans() }}</div>
                        </div>
                    </div>
                    @empty
                    <div style="padding:16px 0;text-align:center;font-size:12px;color:#9ca3af;">
                        Belum ada aktivitas
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

    </div>

    {{-- ── ROW 2: Recent Bookings + Top Vehicles ── --}}
    <div class="dash-row">

        <div class="dash-card">
            <div class="dash-card-hd">
                <span class="dash-card-hd-title">Booking Terbaru</span>
                <a href="{{ route('admin.bookings.index') }}" class="dash-card-hd-link">
                    Semua booking →
                </a>
            </div>
            <div class="dash-card-body" style="padding:0 20px;">
                <table class="dash-table">
                    <thead>
                        <tr>
                            <th>Customer</th>
                            <th>Kendaraan</th>
                            <th>Status</th>
                            <th style="text-align:right;">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentBookings as $b)
                        <tr>
                            <td class="t-name">{{ $b->user->name ?? '-' }}</td>
                            <td class="t-car">{{ ($b->kendaraan->brand ?? '').' '.($b->kendaraan->model ?? '') }}</td>
                            <td>
                                <span class="s-badge s-{{ $b->status }}">
                                    {{ ucfirst($b->status) }}
                                </span>
                            </td>
                            <td style="text-align:right;font-weight:600;color:#111827;">
                                Rp {{ number_format($b->total_price,0,',','.') }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" style="text-align:center;color:#9ca3af;padding:20px 0;">
                                Belum ada booking
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="dash-card">
            <div class="dash-card-hd">
                <span class="dash-card-hd-title">Kendaraan Terpopuler</span>
                <a href="{{ route('admin.kendaraan.index') }}" class="dash-card-hd-link">Semua →</a>
            </div>
            <div class="dash-card-body" style="padding-top:6px;padding-bottom:6px;">
                @php
                    $topVeh = \App\Models\Booking::select('kendaraan_id', \Illuminate\Support\Facades\DB::raw('count(*) as total'))
                        ->with('kendaraan')
                        ->groupBy('kendaraan_id')
                        ->orderByDesc('total')
                        ->take(5)
                        ->get();
                    $maxV = $topVeh->max('total') ?: 1;
                @endphp
                @forelse($topVeh as $v)
                <div class="veh-row">
                    <div class="veh-name">
                        {{ ($v->kendaraan->brand ?? '').' '.($v->kendaraan->model ?? '') }}
                    </div>
                    <div class="veh-bar-wrap">
                        <div class="veh-bar-fill" style="width:{{ round($v->total/$maxV*100) }}%"></div>
                    </div>
                    <div class="veh-pct">{{ $v->total }}x</div>
                </div>
                @empty
                <div style="padding:16px 0;text-align:center;font-size:12px;color:#9ca3af;">Belum ada data</div>
                @endforelse
            </div>
        </div>

    </div>

</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
(function(){
    var raw  = @json($monthlyRevenue);
    var ctx  = document.getElementById('admChart').getContext('2d');

    var grad = ctx.createLinearGradient(0,0,0,200);
    grad.addColorStop(0,'rgba(99,102,241,0.18)');
    grad.addColorStop(1,'rgba(99,102,241,0)');

    new Chart(ctx,{
        type:'line',
        data:{
            labels: raw.map(i=>i.month),
            datasets:[{
                label:'Revenue',
                data: raw.map(i=>i.revenue),
                borderColor:'#6366f1',
                borderWidth:2.5,
                pointBackgroundColor:'#6366f1',
                pointRadius:4,
                pointHoverRadius:6,
                tension:0.42,
                fill:true,
                backgroundColor:grad,
            }]
        },
        options:{
            responsive:true,
            plugins:{
                legend:{display:false},
                tooltip:{
                    callbacks:{
                        label:function(c){
                            return ' Rp '+Number(c.raw).toLocaleString('id-ID');
                        }
                    }
                }
            },
            scales:{
                x:{
                    grid:{display:false},
                    ticks:{font:{size:11,family:'Plus Jakarta Sans'},color:'#9ca3af'}
                },
                y:{
                    grid:{color:'#f3f4f6',drawBorder:false},
                    ticks:{
                        font:{size:11,family:'Plus Jakarta Sans'},
                        color:'#9ca3af',
                        callback:function(v){
                            if(v>=1000000) return 'Rp '+(v/1000000).toFixed(1)+'jt';
                            if(v>=1000)    return 'Rp '+(v/1000).toFixed(0)+'rb';
                            return 'Rp '+v;
                        }
                    }
                }
            }
        }
    });
})();
</script>
@endpush