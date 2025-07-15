<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Guest;
use App\Models\Faculty;
use App\Models\Schedule;
use App\Models\Announcement;
use Illuminate\Support\Facades\DB;

class KioskController extends Controller
{
    public function show(Faculty $faculty)
    {
        $flyers = $faculty->flyers()->latest()->get();
        $contacts = $faculty->contacts()->latest()->get();
        $schedules = Schedule::where(function ($query) use ($faculty) {
                $query->where('faculty_id', $faculty->id)
                      ->orWhereNull('faculty_id');
            })
            // ->where('start_date', '>=', today()) // Hanya yang akan datang
            ->orderBy('start_date', 'asc')
            ->take(5)                     
            ->get();
        
        $announcements = Announcement::where(function ($query) use ($faculty) {
                $query->where('faculty_id', $faculty->id)
                      ->orWhereNull('faculty_id');
            })
            ->latest()
            ->take(5) 
            ->get();
        
        $events = Event::where(function ($query) use ($faculty) {
                $query->where('faculty_id', $faculty->id)
                      ->orWhereNull('faculty_id');
            })
            // ->where('start_time', '>=', now()) // Hanya tampilkan yang belum lewat
            ->orderBy('start_time', 'asc')
            ->take(5)  
            ->get();

        $todayVisitorCount = Guest::where('faculty_id', $faculty->id)->whereDate('created_at', today())->count();
        $weekVisitorCount = Guest::where('faculty_id', $faculty->id)->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count();
        $monthVisitorCount = Guest::where('faculty_id', $faculty->id)->whereMonth('created_at', now()->month)->count();

        $visitorTypeCounts = Guest::where('faculty_id', $faculty->id)
            ->select('jenis_pengunjung', DB::raw('count(*) as total'))
            ->groupBy('jenis_pengunjung')
            ->get();

        $visitorTypeLabels = $visitorTypeCounts->pluck('jenis_pengunjung')->map(fn($val) => ucfirst($val));
        $visitorTypeData = $visitorTypeCounts->pluck('total');
        
        return view('kiosk', compact('faculty', 'flyers', 'contacts', 'schedules', 'announcements','todayVisitorCount','weekVisitorCount', 'monthVisitorCount', 'visitorTypeLabels', 'visitorTypeData', 'events'));
    }
}