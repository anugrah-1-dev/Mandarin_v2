<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banks;


class BankController extends Controller
{
    // Display a listing of the banks
    public function index()
    {
        $banks = Banks::all();
        return view('admin.banks.index', compact('banks'));
    }

    // Show the form for creating a new bank
    public function create()
    {
        return view('admin.banks.create');
    }

    // Store a newly created bank in storage
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'account_number' => 'required|string|max:50',
            'account_name' => 'required|string|max:255',
        ]);

        Banks::create($request->all());

        return redirect()->route('admin.banks.index')->with('success', 'Bank created successfully.');
    }

    // Show the form for editing the specified bank
    public function edit(Banks $bank)
    {
        return view('admin.banks.edit', compact('bank'));
    }

    // Update the specified bank in storage
    public function update(Request $request, Banks $bank)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'account_number' => 'required|string|max:50',
            'account_name' => 'required|string|max:255',
        ]);

        $bank->update($request->all());

        return redirect()->route('admin.banks.index')->with('success', 'Bank updated successfully.');
    }

    // Remove the specified bank from storage
    public function destroy(Banks $bank)
    {
        $bank->delete();

        return redirect()->route('admin.banks.index')->with('success', 'Bank deleted successfully.');
    }
}
