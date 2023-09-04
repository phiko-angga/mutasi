<?php

namespace App\Exports;

use App\Models\Laut;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Facades\DB;

class LautExport implements FromCollection, WithHeadings, WithMapping
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
            'Pelabuhan Asal',
            'Provinsi Tujuan',
            'Pelabuhan Tujuan',
            'Jarak (Mil)',
            'Nama Table',
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
            $row->pelabuhan_asal,
            $row->provinsit_nama,
            $row->pelabuhan_tujuan,
            $row->jarak_mil,
            $row->nama_table,
            $row->created_name,
            $row->created_at,
            $row->updated_name,
            $row->updated_at,
        ];

        return $data;
    }
    
    public function collection()
    {
        $laut = new Laut();
        $data = $laut->get_data($this->request,false);
        return $data;
        
    }
}
