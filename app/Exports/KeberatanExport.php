<?php

namespace App\Exports;

use App\Models\KeberatanInformasi;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class KeberatanExport implements FromQuery, WithHeadings, WithMapping
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
        $query = KeberatanInformasi::query();

        if (!$this->isSuperAdmin) {
            $query->where('faculty_id', $this->facultyId);
        }

        if ($this->search) {
            $query->where(function($q) {
                $q->where('nama', 'like', '%' . $this->search . '%') // Kolom nama di DB
                  ->orWhere('email', 'like', '%' . $this->search . '%')
                  ->orWhere('telepon', 'like', '%' . $this->search . '%')
                  ->orWhere('alasan', 'like', '%' . $this->search . '%')
                  ->orWhere('tujuan', 'like', '%' . $this->search . '%')
                  ->orWhere('alamat_sekarang', 'like', '%' . $this->search . '%');
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
            'Nama/Instansi',
            'Telepon',
            'Email',
            'Alamat Saat Ini',
            'Informasi yang Dimohon',
            'Tujuan Penggunaan',
            'Alasan Keberatan',
            'File Identitas (Path)',
            'Tanggal Input',
        ];

        if ($this->isSuperAdmin) {
            array_splice($headings, 1, 0, 'Fakultas');
        }

        return $headings;
    }

    public function map($keberatan): array
    {
        // Gabungkan hasil radio alasan dengan kolom 'lainnya' jika ada
        $alasanLengkap = $keberatan->alasan;
        if ($keberatan->alasan_lainnya) {
            $alasanLengkap .= " ({$keberatan->alasan_lainnya})";
        }

        $data = [
            $keberatan->id,
            $keberatan->nama,
            $keberatan->telepon,
            $keberatan->email,
            $keberatan->alamat_sekarang,
            $keberatan->informasi,
            $keberatan->tujuan,
            $alasanLengkap,
            $keberatan->file_identitas,
            $keberatan->created_at->format('Y-m-d H:i:s'),
        ];

        if ($this->isSuperAdmin) {
            array_splice($data, 1, 0, $keberatan->faculty->name ?? 'N/A');
        }

        return $data;
    }
}
