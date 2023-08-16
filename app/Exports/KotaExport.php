<?php

namespace App\Exports;

use App\Models\Kota;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Facades\DB;

class KotaExport implements FromCollection, WithHeadings, WithMapping
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
            'kota',
            'Provinsi',
            'Kantor PN',
            'Ibu Kota Prov.',
            'Bandara',
            'Pelabuhan',
            'Stasiun',
            'Bandara',
            'Terminal',
            'Alamat',
            'Kode POS',
            'Status',
        ];
        
        return $data;
    }

    public function map($row): array
    {
        $data = [
            $row->kode,
            $row->nama,
            $row->provinsi_nama,
            $row->kantor == 1 ? 'Y' : 'N',
            $row->ibukota_prov == 1 ? 'Y' : 'N',
            $row->bandara == 1 ? 'Y' : 'N',
            $row->pelabuhan == 1 ? 'Y' : 'N',
            $row->stasiun == 1 ? 'Y' : 'N',
            $row->terminal == 1 ? 'Y' : 'N',
            $row->alamat,
            $row->kodepos,
            $row->status == 1 ? 'Active' : 'Disable',
        ];

        return $data;
    }
    
    public function collection()
    {
        $kota = new Kota();
        $data = $kota->get_data($this->request,false);
        return $data;
        
    }
}
