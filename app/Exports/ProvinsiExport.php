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
            'Provinsi',
            'Jawa - Madura',
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
            $row->jawamadura == 1 ? 'Y' : 'N',
            $row->updated_name,
            $row->updated_at,
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
