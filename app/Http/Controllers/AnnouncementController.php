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
                  ->orWhereNull('faculty_id'); // Tampilkan juga Pengumuman umum
        }

        $announcements = $query->latest()->get();

        return view('admin.announcements.index', compact('announcements'));
    }

    /**
     * Menampilkan form untuk membuat Pengumuman baru.
     */
    public function create()
    {
        $faculties = Faculty::orderBy('name')->get();
        return view('admin.announcements.create', compact('faculties'));
    }

    /**
     * Menyimpan Pengumuman baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'faculty_id' => 'nullable|exists:faculties,id', // 'nullable' untuk Pengumuman umum
        ]);

        Announcement::create($request->all());

        return redirect()->route('announcements.index')->with('success', 'Pengumuman baru berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit Pengumuman.
     */
    public function edit(Announcement $announcement)
    {
        $faculties = Faculty::orderBy('name')->get();
        return view('admin.announcements.edit', compact('announcement', 'faculties'));
    }

    /**
     * Memperbarui Pengumuman di database.
     */
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

    /**
     * Menghapus Pengumuman dari database.
     */
    public function destroy(Announcement $announcement)
    {
        // Otorisasi: hanya Super Admin atau admin dari fakultas yang sama yang bisa menghapus
        $user = Auth::user();
        if (!$user->hasRole('Super Admin') && $announcement->faculty_id !== $user->faculty_id) {
            abort(403, 'AKSI TIDAK DIIZINKAN.');
        }

        $announcement->delete();

        return redirect()->route('announcements.index')->with('success', 'Pengumuman berhasil dihapus.');
    }
}
