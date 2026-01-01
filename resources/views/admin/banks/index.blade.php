@extends('layouts.admin-layout')

@section('header', 'Manajemen Bank')

@section('content')
<div class="space-y-6">
    <!-- Header with Add Button -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-white">Daftar Bank</h2>
            <p class="text-gray-400 mt-1">Kelola rekening bank untuk pembayaran</p>
        </div>
        <a href="{{ route('admin.banks.create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-[#1C4D8D] to-[#2563B8] text-white font-semibold rounded-full hover:shadow-lg hover:shadow-[#1C4D8D]/50 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
            Tambah Bank
        </a>
    </div>

    <!-- Banks List -->
    <div class="bg-gradient-to-br from-white/10 to-white/5 backdrop-blur-sm border border-white/10 rounded-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-white/5 border-b border-white/10">
                    <tr>
                        <th class="text-left py-4 px-6 text-sm font-semibold text-gray-300">Nama Bank</th>
                        <th class="text-left py-4 px-6 text-sm font-semibold text-gray-300">Nomor Rekening</th>
                        <th class="text-left py-4 px-6 text-sm font-semibold text-gray-300">Atas Nama</th>
                        <th class="text-right py-4 px-6 text-sm font-semibold text-gray-300">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($banks as $bank)
                    <tr class="border-b border-white/5 hover:bg-white/5 transition">
                        <td class="py-4 px-6">
                            <span class="text-white font-semibold">{{ $bank->bank_name }}</span>
                        </td>
                        <td class="py-4 px-6 text-gray-300 font-mono">{{ $bank->account_number }}</td>
                        <td class="py-4 px-6 text-gray-300">{{ $bank->account_holder }}</td>
                        <td class="py-4 px-6">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.banks.edit', $bank) }}" class="p-2 bg-[#1C4D8D]/20 hover:bg-[#1C4D8D] text-[#5B9FD8] hover:text-white rounded-lg transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>
                                <form action="{{ route('admin.banks.destroy', $bank) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus bank ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 bg-red-500/20 hover:bg-red-500 text-red-400 hover:text-white rounded-lg transition">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="py-12 text-center">
                            <div class="text-gray-500">
                                <svg class="w-16 h-16 mx-auto mb-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                </svg>
                                <p class="text-lg font-semibold">Belum ada bank</p>
                                <p class="text-sm mt-1">Tambahkan bank pertama Anda</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
