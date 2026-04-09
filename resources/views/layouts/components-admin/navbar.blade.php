{{-- resources/views/components/navbar-admin.blade.php --}}
<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700&display=swap');

.adm-nav {
    position: sticky;
    top: 12px;
    z-index: 100;
    display: flex;
    align-items: center;
    justify-content: space-between;
    height: 56px;
    padding: 0 20px;
    background: #fff;
    border: 1.5px solid #eef0f6;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(17,24,39,0.06);
    font-family: 'Plus Jakarta Sans', sans-serif;
    gap: 16px;
    margin: 0 16px;
}

/* ── BREADCRUMB ── */
.adm-nav-left { display: flex; flex-direction: column; gap: 1px; min-width: 0; }

.adm-nav-trail {
    display: flex;
    align-items: center;
    gap: 5px;
    font-size: 10.5px;
    color: #a0aec0;
    font-weight: 500;
    letter-spacing: 0.02em;
}

.adm-nav-trail svg { opacity: .5; flex-shrink: 0; }

.adm-nav-trail a {
    color: #a0aec0;
    text-decoration: none;
    transition: color .15s;
}

.adm-nav-trail a:hover { color: #6366f1; }

.adm-nav-title {
    font-size: 15px;
    font-weight: 700;
    color: #111827;
    letter-spacing: -0.025em;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

/* ── RIGHT CLUSTER ── */
.adm-nav-right {
    display: flex;
    align-items: center;
    gap: 8px;
    flex-shrink: 0;
}

/* ── SEARCH ── */
.adm-search {
    position: relative;
    display: flex;
    align-items: center;
}

.adm-search svg {
    position: absolute;
    left: 11px;
    color: #9ca3af;
    pointer-events: none;
    flex-shrink: 0;
}

.adm-search input {
    height: 36px;
    width: 196px;
    padding: 0 14px 0 34px;
    border-radius: 10px;
    border: 1.5px solid #eef0f6;
    background: #f9fafb;
    font-size: 12.5px;
    font-family: 'Plus Jakarta Sans', sans-serif;
    color: #374151;
    outline: none;
    transition: all .2s;
}

.adm-search input::placeholder { color: #b0b8c8; }

.adm-search input:focus {
    border-color: #a5b4fc;
    background: #fff;
    width: 224px;
    box-shadow: 0 0 0 3px rgba(99,102,241,.08);
}

/* ── SEPARATOR ── */
.adm-sep {
    width: 1px;
    height: 22px;
    background: #eef0f6;
    flex-shrink: 0;
}

/* ── ICON BTN ── */
.adm-icon-btn {
    position: relative;
    width: 36px;
    height: 36px;
    border-radius: 10px;
    border: 1.5px solid #eef0f6;
    background: #f9fafb;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    color: #6b7280;
    transition: all .2s;
    flex-shrink: 0;
}

.adm-icon-btn:hover {
    background: #eef2ff;
    border-color: #c7d2fe;
    color: #4f46e5;
}

.adm-badge-dot {
    position: absolute;
    top: 6px;
    right: 6px;
    width: 7px;
    height: 7px;
    background: #f43f5e;
    border-radius: 50%;
    border: 1.5px solid #fff;
}

/* ── USER BTN ── */
.adm-user-btn {
    display: flex;
    align-items: center;
    gap: 8px;
    height: 36px;
    padding: 0 10px 0 5px;
    border-radius: 10px;
    border: 1.5px solid #eef0f6;
    background: #f9fafb;
    cursor: pointer;
    transition: all .2s;
    font-family: 'Plus Jakarta Sans', sans-serif;
}

.adm-user-btn:hover {
    background: #eef2ff;
    border-color: #c7d2fe;
}

.adm-avatar {
    width: 26px;
    height: 26px;
    border-radius: 7px;
    background: linear-gradient(135deg, #6366f1 0%, #818cf8 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 10px;
    font-weight: 700;
    color: #fff;
    flex-shrink: 0;
    overflow: hidden;
}

.adm-avatar img { width: 100%; height: 100%; object-fit: cover; border-radius: 7px; }

.adm-user-meta { line-height: 1.25; }

.adm-user-name {
    font-size: 12.5px;
    font-weight: 700;
    color: #111827;
    white-space: nowrap;
}

.adm-user-sub {
    font-size: 10px;
    font-weight: 500;
    color: #6366f1;
}

.adm-chevron {
    color: #b0b8c8;
    transition: transform .22s;
    flex-shrink: 0;
}

/* ── DROPDOWN BASE ── */
.adm-dd { position: relative; }

.adm-dd.open .adm-chevron { transform: rotate(180deg); }

.adm-dd-menu {
    position: absolute;
    top: calc(100% + 9px);
    right: 0;
    width: 214px;
    background: #fff;
    border: 1.5px solid #eef0f6;
    border-radius: 14px;
    padding: 5px;
    box-shadow: 0 16px 40px rgba(17,24,39,.10);
    opacity: 0;
    transform: translateY(-6px) scale(.97);
    pointer-events: none;
    transition: opacity .17s, transform .17s;
    z-index: 300;
}

.adm-dd.open .adm-dd-menu {
    opacity: 1;
    transform: translateY(0) scale(1);
    pointer-events: all;
}

/* user info block */
.adm-dd-info {
    padding: 10px 11px 8px;
    border-bottom: 1px solid #f3f4f6;
    margin-bottom: 4px;
}

.adm-dd-info-name {
    font-size: 13px;
    font-weight: 700;
    color: #111827;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.adm-dd-info-email {
    font-size: 10.5px;
    color: #9ca3af;
    margin-top: 1px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.adm-dd-pill {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    margin-top: 5px;
    padding: 2px 9px;
    border-radius: 99px;
    background: #eef2ff;
    font-size: 9.5px;
    font-weight: 700;
    letter-spacing: .06em;
    color: #4f46e5;
}

.adm-dd-pill-dot { width: 5px; height: 5px; border-radius: 50%; background: #6366f1; }

/* items */
.adm-dd-item {
    display: flex;
    align-items: center;
    gap: 9px;
    padding: 8px 10px;
    border-radius: 9px;
    font-size: 12.5px;
    font-weight: 500;
    color: #374151;
    text-decoration: none;
    cursor: pointer;
    transition: background .14s, color .14s;
    width: 100%;
    border: none;
    background: none;
    font-family: 'Plus Jakarta Sans', sans-serif;
    text-align: left;
}

.adm-dd-item:hover { background: #f9fafb; color: #111827; }

.adm-dd-icon {
    width: 27px;
    height: 27px;
    border-radius: 7px;
    background: #f3f4f6;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    transition: background .14s;
}

.adm-dd-item:hover .adm-dd-icon { background: #e0e7ff; }

.adm-dd-sep { height: 1px; background: #f3f4f6; margin: 4px 0; }

.adm-dd-item.danger { color: #ef4444; }
.adm-dd-item.danger:hover { background: #fff1f2; color: #dc2626; }
.adm-dd-item.danger:hover .adm-dd-icon { background: #ffe4e6; }

/* ── NOTIF PANEL ── */
.adm-notif-wrap { position: relative; }

.adm-notif-panel {
    position: absolute;
    top: calc(100% + 9px);
    right: 0;
    width: 292px;
    background: #fff;
    border: 1.5px solid #eef0f6;
    border-radius: 14px;
    overflow: hidden;
    box-shadow: 0 16px 40px rgba(17,24,39,.10);
    opacity: 0;
    transform: translateY(-6px) scale(.97);
    pointer-events: none;
    transition: opacity .17s, transform .17s;
    z-index: 300;
}

.adm-notif-wrap.open .adm-notif-panel {
    opacity: 1;
    transform: translateY(0) scale(1);
    pointer-events: all;
}

.adm-notif-hd {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 12px 14px 9px;
    border-bottom: 1px solid #f3f4f6;
}

.adm-notif-hd-title { font-size: 12.5px; font-weight: 700; color: #111827; }

.adm-notif-hd-link {
    font-size: 11px;
    font-weight: 600;
    color: #6366f1;
    text-decoration: none;
}

.adm-notif-row {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px 14px;
    border-bottom: 1px solid #f9fafb;
    text-decoration: none;
    transition: background .14s;
    cursor: pointer;
}

.adm-notif-row:last-child { border-bottom: none; }
.adm-notif-row:hover { background: #f9fafb; }

.adm-notif-ico {
    width: 32px;
    height: 32px;
    border-radius: 9px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    flex-shrink: 0;
}

.adm-notif-body { min-width: 0; }

.adm-notif-body-text {
    font-size: 12px;
    font-weight: 500;
    color: #374151;
    line-height: 1.4;
}

.adm-notif-body-text strong { color: #111827; }

.adm-notif-body-time { font-size: 10.5px; color: #9ca3af; margin-top: 2px; }

.adm-notif-empty {
    padding: 22px 14px;
    text-align: center;
    font-size: 12px;
    color: #9ca3af;
}
</style>

<nav class="adm-nav">

    {{-- LEFT: breadcrumb + title --}}
    <div class="adm-nav-left">
        <div class="adm-nav-trail">
            <a href="{{ route('home') }}">Admin</a>
            <svg width="8" height="8" viewBox="0 0 8 8" fill="none">
                <path d="M3 2L5 4L3 6" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            @yield('breadcrumb', 'Dashboard')
        </div>
        <div class="adm-nav-title">@yield('page-title', 'Dashboard')</div>
    </div>

    {{-- RIGHT --}}
    <div class="adm-nav-right">

        {{-- notif --}}
        @php
            try {
                $__nb = \App\Models\Booking::where('status','pending')->count();
                $__nr = \App\Models\ReturnKendaraan::where('status','return_pending')->count();
                $__nv = \App\Models\Review::where('status','pending')->count();
                $__nt = $__nb + $__nr + $__nv;
            } catch(\Exception $e) {
                $__nb = $__nr = $__nv = $__nt = 0;
            }
        @endphp

        <div class="adm-notif-wrap" id="admNW">
            <button class="adm-icon-btn" id="admNB">
                <svg width="15" height="15" viewBox="0 0 16 16" fill="none">
                    <path d="M8 1.5C5.51 1.5 3.5 3.51 3.5 6V9.5L2 11V12H14V11L12.5 9.5V6C12.5 3.51 10.49 1.5 8 1.5Z" stroke="currentColor" stroke-width="1.3" stroke-linejoin="round"/>
                    <path d="M6.5 12.5C6.5 13.33 7.17 14 8 14C8.83 14 9.5 13.33 9.5 12.5" stroke="currentColor" stroke-width="1.3"/>
                </svg>
                @if($__nt > 0)<span class="adm-badge-dot"></span>@endif
            </button>

            <div class="adm-notif-panel">
                <div class="adm-notif-hd">
                    <span class="adm-notif-hd-title">Notifikasi</span>
                    <a href="{{ route('admin.bookings.index') }}" class="adm-notif-hd-link">Lihat semua</a>
                </div>
                @if($__nt === 0)
                    <div class="adm-notif-empty">Tidak ada notifikasi baru 🎉</div>
                @else
                    @if($__nb > 0)
                    <a href="{{ route('admin.bookings.index') }}" class="adm-notif-row">
                        <div class="adm-notif-ico" style="background:#eef2ff;">📅</div>
                        <div class="adm-notif-body">
                            <div class="adm-notif-body-text"><strong>{{ $__nb }} booking</strong> menunggu konfirmasi</div>
                            <div class="adm-notif-body-time">Perlu ditindaklanjuti</div>
                        </div>
                    </a>
                    @endif
                    @if($__nr > 0)
                    <a href="{{ route('admin.returns.index') }}" class="adm-notif-row">
                        <div class="adm-notif-ico" style="background:#fef9c3;">🔄</div>
                        <div class="adm-notif-body">
                            <div class="adm-notif-body-text"><strong>{{ $__nr }} pengembalian</strong> perlu inspeksi</div>
                            <div class="adm-notif-body-time">Perlu ditindaklanjuti</div>
                        </div>
                    </a>
                    @endif
                    @if($__nv > 0)
                    <a href="{{ route('admin.reviews.index') }}" class="adm-notif-row">
                        <div class="adm-notif-ico" style="background:#fce7f3;">⭐</div>
                        <div class="adm-notif-body">
                            <div class="adm-notif-body-text"><strong>{{ $__nv }} ulasan</strong> menunggu moderasi</div>
                            <div class="adm-notif-body-time">Perlu ditindaklanjuti</div>
                        </div>
                    </a>
                    @endif
                @endif
            </div>
        </div>

        <div class="adm-sep"></div>

        {{-- user --}}
        <div class="adm-dd" id="admUD">
            <button class="adm-user-btn" onclick="admTogUD()">
                <div class="adm-avatar">
                    @if(Auth::user()->avatar)
                        <img src="{{ asset('storage/'.Auth::user()->avatar) }}" alt="">
                    @else
                        {{ strtoupper(substr(Auth::user()->name,0,2)) }}
                    @endif
                </div>
                <div class="adm-user-meta">
                    <div class="adm-user-name">{{ Auth::user()->name }}</div>
                    <div class="adm-user-sub">Administrator</div>
                </div>
                <svg class="adm-chevron" width="11" height="11" viewBox="0 0 12 12" fill="none">
                    <path d="M3 4.5L6 7.5L9 4.5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>

            <div class="adm-dd-menu">
                <div class="adm-dd-info">
                    <div class="adm-dd-info-name">{{ Auth::user()->name }}</div>
                    <div class="adm-dd-info-email">{{ Auth::user()->email }}</div>
                    <div class="adm-dd-pill"><span class="adm-dd-pill-dot"></span>Administrator</div>
                </div>

                <a href="{{ route('home') }}" class="adm-dd-item">
                    <div class="adm-dd-icon">
                        <svg width="12" height="12" viewBox="0 0 14 14" fill="none">
                            <rect x="1.5" y="1.5" width="4.5" height="4.5" rx="1" stroke="#6366f1" stroke-width="1.2"/>
                            <rect x="8" y="1.5" width="4.5" height="4.5" rx="1" stroke="#6366f1" stroke-width="1.2"/>
                            <rect x="1.5" y="8" width="4.5" height="4.5" rx="1" stroke="#6366f1" stroke-width="1.2"/>
                            <rect x="8" y="8" width="4.5" height="4.5" rx="1" stroke="#6366f1" stroke-width="1.2"/>
                        </svg>
                    </div>
                    Dashboard
                </a>

                <a href="{{ route('profile.show') }}" class="adm-dd-item">
                    <div class="adm-dd-icon">
                        <svg width="12" height="12" viewBox="0 0 14 14" fill="none">
                            <circle cx="7" cy="5" r="2.5" stroke="#6366f1" stroke-width="1.2"/>
                            <path d="M2 12C2 9.8 4.2 8 7 8C9.8 8 12 9.8 12 12" stroke="#6366f1" stroke-width="1.2" stroke-linecap="round"/>
                        </svg>
                    </div>
                    Profil Saya
                </a>

                <a href="{{ url('/welcome') }}" class="adm-dd-item">
                    <div class="adm-dd-icon">
                        <svg width="12" height="12" viewBox="0 0 14 14" fill="none">
                            <circle cx="7" cy="7" r="5.5" stroke="#6366f1" stroke-width="1.2"/>
                            <path d="M7 1.5C7 1.5 5 4 5 7C5 10 7 12.5 7 12.5" stroke="#6366f1" stroke-width="1.2"/>
                            <path d="M7 1.5C7 1.5 9 4 9 7C9 10 7 12.5 7 12.5" stroke="#6366f1" stroke-width="1.2"/>
                            <path d="M1.5 7H12.5" stroke="#6366f1" stroke-width="1.2"/>
                        </svg>
                    </div>
                    Lihat Situs
                </a>

                <div class="adm-dd-sep"></div>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="adm-dd-item danger">
                        <div class="adm-dd-icon">
                            <svg width="12" height="12" viewBox="0 0 14 14" fill="none">
                                <path d="M5.5 2.5H3C2.2 2.5 1.5 3.2 1.5 4V10C1.5 10.8 2.2 11.5 3 11.5H5.5" stroke="#ef4444" stroke-width="1.2" stroke-linecap="round"/>
                                <path d="M9.5 10L12.5 7L9.5 4M12.5 7H5.5" stroke="#ef4444" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        Logout
                    </button>
                </form>
            </div>
        </div>

    </div>
</nav>

<script>
function admTogUD(){
    document.getElementById('admUD').classList.toggle('open');
    document.getElementById('admNW').classList.remove('open');
}
document.getElementById('admNB').addEventListener('click',function(e){
    e.stopPropagation();
    document.getElementById('admNW').classList.toggle('open');
    document.getElementById('admUD').classList.remove('open');
});
document.addEventListener('click',function(e){
    var u=document.getElementById('admUD'),n=document.getElementById('admNW');
    if(u&&!u.contains(e.target))u.classList.remove('open');
    if(n&&!n.contains(e.target))n.classList.remove('open');
});
</script>