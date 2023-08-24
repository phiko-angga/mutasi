<?php

namespace App\Exports;

use App\Models\Dephub;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Facades\DB;

class DephubExport implements FromCollection, WithHeadings, WithMapping
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
            'Dari',
            'Ke',
            'Jarak (KM)',
            'harga (Rp)',
        ];
        
        return $data;
    }

    public function map($row): array
    {
        $data = [
            $row->kotaa_nama,
            $row->kotat_nama,
            $row->jarak_km,
            $row->harga_tiket,
        ];

        return $data;
    }
    
    public function collection()
    {
        $dephub = new Dephub();
        $data = $dephub->get_data($this->request,false);
        return $data;
        
    }
}
