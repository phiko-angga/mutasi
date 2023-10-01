<?php

namespace App\Exports;

use App\Models\BarangGolongan;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Facades\DB;

class BarangGolonganExport implements FromCollection, WithHeadings, WithMapping
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
            'Golongan',
            'Bujangan',
            'Keluarga',
            'Anak 1',
            'Anak 2',
            'Anak 3+',
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
            $row->golongan,
            $row->bujangan,
            $row->keluarga,
            $row->anak1,
            $row->anak2,
            $row->anak3,
            $row->created_name,
            $row->created_at,
            $row->updated_name,
            $row->updated_at,
        ];

        return $data;
    }
    
    public function collection()
    {
        $barang = new BarangGolongan();
        $data = $barang->get_data($this->request,false);
        return $data;
        
    }
}
