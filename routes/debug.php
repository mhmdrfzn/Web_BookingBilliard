&lt;?php

use App\Models\Booking;
use App\Models\Product;
use Illuminate\Support\Facades\Route;

Route::get('/debug-availability', function() {
    $currentTime = now();
    
    echo "&lt;h2>Current Time: " . $currentTime . "&lt;/h2>";
    echo "&lt;hr>";
    
    // Get all bookings
    $bookings = Booking::whereIn('status', ['pending', 'approved'])
        ->orderBy('created_at', 'desc')
        ->get();
    
    echo "&lt;h3>Active Bookings (Pending or Approved):&lt;/h3>";
    echo "&lt;table border='1' cellpadding='10'>";
    echo "&lt;tr>&lt;th>ID&lt;/th>&lt;th>Table Number&lt;/th>&lt;th>Start Time&lt;/th>&lt;th>End Time&lt;/th>&lt;th>Status&lt;/th>&lt;th>Is Active Now?&lt;/th>&lt;/tr>";
    
    foreach ($bookings as $booking) {
        $isActive = ($booking->start_time <= $currentTime && $booking->end_time > $currentTime);
        $color = $isActive  ? 'background-color: lightgreen' : '';
        echo "&lt;tr style='$color'>";
        echo "&lt;td>{$booking->id}&lt;/td>";
        echo "&lt;td>{$booking->table_number}&lt;/td>";
        echo "&lt;td>{$booking->start_time}&lt;/td>";
        echo "&lt;td>{$booking->end_time}&lt;/td>";
        echo "&lt;td>{$booking->status}&lt;/td>";
        echo "&lt;td>" . ($isActive ? 'YES' : 'NO') . "&lt;/td>";
        echo "&lt;/tr>";
    }
    echo "&lt;/table>";
    
    echo "&lt;hr>";
    echo "&lt;h3>Products Availability:&lt;/h3>";
    
    $products = Product::all();
    foreach ($products as $product) {
        $activeBooking = Booking::where('table_number', $product->id)
            ->whereIn('status', ['pending', 'approved'])
            ->where('start_time', '<=', $currentTime)
            ->where('end_time', '>', $currentTime)
            ->first();
        
        $status = $activeBooking ? 'IN USE' : 'AVAILABLE';
        $color = $activeBooking ? 'red' : 'green';
        
        echo "&lt;p>&lt;strong style='color: $color'>Product: {$product->name} (ID: {$product->id}) - $status&lt;/strong>&lt;/p>";
        if ($activeBooking) {
            echo "&lt;p>Booking ID: {$activeBooking->id}, Ends at: {$activeBooking->end_time}&lt;/p>";
        }
    }
});
