<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Bookings - Billiard Booking</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=manrope:400,500,600,700,800&display=swap" rel="stylesheet" />
    
    <style>
        body { 
            font-family: 'Manrope', sans-serif; 
        }
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .fade-in-up {
            animation: fadeInUp 0.8s ease-out forwards;
        }
        .delay-100 { animation-delay: 0.1s; }
        .delay-200 { animation-delay: 0.2s; }
    </style>
</head>
<body class="bg-black antialiased text-white overflow-x-hidden">
    
    <!-- Background Gradient -->
    <div class="fixed inset-0 bg-gradient-to-br from-[#0A1F3D] via-black to-black -z-10"></div>

    <!-- Navbar -->
    <nav class="sticky top-0 z-50 bg-transparent backdrop-blur-md border-b border-white/5">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <!-- Logo -->
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-[#1C4D8D] to-[#153A6A] rounded-full flex items-center justify-center shadow-lg shadow-[#1C4D8D]/50">
                        <span class="text-white font-black text-lg">8</span>
                    </div>
                    <span class="text-xl font-bold text-white">BilliardClub</span>
                </div>
                
                <!-- Nav Links -->
                <div class="flex items-center gap-3">
                    <a href="{{ route('customer.dashboard') }}" class="px-4 py-2 text-gray-300 hover:text-white font-medium transition-colors">Dashboard</a>
                    <a href="{{ route('my-bookings') }}" class="px-4 py-2 text-white font-medium bg-[#1C4D8D]/20 rounded-full transition-colors">All Bookings</a>
                    <a href="{{ route('profile.edit') }}" class="px-4 py-2 text-gray-300 hover:text-white font-medium transition-colors">Profile</a>
                    <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                        @csrf
                        <button type="submit" class="px-6 py-2.5 bg-red-500/90 hover:bg-red-600 text-white font-semibold rounded-full transition-all duration-300 hover:scale-105">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-6 lg:px-8 py-12">
        
        <!-- Hero Section -->
        <div class="mb-12 opacity-0 fade-in-up">
            <div class="inline-flex items-center gap-2 px-4 py-2 bg-[#1C4D8D]/10 border border-[#1C4D8D]/30 rounded-full backdrop-blur-sm mb-4">
                <div class="w-2 h-2 bg-[#1C4D8D] rounded-full animate-pulse"></div>
                <span class="text-sm font-semibold text-[#5B9FD8]">Booking History</span>
            </div>
            <h1 class="text-5xl md:text-6xl font-black text-white leading-tight mb-4">
                My <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#5B9FD8] to-[#1C4D8D]">Bookings</span>
            </h1>
            <p class="text-xl text-gray-400 leading-relaxed">
                View and manage all your table reservations in one place.
            </p>
        </div>

        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="mb-6 bg-green-500/10 border border-green-500/30 backdrop-blur-sm rounded-2xl p-4 text-green-400 opacity-0 fade-in-up delay-100">
                <div class="flex items-center gap-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 bg-red-500/10 border border-red-500/30 backdrop-blur-sm rounded-2xl p-4 text-red-400 opacity-0 fade-in-up delay-100">
                <div class="flex items-center gap-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="font-medium">{{ session('error') }}</span>
                </div>
            </div>
        @endif

        <!-- Bookings Grid -->
        <section class="opacity-0 fade-in-up delay-200">
            @if($bookings->count() > 0)
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($bookings as $booking)
                        <div class="group bg-gradient-to-br from-white/5 to-white/[0.02] backdrop-blur-sm border border-white/10 rounded-3xl p-6 hover:border-[#1C4D8D]/50 transition-all duration-300 hover:scale-105 hover:shadow-2xl hover:shadow-[#1C4D8D]/20">
                            <div class="flex items-center justify-between mb-4">
                                <div class="text-2xl font-bold text-white">Table {{ $booking->table_number }}</div>
                                @if($booking->status == 'pending')
                                    <span class="px-3 py-1 bg-yellow-500/20 border border-yellow-500/30 text-yellow-400 text-xs font-bold rounded-full uppercase">Pending</span>
                                @elseif($booking->status == 'approved')
                                    <span class="px-3 py-1 bg-green-500/20 border border-green-500/30 text-green-400 text-xs font-bold rounded-full uppercase">Approved</span>
                                @elseif($booking->status == 'rejected')
                                    <span class="px-3 py-1 bg-red-500/20 border border-red-500/30 text-red-400 text-xs font-bold rounded-full uppercase">Rejected</span>
                                @else
                                    <span class="px-3 py-1 bg-gray-500/20 border border-gray-500/30 text-gray-400 text-xs font-bold rounded-full uppercase">Completed</span>
                                @endif
                            </div>
                            
                            <div class="space-y-2 text-gray-400 mb-4">
                                <div class="flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <span>{{ \Carbon\Carbon::parse($booking->start_time)->format('d M Y, H:i') }}</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span>{{ \Carbon\Carbon::parse($booking->start_time)->diffInHours($booking->end_time) }} Hours</span>
                                </div>
                                @if($booking->notes)
                                    <div class="flex items-start gap-2">
                                        <svg class="w-5 h-5 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        <span class="text-sm">{{ $booking->notes }}</span>
                                    </div>
                                @endif
                            </div>
                            
                            <div class="flex items-center justify-between mt-4 pt-4 border-t border-white/10">
                                <div class="text-2xl font-black text-transparent bg-clip-text bg-gradient-to-r from-[#5B9FD8] to-[#1C4D8D]">
                                    Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                                </div>
                                
                                @if($booking->status == 'pending')
                                    <form action="{{ route('booking.destroy', $booking->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this booking?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-4 py-2 bg-red-500/20 hover:bg-red-500/30 border border-red-500/30 hover:border-red-500/50 text-red-400 font-semibold text-sm rounded-full transition-all duration-300">
                                            Cancel
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <!-- Quick Stats -->
                <div class="mt-12 grid grid-cols-3 gap-6">
                    <div class="bg-gradient-to-br from-white/5 to-white/[0.02] backdrop-blur-sm border border-white/10 rounded-2xl p-6 text-center">
                        <div class="text-3xl font-black text-transparent bg-clip-text bg-gradient-to-r from-[#5B9FD8] to-[#1C4D8D] mb-2">
                            {{ $bookings->count() }}
                        </div>
                        <div class="text-gray-400 font-medium">Total Bookings</div>
                    </div>
                    <div class="bg-gradient-to-br from-white/5 to-white/[0.02] backdrop-blur-sm border border-white/10 rounded-2xl p-6 text-center">
                        <div class="text-3xl font-black text-yellow-400 mb-2">
                            {{ $bookings->where('status', 'pending')->count() }}
                        </div>
                        <div class="text-gray-400 font-medium">Pending</div>
                    </div>
                    <div class="bg-gradient-to-br from-white/5 to-white/[0.02] backdrop-blur-sm border border-white/10 rounded-2xl p-6 text-center">
                        <div class="text-3xl font-black text-green-400 mb-2">
                            {{ $bookings->where('status', 'approved')->count() }}
                        </div>
                        <div class="text-gray-400 font-medium">Approved</div>
                    </div>
                </div>
            @else
                <div class="bg-gradient-to-br from-white/5 to-white/[0.02] backdrop-blur-sm border border-white/10 rounded-3xl p-16 text-center">
                    <div class="text-8xl mb-6 opacity-50">📋</div>
                    <h3 class="text-2xl font-bold text-white mb-3">No Bookings Yet</h3>
                    <p class="text-xl text-gray-400 mb-8">You haven't made any bookings yet. Start your billiard experience now!</p>
                    <a href="{{ route('customer.dashboard') }}" class="inline-flex items-center gap-2 px-8 py-4 bg-gradient-to-r from-[#1C4D8D] to-[#153A6A] hover:from-[#2563B8] hover:to-[#1C4D8D] text-white font-bold text-lg rounded-full transition-all duration-300 hover:scale-105 hover:shadow-2xl hover:shadow-[#1C4D8D]/50">
                        Make a Booking
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </a>
                </div>
            @endif
        </section>
    </div>

    <!-- Footer -->
    <footer class="border-t border-white/5 py-8 mt-12">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="text-center text-gray-500 text-sm">
                <p>&copy; {{ date('Y') }} BilliardClub. All rights reserved.</p>
            </div>
        </div>
    </footer>

</body>
</html>