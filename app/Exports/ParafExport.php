<?php

namespace App\Exports;

use App\Models\Paraf;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Facades\DB;

class ParafExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $request;
    private $row;
    
    public function __construct($request)
    {
        $this->request = $request;
    }

    public function headings(): array
    {
        
        $data = [
            'Nomor',
            'Penandatangan',
            'No. urut',
            'Nama tertulis',
            'NIP tertulis',
            'Kepangkatan',
            'Nama jabatan',
            'Nama Pembuat',
            'Tanggal Dibuat',
            'Nama Pengubah',
            'Tanggal Pengubah',
        ];
        
        return $data;
    }

    public function map($row): array
    {
        $data = [
            ++$this->row,
            $row->kelompok,
            $row->nourut,
            $row->nama,
            $row->nip,
            $row->pangkat,
            $row->jabatan,
            $row->created_name,
            $row->created_at,
            $row->updated_name,
            $row->updated_at,
        ];

        return $data;
    }
    
    public function collection()
    {
        $paraf = new Paraf();
        $data = $paraf->get_data($this->request,false);
        return $data;
        
    }
}
