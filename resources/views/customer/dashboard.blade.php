<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Billiard Booking</title>
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
        .delay-300 { animation-delay: 0.3s; }
        
        /* Improve select dropdown visibility */
        select {
            color-scheme: dark;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%239CA3AF' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 0.5rem center;
            background-repeat: no-repeat;
            background-size: 1.5em 1.5em;
            padding-right: 2.5rem;
        }
        select option {
            background-color: #1a1a1a;
            color: #ffffff;
            padding: 12px;
        }
        select option:checked,
        select option:hover {
            background-color: #1C4D8D;
            color: #ffffff;
        }
        
        /* Improve datetime input visibility */
        input[type="datetime-local"] {
            color-scheme: dark;
        }
        input[type="datetime-local"]::-webkit-calendar-picker-indicator {
            filter: invert(1);
            cursor: pointer;
        }
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
                    <a href="{{ route('customer.dashboard') }}" class="px-4 py-2 text-white font-medium bg-[#1C4D8D]/20 rounded-full transition-colors">Dashboard</a>
                    <a href="{{ route('my-bookings') }}" class="px-4 py-2 text-gray-300 hover:text-white font-medium transition-colors">All Bookings</a>
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
                <span class="text-sm font-semibold text-[#5B9FD8]">Customer Dashboard</span>
            </div>
            <h1 class="text-5xl md:text-6xl font-black text-white leading-tight mb-4">
                Welcome back, <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#5B9FD8] to-[#1C4D8D]">{{ Auth::user()->name }}!</span>
            </h1>
            <p class="text-xl text-gray-400 leading-relaxed">
                Manage your bookings, reserve tables, and explore our premium billiard facilities.
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

        @if($errors->any())
            <div class="mb-6 bg-red-500/10 border border-red-500/30 backdrop-blur-sm rounded-2xl p-4 text-red-400 opacity-0 fade-in-up delay-100">
                @foreach($errors->all() as $error)
                    <div class="flex items-center gap-3 mb-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                        <span>{{ $error }}</span>
                    </div>
                @endforeach
            </div>
        @endif

        <!-- My Bookings Section -->
        <section class="mb-12 opacity-0 fade-in-up delay-200">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-3xl font-bold text-white flex items-center gap-3">
                    <div class="w-1 h-8 bg-gradient-to-b from-[#5B9FD8] to-[#1C4D8D] rounded-full"></div>
                    My Recent Bookings
                </h2>
                <a href="{{ route('my-bookings') }}" class="px-4 py-2 bg-white/5 hover:bg-white/10 border border-white/10 text-white font-medium rounded-full backdrop-blur-sm transition-all duration-300">
                    View All
                </a>
            </div>
            
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
                            <div class="text-2xl font-black text-transparent bg-clip-text bg-gradient-to-r from-[#5B9FD8] to-[#1C4D8D]">
                                Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-gradient-to-br from-white/5 to-white/[0.02] backdrop-blur-sm border border-white/10 rounded-3xl p-12 text-center">
                    <div class="text-6xl mb-4 opacity-50">📋</div>
                    <p class="text-xl text-gray-400">You haven't made any bookings yet. Start by creating one below!</p>
                </div>
            @endif
        </section>

        <!-- Make a Booking Section -->
        <section class="mb-12 opacity-0 fade-in-up delay-300">
            <h2 class="text-3xl font-bold text-white mb-6 flex items-center gap-3">
                <div class="w-1 h-8 bg-gradient-to-b from-[#5B9FD8] to-[#1C4D8D] rounded-full"></div>
                Make a New Booking
            </h2>
            
            <div class="bg-gradient-to-br from-white/5 to-white/[0.02] backdrop-blur-sm border border-white/10 rounded-3xl p-8">
                <form action="{{ route('booking.store') }}" method="POST" class="grid md:grid-cols-2 gap-6">
                    @csrf
                    
                    <div>
                        <label class="block text-white font-semibold mb-2">Select Table</label>
                        <select name="table_number" id="dashboard_table_select" class="w-full px-4 py-3 bg-[#1a1a1a] border border-white/20 rounded-xl text-white focus:border-[#1C4D8D] focus:ring-2 focus:ring-[#1C4D8D]/50 transition-all" required>
                            <option value="" data-price="0" style="background-color: #1a1a1a; color: #9CA3AF;">-- Pilih Meja --</option>
                            @forelse($products as $product)
                                <option value="{{ $product->id }}" data-price="{{ $product->price }}" style="background-color: #1a1a1a; color: #ffffff;">
                                    {{ $product->name }} 
                                    @if($product->description)
                                        ({{ $product->description }}) 
                                    @endif
                                    - Rp {{ number_format($product->price, 0, ',', '.') }}/jam
                                </option>
                            @empty
                                <option value="" disabled style="background-color: #1a1a1a; color: #9CA3AF;">Tidak ada meja tersedia</option>
                            @endforelse
                        </select>
                    </div>

                    <div>
                        <label class="block text-white font-semibold mb-2">Start Time</label>
                        <input type="datetime-local" name="start_time" class="w-full px-4 py-3 bg-[#1a1a1a] border border-white/20 rounded-xl text-white focus:border-[#1C4D8D] focus:ring-2 focus:ring-[#1C4D8D]/50 transition-all" required>
                    </div>

                    <div>
                        <label class="block text-white font-semibold mb-2">Duration</label>
                        <select name="duration" id="dashboard_duration_select" class="w-full px-4 py-3 bg-[#1a1a1a] border border-white/20 rounded-xl text-white focus:border-[#1C4D8D] focus:ring-2 focus:ring-[#1C4D8D]/50 transition-all" required>
                            <option value="1" style="background-color: #1a1a1a; color: #ffffff;">1 Hour</option>
                            <option value="2" style="background-color: #1a1a1a; color: #ffffff;">2 Hours</option>
                            <option value="3" style="background-color: #1a1a1a; color: #ffffff;">3 Hours</option>
                            <option value="4" style="background-color: #1a1a1a; color: #ffffff;">4 Hours</option>
                            <option value="5" style="background-color: #1a1a1a; color: #ffffff;">5 Hours</option>
                        </select>
                        <div id="dashboard_price_info" class="mt-2 text-sm text-[#5B9FD8] font-medium" style="display: none;">
                            Total: <span id="dashboard_total_price">Rp 0</span>
                        </div>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-white font-semibold mb-2">Notes (Optional)</label>
                        <textarea name="notes" rows="3" class="w-full px-4 py-3 bg-[#1a1a1a] border border-white/20 rounded-xl text-white focus:border-[#1C4D8D] focus:ring-2 focus:ring-[#1C4D8D]/50 transition-all" placeholder="Any special requests or notes..."></textarea>
                    </div>

                    <div class="md:col-span-2 flex justify-center">
                        <button type="submit" class="group inline-flex items-center gap-3 px-8 py-4 bg-gradient-to-r from-[#1C4D8D] to-[#153A6A] hover:from-[#2563B8] hover:to-[#1C4D8D] text-white font-bold text-lg rounded-full transition-all duration-300 hover:scale-105 hover:shadow-2xl hover:shadow-[#1C4D8D]/50">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            Book Now
                            <svg class="w-5 h-5 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
        </section>

        <!-- Products Section -->
        <section class="opacity-0 fade-in-up delay-300">
            <h2 class="text-3xl font-bold text-white mb-6 flex items-center gap-3">
                <div class="w-1 h-8 bg-gradient-to-b from-[#5B9FD8] to-[#1C4D8D] rounded-full"></div>
                Our Premium Tables
            </h2>
            
            @if($products->count() > 0)
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($products as $product)
                        <div class="group bg-gradient-to-br from-white/5 to-white/[0.02] backdrop-blur-sm border border-white/10 rounded-3xl overflow-hidden hover:border-[#1C4D8D]/50 transition-all duration-300 hover:scale-105 hover:shadow-2xl hover:shadow-[#1C4D8D]/20 relative">
                            <!-- Availability Badge -->
                            <div class="absolute top-4 right-4 z-10">
                                @if($product->is_available)
                                    <span class="px-4 py-2 bg-green-500/90 backdrop-blur-sm border border-green-400/50 text-white text-xs font-bold rounded-full uppercase shadow-lg flex items-center gap-2">
                                        <div class="w-2 h-2 bg-white rounded-full animate-pulse"></div>
                                        Available
                                    </span>
                                @else
                                    <span class="px-4 py-2 bg-red-500/90 backdrop-blur-sm border border-red-400/50 text-white text-xs font-bold rounded-full uppercase shadow-lg flex items-center gap-2">
                                        <div class="w-2 h-2 bg-white rounded-full"></div>
                                        In Use
                                    </span>
                                @endif
                            </div>

                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-48 object-cover">
                            @else
                                <div class="w-full h-48 bg-gradient-to-br from-[#1C4D8D] to-[#153A6A] flex items-center justify-center">
                                    <span class="text-6xl">🎱</span>
                                </div>
                            @endif
                            <div class="p-6">
                                <h3 class="text-xl font-bold text-white mb-2">{{ $product->name }}</h3>
                                <p class="text-gray-400 mb-4">{{ $product->description ?? 'Premium billiard table' }}</p>
                                
                                @if(!$product->is_available && $product->current_booking)
                                    <div class="mb-3 px-3 py-2 bg-red-500/10 border border-red-500/30 rounded-lg">
                                        <p class="text-xs text-red-400 font-medium">
                                            Available at {{ \Carbon\Carbon::parse($product->current_booking->end_time)->format('H:i') }}
                                        </p>
                                    </div>
                                @endif
                                
                                <div class="text-2xl font-black text-transparent bg-clip-text bg-gradient-to-r from-[#5B9FD8] to-[#1C4D8D]">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}/hour
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-gradient-to-br from-white/5 to-white/[0.02] backdrop-blur-sm border border-white/10 rounded-3xl p-12 text-center">
                    <div class="text-6xl mb-4 opacity-50">🎱</div>
                    <p class="text-xl text-gray-400">No products available at the moment.</p>
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

    <script>
        // Dynamic price calculation for dashboard
        const dashTableSelect = document.getElementById('dashboard_table_select');
        const dashDurationSelect = document.getElementById('dashboard_duration_select');
        const dashPriceInfo = document.getElementById('dashboard_price_info');
        const dashTotalPriceSpan = document.getElementById('dashboard_total_price');

        function updateDashboardPrice() {
            const selectedOption = dashTableSelect.options[dashTableSelect.selectedIndex];
            const pricePerHour = parseFloat(selectedOption.getAttribute('data-price') || 0);
            const duration = parseInt(dashDurationSelect.value || 1);
            
            if (pricePerHour > 0) {
                const totalPrice = pricePerHour * duration;
                dashTotalPriceSpan.textContent = 'Rp ' + totalPrice.toLocaleString('id-ID');
                dashPriceInfo.style.display = 'block';
                
                // Update duration options with prices
                updateDashboardDurationOptions(pricePerHour);
            } else {
                dashPriceInfo.style.display = 'none';
            }
        }

        function updateDashboardDurationOptions(pricePerHour) {
            const options = dashDurationSelect.options;
            for (let i = 0; i < options.length; i++) {
                const hours = parseInt(options[i].value);
                const price = pricePerHour * hours;
                const hoursText = hours === 1 ? '1 Hour' : hours + ' Hours';
                options[i].textContent = hoursText + ' - Rp ' + price.toLocaleString('id-ID');
            }
        }

        dashTableSelect.addEventListener('change', updateDashboardPrice);
        dashDurationSelect.addEventListener('change', updateDashboardPrice);
    </script>

</body>
</html>
