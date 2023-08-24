<?php

namespace App\Exports;

use App\Models\BiayaPengepakan;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Facades\DB;

class BiayaPengepakanExport implements FromCollection, WithHeadings, WithMapping
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
            'Transport Darat',
            'Transport Laut',
        ];
        
        return $data;
    }

    public function map($row): array
    {
        $data = [
            $row->transport_darat,
            $row->transport_laut,
        ];

        return $data;
    }
    
    public function collection()
    {
        $biaya = new BiayaPengepakan();
        $data = $biaya->get_data($this->request,false);
        return $data;
        
    }
}
