<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Faculty;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Exports\SurveysExport;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use App\Models\Survey;

class SurveyController extends Controller
{
    public function store(Request $request, Faculty $faculty)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'pesan' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $survey = new Survey();
        $survey->faculty_id = $faculty->id;
        $survey->nama = $request->input('nama');
        $survey->rating = $request->input('rating');
        $survey->pesan = $request->input('pesan');
        $survey->save();

        return response()->json(['message' => 'Survei berhasil disimpan!'], 201);
    }

    public function index(Request $request)
    {
        $user = auth()->user();
        $search = $request->input('search');
        
        $surveysQuery = Survey::query();

        if ($user->hasRole('Super Admin')) {
            $surveysQuery->with('faculty'); 
        } else {
            $surveysQuery->where('faculty_id', $user->faculty_id);
        }

        if ($search) {
            $surveysQuery->where(function($query) use ($search) {
                $query->where('nama', 'like', "%{$search}%")
                      ->orWhere('rating', 'like', "%{$search}%")
                      ->orWhere('pesan', 'like', "%{$search}%");
            });
        }

        $surveys = $surveysQuery->latest()->paginate(15)->withQueryString();
        $ratingQuery = Survey::query();

        if (!$user->hasRole('Super Admin')) {
            $ratingQuery->where('faculty_id', $user->faculty_id);
        }

        $ratingChartData = $ratingQuery->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('AVG(rating) as avg_rating')
            )
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        $chartLabels = $ratingChartData->map(function ($item) {
            return \Carbon\Carbon::parse($item->date)->format('d M Y');
        });
        $chartData = $ratingChartData->map(function ($item) {
            return round($item->avg_rating, 2);
        });

        $overallQuery = Survey::query();
        
        if (!$user->hasRole('Super Admin')) {
            $overallQuery->where('faculty_id', $user->faculty_id);
        }
        
        $overallAverageRating = $overallQuery->avg('rating');
        $totalSurveys = $overallQuery->count();

        return view('admin.surveys.index', [
            'surveys' => $surveys,
            'chartLabels' => $chartLabels,
            'chartData' => $chartData,
            'overallAverageRating' => $overallAverageRating,
            'totalSurveys' => $totalSurveys,
        ]);
    }

    public function destroy(Survey $survey)
    {
        $user = auth()->user();
        if (!$user->hasRole('Super Admin') && $survey->faculty_id !== $user->faculty_id) {
            abort(403, 'AKSI TIDAK DIIZINKAN.');
        }

        $survey->delete();

        return redirect()->route('dashboard')
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

        return Excel::download(new SurveysExport($search, $facultyId, $isSuperAdmin), $filename);
    }
}