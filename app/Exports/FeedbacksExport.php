<?php

namespace App\Exports;

use App\Models\Feedback;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class FeedbacksExport implements FromQuery, WithHeadings, WithMapping
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
        $query = Feedback::query();

        if (!$this->isSuperAdmin) {
            $query->where('faculty_id', $this->facultyId);
        }

        if ($this->search) {
            $query->where(function($q) {
                $q->where('nama', 'like', '%' . $this->search . '%')
                  ->orWhere('kritik', 'like', '%' . $this->search . '%')
                  ->orWhere('saran', 'like', '%' . $this->search . '%');
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
            'Kritik',
            'Saran',
            'Tanggal Input',
        ];

        if ($this->isSuperAdmin) {
            array_splice($headings, 1, 0, 'Fakultas');
        }

        return $headings;
    }

    public function map($feedback): array
    {
        $data = [
            $feedback->id,
            $feedback->nama,
            $feedback->kritik,
            $feedback->saran,
            $feedback->created_at->format('Y-m-d H:i:s'),
        ];

        if ($this->isSuperAdmin) {
            array_splice($data, 1, 0, $feedback->faculty->name ?? 'N/A');
        }

        return $data;
    }
}