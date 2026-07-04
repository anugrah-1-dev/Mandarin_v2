<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transports;

class TransportsController extends Controller
{
    public function index()
    {
        $transports = Transports::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.transports.index', compact('transports'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|integer|min:0',
            'status' => 'required|in:active,inactive',
            'bank_name' => 'nullable|string|max:100',
            'bank_number' => 'nullable|string|max:50',
            'bank_owner' => 'nullable|string|max:100',
        ]);

        Transports::create([
            'name' => $request->name,
            'price' => $request->price,
            'status' => $request->status,
            'bank_name' => $request->bank_name,
            'bank_number' => $request->bank_number,
            'bank_owner' => $request->bank_owner,
        ]);

        return redirect()->back()->with('alert', [
            'icon' => 'success',
            'title' => 'Berhasil!',
            'text' => 'Transportasi berhasil ditambahkan.'
        ]);
    }

    public function edit($id)
    {
        $transport = Transports::findOrFail($id);
        return view('admin.transports-edit', compact('transport'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|integer|min:0',
            'status' => 'required|in:active,inactive',
            'bank_name' => 'nullable|string|max:100',
            'bank_number' => 'nullable|string|max:50',
            'bank_owner' => 'nullable|string|max:100',
        ]);

        $transport = Transports::findOrFail($id);
        $transport->update([
            'name' => $request->name,
            'price' => $request->price,
            'status' => $request->status,
            'bank_name' => $request->bank_name,
            'bank_number' => $request->bank_number,
            'bank_owner' => $request->bank_owner,
        ]);

        return redirect()->route('admin.transports.index')->with('alert', [
            'icon' => 'success',
            'title' => 'Berhasil!',
            'text' => 'Data transportasi berhasil diperbarui.'
        ]);
    }

    public function destroy($id)
    {
        $transport = Transports::findOrFail($id);
        $transport->delete();

        return redirect()->route('admin.transports.index')->with('alert', [
            'icon' => 'success',
            'title' => 'Berhasil!',
            'text' => 'Transports berhasil dihapus.'
        ]);
    }
}
