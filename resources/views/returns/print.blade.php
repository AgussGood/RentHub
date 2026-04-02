{{--
    View   : resources/views/returns/print.blade.php
    Route  : Route::get('/returns/{return}/print', [ReturnController::class, 'print'])
             ->name('returns.print')
    CSS    : public/css/return-print.css
--}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bukti Pengembalian #{{ str_pad($return->id, 6, '0', STR_PAD_LEFT) }}</title>
    <link rel="stylesheet" href="{{ asset('css/return-print.css') }}">
</head>
<body>

    {{-- ── Tombol Aksi (hanya tampil di layar) ─────────────── --}}
    <div class="print-actions no-print">
        <a href="{{ url()->previous() }}" class="btn-back">← Kembali</a>

        <button onclick="window.print()" class="btn-print">🖨 Cetak / Simpan PDF</button>

        @if($return->status === 'completed' && $return->total_penalty > 0 && !$return->penalty_paid)
            <a href="{{ route('payments.penalty.create', $return->id) }}" class="btn-pay">
                💳 Bayar Denda
            </a>
        @endif
    </div>

    {{-- ── Banner Status (hanya di layar) ─────────────────── --}}
    @if($return->status === 'completed')
        @if($return->total_penalty > 0 && !$return->penalty_paid)
            <div class="status-banner status-danger no-print">
                <span class="status-icon">⚠</span>
                <div>
                    <strong>Menunggu Pembayaran Denda</strong> —
                    Total denda: Rp {{ number_format($return->total_penalty, 0, ',', '.') }}
                </div>
            </div>
        @elseif($return->total_penalty > 0 && $return->penalty_paid)
            <div class="status-banner status-success no-print">
                <span class="status-icon">✔</span>
                <div>
                    <strong>Transaksi Selesai!</strong> —
                    Pengembalian dan denda lunas pada
                    {{ \Carbon\Carbon::parse($return->inspected_at)->isoFormat('D MMM Y, HH:mm') }}
                </div>
            </div>
        @else
            <div class="status-banner status-success no-print">
                <span class="status-icon">✔</span>
                <div>
                    <strong>Pengembalian Selesai</strong> —
                    Selesai pada {{ \Carbon\Carbon::parse($return->inspected_at)->isoFormat('D MMM Y, HH:mm') }}
                </div>
            </div>
        @endif
    @else
        <div class="status-banner status-warning no-print">
            <span class="status-icon">⏳</span>
            <div>
                <strong>Menunggu Inspeksi</strong> —
                Dijadwalkan: {{ \Carbon\Carbon::parse($return->return_scheduled_date)->isoFormat('D MMM Y') }}
            </div>
        </div>
    @endif

    {{-- ══════════════════════════════════════════════════════════
         HALAMAN CETAK
         ══════════════════════════════════════════════════════════ --}}
    <div class="print-page">

        {{-- Watermark status --}}
        <div class="stamp-wrap">
            @if($return->status === 'completed' && ($return->total_penalty == 0 || $return->penalty_paid))
                <div class="stamp-text stamp-lunas">LUNAS</div>
            @elseif($return->status === 'completed' && $return->total_penalty > 0 && !$return->penalty_paid)
                <div class="stamp-text stamp-denda">DENDA</div>
            @else
                <div class="stamp-text stamp-proses">PROSES</div>
            @endif
        </div>

        {{-- ── KOP SURAT ───────────────────────────────────── --}}
        <div class="kop">
            <div class="kop-logo">
                <img src="{{ asset('frontend/images/logo.png') }}" alt="Logo"
                     onerror="this.style.display='none'">
            </div>
            <div class="kop-center">
                <div class="kop-perusahaan">CarRental</div>
                <div class="kop-alamat">
                    Jl. Rental No. 1, Jakarta · Telp: (021) 123-4567 · carrental@email.com
                </div>
            </div>
            <div class="kop-right">
                <div class="kop-nodoc-label">No. Dokumen</div>
                <div class="kop-nodoc">#{{ str_pad($return->id, 6, '0', STR_PAD_LEFT) }}</div>
                <div class="kop-date">{{ \Carbon\Carbon::now()->isoFormat('D MMM Y') }}</div>
            </div>
        </div>
        <hr class="kop-line-top">
        <hr class="kop-line-bot">

        {{-- ── JUDUL ───────────────────────────────────────── --}}
        <div class="doc-title-wrap">
            <div class="doc-title">Bukti Pengembalian Kendaraan</div>
            <div class="doc-subtitle">
                Booking #{{ str_pad($return->booking->id, 6, '0', STR_PAD_LEFT) }} ·
                Dicetak: {{ \Carbon\Carbon::now()->isoFormat('D MMM Y, HH:mm') }} WIB
            </div>
        </div>

        {{-- ── A. IDENTITAS PELANGGAN ──────────────────────── --}}
        <div class="section-heading">A. Identitas Pelanggan</div>
        <table class="form-table">
            <tr>
                <td class="f-label">Nama Lengkap</td>
                <td class="f-sep">:</td>
                <td class="f-val">{{ $return->booking->user->name }}</td>
            </tr>
            <tr>
                <td class="f-label">Email</td>
                <td class="f-sep">:</td>
                <td class="f-val">{{ $return->booking->user->email }}</td>
            </tr>
            <tr>
                <td class="f-label">No. Booking</td>
                <td class="f-sep">:</td>
                <td class="f-val">
                    <strong>#{{ str_pad($return->booking->id, 6, '0', STR_PAD_LEFT) }}</strong>
                </td>
            </tr>
            <tr>
                <td class="f-label">No. Pengembalian</td>
                <td class="f-sep">:</td>
                <td class="f-val">
                    <strong>#{{ str_pad($return->id, 6, '0', STR_PAD_LEFT) }}</strong>
                </td>
            </tr>
        </table>

        {{-- ── B. INFORMASI KENDARAAN ──────────────────────── --}}
        <div class="section-heading">B. Informasi Kendaraan</div>
        <table class="form-table">
            <tr>
                <td class="f-label">Kendaraan</td>
                <td class="f-sep">:</td>
                <td class="f-val">
                    <strong>
                        {{ $return->booking->kendaraan->brand }}
                        {{ $return->booking->kendaraan->model }}
                    </strong>
                    @if($return->booking->kendaraan->year)
                        ({{ $return->booking->kendaraan->year }})
                    @endif
                </td>
            </tr>
            <tr>
                <td class="f-label">Nomor Plat</td>
                <td class="f-sep">:</td>
                <td class="f-val" style="font-family:'Courier New',monospace; font-weight:700; letter-spacing:0.1em;">
                    {{ $return->booking->kendaraan->plate_number }}
                </td>
            </tr>
            <tr>
                <td class="f-label">Tipe</td>
                <td class="f-sep">:</td>
                <td class="f-val">
                    {{ ucfirst($return->booking->kendaraan->type ?? '-') }}
                    @if($return->booking->kendaraan->color)
                        · Warna: {{ $return->booking->kendaraan->color }}
                    @endif
                </td>
            </tr>
            @if($return->booking->kendaraan->detail)
            <tr>
                <td class="f-label">Spesifikasi</td>
                <td class="f-sep">:</td>
                <td class="f-val">
                    @if($return->booking->kendaraan->detail->fuel_type)
                        {{ $return->booking->kendaraan->detail->fuel_type }}
                    @endif
                    @if($return->booking->kendaraan->detail->transmission)
                        · {{ $return->booking->kendaraan->detail->transmission }}
                    @endif
                    @if($return->booking->kendaraan->detail->seat_count)
                        · {{ $return->booking->kendaraan->detail->seat_count }} Kursi
                    @endif
                </td>
            </tr>
            @endif
        </table>

        {{-- ── C. JADWAL SEWA & PENGEMBALIAN ──────────────── --}}
        <div class="section-heading">C. Jadwal Sewa &amp; Pengembalian</div>
        <table class="data-table">
            <thead>
                <tr>
                    <th class="td-label">Keterangan</th>
                    <th>Tanggal</th>
                    <th>Waktu</th>
                    <th>Hari</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="td-label">Mulai Sewa</td>
                    <td class="td-center">{{ \Carbon\Carbon::parse($return->booking->start_date)->isoFormat('D MMM Y') }}</td>
                    <td class="td-center">—</td>
                    <td class="td-center">—</td>
                </tr>
                <tr>
                    <td class="td-label">Seharusnya Kembali</td>
                    <td class="td-center">{{ \Carbon\Carbon::parse($return->booking->end_date)->isoFormat('D MMM Y') }}</td>
                    <td class="td-center">—</td>
                    <td class="td-center">{{ $return->booking->total_days }} hari</td>
                </tr>
                <tr>
                    <td class="td-label">Dijadwalkan Kembali</td>
                    <td class="td-center">{{ \Carbon\Carbon::parse($return->return_scheduled_date)->isoFormat('D MMM Y') }}</td>
                    <td class="td-center">
                        {{ \Carbon\Carbon::createFromFormat('H:i:s', $return->return_scheduled_time)->format('H:i') }} WIB
                    </td>
                    <td class="td-center">—</td>
                </tr>
                @if($return->return_actual_date)
                <tr class="row-actual">
                    <td class="td-label"><strong>Kembali Aktual</strong></td>
                    <td class="td-center">
                        <strong>{{ \Carbon\Carbon::parse($return->return_actual_date)->isoFormat('D MMM Y') }}</strong>
                    </td>
                    <td class="td-center">
                        <strong>
                            @if($return->return_actual_time)
                                {{ \Carbon\Carbon::createFromFormat('H:i:s', $return->return_actual_time)->format('H:i') }} WIB
                            @else —
                            @endif
                        </strong>
                    </td>
                    <td class="td-center">—</td>
                </tr>
                @if($return->late_days > 0)
                <tr class="row-penalty">
                    <td class="td-label">Keterlambatan</td>
                    <td class="td-center" colspan="3">
                        <strong>{{ $return->late_days }} hari</strong> melebihi batas
                    </td>
                </tr>
                @endif
                @endif
            </tbody>
        </table>

        {{-- ── D. HASIL INSPEKSI (jika selesai) ────────────── --}}
        @if($return->status === 'completed')
        <div class="section-heading">D. Hasil Inspeksi Kendaraan</div>
        @php
            $condMap = [
                'excellent' => 'Sangat Baik',
                'good'      => 'Baik',
                'fair'      => 'Cukup',
                'poor'      => 'Buruk / Rusak',
            ];
        @endphp
        <table class="form-table">
            <tr>
                <td class="f-label">Kondisi Kendaraan</td>
                <td class="f-sep">:</td>
                <td class="f-val">
                    <strong>{{ $condMap[$return->condition] ?? ucfirst($return->condition ?? '-') }}</strong>
                </td>
            </tr>
            <tr>
                <td class="f-label">Diperiksa Oleh</td>
                <td class="f-sep">:</td>
                <td class="f-val">{{ $return->inspected_by_user->name ?? 'Admin' }}</td>
            </tr>
            <tr>
                <td class="f-label">Tanggal Inspeksi</td>
                <td class="f-sep">:</td>
                <td class="f-val">
                    {{ \Carbon\Carbon::parse($return->inspected_at)->isoFormat('D MMM Y, HH:mm') }} WIB
                </td>
            </tr>
            @if($return->admin_notes)
            <tr>
                <td class="f-label">Catatan Inspektor</td>
                <td class="f-sep">:</td>
                <td class="f-val">{{ $return->admin_notes }}</td>
            </tr>
            @endif
        </table>

        @if($return->damage_description)
        <div class="damage-box">
            <div class="damage-box-title">⚠ Laporan Kerusakan</div>
            <p>{{ $return->damage_description }}</p>
        </div>
        @endif

        {{-- ── E. RINGKASAN KEUANGAN ────────────────────────── --}}
        <div class="section-heading">E. Ringkasan Keuangan</div>
        <div class="finance-wrap">
            <div class="finance-row">
                <span class="f-desc">
                    Biaya Sewa
                    <small style="color:#6b7280;">({{ $return->booking->total_days }} hari)</small>
                </span>
                <span class="f-amount">Rp {{ number_format($return->booking->total_price, 0, ',', '.') }}</span>
            </div>

            @if($return->late_fee > 0)
            <div class="finance-row row-penalty">
                <span class="f-desc">
                    Denda Keterlambatan
                    <small>({{ $return->late_days }} hari × 20% / hari)</small>
                </span>
                <span class="f-amount">Rp {{ number_format($return->late_fee, 0, ',', '.') }}</span>
            </div>
            @endif

            @if($return->damage_fee > 0)
            <div class="finance-row row-penalty">
                <span class="f-desc">Biaya Perbaikan Kerusakan</span>
                <span class="f-amount">Rp {{ number_format($return->damage_fee, 0, ',', '.') }}</span>
            </div>
            @endif

            <div class="finance-row row-total">
                <span class="f-desc">Total Denda</span>
                <span class="f-amount">Rp {{ number_format($return->total_penalty, 0, ',', '.') }}</span>
            </div>

            @if($return->total_penalty > 0 && $return->penalty_paid)
            <div class="finance-row row-paid">
                <span class="f-desc">✔ Status Pembayaran Denda</span>
                <span class="f-amount">LUNAS</span>
            </div>
            @elseif($return->total_penalty > 0 && !$return->penalty_paid)
            <div class="finance-row row-penalty">
                <span class="f-desc">Status Pembayaran Denda</span>
                <span class="f-amount">BELUM BAYAR</span>
            </div>
            @endif
        </div>
        @endif

        {{-- ── CATATAN PELANGGAN ────────────────────────────── --}}
        @if($return->customer_notes)
        <div class="section-heading">
            {{ $return->status === 'completed' ? 'F' : 'D' }}. Catatan Pelanggan
        </div>
        <div class="note-box">{{ $return->customer_notes }}</div>
        @endif

        <hr class="section-divider">

        {{-- ── AREA TANDA TANGAN ────────────────────────────── --}}
        <div class="ttd-section">
            <div class="ttd-grid">
                <div class="ttd-col">
                    <div class="ttd-col-label">Pelanggan</div>
                    <div class="ttd-col-name">{{ $return->booking->user->name }}</div>
                    <div class="ttd-col-line">( .......................................... )</div>
                    <div style="font-size:8pt; color:#6b7280; margin-top:3px;">Nama Jelas &amp; Tanda Tangan</div>
                </div>
                <div class="ttd-col">
                    <div class="ttd-col-label">Inspektor</div>
                    <div class="ttd-col-name">
                        {{ $return->status === 'completed' ? ($return->inspected_by_user->name ?? 'Admin') : '&nbsp;' }}
                    </div>
                    <div class="ttd-col-line">( .......................................... )</div>
                    <div style="font-size:8pt; color:#6b7280; margin-top:3px;">Nama Jelas &amp; Tanda Tangan</div>
                </div>
                <div class="ttd-col">
                    <div class="ttd-col-label">Mengetahui</div>
                    <div class="ttd-col-name">Manajer Operasional</div>
                    <div class="ttd-col-line">( .......................................... )</div>
                    <div style="font-size:8pt; color:#6b7280; margin-top:3px;">Nama Jelas &amp; Tanda Tangan</div>
                </div>
            </div>
        </div>

        {{-- ── FOOTER BAR ───────────────────────────────────── --}}
        <div class="print-footer-bar">
            <div class="footer-left">
                CarRental · (021) 123-4567 · carrental@email.com
            </div>
            <div class="footer-center">
                Dokumen ini sah tanpa tanda tangan basah apabila dicetak melalui sistem.
            </div>
            <div class="footer-right">
                Hal. 1 / 1
            </div>
        </div>

    </div>{{-- /print-page --}}

</body>
</html>