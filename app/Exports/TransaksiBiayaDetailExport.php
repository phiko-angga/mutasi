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
use Maatwebsite\Excel\Concerns\Exportable;
use Carbon\Carbon;
use Log;

class TransaksiBiayaDetailExport implements WithMultipleSheets
{
    
    use Exportable;
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
     * @return array
     */
    public function sheets(): array
    {
        $sheets = [];
        $sheets[] = new TransaksiBiayaSpdExport($this->request, $this->id);
        $sheets[] = new TransaksiBiayaRincianExport($this->request, $this->id);
        $sheets[] = new TransaksiBiayaKuitansiExport($this->request, $this->id);

        return $sheets;
    }
}
