<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register - {{ config('app.name') }}</title>
    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=manrope:400,500,600,700,800&display=swap" rel="stylesheet" />
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body { 
            font-family: 'Manrope', sans-serif; 
        }
    </style>
</head>
<body class="bg-black antialiased text-white overflow-x-hidden">

    <div class="min-h-screen flex flex-row-reverse">
        
        <!-- Form Section -->
        <div class="w-full md:w-1/2 flex flex-col justify-center px-8 md:px-24 py-12 relative bg-gradient-to-br from-[#0A1F3D] via-black to-black">
            <!-- Back to Home -->
            <div class="mb-8">
                <a href="/" class="flex items-center gap-3 group">
                    <div class="w-10 h-10 bg-gradient-to-br from-[#1C4D8D] to-[#153A6A] rounded-full flex items-center justify-center shadow-lg shadow-[#1C4D8D]/50 group-hover:scale-110 transition-transform">
                        <span class="text-white font-black text-lg">8</span>
                    </div>
                    <span class="text-xl font-bold text-white">BilliardClub</span>
                </a>
            </div>

            <!-- Heading -->
            <h2 class="text-4xl md:text-5xl font-black mb-3 text-white">Join the Club.</h2>
            <p class="text-gray-400 text-lg mb-10">Buat akun baru dan nikmati kemudahan booking.</p>

            <!-- Form -->
            <form method="POST" action="{{ route('register') }}" class="space-y-6">
                @csrf

                <!-- Name Field -->
                <div>
                    <label for="name" class="block font-semibold text-sm text-gray-300 mb-2">Nama Lengkap</label>
                    <input id="name" type="text" name="name" :value="old('name')" required autofocus autocomplete="name"
                        class="w-full px-4 py-3.5 rounded-xl border border-white/10 bg-white/5 backdrop-blur-sm text-white placeholder-gray-500 focus:border-[#1C4D8D] focus:ring-2 focus:ring-[#1C4D8D]/50 transition-all">
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Email Field -->
                <div>
                    <label for="email" class="block font-semibold text-sm text-gray-300 mb-2">Email</label>
                    <input id="email" type="email" name="email" :value="old('email')" required autocomplete="username"
                        class="w-full px-4 py-3.5 rounded-xl border border-white/10 bg-white/5 backdrop-blur-sm text-white placeholder-gray-500 focus:border-[#1C4D8D] focus:ring-2 focus:ring-[#1C4D8D]/50 transition-all">
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password Field -->
                <div>
                    <label for="password" class="block font-semibold text-sm text-gray-300 mb-2">Password</label>
                    <input id="password" type="password" name="password" required autocomplete="new-password"
                        class="w-full px-4 py-3.5 rounded-xl border border-white/10 bg-white/5 backdrop-blur-sm text-white placeholder-gray-500 focus:border-[#1C4D8D] focus:ring-2 focus:ring-[#1C4D8D]/50 transition-all">
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Password Confirmation Field -->
                <div>
                    <label for="password_confirmation" class="block font-semibold text-sm text-gray-300 mb-2">Konfirmasi Password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                        class="w-full px-4 py-3.5 rounded-xl border border-white/10 bg-white/5 backdrop-blur-sm text-white placeholder-gray-500 focus:border-[#1C4D8D] focus:ring-2 focus:ring-[#1C4D8D]/50 transition-all">
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full py-4 bg-gradient-to-r from-[#1C4D8D] to-[#2563B8] text-white font-bold text-lg rounded-full shadow-xl shadow-[#1C4D8D]/30 hover:shadow-2xl hover:shadow-[#1C4D8D]/50 hover:scale-[1.02] transition-all duration-300">
                    {{ __('Daftar Sekarang') }}
                </button>

                <!-- Login Link -->
                <p class="mt-6 text-center text-sm text-gray-400">
                    Sudah punya akun? 
                    <a href="{{ route('login') }}" class="font-bold text-[#5B9FD8] hover:text-[#1C4D8D] transition">Masuk disini</a>
                </p>
            </form>
        </div>

        <!-- Image Section -->
        <div class="hidden md:block w-1/2 relative overflow-hidden">
             <img src="{{ asset('images/auth-billiard.png') }}" 
                 alt="Billiard Club" 
                 class="absolute inset-0 w-full h-full object-cover">
            
            <!-- Blue Gradient Overlay -->
            <div class="absolute inset-0 bg-gradient-to-br from-[#2563B8]/80 via-[#1C4D8D]/70 to-black/90"></div>
            
            <!-- Quote Card -->
            <div class="absolute bottom-16 left-12 right-12">
                <div class="bg-white/10 backdrop-blur-xl border border-white/20 rounded-3xl p-8">
                    <h3 class="text-4xl font-black text-white mb-4 leading-tight">"Every shot counts."</h3>
                    <p class="text-lg text-blue-100 leading-relaxed">Bergabunglah dengan komunitas biliar terbesar dan tingkatkan skill Anda.</p>
                </div>
            </div>
        </div>

    </div>
</body>
</html>