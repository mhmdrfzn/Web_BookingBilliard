@extends('layouts.admin-layout')

@section('header', 'Manajemen Meja/Produk')

@section('content')
<div class="space-y-6">
    <!-- Header with Add Button -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-white">Daftar Meja & Produk</h2>
            <p class="text-gray-400 mt-1">Kelola meja billiard dan produk lainnya</p>
        </div>
        <a href="{{ route('admin.products.create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-[#1C4D8D] to-[#2563B8] text-white font-semibold rounded-full hover:shadow-lg hover:shadow-[#1C4D8D]/50 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
            Tambah Produk
        </a>
    </div>

    <!-- Products Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($products as $product)
        <div class="bg-gradient-to-br from-white/10 to-white/5 backdrop-blur-sm border border-white/10 rounded-2xl overflow-hidden hover:scale-105 transition-transform">
            @if($product->image)
            <div class="h-48 bg-gradient-to-br from-[#1C4D8D]/20 to-[#0A1F3D]/20">
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
            </div>
            @else
            <div class="h-48 bg-gradient-to-br from-[#1C4D8D]/20 to-[#0A1F3D]/20 flex items-center justify-center">
                <svg class="w-16 h-16 text-white/20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                </svg>
            </div>
            @endif

            <div class="p-6">
                <h3 class="text-xl font-bold text-white mb-2">{{ $product->name }}</h3>
                @if($product->description)
                <p class="text-sm text-gray-400 mb-4 line-clamp-2">{{ $product->description }}</p>
                @endif
                <div class="flex items-center justify-between mb-4">
                    <span class="text-2xl font-black text-[#5B9FD8]">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                    <span class="text-xs text-gray-500">per jam</span>
                </div>

                <div class="flex gap-2">
                    <a href="{{ route('admin.products.edit', $product) }}" class="flex-1 px-4 py-2 bg-[#1C4D8D] hover:bg-[#2563B8] text-white font-semibold rounded-lg text-center transition">
                        Edit
                    </a>
                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 bg-red-500/20 hover:bg-red-500 text-red-400 hover:text-white font-semibold rounded-lg transition">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full">
            <div class="bg-gradient-to-br from-white/10 to-white/5 backdrop-blur-sm border border-white/10 rounded-2xl p-12 text-center">
                <svg class="w-20 h-20 mx-auto mb-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                </svg>
                <p class="text-lg font-semibold text-gray-400">Belum ada produk/meja</p>
                <p class="text-sm text-gray-500 mt-1">Tambahkan produk pertama Anda</p>
            </div>
        </div>
        @endforelse
    </div>
</div>
@endsection
