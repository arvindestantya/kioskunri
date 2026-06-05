<?php

namespace App\Exports;

use App\Models\PermohonanInformasi;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PermohonanExport implements FromQuery, WithHeadings, WithMapping
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
        $query = PermohonanInformasi::query();

        if (!$this->isSuperAdmin) {
            $query->where('faculty_id', $this->facultyId);
        }

        if ($this->search) {
            $query->where(function($q) {
                $q->where('nama', 'like', '%' . $this->search . '%') // Kolom nama di DB
                  ->orWhere('email', 'like', '%' . $this->search . '%')
                  ->orWhere('no_hp', 'like', '%' . $this->search . '%')
                  ->orWhere('informasi', 'like', '%' . $this->search . '%')
                  ->orWhere('tujuan', 'like', '%' . $this->search . '%')
                  ->orWhere('alamat_ktp', 'like', '%' . $this->search . '%');
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
            'No. HP',
            'Email',
            'Tgl Permohonan',
            'Alamat KTP',
            'Alamat Sekarang',
            'Informasi yang Dibutuhkan',
            'Tujuan Penggunaan',
            'Cara Memperoleh',
            'Cara Mendapatkan Salinan',
            'File Identitas (Path)'
        ];

        if ($this->isSuperAdmin) {
            array_splice($headings, 1, 0, 'Fakultas');
        }

        return $headings;
    }

    public function map($permohonan): array
    {
        // Gabungkan hasil radio dengan kolom 'lainnya' jika ada
        $caraMemperoleh = $permohonan->cara_memperoleh;
        if ($permohonan->cara_memperoleh_lainnya) {
            $caraMemperoleh .= " ({$permohonan->cara_memperoleh_lainnya})";
        }

        $caraMendapatkan = $permohonan->cara_mendapatkan;
        if ($permohonan->cara_mendapatkan_lainnya) {
            $caraMendapatkan .= " ({$permohonan->cara_mendapatkan_lainnya})";
        }

        $data = [
            $permohonan->id,
            $permohonan->nama,
            $permohonan->no_hp,
            $permohonan->email,
            $permohonan->tanggal,
            $permohonan->alamat_ktp,
            $permohonan->alamat_sekarang ?? '-',
            $permohonan->informasi,
            $permohonan->tujuan,
            $caraMemperoleh,
            $caraMendapatkan ?? '-',
            $permohonan->file_identitas, // Menyimpan path ke file
        ];

        if ($this->isSuperAdmin) {
            array_splice($data, 1, 0, $permohonan->faculty->name ?? 'N/A');
        }

        return $data;
    }
}
