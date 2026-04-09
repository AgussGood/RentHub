<!-- SIDENAV -->
<aside class="kd-sidenav">

<style>
.kd-sidenav {
    position: fixed;
    top: 16px;
    left: 16px;
    bottom: 16px;
    width: 250px;
    background: #ffffff;
    border-radius: 16px;
    border: 1px solid #e9ecef;
    box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    display: flex;
    flex-direction: column;
    overflow: hidden;
}

/* HEADER */
.kd-sidenav-header {
    padding: 18px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.kd-logo {
    width: 38px;
    height: 38px;
    border-radius: 10px;
    background: linear-gradient(135deg,#6366f1,#818cf8);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
}

/* SECTION */
.kd-section {
    font-size: 10px;
    font-weight: 700;
    color: #94a3b8;
    text-transform: uppercase;
    padding: 12px 18px 6px;
}

/* MENU */
.kd-menu {
    padding: 6px;
}

.kd-link {
    display: flex;
    align-items: center;
    padding: 10px 12px;
    border-radius: 10px;
    font-size: 13px;
    text-decoration: none;
    color: #64748b;
    transition: all .2s;
}

.kd-link:hover {
    background: #f8fafc;
    color: #1e293b;
}

.kd-link.active {
    background: #eef2ff;
    color: #4f46e5;
    font-weight: 600;
}

/* ICON */
.kd-icon {
    width: 34px;
    height: 34px;
    border-radius: 8px;
    background: #f1f5f9;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 10px;
    transition: all .2s;
}

.kd-link.active .kd-icon {
    background: #6366f1;
    color: #fff;
}

/* BADGE */
.kd-badge {
    margin-left: auto;
    font-size: 10px;
    padding: 2px 7px;
    border-radius: 999px;
    font-weight: 700;
}

/* DIVIDER */
.kd-divider {
    border-top: 1px solid #f1f5f9;
    margin: 6px 12px;
}

/* SCROLL */
.kd-scroll {
    overflow-y: auto;
    padding-bottom: 10px;
}
</style>

@php
    $isDashboard = request()->routeIs('home');
    $isKendaraan = request()->routeIs('admin.kendaraan.*');
    $isBookings  = request()->routeIs('admin.bookings.*');
    $isReturns   = request()->routeIs('admin.returns.*');
    $isReviews   = request()->routeIs('admin.reviews.*');

    try {
        $pendingReturns = \App\Models\ReturnKendaraan::where('status','return_pending')->count();
    } catch(\Exception $e) { $pendingReturns = 0; }

    try {
        $pendingReviews = \App\Models\Review::where('status','pending')->count();
    } catch(\Exception $e) { $pendingReviews = 0; }
@endphp

{{-- HEADER --}}
<div class="kd-sidenav-header">
    <div class="kd-logo">🚗</div>
    <div>
        <div style="font-weight:700;">RentCar</div>
        <div style="font-size:11px;color:#94a3b8;">Admin Panel</div>
    </div>
</div>

<div class="kd-divider"></div>

<div class="kd-scroll">

    <div class="kd-section">Menu Utama</div>

    <div class="kd-menu">
        <a href="{{ route('home') }}" class="kd-link {{ $isDashboard ? 'active' : '' }}">
            <div class="kd-icon">🏠</div>
            Dashboard
        </a>
    </div>

    <div class="kd-divider"></div>

    <div class="kd-section">Operasional</div>

    <div class="kd-menu">

        <a href="{{ route('admin.kendaraan.index') }}" class="kd-link {{ $isKendaraan ? 'active' : '' }}">
            <div class="kd-icon">🚗</div>
            Kendaraan
        </a>

        <a href="{{ route('admin.bookings.index') }}" class="kd-link {{ $isBookings ? 'active' : '' }}">
            <div class="kd-icon">📅</div>
            Booking
        </a>        

        <a href="{{ route('admin.returns.index') }}" class="kd-link {{ $isReturns ? 'active' : '' }}">
            <div class="kd-icon">🔄</div>
            Pengembalian

            @if($pendingReturns > 0)
                <span class="kd-badge" style="background:#fef3c7;color:#92400e;">
                    {{ $pendingReturns }}
                </span>
            @endif
        </a>

        <a href="{{ route('admin.reviews.index') }}" class="kd-link {{ $isReviews ? 'active' : '' }}">
            <div class="kd-icon">⭐</div>
            Review

            @if($pendingReviews > 0)
                <span class="kd-badge" style="background:#fee2e2;color:#991b1b;">
                    {{ $pendingReviews }}
                </span>
            @endif
        </a>

    </div>

</div>

</aside>