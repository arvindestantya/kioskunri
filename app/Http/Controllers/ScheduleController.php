<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\Faculty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends Controller
{
    /**
     * Menampilkan daftar semua jadwal.
     */
    public function index()
    {
        $user = Auth::user();
        $query = Schedule::query()->with('faculty');

        if (!$user->hasRole('Super Admin')) {
            $query->where('faculty_id', $user->faculty_id)
                  ->orWhereNull('faculty_id'); // Tampilkan juga jadwal umum
        }

        $schedules = $query->latest('start_date')->get();

        return view('admin.schedules.index', compact('schedules'));
    }

    /**
     * Menampilkan form untuk membuat jadwal baru.
     */
    public function create()
    {
        $faculties = Faculty::orderBy('name')->get();
        return view('admin.schedules.create', compact('faculties'));
    }

    /**
     * Menyimpan jadwal baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'faculty_id' => 'nullable|exists:faculties,id', // 'nullable' untuk jadwal umum
        ]);

        Schedule::create($request->all());

        return redirect()->route('schedules.index')->with('success', 'Jadwal baru berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit jadwal.
     */
    public function edit(Schedule $schedule)
    {
        $faculties = Faculty::orderBy('name')->get();
        return view('admin.schedules.edit', compact('schedule', 'faculties'));
    }

    /**
     * Memperbarui jadwal di database.
     */
    public function update(Request $request, Schedule $schedule)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'faculty_id' => 'nullable|exists:faculties,id',
        ]);

        $schedule->update($request->all());

        return redirect()->route('schedules.index')->with('success', 'Jadwal berhasil diperbarui.');
    }

    /**
     * Menghapus jadwal dari database.
     */
    public function destroy(Schedule $schedule)
    {
        // Otorisasi: hanya Super Admin atau admin dari fakultas yang sama yang bisa menghapus
        $user = Auth::user();
        if (!$user->hasRole('Super Admin') && $schedule->faculty_id !== $user->faculty_id) {
            abort(403, 'AKSI TIDAK DIIZINKAN.');
        }

        $schedule->delete();

        return redirect()->route('schedules.index')->with('success', 'Jadwal berhasil dihapus.');
    }
}
