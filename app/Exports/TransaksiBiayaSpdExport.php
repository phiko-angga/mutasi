<?php

namespace App\Exports;

use App\Models\TransaksiBiaya;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
// use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
// use Maatwebsite\Excel\Concerns\WithEvents;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Events\AfterSheet;
use Carbon\Carbon;
use Log;

class TransaksiBiayaSpdExport implements FromView
{
    
    // use RegistersEventListeners;
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
        return 'SURAT PERJALANAN DINAS';
    }

    public function view(): View
    {
        $trx = new TransaksiBiaya();
        $data = $trx->get_detail($this->id);
        $title = 'SURAT PERJALANAN DINAS';
        return view('transaksi_biaya.part_excel_spd', compact('data','title'));
    }

    public function columnWidths(): array
    {
        return [          
            'B' => 60,            
        ];
    }

    public static function afterSheet(AfterSheet $event)
    {
        // Create Style Arrays
        $default_font_style = [
            'font' => ['name' => 'Arial', 'size' => 10]
        ];

        $strikethrough = [
            'font' => ['strikethrough' => true],
        ];

        // Get Worksheet
        $active_sheet = $event->sheet->getDelegate();

        // Apply Style Arrays
        // $active_sheet->getParent()->getDefaultStyle()->applyFromArray($default_font_style);

        // strikethrough group of cells (A10 to B12) 
        // $active_sheet->getStyle('A10:B12')->applyFromArray($strikethrough);
        // or
        // $active_sheet->getStyle('A10:B12')->getFont()->setStrikethrough(true);

        // single cell
        // $active_sheet->getStyle('A13')->getFont()->setStrikethrough(true);
    }
}
