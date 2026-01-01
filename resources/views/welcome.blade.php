<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'BilliardClub') }} - Premium Billiard Booking</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=manrope:400,500,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
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
        .delay-400 { animation-delay: 0.4s; }
    </style>
</head>
<body class="bg-black antialiased text-white overflow-x-hidden">

    <!-- Navbar -->
    <nav class="fixed top-0 left-0 right-0 z-50 bg-transparent backdrop-blur-md border-b border-white/5">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <!-- Logo -->
                <div class="flex items-center gap-3 fade-in-up">
                    <div class="w-10 h-10 bg-gradient-to-br from-[#1C4D8D] to-[#153A6A] rounded-full flex items-center justify-center shadow-lg shadow-[#1C4D8D]/50">
                        <span class="text-white font-black text-lg">8</span>
                    </div>
                    <span class="text-xl font-bold text-white"><a href="{{ url('/') }}">BilliardClub</a></span>
                </div>
                
                <!-- Auth Buttons -->
                @if (Route::has('login'))
                    <div class="flex items-center gap-3 fade-in-up delay-100">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="px-6 py-2.5 bg-[#1C4D8D] hover:bg-[#2563B8] text-white font-semibold rounded-full transition-all duration-300 hover:scale-105 hover:shadow-lg hover:shadow-[#1C4D8D]/50">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="px-6 py-2.5 text-gray-300 hover:text-white font-medium transition-colors">
                                Login
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="px-6 py-2.5 bg-[#1C4D8D] hover:bg-[#2563B8] text-white font-semibold rounded-full transition-all duration-300 hover:scale-105 hover:shadow-lg hover:shadow-[#1C4D8D]/50">
                                    Register
                                </a>
                            @endif
                        @endauth
                    </div>
                @endif
            </div>
        </div>
    </nav>

    <!-- Hero Section - Split Layout -->
    <section class="min-h-screen pt-20 relative overflow-hidden">
        <!-- Background Gradient -->
        <div class="absolute inset-0 bg-gradient-to-br from-[#0A1F3D] via-black to-black"></div>
        
        <div class="relative z-10 max-w-7xl mx-auto px-6 lg:px-8 py-20">
            <div class="grid lg:grid-cols-2 gap-12 items-center min-h-[80vh]">
                
                <!-- Left: Text Content -->
                <div class="space-y-8 opacity-0 fade-in-up delay-200">
                    <!-- Badge -->
                    <div class="inline-flex items-center gap-2 px-4 py-2 bg-[#1C4D8D]/10 border border-[#1C4D8D]/30 rounded-full backdrop-blur-sm">
                        <div class="w-2 h-2 bg-[#1C4D8D] rounded-full animate-pulse"></div>
                        <span class="text-sm font-semibold text-[#5B9FD8]">Premium Billiard Club</span>
                    </div>
                    
                    <!-- Headline -->
                    <h1 class="text-5xl md:text-6xl lg:text-7xl font-black text-white leading-[1.1]">
                        Break Shot in
                        <span class="block text-transparent bg-clip-text bg-gradient-to-r from-[#5B9FD8] to-[#1C4D8D] mt-2">
                            Premium Atmosphere
                        </span>
                    </h1>
                    
                    <!-- Description -->
                    <p class="text-xl text-gray-400 leading-relaxed max-w-xl">
                        Experience world-class billiard tables in an exclusive club setting. Book your table instantly and play like a champion.
                    </p>
                    
                    <!-- CTA Button -->
                    <div class="flex flex-wrap gap-4">
                        @auth
                            <a href="{{ route('booking.create') }}" class="group inline-flex items-center gap-3 px-8 py-4 bg-[#1C4D8D] hover:bg-[#2563B8] text-white font-bold text-lg rounded-full transition-all duration-300 hover:scale-105 hover:shadow-2xl hover:shadow-[#1C4D8D]/50">
                                Book Your Table
                                <svg class="w-5 h-5 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                </svg>
                            </a>
                        @else
                            <a href="{{ route('register') }}" class="group inline-flex items-center gap-3 px-8 py-4 bg-[#1C4D8D] hover:bg-[#2563B8] text-white font-bold text-lg rounded-full transition-all duration-300 hover:scale-105 hover:shadow-2xl hover:shadow-[#1C4D8D]/50">
                                Get Started
                                <svg class="w-5 h-5 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                </svg>
                            </a>
                        @endauth
                        <a href="#features" class="inline-flex items-center gap-2 px-8 py-4 bg-white/5 hover:bg-white/10 border border-white/10 text-white font-semibold text-lg rounded-full backdrop-blur-sm transition-all duration-300">
                            Learn More
                        </a>
                    </div>
                    
                    <!-- Stats -->
                    <div class="grid grid-cols-3 gap-8 pt-8 border-t border-white/10">
                        <div>
                            <div class="text-3xl font-bold text-white mb-1">12+</div>
                            <div class="text-sm text-gray-500">Premium Tables</div>
                        </div>
                        <div>
                            <div class="text-3xl font-bold text-white mb-1">4.9★</div>
                            <div class="text-sm text-gray-500">Rating</div>
                        </div>
                        <div>
                            <div class="text-3xl font-bold text-white mb-1">2K+</div>
                            <div class="text-sm text-gray-500">Happy Players</div>
                        </div>
                    </div>
                </div>
                
                <!-- Right: Image with Floating Cards -->
                <div class="relative opacity-0 fade-in-up delay-400">
                    <!-- Main Image -->
                    <div class="relative rounded-[3rem] overflow-hidden shadow-2xl">
                        <img src="{{ asset('images/hero-billiard.jpg') }}" 
                             alt="Premium Billiard Table" 
                             class="w-full h-[600px] object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                    </div>
                    
                    <!-- Floating Card 1: Limited Slots -->
                    <div class="absolute top-8 -left-4 lg:left-8 bg-white/10 backdrop-blur-xl border border-white/20 rounded-2xl p-4 shadow-xl">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-red-500 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-white font-bold text-sm">Limited Slots</p>
                                <p class="text-gray-300 text-xs">3 tables available</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Floating Card 2: Live Match -->
                    <div class="absolute bottom-8 -right-4 lg:right-8 bg-[#1C4D8D]/90 backdrop-blur-xl border border-[#1C4D8D]/30 rounded-2xl p-4 shadow-xl">
                        <div class="flex items-center gap-3">
                            <div class="relative">
                                <div class="w-3 h-3 bg-red-500 rounded-full animate-pulse"></div>
                            </div>
                            <div>
                                <p class="text-white font-bold text-sm">Live Match</p>
                                <p class="text-blue-100 text-xs">VIP Room #2</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Grid -->
    <section id="features" class="py-24 bg-gradient-to-b from-black to-[#0A1F3D]/20">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <!-- Section Header -->
            <div class="text-center mb-16">
                <span class="inline-block px-4 py-2 bg-[#1C4D8D]/10 border border-[#1C4D8D]/30 rounded-full text-[#5B9FD8] text-sm font-semibold mb-4">
                    Premium Facilities
                </span>
                <h2 class="text-4xl md:text-5xl font-bold text-white mb-4">
                    World-Class Experience
                </h2>
                <p class="text-xl text-gray-400 max-w-2xl mx-auto">
                    Everything you need for the perfect billiard experience
                </p>
            </div>
            
            <!-- Features Grid -->
            <div class="grid md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="group relative bg-gradient-to-br from-white/5 to-white/[0.02] backdrop-blur-sm border border-white/10 rounded-3xl p-8 hover:border-[#1C4D8D]/50 transition-all duration-300 hover:scale-105 hover:shadow-2xl hover:shadow-[#1C4D8D]/20">
                    <div class="w-16 h-16 bg-gradient-to-br from-[#1C4D8D] to-[#153A6A] rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform shadow-lg shadow-[#1C4D8D]/50">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-3">International Standard Tables</h3>
                    <p class="text-gray-400 leading-relaxed">
                        Tournament-grade billiard tables with Aramith balls and Simonis cloth for perfect gameplay.
                    </p>
                </div>
                
                <!-- Feature 2 -->
                <div class="group relative bg-gradient-to-br from-white/5 to-white/[0.02] backdrop-blur-sm border border-white/10 rounded-3xl p-8 hover:border-[#1C4D8D]/50 transition-all duration-300 hover:scale-105 hover:shadow-2xl hover:shadow-[#1C4D8D]/20">
                    <div class="w-16 h-16 bg-gradient-to-br from-[#1C4D8D] to-[#153A6A] rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform shadow-lg shadow-[#1C4D8D]/50">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-3">Air-Conditioned VIP Rooms</h3>
                    <p class="text-gray-400 leading-relaxed">
                        Private VIP rooms with premium climate control for maximum comfort during extended sessions.
                    </p>
                </div>
                
                <!-- Feature 3 -->
                <div class="group relative bg-gradient-to-br from-white/5 to-white/[0.02] backdrop-blur-sm border border-white/10 rounded-3xl p-8 hover:border-[#1C4D8D]/50 transition-all duration-300 hover:scale-105 hover:shadow-2xl hover:shadow-[#1C4D8D]/20">
                    <div class="w-16 h-16 bg-gradient-to-br from-[#1C4D8D] to-[#153A6A] rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform shadow-lg shadow-[#1C4D8D]/50">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-3">Food & Beverage Service</h3>
                    <p class="text-gray-400 leading-relaxed">
                        Premium cafe and lounge with extensive menu. Enjoy drinks and snacks while you play.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Social Proof Section -->
    <section class="py-24 bg-gradient-to-b from-[#0A1F3D]/20 to-black">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="relative bg-gradient-to-br from-[#1C4D8D] to-[#153A6A] rounded-[3rem] p-12 md:p-16 overflow-hidden">
                <!-- Background Pattern -->
                <div class="absolute inset-0 opacity-10">
                    <div class="absolute top-0 left-0 w-64 h-64 bg-white rounded-full blur-3xl"></div>
                    <div class="absolute bottom-0 right-0 w-96 h-96 bg-white rounded-full blur-3xl"></div>
                </div>
                
                <div class="relative z-10 grid md:grid-cols-2 gap-12 items-center">
                    <div>
                        <h2 class="text-4xl md:text-5xl font-bold text-white mb-6">
                            Trusted by Thousands of Players
                        </h2>
                        <p class="text-blue-100 text-lg mb-8">
                            Join our community of passionate billiard enthusiasts and experience the best facilities in town.
                        </p>
                        
                        <!-- Review Stats -->
                        <div class="flex items-center gap-6 mb-8">
                            <div>
                                <div class="flex items-center gap-1 mb-2">
                                    <svg class="w-6 h-6 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                        <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                    </svg>
                                    <svg class="w-6 h-6 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                        <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                    </svg>
                                    <svg class="w-6 h-6 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                        <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                    </svg>
                                    <svg class="w-6 h-6 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                        <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                    </svg>
                                    <svg class="w-6 h-6 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                        <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                    </svg>
                                </div>
                                <p class="text-white font-bold text-2xl">4.9 out of 5</p>
                            </div>
                            <div class="h-12 w-px bg-white/20"></div>
                            <div>
                                <p class="text-white font-bold text-2xl">2,153</p>
                                <p class="text-blue-100 text-sm">Total Reviews</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Avatar Grid -->
                    <div class="relative">
                        <div class="bg-white/10 backdrop-blur-lg border border-white/20 rounded-3xl p-8">
                            <div class="flex items-center gap-4 mb-6">
                                <div class="flex -space-x-4">
                                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 border-2 border-white flex items-center justify-center text-white font-bold">A</div>
                                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-purple-400 to-purple-600 border-2 border-white flex items-center justify-center text-white font-bold">M</div>
                                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-pink-400 to-pink-600 border-2 border-white flex items-center justify-center text-white font-bold">R</div>
                                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-orange-400 to-orange-600 border-2 border-white flex items-center justify-center text-white font-bold">D</div>
                                </div>
                                <div class="text-white">
                                    <p class="font-bold">2,000+ Active Members</p>
                                    <p class="text-sm text-blue-100">Join our community</p>
                                </div>
                            </div>
                            
                            <div class="space-y-4">
                                <div class="flex items-start gap-3">
                                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-green-400 to-green-600 flex-shrink-0"></div>
                                    <div>
                                        <p class="text-white font-semibold text-sm">Ahmad Rizki</p>
                                        <p class="text-blue-100 text-xs">"Best billiard club in town! Professional tables and great atmosphere."</p>
                                    </div>
                                </div>
                                <div class="flex items-start gap-3">
                                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-indigo-400 to-indigo-600 flex-shrink-0"></div>
                                    <div>
                                        <p class="text-white font-semibold text-sm">Sinta Maharani</p>
                                        <p class="text-blue-100 text-xs">"Love the VIP rooms. Perfect for private games with friends!"</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-24 bg-black">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-4xl md:text-5xl font-bold text-white mb-6">
                    Ready to Play?
                </h2>
                <p class="text-xl text-gray-400 mb-10 max-w-2xl mx-auto">
                    Book your table now and experience premium billiard gaming at its finest.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    @auth
                        <a href="{{ route('booking.create') }}" class="inline-flex items-center gap-2 px-8 py-4 bg-[#1C4D8D] hover:bg-[#2563B8] text-white font-bold text-lg rounded-full transition-all duration-300 hover:scale-105 hover:shadow-2xl hover:shadow-[#1C4D8D]/50">
                            Book Now
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                            </svg>
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="inline-flex items-center gap-2 px-8 py-4 bg-[#1C4D8D] hover:bg-[#2563B8] text-white font-bold text-lg rounded-full transition-all duration-300 hover:scale-105 hover:shadow-2xl hover:shadow-[#1C4D8D]/50">
                            Get Started
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                            </svg>
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-black border-t border-white/5 py-8">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="text-center text-gray-500 text-sm">
                <p>&copy; {{ date('Y') }} {{ config('app.name', 'BilliardClub') }}. All rights reserved.</p>
            </div>
        </div>
    </footer>

</body>
</html>