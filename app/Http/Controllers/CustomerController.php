<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    /**
     * Display the customer dashboard with bookings and products.
     */
    public function dashboard()
    {
        // Get user's recent bookings (latest 5)
        $bookings = Booking::where('user_id', Auth::id())
                            ->orderBy('created_at', 'desc')
                            ->limit(5)
                            ->get();

        // Get all available products
        $products = Product::orderBy('created_at', 'desc')->get();

        // Add availability status to each product
        $currentTime = now();
        foreach ($products as $product) {
            // Check if there's an active booking for this product (pending or approved)
            $activeBooking = Booking::where('table_number', $product->id)
                ->whereIn('status', ['pending', 'approved']) // Include pending and approved
                ->where('start_time', '<=', $currentTime)
                ->where('end_time', '>', $currentTime)
                ->first();
            
            // Debug logging (temporary)
            \Log::info("Product {$product->name} (ID: {$product->id})", [
                'current_time' => $currentTime,
                'has_active_booking' => $activeBooking ? true : false,
                'booking_id' => $activeBooking ? $activeBooking->id : null,
                'booking_start' => $activeBooking ? $activeBooking->start_time : null,
                'booking_end' => $activeBooking ? $activeBooking->end_time : null,
                'booking_status' => $activeBooking ? $activeBooking->status : null,
            ]);
            
            $product->is_available = !$activeBooking; // true if no active booking
            $product->current_booking = $activeBooking; // store booking info if exists
        }

        return view('customer.dashboard', compact('bookings', 'products'));
    }
}
