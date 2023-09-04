<?php

namespace App\Exports;

use App\Models\Transport;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Facades\DB;

class TransportExport implements FromCollection, WithHeadings, WithMapping
{
    private $row = 0;

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
            'Nomor',
            'Kode',
            'Jenis Transport',
            'Kategori',
            'Status',
        ];
        
        return $data;
    }

    public function map($row): array
    {

        $data = [
            ++$this->row,
            $row->kode,
            $row->nama,
            $row->alias,
            $row->status == 1 ? 'Active' : 'Disable',
        ];

        return $data;
    }
    
    public function collection()
    {
        $transport = new Transport();
        $data = $transport->get_data($this->request,false);
        return $data;
        
    }
}
