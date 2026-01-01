@extends('layouts.admin-layout')

@section('header', 'Tambah Bank')

@section('content')
<div class="max-w-2xl">
    <div class="mb-6">
        <a href="{{ route('admin.banks.index') }}" class="inline-flex items-center gap-2 text-gray-400 hover:text-white transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali
        </a>
    </div>

    <div class="bg-gradient-to-br from-white/10 to-white/5 backdrop-blur-sm border border-white/10 rounded-2xl p-8">
        <h2 class="text-2xl font-bold text-white mb-6">Tambah Bank Baru</h2>

        <form action="{{ route('admin.banks.store') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label for="bank_name" class="block text-sm font-semibold text-gray-300 mb-2">Nama Bank</label>
                <input type="text" name="bank_name" id="bank_name" value="{{ old('bank_name') }}" required
                    class="w-full px-4 py-3 rounded-xl border border-white/10 bg-white/5 text-white placeholder-gray-500 focus:border-[#1C4D8D] focus:ring-2 focus:ring-[#1C4D8D]/50 transition"
                    placeholder="Contoh: BCA, Mandiri, BNI">
                @error('bank_name')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="account_number" class="block text-sm font-semibold text-gray-300 mb-2">Nomor Rekening</label>
                <input type="text" name="account_number" id="account_number" value="{{ old('account_number') }}" required
                    class="w-full px-4 py-3 rounded-xl border border-white/10 bg-white/5 text-white placeholder-gray-500 focus:border-[#1C4D8D] focus:ring-2 focus:ring-[#1C4D8D]/50 transition font-mono"
                    placeholder="1234567890">
                @error('account_number')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="account_holder" class="block text-sm font-semibold text-gray-300 mb-2">Atas Nama</label>
                <input type="text" name="account_holder" id="account_holder" value="{{ old('account_holder') }}" required
                    class="w-full px-4 py-3 rounded-xl border border-white/10 bg-white/5 text-white placeholder-gray-500 focus:border-[#1C4D8D] focus:ring-2 focus:ring-[#1C4D8D]/50 transition"
                    placeholder="Nama pemilik rekening">
                @error('account_holder')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-3 pt-4">
                <button type="submit" class="flex-1 px-6 py-3 bg-gradient-to-r from-[#1C4D8D] to-[#2563B8] text-white font-semibold rounded-full hover:shadow-lg hover:shadow-[#1C4D8D]/50 transition">
                    Simpan Bank
                </button>
                <a href="{{ route('admin.banks.index') }}" class="px-6 py-3 bg-white/5 border border-white/10 text-gray-300 font-semibold rounded-full hover:bg-white/10 transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
