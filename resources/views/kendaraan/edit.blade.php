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
.kd-form-grid   { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
.kd-form-group  { margin-bottom: 0; }

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
.kd-input.is-invalid, .kd-select.is-invalid { border-color: #dc2626; }
.kd-input[readonly] { background: #f8f9fa; color: #6c757d; cursor: default; }

.kd-error { font-size: 11px; color: #dc2626; margin-top: 5px; }
.kd-hint  { font-size: 11px; color: #9ca3af; margin-top: 5px; }

/* ── Divider ─────────────────────────────────────────────── */
.kd-divider { border: none; border-top: 1px solid #e9ecef; margin: 18px 0; }
.kd-section-title {
    font-size: 11px; font-weight: 700; color: #6c757d;
    text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 14px;
}

/* ── Photo grid (existing) ───────────────────────────────── */
.kd-photo-grid {
    display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px;
}
.kd-photo-item { position: relative; border-radius: 9px; overflow: hidden; }
.kd-photo-item img {
    width: 100%; height: 80px; object-fit: cover; display: block;
    border: 1px solid #e9ecef; border-radius: 9px;
    transition: transform 0.15s;
}
.kd-photo-item:hover img { transform: scale(1.04); }
.kd-photo-primary {
    position: absolute; bottom: 5px; left: 5px;
    background: #6366f1; color: #fff;
    font-size: 9px; font-weight: 700; padding: 2px 6px;
    border-radius: 99px; letter-spacing: 0.04em;
}
.kd-photo-del {
    position: absolute; top: 4px; right: 4px;
    width: 20px; height: 20px; border-radius: 50%;
    background: rgba(220,38,38,0.85); color: #fff;
    font-size: 10px; border: none; cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    opacity: 0; transition: opacity 0.15s;
}
.kd-photo-item:hover .kd-photo-del { opacity: 1; }

/* ── Upload zone ─────────────────────────────────────────── */
.kd-upload-zone {
    border: 2px dashed #d1d5db; border-radius: 10px;
    padding: 22px 16px; text-align: center;
    cursor: pointer; transition: border-color 0.15s, background 0.15s;
    background: #fafafa;
}
.kd-upload-zone:hover,
.kd-upload-zone.dragover { border-color: #6366f1; background: #f5f3ff; }
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

/* Preview new uploads */
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
.kd-preview-rm {
    position: absolute; top: 4px; right: 4px;
    width: 20px; height: 20px; border-radius: 50%;
    background: rgba(220,38,38,0.85); color: #fff;
    font-size: 10px; border: none; cursor: pointer;
    display: flex; align-items: center; justify-content: center;
}

/* ── Status badge ────────────────────────────────────────── */
.kd-badge {
    display: inline-flex; align-items: center; gap: 4px;
    padding: 5px 12px; border-radius: 99px;
    font-size: 12px; font-weight: 600;
}
.kd-badge-available   { background: #d1fae5; color: #065f46; }
.kd-badge-rented      { background: #dbeafe; color: #1e40af; }
.kd-badge-maintenance { background: #fef3c7; color: #92400e; }

/* ── Plate ───────────────────────────────────────────────── */
.kd-plate {
    font-size: 14px; font-weight: 700;
    background: #f8f9fa; border: 1px solid #dee2e6;
    border-radius: 6px; padding: 4px 10px;
    font-family: monospace; letter-spacing: 0.1em;
    color: #212529; display: inline-block;
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

/* ── Responsive ──────────────────────────────────────────── */
@media (max-width: 900px) {
    .kd-grid     { grid-template-columns: 1fr; }
    .kd-form-grid { grid-template-columns: 1fr 1fr; }
}
@media (max-width: 600px) {
    .kd-wrap      { padding: 1rem; }
    .kd-header-card { flex-direction: column; align-items: flex-start; gap: 12px; }
    .kd-form-grid { grid-template-columns: 1fr; }
    .kd-photo-grid, .kd-preview-grid { grid-template-columns: repeat(3, 1fr); }
    .kd-btn-actions { flex-direction: column; }
}
</style>

<div class="kd-wrap">

    {{-- ── Header ──────────────────────────────────────────── --}}
    <div class="kd-header-card">
        <div style="display:flex; align-items:center; gap:16px;">
            <div class="kd-header-icon">✏</div>
            <div>
                <p class="kd-header-sub">Manajemen Kendaraan · Edit</p>
                <h4 class="kd-header-title">Edit Kendaraan</h4>
            </div>
        </div>
        <a href="{{ route('admin.kendaraan.index') }}" class="kd-btn-back">← Kembali</a>
    </div>

    <form action="{{ route('admin.kendaraan.update', $kendaraan->id) }}" method="POST"
          enctype="multipart/form-data" id="editForm">
        @csrf
        @method('PUT')

        <div class="kd-grid">

            {{-- ════════════════════════════════════════════════
                 KOLOM KIRI — Form
                 ════════════════════════════════════════════════ --}}
            <div class="kd-col">

                {{-- 1. Foto Kendaraan --}}
                <div class="kd-card">
                    <div class="kd-card-header">📷 Foto Kendaraan</div>
                    <div class="kd-card-body">

                        {{-- Foto yang sudah ada --}}
                        @if($kendaraan->images->count() > 0)
                            <p class="kd-section-title">Foto Saat Ini</p>
                            <div class="kd-photo-grid" style="margin-bottom:18px;">
                                @foreach($kendaraan->images as $image)
                                <div class="kd-photo-item">
                                    <img src="{{ asset('storage/' . $image->image_path) }}"
                                         alt="Foto kendaraan"
                                         onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22100%22 height=%22100%22%3E%3Crect fill=%22%23f0f0f0%22 width=%22100%22 height=%22100%22/%3E%3C/svg%3E'">
                                    @if($image->is_primary)
                                        <span class="kd-photo-primary">Utama</span>
                                    @endif
                                    <button type="button" class="kd-photo-del"
                                            onclick="deleteImage({{ $image->id }}, this)"
                                            title="Hapus foto">✕</button>
                                </div>
                                @endforeach
                            </div>
                            <hr class="kd-divider" style="margin-top:0;">
                        @endif

                        {{-- Upload foto baru --}}
                        <p class="kd-section-title" style="{{ $kendaraan->images->count() > 0 ? '' : 'margin-top:0;' }}">
                            Tambah Foto Baru
                        </p>
                        <div class="kd-upload-zone" id="uploadZone"
                             onclick="document.getElementById('images').click()"
                             ondragover="event.preventDefault(); this.classList.add('dragover')"
                             ondragleave="this.classList.remove('dragover')"
                             ondrop="handleDrop(event)">
                            <div class="kd-upload-icon">📁</div>
                            <p class="kd-upload-label">
                                <strong>Klik untuk pilih</strong> atau seret foto ke sini
                            </p>
                            <p class="kd-upload-hint">JPG, PNG, GIF · Maks. 2MB per file</p>
                            <span class="kd-upload-btn">📷 Pilih Foto</span>
                        </div>
                        <input type="file" name="images[]" id="images" multiple
                               accept="image/*" style="display:none;"
                               onchange="previewImages(event)">

                        <div class="kd-preview-grid" id="imagePreview"></div>

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
                                        class="kd-select {{ $errors->has('type') ? 'is-invalid' : '' }}" required>
                                    <option value="">— Pilih Tipe —</option>
                                    <option value="mobil"  {{ old('type', $kendaraan->type) == 'mobil'  ? 'selected' : '' }}>🚗 Mobil</option>
                                    <option value="motor"  {{ old('type', $kendaraan->type) == 'motor'  ? 'selected' : '' }}>🏍 Motor</option>
                                    <option value="pickup" {{ old('type', $kendaraan->type) == 'pickup' ? 'selected' : '' }}>🚚 Pickup</option>
                                    <option value="minibus"{{ old('type', $kendaraan->type) == 'minibus'? 'selected' : '' }}>🚌 Minibus</option>
                                </select>
                                @error('type') <p class="kd-error">{{ $message }}</p> @enderror
                            </div>

                            <div class="kd-form-group">
                                <label class="kd-label" for="status">
                                    Status <span class="req">*</span>
                                </label>
                                <select name="status" id="status" class="kd-select" required>
                                    <option value="available"   {{ old('status', $kendaraan->status) == 'available'   ? 'selected' : '' }}>✔ Tersedia</option>
                                    <option value="rented"      {{ old('status', $kendaraan->status) == 'rented'      ? 'selected' : '' }}>🔑 Disewa</option>
                                    <option value="maintenance" {{ old('status', $kendaraan->status) == 'maintenance' ? 'selected' : '' }}>🔧 Maintenance</option>
                                </select>
                            </div>

                            <div class="kd-form-group">
                                <label class="kd-label" for="brand">
                                    Merek <span class="req">*</span>
                                </label>
                                <input type="text" name="brand" id="brand"
                                       class="kd-input {{ $errors->has('brand') ? 'is-invalid' : '' }}"
                                       value="{{ old('brand', $kendaraan->brand) }}"
                                       placeholder="Contoh: Toyota, Honda" required>
                                @error('brand') <p class="kd-error">{{ $message }}</p> @enderror
                            </div>

                            <div class="kd-form-group">
                                <label class="kd-label" for="model">
                                    Model <span class="req">*</span>
                                </label>
                                <input type="text" name="model" id="model"
                                       class="kd-input {{ $errors->has('model') ? 'is-invalid' : '' }}"
                                       value="{{ old('model', $kendaraan->model) }}"
                                       placeholder="Contoh: Avanza, Beat" required>
                                @error('model') <p class="kd-error">{{ $message }}</p> @enderror
                            </div>

                            <div class="kd-form-group">
                                <label class="kd-label" for="year">
                                    Tahun <span class="req">*</span>
                                </label>
                                <input type="number" name="year" id="year"
                                       class="kd-input {{ $errors->has('year') ? 'is-invalid' : '' }}"
                                       value="{{ old('year', $kendaraan->year) }}"
                                       min="1900" max="{{ date('Y') + 1 }}" required>
                                @error('year') <p class="kd-error">{{ $message }}</p> @enderror
                            </div>

                            <div class="kd-form-group">
                                <label class="kd-label" for="color">
                                    Warna <span class="req">*</span>
                                </label>
                                <input type="text" name="color" id="color"
                                       class="kd-input {{ $errors->has('color') ? 'is-invalid' : '' }}"
                                       value="{{ old('color', $kendaraan->color) }}"
                                       placeholder="Contoh: Putih, Hitam, Silver" required>
                                @error('color') <p class="kd-error">{{ $message }}</p> @enderror
                            </div>

                            <div class="kd-form-group">
                                <label class="kd-label" for="plate_number">
                                    Nomor Plat <span class="req">*</span>
                                </label>
                                <input type="text" name="plate_number" id="plate_number"
                                       class="kd-input {{ $errors->has('plate_number') ? 'is-invalid' : '' }}"
                                       value="{{ old('plate_number', $kendaraan->plate_number) }}"
                                       placeholder="Contoh: B 1234 ABC"
                                       style="font-family:monospace; font-weight:700; letter-spacing:0.08em;"
                                       required>
                                @error('plate_number') <p class="kd-error">{{ $message }}</p> @enderror
                            </div>

                            <div class="kd-form-group">
                                <label class="kd-label" for="price_per_day">
                                    Harga per Hari (Rp) <span class="req">*</span>
                                </label>
                                <input type="number" name="price_per_day" id="price_per_day"
                                       class="kd-input {{ $errors->has('price_per_day') ? 'is-invalid' : '' }}"
                                       value="{{ old('price_per_day', $kendaraan->price_per_day) }}"
                                       min="0" step="1000" placeholder="Contoh: 300000" required>
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
                                    <option value="Bensin"   {{ old('fuel_type', $kendaraan->detail->fuel_type ?? '') == 'Bensin'   ? 'selected' : '' }}>⛽ Bensin</option>
                                    <option value="Diesel"   {{ old('fuel_type', $kendaraan->detail->fuel_type ?? '') == 'Diesel'   ? 'selected' : '' }}>🛢 Diesel</option>
                                    <option value="Electric" {{ old('fuel_type', $kendaraan->detail->fuel_type ?? '') == 'Electric' ? 'selected' : '' }}>⚡ Electric</option>
                                    <option value="Hybrid"   {{ old('fuel_type', $kendaraan->detail->fuel_type ?? '') == 'Hybrid'   ? 'selected' : '' }}>🔋 Hybrid</option>
                                </select>
                            </div>

                            <div class="kd-form-group">
                                <label class="kd-label" for="transmission">
                                    Transmisi <span class="opt">(Opsional)</span>
                                </label>
                                <select name="transmission" id="transmission" class="kd-select">
                                    <option value="">— Pilih Transmisi —</option>
                                    <option value="Manual"    {{ old('transmission', $kendaraan->detail->transmission ?? '') == 'Manual'    ? 'selected' : '' }}>Manual</option>
                                    <option value="Automatic" {{ old('transmission', $kendaraan->detail->transmission ?? '') == 'Automatic' ? 'selected' : '' }}>Automatic</option>
                                    <option value="CVT"       {{ old('transmission', $kendaraan->detail->transmission ?? '') == 'CVT'       ? 'selected' : '' }}>CVT</option>
                                </select>
                            </div>

                            <div class="kd-form-group">
                                <label class="kd-label" for="seat_count">
                                    Jumlah Kursi <span class="opt">(Opsional)</span>
                                </label>
                                <input type="number" name="seat_count" id="seat_count"
                                       class="kd-input"
                                       value="{{ old('seat_count', $kendaraan->detail->seat_count ?? '') }}"
                                       min="1" max="50" placeholder="Contoh: 5">
                            </div>

                            <div class="kd-form-group">
                                <label class="kd-label" for="engine_capacity">
                                    Kapasitas Mesin (cc) <span class="opt">(Opsional)</span>
                                </label>
                                <input type="number" name="engine_capacity" id="engine_capacity"
                                       class="kd-input"
                                       value="{{ old('engine_capacity', $kendaraan->detail->engine_capacity ?? '') }}"
                                       min="0" placeholder="Contoh: 1500">
                            </div>

                        </div>
                    </div>
                </div>

                {{-- Tombol Aksi --}}
                <div class="kd-btn-actions">
                    <button type="submit" class="kd-btn-submit" id="btnSubmit">
                        ✔ Simpan Perubahan
                    </button>
                    <a href="{{ route('admin.kendaraan.index') }}" class="kd-btn-cancel">
                        ✖ Batal
                    </a>
                </div>

            </div>{{-- /kiri --}}


            {{-- ════════════════════════════════════════════════
                 KOLOM KANAN — Pratinjau & Info
                 ════════════════════════════════════════════════ --}}
            <div class="kd-col">

                {{-- Pratinjau Kendaraan --}}
                <div class="kd-card">
                    <div class="kd-card-header">👁 Pratinjau</div>
                    <div class="kd-card-body">

                        @if($kendaraan->images->first())
                            <img src="{{ asset('storage/' . $kendaraan->images->first()->image_path) }}"
                                 alt="{{ $kendaraan->brand }}"
                                 style="width:100%; height:140px; object-fit:cover; border-radius:10px; border:1px solid #e9ecef; margin-bottom:14px; display:block;">
                        @else
                            <div style="width:100%; height:100px; background:#f1f3f5; border-radius:10px; border:1px solid #e9ecef; display:flex; align-items:center; justify-content:center; font-size:40px; margin-bottom:14px;">🚗</div>
                        @endif

                        <p style="font-size:15px; font-weight:700; color:#212529; margin:0 0 6px;" id="previewName">
                            {{ $kendaraan->brand }} {{ $kendaraan->model }}
                        </p>
                        <span class="kd-plate" id="previewPlate">
                            {{ $kendaraan->plate_number }}
                        </span>

                        <hr style="border:none; border-top:1px solid #e9ecef; margin:14px 0;">

                        {{-- Status saat ini --}}
                        <p style="font-size:11px; font-weight:700; color:#6c757d; text-transform:uppercase; letter-spacing:0.04em; margin-bottom:8px;">Status Saat Ini</p>
                        @php
                            $statusBadge = [
                                'available'   => ['class' => 'kd-badge-available',   'label' => '✔ Tersedia'],
                                'rented'      => ['class' => 'kd-badge-rented',      'label' => '🔑 Disewa'],
                                'maintenance' => ['class' => 'kd-badge-maintenance', 'label' => '🔧 Maintenance'],
                            ];
                            $sb = $statusBadge[$kendaraan->status] ?? $statusBadge['available'];
                        @endphp
                        <span class="kd-badge {{ $sb['class'] }}">{{ $sb['label'] }}</span>

                        <hr style="border:none; border-top:1px solid #e9ecef; margin:14px 0;">

                        {{-- Detail --}}
                        <div style="display:flex; flex-direction:column; gap:8px;">
                            <div style="display:flex; justify-content:space-between; font-size:12px;">
                                <span style="color:#6c757d;">Tahun</span>
                                <strong style="color:#212529;">{{ $kendaraan->year }}</strong>
                            </div>
                            <div style="display:flex; justify-content:space-between; font-size:12px;">
                                <span style="color:#6c757d;">Warna</span>
                                <strong style="color:#212529;">{{ $kendaraan->color }}</strong>
                            </div>
                            @if($kendaraan->detail)
                            <div style="display:flex; justify-content:space-between; font-size:12px;">
                                <span style="color:#6c757d;">Transmisi</span>
                                <strong style="color:#212529;">{{ $kendaraan->detail->transmission ?? '—' }}</strong>
                            </div>
                            <div style="display:flex; justify-content:space-between; font-size:12px;">
                                <span style="color:#6c757d;">Bahan Bakar</span>
                                <strong style="color:#212529;">{{ $kendaraan->detail->fuel_type ?? '—' }}</strong>
                            </div>
                            <div style="display:flex; justify-content:space-between; font-size:12px;">
                                <span style="color:#6c757d;">Kursi</span>
                                <strong style="color:#212529;">{{ $kendaraan->detail->seat_count ?? '—' }} orang</strong>
                            </div>
                            @endif
                            <div style="display:flex; justify-content:space-between; font-size:12px; padding-top:8px; border-top:1px solid #f1f3f5;">
                                <span style="color:#6c757d;">Harga/Hari</span>
                                <strong style="color:#6366f1; font-size:14px;">
                                    Rp {{ number_format($kendaraan->price_per_day, 0, ',', '.') }}
                                </strong>
                            </div>
                        </div>

                    </div>
                </div>

                {{-- Statistik Booking --}}
                @if($kendaraan->bookings_count ?? false)
                <div class="kd-card">
                    <div class="kd-card-header">📊 Statistik</div>
                    <div class="kd-card-body">
                        <div style="display:flex; justify-content:space-between; font-size:13px; padding:6px 0;">
                            <span style="color:#6c757d;">Total Booking</span>
                            <strong style="color:#212529;">{{ $kendaraan->bookings_count }}</strong>
                        </div>
                    </div>
                </div>
                @endif

                {{-- Info --}}
                <div class="kd-card kd-card-info">
                    <div class="kd-card-body">
                        <div style="display:flex; align-items:center; gap:10px; margin-bottom:10px;">
                            <div style="width:36px; height:36px; border-radius:8px; background:#eef2ff; display:flex; align-items:center; justify-content:center; font-size:16px;">ℹ</div>
                            <span style="font-size:13px; font-weight:600; color:#212529;">Informasi</span>
                        </div>
                        <p style="font-size:12px; color:#6c757d; line-height:1.7; margin:0;">
                            Perubahan status kendaraan akan langsung berpengaruh pada ketersediaan di halaman pemesanan pelanggan.
                            Pastikan data yang diisi sudah benar sebelum menyimpan.
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

    /* ── Preview harga real-time ────────────────────────────── */
    const priceInput   = document.getElementById('price_per_day');
    const pricePreview = document.getElementById('pricePreview');

    function formatRp(val) {
        return 'Rp ' + parseInt(val || 0).toLocaleString('id-ID');
    }

    priceInput.addEventListener('input', function () {
        pricePreview.textContent = this.value
            ? '= ' + formatRp(this.value) + ' / hari'
            : '';
    });

    /* ── Preview nama kendaraan real-time ───────────────────── */
    const brandInput   = document.getElementById('brand');
    const modelInput   = document.getElementById('model');
    const plateInput   = document.getElementById('plate_number');
    const previewName  = document.getElementById('previewName');
    const previewPlate = document.getElementById('previewPlate');

    function updatePreview() {
        const b = brandInput.value.trim();
        const m = modelInput.value.trim();
        previewName.textContent  = (b || m) ? (b + ' ' + m).trim() : '{{ $kendaraan->brand }} {{ $kendaraan->model }}';
        previewPlate.textContent = plateInput.value.trim() || '{{ $kendaraan->plate_number }}';
    }
    brandInput.addEventListener('input', updatePreview);
    modelInput.addEventListener('input', updatePreview);
    plateInput.addEventListener('input', updatePreview);

    /* ── Preview foto baru ──────────────────────────────────── */
    let newFiles = [];

    window.previewImages = function (event) {
        newFiles = newFiles.concat(Array.from(event.target.files)).slice(0, 6);
        renderPreview();
    };

    window.handleDrop = function (event) {
        event.preventDefault();
        document.getElementById('uploadZone').classList.remove('dragover');
        const dropped = Array.from(event.dataTransfer.files).filter(f => f.type.startsWith('image/'));
        newFiles = newFiles.concat(dropped).slice(0, 6);
        renderPreview();
    };

    function renderPreview() {
        const container = document.getElementById('imagePreview');
        container.innerHTML = '';
        newFiles.forEach(function (file, idx) {
            const reader = new FileReader();
            reader.onload = function (e) {
                const wrap = document.createElement('div');
                wrap.className = 'kd-preview-item';
                wrap.innerHTML =
                    '<img src="' + e.target.result + '" alt="Preview">' +
                    '<span class="kd-preview-badge">Baru</span>' +
                    '<button type="button" class="kd-preview-rm" onclick="removePreview(' + idx + ')">✕</button>';
                container.appendChild(wrap);
            };
            reader.readAsDataURL(file);
        });
    }

    window.removePreview = function (idx) {
        newFiles.splice(idx, 1);
        renderPreview();
    };

    /* ── Hapus foto existing ────────────────────────────────── */
    window.deleteImage = function (imageId, btn) {
        if (!confirm('Yakin ingin menghapus foto ini?')) return;
        const wrap = btn.closest('.kd-photo-item');

        fetch('/admin/kendaraan/image/' + imageId, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                wrap.style.transition = 'opacity 0.3s';
                wrap.style.opacity = '0';
                setTimeout(() => wrap.remove(), 300);
            } else {
                alert('Gagal menghapus foto.');
            }
        })
        .catch(() => alert('Terjadi kesalahan saat menghapus foto.'));
    };

    /* ── Cegah double submit ────────────────────────────────── */
    document.getElementById('editForm').addEventListener('submit', function () {
        const btn = document.getElementById('btnSubmit');
        btn.disabled = true;
        btn.innerHTML = '<span class="kd-spinner"></span> Menyimpan...';
    });
});
</script>
@endpush

@endsection