@extends('layouts.admin-layout')

@section('header', 'Dashboard')

@section('content')
<div class="space-y-8">
    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Active Tables Card -->
        <div class="bg-gradient-to-br from-white/10 to-white/5 backdrop-blur-sm border border-white/10 rounded-2xl p-6 hover:scale-105 transition-transform">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-gradient-to-br from-[#1C4D8D] to-[#153A6A] rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                </div>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-500/10 text-green-400">
                    Aktif
                </span>
            </div>
            <h3 class="text-3xl font-black text-white mb-1">{{ $activeBookings->count() }}</h3>
            <p class="text-sm text-gray-400">Meja Sedang Digunakan</p>
        </div>

        <!-- Revenue Card -->
        <div class="bg-gradient-to-br from-white/10 to-white/5 backdrop-blur-sm border border-white/10 rounded-2xl p-6 hover:scale-105 transition-transform">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-gradient-to-br from-green-600 to-green-700 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
            <h3 class="text-3xl font-black text-white mb-1">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
            <p class="text-sm text-gray-400">Total Pendapatan</p>
        </div>

        <!-- Pending Bookings Card -->
        <div class="bg-gradient-to-br from-white/10 to-white/5 backdrop-blur-sm border border-white/10 rounded-2xl p-6 hover:scale-105 transition-transform">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-gradient-to-br from-yellow-600 to-yellow-700 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                @if($pendingCount > 0)
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-yellow-500/10 text-yellow-400">
                        Action Needed
                    </span>
                @endif
            </div>
            <h3 class="text-3xl font-black text-white mb-1">{{ $pendingCount }}</h3>
            <p class="text-sm text-gray-400">Booking Pending</p>
        </div>

        <!-- Total Tables Card -->
        <div class="bg-gradient-to-br from-white/10 to-white/5 backdrop-blur-sm border border-white/10 rounded-2xl p-6 hover:scale-105 transition-transform">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-gradient-to-br from-purple-600 to-purple-700 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                    </svg>
                </div>
            </div>
            <h3 class="text-3xl font-black text-white mb-1">{{ $totalTables }}</h3>
            <p class="text-sm text-gray-400">Total Meja</p>
        </div>
    </div>

    <!-- Active Bookings -->
    @if($activeBookings->count() > 0)
    <div class="bg-gradient-to-br from-white/10 to-white/5 backdrop-blur-sm border border-white/10 rounded-2xl p-6">
        <h2 class="text-xl font-bold text-white mb-4">Meja Sedang Digunakan</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($activeBookings as $booking)
            <div class="bg-white/5 border border-white/10 rounded-xl p-4">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-lg font-bold text-white">{{ $booking->product ? $booking->product->name : 'Meja #' . $booking->table_number }}</span>
                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-green-500/10 text-green-400">
                        <span class="w-2 h-2 bg-green-400 rounded-full mr-1 animate-pulse"></span>
                        Aktif
                    </span>
                </div>
                <p class="text-sm text-gray-400 mb-2">{{ $booking->user->name }}</p>
                <div class="text-xs text-gray-500">
                    <p>Mulai: {{ $booking->start_time->format('H:i') }}</p>
                    <p>Selesai: {{ $booking->end_time->format('H:i') }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Recent Bookings -->
    <div class="bg-gradient-to-br from-white/10 to-white/5 backdrop-blur-sm border border-white/10 rounded-2xl p-6">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-bold text-white">Booking Terbaru</h2>
            <a href="{{ route('admin.bookings.index') }}" class="text-sm font-semibold text-[#5B9FD8] hover:text-[#1C4D8D] transition">
                Lihat Semua →
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-white/10">
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-400">Customer</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-400">Meja</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-400">Waktu</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-400">Harga</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-400">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentBookings as $booking)
                    <tr class="border-b border-white/5 hover:bg-white/5 transition">
                        <td class="py-4 px-4">
                            <p class="text-sm font-semibold text-white">{{ $booking->user->name }}</p>
                            <p class="text-xs text-gray-500">{{ $booking->user->email }}</p>
                        </td>
                        <td class="py-4 px-4 text-sm text-gray-300">{{ $booking->product ? $booking->product->name : 'Meja #' . $booking->table_number }}</td>
                        <td class="py-4 px-4">
                            <p class="text-sm text-gray-300">{{ $booking->start_time->format('d M Y') }}</p>
                            <p class="text-xs text-gray-500">{{ $booking->start_time->format('H:i') }} - {{ $booking->end_time->format('H:i') }}</p>
                        </td>
                        <td class="py-4 px-4 text-sm font-semibold text-white">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                        <td class="py-4 px-4">
                            @if($booking->status === 'pending')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-yellow-500/10 text-yellow-400">
                                    Pending
                                </span>
                            @elseif($booking->status === 'approved')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-500/10 text-green-400">
                                    Approved
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-500/10 text-red-400">
                                    Rejected
                                </span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-8 text-center text-gray-500">Tidak ada booking</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
