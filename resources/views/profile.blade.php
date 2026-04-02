@extends('layouts.front')

@section('title', 'Profil Saya')

@push('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
/* ── Pastikan Google Font termuat di atas Bootstrap ────── */
.pf-root, .pf-root * {
    font-family: 'Plus Jakarta Sans', sans-serif !important;
    box-sizing: border-box !important;
}

/* ── Reset agresif terhadap Bootstrap ──────────────────── */
.pf-root h1, .pf-root h2, .pf-root h3,
.pf-root h4, .pf-root h5, .pf-root h6 {
    font-family: 'Plus Jakarta Sans', sans-serif !important;
    margin: 0 !important;
    padding: 0 !important;
    line-height: 1.3 !important;
}
.pf-root p { margin: 0 !important; padding: 0 !important; }
.pf-root a { text-decoration: none !important; }
.pf-root button { font-family: 'Plus Jakarta Sans', sans-serif !important; }
.pf-root input, .pf-root textarea, .pf-root select {
    font-family: 'Plus Jakarta Sans', sans-serif !important;
}

/* ══════════════════════════════════════════════════════════
   ROOT
   ══════════════════════════════════════════════════════════ */
.pf-root {
    background: #f0f2f8 !important;
    padding: 36px 16px 64px !important;
    min-height: 80vh !important;
    color: #111827 !important;
}

/* ── Judul halaman ─────────────────────────────────────── */
.pf-page-head {
    max-width: 980px !important;
    margin: 0 auto 26px auto !important;
}
.pf-page-head h1 {
    font-size: 24px !important;
    font-weight: 700 !important;
    color: #111827 !important;
    line-height: 1.2 !important;
    margin: 0 !important;
}
.pf-page-head p {
    font-size: 13px !important;
    color: #9ca3af !important;
    margin-top: 4px !important;
}

/* ── Grid utama ────────────────────────────────────────── */
.pf-wrap {
    max-width: 980px !important;
    margin: 0 auto !important;
    display: grid !important;
    grid-template-columns: 250px 1fr !important;
    gap: 20px !important;
    align-items: start !important;
}

/* ── Kartu dasar ───────────────────────────────────────── */
.pf-card {
    background: #ffffff !important;
    border: 1px solid rgba(0,0,0,0.08) !important;
    border-radius: 16px !important;
    overflow: hidden !important;
    box-shadow: 0 2px 16px rgba(0,0,0,0.07) !important;
    margin: 0 !important;
    padding: 0 !important;
}
.pf-card + .pf-card { margin-top: 18px !important; }

.pf-card-head {
    padding: 16px 22px !important;
    border-bottom: 1px solid rgba(0,0,0,0.07) !important;
    display: flex !important;
    align-items: center !important;
    justify-content: space-between !important;
}
.pf-card-head-title {
    font-size: 11px !important;
    font-weight: 700 !important;
    letter-spacing: 0.07em !important;
    text-transform: uppercase !important;
    color: #6b7280 !important;
}
.pf-card-head-meta {
    font-size: 11px !important;
    color: #9ca3af !important;
}
.pf-card-body { padding: 22px !important; }
.pf-card-foot {
    padding: 14px 22px !important;
    border-top: 1px solid rgba(0,0,0,0.07) !important;
    background: #fafbff !important;
    display: flex !important;
    justify-content: flex-end !important;
    align-items: center !important;
    gap: 10px !important;
}

/* ════════════════════════════════════════════════════════
   SIDEBAR
   ════════════════════════════════════════════════════════ */
.pf-sidebar {
    position: sticky !important;
    top: 90px !important;
}

/* Avatar area */
.pf-identity {
    display: flex !important;
    flex-direction: column !important;
    align-items: center !important;
    text-align: center !important;
    padding: 28px 22px 20px !important;
}

.pf-avatar-wrap {
    position: relative !important;
    width: 90px !important;
    height: 90px !important;
    margin-bottom: 14px !important;
}

.pf-avatar-img {
    width: 90px !important;
    height: 90px !important;
    border-radius: 50% !important;
    object-fit: cover !important;
    border: 3px solid #2563eb !important;
    display: block !important;
}

.pf-avatar-initials {
    width: 90px !important;
    height: 90px !important;
    border-radius: 50% !important;
    background: linear-gradient(135deg, #2563eb, #1d4ed8) !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    font-size: 28px !important;
    font-weight: 700 !important;
    color: #fff !important;
    border: 3px solid #2563eb !important;
}

/* Upload link — pakai <label for="..."> */
.pf-avatar-label {
    position: absolute !important;
    bottom: 0 !important;
    right: 0 !important;
    width: 26px !important;
    height: 26px !important;
    border-radius: 50% !important;
    background: #2563eb !important;
    border: 2px solid #fff !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    cursor: pointer !important;
    color: #fff !important;
    font-size: 11px !important;
    line-height: 1 !important;
    text-decoration: none !important;
}
.pf-avatar-label:hover { background: #1d4ed8 !important; }

.pf-avatar-input-hidden {
    position: absolute !important;
    width: 1px !important;
    height: 1px !important;
    opacity: 0 !important;
    overflow: hidden !important;
    clip: rect(0,0,0,0) !important;
    white-space: nowrap !important;
    pointer-events: none !important;
}

.pf-user-name {
    font-size: 18px !important;
    font-weight: 700 !important;
    color: #111827 !important;
    margin-bottom: 5px !important;
}
.pf-user-role {
    display: inline-block !important;
    font-size: 10px !important;
    font-weight: 700 !important;
    letter-spacing: 0.08em !important;
    text-transform: uppercase !important;
    padding: 3px 10px !important;
    border-radius: 99px !important;
    background: #eff6ff !important;
    color: #2563eb !important;
    margin-bottom: 5px !important;
}
.pf-user-email {
    font-size: 12px !important;
    color: #9ca3af !important;
    word-break: break-all !important;
}

/* Stats */
.pf-stats-list {
    padding: 0 16px 18px !important;
    list-style: none !important;
    margin: 0 !important;
}
.pf-stats-item {
    display: flex !important;
    align-items: center !important;
    justify-content: space-between !important;
    padding: 8px 10px !important;
    border-radius: 8px !important;
}
.pf-stats-item:hover { background: #f0f2f8 !important; }
.pf-stats-key {
    font-size: 12px !important;
    color: #9ca3af !important;
}
.pf-stats-val {
    font-size: 13px !important;
    font-weight: 600 !important;
    color: #111827 !important;
}

/* Garis pembagi */
.pf-hr {
    height: 1px !important;
    background: rgba(0,0,0,0.07) !important;
    border: none !important;
    margin: 0 22px 16px !important;
}

/* Nav */
.pf-nav {
    padding: 0 12px 18px !important;
    list-style: none !important;
    margin: 0 !important;
}
.pf-nav-item { margin: 0 !important; }
.pf-nav-link {
    display: flex !important;
    align-items: center !important;
    gap: 10px !important;
    padding: 9px 10px !important;
    border-radius: 9px !important;
    font-size: 13px !important;
    font-weight: 500 !important;
    color: #4b5563 !important;
    text-decoration: none !important;
    transition: background 0.15s, color 0.15s !important;
    border: none !important;
    background: transparent !important;
    width: 100% !important;
    cursor: pointer !important;
}
.pf-nav-link:hover { background: #eff6ff !important; color: #2563eb !important; }
.pf-nav-link-danger { color: #dc2626 !important; }
.pf-nav-link-danger:hover { background: #fef2f2 !important; color: #dc2626 !important; }

.pf-nav-icon {
    width: 30px !important;
    height: 30px !important;
    border-radius: 8px !important;
    background: #f0f2f8 !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    font-size: 14px !important;
    flex-shrink: 0 !important;
    line-height: 1 !important;
}

/* ════════════════════════════════════════════════════════
   KONTEN KANAN
   ════════════════════════════════════════════════════════ */
.pf-content {
    display: flex !important;
    flex-direction: column !important;
    gap: 18px !important;
}

/* Alert */
.pf-alert {
    display: flex !important;
    align-items: flex-start !important;
    gap: 10px !important;
    padding: 13px 16px !important;
    border-radius: 12px !important;
    font-size: 13px !important;
    font-weight: 500 !important;
}
.pf-alert-ok  { background: #f0fdf4 !important; color: #16a34a !important; border: 1px solid #bbf7d0 !important; }
.pf-alert-err { background: #fef2f2 !important; color: #dc2626 !important; border: 1px solid #fecaca !important; }
.pf-alert-icon { font-size: 16px !important; flex-shrink: 0 !important; margin-top: 1px !important; }
.pf-alert ul  { margin: 4px 0 0 16px !important; padding: 0 !important; }
.pf-alert li  { margin-bottom: 2px !important; }

/* ── Form ──────────────────────────────────────────────── */
.pf-grid { display: grid !important; grid-template-columns: 1fr 1fr !important; gap: 16px !important; }
.pf-full { grid-column: 1 / -1 !important; }
.pf-group { display: flex !important; flex-direction: column !important; gap: 5px !important; }

.pf-label {
    display: block !important;
    font-size: 11px !important;
    font-weight: 700 !important;
    letter-spacing: 0.06em !important;
    text-transform: uppercase !important;
    color: #9ca3af !important;
}
.pf-req { color: #dc2626 !important; margin-left: 2px !important; }

.pf-input, .pf-textarea {
    display: block !important;
    width: 100% !important;
    padding: 10px 14px !important;
    border: 1px solid rgba(0,0,0,0.12) !important;
    border-radius: 10px !important;
    font-size: 14px !important;
    color: #111827 !important;
    background: #fff !important;
    outline: none !important;
    appearance: none !important;
    -webkit-appearance: none !important;
    box-shadow: none !important;
    transition: border-color 0.2s !important;
}
.pf-input:focus, .pf-textarea:focus {
    border-color: #2563eb !important;
    box-shadow: 0 0 0 3px rgba(37,99,235,0.1) !important;
    outline: none !important;
}
.pf-input-readonly {
    background: #f5f6fa !important;
    color: #9ca3af !important;
    cursor: default !important;
}
.pf-textarea { resize: vertical !important; min-height: 78px !important; line-height: 1.6 !important; }
.pf-hint { font-size: 11px !important; color: #9ca3af !important; }
.pf-err-msg { font-size: 11px !important; color: #dc2626 !important; }

/* Tombol */
.pf-btn {
    display: inline-flex !important;
    align-items: center !important;
    gap: 7px !important;
    padding: 10px 20px !important;
    border-radius: 10px !important;
    font-size: 13px !important;
    font-weight: 600 !important;
    cursor: pointer !important;
    border: none !important;
    text-decoration: none !important;
    line-height: 1 !important;
    white-space: nowrap !important;
    transition: opacity 0.15s, box-shadow 0.15s !important;
}
.pf-btn:hover { opacity: 0.88 !important; }
.pf-btn-primary { background: #2563eb !important; color: #fff !important; }
.pf-btn-primary:hover { box-shadow: 0 4px 14px rgba(37,99,235,0.3) !important; color: #fff !important; }
.pf-btn-ghost {
    background: transparent !important;
    color: #6b7280 !important;
    border: 1px solid rgba(0,0,0,0.1) !important;
}
.pf-btn-ghost:hover { background: #f0f2f8 !important; color: #111827 !important; }

/* Strength bar — pure CSS, no JS */
.pf-pw-row { display: grid !important; grid-template-columns: 1fr 1fr !important; gap: 16px !important; }
.pf-pw-row-full { grid-column: 1 / -1 !important; }

/* ── Responsive ────────────────────────────────────────── */
@media (max-width: 800px) {
    .pf-wrap  { grid-template-columns: 1fr !important; }
    .pf-sidebar { position: static !important; }
    .pf-grid  { grid-template-columns: 1fr !important; }
    .pf-full  { grid-column: 1 !important; }
    .pf-pw-row { grid-template-columns: 1fr !important; }
    .pf-pw-row-full { grid-column: 1 !important; }
}
</style>
@endpush

@section('content')
<div class="pf-root">

    {{-- Judul halaman --}}
    <div class="pf-page-head">
        <h1>Profil Saya</h1>
        <p>Kelola informasi akun dan keamanan Anda</p>
    </div>

    <div class="pf-wrap">

        {{-- ════════════════════════════════════════════════
             SIDEBAR
             ════════════════════════════════════════════════ --}}
        <aside class="pf-sidebar">
            <div class="pf-card">

                {{-- Identitas + avatar --}}
                <div class="pf-identity">
                    <div class="pf-avatar-wrap">

                        @if(Auth::user()->avatar)
                            <img src="{{ asset('storage/' . Auth::user()->avatar) }}"
                                 alt="Foto Profil" class="pf-avatar-img">
                        @else
                            <div class="pf-avatar-initials">
                                {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                            </div>
                        @endif

                        {{-- Tombol ganti foto: form POST biasa, tanpa JS --}}
                        <label class="pf-avatar-label" for="pf-quick-avatar" title="Ganti foto">✏</label>

                    </div>

                    <div class="pf-user-name">{{ Auth::user()->name }}</div>
                    <span class="pf-user-role">★ {{ ucfirst(Auth::user()->role) }}</span>
                    <div class="pf-user-email">{{ Auth::user()->email }}</div>
                </div>

                {{-- Form upload avatar (tersembunyi, submit otomatis via CSS :has) --}}
                {{-- Karena tanpa JS, kita taruh di form profil utama di kanan --}}

                {{-- Statistik --}}
                <ul class="pf-stats-list">
                    <li class="pf-stats-item">
                        <span class="pf-stats-key">Bergabung</span>
                        <span class="pf-stats-val">{{ Auth::user()->created_at->translatedFormat('M Y') }}</span>
                    </li>
                    <li class="pf-stats-item">
                        <span class="pf-stats-key">Total Booking</span>
                        <span class="pf-stats-val">{{ Auth::user()->bookings()->count() }}</span>
                    </li>
                    @if(Auth::user()->phone)
                    <li class="pf-stats-item">
                        <span class="pf-stats-key">Telepon</span>
                        <span class="pf-stats-val">{{ Auth::user()->phone }}</span>
                    </li>
                    @endif
                </ul>

                <hr class="pf-hr">

                {{-- Navigasi --}}
                <ul class="pf-nav">
                    <li class="pf-nav-item">
                        <a href="{{ route('bookings.history') }}" class="pf-nav-link">
                            <span class="pf-nav-icon">📋</span> Riwayat Booking
                        </a>
                    </li>
                    <li class="pf-nav-item">
                        <a href="{{ route('welcome') }}" class="pf-nav-link">
                            <span class="pf-nav-icon">🚗</span> Cari Kendaraan
                        </a>
                    </li>
                    <li class="pf-nav-item" style="margin-top:6px !important;">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="pf-nav-link pf-nav-link-danger">
                                <span class="pf-nav-icon">↩</span> Logout
                            </button>
                        </form>
                    </li>
                </ul>

            </div>
        </aside>

        {{-- ════════════════════════════════════════════════
             KONTEN KANAN
             ════════════════════════════════════════════════ --}}
        <div class="pf-content">

            {{-- Flash alert --}}
            @if(session('success'))
            <div class="pf-alert pf-alert-ok">
                <span class="pf-alert-icon">✔</span>
                <span>{{ session('success') }}</span>
            </div>
            @endif

            @if($errors->any())
            <div class="pf-alert pf-alert-err">
                <span class="pf-alert-icon">⚠</span>
                <div>
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- ── Kartu Informasi Profil ─────────────────── --}}
            <div class="pf-card">
                <div class="pf-card-head">
                    <span class="pf-card-head-title">Informasi Profil</span>
                    <span class="pf-card-head-meta">
                        Diperbarui {{ Auth::user()->updated_at->diffForHumans() }}
                    </span>
                </div>

                <form action="{{ route('profile.update') }}" method="POST"
                      enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="pf-card-body">

                        {{-- Upload avatar — input file biasa, submit form ini --}}
                        <div class="pf-group pf-full" style="margin-bottom:16px !important;">
                            <label class="pf-label">Foto Profil</label>
                            <input id="pf-quick-avatar"
                                   type="file"
                                   name="avatar"
                                   accept="image/*"
                                   class="pf-input"
                                   style="padding: 7px 14px !important; cursor:pointer !important;">
                            <span class="pf-hint">JPG, PNG · maks. 2 MB. Klik Simpan untuk menerapkan.</span>
                        </div>

                        <div class="pf-grid">

                            <div class="pf-group">
                                <label class="pf-label" for="pf-name">
                                    Nama Lengkap <span class="pf-req">*</span>
                                </label>
                                <input type="text" id="pf-name" name="name"
                                       class="pf-input @error('name') pf-input-err @enderror"
                                       value="{{ old('name', Auth::user()->name) }}"
                                       required>
                                @error('name')
                                    <span class="pf-err-msg">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="pf-group">
                                <label class="pf-label" for="pf-phone">Nomor Telepon</label>
                                <input type="text" id="pf-phone" name="phone"
                                       class="pf-input"
                                       value="{{ old('phone', Auth::user()->phone) }}"
                                       placeholder="+62 812 3456 7890">
                            </div>

                            <div class="pf-group pf-full">
                                <label class="pf-label">Email</label>
                                <input type="email"
                                       class="pf-input pf-input-readonly"
                                       value="{{ Auth::user()->email }}"
                                       readonly tabindex="-1">
                                <span class="pf-hint">Email tidak dapat diubah.</span>
                            </div>

                            <div class="pf-group pf-full">
                                <label class="pf-label" for="pf-address">Alamat</label>
                                <textarea id="pf-address" name="address"
                                          class="pf-textarea"
                                          placeholder="Jl. Contoh No. 1, Kota...">{{ old('address', Auth::user()->address) }}</textarea>
                            </div>

                        </div>
                    </div>

                    <div class="pf-card-foot">
                        <a href="{{ route('profile.show') }}" class="pf-btn pf-btn-ghost">Batal</a>
                        <button type="submit" class="pf-btn pf-btn-primary">
                            💾 Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>

            {{-- ── Kartu Ubah Password ────────────────────── --}}
            <div class="pf-card">
                <div class="pf-card-head">
                    <span class="pf-card-head-title">Ubah Password</span>
                </div>

                <form action="{{ route('profile.password') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="pf-card-body">
                        <div class="pf-grid">

                            <div class="pf-group pf-full">
                                <label class="pf-label" for="pf-cur-pw">
                                    Password Saat Ini <span class="pf-req">*</span>
                                </label>
                                <input type="password" id="pf-cur-pw"
                                       name="current_password"
                                       class="pf-input"
                                       placeholder="••••••••"
                                       autocomplete="current-password">
                                @error('current_password')
                                    <span class="pf-err-msg">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="pf-group">
                                <label class="pf-label" for="pf-new-pw">
                                    Password Baru <span class="pf-req">*</span>
                                </label>
                                <input type="password" id="pf-new-pw"
                                       name="password"
                                       class="pf-input"
                                       placeholder="Min. 8 karakter"
                                       autocomplete="new-password">
                                @error('password')
                                    <span class="pf-err-msg">{{ $message }}</span>
                                @enderror
                                <span class="pf-hint">Gunakan huruf besar, angka, dan simbol untuk keamanan lebih baik.</span>
                            </div>

                            <div class="pf-group">
                                <label class="pf-label" for="pf-conf-pw">
                                    Konfirmasi Password <span class="pf-req">*</span>
                                </label>
                                <input type="password" id="pf-conf-pw"
                                       name="password_confirmation"
                                       class="pf-input"
                                       placeholder="Ulangi password baru"
                                       autocomplete="new-password">
                            </div>

                        </div>
                    </div>

                    <div class="pf-card-foot">
                        <button type="submit" class="pf-btn pf-btn-primary">
                            🔒 Perbarui Password
                        </button>
                    </div>
                </form>
            </div>

        </div>{{-- /pf-content --}}
    </div>{{-- /pf-wrap --}}
</div>{{-- /pf-root --}}
@endsection