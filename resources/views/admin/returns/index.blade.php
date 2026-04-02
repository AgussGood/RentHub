@extends('layouts.admin')

@section('content')
<style>
* { box-sizing: border-box; }

.ret-wrap { padding: 1.5rem 2rem 2rem 2rem; font-family: inherit; max-width: 1200px; }

/* Header Card */
.ret-header-card {
    background: linear-gradient(135deg, #4f5fd5 0%, #6366f1 100%);
    border-radius: 14px;
    padding: 22px 28px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}
.ret-header-icon {
    width: 46px; height: 46px;
    background: rgba(255,255,255,0.15);
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    font-size: 20px; flex-shrink: 0;
}
.ret-header-title { font-size: 20px; font-weight: 600; color: #fff; margin: 0; }
.ret-header-sub   { font-size: 12px; color: rgba(255,255,255,0.65); margin: 3px 0 0; }

/* Stat cards */
.ret-stats { display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px; margin-bottom: 20px; }
.ret-stat {
    background: #fff;
    border: 1px solid #e9ecef;
    border-radius: 12px;
    padding: 16px 18px;
    display: flex; align-items: center; gap: 14px;
}
.ret-stat-icon {
    width: 42px; height: 42px; border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    font-size: 18px; flex-shrink: 0;
}
.ret-stat-num { font-size: 22px; font-weight: 700; color: #212529; line-height: 1; }
.ret-stat-lbl { font-size: 11px; color: #6c757d; margin-top: 3px; }

/* Main card */
.ret-card {
    background: #fff;
    border: 1px solid #e9ecef;
    border-radius: 14px;
    overflow: hidden;
}

/* Table */
.ret-table { width: 100%; border-collapse: collapse; }
.ret-table thead tr { background: #f8f9fa; }
.ret-table thead th {
    padding: 11px 16px;
    font-size: 11px; font-weight: 700;
    color: #6c757d;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    text-align: left;
    border-bottom: 1px solid #e9ecef;
    white-space: nowrap;
}
.ret-table thead th.center { text-align: center; }
.ret-table tbody tr { border-bottom: 1px solid #f1f3f5; transition: background 0.12s; }
.ret-table tbody tr:last-child { border-bottom: none; }
.ret-table tbody tr:hover { background: #f8f9ff; }
.ret-table td { padding: 13px 16px; vertical-align: middle; }
.ret-table td.center { text-align: center; }

/* Avatar */
.ret-avatar {
    width: 36px; height: 36px; border-radius: 50%;
    background: linear-gradient(135deg, #6366f1, #818cf8);
    display: flex; align-items: center; justify-content: center;
    font-weight: 700; font-size: 13px; color: #fff; flex-shrink: 0;
}

/* ID pill */
.ret-id {
    font-size: 12px; font-weight: 600;
    color: #6366f1; background: #eef2ff;
    border-radius: 6px; padding: 3px 8px;
    font-family: monospace;
}

/* Plate */
.ret-plate {
    font-size: 11px; font-weight: 600;
    background: #f8f9fa; border: 1px solid #dee2e6;
    border-radius: 5px; padding: 2px 7px;
    font-family: monospace; letter-spacing: 0.06em;
    color: #495057; display: inline-block; margin-top: 3px;
}

/* Badges */
.ret-badge { display: inline-flex; align-items: center; gap: 4px; padding: 4px 10px; border-radius: 99px; font-size: 11px; font-weight: 600; white-space: nowrap; }
.ret-badge-pending   { background: #fef3c7; color: #92400e; }
.ret-badge-completed { background: #d1fae5; color: #065f46; }

/* Schedule box */
.ret-schedule {
    display: inline-flex; flex-direction: column; align-items: center;
    background: #f8f9fa; border: 1px solid #e9ecef;
    border-radius: 8px; padding: 6px 12px; gap: 2px;
}
.ret-schedule-date { font-size: 13px; font-weight: 600; color: #212529; }
.ret-schedule-time { font-size: 11px; color: #6c757d; }

/* Overdue indicator */
.ret-overdue {
    display: inline-block; font-size: 10px; font-weight: 600;
    color: #991b1b; background: #fee2e2; border-radius: 99px;
    padding: 2px 7px; margin-top: 4px;
}

/* Action buttons */
.ret-btn-act {
    width: 32px; height: 32px; border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    font-size: 13px; border: 1px solid transparent;
    cursor: pointer; transition: all 0.12s; text-decoration: none;
}
.ret-btn-inspect { background: #f0fdf4; color: #15803d; border-color: #bbf7d0; }
.ret-btn-inspect:hover { background: #dcfce7; text-decoration: none; }
.ret-btn-view    { background: #eff6ff; color: #1d4ed8; border-color: #bfdbfe; }
.ret-btn-view:hover { background: #dbeafe; text-decoration: none; }

/* Alert */
.ret-alert { margin: 16px 22px 0; padding: 12px 16px; border-radius: 8px; font-size: 13px; font-weight: 500; display: flex; align-items: center; gap: 8px; }
.ret-alert-success { background: #d1fae5; color: #065f46; border: 1px solid #a7f3d0; }

/* Footer */
.ret-footer { padding: 14px 22px; border-top: 1px solid #e9ecef; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px; }
.ret-footer-info { font-size: 12px; color: #6c757d; }
.ret-footer-info strong { color: #212529; }

/* Empty */
.ret-empty { padding: 50px 20px; text-align: center; }
.ret-empty-icon { font-size: 40px; margin-bottom: 12px; opacity: 0.3; }

@media (max-width: 900px) {
    .ret-stats { grid-template-columns: repeat(3, 1fr); }
}
@media (max-width: 600px) {
    .ret-wrap  { padding: 1rem; }
    .ret-stats { grid-template-columns: repeat(1, 1fr); }
    .ret-header-card { flex-direction: column; align-items: flex-start; gap: 12px; }
}
</style>

<div class="ret-wrap">

    {{-- Header Card --}}
    <div class="ret-header-card">
        <div style="display:flex; align-items:center; gap:16px;">
            <div class="ret-header-icon">🔄</div>
            <div>
                <p class="ret-header-sub">Admin Panel · Manajemen</p>
                <h4 class="ret-header-title">Pengembalian Kendaraan</h4>
            </div>
        </div>
        <div style="font-size:12px; color:rgba(255,255,255,0.65); text-align:right;">
            Total: <strong style="color:#fff; font-size:16px;">{{ $returns->count() }}</strong> pengembalian
        </div>
    </div>

    {{-- Stat Cards --}}
    @php
        $totalCount     = $returns->count();
        $pendingCount   = $returns->where('status','return_pending')->count();
        $completedCount = $returns->where('status','!=','return_pending')->count();
    @endphp
    <div class="ret-stats">
        <div class="ret-stat">
            <div class="ret-stat-icon" style="background:#eef2ff;">📋</div>
            <div>
                <div class="ret-stat-num">{{ $totalCount }}</div>
                <div class="ret-stat-lbl">Total Pengembalian</div>
            </div>
        </div>
        <div class="ret-stat">
            <div class="ret-stat-icon" style="background:#fef3c7;">⏳</div>
            <div>
                <div class="ret-stat-num" style="color:#92400e;">{{ $pendingCount }}</div>
                <div class="ret-stat-lbl">Menunggu Inspeksi</div>
            </div>
        </div>
        <div class="ret-stat">
            <div class="ret-stat-icon" style="background:#d1fae5;">✅</div>
            <div>
                <div class="ret-stat-num" style="color:#065f46;">{{ $completedCount }}</div>
                <div class="ret-stat-lbl">Selesai</div>
            </div>
        </div>
    </div>

    {{-- Main Card --}}
    <div class="ret-card">

        {{-- Alert --}}
        @if(session('success'))
            <div class="ret-alert ret-alert-success" style="margin-bottom:0;">
                ✔ {{ session('success') }}
            </div>
        @endif

        {{-- Table --}}
        <div style="overflow-x:auto;">
            <table class="ret-table">
                <thead>
                    <tr>
                        <th>ID Pengembalian</th>
                        <th>Pelanggan</th>
                        <th>Kendaraan</th>
                        <th class="center">Jadwal Pengembalian</th>
                        <th class="center">Status</th>
                        <th class="center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($returns as $return)
                    @php
                        $scheduledDate = \Carbon\Carbon::parse($return->return_scheduled_date);
                        $isOverdue = $return->status === 'return_pending' && $scheduledDate->isPast();
                    @endphp
                    <tr>
                        {{-- ID --}}
                        <td>
                            <span class="ret-id">#{{ str_pad($return->id, 6, '0', STR_PAD_LEFT) }}</span>
                        </td>

                        {{-- Pelanggan --}}
                        <td>
                            <div style="display:flex; align-items:center; gap:10px;">
                                <div class="ret-avatar">{{ substr($return->booking->user->name, 0, 1) }}</div>
                                <div style="min-width:0;">
                                    <div style="font-size:13px; font-weight:600; color:#212529; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; max-width:130px;">
                                        {{ $return->booking->user->name }}
                                    </div>
                                    <div style="font-size:11px; color:#6c757d; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; max-width:130px;">
                                        {{ $return->booking->user->email }}
                                    </div>
                                </div>
                            </div>
                        </td>

                        {{-- Kendaraan --}}
                        <td>
                            <div style="font-size:13px; font-weight:600; color:#212529;">
                                {{ $return->booking->kendaraan->brand }} {{ $return->booking->kendaraan->model }}
                            </div>
                            <span class="ret-plate">{{ $return->booking->kendaraan->plate_number }}</span>
                        </td>

                        {{-- Jadwal --}}
                        <td class="center">
                            <div class="ret-schedule">
                                <span class="ret-schedule-date">
                                    {{ $scheduledDate->translatedFormat('d M Y') }}
                                </span>
                                <span class="ret-schedule-time">
                                    {{ \Carbon\Carbon::createFromFormat('H:i:s', $return->return_scheduled_time)->format('H:i') }} WIB
                                </span>
                            </div>
                            @if($isOverdue)
                                <div><span class="ret-overdue">⚠ Terlambat</span></div>
                            @endif
                        </td>

                        {{-- Status --}}
                        <td class="center">
                            @if($return->status === 'return_pending')
                                <span class="ret-badge ret-badge-pending">⏳ Menunggu</span>
                            @else
                                <span class="ret-badge ret-badge-completed">✔ Selesai</span>
                            @endif
                        </td>

                        {{-- Aksi --}}
                        <td class="center">
                            @if($return->status === 'return_pending')
                                <a href="{{ route('admin.returns.inspect', $return->id) }}"
                                   class="ret-btn-act ret-btn-inspect"
                                   title="Mulai Inspeksi" style="margin: 0 auto;">
                                   📋
                                </a>
                            @else
                                <a href="{{ route('admin.returns.show', $return->id) }}"
                                   class="ret-btn-act ret-btn-view"
                                   title="Lihat Detail" style="margin: 0 auto;">
                                   👁
                                </a>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">
                            <div class="ret-empty">
                                <div class="ret-empty-icon">📭</div>
                                <p style="font-size:14px; color:#6c757d; margin:0;">Belum ada data pengembalian kendaraan</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        {{-- Footer --}}
        <div class="ret-footer">
            <div class="ret-footer-info">
                Total <strong>{{ $returns->count() }}</strong> pengembalian &nbsp;·&nbsp;
                <span style="color:#92400e; font-weight:600;">{{ $pendingCount }} menunggu inspeksi</span>
            </div>
            @if(method_exists($returns, 'links'))
                <div>{{ $returns->links() }}</div>
            @endif
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
@if(session('success'))
    setTimeout(function() {
        const alert = document.querySelector('.ret-alert');
        if (alert) {
            alert.style.transition = 'opacity 0.5s';
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 500);
        }
    }, 4000);
@endif
</script>
@endpush