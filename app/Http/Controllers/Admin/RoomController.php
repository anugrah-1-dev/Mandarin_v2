<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rooms;
use App\Models\ProgramCamp;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index()
    {

        $programCamps = ProgramCamp::all();
        $rooms = Rooms::all();
        return view('admin.rooms.index', compact('rooms', 'programCamps'));
    }

    public function create()
    {
        $programs = ProgramCamp::all();
        return view('admin.rooms.create', compact('programs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'program_camp_id' => 'required|exists:program_camps,id',
            'nama' => 'required|string|max:50',
            'nomor_kamar' => 'required|string|max:50|unique:rooms,nomor_kamar',
            'gender' => 'required|in:putra,putri',
            'kategori' => 'required|in:VVIP,VIP,Barack',
            'kapasitas' => 'required|integer|min:1|max:6',
        ]);

        Rooms::create($validated); // Pastikan modelnya 'Room' bukan 'Rooms'

        return redirect()->route('admin.rooms.index')->with('success', 'Kamar berhasil ditambahkan!');
    }

    public function edit(Rooms $room)
    {
        $programs = ProgramCamp::all();
        return view('admin.rooms.edit', compact('room', 'programs'));
    }

    public function update(Request $request, Rooms $room)
    {
        $validated = $request->validate([
            'program_camp_id' => 'required|exists:program_camps,id',
            'nama' => 'required|string|max:50',
            'nomor_kamar' => 'required|string|max:50|unique:rooms,nomor_kamar,' . $room->id,
            'gender' => 'required|in:putra,putri',
            'kategori' => 'required|in:VVIP,VIP,Barack',
            'kapasitas' => 'required|integer|min:1|max:6',
        ]);

        $room->update($validated);

        return redirect()->route('rooms.index')->with('success', 'Data kamar berhasil diperbarui!');
    }

    public function destroy(Rooms $room)
    {
        $room->delete();
        return redirect()->route('rooms.index')->with('success', 'Kamar berhasil dihapus.');
    }
}
