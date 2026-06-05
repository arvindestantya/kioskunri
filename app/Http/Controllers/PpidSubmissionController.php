<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Faculty;
use App\Models\PermohonanInformasi;
use App\Models\KeberatanInformasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PpidSubmissionController extends Controller
{
    /**
     * Menyimpan submission Permohonan Informasi baru.
     */
    public function storePermohonan(Request $request, Faculty $faculty)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'file_identitas' => 'required|file|mimes:jpg,jpeg,png,pdf|max:10240', // 10MB
            'alamat_ktp' => 'required|string',
            'alamat_sekarang' => 'nullable|string',
            'no_hp' => 'required|string',
            'email' => 'required|string',
            'informasi' => 'required|string',
            'tujuan' => 'required|string',
            'cara_memperoleh' => 'required|string',
            'cara_mendapatkan' => 'required|string',
            'tanggal' => 'required|date',
        ]);

        // Handle file upload
        $filePath = $request->file('file_identitas')->store('public/identitas/permohonan');

        // Simpan ke database
        $permohonan = $faculty->permohonanInformasi()->create([
            'nama' => $validated['nama'],
            'file_identitas' => $filePath,
            'alamat_ktp' => $validated['alamat_ktp'],
            'alamat_sekarang' => $validated['alamat_sekarang'],
            'no_hp' => $validated['no_hp'],
            'email' => $validated['email'],
            'informasi' => $validated['informasi'],
            'tujuan' => $validated['tujuan'],
            'cara_memperoleh' => $validated['cara_memperoleh'],
            'cara_mendapatkan' => $validated['cara_mendapatkan'],
            'tanggal' => $validated['tanggal'],
        ]);

        return response()->json([
            'message' => 'Permohonan informasi berhasil dikirim.',
            'data' => $permohonan
        ], 201);
    }

    /**
     * Menyimpan submission Keberatan Informasi baru.
     */
    public function storeKeberatan(Request $request, Faculty $faculty)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'file_identitas' => 'required|file|mimes:jpg,jpeg,png,pdf|max:10240', // 10MB
            'alamat_sekarang' => 'required|string',
            'telepon' => 'required|string|max:20',
            'email' => 'required|string',
            'informasi' => 'required|string',
            'tujuan' => 'required|string',
            'alasan' => 'required|string',
        ]);

        // Handle file upload
        $filePath = $request->file('file_identitas')->store('public/identitas/keberatan');

        // Simpan ke database
        $keberatan = $faculty->keberatanInformasi()->create([
            'nama' => $validated['nama'],
            'file_identitas' => $filePath,
            'alamat_sekarang' => $validated['alamat_sekarang'],
            'telepon' => $validated['telepon'],
            'email' => $validated['email'],
            'informasi' => $validated['informasi'],
            'tujuan' => $validated['tujuan'],
            'alasan' => $validated['alasan'],
        ]);

        return response()->json([
            'message' => 'Keberatan informasi berhasil dikirim.',
            'data' => $keberatan
        ], 201);
    }
}
