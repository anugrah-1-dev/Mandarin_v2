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

    public function edit(Rooms $room)
    {
        $programs = ProgramCamp::all();
        return view('admin.rooms.edit', compact('room', 'programs'));
    }
  
    public function update(Request $request, $id)
    {
        $room = Rooms::findOrFail($id);

        $request->validate([
            'gender' => 'required|in:putra,putri',
            'kategori' => 'required|in:vvip,vip,barack',
            'kapasitas' => 'required|integer|min:1',
            'penghuni' => 'required|integer|min:0',
        ]);

        $room->update([
            'gender' => $request->input('gender'),
            'kategori' => $request->input('kategori'),
            'kapasitas' => $request->input('kapasitas'),
            'penghuni' => $request->input('penghuni'),
        ]);

        return response()->json(['success' => true]);
    }





    public function destroy(Rooms $room)
    {
        $room->delete();
        return redirect()->route('rooms.index')->with('success', 'Kamar berhasil dihapus.');
    }
}
