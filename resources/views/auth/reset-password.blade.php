<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - BilliardClub</title>
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
    </style>
</head>
<body class="bg-black antialiased text-white overflow-x-hidden">
    
    <!-- Background Gradient -->
    <div class="fixed inset-0 bg-gradient-to-br from-[#0A1F3D] via-black to-black -z-10"></div>
    
    <!-- Animated Background Pattern -->
    <div class="fixed inset-0 -z-10 opacity-10">
        <div class="absolute top-20 left-20 w-96 h-96 bg-[#1C4D8D] rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute bottom-20 right-20 w-96 h-96 bg-[#153A6A] rounded-full blur-3xl animate-pulse" style="animation-delay: 2s;"></div>
    </div>

    <div class="min-h-screen flex items-center justify-center px-6 py-12">
        <div class="w-full max-w-md">
            
            <!-- Logo/Header -->
            <div class="text-center mb-8 opacity-0 fade-in-up">
                <a href="{{ url('/') }}" class="inline-flex items-center gap-3 mb-6">
                    <div class="w-14 h-14 bg-gradient-to-br from-[#1C4D8D] to-[#153A6A] rounded-full flex items-center justify-center shadow-lg shadow-[#1C4D8D]/50">
                        <span class="text-white font-black text-2xl">8</span>
                    </div>
                    <span class="text-2xl font-bold text-white">BilliardClub</span>
                </a>
                
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-[#1C4D8D]/10 border border-[#1C4D8D]/30 rounded-full backdrop-blur-sm mb-4">
                    <svg class="w-5 h-5 text-[#5B9FD8]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                    <span class="text-sm font-semibold text-[#5B9FD8]">Secure Reset</span>
                </div>
                
                <h1 class="text-3xl md:text-4xl font-black text-white mb-3">
                    Reset Your Password
                </h1>
                <p class="text-gray-400 text-base">
                    Enter your new password below to secure your account.
                </p>
            </div>

            <!-- Main Card -->
            <div class="bg-gradient-to-br from-white/5 to-white/[0.02] backdrop-blur-sm border border-white/10 rounded-3xl p-8 shadow-2xl opacity-0 fade-in-up delay-200">
                
                <form method="POST" action="{{ route('password.store') }}" class="space-y-6">
                    @csrf

                    <!-- Password Reset Token -->
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <!-- Email Input -->
                    <div>
                        <label for="email" class="block text-white font-bold text-lg mb-3 flex items-center gap-2">
                            <svg class="w-5 h-5 text-[#5B9FD8]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            Email Address
                        </label>
                        <input 
                            id="email" 
                            type="email" 
                            name="email" 
                            value="{{ old('email', $request->email) }}"
                            required 
                            autofocus
                            autocomplete="username"
                            class="w-full px-5 py-4 bg-[#1a1a1a] border border-white/20 rounded-2xl text-white text-base focus:border-[#1C4D8D] focus:ring-2 focus:ring-[#1C4D8D]/50 transition-all placeholder-gray-500"
                            placeholder="your.email@example.com"
                        >
                        @error('email')
                            <div class="mt-2 flex items-center gap-2 text-red-400 text-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Password Input -->
                    <div>
                        <label for="password" class="block text-white font-bold text-lg mb-3 flex items-center gap-2">
                            <svg class="w-5 h-5 text-[#5B9FD8]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                            New Password
                        </label>
                        <input 
                            id="password" 
                            type="password" 
                            name="password" 
                            required
                            autocomplete="new-password"
                            class="w-full px-5 py-4 bg-[#1a1a1a] border border-white/20 rounded-2xl text-white text-base focus:border-[#1C4D8D] focus:ring-2 focus:ring-[#1C4D8D]/50 transition-all placeholder-gray-500"
                            placeholder="Enter your new password"
                        >
                        @error('password')
                            <div class="mt-2 flex items-center gap-2 text-red-400 text-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Confirm Password Input -->
                    <div>
                        <label for="password_confirmation" class="block text-white font-bold text-lg mb-3 flex items-center gap-2">
                            <svg class="w-5 h-5 text-[#5B9FD8]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                            Confirm Password
                        </label>
                        <input 
                            id="password_confirmation" 
                            type="password" 
                            name="password_confirmation" 
                            required
                            autocomplete="new-password"
                            class="w-full px-5 py-4 bg-[#1a1a1a] border border-white/20 rounded-2xl text-white text-base focus:border-[#1C4D8D] focus:ring-2 focus:ring-[#1C4D8D]/50 transition-all placeholder-gray-500"
                            placeholder="Confirm your new password"
                        >
                        @error('password_confirmation')
                            <div class="mt-2 flex items-center gap-2 text-red-400 text-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Info Box -->
                    <div class="bg-[#1C4D8D]/10 border border-[#1C4D8D]/30 rounded-2xl p-4">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-[#5B9FD8] flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div class="text-sm text-blue-300">
                                <p class="font-semibold mb-1">Password Requirements:</p>
                                <ul class="space-y-1 text-xs">
                                    <li>• At least 8 characters long</li>
                                    <li>• Must match confirmation</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button 
                        type="submit" 
                        class="group w-full inline-flex items-center justify-center gap-3 px-8 py-4 bg-gradient-to-r from-[#1C4D8D] to-[#153A6A] hover:from-[#2563B8] hover:to-[#1C4D8D] text-white font-bold text-lg rounded-full transition-all duration-300 hover:scale-[1.02] hover:shadow-2xl hover:shadow-[#1C4D8D]/50"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Reset Password
                        <svg class="w-5 h-5 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </button>
                </form>
            </div>

            <!-- Additional Help -->
            <div class="mt-6 text-center opacity-0 fade-in-up delay-300">
                <p class="text-gray-500 text-sm">
                    Remember your password? 
                    <a href="{{ route('login') }}" class="text-[#5B9FD8] hover:text-[#1C4D8D] font-semibold transition-colors">
                        Back to Login
                    </a>
                </p>
            </div>
        </div>
    </div>

</body>
</html>
