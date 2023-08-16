<?php

namespace App\Exports;

use App\Models\Provinsi;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Facades\DB;

class ProvinsiExport implements FromCollection, WithHeadings, WithMapping
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
            'Kode',
            'Provinsi',
            'Jawa - Madura',
            'Status',
        ];
        
        return $data;
    }

    public function map($row): array
    {
        $data = [
            $row->kode,
            $row->nama,
            $row->jawamadura == 1 ? 'Y' : 'N',
            $row->status == 1 ? 'Active' : 'Disabled',
        ];

        return $data;
    }
    
    public function collection()
    {
        $provinsi = new Provinsi();
        $data = $provinsi->get_data($this->request,false);
        return $data;
        
    }
}
