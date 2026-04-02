@extends('layouts.admin')

@section('content')
<style>
* { box-sizing: border-box; }

.rs-wrap { padding: 1.5rem 2rem 2rem 2rem; font-family: inherit; max-width: 1200px; }

/* Header Card */
.rs-header-card {
    background: linear-gradient(135deg, #4f5fd5 0%, #6366f1 100%);
    border-radius: 14px;
    padding: 22px 28px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}
.rs-header-icon {
    width: 46px; height: 46px;
    background: rgba(255,255,255,0.15);
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    font-size: 20px; flex-shrink: 0;
}
.rs-header-title { font-size: 20px; font-weight: 600; color: #fff; margin: 0; }
.rs-header-sub   { font-size: 12px; color: rgba(255,255,255,0.65); margin: 3px 0 0; }
.rs-btn-back {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 8px 16px; border-radius: 8px;
    background: rgba(255,255,255,0.15); border: 1px solid rgba(255,255,255,0.3);
    color: #fff; font-size: 13px; cursor: pointer; text-decoration: none;
    transition: background 0.15s;
}
.rs-btn-back:hover { background: rgba(255,255,255,0.25); color: #fff; text-decoration: none; }

/* Grid */
.rs-grid { display: grid; grid-template-columns: 1fr 320px; gap: 20px; align-items: start; }
.rs-col  { display: flex; flex-direction: column; gap: 16px; }

/* Cards */
.rs-card {
    background: #fff;
    border: 1px solid #e9ecef;
    border-radius: 14px;
    overflow: hidden;
}
.rs-card-header {
    padding: 14px 22px;
    border-bottom: 1px solid #e9ecef;
    display: flex; align-items: center; gap: 8px;
    font-size: 12px; font-weight: 700;
    color: #6c757d; text-transform: uppercase; letter-spacing: 0.06em;
}
.rs-card-body { padding: 20px 22px; }

/* Info grid */
.rs-info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
.rs-info-label { font-size: 11px; color: #6c757d; font-weight: 600; text-transform: uppercase; letter-spacing: 0.04em; margin-bottom: 4px; }
.rs-info-val   { font-size: 14px; font-weight: 500; color: #212529; }

/* Plate */
.rs-plate {
    font-size: 12px; font-weight: 700;
    background: #f8f9fa; border: 1px solid #dee2e6;
    border-radius: 6px; padding: 3px 9px;
    font-family: monospace; letter-spacing: 0.08em;
    color: #495057; display: inline-block;
}

/* Divider */
.rs-divider { border: none; border-top: 1px solid #e9ecef; margin: 16px 0; }

/* Quote */
.rs-quote {
    background: #f8f9fa; border-left: 3px solid #6366f1;
    border-radius: 0 8px 8px 0;
    padding: 12px 14px; font-size: 13px; line-height: 1.7; color: #495057;
}

/* Notice */
.rs-notice {
    padding: 11px 14px; border-radius: 8px;
    font-size: 13px; display: flex; align-items: flex-start; gap: 8px;
}
.rs-notice-warning { background: #fef3c7; color: #92400e; border: 1px solid #fde68a; }
.rs-notice-danger  { background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }
.rs-notice-info    { background: #dbeafe; color: #1e40af; border: 1px solid #bfdbfe; }

/* Vehicle image */
.rs-vehicle-img {
    width: 100%; height: 160px; object-fit: cover;
    border-radius: 10px; border: 1px solid #e9ecef;
    display: block;
}
.rs-vehicle-fallback {
    width: 100%; height: 120px; background: #f1f3f5;
    border-radius: 10px; border: 1px solid #e9ecef;
    display: flex; align-items: center; justify-content: center;
    font-size: 40px;
}

/* Booking ref */
.rs-booking-ref {
    display: flex; align-items: center; gap: 14px;
    padding: 12px 14px; background: #f8f9ff;
    border: 1px solid #e0e7ff; border-radius: 10px;
}
.rs-booking-icon {
    width: 40px; height: 40px; border-radius: 8px;
    background: #eef2ff; display: flex; align-items: center;
    justify-content: center; font-size: 18px; flex-shrink: 0;
}

/* Form Controls */
.rs-form-group { margin-bottom: 18px; }
.rs-label {
    display: block; font-size: 11px; font-weight: 700;
    color: #495057; text-transform: uppercase; letter-spacing: 0.05em;
    margin-bottom: 7px;
}
.rs-label span.req { color: #dc2626; margin-left: 2px; }
.rs-label span.opt { color: #9ca3af; font-weight: 400; text-transform: none; letter-spacing: 0; margin-left: 4px; font-size: 11px; }

.rs-input, .rs-select, .rs-textarea {
    width: 100%; padding: 9px 12px;
    border: 1px solid #d1d5db; border-radius: 8px;
    font-size: 13px; color: #212529; background: #fff;
    transition: border-color 0.15s, box-shadow 0.15s;
    outline: none; font-family: inherit;
}
.rs-input:focus, .rs-select:focus, .rs-textarea:focus {
    border-color: #6366f1;
    box-shadow: 0 0 0 3px rgba(99,102,241,0.1);
}
.rs-input.is-invalid, .rs-select.is-invalid, .rs-textarea.is-invalid {
    border-color: #dc2626;
}
.rs-input-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
.rs-error { font-size: 11px; color: #dc2626; margin-top: 5px; }
.rs-hint  { font-size: 11px; color: #9ca3af; margin-top: 5px; }

.rs-textarea { resize: vertical; min-height: 96px; line-height: 1.6; }

/* Damage section */
.rs-damage-box {
    background: #fff1f2; border: 1px solid #fecdd3;
    border-radius: 12px; padding: 18px;
    margin-bottom: 18px;
}
.rs-damage-title {
    font-size: 12px; font-weight: 700; color: #be123c;
    text-transform: uppercase; letter-spacing: 0.05em;
    margin-bottom: 4px; display: flex; align-items: center; gap: 6px;
}
.rs-damage-sub { font-size: 12px; color: #9f1239; margin-bottom: 14px; }

/* File input */
.rs-file {
    width: 100%;
    border: 1px dashed #d1d5db; border-radius: 8px;
    padding: 12px; font-size: 13px; color: #6c757d;
    cursor: pointer; background: #fafafa;
    transition: border-color 0.15s;
}
.rs-file:hover { border-color: #6366f1; }

/* Photo preview */
.rs-photos-preview { display: flex; flex-wrap: wrap; gap: 10px; margin-top: 10px; }
.rs-photos-preview img {
    width: 80px; height: 80px; object-fit: cover;
    border-radius: 8px; border: 1px solid #e9ecef;
}

/* Financial Summary */
.rs-fin-row { display: flex; justify-content: space-between; align-items: center; padding: 8px 0; }
.rs-fin-row + .rs-fin-row { border-top: 1px solid #f1f3f5; }
.rs-fin-label { font-size: 13px; color: #6c757d; }
.rs-fin-val   { font-size: 13px; font-weight: 600; color: #212529; }
.rs-fin-sub   { font-size: 11px; color: #9ca3af; margin-top: 2px; }
.rs-fin-total {
    display: flex; justify-content: space-between; align-items: center;
    padding: 12px 0 0; border-top: 2px solid #e9ecef; margin-top: 4px;
}
.rs-fin-total-label { font-size: 14px; font-weight: 700; color: #212529; }
.rs-fin-total-val   { font-size: 20px; font-weight: 700; }

/* Action buttons */
.rs-btn-primary {
    flex: 1; padding: 12px; border-radius: 8px;
    background: #6366f1; color: #fff; border: none;
    font-size: 14px; font-weight: 600; cursor: pointer;
    display: inline-flex; align-items: center; justify-content: center; gap: 8px;
    text-decoration: none; transition: background 0.15s;
}
.rs-btn-primary:hover { background: #4f46e5; }
.rs-btn-primary:disabled { background: #a5b4fc; cursor: not-allowed; }
.rs-btn-secondary {
    padding: 12px 20px; border-radius: 8px;
    background: #f1f5f9; color: #475569; border: 1px solid #e2e8f0;
    font-size: 14px; font-weight: 600; cursor: pointer;
    display: inline-flex; align-items: center; gap: 8px;
    text-decoration: none; transition: background 0.15s;
}
.rs-btn-secondary:hover { background: #e2e8f0; color: #334155; text-decoration: none; }
.rs-btn-actions { display: flex; gap: 10px; align-items: center; }

/* Info card */
.rs-info-card {
    background: #f8f9ff; border: 1px solid #e0e7ff;
    border-radius: 14px; overflow: hidden;
}

/* Spinner */
@keyframes rs-spin { to { transform: rotate(360deg); } }
.rs-spinner {
    display: inline-block; width: 14px; height: 14px;
    border: 2px solid rgba(255,255,255,0.4);
    border-top-color: #fff; border-radius: 50%;
    animation: rs-spin 0.7s linear infinite;
}

@media (max-width: 900px) {
    .rs-grid      { grid-template-columns: 1fr; }
    .rs-input-grid { grid-template-columns: 1fr 1fr; }
}
@media (max-width: 600px) {
    .rs-wrap { padding: 1rem; }
    .rs-header-card { flex-direction: column; align-items: flex-start; gap: 12px; }
    .rs-input-grid { grid-template-columns: 1fr; }
}
</style>

<div class="rs-wrap">

    {{-- Header Card --}}
    <div class="rs-header-card">
        <div style="display:flex; align-items:center; gap:16px;">
            <div class="rs-header-icon">📋</div>
            <div>
                <p class="rs-header-sub">Pengembalian Kendaraan · Proses Inspeksi</p>
                <h4 class="rs-header-title">
                    Inspeksi Return #{{ str_pad($return->id, 6, '0', STR_PAD_LEFT) }}
                </h4>
            </div>
        </div>
        <a href="{{ route('admin.returns.index') }}" class="rs-btn-back">← Kembali</a>
    </div>

    <form action="{{ route('admin.returns.complete', $return->id) }}" method="POST"
          enctype="multipart/form-data" id="inspectForm">
        @csrf

        <div class="rs-grid">

            {{-- LEFT: Form Inspeksi --}}
            <div class="rs-col">

                {{-- Peringatan Penting --}}
                <div class="rs-notice rs-notice-warning" style="border-radius:12px;">
                    <span style="font-size:18px; flex-shrink:0;">⚠</span>
                    <div>
                        <strong style="display:block; margin-bottom:3px;">Perhatian Penting</strong>
                        Periksa kondisi kendaraan secara teliti sebelum mengisi formulir ini.
                        Seluruh informasi yang dimasukkan akan dikirimkan ke pelanggan melalui email.
                    </div>
                </div>

                {{-- Tanggal & Waktu Aktual --}}
                <div class="rs-card">
                    <div class="rs-card-header">📅 Waktu Pengembalian Aktual</div>
                    <div class="rs-card-body">
                        <div class="rs-input-grid">
                            <div class="rs-form-group" style="margin-bottom:0;">
                                <label class="rs-label" for="return_actual_date">
                                    Tanggal Aktual <span class="req">*</span>
                                </label>
                                <input type="date"
                                       class="rs-input {{ $errors->has('return_actual_date') ? 'is-invalid' : '' }}"
                                       id="return_actual_date"
                                       name="return_actual_date"
                                       value="{{ old('return_actual_date', date('Y-m-d')) }}"
                                       required>
                                @error('return_actual_date')
                                    <p class="rs-error">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="rs-form-group" style="margin-bottom:0;">
                                <label class="rs-label" for="return_actual_time">
                                    Waktu Aktual <span class="req">*</span>
                                </label>
                                <input type="time"
                                       class="rs-input {{ $errors->has('return_actual_time') ? 'is-invalid' : '' }}"
                                       id="return_actual_time"
                                       name="return_actual_time"
                                       value="{{ old('return_actual_time', date('H:i')) }}"
                                       required>
                                @error('return_actual_time')
                                    <p class="rs-error">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div id="overdueNotice" style="margin-top:12px; display:none;"></div>
                    </div>
                </div>

                {{-- Kondisi & Kerusakan --}}
                <div class="rs-card">
                    <div class="rs-card-header">🔍 Kondisi Kendaraan</div>
                    <div class="rs-card-body">

                        <div class="rs-form-group">
                            <label class="rs-label" for="condition">
                                Kondisi Saat Kembali <span class="req">*</span>
                            </label>
                            <select class="rs-select {{ $errors->has('condition') ? 'is-invalid' : '' }}"
                                    id="condition" name="condition" required>
                                <option value="">— Pilih Kondisi —</option>
                                <option value="excellent" {{ old('condition') == 'excellent' ? 'selected' : '' }}>
                                    ⭐ Sangat Baik — Seperti baru, tidak ada masalah
                                </option>
                                <option value="good" {{ old('condition', 'good') == 'good' ? 'selected' : '' }}>
                                    ✔ Baik — Keausan normal, goresan kecil masih wajar
                                </option>
                                <option value="fair" {{ old('condition') == 'fair' ? 'selected' : '' }}>
                                    ⚠ Cukup — Keausan terlihat, perlu perbaikan ringan
                                </option>
                                <option value="damaged" {{ old('condition') == 'damaged' ? 'selected' : '' }}>
                                    ✖ Rusak — Kerusakan signifikan, perlu perbaikan besar
                                </option>
                            </select>
                            @error('condition')
                                <p class="rs-error">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Seksi Kerusakan (ditampilkan jika kondisi fair/damaged) --}}
                        <div id="damageSection" style="display:none;">
                            <div class="rs-damage-box">
                                <div class="rs-damage-title">⚠ Dokumentasi Kerusakan Diperlukan</div>
                                <p class="rs-damage-sub">
                                    Harap isi detail kerusakan dan estimasi biaya perbaikan secara lengkap.
                                </p>

                                <div class="rs-form-group">
                                    <label class="rs-label" for="damage_fee">
                                        Biaya Perbaikan (Rp) <span class="req">*</span>
                                    </label>
                                    <input type="number"
                                           class="rs-input {{ $errors->has('damage_fee') ? 'is-invalid' : '' }}"
                                           id="damage_fee"
                                           name="damage_fee"
                                           value="{{ old('damage_fee', 0) }}"
                                           min="0" step="10000"
                                           placeholder="Masukkan estimasi biaya perbaikan">
                                    <p class="rs-hint">Estimasi berdasarkan kutipan dari bengkel rekanan</p>
                                    @error('damage_fee')
                                        <p class="rs-error">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="rs-form-group">
                                    <label class="rs-label" for="damage_description">
                                        Deskripsi Kerusakan <span class="req">*</span>
                                    </label>
                                    <textarea class="rs-textarea {{ $errors->has('damage_description') ? 'is-invalid' : '' }}"
                                              id="damage_description"
                                              name="damage_description"
                                              rows="5"
                                              placeholder="Jelaskan kerusakan secara detail:&#10;• Lokasi kerusakan (misal: bumper depan, pintu kiri)&#10;• Jenis kerusakan (goresan, penyok, retak, komponen lepas)&#10;• Tingkat keparahan dan ukuran&#10;• Masalah fungsional yang ditimbulkan">{{ old('damage_description') }}</textarea>
                                    @error('damage_description')
                                        <p class="rs-error">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="rs-form-group" style="margin-bottom:0;">
                                    <label class="rs-label" for="damage_photos">
                                        Foto Kerusakan <span class="opt">(Opsional, sangat disarankan)</span>
                                    </label>
                                    <input type="file"
                                           class="rs-file {{ $errors->has('damage_photos.*') ? 'is-invalid' : '' }}"
                                           id="damage_photos"
                                           name="damage_photos[]"
                                           accept="image/*" multiple>
                                    <p class="rs-hint">📷 Upload foto kerusakan yang jelas (maks. 5 foto, format JPG/PNG)</p>
                                    @error('damage_photos.*')
                                        <p class="rs-error">{{ $message }}</p>
                                    @enderror
                                    <div class="rs-photos-preview" id="photoPreview"></div>
                                </div>
                            </div>
                        </div>

                        {{-- Catatan Inspektor --}}
                        <div class="rs-form-group" style="margin-bottom:0;">
                            <label class="rs-label" for="admin_notes">
                                Catatan Inspektor <span class="opt">(Opsional)</span>
                            </label>
                            <textarea class="rs-textarea {{ $errors->has('admin_notes') ? 'is-invalid' : '' }}"
                                      id="admin_notes"
                                      name="admin_notes"
                                      rows="3"
                                      placeholder="Tambahkan catatan atau rekomendasi hasil inspeksi...">{{ old('admin_notes') }}</textarea>
                            <p class="rs-hint">💡 Catatan ini akan disertakan dalam laporan yang dikirim ke pelanggan</p>
                            @error('admin_notes')
                                <p class="rs-error">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>
                </div>

                {{-- Tombol Aksi --}}
                <div class="rs-btn-actions">
                    <button type="submit" class="rs-btn-primary" id="btnSubmit">
                        ✔ Selesaikan Inspeksi & Kirim Notifikasi
                    </button>
                    <a href="{{ route('admin.returns.index') }}" class="rs-btn-secondary">
                        ✖ Batal
                    </a>
                </div>

            </div>

            {{-- RIGHT: Informasi & Ringkasan --}}
            <div class="rs-col">

                {{-- Informasi Booking --}}
                <div class="rs-card">
                    <div class="rs-card-header">📄 Informasi Booking</div>
                    <div class="rs-card-body">

                        {{-- Gambar Kendaraan --}}
                        @if($return->booking->kendaraan->images->first())
                            <img src="{{ Storage::url($return->booking->kendaraan->images->first()->image_path) }}"
                                 alt="{{ $return->booking->kendaraan->brand }}"
                                 class="rs-vehicle-img" style="margin-bottom:14px;">
                        @else
                            <div class="rs-vehicle-fallback" style="margin-bottom:14px;">🚗</div>
                        @endif

                        {{-- Kendaraan --}}
                        <p style="font-size:16px; font-weight:600; color:#212529; margin-bottom:4px;">
                            {{ $return->booking->kendaraan->brand }} {{ $return->booking->kendaraan->model }}
                        </p>
                        <span class="rs-plate" style="margin-bottom:14px; display:inline-block;">
                            {{ $return->booking->kendaraan->plate_number }}
                        </span>

                        <hr class="rs-divider">

                        {{-- Data Booking --}}
                        <p style="font-size:11px; font-weight:700; color:#6c757d; text-transform:uppercase; letter-spacing:0.05em; margin-bottom:10px;">Detail Booking</p>
                        <div style="display:flex; flex-direction:column; gap:8px;">
                            <div style="display:flex; justify-content:space-between; font-size:13px;">
                                <span style="color:#6c757d;">Pelanggan</span>
                                <strong style="color:#212529;">{{ $return->booking->user->name }}</strong>
                            </div>
                            <div style="display:flex; justify-content:space-between; font-size:13px;">
                                <span style="color:#6c757d;">Booking</span>
                                <span style="color:#6366f1; font-family:monospace; font-weight:600;">
                                    #{{ str_pad($return->booking->id, 6, '0', STR_PAD_LEFT) }}
                                </span>
                            </div>
                            <div style="display:flex; justify-content:space-between; font-size:13px;">
                                <span style="color:#6c757d;">Mulai Sewa</span>
                                <span style="color:#212529;">{{ \Carbon\Carbon::parse($return->booking->start_date)->translatedFormat('d M Y') }}</span>
                            </div>
                            <div style="display:flex; justify-content:space-between; font-size:13px;">
                                <span style="color:#6c757d;">Batas Kembali</span>
                                <strong style="color:#dc2626;">{{ \Carbon\Carbon::parse($return->booking->end_date)->translatedFormat('d M Y') }}</strong>
                            </div>
                            <div style="display:flex; justify-content:space-between; font-size:13px;">
                                <span style="color:#6c757d;">Jadwal Kembali</span>
                                <div style="text-align:right;">
                                    <span style="color:#6366f1; font-weight:600;">{{ \Carbon\Carbon::parse($return->return_scheduled_date)->translatedFormat('d M Y') }}</span>
                                    <span style="display:block; font-size:11px; color:#9ca3af;">
                                        {{ \Carbon\Carbon::parse($return->return_scheduled_time)->format('H:i') }} WIB
                                    </span>
                                </div>
                            </div>
                        </div>

                        <hr class="rs-divider">

                        {{-- Harga --}}
                        <p style="font-size:11px; font-weight:700; color:#6c757d; text-transform:uppercase; letter-spacing:0.05em; margin-bottom:10px;">Detail Harga</p>
                        <div style="display:flex; flex-direction:column; gap:8px;">
                            <div style="display:flex; justify-content:space-between; font-size:13px;">
                                <span style="color:#6c757d;">Harga per Hari</span>
                                <span style="color:#212529; font-weight:600;">Rp {{ number_format($return->booking->kendaraan->price_per_day, 0, ',', '.') }}</span>
                            </div>
                            <div style="display:flex; justify-content:space-between; font-size:13px;">
                                <span style="color:#6c757d;">Durasi Sewa</span>
                                <span style="color:#212529; font-weight:600;">{{ $return->booking->total_days }} hari</span>
                            </div>
                            <div style="display:flex; justify-content:space-between; font-size:13px; padding-top:8px; border-top:1px solid #f1f3f5;">
                                <span style="color:#6c757d;">Total Biaya Sewa</span>
                                <span style="color:#059669; font-weight:700; font-size:15px;">Rp {{ number_format($return->booking->total_price, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        @if($return->customer_notes)
                        <hr class="rs-divider">
                        <p style="font-size:11px; font-weight:700; color:#6c757d; text-transform:uppercase; letter-spacing:0.05em; margin-bottom:8px;">Catatan Pelanggan</p>
                        <div class="rs-quote">{{ $return->customer_notes }}</div>
                        @endif

                    </div>
                </div>

                {{-- Ringkasan Denda --}}
                <div class="rs-card">
                    <div class="rs-card-header">💰 Ringkasan Perhitungan Denda</div>
                    <div class="rs-card-body">
                        <div class="rs-fin-row">
                            <div>
                                <p class="rs-fin-label">⏰ Denda Keterlambatan</p>
                                <p class="rs-fin-sub" id="lateDaysDisplay">0 hari × 20% per hari</p>
                            </div>
                            <div style="text-align:right;">
                                <span class="rs-fin-val" style="color:#92400e;">
                                    Rp <span id="lateFeeDisplay">0</span>
                                </span>
                            </div>
                        </div>
                        <div class="rs-fin-row">
                            <p class="rs-fin-label">🔧 Biaya Perbaikan</p>
                            <span class="rs-fin-val" style="color:#991b1b;">
                                Rp <span id="damageFeeDisplay">0</span>
                            </span>
                        </div>
                        <div class="rs-fin-total">
                            <span class="rs-fin-total-label">Total Denda</span>
                            <span class="rs-fin-total-val" id="totalPenaltyColor" style="color:#059669;">
                                Rp <span id="totalPenalty">0</span>
                            </span>
                        </div>
                        <hr class="rs-divider">
                        <div id="penaltyNotice" class="rs-notice rs-notice-info" style="font-size:12px;">
                            ℹ Isi formulir untuk melihat perhitungan denda secara otomatis.
                        </div>
                    </div>
                </div>

                {{-- Info --}}
                <div class="rs-info-card">
                    <div class="rs-card-body">
                        <div style="display:flex; align-items:center; gap:10px; margin-bottom:10px;">
                            <div style="width:36px; height:36px; border-radius:8px; background:#eef2ff; display:flex; align-items:center; justify-content:center; font-size:16px;">ℹ</div>
                            <span style="font-size:13px; font-weight:600; color:#212529;">Informasi</span>
                        </div>
                        <p style="font-size:12px; color:#6c757d; line-height:1.7; margin:0;">
                            Formulir ini akan menyelesaikan proses pengembalian kendaraan untuk Booking
                            <strong style="color:#6366f1;">#{{ str_pad($return->booking->id, 6, '0', STR_PAD_LEFT) }}</strong>.
                            Notifikasi hasil inspeksi akan dikirimkan ke pelanggan secara otomatis setelah proses selesai.
                        </p>
                    </div>
                </div>

            </div>
        </div>

    </form>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const actualDateInput   = document.getElementById('return_actual_date');
    const conditionSelect   = document.getElementById('condition');
    const damageSection     = document.getElementById('damageSection');
    const damageFeeInput    = document.getElementById('damage_fee');
    const damageDescInput   = document.getElementById('damage_description');
    const damagePhotosInput = document.getElementById('damage_photos');
    const inspectForm       = document.getElementById('inspectForm');

    const endDate    = new Date('{{ $return->booking->end_date }}');
    const pricePerDay = {{ $return->booking->kendaraan->price_per_day }};

    /* ---------- Toggle seksi kerusakan ---------- */
    conditionSelect.addEventListener('change', function () {
        const isDamaged = this.value === 'damaged' || this.value === 'fair';
        damageSection.style.display = isDamaged ? 'block' : 'none';
        damageDescInput.required = this.value === 'damaged';
        damageFeeInput.required  = this.value === 'damaged';
        if (!isDamaged) {
            damageFeeInput.value = 0;
        }
        updatePenalty();
    });

    /* ---------- Hitung denda keterlambatan ---------- */
    function calculateLateFee() {
        if (!actualDateInput.value) return { days: 0, fee: 0 };

        const actualDate  = new Date(actualDateInput.value);
        actualDate.setHours(0, 0, 0, 0);

        const endDateCopy = new Date(endDate);
        endDateCopy.setHours(0, 0, 0, 0);

        const diffMs   = actualDate.getTime() - endDateCopy.getTime();
        const diffDays = Math.floor(diffMs / (1000 * 60 * 60 * 24));

        if (diffDays > 0) {
            return { days: diffDays, fee: diffDays * (pricePerDay * 0.2) };
        }
        return { days: 0, fee: 0 };
    }

    /* ---------- Perbarui tampilan denda ---------- */
    function updatePenalty() {
        const lateResult   = calculateLateFee();
        const damageFee    = parseFloat(damageFeeInput.value) || 0;
        const totalPenalty = lateResult.fee + damageFee;

        document.getElementById('lateDaysDisplay').textContent =
            lateResult.days + ' hari × 20% per hari';
        document.getElementById('lateFeeDisplay').textContent =
            lateResult.fee.toLocaleString('id-ID');
        document.getElementById('damageFeeDisplay').textContent =
            damageFee.toLocaleString('id-ID');
        document.getElementById('totalPenalty').textContent =
            totalPenalty.toLocaleString('id-ID');

        const totalEl = document.getElementById('totalPenaltyColor');
        totalEl.style.color = totalPenalty > 0 ? '#dc2626' : '#059669';

        /* Notice denda */
        const noticeEl = document.getElementById('penaltyNotice');
        if (totalPenalty > 0) {
            noticeEl.className = 'rs-notice rs-notice-warning';
            noticeEl.innerHTML = '⚠ Pelanggan dikenakan denda <strong>Rp ' +
                totalPenalty.toLocaleString('id-ID') + '</strong>';
        } else if (actualDateInput.value) {
            noticeEl.className = 'rs-notice';
            noticeEl.style.background = '#d1fae5';
            noticeEl.style.color = '#065f46';
            noticeEl.style.border = '1px solid #a7f3d0';
            noticeEl.innerHTML = '✔ Tidak ada denda yang dikenakan';
        } else {
            noticeEl.className = 'rs-notice rs-notice-info';
            noticeEl.innerHTML = 'ℹ Isi formulir untuk melihat perhitungan denda secara otomatis.';
        }

        /* Notifikasi keterlambatan */
        const overdueEl = document.getElementById('overdueNotice');
        if (lateResult.days > 0) {
            overdueEl.style.display = 'block';
            overdueEl.className = 'rs-notice rs-notice-danger';
            overdueEl.innerHTML = '⚠ Terlambat <strong>' + lateResult.days +
                ' hari</strong> dari batas pengembalian.';
        } else if (actualDateInput.value) {
            overdueEl.style.display = 'block';
            overdueEl.className = 'rs-notice';
            overdueEl.style.background = '#d1fae5';
            overdueEl.style.color = '#065f46';
            overdueEl.style.border = '1px solid #a7f3d0';
            overdueEl.style.borderRadius = '8px';
            overdueEl.innerHTML = '✔ Pengembalian tepat waktu atau lebih awal.';
        } else {
            overdueEl.style.display = 'none';
        }
    }

    /* ---------- Preview foto kerusakan ---------- */
    damagePhotosInput.addEventListener('change', function (e) {
        const preview = document.getElementById('photoPreview');
        preview.innerHTML = '';
        Array.from(e.target.files).slice(0, 5).forEach(function (file) {
            const reader = new FileReader();
            reader.onload = function (ev) {
                const img = document.createElement('img');
                img.src = ev.target.result;
                preview.appendChild(img);
            };
            reader.readAsDataURL(file);
        });
    });

    /* ---------- Event listeners ---------- */
    actualDateInput.addEventListener('change', updatePenalty);
    damageFeeInput.addEventListener('input', updatePenalty);

    /* ---------- Cegah double submit ---------- */
    inspectForm.addEventListener('submit', function () {
        const btn = document.getElementById('btnSubmit');
        btn.disabled = true;
        btn.innerHTML = '<span class="rs-spinner"></span> Memproses...';
    });

    /* ---------- Inisialisasi ---------- */
    updatePenalty();
    if (conditionSelect.value === 'damaged' || conditionSelect.value === 'fair') {
        conditionSelect.dispatchEvent(new Event('change'));
    }
});
</script>
@endpush

@endsection