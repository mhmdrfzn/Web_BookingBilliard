<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminBookingController;
use App\Http\Controllers\CustomerController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return redirect()->route('customer.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Customer Dashboard
    Route::get('/customer/dashboard', [CustomerController::class, 'dashboard'])->name('customer.dashboard');

    Route::get('/booking/create', [BookingController::class, 'create'])->name('booking.create');
    Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');
    Route::delete('/booking/{id}', [BookingController::class, 'destroy'])->name('booking.destroy');

    // Route untuk melihat history booking customer
    Route::get('/my-bookings', [BookingController::class, 'index'])->name('my-bookings');
});

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\AdminDashboardController::class, 'index'])->name('dashboard');
    
    // Bank Management
    Route::resource('banks', \App\Http\Controllers\BankController::class);
    
    // Product/Table Management
    Route::resource('products', \App\Http\Controllers\ProductController::class);
    
    // Booking Management
    Route::get('/bookings', [AdminBookingController::class, 'index'])->name('bookings.index');
    Route::patch('/booking/{id}', [AdminBookingController::class, 'updateStatus'])->name('booking.update');
});

// Debug route (temporary - remove in production)
Route::get('/debug-availability', function() {
    $currentTime = now();
    
    $html = "<h2>Current Time: " . $currentTime . "</h2>";
    $html .= "<hr>";
    
    // Get all bookings
    $bookings = \App\Models\Booking::whereIn('status', ['pending', 'approved'])
        ->orderBy('created_at', 'desc')
        ->get();
    
    $html .= "<h3>Active Bookings (Pending or Approved):</h3>";
    $html .= "<table border='1' cellpadding='10' style='border-collapse: collapse;'>";
    $html .= "<tr><th>ID</th><th>Table Number</th><th>Start Time</th><th>End Time</th><th>Status</th><th>Is Active Now?</th></tr>";
    
    foreach ($bookings as $booking) {
        $isActive = ($booking->start_time <= $currentTime && $booking->end_time > $currentTime);
        $color = $isActive ? 'background-color: lightgreen' : '';
        $html .= "<tr style='$color'>";
        $html .= "<td>{$booking->id}</td>";
        $html .= "<td>{$booking->table_number}</td>";
        $html .= "<td>{$booking->start_time}</td>";
        $html .= "<td>{$booking->end_time}</td>";
        $html .= "<td>{$booking->status}</td>";
        $html .= "<td>" . ($isActive ? '<strong>YES</strong>' : 'NO') . "</td>";
        $html .= "</tr>";
    }
    $html .= "</table>";
    
    $html .= "<hr>";
    $html .= "<h3>Products Availability:</h3>";
    
    $products = \App\Models\Product::all();
    foreach ($products as $product) {
        $activeBooking = \App\Models\Booking::where('table_number', $product->id)
            ->whereIn('status', ['pending', 'approved'])
            ->where('start_time', '<=', $currentTime)
            ->where('end_time', '>', $currentTime)
            ->first();
        
        $status = $activeBooking ? 'IN USE' : 'AVAILABLE';
        $color = $activeBooking ? 'red' : 'green';
        
        $html .= "<p><strong style='color: $color; font-size: 18px;'>Product: {$product->name} (ID: {$product->id}) - $status</strong></p>";
        if ($activeBooking) {
            $html .= "<p style='margin-left: 20px;'>→ Booking ID: {$activeBooking->id}, Ends at: {$activeBooking->end_time}</p>";
        }
        $html .= "<hr style='margin: 10px 0;'>";
    }
    
    return $html;
});

require __DIR__.'/auth.php';
