@extends('layouts.admin')

@section('content')
<style>
* { box-sizing: border-box; }

.ri-wrap { padding: 1.5rem 2rem 2rem 2rem; font-family: inherit; max-width: 1200px; }

/* Header Card */
.ri-header-card {
    background: linear-gradient(135deg, #4f5fd5 0%, #6366f1 100%);
    border-radius: 14px;
    padding: 22px 28px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}
.ri-header-icon {
    width: 46px; height: 46px;
    background: rgba(255,255,255,0.15);
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    font-size: 20px; flex-shrink: 0;
}
.ri-header-title { font-size: 20px; font-weight: 600; color: #fff; margin: 0; }
.ri-header-sub   { font-size: 12px; color: rgba(255,255,255,0.65); margin: 3px 0 0; }

/* Stat cards */
.ri-stats { display: grid; grid-template-columns: repeat(4, 1fr); gap: 12px; margin-bottom: 20px; }
.ri-stat {
    background: #fff;
    border: 1px solid #e9ecef;
    border-radius: 12px;
    padding: 16px 18px;
    display: flex; align-items: center; gap: 14px;
}
.ri-stat-icon {
    width: 42px; height: 42px; border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    font-size: 18px; flex-shrink: 0;
}
.ri-stat-num  { font-size: 22px; font-weight: 700; color: #212529; line-height: 1; }
.ri-stat-lbl  { font-size: 11px; color: #6c757d; margin-top: 3px; }

/* Main card */
.ri-card {
    background: #fff;
    border: 1px solid #e9ecef;
    border-radius: 14px;
    overflow: hidden;
}

/* Filter bar */
.ri-filter { padding: 18px 22px; border-bottom: 1px solid #e9ecef; display: flex; gap: 10px; flex-wrap: wrap; align-items: flex-end; }
.ri-filter-group { display: flex; flex-direction: column; gap: 5px; }
.ri-filter-group label { font-size: 11px; font-weight: 600; color: #6c757d; text-transform: uppercase; letter-spacing: 0.05em; }
.ri-filter select,
.ri-filter input[type="text"] {
    padding: 8px 12px;
    font-size: 13px;
    border: 1px solid #dee2e6;
    border-radius: 8px;
    background: #fff;
    color: #212529;
    outline: none;
    height: 36px;
}
.ri-filter select:focus,
.ri-filter input[type="text"]:focus { border-color: #6366f1; box-shadow: 0 0 0 3px rgba(99,102,241,0.1); }
.ri-filter input[type="text"] { width: 220px; }
.ri-btn-search {
    height: 36px; padding: 0 16px;
    background: #6366f1; color: #fff;
    border: none; border-radius: 8px;
    font-size: 13px; font-weight: 500;
    cursor: pointer; display: flex; align-items: center; gap: 6px;
}
.ri-btn-search:hover { background: #4f46e5; }
.ri-btn-reset {
    height: 36px; padding: 0 14px;
    background: #f8f9fa; color: #6c757d;
    border: 1px solid #dee2e6; border-radius: 8px;
    font-size: 13px; cursor: pointer; text-decoration: none;
    display: flex; align-items: center; gap: 6px;
}
.ri-btn-reset:hover { background: #e9ecef; color: #495057; text-decoration: none; }

/* Table */
.ri-table { width: 100%; border-collapse: collapse; }
.ri-table thead tr { background: #f8f9fa; }
.ri-table thead th {
    padding: 11px 16px;
    font-size: 11px; font-weight: 700;
    color: #6c757d;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    text-align: left;
    border-bottom: 1px solid #e9ecef;
    white-space: nowrap;
}
.ri-table thead th.center { text-align: center; }
.ri-table tbody tr { border-bottom: 1px solid #f1f3f5; transition: background 0.12s; }
.ri-table tbody tr:last-child { border-bottom: none; }
.ri-table tbody tr:hover { background: #f8f9ff; }
.ri-table td { padding: 13px 16px; vertical-align: middle; }
.ri-table td.center { text-align: center; }

/* Avatar */
.ri-avatar {
    width: 36px; height: 36px; border-radius: 50%;
    background: linear-gradient(135deg, #6366f1, #818cf8);
    display: flex; align-items: center; justify-content: center;
    font-weight: 700; font-size: 13px; color: #fff; flex-shrink: 0;
}
/* Car thumb */
.ri-car-thumb {
    width: 44px; height: 36px; border-radius: 7px;
    object-fit: cover; flex-shrink: 0;
    border: 1px solid #e9ecef;
}
.ri-car-fallback {
    width: 44px; height: 36px; border-radius: 7px;
    background: #f1f3f5; border: 1px solid #e9ecef;
    display: flex; align-items: center; justify-content: center;
    font-size: 16px; flex-shrink: 0;
}

/* Stars */
.ri-stars { display: flex; gap: 2px; }
.ri-star-on  { color: #f0a500; font-size: 12px; }
.ri-star-off { color: #dee2e6; font-size: 12px; }

/* Badges */
.ri-badge { display: inline-flex; align-items: center; gap: 4px; padding: 4px 10px; border-radius: 99px; font-size: 11px; font-weight: 600; white-space: nowrap; }
.ri-badge-published { background: #d1fae5; color: #065f46; }
.ri-badge-pending   { background: #fef3c7; color: #92400e; }
.ri-badge-rejected  { background: #fee2e2; color: #991b1b; }

/* Action buttons */
.ri-actions { display: flex; align-items: center; justify-content: center; gap: 6px; }
.ri-btn-act {
    width: 32px; height: 32px; border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    font-size: 12px; border: 1px solid transparent;
    cursor: pointer; transition: all 0.12s; text-decoration: none;
}
.ri-btn-view    { background: #eff6ff; color: #1d4ed8; border-color: #bfdbfe; }
.ri-btn-view:hover { background: #dbeafe; }
.ri-btn-publish { background: #f0fdf4; color: #15803d; border-color: #bbf7d0; }
.ri-btn-publish:hover { background: #dcfce7; }
.ri-btn-del     { background: #fff1f2; color: #be123c; border-color: #fecdd3; }
.ri-btn-del:hover { background: #ffe4e6; }

/* Empty */
.ri-empty { padding: 50px 20px; text-align: center; }
.ri-empty-icon { font-size: 40px; margin-bottom: 12px; opacity: 0.3; }

/* Footer */
.ri-footer { padding: 14px 22px; border-top: 1px solid #e9ecef; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px; }
.ri-footer-info { font-size: 12px; color: #6c757d; }
.ri-footer-info strong { color: #212529; }

/* Alert */
.ri-alert { margin: 0 22px 16px; padding: 12px 16px; border-radius: 8px; font-size: 13px; font-weight: 500; display: flex; align-items: center; gap: 8px; }
.ri-alert-success { background: #d1fae5; color: #065f46; border: 1px solid #a7f3d0; }
.ri-alert-error   { background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }

/* ID pill */
.ri-id { font-size: 12px; font-weight: 600; color: #6366f1; background: #eef2ff; border-radius: 6px; padding: 3px 8px; font-family: monospace; }

@media (max-width: 900px) {
    .ri-stats { grid-template-columns: repeat(2, 1fr); }
    .ri-filter input[type="text"] { width: 160px; }
}
@media (max-width: 600px) {
    .ri-wrap { padding: 1rem; }
    .ri-stats { grid-template-columns: repeat(2, 1fr); }
    .ri-header-card { flex-direction: column; align-items: flex-start; gap: 12px; }
}
</style>

<div class="ri-wrap">

    {{-- Header Card --}}
    <div class="ri-header-card">
        <div style="display:flex; align-items:center; gap:16px;">
            <div class="ri-header-icon">⭐</div>
            <div>
                <p class="ri-header-sub">Admin Panel · Manajemen</p>
                <h4 class="ri-header-title">Manajemen Review</h4>
            </div>
        </div>
        <div style="font-size:12px; color:rgba(255,255,255,0.65); text-align:right;">
            Total: <strong style="color:#fff; font-size:16px;">{{ $reviews->total() }}</strong> review
        </div>
    </div>

    {{-- Stat Cards --}}
    <div class="ri-stats">
        @php
            $allTotal       = $reviews->total();
            $publishedCount = \App\Models\Review::where('status','published')->count();
            $pendingCount   = \App\Models\Review::where('status','pending')->count();
            $rejectedCount  = \App\Models\Review::where('status','rejected')->count();
        @endphp
        <div class="ri-stat">
            <div class="ri-stat-icon" style="background:#eef2ff;">📋</div>
            <div>
                <div class="ri-stat-num">{{ $allTotal }}</div>
                <div class="ri-stat-lbl">Total Review</div>
            </div>
        </div>
        <div class="ri-stat">
            <div class="ri-stat-icon" style="background:#d1fae5;">✅</div>
            <div>
                <div class="ri-stat-num" style="color:#065f46;">{{ $publishedCount }}</div>
                <div class="ri-stat-lbl">Published</div>
            </div>
        </div>
        <div class="ri-stat">
            <div class="ri-stat-icon" style="background:#fef3c7;">⏳</div>
            <div>
                <div class="ri-stat-num" style="color:#92400e;">{{ $pendingCount }}</div>
                <div class="ri-stat-lbl">Pending</div>
            </div>
        </div>
        <div class="ri-stat">
            <div class="ri-stat-icon" style="background:#fee2e2;">❌</div>
            <div>
                <div class="ri-stat-num" style="color:#991b1b;">{{ $rejectedCount }}</div>
                <div class="ri-stat-lbl">Rejected</div>
            </div>
        </div>
    </div>

    {{-- Main Table Card --}}
    <div class="ri-card">

        {{-- Alerts --}}
        @if(session('success'))
        <div style="padding: 16px 22px 0;">
            <div class="ri-alert ri-alert-success">✔ {{ session('success') }}</div>
        </div>
        @endif
        @if(session('error'))
        <div style="padding: 16px 22px 0;">
            <div class="ri-alert ri-alert-error">✖ {{ session('error') }}</div>
        </div>
        @endif

        {{-- Filter Bar --}}
        <form method="GET" action="{{ route('admin.reviews.index') }}">
            <div class="ri-filter">
                <div class="ri-filter-group">
                    <label>Status</label>
                    <select name="status" onchange="this.form.submit()">
                        <option value="all"       {{ request('status','all') == 'all'       ? 'selected' : '' }}>Semua Status</option>
                        <option value="pending"   {{ request('status') == 'pending'         ? 'selected' : '' }}>⏳ Pending</option>
                        <option value="published" {{ request('status') == 'published'       ? 'selected' : '' }}>✅ Published</option>
                        <option value="rejected"  {{ request('status') == 'rejected'        ? 'selected' : '' }}>❌ Rejected</option>
                    </select>
                </div>
                <div class="ri-filter-group">
                    <label>Rating</label>
                    <select name="rating" onchange="this.form.submit()">
                        <option value="all" {{ request('rating','all') == 'all' ? 'selected' : '' }}>Semua Rating</option>
                        <option value="5"   {{ request('rating') == '5' ? 'selected' : '' }}>★★★★★ 5</option>
                        <option value="4"   {{ request('rating') == '4' ? 'selected' : '' }}>★★★★☆ 4</option>
                        <option value="3"   {{ request('rating') == '3' ? 'selected' : '' }}>★★★☆☆ 3</option>
                        <option value="2"   {{ request('rating') == '2' ? 'selected' : '' }}>★★☆☆☆ 2</option>
                        <option value="1"   {{ request('rating') == '1' ? 'selected' : '' }}>★☆☆☆☆ 1</option>
                    </select>
                </div>
                <div class="ri-filter-group" style="flex:1; min-width:200px;">
                    <label>Cari</label>
                    <div style="display:flex; gap:6px;">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari customer, kendaraan...">
                        <button type="submit" class="ri-btn-search">
                            <i class="fas fa-search" style="font-size:12px;"></i> Cari
                        </button>
                        @if(request('search') || (request('status') && request('status') != 'all') || (request('rating') && request('rating') != 'all'))
                            <a href="{{ route('admin.reviews.index') }}" class="ri-btn-reset">
                                <i class="fas fa-times" style="font-size:11px;"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </form>

        {{-- Table --}}
        <div style="overflow-x: auto;">
            <table class="ri-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Customer</th>
                        <th>Kendaraan</th>
                        <th class="center">Rating</th>
                        <th>Komentar</th>
                        <th class="center">Status</th>
                        <th class="center">Tanggal</th>
                        <th class="center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($reviews as $review)
                    <tr>
                        {{-- ID --}}
                        <td>
                            <span class="ri-id">#{{ str_pad($review->id, 4, '0', STR_PAD_LEFT) }}</span>
                        </td>

                        {{-- Customer --}}
                        <td>
                            <div style="display:flex; align-items:center; gap:10px;">
                                <div class="ri-avatar">{{ substr($review->user->name, 0, 1) }}</div>
                                <div style="min-width:0;">
                                    <div style="font-size:13px; font-weight:600; color:#212529; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; max-width:120px;">{{ $review->user->name }}</div>
                                    <div style="font-size:11px; color:#6c757d; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; max-width:120px;">{{ $review->user->email }}</div>
                                </div>
                            </div>
                        </td>

                        {{-- Kendaraan --}}
                        <td>
                            <div style="display:flex; align-items:center; gap:10px;">
                                @if($review->kendaraan->images->first())
                                    <img src="{{ Storage::url($review->kendaraan->images->first()->image_path) }}"
                                         alt="{{ $review->kendaraan->brand }}"
                                         class="ri-car-thumb">
                                @else
                                    <div class="ri-car-fallback">🚗</div>
                                @endif
                                <div style="min-width:0;">
                                    <div style="font-size:13px; font-weight:600; color:#212529; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; max-width:110px;">
                                        {{ $review->kendaraan->brand }} {{ $review->kendaraan->model }}
                                    </div>
                                    <div style="font-size:11px; color:#6c757d;">{{ $review->kendaraan->year }}</div>
                                </div>
                            </div>
                        </td>

                        {{-- Rating --}}
                        <td class="center">
                            <div class="ri-stars" style="justify-content:center; margin-bottom:3px;">
                                @for($i = 1; $i <= 5; $i++)
                                    <span class="{{ $i <= $review->rating ? 'ri-star-on' : 'ri-star-off' }}">★</span>
                                @endfor
                            </div>
                            <div style="font-size:11px; font-weight:600; color:#6c757d;">{{ $review->rating }}/5</div>
                        </td>

                        {{-- Komentar --}}
                        <td style="max-width:200px;">
                            <p style="font-size:13px; color:#495057; margin:0; overflow:hidden; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; line-height:1.5;">
                                {{ Str::limit($review->comment, 80) }}
                            </p>
                        </td>

                        {{-- Status --}}
                        <td class="center">
                            @if($review->status == 'published')
                                <span class="ri-badge ri-badge-published">✔ Published</span>
                            @elseif($review->status == 'pending')
                                <span class="ri-badge ri-badge-pending">⏳ Pending</span>
                            @else
                                <span class="ri-badge ri-badge-rejected">✖ Rejected</span>
                            @endif
                        </td>

                        {{-- Tanggal --}}
                        <td class="center" style="white-space:nowrap;">
                            <div style="font-size:13px; font-weight:500; color:#212529;">{{ $review->created_at->format('d M Y') }}</div>
                            <div style="font-size:11px; color:#6c757d;">{{ $review->created_at->format('H:i') }}</div>
                        </td>

                        {{-- Aksi --}}
                        <td>
                            <div class="ri-actions">
                                {{-- Publish --}}
                                @if($review->status != 'published')
                                    <form action="{{ route('admin.reviews.updateStatus', $review->id) }}"
                                          method="POST"
                                          id="publishForm{{ $review->id }}"
                                          style="display:inline;">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="published">
                                        <button type="button"
                                                onclick="quickPublish({{ $review->id }})"
                                                class="ri-btn-act ri-btn-publish"
                                                title="Publish">✔</button>
                                    </form>
                                @endif

                                {{-- View --}}
                                <a href="{{ route('admin.reviews.show', $review->id) }}"
                                   class="ri-btn-act ri-btn-view"
                                   title="Lihat Detail">👁</a>

                                {{-- Delete --}}
                                <button type="button"
                                        onclick="confirmDelete({{ $review->id }})"
                                        class="ri-btn-act ri-btn-del"
                                        title="Hapus">🗑</button>

                                <form id="deleteForm{{ $review->id }}"
                                      action="{{ route('admin.reviews.destroy', $review->id) }}"
                                      method="POST"
                                      style="display:none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8">
                            <div class="ri-empty">
                                <div class="ri-empty-icon">📭</div>
                                <p style="font-size:14px; color:#6c757d; margin:0;">Tidak ada review ditemukan</p>
                                @if(request('search') || request('status') || request('rating'))
                                    <a href="{{ route('admin.reviews.index') }}" style="font-size:13px; color:#6366f1; margin-top:8px; display:inline-block;">Hapus filter</a>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        {{-- Footer --}}
        <div class="ri-footer">
            <div class="ri-footer-info">
                Menampilkan <strong>{{ $reviews->firstItem() ?? 0 }}–{{ $reviews->lastItem() ?? 0 }}</strong>
                dari <strong>{{ $reviews->total() }}</strong> review
            </div>
            <div>
                {{ $reviews->appends(request()->query())->links() }}
            </div>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function quickPublish(reviewId) {
    Swal.fire({
        title: 'Publish Review?',
        text: 'Review akan langsung dipublikasikan dan terlihat oleh customer.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#6366f1',
        cancelButtonColor: '#6b7280',
        confirmButtonText: '✔ Ya, Publish',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('publishForm' + reviewId).submit();
        }
    });
}

function confirmDelete(reviewId) {
    Swal.fire({
        title: 'Hapus Review?',
        text: 'Tindakan ini tidak dapat dibatalkan!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#6b7280',
        confirmButtonText: '🗑 Ya, Hapus',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('deleteForm' + reviewId).submit();
        }
    });
}

@if(session('success') || session('error'))
    setTimeout(function() {
        document.querySelectorAll('.ri-alert').forEach(el => {
            el.style.transition = 'opacity 0.5s';
            el.style.opacity = '0';
            setTimeout(() => el.closest('div').remove(), 500);
        });
    }, 4000);
@endif
</script>
@endpush