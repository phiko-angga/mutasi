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
    
    public function __construct($request)
    {
        $this->request = $request;
    }

    public function headings(): array
    {
        
        $data = [
            'Penandatangan',
            'No. urut',
            'Nama tertulis',
            'NIP tertulis',
            'Kepangkatan',
            'Nama jabatan',
        ];
        
        return $data;
    }

    public function map($row): array
    {
        $data = [
            $row->kelompok,
            $row->nourut,
            $row->nama,
            $row->nip,
            $row->pangkat,
            $row->jabatan,
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
