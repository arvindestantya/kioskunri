<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Faculty;
use App\Models\Map;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MapController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $facultiesForUpload = collect();
        $facultiesWithMaps = collect();

        if ($user->hasRole('Super Admin')) {
            // Super Admin bisa mengupload untuk semua fakultas
            $facultiesForUpload = Faculty::orderBy('name')->get();
            // Dan melihat semua denah yang ada
            $facultiesWithMaps = Faculty::has('maps')->with('maps')->get();
        } elseif ($user->faculty) {
            // Admin Fakultas hanya bisa mengupload untuk fakultasnya
            $facultiesForUpload = collect([$user->faculty]);
            // Dan hanya melihat denah fakultasnya
            $facultiesWithMaps = collect([$user->faculty->load('maps')]);
        }

        return view('admin.maps.index', compact('facultiesForUpload', 'facultiesWithMaps'));
    }

    public function create()
    {
        $faculties = Faculty::orderBy('name')->get();
        return view('admin.maps.create', compact('faculties'));
    }

    public function store(Request $request)
    {
        // Tambahkan validasi untuk 'title'
        $request->validate([
            'faculty_id' => 'required|exists:faculties,id',
            'title' => 'required|string|max:255', // <-- Validasi baru
            'map_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $path = $request->file('map_image')->store('maps', 'public');

        // Tambahkan 'title' saat membuat data baru
        Map::create([
            'faculty_id' => $request->faculty_id,
            'title' => $request->title, // <-- Simpan judul
            'path' => $path,
        ]);

        return redirect()->route('maps.index')->with('success', 'Denah baru berhasil diunggah.');
    }

    public function edit(Map $map)
    {
        return view('admin.maps.edit', compact('map'));
    }

    public function update(Request $request, Map $map)
    {
        // Tambahkan validasi untuk 'title'
        $request->validate([
            'title' => 'required|string|max:255', // <-- Validasi baru
            'map_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Dibuat nullable agar gambar tidak wajib diganti
        ]);

        // Update judul
        $map->title = $request->title;

        // Logika untuk mengganti gambar jika ada file baru
        if ($request->hasFile('map_image')) {
            // Hapus gambar lama
            Storage::disk('public')->delete($map->path);
            // Simpan gambar baru dan update path
            $map->path = $request->file('map_image')->store('maps', 'public');
        }

        $map->save();

        return redirect()->route('maps.index')->with('success', 'Denah berhasil diperbarui.');
    }

    public function destroy(Map $map)
    {
        Storage::disk('public')->delete($map->path);
        $map->delete();

        return redirect()->route('maps.index')->with('success', 'Denah berhasil dihapus.');
    }
}