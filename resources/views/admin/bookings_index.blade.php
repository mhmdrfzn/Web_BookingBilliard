@extends('layouts.admin-layout')

@section('header', 'Manajemen Booking')

@section('content')
<div class="space-y-6">
    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-gradient-to-br from-white/10 to-white/5 backdrop-blur-sm border border-white/10 rounded-2xl p-6">
            <div class="flex items-center justify-between mb-2">
                <h3 class="text-sm font-semibold text-gray-400">Perlu Konfirmasi</h3>
                <div class="w-10 h-10 bg-yellow-500/20 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
            <p class="text-3xl font-black text-white">{{ $pendingCount }}</p>
            <p class="text-xs text-gray-500 mt-1">Menunggu tindakan Anda</p>
        </div>

        <div class="bg-gradient-to-br from-white/10 to-white/5 backdrop-blur-sm border border-white/10 rounded-2xl p-6">
            <div class="flex items-center justify-between mb-2">
                <h3 class="text-sm font-semibold text-gray-400">Jadwal Hari Ini</h3>
                <div class="w-10 h-10 bg-blue-500/20 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
            </div>
            <p class="text-3xl font-black text-white">{{ $todayCount }}</p>
            <p class="text-xs text-gray-500 mt-1">Total sesi main hari ini</p>
        </div>

        <div class="bg-gradient-to-br from-white/10 to-white/5 backdrop-blur-sm border border-white/10 rounded-2xl p-6">
            <div class="flex items-center justify-between mb-2">
                <h3 class="text-sm font-semibold text-gray-400">Total Pendapatan</h3>
                <div class="w-10 h-10 bg-green-500/20 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
            <p class="text-3xl font-black text-white">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
            <p class="text-xs text-gray-500 mt-1">Dari booking disetujui</p>
        </div>
    </div>

    <!-- Bookings Table -->
    <div class="bg-gradient-to-br from-white/10 to-white/5 backdrop-blur-sm border border-white/10 rounded-2xl overflow-hidden">
        <div class="p-6 border-b border-white/10">
            <h2 class="text-xl font-bold text-white">Semua Booking</h2>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-white/5 border-b border-white/10">
                    <tr>
                        <th class="text-left py-4 px-6 text-sm font-semibold text-gray-300">Pemesan</th>
                        <th class="text-left py-4 px-6 text-sm font-semibold text-gray-300">Meja</th>
                        <th class="text-left py-4 px-6 text-sm font-semibold text-gray-300">Waktu Main</th>
                        <th class="text-left py-4 px-6 text-sm font-semibold text-gray-300">Durasi</th>
                        <th class="text-left py-4 px-6 text-sm font-semibold text-gray-300">Total Harga</th>
                        <th class="text-left py-4 px-6 text-sm font-semibold text-gray-300">Status</th>
                        <th class="text-right py-4 px-6 text-sm font-semibold text-gray-300">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bookings as $booking)
                    <tr class="border-b border-white/5 hover:bg-white/5 transition">
                        <td class="py-4 px-6">
                            <p class="text-sm font-semibold text-white">{{ $booking->user->name }}</p>
                            <p class="text-xs text-gray-500">{{ $booking->user->email }}</p>
                        </td>
                        <td class="py-4 px-6 text-white font-semibold">Meja {{ $booking->table_number }}</td>
                        <td class="py-4 px-6">
                            <p class="text-sm text-gray-300">{{ \Carbon\Carbon::parse($booking->start_time)->format('d M Y') }}</p>
                            <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($booking->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($booking->end_time)->format('H:i') }}</p>
                        </td>
                        <td class="py-4 px-6 text-gray-300">
                            {{ \Carbon\Carbon::parse($booking->start_time)->diffInHours($booking->end_time) }} Jam
                        </td>
                        <td class="py-4 px-6 text-white font-semibold font-mono">
                            Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                        </td>
                        <td class="py-4 px-6">
                            @if($booking->status == 'pending')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-yellow-500/10 text-yellow-400">
                                    Pending
                                </span>
                            @elseif($booking->status == 'approved')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-500/10 text-green-400">
                                    Approved
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-500/10 text-red-400">
                                    Rejected
                                </span>
                            @endif
                        </td>
                        <td class="py-4 px-6">
                            @if($booking->status == 'pending')
                                <div class="flex items-center justify-end gap-2">
                                    <form action="{{ route('admin.booking.update', $booking->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="approved">
                                        <button type="submit" class="px-4 py-2 bg-green-500/20 hover:bg-green-500 text-green-400 hover:text-white font-semibold rounded-lg text-xs transition">
                                            Terima
                                        </button>
                                    </form>

                                    <form action="{{ route('admin.booking.update', $booking->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="rejected">
                                        <button type="submit" class="px-4 py-2 bg-red-500/20 hover:bg-red-500 text-red-400 hover:text-white font-semibold rounded-lg text-xs transition">
                                            Tolak
                                        </button>
                                    </form>
                                </div>
                            @else
                                <span class="text-xs text-gray-500 text-right block">Selesai</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="py-12 text-center text-gray-500">Tidak ada booking</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection