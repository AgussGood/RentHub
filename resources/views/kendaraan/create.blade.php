@extends('layouts.admin')

@section('content')
<style>
* { box-sizing: border-box; }

.kd-wrap { padding: 1.5rem 2rem 2rem 2rem; font-family: inherit; max-width: 1100px; }

/* ── Header Card ─────────────────────────────────────────── */
.kd-header-card {
    background: linear-gradient(135deg, #4f5fd5 0%, #6366f1 100%);
    border-radius: 14px;
    padding: 22px 28px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}
.kd-header-icon {
    width: 46px; height: 46px;
    background: rgba(255,255,255,0.15);
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    font-size: 20px; flex-shrink: 0;
}
.kd-header-title { font-size: 20px; font-weight: 600; color: #fff; margin: 0; }
.kd-header-sub   { font-size: 12px; color: rgba(255,255,255,0.65); margin: 3px 0 0; }
.kd-btn-back {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 8px 16px; border-radius: 8px;
    background: rgba(255,255,255,0.15); border: 1px solid rgba(255,255,255,0.3);
    color: #fff; font-size: 13px; cursor: pointer; text-decoration: none;
    transition: background 0.15s;
}
.kd-btn-back:hover { background: rgba(255,255,255,0.25); color: #fff; text-decoration: none; }

/* ── Grid ────────────────────────────────────────────────── */
.kd-grid { display: grid; grid-template-columns: 1fr 300px; gap: 20px; align-items: start; }
.kd-col  { display: flex; flex-direction: column; gap: 16px; }

/* ── Cards ───────────────────────────────────────────────── */
.kd-card {
    background: #fff;
    border: 1px solid #e9ecef;
    border-radius: 14px;
    overflow: hidden;
}
.kd-card-header {
    padding: 14px 22px;
    border-bottom: 1px solid #e9ecef;
    display: flex; align-items: center; gap: 8px;
    font-size: 12px; font-weight: 700;
    color: #6c757d; text-transform: uppercase; letter-spacing: 0.06em;
}
.kd-card-body { padding: 20px 22px; }

/* ── Form ────────────────────────────────────────────────── */
.kd-form-grid  { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
.kd-form-group { margin-bottom: 0; }

.kd-label {
    display: block; font-size: 11px; font-weight: 700;
    color: #495057; text-transform: uppercase; letter-spacing: 0.05em;
    margin-bottom: 7px;
}
.kd-label .req { color: #dc2626; margin-left: 2px; }
.kd-label .opt { color: #9ca3af; font-weight: 400; text-transform: none;
                  letter-spacing: 0; margin-left: 4px; font-size: 11px; }

.kd-input, .kd-select {
    width: 100%; padding: 9px 12px;
    border: 1px solid #d1d5db; border-radius: 8px;
    font-size: 13px; color: #212529; background: #fff;
    transition: border-color 0.15s, box-shadow 0.15s;
    outline: none; font-family: inherit; appearance: auto;
}
.kd-input:focus, .kd-select:focus {
    border-color: #6366f1;
    box-shadow: 0 0 0 3px rgba(99,102,241,0.1);
}
.kd-input.is-invalid, .kd-select.is-invalid {
    border-color: #dc2626;
    box-shadow: 0 0 0 3px rgba(220,38,38,0.1);
}
.kd-input.is-valid, .kd-select.is-valid {
    border-color: #059669;
    box-shadow: 0 0 0 3px rgba(5,150,105,0.1);
}
.kd-input::placeholder { color: #9ca3af; }

.kd-error { font-size: 11px; color: #dc2626; margin-top: 5px; }
.kd-hint  { font-size: 11px; color: #9ca3af; margin-top: 5px; }

/* ── Divider / section title ─────────────────────────────── */
.kd-divider { border: none; border-top: 1px solid #e9ecef; margin: 18px 0; }
.kd-section-title {
    font-size: 11px; font-weight: 700; color: #6c757d;
    text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 14px;
}

/* ── Upload zone ─────────────────────────────────────────── */
.kd-upload-zone {
    border: 2px dashed #d1d5db; border-radius: 10px;
    padding: 22px 16px; text-align: center;
    cursor: pointer; transition: border-color 0.15s, background 0.15s;
    background: #fafafa;
}
.kd-upload-zone:hover,
.kd-upload-zone.dragover { border-color: #6366f1; background: #f5f3ff; }
.kd-upload-zone.is-invalid { border-color: #dc2626; background: #fff5f5; }
.kd-upload-icon  { font-size: 28px; margin-bottom: 8px; }
.kd-upload-label { font-size: 13px; color: #6c757d; margin-bottom: 3px; }
.kd-upload-label strong { color: #6366f1; }
.kd-upload-hint  { font-size: 11px; color: #9ca3af; }
.kd-upload-btn {
    display: inline-flex; align-items: center; gap: 6px;
    margin-top: 12px; padding: 7px 16px; border-radius: 8px;
    background: #eef2ff; color: #6366f1; border: 1px solid #c7d2fe;
    font-size: 12px; font-weight: 600; cursor: pointer;
    transition: background 0.15s;
}
.kd-upload-btn:hover { background: #e0e7ff; }

/* ── Preview grid ────────────────────────────────────────── */
.kd-preview-grid {
    display: grid; grid-template-columns: repeat(4, 1fr);
    gap: 10px; margin-top: 12px;
}
.kd-preview-item { position: relative; }
.kd-preview-item img {
    width: 100%; height: 80px; object-fit: cover;
    border-radius: 9px; border: 1px solid #c7d2fe;
    display: block;
}
.kd-preview-badge {
    position: absolute; bottom: 5px; left: 5px;
    background: #6366f1; color: #fff;
    font-size: 9px; font-weight: 700;
    padding: 2px 6px; border-radius: 99px;
}
.kd-preview-main {
    position: absolute; bottom: 5px; left: 5px;
    background: #059669; color: #fff;
    font-size: 9px; font-weight: 700;
    padding: 2px 6px; border-radius: 99px;
}
.kd-preview-rm {
    position: absolute; top: 4px; right: 4px;
    width: 20px; height: 20px; border-radius: 50%;
    background: rgba(220,38,38,0.85); color: #fff;
    font-size: 10px; border: none; cursor: pointer;
    display: flex; align-items: center; justify-content: center;
}

/* ── Alert ───────────────────────────────────────────────── */
.kd-alert { padding: 12px 16px; border-radius: 8px; font-size: 13px; font-weight: 500; display: flex; align-items: flex-start; gap: 8px; margin-bottom: 16px; }
.kd-alert-success { background: #d1fae5; color: #065f46; border: 1px solid #a7f3d0; }
.kd-alert-error   { background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }
.kd-alert ul { margin: 6px 0 0 16px; padding: 0; }
.kd-alert ul li { font-size: 12px; margin-bottom: 3px; }

/* ── Preview sidebar ─────────────────────────────────────── */
.kd-preview-thumb {
    width: 100%; height: 130px; background: #f1f3f5;
    border-radius: 10px; border: 1px solid #e9ecef;
    display: flex; align-items: center; justify-content: center;
    font-size: 40px; margin-bottom: 14px; overflow: hidden;
}
.kd-preview-thumb img {
    width: 100%; height: 100%; object-fit: cover; display: block;
}

/* ── Action buttons ──────────────────────────────────────── */
.kd-btn-submit {
    flex: 1; padding: 12px; border-radius: 8px;
    background: #6366f1; color: #fff; border: none;
    font-size: 14px; font-weight: 600; cursor: pointer;
    display: inline-flex; align-items: center; justify-content: center; gap: 8px;
    transition: background 0.15s;
}
.kd-btn-submit:hover    { background: #4f46e5; }
.kd-btn-submit:disabled { background: #a5b4fc; cursor: not-allowed; }
.kd-btn-cancel {
    padding: 12px 20px; border-radius: 8px;
    background: #f1f5f9; color: #475569;
    border: 1px solid #e2e8f0; font-size: 14px; font-weight: 600;
    cursor: pointer; display: inline-flex; align-items: center; gap: 8px;
    text-decoration: none; transition: background 0.15s;
}
.kd-btn-cancel:hover { background: #e2e8f0; color: #334155; text-decoration: none; }
.kd-btn-reset {
    padding: 12px 16px; border-radius: 8px;
    background: #fff7ed; color: #c2410c;
    border: 1px solid #fed7aa; font-size: 14px; font-weight: 600;
    cursor: pointer; display: inline-flex; align-items: center; gap: 8px;
    transition: background 0.15s;
}
.kd-btn-reset:hover { background: #ffedd5; }
.kd-btn-actions { display: flex; gap: 10px; }

/* ── Info sidebar ────────────────────────────────────────── */
.kd-card-info { background: #f8f9ff; border-color: #e0e7ff; }

/* ── Spinner ─────────────────────────────────────────────── */
@keyframes kd-spin { to { transform: rotate(360deg); } }
.kd-spinner {
    display: inline-block; width: 14px; height: 14px;
    border: 2px solid rgba(255,255,255,0.35);
    border-top-color: #fff; border-radius: 50%;
    animation: kd-spin 0.7s linear infinite;
}

/* ── Plate preview ───────────────────────────────────────── */
.kd-plate {
    font-size: 13px; font-weight: 700;
    background: #f8f9fa; border: 1px solid #dee2e6;
    border-radius: 6px; padding: 3px 9px;
    font-family: monospace; letter-spacing: 0.1em;
    color: #212529; display: inline-block;
}

/* ── Tip box ─────────────────────────────────────────────── */
.kd-tip {
    background: #fefce8; border: 1px solid #fde68a;
    border-radius: 8px; padding: 10px 14px;
    font-size: 12px; color: #713f12; line-height: 1.6;
}

/* ── Responsive ──────────────────────────────────────────── */
@media (max-width: 900px) {
    .kd-grid      { grid-template-columns: 1fr; }
    .kd-form-grid { grid-template-columns: 1fr 1fr; }
}
@media (max-width: 600px) {
    .kd-wrap      { padding: 1rem; }
    .kd-header-card { flex-direction: column; align-items: flex-start; gap: 12px; }
    .kd-form-grid { grid-template-columns: 1fr; }
    .kd-preview-grid { grid-template-columns: repeat(3, 1fr); }
    .kd-btn-actions { flex-direction: column; }
}
</style>

<div class="kd-wrap">

    {{-- ── Header ─────────────────────────────────────────────── --}}
    <div class="kd-header-card">
        <div style="display:flex; align-items:center; gap:16px;">
            <div class="kd-header-icon">➕</div>
            <div>
                <p class="kd-header-sub">Manajemen Kendaraan · Tambah</p>
                <h4 class="kd-header-title">Tambah Kendaraan Baru</h4>
            </div>
        </div>
        <a href="{{ route('admin.kendaraan.index') }}" class="kd-btn-back">← Kembali</a>
    </div>

    {{-- ── Alerts ──────────────────────────────────────────────── --}}
    @if(session('success'))
        <div class="kd-alert kd-alert-success">✔ {{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="kd-alert kd-alert-error">✖ {{ session('error') }}</div>
    @endif
    @if($errors->any())
        <div class="kd-alert kd-alert-error">
            <span style="flex-shrink:0;">⚠</span>
            <div>
                <strong>Terdapat {{ $errors->count() }} kesalahan:</strong>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <form action="{{ route('admin.kendaraan.store') }}" method="POST"
          enctype="multipart/form-data" id="createForm" novalidate>
        @csrf

        <div class="kd-grid">

            {{-- ════════════════════════════════════════════════
                 KOLOM KIRI — Form
                 ════════════════════════════════════════════════ --}}
            <div class="kd-col">

                {{-- 1. Foto Kendaraan --}}
                <div class="kd-card">
                    <div class="kd-card-header">📷 Foto Kendaraan</div>
                    <div class="kd-card-body">
                        <div class="kd-upload-zone" id="uploadZone"
                             onclick="document.getElementById('images').click()"
                             ondragover="event.preventDefault(); this.classList.add('dragover')"
                             ondragleave="this.classList.remove('dragover')"
                             ondrop="handleDrop(event)">
                            <div class="kd-upload-icon">📁</div>
                            <p class="kd-upload-label">
                                <strong>Klik untuk pilih</strong> atau seret foto ke sini
                            </p>
                            <p class="kd-upload-hint">JPG, PNG, GIF · Maks. 2MB per file · Foto pertama menjadi foto utama</p>
                            <span class="kd-upload-btn">📷 Pilih Foto</span>
                        </div>
                        <input type="file" name="images[]" id="images" multiple
                               accept="image/*" style="display:none;"
                               onchange="previewImages(event)">
                        <div class="kd-preview-grid" id="imagePreview"></div>
                        @error('images.*')
                            <p class="kd-error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- 2. Informasi Dasar --}}
                <div class="kd-card">
                    <div class="kd-card-header">📋 Informasi Dasar</div>
                    <div class="kd-card-body">
                        <div class="kd-form-grid">

                            <div class="kd-form-group">
                                <label class="kd-label" for="type">
                                    Tipe Kendaraan <span class="req">*</span>
                                </label>
                                <select name="type" id="type"
                                        class="kd-select {{ $errors->has('type') ? 'is-invalid' : '' }}">
                                    <option value="">— Pilih Tipe —</option>
                                    <option value="mobil"   {{ old('type') == 'mobil'   ? 'selected' : '' }}>🚗 Mobil</option>
                                    <option value="motor"   {{ old('type') == 'motor'   ? 'selected' : '' }}>🏍 Motor</option>
                                    <option value="pickup"  {{ old('type') == 'pickup'  ? 'selected' : '' }}>🚚 Pickup</option>
                                    <option value="minibus" {{ old('type') == 'minibus' ? 'selected' : '' }}>🚌 Minibus</option>
                                </select>
                                @error('type') <p class="kd-error">{{ $message }}</p> @enderror
                            </div>

                            <div class="kd-form-group">
                                <label class="kd-label" for="brand">
                                    Merek <span class="req">*</span>
                                </label>
                                <input type="text" name="brand" id="brand"
                                       class="kd-input {{ $errors->has('brand') ? 'is-invalid' : '' }}"
                                       value="{{ old('brand') }}"
                                       placeholder="Contoh: Toyota, Honda">
                                @error('brand') <p class="kd-error">{{ $message }}</p> @enderror
                            </div>

                            <div class="kd-form-group">
                                <label class="kd-label" for="model">
                                    Model <span class="req">*</span>
                                </label>
                                <input type="text" name="model" id="model"
                                       class="kd-input {{ $errors->has('model') ? 'is-invalid' : '' }}"
                                       value="{{ old('model') }}"
                                       placeholder="Contoh: Avanza, Beat">
                                @error('model') <p class="kd-error">{{ $message }}</p> @enderror
                            </div>

                            <div class="kd-form-group">
                                <label class="kd-label" for="year">
                                    Tahun <span class="req">*</span>
                                </label>
                                <input type="number" name="year" id="year"
                                       class="kd-input {{ $errors->has('year') ? 'is-invalid' : '' }}"
                                       value="{{ old('year') }}"
                                       min="1900" max="{{ date('Y') + 1 }}"
                                       placeholder="{{ date('Y') }}">
                                @error('year') <p class="kd-error">{{ $message }}</p> @enderror
                            </div>

                            <div class="kd-form-group">
                                <label class="kd-label" for="color">
                                    Warna <span class="req">*</span>
                                </label>
                                <input type="text" name="color" id="color"
                                       class="kd-input {{ $errors->has('color') ? 'is-invalid' : '' }}"
                                       value="{{ old('color') }}"
                                       placeholder="Contoh: Putih, Hitam, Silver">
                                @error('color') <p class="kd-error">{{ $message }}</p> @enderror
                            </div>

                            <div class="kd-form-group">
                                <label class="kd-label" for="plate_number">
                                    Nomor Plat <span class="req">*</span>
                                </label>
                                <input type="text" name="plate_number" id="plate_number"
                                       class="kd-input {{ $errors->has('plate_number') ? 'is-invalid' : '' }}"
                                       value="{{ old('plate_number') }}"
                                       placeholder="Contoh: B 1234 ABC"
                                       style="font-family:monospace; font-weight:700; letter-spacing:0.08em;">
                                @error('plate_number') <p class="kd-error">{{ $message }}</p> @enderror
                            </div>

                            <div class="kd-form-group" style="grid-column: span 2;">
                                <label class="kd-label" for="price_per_day">
                                    Harga per Hari (Rp) <span class="req">*</span>
                                </label>
                                <input type="number" name="price_per_day" id="price_per_day"
                                       class="kd-input {{ $errors->has('price_per_day') ? 'is-invalid' : '' }}"
                                       value="{{ old('price_per_day') }}"
                                       min="0" step="1000"
                                       placeholder="Contoh: 300000">
                                <p class="kd-hint" id="pricePreview"></p>
                                @error('price_per_day') <p class="kd-error">{{ $message }}</p> @enderror
                            </div>

                        </div>
                    </div>
                </div>

                {{-- 3. Spesifikasi Teknis --}}
                <div class="kd-card">
                    <div class="kd-card-header">⚙ Spesifikasi Teknis</div>
                    <div class="kd-card-body">
                        <div class="kd-form-grid">

                            <div class="kd-form-group">
                                <label class="kd-label" for="fuel_type">
                                    Bahan Bakar <span class="opt">(Opsional)</span>
                                </label>
                                <select name="fuel_type" id="fuel_type" class="kd-select">
                                    <option value="">— Pilih Bahan Bakar —</option>
                                    <option value="Bensin"   {{ old('fuel_type') == 'Bensin'   ? 'selected' : '' }}>⛽ Bensin</option>
                                    <option value="Diesel"   {{ old('fuel_type') == 'Diesel'   ? 'selected' : '' }}>🛢 Diesel</option>
                                    <option value="Electric" {{ old('fuel_type') == 'Electric' ? 'selected' : '' }}>⚡ Electric</option>
                                    <option value="Hybrid"   {{ old('fuel_type') == 'Hybrid'   ? 'selected' : '' }}>🔋 Hybrid</option>
                                </select>
                            </div>

                            <div class="kd-form-group">
                                <label class="kd-label" for="transmission">
                                    Transmisi <span class="opt">(Opsional)</span>
                                </label>
                                <select name="transmission" id="transmission" class="kd-select">
                                    <option value="">— Pilih Transmisi —</option>
                                    <option value="Manual"    {{ old('transmission') == 'Manual'    ? 'selected' : '' }}>Manual</option>
                                    <option value="Automatic" {{ old('transmission') == 'Automatic' ? 'selected' : '' }}>Automatic</option>
                                    <option value="CVT"       {{ old('transmission') == 'CVT'       ? 'selected' : '' }}>CVT</option>
                                </select>
                            </div>

                            <div class="kd-form-group">
                                <label class="kd-label" for="seat_count">
                                    Jumlah Kursi <span class="opt">(Opsional)</span>
                                </label>
                                <input type="number" name="seat_count" id="seat_count"
                                       class="kd-input" value="{{ old('seat_count') }}"
                                       min="1" max="50" placeholder="Contoh: 5">
                            </div>

                            <div class="kd-form-group">
                                <label class="kd-label" for="engine_capacity">
                                    Kapasitas Mesin (cc) <span class="opt">(Opsional)</span>
                                </label>
                                <input type="number" name="engine_capacity" id="engine_capacity"
                                       class="kd-input" value="{{ old('engine_capacity') }}"
                                       min="0" placeholder="Contoh: 1500">
                            </div>

                        </div>
                    </div>
                </div>

                {{-- Tombol Aksi --}}
                <div class="kd-btn-actions">
                    <button type="submit" class="kd-btn-submit" id="btnSubmit">
                        ✔ Simpan Kendaraan
                    </button>
                    <button type="button" class="kd-btn-reset" id="btnReset">
                        ↺ Reset
                    </button>
                    <a href="{{ route('admin.kendaraan.index') }}" class="kd-btn-cancel">
                        ✖ Batal
                    </a>
                </div>

            </div>{{-- /kiri --}}


            {{-- ════════════════════════════════════════════════
                 KOLOM KANAN — Pratinjau & Panduan
                 ════════════════════════════════════════════════ --}}
            <div class="kd-col">

                {{-- Pratinjau --}}
                <div class="kd-card">
                    <div class="kd-card-header">👁 Pratinjau</div>
                    <div class="kd-card-body">

                        <div class="kd-preview-thumb" id="previewThumb">
                            <span>🚗</span>
                        </div>

                        <p style="font-size:15px; font-weight:700; color:#212529; margin:0 0 6px;" id="previewName">
                            Nama Kendaraan
                        </p>
                        <span class="kd-plate" id="previewPlate" style="color:#9ca3af; border-style:dashed;">
                            Nomor Plat
                        </span>

                        <hr style="border:none; border-top:1px solid #e9ecef; margin:14px 0;">

                        <div style="display:flex; flex-direction:column; gap:8px;">
                            <div style="display:flex; justify-content:space-between; font-size:12px;">
                                <span style="color:#6c757d;">Tipe</span>
                                <strong style="color:#212529;" id="previewType">—</strong>
                            </div>
                            <div style="display:flex; justify-content:space-between; font-size:12px;">
                                <span style="color:#6c757d;">Tahun</span>
                                <strong style="color:#212529;" id="previewYear">—</strong>
                            </div>
                            <div style="display:flex; justify-content:space-between; font-size:12px;">
                                <span style="color:#6c757d;">Warna</span>
                                <strong style="color:#212529;" id="previewColor">—</strong>
                            </div>
                            <div style="display:flex; justify-content:space-between; font-size:12px;">
                                <span style="color:#6c757d;">Transmisi</span>
                                <strong style="color:#212529;" id="previewTransmission">—</strong>
                            </div>
                            <div style="display:flex; justify-content:space-between; font-size:12px;">
                                <span style="color:#6c757d;">Bahan Bakar</span>
                                <strong style="color:#212529;" id="previewFuel">—</strong>
                            </div>
                            <div style="display:flex; justify-content:space-between; font-size:12px;">
                                <span style="color:#6c757d;">Kursi</span>
                                <strong style="color:#212529;" id="previewSeat">—</strong>
                            </div>
                            <div style="display:flex; justify-content:space-between; font-size:12px; padding-top:8px; border-top:1px solid #f1f3f5;">
                                <span style="color:#6c757d;">Harga/Hari</span>
                                <strong style="color:#6366f1; font-size:14px;" id="previewPrice">—</strong>
                            </div>
                        </div>

                    </div>
                </div>

                {{-- Panduan --}}
                <div class="kd-card">
                    <div class="kd-card-header">📌 Panduan Pengisian</div>
                    <div class="kd-card-body" style="display:flex; flex-direction:column; gap:10px;">
                        <div class="kd-tip">
                            <strong>📷 Foto:</strong> Upload minimal 1 foto. Foto pertama otomatis menjadi foto utama yang ditampilkan ke pelanggan.
                        </div>
                        <div class="kd-tip">
                            <strong>🔢 Nomor Plat:</strong> Masukkan nomor plat sesuai STNK, contoh: <code style="background:#fef08a; padding:1px 4px; border-radius:3px;">B 1234 ABC</code>
                        </div>
                        <div class="kd-tip">
                            <strong>💰 Harga:</strong> Masukkan harga dalam Rupiah tanpa titik atau koma, contoh: <code style="background:#fef08a; padding:1px 4px; border-radius:3px;">300000</code>
                        </div>
                    </div>
                </div>

                {{-- Info --}}
                <div class="kd-card kd-card-info">
                    <div class="kd-card-body">
                        <div style="display:flex; align-items:center; gap:10px; margin-bottom:10px;">
                            <div style="width:36px; height:36px; border-radius:8px; background:#eef2ff; display:flex; align-items:center; justify-content:center; font-size:16px;">ℹ</div>
                            <span style="font-size:13px; font-weight:600; color:#212529;">Informasi</span>
                        </div>
                        <p style="font-size:12px; color:#6c757d; line-height:1.7; margin:0;">
                            Kendaraan baru akan langsung masuk dengan status <strong style="color:#065f46;">Tersedia</strong> dan dapat dipesan oleh pelanggan.
                            Pastikan semua data sudah benar sebelum menyimpan.
                        </p>
                    </div>
                </div>

            </div>{{-- /kanan --}}

        </div>{{-- /kd-grid --}}
    </form>

</div>{{-- /kd-wrap --}}

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    /* ══════════════════════════════════════════════════════════
       HELPERS
       ══════════════════════════════════════════════════════════ */
    function formatRp(val) {
        return 'Rp ' + parseInt(val || 0).toLocaleString('id-ID');
    }
    function setText(id, val) {
        const el = document.getElementById(id);
        if (el) el.textContent = val || '—';
    }

    /* ══════════════════════════════════════════════════════════
       VALIDASI — RULES
       ══════════════════════════════════════════════════════════ */
    const rules = {
        type: {
            custom(val) {
                if (!val) return 'Tipe kendaraan wajib dipilih.';
                return null;
            }
        },
        brand: {
            custom(val) {
                if (!val || !val.trim()) return 'Merek kendaraan wajib diisi.';
                return null;
            }
        },
        model: {
            custom(val) {
                if (!val || !val.trim()) return 'Model kendaraan wajib diisi.';
                return null;
            }
        },
        year: {
            custom(val) {
                if (!val) return 'Tahun kendaraan wajib diisi.';
                const y = parseInt(val);
                if (isNaN(y))                            return 'Tahun harus berupa angka.';
                if (y < 1900)                            return 'Tahun tidak boleh kurang dari 1900.';
                if (y > new Date().getFullYear() + 1)    return 'Tahun tidak boleh melebihi tahun depan.';
                return null;
            }
        },
        color: {
            custom(val) {
                if (!val || !val.trim()) return 'Warna kendaraan wajib diisi.';
                return null;
            }
        },
        plate_number: {
            custom(val) {
                if (!val || !val.trim()) return 'Nomor plat kendaraan wajib diisi.';
                return null;
            }
        },
        price_per_day: {
            custom(val) {
                if (val === '' || val === null || val === undefined) return 'Harga per hari wajib diisi.';
                if (isNaN(val))           return 'Harga harus berupa angka.';
                if (parseFloat(val) < 0) return 'Harga tidak boleh negatif.';
                return null;
            }
        },
        seat_count: {
            custom(val) {
                if (!val) return null;
                if (isNaN(val) || parseInt(val) < 1)  return 'Jumlah kursi minimal 1.';
                if (parseInt(val) > 50)               return 'Jumlah kursi maksimal 50.';
                return null;
            }
        },
        engine_capacity: {
            custom(val) {
                if (!val) return null;
                if (isNaN(val) || parseFloat(val) < 0) return 'Kapasitas mesin tidak valid, harus angka positif.';
                return null;
            }
        },
    };

    /* ── Tampilkan / hapus error pada sebuah field ────────────── */
    function showFieldError(fieldName, message) {
        const el = document.querySelector('[name="' + fieldName + '"]');
        if (!el) return;

        const filled = el.value !== '' && el.value !== null;
        el.classList.toggle('is-invalid', !!message);
        el.classList.toggle('is-valid',   !message && filled);

        const group = el.closest('.kd-form-group') || el.parentElement;
        const existing = group.querySelector('.kd-error.js-error');
        if (existing) existing.remove();

        if (message) {
            const p = document.createElement('p');
            p.className = 'kd-error js-error';
            p.textContent = message;
            el.insertAdjacentElement('afterend', p);
        }
    }

    /* ── Validasi satu field, return true jika valid ──────────── */
    function validateField(name, value) {
        const rule = rules[name];
        if (!rule) return true;
        const errMsg = rule.custom ? rule.custom(value) : null;
        showFieldError(name, errMsg);
        return !errMsg;
    }

    /* ── Pasang listener blur + input untuk semua field ──────── */
    Object.keys(rules).forEach(function(name) {
        const el = document.querySelector('[name="' + name + '"]');
        if (!el) return;

        el.addEventListener('blur', function() {
            validateField(name, el.value);
        });
        el.addEventListener('input', function() {
            if (el.classList.contains('is-invalid')) {
                validateField(name, el.value);
            }
        });
        if (el.tagName === 'SELECT') {
            el.addEventListener('change', function() {
                validateField(name, el.value);
            });
        }
    });

    /* ══════════════════════════════════════════════════════════
       VALIDASI FOTO
       ══════════════════════════════════════════════════════════ */
    const MAX_FILE_SIZE  = 2 * 1024 * 1024; // 2 MB
    const ALLOWED_TYPES  = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];

    function showFotoError(message) {
        const zone      = document.getElementById('uploadZone');
        const container = zone.parentElement;

        // Hapus error lama
        const existing = container.querySelector('.kd-error.js-foto-error');
        if (existing) existing.remove();

        if (message) {
            zone.classList.add('is-invalid');
            zone.classList.remove('dragover');
            const p = document.createElement('p');
            p.className = 'kd-error js-foto-error';
            p.textContent = message;
            zone.insertAdjacentElement('afterend', p);
        } else {
            zone.classList.remove('is-invalid');
        }
    }

    function validateFoto() {
        if (newFiles.length === 0) {
            showFotoError('Foto kendaraan wajib diupload minimal 1 foto.');
            return false;
        }
        for (let i = 0; i < newFiles.length; i++) {
            const file = newFiles[i];
            if (!ALLOWED_TYPES.includes(file.type)) {
                showFotoError('File "' + file.name + '" bukan format yang valid. Gunakan JPG, PNG, atau GIF.');
                return false;
            }
            if (file.size > MAX_FILE_SIZE) {
                showFotoError('File "' + file.name + '" melebihi batas ukuran maksimal 2MB.');
                return false;
            }
        }
        showFotoError(null);
        return true;
    }

    /* ══════════════════════════════════════════════════════════
       PREVIEW FOTO
       ══════════════════════════════════════════════════════════ */
    let newFiles = [];
    const previewThumb = document.getElementById('previewThumb');

    window.previewImages = function(event) {
        newFiles = newFiles.concat(Array.from(event.target.files)).slice(0, 8);
        renderPreview();
        validateFoto();
    };

    window.handleDrop = function(event) {
        event.preventDefault();
        document.getElementById('uploadZone').classList.remove('dragover');
        const dropped = Array.from(event.dataTransfer.files).filter(function(f) {
            return f.type.startsWith('image/');
        });
        newFiles = newFiles.concat(dropped).slice(0, 8);
        renderPreview();
        validateFoto();
    };

    window.removePreview = function(idx) {
        newFiles.splice(idx, 1);
        renderPreview();
        validateFoto();
    };

    function renderPreview() {
        const container = document.getElementById('imagePreview');
        container.innerHTML = '';

        newFiles.forEach(function(file, idx) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const wrap = document.createElement('div');
                wrap.className = 'kd-preview-item';
                wrap.innerHTML =
                    '<img src="' + e.target.result + '" alt="Preview">' +
                    (idx === 0
                        ? '<span class="kd-preview-main">Utama</span>'
                        : '<span class="kd-preview-badge">Foto ' + (idx + 1) + '</span>') +
                    '<button type="button" class="kd-preview-rm" onclick="removePreview(' + idx + ')">✕</button>';
                container.appendChild(wrap);

                if (idx === 0) {
                    previewThumb.innerHTML = '<img src="' + e.target.result + '" alt="Utama">';
                }
            };
            reader.readAsDataURL(file);
        });

        if (newFiles.length === 0) {
            previewThumb.innerHTML = '<span>🚗</span>';
        }
    }

    /* ══════════════════════════════════════════════════════════
       PREVIEW REAL-TIME SIDEBAR
       ══════════════════════════════════════════════════════════ */
    const brandInput   = document.getElementById('brand');
    const modelInput   = document.getElementById('model');
    const plateInput   = document.getElementById('plate_number');
    const yearInput    = document.getElementById('year');
    const colorInput   = document.getElementById('color');
    const typeSelect   = document.getElementById('type');
    const fuelSelect   = document.getElementById('fuel_type');
    const transSelect  = document.getElementById('transmission');
    const seatInput    = document.getElementById('seat_count');
    const priceInput   = document.getElementById('price_per_day');
    const pricePreview = document.getElementById('pricePreview');
    const previewName  = document.getElementById('previewName');
    const previewPlate = document.getElementById('previewPlate');

    function updatePreview() {
        const b = brandInput.value.trim();
        const m = modelInput.value.trim();
        previewName.textContent  = (b || m) ? (b + ' ' + m).trim() : 'Nama Kendaraan';
        previewPlate.textContent = plateInput.value.trim() || 'Nomor Plat';
        previewPlate.style.color       = plateInput.value.trim() ? '#212529' : '#9ca3af';
        previewPlate.style.borderStyle = plateInput.value.trim() ? 'solid'   : 'dashed';

        setText('previewYear',         yearInput.value  || null);
        setText('previewColor',        colorInput.value || null);
        setText('previewType',         typeSelect.options[typeSelect.selectedIndex]?.text.replace(/^[^\s]+ /, '') || null);
        setText('previewFuel',         fuelSelect.value  || null);
        setText('previewTransmission', transSelect.value || null);
        setText('previewSeat',         seatInput.value ? seatInput.value + ' orang' : null);

        if (priceInput.value) {
            document.getElementById('previewPrice').textContent = formatRp(priceInput.value);
            pricePreview.textContent = '= ' + formatRp(priceInput.value) + ' / hari';
        } else {
            document.getElementById('previewPrice').textContent = '—';
            pricePreview.textContent = '';
        }
    }

    [brandInput, modelInput, plateInput, yearInput, colorInput,
     typeSelect, fuelSelect, transSelect, seatInput, priceInput]
        .forEach(function(el) { if (el) el.addEventListener('input', updatePreview); });

    /* ══════════════════════════════════════════════════════════
       SUBMIT — VALIDASI SEMUA SEBELUM KIRIM
       ══════════════════════════════════════════════════════════ */
    document.getElementById('createForm').addEventListener('submit', function(e) {
        let formValid = true;

        // 1. Validasi foto
        if (!validateFoto()) formValid = false;

        // 2. Validasi semua field
        Object.keys(rules).forEach(function(name) {
            const el = document.querySelector('[name="' + name + '"]');
            if (el && !validateField(name, el.value)) {
                formValid = false;
            }
        });

        if (!formValid) {
            e.preventDefault();
            // Scroll ke error pertama
            const firstErr = document.querySelector('.js-foto-error, .is-invalid');
            if (firstErr) firstErr.scrollIntoView({ behavior: 'smooth', block: 'center' });
            return;
        }

        // Cegah double submit
        const btn = document.getElementById('btnSubmit');
        btn.disabled = true;
        btn.innerHTML = '<span class="kd-spinner"></span> Menyimpan...';
    });

    /* ══════════════════════════════════════════════════════════
       RESET FORM
       ══════════════════════════════════════════════════════════ */
    document.getElementById('btnReset').addEventListener('click', function() {
        if (!confirm('Reset semua data yang sudah diisi?')) return;

        document.getElementById('createForm').reset();
        newFiles = [];
        document.getElementById('imagePreview').innerHTML = '';
        document.getElementById('images').value = '';
        previewThumb.innerHTML = '<span>🚗</span>';

        // Reset preview sidebar
        previewName.textContent  = 'Nama Kendaraan';
        previewPlate.textContent = 'Nomor Plat';
        previewPlate.style.color       = '#9ca3af';
        previewPlate.style.borderStyle = 'dashed';
        ['previewYear','previewColor','previewType','previewFuel',
         'previewTransmission','previewSeat','previewPrice'].forEach(function(id) {
            setText(id, null);
        });
        pricePreview.textContent = '';

        // Bersihkan semua status validasi
        document.querySelectorAll('.kd-input, .kd-select').forEach(function(el) {
            el.classList.remove('is-valid', 'is-invalid');
        });
        document.querySelectorAll('.kd-error.js-error, .kd-error.js-foto-error').forEach(function(el) {
            el.remove();
        });
        document.getElementById('uploadZone').classList.remove('is-invalid');
    });

    /* ══════════════════════════════════════════════════════════
       AUTO DISMISS ALERTS
       ══════════════════════════════════════════════════════════ */
    @if(session('success') || session('error'))
    setTimeout(function() {
        document.querySelectorAll('.kd-alert').forEach(function(el) {
            el.style.transition = 'opacity 0.5s';
            el.style.opacity    = '0';
            setTimeout(function() { el.remove(); }, 500);
        });
    }, 5000);
    @endif

    /* ── Bersihkan form setelah sukses ──────────────────────── */
    @if(session('success'))
    document.getElementById('createForm').reset();
    document.getElementById('imagePreview').innerHTML = '';
    document.getElementById('images').value = '';
    @endif

});
</script>
@endpush

@endsection