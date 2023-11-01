<?php

namespace App\Exports;

use App\Models\TransaksiBiaya;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithTitle;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Collection;
use Carbon\Carbon;
use Log;

class TransaksiBiayaRincianExport implements FromView
{
    
    /**
    * @return \Illuminate\Support\View
    */
    protected $request, $id;
    private $row;
    
    public function __construct($request, $id)
    {
        $this->request = $request;
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Rincian Biaya';
    }

    public function view(): View
    {
        $trx = new TransaksiBiaya();
        $data = $trx->get_detail($this->id);
        $title = 'RINCIAN BIAYA PERJALANAN';
        return view('transaksi_biaya.part_excel_rincian', compact('data','title'));
           
    }
}
