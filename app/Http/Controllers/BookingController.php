<?php

namespace App\Http\Controllers;

use App\Models\Booking; // Import Model Booking
use App\Models\User;    // Import Model User (untuk mencari Admin)
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Untuk mengambil ID user yang login
use Carbon\Carbon; // Wajib ada untuk manipulasi jam/tanggal
use Illuminate\Support\Facades\Notification; // Untuk mengirim notifikasi
use App\Notifications\NewBookingNotification; // Class notifikasi yang sudah dibuat

class BookingController extends Controller
{
    /**
     * Menampilkan daftar riwayat booking milik user yang sedang login.
     * Route: /my-bookings
     */
    public function index()
    {
        // Ambil data booking hanya milik user yang sedang login
        // Urutkan dari yang paling baru (descending)
        $bookings = Booking::where('user_id', Auth::id())
                            ->orderBy('created_at', 'desc')
                            ->get();

        return view('customer.my_bookings', compact('bookings'));
    }

    /**
     * Menampilkan formulir pembuatan booking baru.
     * Route: /booking/create
     */
    public function create()
    {
        // Ambil semua produk dari database
        $products = \App\Models\Product::all();
        
        return view('customer.create_booking', compact('products'));
    }

    /**
     * Memproses penyimpanan data booking ke database.
     * Route: POST /booking
     */
    public function store(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'table_number' => 'required|exists:products,id', // Validasi bahwa product ada
            'start_time'   => 'required|date|after:now', 
            'duration'     => 'required|integer|min:1',
        ]);

        // 2. Ambil data produk dari database
        $product = \App\Models\Product::findOrFail($request->table_number);

        // 3. Hitung Waktu
        $startTime = Carbon::parse($request->start_time);
        $endTime   = $startTime->copy()->addHours((int) $request->duration);

        // 4. CEK JADWAL BENTROK
        $isBooked = Booking::where('table_number', $request->table_number)
            ->where('status', '!=', 'rejected') // Abaikan booking yang sudah Ditolak
            ->where(function ($query) use ($startTime, $endTime) {
                $query->whereBetween('start_time', [$startTime, $endTime])
                      ->orWhereBetween('end_time', [$startTime, $endTime])
                      ->orWhere(function ($q) use ($startTime, $endTime) {
                          // Handle booking yang mengapit (mulai sebelum & selesai sesudah request kita)
                          $q->where('start_time', '<', $startTime)
                            ->where('end_time', '>', $endTime);
                      });
            })
            ->exists();

        if ($isBooked) {
            return back()
                ->withErrors(['start_time' => 'Maaf, Meja ini sudah terisi pada jam tersebut. Pilih jam atau meja lain.'])
                ->withInput();
        }

        // 5. Hitung harga berdasarkan produk yang dipilih
        $pricePerHour = $product->price; // Ambil harga dari database produk
        $totalPrice   = $pricePerHour * (int) $request->duration;
        // 3. Simpan ke Database (Jika aman)
        $booking = Booking::create([
            'user_id'      => Auth::id(),
            'table_number' => $request->table_number,
            'start_time'   => $startTime,
            'end_time'     => $endTime,
            'status'       => 'pending',
            'total_price'  => $totalPrice,
            'notes'        => $request->notes,
        ]);

        // 4. Kirim Notifikasi (Try-Catch)
        try {
            $admins = User::where('role', 'admin')->get();
            if ($admins->count() > 0) {
                Notification::send($admins, new NewBookingNotification($booking));
            }
        } catch (\Exception $e) {
            // Silent fail
        }

        return redirect()->route('my-bookings')->with('success', 'Booking berhasil dibuat!');
    }

    public function destroy($id)
    {
        // 1. Cari data booking
        $booking = Booking::findOrFail($id);

        // 2. Keamanan: Pastikan yang menghapus adalah pemilik booking itu sendiri
        if ($booking->user_id != Auth::id()) {
            abort(403, 'Akses Ditolak');
        }

        // 3. Validasi: Hanya boleh cancel jika status masih pending
        if ($booking->status != 'pending') {
            return back()->with('error', 'Booking yang sudah disetujui/selesai tidak bisa dibatalkan.');
        }

        // 4. Hapus data
        $booking->delete();

        // 5. Kembali dengan pesan sukses
        return back()->with('success', 'Booking berhasil dibatalkan.');
    }
}