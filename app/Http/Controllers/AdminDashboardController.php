<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Faculty;
use App\Models\Guest;
use App\Models\Survey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $period = $request->input('period', 'all_time');

        $visitorData = [];
        $ratingData = [];
        $facultiesToProcess = [];

        if ($user->hasRole('Super Admin')) {
            $facultiesToProcess = Faculty::all();
        } elseif ($user->faculty) {
            $facultiesToProcess = collect([$user->faculty]);
        }

        foreach ($facultiesToProcess as $faculty) {
            $guestQuery = Guest::where('faculty_id', $faculty->id);
            $surveyQuery = Survey::where('faculty_id', $faculty->id);

            switch ($period) {
                case 'today':
                    $guestQuery->whereDate('created_at', today());
                    $surveyQuery->whereDate('created_at', today());
                    break;
                case 'week':
                    $guestQuery->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                    $surveyQuery->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                    break;
                case 'month':
                    $guestQuery->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()]);
                    $surveyQuery->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()]);
                    break;
            }

            $visitorData[$faculty->name] = $guestQuery->count();
            $averageRating = $surveyQuery->avg('rating');
            $ratingData[$faculty->name] = round($averageRating ?? 0, 1);
        }

        return view('admin.dashboard', [
            'visitorData' => $visitorData,
            'ratingData' => $ratingData,
            'currentPeriod' => $period,
        ]);
    }
}
