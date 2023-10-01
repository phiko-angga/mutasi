<?php

namespace App\Exports;

use App\Models\Rute;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Facades\DB;

class RuteExport implements FromCollection, WithHeadings, WithMapping
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
            'Provinsi',
            'Kabupaten/Kota',
            'Jawa - Madura',
            'kapal Laut/KA 1xPerj.',
            'Plane 1xPerj.',
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
            $row->provinsi_nama,
            $row->kota_nama,
            $row->bus,
            $row->kapal,
            $row->plane,
            $row->created_name,
            $row->created_at,
            $row->updated_name,
            $row->updated_at,
        ];

        return $data;
    }
    
    public function collection()
    {
        $rute = new Rute();
        $data = $rute->get_data($this->request,false);
        return $data;
        
    }
}
