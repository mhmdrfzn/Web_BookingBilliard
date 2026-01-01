<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Product;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Get active bookings (approved and currently in progress)
        $activeBookings = Booking::where('status', 'approved')
            ->where('start_time', '<=', Carbon::now())
            ->where('end_time', '>=', Carbon::now())
            ->with(['user', 'product'])
            ->get();

        // Calculate total revenue from approved bookings
        $totalRevenue = Booking::where('status', 'approved')->sum('total_price');

        // Count pending bookings
        $pendingCount = Booking::where('status', 'pending')->count();

        // Get today's bookings
        $todayBookings = Booking::whereDate('start_time', Carbon::today())
            ->with(['user', 'product'])
            ->orderBy('start_time', 'desc')
            ->get();

        // Count total products/tables
        $totalTables = Product::count();

        // Get recent bookings for display
        $recentBookings = Booking::with(['user', 'product'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'activeBookings',
            'totalRevenue',
            'pendingCount',
            'todayBookings',
            'totalTables',
            'recentBookings'
        ));
    }
}
