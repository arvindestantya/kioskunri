<?php

namespace App\Http\Controllers;

use App\Models\Faculty;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    //
    public function index()
    {
        $user = Auth::user();
        $query = Service::query()->with('faculty');

        if (!$user->hasRole('Super Admin')) {
            $query->where('faculty_id', $user->faculty_id);
        }

        $services = $query->latest()->get();

        return view('admin.services.index', compact('services'));
    }

    public function create()
    {
        $faculties = Faculty::orderBy('name')->get();
        return view('admin.services.create', compact('faculties'));
    }
    
    public function store(Request $request)
    {
        $user = Auth::user();
        $facultyId = $user->hasRole('Super Admin') ? $request->faculty_id : $user->faculty_id;

        $request->validate([
            'faculty_id' => 'required|exists:faculties,id',
            'nama_layanan' => 'required|string|max:255',
        ]);
        
        Service::create($request->all());
        
        return redirect()->route('services.index')->with('success', 'Layanan berhasil ditambahkan.');
    }
    
    public function edit(Service $service)
    {
        $faculties = Faculty::orderBy('name')->get();
        return view('admin.services.edit', compact('service', 'faculties'));
    }
    
    public function update(Request $request, Service $service)
    {
        $user = Auth::user();
        $facultyId = $user->hasRole('Super Admin') ? $request->faculty_id : $user->faculty_id;

        $request->validate([
            'faculty_id' => 'required|exists:faculties,id',
            'nama_layanan' => 'required|string|max:255',

        ]);

        $service->update($request->all());

        return redirect()->route('services.index')->with('success', 'Layanan berhasil diperbarui.');
    }

    public function destroy(Service $service)
    {
        $user = auth()->user();
        if (!$user->hasRole('Super Admin') && $service->faculty_id !== $user->faculty_id) {
            abort(403, 'AKSI TIDAK DIIZINKAN.');
        }

        $service->delete();

        return redirect()->route('services.index')->with('success', 'Layanan berhasil dihapus.');
    }
}
