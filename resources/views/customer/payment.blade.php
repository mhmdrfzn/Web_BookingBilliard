<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment - Billiard Booking</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=manrope:400,500,600,700,800&display=swap" rel="stylesheet" />
    <style>
        body { font-family: 'Manrope', sans-serif; }
    </style>
</head>
<body class="bg-black antialiased text-white overflow-x-hidden">
    
    <!-- Background Gradient -->
    <div class="fixed inset-0 bg-gradient-to-br from-[#0A1F3D] via-black to-black -z-10"></div>

    <!-- Navbar -->
    <nav class="sticky top-0 z-50 bg-transparent backdrop-blur-md border-b border-white/5">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-[#1C4D8D] to-[#153A6A] rounded-full flex items-center justify-center shadow-lg shadow-[#1C4D8D]/50">
                        <span class="text-white font-black text-lg">8</span>
                    </div>
                    <span class="text-xl font-bold text-white">BilliardClub</span>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('customer.dashboard') }}" class="px-4 py-2 text-gray-300 hover:text-white font-medium transition-colors">Dashboard</a>
                    <a href="{{ route('my-bookings') }}" class="px-4 py-2 text-white font-medium bg-[#1C4D8D]/20 rounded-full transition-colors">All Bookings</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-4xl mx-auto px-6 lg:px-8 py-12">
        <div class="mb-8 text-center">
            <h1 class="text-4xl font-black text-white mb-2">Complete Your Payment</h1>
            <p class="text-gray-400">Please transfer the total amount to one of the bank accounts below.</p>
        </div>

        <div class="grid md:grid-cols-2 gap-8">
            <!-- Booking Summary -->
            <div class="bg-gradient-to-br from-white/5 to-white/[0.02] backdrop-blur-sm border border-white/10 rounded-3xl p-8">
                <h3 class="text-xl font-bold text-white mb-6 border-b border-white/10 pb-4">Booking Summary</h3>
                <div class="space-y-4">
                    <div class="flex justify-between">
                        <span class="text-gray-400">Table</span>
                        <span class="text-white font-semibold">{{ $booking->product->name ?? 'Meja ' . $booking->table_number }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-400">Date</span>
                        <span class="text-white font-semibold">{{ \Carbon\Carbon::parse($booking->start_time)->format('d M Y') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-400">Time</span>
                        <span class="text-white font-semibold">{{ \Carbon\Carbon::parse($booking->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($booking->end_time)->format('H:i') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-400">Duration</span>
                        <span class="text-white font-semibold">{{ \Carbon\Carbon::parse($booking->start_time)->diffInHours($booking->end_time) }} Hours</span>
                    </div>
                    <div class="pt-4 border-t border-white/10 flex justify-between items-center">
                        <span class="text-gray-400">Total Amount</span>
                        <span class="text-2xl font-black text-[#5B9FD8]">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <!-- Payment Details & Upload -->
            <div class="space-y-6">
                <!-- Bank Accounts -->
                <div class="bg-gradient-to-br from-white/5 to-white/[0.02] backdrop-blur-sm border border-white/10 rounded-3xl p-8">
                    <h3 class="text-xl font-bold text-white mb-6 border-b border-white/10 pb-4">Bank Accounts</h3>
                    @forelse($banks as $bank)
                        <div class="mb-4 last:mb-0 p-4 bg-white/5 rounded-xl border border-white/5">
                            <div class="font-bold text-[#5B9FD8] text-lg">{{ $bank->bank_name }}</div>
                            <div class="text-white text-xl tracking-wider font-mono my-1 copy-text cursor-pointer" title="Click to copy" onclick="navigator.clipboard.writeText('{{ $bank->account_number }}'); alert('Copied!')">{{ $bank->account_number }}</div>
                            <div class="text-sm text-gray-400">a.n {{ $bank->account_holder }}</div>
                        </div>
                    @empty
                        <p class="text-gray-400">No bank accounts available. Please contact admin.</p>
                    @endforelse
                </div>

                <!-- Upload Form -->
                <div class="bg-gradient-to-br from-white/5 to-white/[0.02] backdrop-blur-sm border border-white/10 rounded-3xl p-8">
                    <h3 class="text-xl font-bold text-white mb-4">Upload Proof</h3>
                    <form action="{{ route('booking.payment.process', $booking->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-400 mb-2">Payment Receipt (Image)</label>
                            <input type="file" name="payment_proof" accept="image/*" class="w-full text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-[#1C4D8D] file:text-white hover:file:bg-[#153A6A] transition-colors cursor-pointer" required>
                        </div>
                        <button type="submit" class="w-full py-3 bg-green-600 hover:bg-green-700 text-white font-bold rounded-xl transition-all shadow-lg hover:shadow-green-500/30">
                            Submit Payment
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
