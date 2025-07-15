<?php

namespace App\Http\Controllers;

use App\Models\Flyer;
use App\Models\Faculty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FlyerController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $query = Flyer::query();
        $faculties = collect();

        if ($user->hasRole('Super Admin')) {
            $faculties = Faculty::orderBy('name')->get();
        } else {
            $query->where('faculty_id', $user->faculty_id);
        }

        $flyers = $query->with('faculty')->latest()->get();

        return view('admin.flyers.index', compact('flyers', 'faculties'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'flyer_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $user = auth()->user();
        $facultyId = null;

        if ($user->hasRole('Super Admin')) {
            $request->validate(['faculty_id' => 'required|exists:faculties,id']);
            $facultyId = $request->faculty_id;
        } else {
            $facultyId = $user->faculty_id;
            if (is_null($facultyId)) {
                return redirect()->back()->with('error', 'Akun Anda tidak terhubung dengan fakultas manapun.');
            }
        }

        $path = $request->file('flyer_image')->store('flyers', 'public');

        Flyer::create([
            'path' => $path,
            'faculty_id' => $facultyId,
        ]);

        return redirect()->route('flyers.index')->with('success', 'Flyer berhasil di-upload.');
    }

    public function destroy(Flyer $flyer)
    {
        $user = auth()->user();
        if (!$user->hasRole('Super Admin') && $flyer->faculty_id !== $user->faculty_id) {
            abort(403, 'AKSI TIDAK DIIZINKAN.');
        }

        Storage::disk('public')->delete($flyer->path);
        $flyer->delete();

        return redirect()->route('flyers.index')->with('success', 'Flyer berhasil dihapus.');
    }
}
