<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use App\Models\Faculty;
use Illuminate\Http\Request;
use Illuminate\Support\Str; // <-- Perbaikan ada di sini
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\GuestsExport;

class GuestController extends Controller
{
    /**
     * Menyimpan data tamu baru dari form untuk fakultas tertentu.
     */
    public function store(Request $request, Faculty $faculty)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'no_handphone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'jenis_pengunjung' => 'required|string|in:mahasiswa,dosen,tendik,umum',
            'perihal' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $guestData = $validator->validated();
        $guestData['faculty_id'] = $faculty->id;

        $guest = Guest::create($guestData);

        return response()->json(['message' => 'Data tamu berhasil disimpan!', 'data' => $guest], 201);
    }

    /**
     * Menampilkan semua data tamu untuk admin dengan fitur PENCARIAN.
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        $search = $request->input('search');
        
        $guestsQuery = Guest::query();

        if ($user->hasRole('Super Admin')) {
            $guestsQuery->with('faculty'); 
        } else {
            $guestsQuery->where('faculty_id', $user->faculty_id);
        }

        if ($search) {
            $guestsQuery->where(function($query) use ($search) {
                $query->where('nama', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhere('no_handphone', 'like', "%{$search}%")
                      ->orWhere('perihal', 'like', "%{$search}%");
            });
        }

        $guests = $guestsQuery->latest()->paginate(15)->withQueryString();
        
        return view('admin.guests.index', compact('guests'));
    }

    /**
     * Menghapus data tamu.
     */
    public function destroy(Guest $guest)
    {
        $user = auth()->user();
        if (!$user->hasRole('Super Admin') && $guest->faculty_id !== $user->faculty_id) {
            abort(403, 'AKSI TIDAK DIIZINKAN.');
        }

        $guest->delete();

        return redirect()->route('dashboard')
                         ->with('success', 'Data tamu berhasil dihapus.');
    }

    /**
     * Mengekspor data tamu ke Excel, disesuaikan dengan peran user.
     */
    public function export(Request $request)
    {
        $user = auth()->user();
        $search = $request->input('search');

        $facultyId = $user->faculty_id;
        $isSuperAdmin = $user->hasRole('Super Admin');

        $filename = 'data-tamu-' . date('Y-m-d');
        if (!$isSuperAdmin && $user->faculty) {
            $filename .= '-' . Str::slug($user->faculty->name);
        }
        $filename .= '.xlsx';

        return Excel::download(new GuestsExport($search, $facultyId, $isSuperAdmin), $filename);
    }
}