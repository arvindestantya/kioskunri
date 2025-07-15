<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use App\Models\Faculty;
use Illuminate\Http\Request;
use App\Exports\GuestsExport;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class GuestController extends Controller
{
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
                      ->orWhere('jenis_pengunjung', 'like', "%{$search}%")
                      ->orWhere('perihal', 'like', "%{$search}%");
            });
        }

        $guests = $guestsQuery->latest()->paginate(15)->withQueryString();

        $chartQuery = Guest::query();

        if (!$user->hasRole('Super Admin')) {
            $chartQuery->where('faculty_id', $user->faculty_id);
        }

        $guestChartData = $chartQuery
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        $chartLabels = $guestChartData->map(function ($item) {
            return \Carbon\Carbon::parse($item->date)->format('d M Y');
        });
        $chartData = $guestChartData->pluck('count');

        return view('admin.guests.index', [
            'guests' => $guests,
            'chartLabels' => $chartLabels,
            'chartData' => $chartData,
        ]);
    }

    public function destroy(Guest $guest)
    {
        $user = auth()->user();
        if (!$user->hasRole('Super Admin') && $guest->faculty_id !== $user->faculty_id) {
            abort(403, 'AKSI TIDAK DIIZINKAN.');
        }

        $guest->delete();

        return redirect()->route('guests')
                         ->with('success', 'Data tamu berhasil dihapus.');
    }

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