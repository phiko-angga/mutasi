<?php

namespace App\Exports;

use App\Models\Sbum;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Facades\DB;

class SbumExport implements FromCollection, WithHeadings, WithMapping
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
            'Kota Asal',
            'Provinsi Asal',
            'Kota Tujuan',
            'Provinsi Tujuan',
            'harga (Rp)',
        ];
        
        return $data;
    }

    public function map($row): array
    {
        $data = [
            $row->kotaa_nama,
            $row->provinsia_nama,
            $row->kotat_nama,
            $row->provinsit_nama,
            $row->harga_tiket,
        ];

        return $data;
    }
    
    public function collection()
    {
        $sbum = new Sbum();
        $data = $sbum->get_data($this->request,false);
        return $data;
        
    }
}
