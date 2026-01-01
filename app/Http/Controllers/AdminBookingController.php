<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
 // <--- 1. Jangan lupa import ini
use App\Notifications\BookingStatusNotification;
use Illuminate\Support\Facades\Notification;     // <--- 2. Import facade Notification (opsional jika pakai $user->notify)

class AdminBookingController extends Controller
{
    public function index()
    {
        $pendingCount = Booking::where('status', 'pending')->count();
        $todayCount   = Booking::whereDate('start_time', \Carbon\Carbon::today())->count();
        
        // Hitung total uang dari booking yang statusnya SUDAH SELESAI/APPROVED
        // Kita pakai sum('total_price')
        $totalRevenue = Booking::where('status', 'approved')->sum('total_price'); 

        $bookings = Booking::with('user')->orderBy('created_at', 'desc')->get();

        // Ganti totalCount jadi totalRevenue di compact
        return view('admin.bookings_index', compact('bookings', 'pendingCount', 'todayCount', 'totalRevenue'));
    }

    public function updateStatus(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);
        
        $request->validate([
            'status' => 'required|in:approved,rejected'
        ]);

        // Update status database
        $booking->update([
            'status' => $request->status
        ]);

        // --- 3. KODE BARU: Kirim Notifikasi ke Pemilik Booking ---
        try {
            // Kita kirim notifikasi langsung ke User pemilik booking
            $booking->user->notify(new BookingStatusNotification($booking));
        } catch (\Exception $e) {
            // Abaikan error email agar tidak mengganggu proses admin
            Log::error('Gagal kirim notifikasi ke customer: ' . $e->getMessage());
        }
        // ---------------------------------------------------------

        return back()->with('success', 'Status booking diperbarui & notifikasi dikirim ke customer.');
    }
}