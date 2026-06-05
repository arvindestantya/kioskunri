<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Survey;
use App\Models\PermohonanInformasi;
use App\Models\KeberatanInformasi;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PermohonanExport;
use App\Exports\KeberatanExport;
use Illuminate\Http\Request;

class PpidDataController extends Controller
{
    /**
     * Helper function untuk menerapkan filter dan sorting
     */
    private function applyFilters($query, Request $request)
    {
        $modelName = class_basename($query->getModel());
        // Menerapkan Filter Pencarian
        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search, $modelName) {
                $q->where('nama', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");

                // [PERBAIKAN UTAMA] Sesuaikan kolom telepon berdasarkan model
                if ($modelName === 'PermohonanInformasi') {
                    $q->orWhere('no_hp', 'like', "%{$search}%");
                } elseif ($modelName === 'KeberatanInformasi') {
                    $q->orWhere('telepon', 'like', "%{$search}%");
                }

                // Tambahkan pencarian kolom teks panjang seperti informasi/alasan
                if (in_array($modelName, ['PermohonanInformasi', 'KeberatanInformasi'])) {
                    $q->orWhere('informasi', 'like', "%{$search}%")
                    ->orWhere('tujuan', 'like', "%{$search}%");
                }
            });
        }

        // Menerapkan Filter Tanggal
        if ($startDate = $request->get('start_date')) {
            $query->whereDate('created_at', '>=', $startDate);
        }
        if ($endDate = $request->get('end_date')) {
            $query->whereDate('created_at', '<=', $endDate);
        }

        // Menerapkan Sorting
        $sortColumn = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');
        $query->orderBy($sortColumn, $sortDirection);

        return $query;
    }

    public function listPermohonan(Request $request)
    {
        $query = PermohonanInformasi::with('faculty');
        $query = $this->applyFilters($query, $request);
        $permohonan = $query->paginate(20)->withQueryString();

        // Mengirim data ke view permohonan.blade.php
        return view('admin.ppid.permohonan', compact('permohonan'));
    }

    public function listKeberatan(Request $request)
    {
        $query = KeberatanInformasi::with('faculty');
        $query = $this->applyFilters($query, $request);
        $keberatan = $query->paginate(20)->withQueryString();

        // Mengirim data ke view keberatan.blade.php
        return view('admin.ppid.keberatan', compact('keberatan'));
    }

    public function exportPermohonan(Request $request)
    {
        $user = auth()->user();
        $search = $request->input('search');
        $facultyId = $user->faculty_id;
        $isSuperAdmin = $user->hasRole('Super Admin');

        $fileName = 'data-permohonan-' . date('Y-m-d');
        if (!$isSuperAdmin && $user->faculty) {
            $fileName .= '-' . \Illuminate\Support\Str::slug($user->faculty->name);
        }
        $fileName .= '.xlsx';

        return Excel::download(
            new PermohonanExport($search, $facultyId, $isSuperAdmin),
            $fileName
        );
    }

    public function exportKeberatan(Request $request)
    {
        $user = auth()->user();
        $search = $request->input('search');
        $facultyId = $user->faculty_id;
        $isSuperAdmin = $user->hasRole('Super Admin');

        $fileName = 'data-keberatan-' . date('Y-m-d');
        if (!$isSuperAdmin && $user->faculty) {
            $fileName .= '-' . \Illuminate\Support\Str::slug($user->faculty->name);
        }
        $fileName .= '.xlsx';

        return Excel::download(
            new KeberatanExport($search, $facultyId, $isSuperAdmin),
            $fileName
        );
    }
}
