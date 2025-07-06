<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer_Service;

class Customer_Service_Controller extends Controller
{

    public function index()
    {
        $customerServices = Customer_Service::all();
        return view('admin.customer_service.index', compact('customerServices'));
    }

    // Menampilkan form tambah contact person
    public function create()
    {
        return view('admin.customer_service.create');
    }

    // Menyimpan data contact person baru
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nomor' => 'required|numeric|digits_between:10,15',
        ]);

        Customer_Service::create($request->all());

        return redirect()->route('admin.customer_services.index')->with('success', 'Kontak CS berhasil ditambahkan.');
    }

    // Menampilkan detail contact person tertentu
    public function show($id)
    {
        $contact = Customer_Service::findOrFail($id);
        return view('admin.customer_services.show', compact('contact'));
    }

    // Menampilkan form edit contact person
    public function edit($id)
    {
        $contact = Customer_Service::findOrFail($id);
        return view('admin.customer_services.edit', compact('contact'));
    }

    // Menyimpan perubahan data contact person
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nomor' => 'required|string|max:16',
        ]);

        $contact = Customer_Service::findOrFail($id);
        $contact->update($request->only('nama', 'nomor'));

        return redirect()->route('admin.customer_services.index')->with('success', 'Contact person berhasil diperbarui.');
    }

    // Menghapus contact person
    public function destroy($id)
    {
        $contact = Customer_Service::findOrFail($id);
        $contact->delete();

        return redirect()->route('admin.customer_services.index')->with('success', 'Contact person berhasil dihapus.');
    }
}
