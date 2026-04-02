@extends('layouts.admin')

@section('content')
<style>
* { box-sizing: border-box; }
.rv-page { padding: 1.5rem 2rem 2rem 2rem; font-family: inherit; max-width: 1200px; }
.rv-grid { display: grid; grid-template-columns: 1fr 340px; gap: 20px; }
.rv-col { display: flex; flex-direction: column; gap: 16px; }
.rv-card { background: #fff; border: 1px solid #e9ecef; border-radius: 12px; overflow: hidden; }
.rv-label { font-size: 12px; color: #6c757d; margin-bottom: 3px; }
.rv-val { font-size: 14px; color: #212529; font-weight: 500; }
.rv-badge { display: inline-flex; align-items: center; gap: 5px; padding: 4px 12px; border-radius: 99px; font-size: 12px; font-weight: 500; }
.rv-badge-success { background: #d1f5e0; color: #0a6640; }
.rv-badge-warning { background: #fff3cd; color: #856404; }
.rv-badge-danger  { background: #fde8e8; color: #991b1b; }
.rv-divider { border: none; border-top: 1px solid #e9ecef; margin: 12px 0; }
.rv-stat { background: #f8f9fa; border-radius: 8px; padding: 12px 16px; text-align: center; }
.rv-stat .num { font-size: 18px; font-weight: 600; color: #212529; }
.rv-row-3 { display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px; }
.rv-row-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
.rv-avatar { width: 44px; height: 44px; border-radius: 50%; background: #dbeafe; display: flex; align-items: center; justify-content: center; font-weight: 600; font-size: 16px; color: #1d4ed8; flex-shrink: 0; }
.rv-info-row { display: flex; align-items: flex-start; gap: 10px; margin-bottom: 12px; }
.rv-icon-box { width: 32px; height: 32px; border-radius: 8px; background: #f8f9fa; border: 1px solid #e9ecef; display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-size: 13px; }
.rv-star-on  { color: #f0a500; font-size: 20px; }
.rv-star-off { color: #dee2e6; font-size: 20px; }
.rv-car-thumb { width: 100%; height: 140px; background: #f1f3f5; display: flex; align-items: center; justify-content: center; border-bottom: 1px solid #e9ecef; font-size: 48px; }
.rv-section-title { font-size: 11px; font-weight: 600; color: #6c757d; text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: 14px; }
.rv-quote { background: #f8f9fa; border-left: 3px solid #185FA5; border-radius: 0 8px 8px 0; padding: 14px 16px; font-size: 14px; line-height: 1.75; color: #212529; font-style: italic; }
.rv-quote-green { background: #f0fdf4; border-left: 3px solid #16a34a; border-radius: 0 8px 8px 0; padding: 14px 16px; font-size: 13px; line-height: 1.7; color: #212529; }
.rv-meta-pill { display: inline-flex; align-items: center; gap: 5px; font-size: 12px; color: #6c757d; background: #f8f9fa; border: 1px solid #e9ecef; border-radius: 99px; padding: 4px 10px; }
.rv-plate { background: #f8f9fa; border: 1px solid #dee2e6; border-radius: 6px; padding: 3px 10px; font-size: 13px; font-weight: 600; font-family: monospace; letter-spacing: 0.1em; color: #212529; display: inline-block; }
.rv-tag { background: #f1f3f5; border: 1px solid #e9ecef; border-radius: 99px; padding: 3px 10px; font-size: 12px; color: #6c757d; display: inline-block; }
.rv-header { display: flex; justify-content: space-between; align-items: flex-start; padding-bottom: 18px; border-bottom: 1px solid #e9ecef; margin-bottom: 20px; }
.rv-btn-back { display: inline-flex; align-items: center; gap: 6px; padding: 8px 16px; border-radius: 8px; border: 1px solid #dee2e6; background: #fff; color: #495057; font-size: 13px; cursor: pointer; text-decoration: none; transition: background 0.15s; }
.rv-btn-back:hover { background: #f8f9fa; color: #212529; text-decoration: none; }
.rv-btn-primary { width: 100%; padding: 10px; border-radius: 8px; background: #185FA5; color: #fff; border: none; font-size: 14px; font-weight: 500; cursor: pointer; transition: background 0.15s; }
.rv-btn-primary:hover { background: #0C447C; }
.rv-btn-danger { width: 100%; padding: 10px; border-radius: 8px; background: #fde8e8; color: #991b1b; border: 1px solid #fca5a5; font-size: 14px; font-weight: 500; cursor: pointer; margin-top: 8px; transition: background 0.15s; }
.rv-btn-danger:hover { background: #fee2e2; }
.rv-select { width: 100%; padding: 9px 12px; border-radius: 8px; border: 1px solid #dee2e6; background: #fff; color: #212529; font-size: 14px; outline: none; margin-bottom: 14px; }
.rv-select:focus { border-color: #185FA5; box-shadow: 0 0 0 3px rgba(24,95,165,0.1); }
.rv-card-header { padding: 14px 20px; border-bottom: 1px solid #e9ecef; font-size: 14px; font-weight: 600; color: #212529; display: flex; align-items: center; gap: 8px; }
.rv-admin-avatar { width: 28px; height: 28px; border-radius: 50%; background: #f1f3f5; border: 1px solid #dee2e6; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 600; color: #6c757d; }
@media (max-width: 768px) {
    .rv-grid  { grid-template-columns: 1fr; }
    .rv-row-2 { grid-template-columns: 1fr; }
    .rv-row-3 { grid-template-columns: 1fr 1fr; }
}
</style>

<div class="rv-page">

    {{-- Page Header --}}
    {{-- Page Header Card --}}
    <div class="rv-card" style="margin-bottom: 20px; background: linear-gradient(135deg, #4f5fd5 0%, #6366f1 100%); border: none;">
        <div style="padding: 20px 28px; display: flex; justify-content: space-between; align-items: center;">
            <div style="display: flex; align-items: center; gap: 16px;">
                <div style="width: 46px; height: 46px; border-radius: 10px; background: rgba(255,255,255,0.15); display: flex; align-items: center; justify-content: center; font-size: 20px;">⭐</div>
                <div>
                    <p style="font-size: 12px; color: rgba(255,255,255,0.7); margin: 0 0 4px 0; letter-spacing: 0.04em;">
                        Review #{{ str_pad($review->id, 4, '0', STR_PAD_LEFT) }} &nbsp;·&nbsp; {{ $review->created_at->format('d M Y, H:i') }}
                    </p>
                    <h4 style="font-size: 20px; font-weight: 600; color: #fff; margin: 0;">Review details</h4>
                </div>
            </div>
            <a href="{{ route('admin.reviews.index') }}" class="rv-btn-back" style="background: rgba(255,255,255,0.15); border-color: rgba(255,255,255,0.3); color: #fff;">← Back</a>
        </div>
    </div>

    <div class="rv-grid">

        {{-- LEFT COLUMN --}}
        <div class="rv-col">

            {{-- Review Content --}}
            <div class="rv-card">
                <div style="padding: 20px 24px; border-bottom: 1px solid #e9ecef; display: flex; justify-content: space-between; align-items: flex-start;">
                    <div>
                        <div style="display: flex; gap: 3px; margin-bottom: 8px;">
                            @for($i = 1; $i <= 5; $i++)
                                <span class="{{ $i <= $review->rating ? 'rv-star-on' : 'rv-star-off' }}">★</span>
                            @endfor
                        </div>
                        <div style="display: flex; align-items: baseline; gap: 6px;">
                            <span style="font-size: 32px; font-weight: 700; color: #212529;">{{ $review->rating }}.0</span>
                            <span style="font-size: 13px; color: #6c757d;">out of 5</span>
                        </div>
                    </div>
                    @php
                        $badgeClass = $review->status == 'published' ? 'rv-badge-success' : ($review->status == 'pending' ? 'rv-badge-warning' : 'rv-badge-danger');
                        $dot = $review->status == 'published' ? '●' : ($review->status == 'pending' ? '◌' : '✕');
                    @endphp
                    <span class="rv-badge {{ $badgeClass }}">{{ $dot }} {{ ucfirst($review->status) }}</span>
                </div>
                <div style="padding: 20px 24px;">
                    <p class="rv-section-title">Customer's review</p>
                    <div class="rv-quote">
                        "{{ $review->comment }}"
                    </div>
                    <div style="display: flex; gap: 8px; margin-top: 14px; flex-wrap: wrap;">
                        <span class="rv-meta-pill">🕐 {{ $review->created_at->diffForHumans() }}</span>
                        <span class="rv-meta-pill">📅 {{ $review->created_at->format('l, d F Y') }}</span>
                    </div>
                </div>
            </div>

            {{-- Customer & Vehicle --}}
            <div class="rv-row-2">

                {{-- Customer --}}
                <div class="rv-card">
                    <div style="padding: 18px 20px;">
                        <p class="rv-section-title">Customer</p>
                        <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 14px;">
                            <div class="rv-avatar">{{ substr($review->user->name, 0, 1) }}</div>
                            <div>
                                <p class="rv-val">{{ $review->user->name }}</p>
                                <span class="rv-tag">Customer</span>
                            </div>
                        </div>
                        <hr class="rv-divider">
                        <div class="rv-info-row">
                            <div class="rv-icon-box">✉</div>
                            <div>
                                <p class="rv-label">Email</p>
                                <p class="rv-val" style="font-size: 13px;">{{ $review->user->email }}</p>
                            </div>
                        </div>
                        <div class="rv-info-row">
                            <div class="rv-icon-box">📞</div>
                            <div>
                                <p class="rv-label">Phone</p>
                                <p class="rv-val" style="font-size: 13px;">{{ $review->user->phone ?? 'Not provided' }}</p>
                            </div>
                        </div>
                        <div class="rv-info-row" style="margin-bottom: 0;">
                            <div class="rv-icon-box">📆</div>
                            <div>
                                <p class="rv-label">Member since</p>
                                <p class="rv-val" style="font-size: 13px;">{{ $review->user->created_at->format('d M Y') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Vehicle --}}
                <div class="rv-card">
                    <div class="rv-car-thumb">
                        @php
                            $primaryImage = $review->kendaraan->images->where('is_primary', 1)->first();
                        @endphp
                        @if($primaryImage)
                            <img src="{{ asset('storage/' . $primaryImage->image_path) }}"
                                 alt="{{ $review->kendaraan->brand }}"
                                 style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            🚗
                        @endif
                    </div>
                    <div style="padding: 16px 18px;">
                        <p style="font-size: 15px; font-weight: 600; color: #212529; margin-bottom: 12px;">
                            {{ $review->kendaraan->brand }} {{ $review->kendaraan->model }}
                        </p>
                        <div class="rv-row-2" style="gap: 8px; margin-bottom: 12px;">
                            <div>
                                <p class="rv-label">Year</p>
                                <p class="rv-val">{{ $review->kendaraan->year }}</p>
                            </div>
                            <div>
                                <p class="rv-label">Type</p>
                                <p class="rv-val">{{ ucfirst($review->kendaraan->type) }}</p>
                            </div>
                        </div>
                        <div>
                            <p class="rv-label" style="margin-bottom: 5px;">Plate number</p>
                            <span class="rv-plate">{{ $review->kendaraan->plate_number }}</span>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Booking Information --}}
            <div class="rv-card">
                <div style="padding: 18px 22px;">
                    <p class="rv-section-title">Booking information</p>
                    <div class="rv-row-3" style="margin-bottom: 16px;">
                        <div class="rv-stat">
                            <p class="rv-label">Booking ID</p>
                            <p class="num">#{{ str_pad($review->booking->id, 6, '0', STR_PAD_LEFT) }}</p>
                        </div>
                        <div class="rv-stat">
                            <p class="rv-label">Duration</p>
                            <p class="num">{{ $review->booking->total_days }} days</p>
                        </div>
                        <div class="rv-stat">
                            <p class="rv-label">Total price</p>
                            <p class="num" style="font-size: 15px; color: #0a6640;">Rp {{ number_format($review->booking->total_price, 0, ',', '.') }}</p>
                        </div>
                    </div>
                    <hr class="rv-divider">
                    <div class="rv-row-2">
                        <div>
                            <p class="rv-label">Start date</p>
                            <p class="rv-val">{{ \Carbon\Carbon::parse($review->booking->start_date)->format('d M Y') }}</p>
                        </div>
                        <div>
                            <p class="rv-label">End date</p>
                            <p class="rv-val">{{ \Carbon\Carbon::parse($review->booking->end_date)->format('d M Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        {{-- RIGHT COLUMN --}}
        <div class="rv-col">

            {{-- Manage Review --}}
            <div class="rv-card">
                <div class="rv-card-header">⚙ Manage review</div>
                <div style="padding: 18px 20px;">
                    <form action="{{ route('admin.reviews.updateStatus', $review->id) }}" method="POST" id="statusForm">
                        @csrf
                        @method('PUT')
                        <p class="rv-label" style="margin-bottom: 8px;">Change status</p>
                        <select name="status" class="rv-select">
                            <option value="pending"   {{ $review->status == 'pending'   ? 'selected' : '' }}>⏳ Pending review</option>
                            <option value="published" {{ $review->status == 'published' ? 'selected' : '' }}>✅ Published</option>
                            <option value="rejected"  {{ $review->status == 'rejected'  ? 'selected' : '' }}>❌ Rejected</option>
                        </select>
                        <button type="submit" class="rv-btn-primary">Update review</button>
                    </form>
                    <button type="button" class="rv-btn-danger" onclick="confirmDelete()">Delete review</button>
                    <form id="deleteForm" action="{{ route('admin.reviews.destroy', $review->id) }}" method="POST" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
            </div>

            {{-- Admin Response --}}
            @if($review->admin_response && $review->respondedBy)
            <div class="rv-card">
                <div class="rv-card-header">
                    ↩ Admin response
                    <span class="rv-badge rv-badge-success" style="font-size: 11px; padding: 2px 8px; margin-left: auto;">Responded</span>
                </div>
                <div style="padding: 18px 20px;">
                    <div class="rv-quote-green" style="margin-bottom: 12px;">
                        {{ $review->admin_response }}
                    </div>
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <div class="rv-admin-avatar">{{ substr($review->respondedBy->name, 0, 1) }}</div>
                            <p style="font-size: 12px; color: #6c757d; margin: 0;">{{ $review->respondedBy->name }}</p>
                        </div>
                        <p style="font-size: 12px; color: #6c757d; margin: 0;">{{ $review->responded_at->format('d M Y') }}</p>
                    </div>
                </div>
            </div>
            @endif

        </div>

    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function confirmDelete() {
    Swal.fire({
        title: 'Delete this review?',
        html: '<p style="color:#6c757d;font-size:14px;">This action cannot be undone. The review will be permanently removed.</p>',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, delete it',
        cancelButtonText: 'Cancel',
        reverseButtons: true,
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('deleteForm').submit();
        }
    });
}

document.getElementById('statusForm').addEventListener('submit', function() {
    Swal.fire({
        title: 'Updating...',
        text: 'Please wait',
        allowOutsideClick: false,
        didOpen: () => { Swal.showLoading(); }
    });
});
</script>
@endpush