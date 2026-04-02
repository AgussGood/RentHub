@extends('layouts.admin')

@section('content')

<style>
/* reuse dari kendaraan */
.kd-wrap { padding: 1.5rem 2rem; max-width: 1300px; }

/* header */
.kd-header {
    background: linear-gradient(135deg, #4f5fd5, #6366f1);
    padding: 22px;
    border-radius: 14px;
    color: #fff;
    margin-bottom: 20px;
}

/* stat card */
.kd-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 14px;
    margin-bottom: 20px;
}

.kd-card-stat {
    background: #fff;
    border-radius: 12px;
    padding: 18px;
    border: 1px solid #e9ecef;
}

.kd-card-title {
    font-size: 12px;
    color: #6c757d;
}

.kd-card-value {
    font-size: 22px;
    font-weight: 700;
    margin-top: 4px;
}

/* card */
.kd-card {
    background: #fff;
    border-radius: 14px;
    border: 1px solid #e9ecef;
    margin-bottom: 20px;
}

.kd-card-header {
    padding: 14px 18px;
    border-bottom: 1px solid #e9ecef;
    font-weight: 600;
}

.kd-card-body {
    padding: 16px;
}

/* table */
.kd-table {
    width: 100%;
    border-collapse: collapse;
}

.kd-table th {
    font-size: 11px;
    text-transform: uppercase;
    color: #6c757d;
    padding: 10px;
    background: #f8f9fa;
}

.kd-table td {
    padding: 10px;
    border-bottom: 1px solid #f1f3f5;
}

/* responsive */
@media(max-width: 900px){
    .kd-grid { grid-template-columns: repeat(2,1fr); }
}
</style>

<div class="kd-wrap">

    {{-- HEADER --}}
    <div class="kd-header">
        <h3>Dashboard Admin</h3>
        <p style="opacity:.7;">Monitoring sistem rental kendaraan</p>
    </div>

    {{-- STATS --}}
    <div class="kd-grid">

        <div class="kd-card-stat">
            <div class="kd-card-title">Today's Revenue</div>
            <div class="kd-card-value">
                Rp {{ number_format($todayRevenue,0,',','.') }}
            </div>
        </div>

        <div class="kd-card-stat">
            <div class="kd-card-title">Active Booking</div>
            <div class="kd-card-value">{{ $todayActiveBookings }}</div>
        </div>

        <div class="kd-card-stat">
            <div class="kd-card-title">New Customers</div>
            <div class="kd-card-value">{{ $newCustomersThisMonth }}</div>
        </div>

        <div class="kd-card-stat">
            <div class="kd-card-title">Monthly Sales</div>
            <div class="kd-card-value">
                Rp {{ number_format($totalSalesThisMonth,0,',','.') }}
            </div>
        </div>

    </div>

    {{-- CHART --}}
    <div class="kd-card">
        <div class="kd-card-header">Revenue Overview</div>
        <div class="kd-card-body">
            <canvas id="chart-line" height="120"></canvas>
        </div>
    </div>

    {{-- TABLE --}}
    <div class="kd-card">
        <div class="kd-card-header">Recent Bookings</div>
        <div class="kd-card-body">
            <table class="kd-table">
                <thead>
                    <tr>
                        <th>Customer</th>
                        <th>Kendaraan</th>
                        <th>Status</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentBookings as $booking)
                    <tr>
                        <td>{{ $booking->user->name }}</td>
                        <td>{{ $booking->kendaraan->brand }} {{ $booking->kendaraan->model }}</td>
                        <td>{{ ucfirst($booking->status) }}</td>
                        <td>Rp {{ number_format($booking->total_price,0,',','.') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" style="text-align:center;">Belum ada data</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
var ctx = document.getElementById("chart-line").getContext("2d");

var data = @json($monthlyRevenue);

new Chart(ctx, {
    type: "line",
    data: {
        labels: data.map(i => i.month),
        datasets: [{
            label: "Revenue",
            data: data.map(i => i.revenue),
            borderWidth: 2,
            tension: 0.4,
        }]
    }
});
</script>
@endpush