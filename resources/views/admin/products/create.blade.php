@extends('layouts.admin-layout')

@section('header', 'Tambah Produk')

@section('content')
<div class="max-w-2xl">
    <div class="mb-6">
        <a href="{{ route('admin.products.index') }}" class="inline-flex items-center gap-2 text-gray-400 hover:text-white transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali
        </a>
    </div>

    <div class="bg-gradient-to-br from-white/10 to-white/5 backdrop-blur-sm border border-white/10 rounded-2xl p-8">
        <h2 class="text-2xl font-bold text-white mb-6">Tambah Produk/Meja Baru</h2>

        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div>
                <label for="name" class="block text-sm font-semibold text-gray-300 mb-2">Nama Produk/Meja</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                    class="w-full px-4 py-3 rounded-xl border border-white/10 bg-white/5 text-white placeholder-gray-500 focus:border-[#1C4D8D] focus:ring-2 focus:ring-[#1C4D8D]/50 transition"
                    placeholder="Contoh: Meja Billiard VIP #1">
                @error('name')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="price" class="block text-sm font-semibold text-gray-300 mb-2">Harga (per jam)</label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">Rp</span>
                    <input type="number" name="price" id="price" value="{{ old('price') }}" required min="0" step="1000"
                        class="w-full pl-12 pr-4 py-3 rounded-xl border border-white/10 bg-white/5 text-white placeholder-gray-500 focus:border-[#1C4D8D] focus:ring-2 focus:ring-[#1C4D8D]/50 transition"
                        placeholder="50000">
                </div>
                @error('price')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="description" class="block text-sm font-semibold text-gray-300 mb-2">Deskripsi (Opsional)</label>
                <textarea name="description" id="description" rows="4"
                    class="w-full px-4 py-3 rounded-xl border border-white/10 bg-white/5 text-white placeholder-gray-500 focus:border-[#1C4D8D] focus:ring-2 focus:ring-[#1C4D8D]/50 transition"
                    placeholder="Deskripsi produk/meja...">{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="image" class="block text-sm font-semibold text-gray-300 mb-2">Gambar (Opsional)</label>
                <input type="file" name="image" id="image" accept="image/*"
                    class="w-full px-4 py-3 rounded-xl border border-white/10 bg-white/5 text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-[#1C4D8D] file:text-white hover:file:bg-[#2563B8] transition">
                <p class="mt-2 text-xs text-gray-500">Format: JPG, PNG, GIF. Maksimal 2MB</p>
                @error('image')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-3 pt-4">
                <button type="submit" class="flex-1 px-6 py-3 bg-gradient-to-r from-[#1C4D8D] to-[#2563B8] text-white font-semibold rounded-full hover:shadow-lg hover:shadow-[#1C4D8D]/50 transition">
                    Simpan Produk
                </button>
                <a href="{{ route('admin.products.index') }}" class="px-6 py-3 bg-white/5 border border-white/10 text-gray-300 font-semibold rounded-full hover:bg-white/10 transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
