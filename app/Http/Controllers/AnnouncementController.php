<?php

namespace App\Http\Controllers;

use App\Models\Faculty;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnnouncementController extends Controller
{
    //
    public function index()
    {
        $user = Auth::user();
        $query = Announcement::query()->with('faculty');

        if (!$user->hasRole('Super Admin')) {
            $query->where('faculty_id', $user->faculty_id)
                  ->orWhereNull('faculty_id');
        }

        $announcements = $query->latest()->get();

        return view('admin.announcements.index', compact('announcements'));
    }

    public function create()
    {
        $faculties = Faculty::orderBy('name')->get();
        return view('admin.announcements.create', compact('faculties'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'faculty_id' => 'nullable|exists:faculties,id',
        ]);

        Announcement::create($request->all());

        return redirect()->route('announcements.index')->with('success', 'Pengumuman baru berhasil ditambahkan.');
    }

    public function edit(Announcement $announcement)
    {
        $faculties = Faculty::orderBy('name')->get();
        return view('admin.announcements.edit', compact('announcement', 'faculties'));
    }

    public function update(Request $request, Announcement $announcement)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'faculty_id' => 'nullable|exists:faculties,id',
        ]);

        $announcement->update($request->all());

        return redirect()->route('announcements.index')->with('success', 'Pengumuman berhasil diperbarui.');
    }

    public function destroy(Announcement $announcement)
    {
        $user = Auth::user();
        if (!$user->hasRole('Super Admin') && $announcement->faculty_id !== $user->faculty_id) {
            abort(403, 'AKSI TIDAK DIIZINKAN.');
        }

        $announcement->delete();

        return redirect()->route('announcements.index')->with('success', 'Pengumuman berhasil dihapus.');
    }
}
