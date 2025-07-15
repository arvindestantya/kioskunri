<?php

namespace App\Exports;

use App\Models\Survey;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SurveysExport implements FromQuery, WithHeadings, WithMapping
{
    protected $search;
    protected $facultyId;
    protected $isSuperAdmin;

    public function __construct($search, $facultyId, $isSuperAdmin)
    {
        $this->search = $search;
        $this->facultyId = $facultyId;
        $this->isSuperAdmin = $isSuperAdmin;
    }

    public function query()
    {
        $query = Survey::query();

        if (!$this->isSuperAdmin) {
            $query->where('faculty_id', $this->facultyId);
        }

        if ($this->search) {
            $query->where(function($q) {
                $q->where('nama', 'like', '%' . $this->search . '%')
                  ->orWhere('rating', 'like', '%' . $this->search . '%')
                  ->orWhere('pesan', 'like', '%' . $this->search . '%');
            });
        }
        
        if($this->isSuperAdmin) {
            $query->with('faculty');
        }

        return $query->latest();
    }

    public function headings(): array
    {
        $headings = [
            'ID',
            'Nama',
            'Rating',
            'Pesan',
        ];

        if ($this->isSuperAdmin) {
            array_splice($headings, 1, 0, 'Fakultas');
        }

        return $headings;
    }

    public function map($survey): array
    {
        $data = [
            $survey->id,
            $survey->nama,
            $survey->rating,
            $survey->pesan,
            $survey->created_at->format('Y-m-d H:i:s'),
        ];

        if ($this->isSuperAdmin) {
            array_splice($data, 1, 0, $survey->faculty->name ?? 'N/A');
        }

        return $data;
    }
}