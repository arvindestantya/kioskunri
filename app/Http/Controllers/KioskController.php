<?php

namespace App\Http\Controllers;

use App\Models\Faculty;
use App\Models\Schedule;

class KioskController extends Controller
{
    public function show(Faculty $faculty)
    {
        // Muat flyer yang hanya milik fakultas ini
        $flyers = $faculty->flyers()->latest()->get();
        $contacts = $faculty->contacts()->latest()->get();
        $schedules = Schedule::where(function ($query) use ($faculty) {
                $query->where('faculty_id', $faculty->id)
                      ->orWhereNull('faculty_id');
            })
            ->where('start_date', '>=', today()) // Hanya yang akan datang
            ->orderBy('start_date', 'asc')       // Urutkan dari yang paling dekat
            ->take(5)                           // Ambil 5 jadwal teratas
            ->get();
        
        return view('kiosk', compact('faculty', 'flyers', 'contacts', 'schedules'));
    }
}