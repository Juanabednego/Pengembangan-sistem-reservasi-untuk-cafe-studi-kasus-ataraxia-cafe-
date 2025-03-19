<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Support\Facades\Storage;

class KelolaEventController extends Controller
{
    public function index()
    {
        $events = Event::all();
        return view('admin.kelola-event', compact('events'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);
    
        // Cek apakah ada file yang diunggah
        if ($request->hasFile('image')) {
            // Ambil file dari request
            $image = $request->file('image');
    
            // Tentukan nama unik untuk file
            $imageName = time() . '_' . $image->getClientOriginalName();
    
            // Simpan langsung ke dalam folder `public/events`
            $image->move(public_path('events'), $imageName);
    
            // Simpan hanya nama file untuk database
            $imagePath = 'events/' . $imageName;
        } else {
            $imagePath = null;
        }
    
        // Simpan data ke database
        Event::create([
            'name' => $request->name,
            'description' => $request->description,
            'image' => $imagePath,
        ]);
    
        return redirect()->route('kelola-event')->with('success', 'Event berhasil ditambahkan!');
    }
    
    
    public function update(Request $request, $id)
    {
        $event = Event::findOrFail($id); // Temukan event berdasarkan ID
    
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);
    
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($event->image) {
                Storage::disk('public')->delete($event->image);
            }
            // Simpan gambar baru
            $event->image = $request->file('image')->store('events', 'public');
        }
    
        // Update data event
        $event->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);
    
        return redirect()->route('kelola-event')->with('success', 'Event berhasil diperbarui!');
    }
    

    public function destroy(Event $event)
    {
        if ($event->image) {
            Storage::disk('public')->delete($event->image);
        }

        $event->delete();

        return redirect()->route('kelola-event')->with('success', 'Event berhasil dihapus!');
    }

    public function showEvents()
    {
        $events = Event::all(); // Ambil semua event dari database
        return view('BookTable', compact('events')); // Kirim ke tampilan user
    }
}
