<?php

namespace App\Exports;

use App\Models\Guest;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class GuestsExport implements FromQuery, WithHeadings, WithMapping
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
        $query = Guest::query();

        if (!$this->isSuperAdmin) {
            $query->where('faculty_id', $this->facultyId);
        }

        if ($this->search) {
            $query->where(function($q) {
                $q->where('nama', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%')
                  ->orWhere('no_handphone', 'like', '%' . $this->search . '%')
                  ->orWhere('no_identitas', 'like', '%' . $this->search . '%')
                  ->orWhere('nama_fakultas', 'like', '%' . $this->search . '%')
                  ->orWhere('jenis_layanan', 'like', '%' . $this->search . '%')
                  ->orWhere('perihal', 'like', '%' . $this->search . '%');
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
            'No. Handphone',
            'Email',
            'Jenis Pengunjung',
            'NIM/NUPTK/NIP',
            'Asal Fakultas',
            'Jenis Layanan',
            'Perihal Kunjungan',
            'Tanggal Input',
        ];

        if ($this->isSuperAdmin) {
            array_splice($headings, 1, 0, 'Fakultas');
        }

        return $headings;
    }

    public function map($guest): array
    {
        $data = [
            $guest->id,
            $guest->nama,
            $guest->no_handphone,
            $guest->email,
            ucfirst($guest->jenis_pengunjung),
            $guest->no_identitas,
            $guest->nama_fakultas,
            $guest->jenis_layanan,
            $guest->perihal,
            $guest->created_at->format('Y-m-d H:i:s'),
        ];

        if ($this->isSuperAdmin) {
            array_splice($data, 1, 0, $guest->faculty->name ?? 'N/A');
        }

        return $data;
    }
}