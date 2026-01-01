<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use Illuminate\Http\Request;

class BankController extends Controller
{
    public function index()
    {
        $banks = Bank::orderBy('created_at', 'desc')->get();
        return view('admin.banks.index', compact('banks'));
    }

    public function create()
    {
        return view('admin.banks.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'bank_name' => 'required|string|max:255',
            'account_number' => 'required|string|max:255',
            'account_holder' => 'required|string|max:255',
        ]);

        Bank::create($validated);

        return redirect()
            ->route('admin.banks.index')
            ->with('success', 'Bank berhasil ditambahkan.');
    }

    public function edit(Bank $bank)
    {
        return view('admin.banks.edit', compact('bank'));
    }

    public function update(Request $request, Bank $bank)
    {
        $validated = $request->validate([
            'bank_name' => 'required|string|max:255',
            'account_number' => 'required|string|max:255',
            'account_holder' => 'required|string|max:255',
        ]);

        $bank->update($validated);

        return redirect()
            ->route('admin.banks.index')
            ->with('success', 'Bank berhasil diperbarui.');
    }

    public function destroy(Bank $bank)
    {
        $bank->delete();

        return redirect()
            ->route('admin.banks.index')
            ->with('success', 'Bank berhasil dihapus.');
    }
}
