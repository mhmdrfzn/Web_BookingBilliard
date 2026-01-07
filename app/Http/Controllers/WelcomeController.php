<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Booking;
use Illuminate\Http\Request;
use Carbon\Carbon;

class WelcomeController extends Controller
{
    public function index()
    {
        // Get total number of tables from products
        $totalTables = Product::count();
        
        // Get currently active bookings (status is active/approved and time is within start_time and end_time)
        $now = Carbon::now();
        $activeBookings = Booking::where('status', 'approved')
            ->where('start_time', '<=', $now)
            ->where('end_time', '>=', $now)
            ->with(['product', 'user'])
            ->get();
        
        // Calculate available tables
        $bookedTablesCount = $activeBookings->count();
        $availableTables = $totalTables - $bookedTablesCount;
        
        // Get a random live match (if any)
        $liveMatch = $activeBookings->isNotEmpty() ? $activeBookings->random() : null;
        
        return view('welcome', compact('availableTables', 'liveMatch', 'totalTables'));
    }
}
