<?php

namespace App\Exports;

use App\Models\BiayaMuat;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Facades\DB;

class BiayaMuatExport implements FromCollection, WithHeadings, WithMapping
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
            'Biaya Darat',
            'Biaya Laut',
            'Jawa Madura',
        ];
        
        return $data;
    }

    public function map($row): array
    {
        $data = [
            $row->biaya_darat,
            $row->biaya_laut,
            $row->jawamadura == '0' ? 'N' : 'Y',
        ];

        return $data;
    }
    
    public function collection()
    {
        $biaya = new BiayaMuat();
        $data = $biaya->get_data($this->request,false);
        return $data;
        
    }
}
