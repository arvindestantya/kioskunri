<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Faculty;
use App\Models\Guest;
use App\Models\Survey;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $visitorData = [];
        $ratingData = [];

        $facultiesToProcess = [];

        if ($user->hasRole('Super Admin')) {
            // Super Admin melihat semua fakultas
            $facultiesToProcess = Faculty::all();
        } elseif ($user->faculty) {
            // Admin biasa hanya "melihat" fakultasnya sendiri
            $facultiesToProcess = collect([$user->faculty]);
        }

        foreach ($facultiesToProcess as $faculty) {
            // Ambil jumlah pengunjung
            $visitorData[$faculty->name] = Guest::where('faculty_id', $faculty->id)->count();

            // Ambil rata-rata rating
            $averageRating = Survey::where('faculty_id', $faculty->id)->avg('rating');

            // PERBAIKAN: Jika avg() mengembalikan null (tidak ada survei), anggap nilainya 0.
            $ratingData[$faculty->name] = round($averageRating ?? 0, 1);
        }

        return view('admin.dashboard', [
            'visitorData' => $visitorData,
            'ratingData' => $ratingData,
        ]);
    }
}