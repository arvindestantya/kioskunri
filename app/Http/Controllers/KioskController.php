<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use App\Models\Faculty;
use App\Models\Schedule;
use Illuminate\Support\Facades\DB;

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
            // ->where('start_date', '>=', today()) // Hanya yang akan datang
            ->orderBy('start_date', 'asc')       // Urutkan dari yang paling dekat
            ->take(5)                           // Ambil 5 jadwal teratas
            ->get();
        
        // 1. Hitung pengunjung berdasarkan periode
        $todayVisitorCount = Guest::where('faculty_id', $faculty->id)->whereDate('created_at', today())->count();
        $weekVisitorCount = Guest::where('faculty_id', $faculty->id)->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count();
        $monthVisitorCount = Guest::where('faculty_id', $faculty->id)->whereMonth('created_at', now()->month)->count();

        // 2. Hitung komposisi pengunjung untuk grafik
        $visitorTypeCounts = Guest::where('faculty_id', $faculty->id)
            ->select('jenis_pengunjung', DB::raw('count(*) as total'))
            ->groupBy('jenis_pengunjung')
            ->get();

        // 3. Siapkan data untuk Chart.js
        $visitorTypeLabels = $visitorTypeCounts->pluck('jenis_pengunjung')->map(fn($val) => ucfirst($val));
        $visitorTypeData = $visitorTypeCounts->pluck('total');
        
        return view('kiosk', compact('faculty', 'flyers', 'contacts', 'schedules','todayVisitorCount','weekVisitorCount', 'monthVisitorCount', 'visitorTypeLabels', 'visitorTypeData'));
    }
}