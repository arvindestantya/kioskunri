<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Faculty;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FacultyController extends Controller
{
    /**
     * Menampilkan daftar semua fakultas.
     */
    public function index()
    {
        $faculties = Faculty::withCount('users')->latest()->paginate(10);
        return view('superadmin.faculties.index', compact('faculties'));
    }

    /**
     * Menampilkan form untuk membuat fakultas baru.
     */
    public function create()
    {
        return view('superadmin.faculties.create');
    }

    /**
     * Menyimpan fakultas baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:faculties,name',
        ]);

        Faculty::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name), // Otomatis membuat slug, e.g., "Fakultas Teknik" -> "fakultas-teknik"
        ]);

        return redirect()->route('superadmin.faculties.index')
                         ->with('success', 'Fakultas berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit fakultas.
     */
    public function edit(Faculty $faculty)
    {
        return view('superadmin.faculties.edit', compact('faculty'));
    }

    /**
     * Memperbarui data fakultas di database.
     */
    public function update(Request $request, Faculty $faculty)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:faculties,name,' . $faculty->id,
        ]);

        $faculty->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return redirect()->route('superadmin.faculties.index')
                         ->with('success', 'Fakultas berhasil diperbarui.');
    }

    /**
     * Menghapus fakultas dari database.
     * PERHATIAN: Ini akan menghapus semua user, tamu, dan flyer yang terhubung dengannya karena `onDelete('cascade')`.
     */
    public function destroy(Faculty $faculty)
    {
        // Untuk keamanan, Anda mungkin ingin menambahkan logika untuk mencegah penghapusan jika masih ada user terhubung.
        // Contoh: if ($faculty->users()->count() > 0) { return back()->with('error', 'Tidak bisa dihapus, masih ada user terhubung.'); }

        $faculty->delete();

        return redirect()->route('superadmin.faculties.index')
                         ->with('success', 'Fakultas berhasil dihapus.');
    }
}