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
                        <td class="py-4 px-6 text-white font-semibold">{{ $booking->product->name ?? 'Meja ' . $booking->table_number }}</td>
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
                            @elseif($booking->status == 'approved' && $booking->payment_status == 'pending_verification')
                                <div class="flex items-center justify-end">
                                    <button onclick="openPaymentModal('{{ asset($booking->payment_proof) }}', '{{ route('admin.booking.verify-payment', $booking->id) }}')" 
                                            class="px-4 py-2 bg-yellow-500/20 hover:bg-yellow-500 text-yellow-400 hover:text-white font-semibold rounded-lg text-xs transition">
                                        Verifikasi Bayar
                                    </button>
                                </div>
                            @else
                                <div class="flex items-center justify-end gap-2">
                                    @if($booking->payment_status == 'unpaid')
                                        <span class="text-xs text-red-400">Belum Bayar</span>
                                    @elseif($booking->payment_status == 'paid')
                                        <span class="text-xs text-green-400">✓ Lunas</span>
                                    @elseif($booking->payment_status == 'failed')
                                        <span class="text-xs text-red-400">Ditolak</span>
                                    @else
                                        <span class="text-xs text-gray-500">Selesai</span>
                                    @endif
                                </div>
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

<!-- Payment Verification Modal -->
<div id="paymentModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div class="fixed inset-0 bg-black/80 transition-opacity" aria-hidden="true" onclick="closePaymentModal()"></div>

        <!-- Modal panel -->
        <div class="inline-block align-bottom bg-[#1a1a1a] border border-white/10 rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                        <h3 class="text-lg leading-6 font-medium text-white mb-4" id="modal-title">
                            Verifikasi Pembayaran
                        </h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-400 mb-4">Bukti Transfer:</p>
                            <div class="bg-black/50 rounded-lg p-2 mb-4 border border-white/10">
                                <img id="paymentProofImage" src="" alt="Payment Proof" class="w-full h-auto rounded object-contain max-h-[400px]">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-black/20 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse gap-3">
                <form id="approveForm" method="POST" action="">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="payment_status" value="paid">
                    <button type="submit" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm transition">
                        ✓ Terima Pembayaran
                    </button>
                </form>
                
                <form id="rejectForm" method="POST" action="">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="payment_status" value="failed">
                    <button type="submit" class="mt-3 w-full inline-flex justify-center rounded-xl border border-red-500/30 shadow-sm px-4 py-2 bg-red-500/10 text-base font-medium text-red-400 hover:bg-red-500/20 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition">
                        ✗ Tolak Pembayaran
                    </button>
                </form>

                <button type="button" onclick="closePaymentModal()" class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-500/30 shadow-sm px-4 py-2 bg-white/5 text-base font-medium text-gray-300 hover:bg-white/10 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    function openPaymentModal(imageSrc, actionUrl) {
        document.getElementById('paymentProofImage').src = imageSrc;
        document.getElementById('approveForm').action = actionUrl;
        document.getElementById('rejectForm').action = actionUrl;
        document.getElementById('paymentModal').classList.remove('hidden');
    }

    function closePaymentModal() {
        document.getElementById('paymentModal').classList.add('hidden');
    }
</script>
@endsection