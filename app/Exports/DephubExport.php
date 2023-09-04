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
    private $row;
    
    public function __construct($request)
    {
        $this->request = $request;
    }

    public function headings(): array
    {
        
        $data = [
            'Nomor',
            'Provinsi Asal',
            'Dari',
            'Pronvinsi Tujuan',
            'Ke',
            'Jarak (KM)',
            'harga (Rp)',
            'Nama Pembuat',
            'Tanggal Dibuat',
            'Nama Pengubah',
            'Tanggal Pengubah',
        ];
        
        return $data;
    }

    public function map($row): array
    {
        $data = [
            ++$this->row,
            $row->provinsia_nama,
            $row->kotaa_nama,
            $row->provinsit_nama,
            $row->kotat_nama,
            $row->jarak_km,
            $row->harga_tiket,
            $row->created_name,
            $row->created_at,
            $row->updated_name,
            $row->updated_at,
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
