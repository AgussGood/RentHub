@extends('layouts.front')

@section('title', 'Profil Saya')

@push('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,300&family=DM+Serif+Display&display=swap" rel="stylesheet">

<style>
/* ── Reset & Base ──────────────────────────────────── */
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

:root {
    --c-bg:           #F7F8FC;
    --c-surface:      #FFFFFF;
    --c-surface-2:    #F1F3FA;
    --c-border:       rgba(0,0,0,0.07);
    --c-border-focus: #3B6ECC;
    --c-text-1:       #0F1623;
    --c-text-2:       #5A6378;
    --c-text-3:       #9AA3B5;
    --c-accent:       #3B6ECC;
    --c-accent-light: #EBF1FF;
    --c-danger:       #C84040;
    --c-danger-light: #FFF0F0;
    --c-success:      #2E7D52;
    --c-success-light:#F0FBF5;
    --radius-sm: 8px;
    --radius-md: 12px;
    --radius-lg: 18px;
    --shadow-card: 0 1px 3px rgba(0,0,0,0.05), 0 4px 16px rgba(0,0,0,0.06);
}

/* ── Typography ────────────────────────────────────── */
.pf { font-family: 'DM Sans', sans-serif; font-size: 14px; color: var(--c-text-1); line-height: 1.6; }
.pf h1, .pf h2, .pf h3 { font-family: 'DM Serif Display', serif; font-style: italic; }

/* ── Layout ────────────────────────────────────────── */
.pf { background: var(--c-bg); padding: 40px 20px 80px; min-height: 80vh; }

.pf-header { max-width: 1000px; margin: 0 auto 28px; }
.pf-header__eyebrow { font-size: 11px; font-weight: 600; letter-spacing: 0.1em; text-transform: uppercase; color: var(--c-accent); margin-bottom: 4px; }
.pf-header__title { font-size: 28px; color: var(--c-text-1); }
.pf-header__sub { font-size: 13px; color: var(--c-text-3); margin-top: 4px; }

.pf-layout {
    max-width: 1000px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: 240px 1fr;
    gap: 20px;
    align-items: start;
}

/* ── Card ──────────────────────────────────────────── */
.pf-card {
    background: var(--c-surface);
    border-radius: var(--radius-lg);
    border: 1px solid var(--c-border);
    box-shadow: var(--shadow-card);
    overflow: hidden;
}
.pf-card + .pf-card { margin-top: 16px; }

.pf-card__header {
    padding: 16px 24px;
    border-bottom: 1px solid var(--c-border);
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.pf-card__title {
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    color: var(--c-text-3);
}
.pf-card__meta { font-size: 11px; color: var(--c-text-3); }
.pf-card__body { padding: 24px; }
.pf-card__footer {
    padding: 14px 24px;
    border-top: 1px solid var(--c-border);
    background: var(--c-surface-2);
    display: flex;
    justify-content: flex-end;
    align-items: center;
    gap: 10px;
}

/* ── Sidebar ───────────────────────────────────────── */
.pf-sidebar { position: sticky; top: 88px; }

/* Avatar */
.pf-identity {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    padding: 30px 20px 20px;
    background: linear-gradient(170deg, var(--c-accent-light) 0%, var(--c-surface) 60%);
}

.pf-avatar {
    position: relative;
    width: 84px;
    height: 84px;
    margin-bottom: 14px;
}

.pf-avatar__img {
    width: 84px;
    height: 84px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid var(--c-surface);
    box-shadow: 0 0 0 3px var(--c-accent);
    display: block;
}

.pf-avatar__initials {
    width: 84px;
    height: 84px;
    border-radius: 50%;
    background: var(--c-accent);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 26px;
    font-weight: 600;
    color: #fff;
    border: 3px solid var(--c-surface);
    box-shadow: 0 0 0 3px var(--c-accent);
    font-family: 'DM Sans', sans-serif;
}

.pf-avatar__btn {
    position: absolute;
    bottom: 1px;
    right: 1px;
    width: 24px;
    height: 24px;
    border-radius: 50%;
    background: var(--c-accent);
    border: 2px solid var(--c-surface);
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    color: #fff;
    text-decoration: none;
    transition: background 0.15s;
}
.pf-avatar__btn:hover { background: #2a57a8; }
.pf-avatar__btn svg { width: 11px; height: 11px; }

.pf-avatar__input { position: absolute; width: 1px; height: 1px; opacity: 0; overflow: hidden; clip: rect(0,0,0,0); }

.pf-identity__name {
    font-size: 17px;
    font-weight: 600;
    color: var(--c-text-1);
    margin-bottom: 5px;
}
.pf-identity__badge {
    display: inline-block;
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 0.07em;
    text-transform: uppercase;
    padding: 3px 10px;
    border-radius: 99px;
    background: var(--c-accent-light);
    color: var(--c-accent);
    margin-bottom: 5px;
}
.pf-identity__email { font-size: 11.5px; color: var(--c-text-3); word-break: break-all; }

/* Stats */
.pf-stats {
    list-style: none;
    padding: 4px 12px 14px;
}
.pf-stats__item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 7px 10px;
    border-radius: var(--radius-sm);
    transition: background 0.15s;
}
.pf-stats__item:hover { background: var(--c-surface-2); }
.pf-stats__key { font-size: 12px; color: var(--c-text-3); }
.pf-stats__val { font-size: 12.5px; font-weight: 600; color: var(--c-text-1); }

.pf-divider { height: 1px; background: var(--c-border); margin: 0 20px 12px; border: none; }

/* Sidebar Nav */
.pf-nav { list-style: none; padding: 0 10px 16px; }
.pf-nav__item { margin-bottom: 2px; }

.pf-nav__link {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 9px 12px;
    border-radius: 10px;
    font-size: 13px;
    font-weight: 500;
    color: var(--c-text-2);
    text-decoration: none;
    border: none;
    background: transparent;
    width: 100%;
    cursor: pointer;
    transition: background 0.15s, color 0.15s;
    font-family: 'DM Sans', sans-serif;
}
.pf-nav__link:hover { background: var(--c-accent-light); color: var(--c-accent); }
.pf-nav__link--danger { color: var(--c-danger); }
.pf-nav__link--danger:hover { background: var(--c-danger-light); color: var(--c-danger); }

.pf-nav__icon {
    width: 28px;
    height: 28px;
    border-radius: 7px;
    background: var(--c-surface-2);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    transition: background 0.15s;
}
.pf-nav__link:hover .pf-nav__icon { background: rgba(59,110,204,0.12); }
.pf-nav__link--danger:hover .pf-nav__icon { background: rgba(200,64,64,0.1); }
.pf-nav__icon svg { width: 14px; height: 14px; }

/* ── Alerts ────────────────────────────────────────── */
.pf-alert {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    padding: 12px 16px;
    border-radius: var(--radius-md);
    font-size: 13px;
    font-weight: 500;
}
.pf-alert--ok { background: var(--c-success-light); color: var(--c-success); border: 1px solid rgba(46,125,82,0.15); }
.pf-alert--err { background: var(--c-danger-light); color: var(--c-danger); border: 1px solid rgba(200,64,64,0.15); }
.pf-alert__icon { flex-shrink: 0; margin-top: 1px; }
.pf-alert__icon svg { width: 16px; height: 16px; }

/* ── Form ──────────────────────────────────────────── */
.pf-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
}
.pf-grid--full { grid-column: 1 / -1; }

.pf-field { display: flex; flex-direction: column; gap: 6px; }

.pf-label {
    font-size: 10.5px;
    font-weight: 700;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    color: var(--c-text-3);
}
.pf-label__req { color: var(--c-danger); margin-left: 2px; }

.pf-input, .pf-textarea {
    width: 100%;
    padding: 9px 13px;
    border: 1px solid var(--c-border);
    border-radius: var(--radius-sm);
    font-size: 13.5px;
    color: var(--c-text-1);
    background: var(--c-surface);
    outline: none;
    appearance: none;
    font-family: 'DM Sans', sans-serif;
    transition: border-color 0.15s, box-shadow 0.15s;
}
.pf-input:hover, .pf-textarea:hover { border-color: rgba(0,0,0,0.18); }
.pf-input:focus, .pf-textarea:focus {
    border-color: var(--c-border-focus);
    box-shadow: 0 0 0 3px rgba(59,110,204,0.1);
}
.pf-input--readonly {
    background: var(--c-surface-2);
    color: var(--c-text-3);
    cursor: default;
    border-color: var(--c-border);
}
.pf-input--file { cursor: pointer; padding: 7px 13px; }
.pf-textarea { resize: vertical; min-height: 80px; line-height: 1.65; }
.pf-hint { font-size: 11px; color: var(--c-text-3); }
.pf-field-err { font-size: 11px; color: var(--c-danger); }

/* ── Buttons ───────────────────────────────────────── */
.pf-btn {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 9px 20px;
    border-radius: var(--radius-sm);
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    border: none;
    text-decoration: none;
    line-height: 1;
    white-space: nowrap;
    font-family: 'DM Sans', sans-serif;
    transition: opacity 0.15s, box-shadow 0.15s, background 0.15s;
}
.pf-btn svg { width: 14px; height: 14px; }

.pf-btn--primary {
    background: var(--c-accent);
    color: #fff;
}
.pf-btn--primary:hover {
    background: #2a57a8;
    box-shadow: 0 4px 14px rgba(59,110,204,0.25);
    color: #fff;
}

.pf-btn--ghost {
    background: transparent;
    color: var(--c-text-2);
    border: 1px solid var(--c-border);
}
.pf-btn--ghost:hover {
    background: var(--c-surface-2);
    color: var(--c-text-1);
}

/* ── Content Stack ─────────────────────────────────── */
.pf-content { display: flex; flex-direction: column; gap: 16px; }

/* ── Responsive ────────────────────────────────────── */
@media (max-width: 780px) {
    .pf-layout  { grid-template-columns: 1fr; }
    .pf-sidebar { position: static; }
    .pf-grid    { grid-template-columns: 1fr; }
    .pf-grid--full { grid-column: 1; }
}
</style>
@endpush

@section('content')
<div class="pf">

    {{-- Page header --}}
    <div class="pf-header">
        <p class="pf-header__eyebrow">Akun</p>
        <h1 class="pf-header__title">Profil Saya</h1>
        <p class="pf-header__sub">Kelola informasi akun dan keamanan Anda</p>
    </div>

    <div class="pf-layout">

        {{-- ═══════════════════════════
             SIDEBAR
             ═══════════════════════════ --}}
        <aside class="pf-sidebar">
            <div class="pf-card">

                {{-- Identity & Avatar --}}
                <div class="pf-identity">
                    <div class="pf-avatar">

                        @if(Auth::user()->avatar)
                            <img src="{{ asset('storage/' . Auth::user()->avatar) }}"
                                 alt="Foto Profil"
                                 class="pf-avatar__img">
                        @else
                            <div class="pf-avatar__initials">
                                {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                            </div>
                        @endif

                        <label class="pf-avatar__btn" for="pf-avatar-input" title="Ganti foto">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                            </svg>
                        </label>

                    </div>

                    <div class="pf-identity__name">{{ Auth::user()->name }}</div>
                    <span class="pf-identity__badge">{{ ucfirst(Auth::user()->role) }}</span>
                    <div class="pf-identity__email">{{ Auth::user()->email }}</div>
                </div>

                {{-- Stats --}}
                <ul class="pf-stats">
                    <li class="pf-stats__item">
                        <span class="pf-stats__key">Bergabung</span>
                        <span class="pf-stats__val">{{ Auth::user()->created_at->translatedFormat('M Y') }}</span>
                    </li>
                    <li class="pf-stats__item">
                        <span class="pf-stats__key">Total Booking</span>
                        <span class="pf-stats__val">{{ Auth::user()->bookings()->count() }}</span>
                    </li>
                    @if(Auth::user()->phone)
                    <li class="pf-stats__item">
                        <span class="pf-stats__key">Telepon</span>
                        <span class="pf-stats__val">{{ Auth::user()->phone }}</span>
                    </li>
                    @endif
                </ul>

                <hr class="pf-divider">

                {{-- Navigation --}}
                <ul class="pf-nav">
                    <li class="pf-nav__item">
                        <a href="{{ route('bookings.history') }}" class="pf-nav__link">
                            <span class="pf-nav__icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                    <path d="M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2"/>
                                    <rect x="9" y="3" width="6" height="4" rx="2"/>
                                    <line x1="9" y1="12" x2="15" y2="12"/>
                                    <line x1="9" y1="16" x2="13" y2="16"/>
                                </svg>
                            </span>
                            Riwayat Booking
                        </a>
                    </li>
                    <li class="pf-nav__item">
                        <a href="{{ route('welcome') }}" class="pf-nav__link">
                            <span class="pf-nav__icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                    <rect x="1" y="3" width="15" height="13" rx="2"/>
                                    <path d="M16 8h4l3 5v4h-7V8z"/>
                                    <circle cx="5.5" cy="18.5" r="2.5"/>
                                    <circle cx="18.5" cy="18.5" r="2.5"/>
                                </svg>
                            </span>
                            Cari Kendaraan
                        </a>
                    </li>
                    <li class="pf-nav__item" style="margin-top: 6px;">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="pf-nav__link pf-nav__link--danger">
                                <span class="pf-nav__icon">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                                        <polyline points="16 17 21 12 16 7"/>
                                        <line x1="21" y1="12" x2="9" y2="12"/>
                                    </svg>
                                </span>
                                Logout
                            </button>
                        </form>
                    </li>
                </ul>

            </div>
        </aside>

        {{-- ═══════════════════════════
             MAIN CONTENT
             ═══════════════════════════ --}}
        <div class="pf-content">

            {{-- Flash Alerts --}}
            @if(session('success'))
            <div class="pf-alert pf-alert--ok">
                <span class="pf-alert__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <polyline points="20 6 9 17 4 12"/>
                    </svg>
                </span>
                <span>{{ session('success') }}</span>
            </div>
            @endif

            @if($errors->any())
            <div class="pf-alert pf-alert--err">
                <span class="pf-alert__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <circle cx="12" cy="12" r="10"/>
                        <line x1="12" y1="8" x2="12" y2="12"/>
                        <line x1="12" y1="16" x2="12.01" y2="16"/>
                    </svg>
                </span>
                <div>
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- ── Kartu Informasi Profil ── --}}
            <div class="pf-card">
                <div class="pf-card__header">
                    <span class="pf-card__title">Informasi Profil</span>
                    <span class="pf-card__meta">Diperbarui {{ Auth::user()->updated_at->diffForHumans() }}</span>
                </div>

                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="pf-card__body">

                        {{-- Avatar upload (linked to sidebar label) --}}
                        <div class="pf-field" style="margin-bottom: 18px;">
                            <label class="pf-label">Foto Profil</label>
                            <input id="pf-avatar-input"
                                   type="file"
                                   name="avatar"
                                   accept="image/*"
                                   class="pf-input pf-input--file">
                            <span class="pf-hint">JPG atau PNG, maksimal 2 MB. Klik Simpan untuk menerapkan.</span>
                        </div>

                        <div class="pf-grid">

                            <div class="pf-field">
                                <label class="pf-label" for="pf-name">
                                    Nama Lengkap<span class="pf-label__req">*</span>
                                </label>
                                <input type="text"
                                       id="pf-name"
                                       name="name"
                                       class="pf-input"
                                       value="{{ old('name', Auth::user()->name) }}"
                                       placeholder="Nama lengkap Anda"
                                       required>
                                @error('name')
                                    <span class="pf-field-err">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="pf-field">
                                <label class="pf-label" for="pf-phone">Nomor Telepon</label>
                                <input type="text"
                                       id="pf-phone"
                                       name="phone"
                                       class="pf-input"
                                       value="{{ old('phone', Auth::user()->phone) }}"
                                       placeholder="+62 812 3456 7890">
                                @error('phone')
                                    <span class="pf-field-err">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="pf-field pf-grid--full">
                                <label class="pf-label">Alamat Email</label>
                                <input type="email"
                                       class="pf-input pf-input--readonly"
                                       value="{{ Auth::user()->email }}"
                                       readonly
                                       tabindex="-1">
                                <span class="pf-hint">Alamat email tidak dapat diubah.</span>
                            </div>

                            <div class="pf-field pf-grid--full">
                                <label class="pf-label" for="pf-address">Alamat</label>
                                <textarea id="pf-address"
                                          name="address"
                                          class="pf-textarea"
                                          placeholder="Jl. Contoh No. 1, Kota...">{{ old('address', Auth::user()->address) }}</textarea>
                                @error('address')
                                    <span class="pf-field-err">{{ $message }}</span>
                                @enderror
                            </div>

                        </div>
                    </div>

                    <div class="pf-card__footer">
                        <a href="{{ route('profile.show') }}" class="pf-btn pf-btn--ghost">
                            Batal
                        </a>
                        <button type="submit" class="pf-btn pf-btn--primary">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/>
                                <polyline points="17 21 17 13 7 13 7 21"/>
                                <polyline points="7 3 7 8 15 8"/>
                            </svg>
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>

            {{-- ── Kartu Ubah Password ── --}}
            <div class="pf-card">
                <div class="pf-card__header">
                    <span class="pf-card__title">Ubah Password</span>
                </div>

                <form action="{{ route('profile.password') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="pf-card__body">
                        <div class="pf-grid">

                            <div class="pf-field pf-grid--full">
                                <label class="pf-label" for="pf-cur-pw">
                                    Password Saat Ini<span class="pf-label__req">*</span>
                                </label>
                                <input type="password"
                                       id="pf-cur-pw"
                                       name="current_password"
                                       class="pf-input"
                                       placeholder="Masukkan password saat ini"
                                       autocomplete="current-password">
                                @error('current_password')
                                    <span class="pf-field-err">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="pf-field">
                                <label class="pf-label" for="pf-new-pw">
                                    Password Baru<span class="pf-label__req">*</span>
                                </label>
                                <input type="password"
                                       id="pf-new-pw"
                                       name="password"
                                       class="pf-input"
                                       placeholder="Min. 8 karakter"
                                       autocomplete="new-password">
                                @error('password')
                                    <span class="pf-field-err">{{ $message }}</span>
                                @enderror
                                <span class="pf-hint">Gunakan huruf besar, angka, dan simbol.</span>
                            </div>

                            <div class="pf-field">
                                <label class="pf-label" for="pf-conf-pw">
                                    Konfirmasi Password<span class="pf-label__req">*</span>
                                </label>
                                <input type="password"
                                       id="pf-conf-pw"
                                       name="password_confirmation"
                                       class="pf-input"
                                       placeholder="Ulangi password baru"
                                       autocomplete="new-password">
                            </div>

                        </div>
                    </div>

                    <div class="pf-card__footer">
                        <button type="submit" class="pf-btn pf-btn--primary">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                            </svg>
                            Perbarui Password
                        </button>
                    </div>
                </form>
            </div>

        </div>{{-- /pf-content --}}
    </div>{{-- /pf-layout --}}
</div>{{-- /pf --}}
@endsection