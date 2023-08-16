<?php

namespace App\Exports;

use App\Models\Uangh;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Facades\DB;

class UanghExport implements FromCollection, WithHeadings, WithMapping
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
            'Provinsi',
            'Satuan',
            'Luar Kota',
            'Dalam Kota',
            'Diklat',
        ];
        
        return $data;
    }

    public function map($row): array
    {
        $data = [
            $row->provinsi_nama,
            $row->satuan,
            $row->luar_kota,
            $row->dalam_kota,
            $row->diklat,
        ];

        return $data;
    }
    
    public function collection()
    {
        $uangh = new Uangh();
        $data = $uangh->get_data($this->request,false);
        return $data;
        
    }
}
