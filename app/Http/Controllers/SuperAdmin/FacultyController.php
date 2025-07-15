<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Faculty;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FacultyController extends Controller
{
    public function index()
    {
        $faculties = Faculty::withCount('users')->latest()->paginate(10);
        return view('superadmin.faculties.index', compact('faculties'));
    }

    public function create()
    {
        return view('superadmin.faculties.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:faculties,name',
        ]);

        Faculty::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return redirect()->route('superadmin.faculties.index')
                         ->with('success', 'Fakultas berhasil ditambahkan.');
    }

    public function edit(Faculty $faculty)
    {
        return view('superadmin.faculties.edit', compact('faculty'));
    }

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

    public function destroy(Faculty $faculty)
    {
        // Untuk keamanan, Anda mungkin ingin menambahkan logika untuk mencegah penghapusan jika masih ada user terhubung.
        // Contoh: if ($faculty->users()->count() > 0) { return back()->with('error', 'Tidak bisa dihapus, masih ada user terhubung.'); }

        $faculty->delete();

        return redirect()->route('superadmin.faculties.index')
                         ->with('success', 'Fakultas berhasil dihapus.');
    }
}