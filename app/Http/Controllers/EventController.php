<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Faculty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $query = Event::query()->with('faculty');

        if (!$user->hasRole('Super Admin')) {
            $query->where(function ($q) use ($user) {
                $q->where('faculty_id', $user->faculty_id)
                  ->orWhereNull('faculty_id');
            });
        }

        $events = $query->latest('start_time')->get();
        return view('admin.events.index', compact('events'));
    }

    public function create()
    {
        $faculties = Faculty::orderBy('name')->get();
        return view('admin.events.create', compact('faculties'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'faculty_id' => 'nullable|exists:faculties,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'start_time' => 'required|date',
            'end_time' => 'nullable|date|after_or_equal:start_time',
            'event_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('event_image')) {
            $imagePath = $request->file('event_image')->store('events', 'public');
        }

        Event::create([
            'faculty_id' => $validated['faculty_id'],
            'title' => $validated['title'],
            'description' => $validated['description'],
            'location' => $validated['location'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'path' => $imagePath, // KONSISTENSI: Menggunakan 'path' sesuai database
        ]);

        return redirect()->route('events.index')->with('success', 'Kegiatan baru berhasil diunggah.');
    }

    public function edit(Event $event)
    {
        $faculties = Faculty::orderBy('name')->get();
        return view('admin.events.edit', compact('event', 'faculties'));
    }

    public function update(Request $request, Event $event)
    {
        $request->validate([
            'faculty_id' => 'nullable|exists:faculties,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'start_time' => 'required|date',
            'end_time' => 'nullable|date|after_or_equal:start_time',
            'event_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $event->update($request->except('event_image'));

        if ($request->hasFile('event_image')) {
            // KONSISTENSI: Menggunakan properti 'path'
            if ($event->path) {
                Storage::disk('public')->delete($event->path);
            }
            // KONSISTENSI: Menyimpan ke properti 'path'
            $event->path = $request->file('event_image')->store('events', 'public');
        }
        
        $event->save();

        return redirect()->route('events.index')->with('success', 'Kegiatan berhasil diperbarui.');
    }

    public function destroy(Event $event)
    {
        // KONSISTENSI: Menggunakan properti 'path'
        if ($event->path) {
            Storage::disk('public')->delete($event->path);
        }

        $event->delete();
        return redirect()->route('events.index')->with('success', 'Kegiatan berhasil dihapus.');
    }
}