<?php

namespace App\Exports;

use App\Models\Laut;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Facades\DB;

class LautExport implements FromCollection, WithHeadings, WithMapping
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
            'Pelabuhan Asal',
            'Provinsi Asal',
            'Pelabuhan Tujuan',
            'Provinsi Tujuan',
            'Jarak (Mil)',
            'Nama Table',
        ];
        
        return $data;
    }

    public function map($row): array
    {
        $data = [
            $row->pelabuhan_asal,
            $row->provinsia_nama,
            $row->pelabuhan_tujuan,
            $row->provinsit_nama,
            $row->jarak_mil,
            $row->nama_table,
        ];

        return $data;
    }
    
    public function collection()
    {
        $laut = new Laut();
        $data = $laut->get_data($this->request,false);
        return $data;
        
    }
}
