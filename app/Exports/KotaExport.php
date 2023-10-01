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
    private $row;
    
    public function __construct($request)
    {
        $this->request = $request;
    }

    public function headings(): array
    {
        
        $data = [
            'Nomor',
            'Kode',
            'kota',
            'Kantor PN',
            'Ibu Kota Prov.',
            'Bandara',
            'Pelabuhan',
            'Stasiun',
            'Bandara',
            'Terminal',
            'Alamat',
            'Telepon',
            'Kode POS',
            'Status',
            'Nama pembuat',
            'Tanggal dibuat',
            'Nama pengubah',
            'Tanggal diubah',
        ];
        
        return $data;
    }

    public function map($row): array
    {
        $data = [
            ++$this->row,
            $row->kode,
            $row->nama,
            $row->kantor == 1 ? 'Y' : 'N',
            $row->ibukota_prov == 1 ? 'Y' : 'N',
            $row->bandara == 1 ? 'Y' : 'N',
            $row->pelabuhan == 1 ? 'Y' : 'N',
            $row->stasiun == 1 ? 'Y' : 'N',
            $row->terminal == 1 ? 'Y' : 'N',
            $row->status == 1 ? 'Active' : 'Disable',
            $row->alamat,
            $row->telepon,
            $row->kodepos,
            $row->created_name,
            $row->created_at,
            $row->updated_name,
            $row->updated_at,
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
