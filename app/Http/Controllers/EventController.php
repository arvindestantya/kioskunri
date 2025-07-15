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
            $query->where('faculty_id', $user->faculty_id)
                  ->orWhereNull('faculty_id');
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
        $request->validate([
            'faculty_id' => 'required|exists:faculties,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'start_time' => 'required|date',
            'end_time' => 'nullable|date|after_or_equal:start_date',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $path = null;

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('events', 'public');
        }

        Event::create([
            'faculty_id' => $request->faculty_id,
            'title' => $request->title,
            'description' => $request->description,
            'location' => $request->location,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'image_path' => $path,
        ]);

        return redirect()->route('events.index')->with('success', 'Kegiatan baru berhasil diunggah.');
    }

    public function edit(Event $event)
    {
        return view('admin.events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'start_time' => 'required|date',
            'end_time' => 'nullable|date|after_or_equal:start_date',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $event->title = $request->title;
        $event->description = $request->description;
        $event->location = $request->location;
        $event->start_time = $request->start_time;
        $event->end_time = $request->end_time;

        if ($request->hasFile('image_path')) {
            Storage::disk('public')->delete($event->path);
            $event->path = $request->file('image_path')->store('events', 'public');
        }

        $event->save();

        return redirect()->route('events.index')->with('success', 'Kegiatan berhasil diperbarui.');
    }

    public function destroy(Event $event)
    {
        Storage::disk('public')->delete($event->path);
        $event->delete();

        return redirect()->route('events.index')->with('success', 'Kegiatan berhasil dihapus.');
    }
}
