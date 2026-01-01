<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book a Table - Billiard Booking</title>
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
                    <a href="{{ route('customer.dashboard') }}" class="px-4 py-2 text-gray-300 hover:text-white font-medium transition-colors">Dashboard</a>
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

    <div class="max-w-4xl mx-auto px-6 lg:px-8 py-12">
        
        <!-- Hero Section -->
        <div class="mb-12 opacity-0 fade-in-up text-center">
            <div class="inline-flex items-center gap-2 px-4 py-2 bg-[#1C4D8D]/10 border border-[#1C4D8D]/30 rounded-full backdrop-blur-sm mb-4">
                <div class="w-2 h-2 bg-[#1C4D8D] rounded-full animate-pulse"></div>
                <span class="text-sm font-semibold text-[#5B9FD8]">Reserve Your Table</span>
            </div>
            <h1 class="text-5xl md:text-6xl font-black text-white leading-tight mb-4">
                Book a <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#5B9FD8] to-[#1C4D8D]">Table</span>
            </h1>
            <p class="text-xl text-gray-400 leading-relaxed max-w-2xl mx-auto">
                Select your preferred table, time, and duration. We'll confirm your booking shortly.
            </p>
        </div>

        <!-- Error Messages -->
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

        <!-- Booking Form -->
        <div class="bg-gradient-to-br from-white/5 to-white/[0.02] backdrop-blur-sm border border-white/10 rounded-3xl p-8 md:p-12 opacity-0 fade-in-up delay-200">
            <form action="{{ route('booking.store') }}" method="POST" class="space-y-6">
                @csrf
                
                <!-- Table Selection -->
                <div>
                    <label class="block text-white font-bold text-lg mb-3 flex items-center gap-2">
                        <svg class="w-6 h-6 text-[#5B9FD8]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        Select Table
                    </label>
                    <select name="table_number" id="table_select" class="w-full px-5 py-4 bg-[#1a1a1a] border border-white/20 rounded-2xl text-white text-lg focus:border-[#1C4D8D] focus:ring-2 focus:ring-[#1C4D8D]/50 transition-all" required>
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

                <!-- Date & Time -->
                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-white font-bold text-lg mb-3 flex items-center gap-2">
                            <svg class="w-6 h-6 text-[#5B9FD8]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            Start Time
                        </label>
                        <input type="datetime-local" name="start_time" class="w-full px-5 py-4 bg-[#1a1a1a] border border-white/20 rounded-2xl text-white text-lg focus:border-[#1C4D8D] focus:ring-2 focus:ring-[#1C4D8D]/50 transition-all" required>
                    </div>

                    <div>
                        <label class="block text-white font-bold text-lg mb-3 flex items-center gap-2">
                            <svg class="w-6 h-6 text-[#5B9FD8]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Duration
                        </label>
                        <select name="duration" id="duration_select" class="w-full px-5 py-4 bg-[#1a1a1a] border border-white/20 rounded-2xl text-white text-lg focus:border-[#1C4D8D] focus:ring-2 focus:ring-[#1C4D8D]/50 transition-all" required>
                            <option value="1" style="background-color: #1a1a1a; color: #ffffff;">1 Hour</option>
                            <option value="2" style="background-color: #1a1a1a; color: #ffffff;">2 Hours</option>
                            <option value="3" style="background-color: #1a1a1a; color: #ffffff;">3 Hours</option>
                            <option value="4" style="background-color: #1a1a1a; color: #ffffff;">4 Hours</option>
                            <option value="5" style="background-color: #1a1a1a; color: #ffffff;">5 Hours</option>
                        </select>
                        <div id="price_info" class="mt-2 text-sm text-[#5B9FD8] font-medium" style="display: none;">
                            Total: <span id="total_price">Rp 0</span>
                        </div>
                    </div>
                </div>

                <!-- Notes -->
                <div>
                    <label class="block text-white font-bold text-lg mb-3 flex items-center gap-2">
                        <svg class="w-6 h-6 text-[#5B9FD8]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Notes (Optional)
                    </label>
                    <textarea name="notes" rows="4" class="w-full px-5 py-4 bg-[#1a1a1a] border border-white/20 rounded-2xl text-white text-lg focus:border-[#1C4D8D] focus:ring-2 focus:ring-[#1C4D8D]/50 transition-all resize-none" placeholder="Any special requests? Let us know here..."></textarea>
                </div>

                <!-- Info Box -->
                <div class="bg-[#1C4D8D]/10 border border-[#1C4D8D]/30 rounded-2xl p-6">
                    <div class="flex items-start gap-3">
                        <svg class="w-6 h-6 text-[#5B9FD8] flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div class="text-[#5B9FD8]">
                            <p class="font-bold mb-1">Booking Information</p>
                            <p class="text-sm text-blue-300">Your booking will be pending until confirmed by our staff. You'll receive a notification once it's approved.</p>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center pt-4">
                    <a href="{{ route('customer.dashboard') }}" class="inline-flex items-center justify-center gap-2 px-8 py-4 bg-white/5 hover:bg-white/10 border border-white/10 text-white font-bold text-lg rounded-full transition-all duration-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Back to Dashboard
                    </a>
                    <button type="submit" class="group inline-flex items-center justify-center gap-3 px-8 py-4 bg-gradient-to-r from-[#1C4D8D] to-[#153A6A] hover:from-[#2563B8] hover:to-[#1C4D8D] text-white font-bold text-lg rounded-full transition-all duration-300 hover:scale-105 hover:shadow-2xl hover:shadow-[#1C4D8D]/50">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Confirm Booking
                        <svg class="w-5 h-5 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </button>
                </div>
            </form>
        </div>

        <!-- Features Highlight -->
        <div class="mt-12 grid md:grid-cols-3 gap-6 opacity-0 fade-in-up delay-300">
            <div class="bg-gradient-to-br from-white/5 to-white/[0.02] backdrop-blur-sm border border-white/10 rounded-2xl p-6 text-center">
                <div class="w-12 h-12 bg-gradient-to-br from-[#1C4D8D] to-[#153A6A] rounded-full flex items-center justify-center mx-auto mb-3 shadow-lg shadow-[#1C4D8D]/50">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <h3 class="text-white font-bold mb-2">Instant Booking</h3>
                <p class="text-gray-400 text-sm">Quick reservation process</p>
            </div>
            <div class="bg-gradient-to-br from-white/5 to-white/[0.02] backdrop-blur-sm border border-white/10 rounded-2xl p-6 text-center">
                <div class="w-12 h-12 bg-gradient-to-br from-[#1C4D8D] to-[#153A6A] rounded-full flex items-center justify-center mx-auto mb-3 shadow-lg shadow-[#1C4D8D]/50">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <h3 class="text-white font-bold mb-2">Secure Payment</h3>
                <p class="text-gray-400 text-sm">Safe and verified</p>
            </div>
            <div class="bg-gradient-to-br from-white/5 to-white/[0.02] backdrop-blur-sm border border-white/10 rounded-2xl p-6 text-center">
                <div class="w-12 h-12 bg-gradient-to-br from-[#1C4D8D] to-[#153A6A] rounded-full flex items-center justify-center mx-auto mb-3 shadow-lg shadow-[#1C4D8D]/50">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="text-white font-bold mb-2">Premium Service</h3>
                <p class="text-gray-400 text-sm">Top-notch experience</p>
            </div>
        </div>
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
        // Dynamic price calculation
        const tableSelect = document.getElementById('table_select');
        const durationSelect = document.getElementById('duration_select');
        const priceInfo = document.getElementById('price_info');
        const totalPriceSpan = document.getElementById('total_price');

        function updatePrice() {
            const selectedOption = tableSelect.options[tableSelect.selectedIndex];
            const pricePerHour = parseFloat(selectedOption.getAttribute('data-price') || 0);
            const duration = parseInt(durationSelect.value || 1);
            
            if (pricePerHour > 0) {
                const totalPrice = pricePerHour * duration;
                totalPriceSpan.textContent = 'Rp ' + totalPrice.toLocaleString('id-ID');
                priceInfo.style.display = 'block';
                
                // Update duration options with prices
                updateDurationOptions(pricePerHour);
            } else {
                priceInfo.style.display = 'none';
            }
        }

        function updateDurationOptions(pricePerHour) {
            const options = durationSelect.options;
            for (let i = 0; i < options.length; i++) {
                const hours = parseInt(options[i].value);
                const price = pricePerHour * hours;
                const hoursText = hours === 1 ? '1 Hour' : hours + ' Hours';
                options[i].textContent = hoursText + ' - Rp ' + price.toLocaleString('id-ID');
            }
        }

        tableSelect.addEventListener('change', updatePrice);
        durationSelect.addEventListener('change', updatePrice);
    </script>

</body>
</html>