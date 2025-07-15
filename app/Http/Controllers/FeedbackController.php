<?php

namespace App\Http\Controllers;

use App\Models\Faculty;
use App\Models\Feedback;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Exports\FeedbacksExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;

class FeedbackController extends Controller
{
    public function store(Request $request, Faculty $faculty)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'kritik' => 'required|string',
            'saran' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $feedbackData = $validator->validated();
        $feedbackData['faculty_id'] = $faculty->id;

        $feedback = Feedback::create($feedbackData);

        return response()->json(['message' => 'Data tamu berhasil disimpan!', 'data' => $feedback], 201);
    }

    public function index(Request $request)
    {
        $user = auth()->user();
        $search = $request->input('search');
        
        $feedbacksQuery = Feedback::query();

        if ($user->hasRole('Super Admin')) {
            $feedbacksQuery->with('faculty'); 
        } else {
            $feedbacksQuery->where('faculty_id', $user->faculty_id);
        }

        if ($search) {
            $feedbacksQuery->where(function($query) use ($search) {
                $query->where('nama', 'like', "%{$search}%")
                      ->orWhere('kritik', 'like', "%{$search}%")
                      ->orWhere('saran', 'like', "%{$search}%");
            });
        }

        $feedbacks = $feedbacksQuery->latest()->paginate(15)->withQueryString();
        
        return view('admin.feedbacks.index', compact('feedbacks'));
    }

    public function destroy(Feedback $feedback)
    {
        $user = auth()->user();
        if (!$user->hasRole('Super Admin') && $feedback->faculty_id !== $user->faculty_id) {
            abort(403, 'AKSI TIDAK DIIZINKAN.');
        }

        $feedback->delete();

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

        return Excel::download(new FeedbacksExport($search, $facultyId, $isSuperAdmin), $filename);
    }
}
