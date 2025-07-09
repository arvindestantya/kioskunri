<?php

namespace App\Exports;

use App\Models\Survey;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SurveysExport implements FromQuery, WithHeadings, WithMapping
{
    protected $search;
    protected $facultyId; // <-- Properti baru
    protected $isSuperAdmin; // <-- Properti baru

    /**
     * Terima semua parameter yang dibutuhkan.
     */
    public function __construct($search, $facultyId, $isSuperAdmin)
    {
        $this->search = $search;
        $this->facultyId = $facultyId;
        $this->isSuperAdmin = $isSuperAdmin;
    }

    /**
     * Menyiapkan query database dengan filter yang benar.
     */
    public function query()
    {
        $query = Survey::query();

        // Jika user BUKAN Super Admin, filter berdasarkan fakultasnya.
        if (!$this->isSuperAdmin) {
            $query->where('faculty_id', $this->facultyId);
        }

        // Terapkan filter pencarian jika ada.
        if ($this->search) {
            $query->where(function($q) {
                $q->where('nama', 'like', '%' . $this->search . '%')
                  ->orWhere('rating', 'like', '%' . $this->search . '%')
                  ->orWhere('pesan', 'like', '%' . $this->search . '%');
            });
        }
        
        // Super admin melihat data dengan relasi fakultas
        if($this->isSuperAdmin) {
            $query->with('faculty');
        }

        return $query->latest();
    }

    /**
     * Mendefinisikan header. Header akan berbeda untuk Super Admin.
     */
    public function headings(): array
    {
        $headings = [
            'ID',
            'Nama',
            'Rating',
            'Pesan',
        ];

        // Jika Super Admin, tambahkan kolom Fakultas di awal.
        if ($this->isSuperAdmin) {
            array_splice($headings, 1, 0, 'Fakultas');
        }

        return $headings;
    }

    /**
     * Memetakan setiap baris data. Format akan berbeda untuk Super Admin.
     */
    public function map($survey): array
    {
        $data = [
            $survey->id,
            $survey->nama,
            $survey->rating,
            $survey->pesan,
            $survey->created_at->format('Y-m-d H:i:s'),
        ];

        // Jika Super Admin, tambahkan nama fakultas ke data.
        if ($this->isSuperAdmin) {
            array_splice($data, 1, 0, $survey->faculty->name ?? 'N/A');
        }

        return $data;
    }
}