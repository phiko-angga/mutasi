<?php

namespace App\Exports;

use App\Models\BiayaTransport;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Facades\DB;

class BiayaTransportExport implements FromCollection, WithHeadings, WithMapping
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
        ];
        
        return $data;
    }

    public function map($row): array
    {
        $data = [
            $row->biaya_darat,
            $row->biaya_laut,
        ];

        return $data;
    }
    
    public function collection()
    {
        $biaya = new BiayaTransport();
        $data = $biaya->get_data($this->request,false);
        return $data;
        
    }
}
