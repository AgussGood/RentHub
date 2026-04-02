<style>
  @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600&display=swap');

  :root { --ac: #2563EB; }

  .rh-navbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 56px;
    height: 72px;
    background: #fff;
    border-bottom: 1px solid rgba(0,0,0,0.06);
    font-family: 'Plus Jakarta Sans', sans-serif;
    position: sticky;
    top: 0;
    z-index: 1000;
  }

  .rh-brand {
    text-decoration: none;
    font-size: 22px;
    font-weight: 600;
    color: #0B132A;
    letter-spacing: -0.02em;
  }

  .rh-brand span { color: var(--ac); }

  .rh-nav-links {
    display: flex;
    align-items: center;
    gap: 4px;
    list-style: none;
  }

  .rh-nav-links li a {
    font-size: 15px;
    font-weight: 400;
    color: #4F5665;
    text-decoration: none;
    padding: 8px 20px;
    border-radius: 6px;
    display: block;
    position: relative;
    transition: color 0.2s, background 0.2s;
    white-space: nowrap;
  }

  .rh-nav-links li a::after {
    content: '';
    position: absolute;
    bottom: -1px;
    left: 20px;
    right: 20px;
    height: 2.5px;
    border-radius: 2px 2px 0 0;
    background: var(--ac);
    transform: scaleX(0);
    transition: transform 0.25s ease;
  }

  .rh-nav-links li a.active {
    font-weight: 600;
    color: var(--ac);
  }

  .rh-nav-links li a.active::after { transform: scaleX(1); }

  .rh-nav-links li a:hover:not(.active) {
    color: #0B132A;
    background: #EFF6FF;
  }

  .rh-nav-right {
    display: flex;
    align-items: center;
    gap: 6px;
  }

  .rh-dropdown { position: relative; }

  .rh-dropdown-btn {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 15px;
    font-weight: 500;
    color: #0B132A;
    background: none;
    border: none;
    cursor: pointer;
    padding: 8px 14px;
    border-radius: 8px;
    transition: background 0.2s;
    font-family: 'Plus Jakarta Sans', sans-serif;
  }

  .rh-dropdown-btn:hover { background: #EFF6FF; }

  .rh-avatar {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 11px;
    font-weight: 700;
    color: #fff;
    background: var(--ac);
    flex-shrink: 0;
  }

  .rh-chevron { opacity: 0.45; transition: transform 0.25s; }
  .rh-dropdown.open .rh-chevron { transform: rotate(180deg); }

  .rh-dropdown-menu {
    position: absolute;
    top: calc(100% + 10px);
    right: 0;
    min-width: 190px;
    background: #fff;
    border: 1px solid rgba(0,0,0,0.09);
    border-radius: 10px;
    padding: 6px;
    opacity: 0;
    transform: translateY(-6px);
    pointer-events: none;
    transition: opacity 0.18s, transform 0.18s;
    box-shadow: 0 8px 28px rgba(0,0,0,0.1);
    z-index: 99;
  }

  .rh-dropdown.open .rh-dropdown-menu {
    opacity: 1;
    transform: translateY(0);
    pointer-events: all;
  }

  .rh-dropdown-item {
    display: flex;
    align-items: center;
    gap: 9px;
    padding: 9px 13px;
    border-radius: 7px;
    font-size: 13.5px;
    color: #4F5665;
    text-decoration: none;
    cursor: pointer;
    transition: color 0.15s, background 0.15s;
    width: 100%;
    text-align: left;
    border: none;
    background: none;
    font-family: 'Plus Jakarta Sans', sans-serif;
  }

  .rh-dropdown-item:hover {
    background: #EFF6FF;
    color: var(--ac);
  }

  .rh-dropdown-item.danger:hover {
    background: #fef2f2;
    color: #DC2626;
  }

  .rh-dropdown-sep {
    height: 1px;
    background: rgba(0,0,0,0.07);
    margin: 4px 0;
  }

  .rh-btn-login {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: 15px;
    font-weight: 600;
    color: var(--ac);
    background: none;
    border: 2px solid var(--ac);
    cursor: pointer;
    padding: 8px 28px;
    border-radius: 999px;
    font-family: 'Plus Jakarta Sans', sans-serif;
    text-decoration: none;
    transition: background 0.2s, color 0.2s;
  }

  .rh-btn-login:hover {
    background: var(--ac);
    color: #fff;
  }

  .rh-toggler {
    display: none;
    flex-direction: column;
    gap: 5px;
    background: none;
    border: none;
    cursor: pointer;
    padding: 8px;
  }

  .rh-toggler span {
    display: block;
    width: 22px;
    height: 1.5px;
    background: #4F5665;
    transition: all 0.25s;
    transform-origin: center;
  }

  .rh-toggler.open span:nth-child(1) { transform: translateY(6.5px) rotate(45deg); }
  .rh-toggler.open span:nth-child(2) { opacity: 0; }
  .rh-toggler.open span:nth-child(3) { transform: translateY(-6.5px) rotate(-45deg); }

  .rh-mobile-menu {
    display: none;
    flex-direction: column;
    gap: 2px;
    padding: 12px 16px 16px;
    background: #fff;
    border-bottom: 1px solid rgba(0,0,0,0.06);
    font-family: 'Plus Jakarta Sans', sans-serif;
  }

  .rh-mobile-menu.open { display: flex; }

  .rh-mobile-link {
    display: flex;
    align-items: center;
    gap: 9px;
    padding: 10px 12px;
    border-radius: 8px;
    font-size: 14px;
    color: #4F5665;
    text-decoration: none;
    transition: all 0.2s;
    border: none;
    background: none;
    cursor: pointer;
    width: 100%;
    font-family: 'Plus Jakarta Sans', sans-serif;
  }

  .rh-mobile-link.active {
    color: var(--ac);
    background: #EFF6FF;
    font-weight: 600;
  }

  .rh-mobile-link:hover:not(.active) {
    color: #0B132A;
    background: #f3f4f6;
  }

  .rh-mobile-sep {
    height: 1px;
    background: rgba(0,0,0,0.07);
    margin: 6px 0;
  }

  @media (max-width: 991px) {
    .rh-navbar { padding: 0 20px; }
    .rh-nav-links, .rh-nav-right { display: none; }
    .rh-toggler { display: flex; }
  }
</style>

<nav class="rh-navbar">

  {{-- Brand tanpa logo --}}
  <a class="rh-brand" href="{{ url('/') }}">
    Rent<span>Hub</span>
  </a>

  {{-- Desktop Nav Links --}}
  <ul class="rh-nav-links">
    <li>
      <a href="{{ url('/') }}" class="{{ request()->is('/') ? 'active' : '' }}">
        Beranda
      </a>
    </li>
    <li>
      <a href="{{ route('cars') }}" class="{{ request()->routeIs('cars') ? 'active' : '' }}">
        Kendaraan
      </a>
    </li>
    <li>
      <a href="{{ route('bookings.history') }}" class="{{ request()->routeIs('bookings.history') ? 'active' : '' }}">
        Histori
      </a>
    </li>
  </ul>

  {{-- Desktop Right --}}
  <div class="rh-nav-right">
    @auth
      <div class="rh-dropdown" id="rhDropdown">
        <button class="rh-dropdown-btn" onclick="rhToggleDD()">
          <div class="rh-avatar">
            {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
          </div>
          {{ Auth::user()->name }}
          <svg class="rh-chevron" width="12" height="12" viewBox="0 0 12 12" fill="none">
            <path d="M3 4.5L6 7.5L9 4.5" stroke="#0B132A" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </button>
        <div class="rh-dropdown-menu">
          @if(Auth::user()->role === 'admin')
            <a class="rh-dropdown-item" href="{{ url('/home') }}">
              <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                <rect x="1.5" y="1.5" width="4.5" height="4.5" rx="1" stroke="currentColor" stroke-width="1.2"/>
                <rect x="8" y="1.5" width="4.5" height="4.5" rx="1" stroke="currentColor" stroke-width="1.2"/>
                <rect x="1.5" y="8" width="4.5" height="4.5" rx="1" stroke="currentColor" stroke-width="1.2"/>
                <rect x="8" y="8" width="4.5" height="4.5" rx="1" stroke="currentColor" stroke-width="1.2"/>
              </svg>
              Dashboard
            </a>
          @else
            <a class="rh-dropdown-item" href="{{ url('/profile') }}">
              <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                <circle cx="7" cy="5" r="2.5" stroke="currentColor" stroke-width="1.2"/>
                <path d="M2 12C2 9.8 4.2 8 7 8C9.8 8 12 9.8 12 12" stroke="currentColor" stroke-width="1.2" stroke-linecap="round"/>
              </svg>
              Profile
            </a>
          @endif
          <div class="rh-dropdown-sep"></div>
          <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="rh-dropdown-item danger">
              <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                <path d="M5.5 2.5H3C2.2 2.5 1.5 3.2 1.5 4V10C1.5 10.8 2.2 11.5 3 11.5H5.5M9.5 10L12.5 7L9.5 4M12.5 7H5.5" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
              Logout
            </button>
          </form>
        </div>
      </div>
    @else
      <a href="{{ route('login') }}" class="rh-btn-login">
        <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
          <path d="M9 2.5H11C11.8 2.5 12.5 3.2 12.5 4V10C12.5 10.8 11.8 11.5 11 11.5H9M6 10L9 7L6 4M9 7H1.5" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        Login
      </a>
    @endauth
  </div>

  {{-- Mobile Toggler --}}
  <button class="rh-toggler" id="rhToggler" onclick="rhToggleMobile()">
    <span></span><span></span><span></span>
  </button>
</nav>

{{-- Mobile Menu --}}
<div class="rh-mobile-menu" id="rhMobileMenu">
  <a class="rh-mobile-link {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}">
    Beranda
  </a>
  <a class="rh-mobile-link {{ request()->routeIs('cars') ? 'active' : '' }}" href="{{ route('cars') }}">
    Kendaraan
  </a>
  <a class="rh-mobile-link {{ request()->routeIs('bookings.history') ? 'active' : '' }}" href="{{ route('bookings.history') }}">
    Histori
  </a>
  <div class="rh-mobile-sep"></div>
  @auth
    <a class="rh-mobile-link" href="{{ Auth::user()->role === 'admin' ? url('/home') : url('/welcome') }}">
      {{ Auth::user()->name }}
    </a>
    <form action="{{ route('logout') }}" method="POST">
      @csrf
      <button type="submit" class="rh-mobile-link" style="color:#DC2626;">
        Logout
      </button>
    </form>
  @else
    <a class="rh-mobile-link" href="{{ route('login') }}" style="color:var(--ac);font-weight:600;">
      Login
    </a>
  @endauth
</div>

<script>
  function rhToggleDD() {
    var el = document.getElementById('rhDropdown');
    if (el) el.classList.toggle('open');
  }

  function rhToggleMobile() {
    document.getElementById('rhMobileMenu').classList.toggle('open');
    document.getElementById('rhToggler').classList.toggle('open');
  }

  document.addEventListener('click', function(e) {
    var dd = document.getElementById('rhDropdown');
    if (dd && !dd.contains(e.target)) dd.classList.remove('open');
  });
</script>