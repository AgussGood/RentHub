<?php
namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Kendaraan;
use App\Models\Payments;
use App\Models\Review;
use App\Models\User;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Today's Revenue
        $todayRevenue = Payments::where('payment_status', 'paid')
            ->whereDate('payment_date', Carbon::today())
            ->sum('amount');

        // Yesterday's Revenue for comparison
        $yesterdayRevenue = Payments::where('payment_status', 'paid')
            ->whereDate('payment_date', Carbon::yesterday())
            ->sum('amount');

        $revenueGrowth = $yesterdayRevenue > 0
            ? (($todayRevenue - $yesterdayRevenue) / $yesterdayRevenue) * 100
            : 0;

        // Today's Active Bookings
        $todayActiveBookings = Booking::where('status', 'confirmed')
            ->whereDate('start_date', '<=', Carbon::today())
            ->whereDate('end_date', '>=', Carbon::today())
            ->count();

        // Last week active bookings for comparison
        $lastWeekActiveBookings = Booking::where('status', 'confirmed')
            ->whereBetween('start_date', [
                Carbon::now()->subWeek()->startOfWeek(),
                Carbon::now()->subWeek()->endOfWeek(),
            ])
            ->count();

        $bookingsGrowth = $lastWeekActiveBookings > 0
            ? (($todayActiveBookings - $lastWeekActiveBookings) / $lastWeekActiveBookings) * 100
            : 0;

        // New Customers (This Month)
        $newCustomersThisMonth = User::whereHas('bookings')
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();

        // Last month new customers
        $newCustomersLastMonth = User::whereHas('bookings')
            ->whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->whereYear('created_at', Carbon::now()->subMonth()->year)
            ->count();

        $customersGrowth = $newCustomersLastMonth > 0
            ? (($newCustomersThisMonth - $newCustomersLastMonth) / $newCustomersLastMonth) * 100
            : 0;

        // Total Sales (This Month)
        $totalSalesThisMonth = Payments::where('payment_status', 'paid')
            ->whereMonth('payment_date', Carbon::now()->month)
            ->whereYear('payment_date', Carbon::now()->year)
            ->sum('amount');

        // Last month sales
        $totalSalesLastMonth = Payments::where('payment_status', 'paid')
            ->whereMonth('payment_date', Carbon::now()->subMonth()->month)
            ->whereYear('payment_date', Carbon::now()->subMonth()->year)
            ->sum('amount');

        $salesGrowth = $totalSalesLastMonth > 0
            ? (($totalSalesThisMonth - $totalSalesLastMonth) / $totalSalesLastMonth) * 100
            : 0;

        // Monthly Revenue for Chart (Last 12 months)
        $monthlyRevenue = [];
        for ($i = 11; $i >= 0; $i--) {
            $date    = Carbon::now()->subMonths($i);
            $revenue = Payments::where('payment_status', 'paid')
                ->whereMonth('payment_date', $date->month)
                ->whereYear('payment_date', $date->year)
                ->sum('amount');

            $monthlyRevenue[] = [
                'month'   => $date->format('M Y'),
                'revenue' => $revenue,
            ];
        }

        // Vehicle Statistics
        $vehicleStats = [
            [
                'type'  => 'Total Vehicles',
                'count' => Kendaraan::count(),
                'icon'  => 'fa-car',
            ],
            [
                'type'  => 'Available',
                'count' => Kendaraan::where('status', 'available')->count(),
                'icon'  => 'fa-check-circle',
            ],
            [
                'type'  => 'Rented',
                'count' => Kendaraan::where('status', 'rented')->count(),
                'icon'  => 'fa-key',
            ],
            [
                'type'  => 'Maintenance',
                'count' => Kendaraan::where('status', 'maintenance')->count(),
                'icon'  => 'fa-wrench',
            ],
        ];

        // Recent Bookings
        $recentBookings = Booking::with(['user', 'kendaraan.images'])
            ->latest()
            ->take(5)
            ->get();

        // Top Vehicles (Most Booked)
        $topVehicles = Kendaraan::withCount('bookings')
            ->with('images')
            ->orderBy('bookings_count', 'desc')
            ->take(5)
            ->get();

        // Recent Reviews
        $recentReviews = Review::with(['user', 'kendaraan'])
            ->where('status', 'published')
            ->latest()
            ->take(5)
            ->get();

        // Status Distribution
        $statusDistribution = [
            'pending'   => Booking::where('status', 'pending')->count(),
            'confirmed' => Booking::where('status', 'confirmed')->count(),
            'completed' => Booking::where('status', 'completed')->count(),
            'cancelled' => Booking::where('status', 'cancelled')->count(),
        ];

        return view('home', compact(
            'todayRevenue',
            'revenueGrowth',
            'todayActiveBookings',
            'bookingsGrowth',
            'newCustomersThisMonth',
            'customersGrowth',
            'totalSalesThisMonth',
            'salesGrowth',
            'monthlyRevenue',
            'vehicleStats',
            'recentBookings',
            'topVehicles',
            'recentReviews',
            'statusDistribution'
        ));
    }
}
