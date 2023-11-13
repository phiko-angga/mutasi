<?php

namespace App\Http\Controllers;

use App\Models\Paraf;
use App\Models\TransaksiBiaya;
use App\Models\TransaksiBiayaTransport;
use App\Models\TransaksiBiayaMuat;
use App\Models\TransaksiBiayaKeluarga;
use App\Models\PejabatKomitmen;
use App\Models\PangkatGolongan;
use App\Models\KelompokJabatan;
use App\Models\Transport;
use App\Models\Kota;
use App\Exports\TransaksiBiayaDetailExport;
use App\Exports\TransaksiBiayaExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use PhpOffice\PhpWord\PhpWord;
use Carbon\Carbon;
use Redirect;
use Log;
use PDF;
use DateTime;

class TransaksiBiayaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index(Request $request)
    {
        $paginate_num = $request->get('show_per_page') != null ? $request->get('show_per_page') : 10;
        $transaksi_biaya = new TransaksiBiaya();
        $data = $transaksi_biaya->get_data($request,true,['approved' => 0]);

        $page = 'Perhitungan Biaya Mutasi';

        if($request->ajax()){
            return view('transaksi_biaya.list_pagination',compact('data','paginate_num'));
        }else{
            return view('transaksi_biaya.list', compact('data','page','paginate_num'));
        }
    }

    public function approvedList(Request $request)
    {
        $transaksi_biaya = new TransaksiBiaya();
        $data = $transaksi_biaya->get_data($request,true,['approved' => 1]);

        $page = 'Approved Biaya Mutasi';
        if($request->ajax()){
            return view('transaksi_biaya.list_approved_pagination',compact('data'));
        }else{
            return view('transaksi_biaya.list_approved', compact('data','page'));
        }
    }
    
    public function printPdf(Request $request)
    {
        $title = 'Perhitungan Biaya Mutasi';
        $transaksi_biaya = new TransaksiBiaya();
        $data = $transaksi_biaya->get_data($request,true,['approved' => 0]);
    	$pdf = PDF::loadview('transaksi_biaya.list_pdf', compact('data','title'))->setPaper('a4', 'landscape');
    	return $pdf->stream('PERHITUNGAN BIAYA MUTASI.pdf');
    }

    public function printDetailPdf(Request $request, $id)
    {
        $title = 'SURAT PERJALANAN DINAS (SPD)';
        $transaksi_biaya = new TransaksiBiaya();
        $data = $transaksi_biaya->get_detail($id);
        // Log::debug('data '.json_encode($data));
    	// return view('transaksi_biaya.list_detail_pdf', compact('data','title'));
    	$pdf = PDF::loadview('transaksi_biaya.list_detail_pdf', compact('data','title'));
    	return $pdf->stream('SURAT PERJALANAN DINAS.pdf');
    }

    public function printExcel(Request $request)
    {
        return \Excel::download(new TransaksiBiayaExport($request), 'PERHITUNGAN BIAYA MUTASI.xlsx');
    }

    public function printDetailExcel(Request $request, $id)
    {
        return \Excel::download(new TransaksiBiayaDetailExport($request,$id), 'Perhitungan Biaya Mutasi Detail.xlsx');
    }

    public function printDetailDoc(Request $request, $id)
    {
        $transaksi_biaya = new TransaksiBiaya();
        $data = $transaksi_biaya->get_detail($id);

        $phpWord = new PhpWord();
        // $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $section = $phpWord->addSection(['marginLeft' => 300,'marginRight' => 300]);
        $fontStyle = ['size' => 12];
        $alignCenterStyle = ['align' => 'center'];
        
        //------------ HEADER ------------------
        $table = $section->addTable(['cellMargin' => 80, 'width' => 5000,'unit' => 'pct']);
        for ($r = 0; $r <= 0; $r++) {
            $table->addRow();
            for ($c = 0; $c <= 3; $c++) {
                if($r == 0 && $c == 0){
                    $cell = $table->addCell();
                    $cell->addImage("./img/logo.png",array('width' => 80, 'height' => 100));  
                }
                if($r == 0 && $c == 1){
                    // $table->addRow()
                    $cell = $table->addCell();
                    $cell->addText("MAHKAMAH AGUNG RI",array('size' => 16,'bold' => true),$alignCenterStyle);
                    $cell->addText("DIREKTORAT JENDERAL",$fontStyle,$alignCenterStyle);
                    $cell->addText("BADAN PERADILAN UMUM",$fontStyle,$alignCenterStyle);
                    $cell->addText("JAKARTA",$fontStyle,$alignCenterStyle);
                }
                if($r == 0 && $c == 2){
                    // $table->addRow();
                    $cell = $table->addCell();
                    $cell->addText("Lembar Ke");
                    $cell->addText("Kode No");
                    $cell->addText("Nomor");
                }
                if($r == 0 && $c == 3){
                    // $table->addRow();
                    $cell = $table->addCell();
                    $cell->addText(": ");
                    $cell->addText(": ");
                    $cell->addText(": ".$data->nomor);
                }
            }
            
        }
        $section->addText("");

        $table->addRow();
        $cell = $table->addCell(2000,['gridSpan' => 3]);
        $cell->addText("SURAT PERJALANAN DINAS (SPD)",$fontStyle,$alignCenterStyle);

        //------------ BODY ------------------
        $val = [];
        $val[0][0] = "1.";
        $val[0][1] = "Pejabat Pembuat Komitmen";
        $val[0][2] = "SEKRETARIAT DITJEN BADAN PERADILAN UMUM";
        $val[0]['style'][2] = ['gridSpan' => 2];

        $val[1][0] = "2.";
        $val[1][1] = [
            '0' => "Nama pegawai diperintahkan",
            '1' => "NIP",
        ];
        $val[1][2] = [
            '0' => $data->pegawai_diperintah,
            '1' => $data->nip,
        ];
        $val[1]['style'][2] = ['gridSpan' => 2];

        $val[2][0] = "3.";
        $val[2][1] = [
            '0' => "a. Pangkat dan Gol. Ruang Gaji (PP No. 6 Tahun 1997)",
            '1' => "b. Jabatan Instansi",
            '2' => "c. Tingkat Biaya Perjalanan Dinas",
        ];
        $val[2][2] = [
            '0' => $data->pangkat.' - '.$data->golongan,
            '1' => $data->jabatan_instansi,
            '2' => $data->tingkat_perj_dinas,
        ];
        $val[2]['style'][2] = ['gridSpan' => 2];

        $val[3][0] = "4.";
        $val[3][1] = "Maksud Perjalanan Dinas";
        $val[3][2] = $data->maksud_perj_dinas;
        $val[3]['style'][2] = ['gridSpan' => 2];

        $val[4][0] = "5.";
        $val[4][1] = "Alat angkutan yang dipergunakan";
        $val[4][2] = $data->transport_nama;
        $val[4]['style'][2] = ['gridSpan' => 2];
        
        $val[5][0] = "6.";
        $val[5][1] = [
            '0' => "a. Tempat berangkat",
            '1' => "b. Tempat tujuan",
        ];
        $val[5][2] = [
            '0' => $data->kotaa_nama,
            '1' => $data->kotat_nama,
        ];
        $val[5]['style'][2] = ['gridSpan' => 2];
        
        $val[6][0] = "7.";
        $val[6][1] = [
            '0' => "a. Lama perjalanan dinas",
            '1' => "b. Tanggal berangkat",
            '2' => "c. Tanggal harus kembali/tiba di tempat baru",
        ];
        $val[6][2] = [
            '0' => $data->lama_perj_dinas,
            '1' => Carbon::parse($data->tanggal_berangkat)->formatLocalized('%d %B %Y'),
            '2' => Carbon::parse($data->tanggal_kembali)->formatLocalized('%d %B %Y'),
        ];
        $val[6]['style'][2] = ['gridSpan' => 2];
        
        $val[7][0] = "8.";
        $val[7][1] = "pengikut : Nama";
        $val[7][2] = "Tanggal Lahir / Umur";
        $val[7][3] = "Keterangan";

        $no = 7;
        $alp = "a";
        if(isset($data->keluarga)){
            foreach($data->keluarga as $kel){
                ++$no;
                
                $val[$no][0] = "";
                $val[$no][1] = $alp.". ".$kel->nama;
                $val[$no][2] = Carbon::parse($kel->tanggal_lahir)->formatLocalized('%d %B %Y');
                $val[$no][3] = $kel->keterangan;   
                
                ++$alp;
            }
        }
        ++$no;

        $val[$no][0] = "9.";
        $val[$no][1] = [
            '0' => "Pembebanan Anggaran",
            '1' => "a. Instansi",
            '2' => "b. Mata Anggaran",
        ];
        $val[$no][2] = "DIREKTORAT JENDERAL BADAN PERADILAN UMUM";
        $val[$no]['textfstyle'][2] = $fontStyle;
        $val[$no]['textastyle'][2] = $alignCenterStyle;
        $val[$no]['style'][2] = ['gridSpan' => 2];
        ++$no;

        $val[$no][0] = "10.";
        $val[$no][1] = "Keterangan lain - Lain";
        $val[$no][2] = $data->ket_lain2;
        $val[$no]['style'][2] = ['gridSpan' => 2];
        ++$no;

        $table2 = $section->addTable(['cellMargin' => 80, 'width' => 5000,'unit' => 'pct','borderColor' => '000000','borderSize' => '6']);
        $rowCount = count($val);

        //------- Row / Baris -------
        for ($r = 0; $r <= ($rowCount-1); $r++) {
            $table2->addRow();

            $cellCount = count($val[$r]);
            //------- Cell / Kolom -------
            for ($c = 0; $c <= ($cellCount-1); $c++) {

                //------ Add Cell Style ----------
                $style = [];
                if(isset($val[$r]['style'][$c])){
                    $style = $val[$r]['style'][$c];
                }
                // Log::debug('style : '.json_encode($style));
                // $cell = $table2->addCell(null,$style);

                //------ Add Cell Table ----------
                // $addTable = 0;
                // if(isset($val[$r][$c]['table'])){
                //     $addTable = $val[$r][$c]['table'];
                // }
                // Log::debug('addTable : '.json_encode($addTable));
                // if($addTable == 1){
                //     $section->addText("");
                //     $table3 = $section->addTable(['cellMargin' => 80, 'width' => 5000,'unit' => 'pct','borderColor' => '000000','borderSize' => '300']);
                // }

                if(isset($val[$r][$c])){
                    $v = $val[$r][$c];
                    if(is_array($v)){
                        //--------------- Cell values Multiple Line --------------
                        for ($rc = 0; $rc <= (count($v)-1); $rc++) {

                            if($rc == 0){
                                // Log::debug('style : '.json_encode($style));
                                $cell = $table2->addCell(null,$style);
                            }

                            if(isset($val[$r][$c][$rc])){
                                $v1 = $val[$r][$c][$rc];

                                if(!is_array($v1)){
                                    
                                    $cell->addText($v1);
                                }
                            }
                        }
                    }else{
                        $text_fontstyle = [];
                        $text_alignstyle = [];
                        if(isset($val[$r]['textfstyle'][$c])){
                            $text_fontstyle = $val[$r]['textfstyle'][$c];
                        }
                        if(isset($val[$r]['textastyle'][$c])){
                            $text_alignstyle = $val[$r]['textastyle'][$c];
                        }
                        $cell = $table2->addCell(null,$style)->addText( $val[$r][$c],$text_fontstyle,$text_alignstyle);
                    }
                }
            }
        }
        $section->addText("");

        //------------ FOOTER ------------------
        $table3 = $section->addTable(['cellMargin' => 80, 'width' => 5000,'unit' => 'pct']);
        for ($r = 0; $r <= 5; $r++) {
            $table3->addRow();
            for ($c = 0; $c <= 3; $c++) {
                if(in_array($r,[2,3,4])){
                    $cell = $table3->addCell()->addText("");  
                }

                if($c == 0){
                    $cell = $table3->addCell(3000)->addText("");  
                }

                if($r == 0 && $c == 1){
                    $cell = $table3->addCell(200);
                    $cell->addText("Dikeluarkan",null,['align' => 'right']);
                    $cell->addText("Tanggal",null,['align' => 'right']);
                }
                if($r == 0 && $c == 2){
                    // $table->addRow();
                    $cell = $table3->addCell();
                    $cell->addText(":");
                    $cell->addText(":");
                }
                if($r == 0 && $c == 3){
                    // $table->addRow();
                    $cell = $table3->addCell();
                    $cell->addText("Jakarta,");
                    $cell->addText(Carbon::parse($data->tanggal)->formatLocalized('%d %B %Y'));
                }

                if($r == 1 ){
                    if($c == 1){
                        $cell = $table3->addCell(null);
                    }else
                    if($c == 2){
                        $cell = $table3->addCell(null,['gridSpan' => 2]);
                        $cell->addText("DIREKTORAT JENDERAL",null,['align' => 'center']);
                        $cell->addText("BADAN PERADILAN UMUM",null,['align' => 'center']);
                        $cell->addText("Pejabat Pembuat Komitmen (PPK)",null,['align' => 'center']);
                    }
                }
                if($r == 5){
                    if($c == 1){
                        $cell = $table3->addCell(null);
                    }else
                    if($c == 2){
                        $cell = $table3->addCell(null,['gridSpan' => 2]);
                        $cell->addText($data->pejabat_komitmen_nama,null,['align' => 'center']);
                        $cell->addText("NIP. ".$data->pejabat_komitmen_nip,null,['align' => 'center']);
                    }
                }
            }
        }

        //----------------- TRANSPORT --------------------
        $section2 = $phpWord->addSection(['marginLeft' => 300,'marginRight' => 300]);
        $fontStyle = ['size' => 12];
        $alignCenterStyle = ['align' => 'center'];
        
        //------------ HEADER ------------------
        $table = $section2->addTable(['cellMargin' => 80, 'width' => 5000,'unit' => 'pct']);
        for ($r = 0; $r <= 0; $r++) {
            $table->addRow();
            for ($c = 0; $c <= 3; $c++) {
                if($r == 0 && $c == 0){
                    $cell = $table->addCell();
                    $cell->addImage("./img/logo.png",array('width' => 80, 'height' => 100));  
                }
                if($r == 0 && $c == 1){
                    // $table->addRow()
                    $cell = $table->addCell();
                    $cell->addText("MAHKAMAH AGUNG RI",array('size' => 16,'bold' => true),$alignCenterStyle);
                    $cell->addText("DIREKTORAT JENDERAL",$fontStyle,$alignCenterStyle);
                    $cell->addText("BADAN PERADILAN UMUM",$fontStyle,$alignCenterStyle);
                    $cell->addText("JAKARTA",$fontStyle,$alignCenterStyle);
                }
                if($r == 0 && $c == 2){
                    // $table->addRow();
                    $cell = $table->addCell();
                    $cell->addText("Lampiran SPD");
                    $cell->addText("Tanggal");
                }
                if($r == 0 && $c == 3){
                    // $table->addRow();
                    $cell = $table->addCell();
                    $cell->addText(": ".$data->nomor);
                    $cell->addText(": ".Carbon::parse($data->tanggal)->formatLocalized('%d %B %Y'));
                }
            }
            
        }
        $section2->addText("");

        $table->addRow();
        $cell = $table->addCell(2000,['gridSpan' => 3]);
        $cell->addText("RINCIAN BIAYA PERJALANAN DINAS",$fontStyle,$alignCenterStyle);

        //------------ BODY ------------------
        $no = -1;
        $val = [];

        ++$no;
        $val[$no][0] = "No.";
        $val[$no][1] = "Rincian Biaya";
        $val[$no][2] = "Jumlah";
        $val[$no][3] = "Keterangan";

        ++$no;
        $val[$no][0] = "I";
        $val[$no][1] = "TRANSPORT";
        $val[$no][2] = "";
        $val[$no][3] = "";

        if(isset($data->transport)){
            foreach($data->transport as $tr){
                ++$no;
                $val[$no][0] = "";
                $val[$no][1] = $tr->transport_nama." : ".$tr->kotaa_nama." ".$tr->kotat_nama;
                $val[$no][2] = "";
                $val[$no][3] = "";

                ++$no;
                $val[$no][0] = "";
                $val[$no][1] = $tr->orang." x Rp. ".number_format($tr->biaya_perorang);
                $val[$no][2] = "Rp. ".number_format($tr->jumlah_biaya);
                $val[$no][3] = "";
            }
        }

        ++$no;
        $val[$no][0] = "II";
        $val[$no][1] = "BARANG";
        $val[$no][2] = "";
        $val[$no][3] = "";

        ++$no;
        $val[$no][0] = "";
        $val[$no][1] = "Pengepakan / Penggudangan";
        $val[$no][2] = "";
        $val[$no][3] = "";

        ++$no;
        $val[$no][0] = "";
        $val[$no][1] = $data->pengepakan_berat." x Rp. ".number_format($data->pengepakan_tarif);
        $val[$no][2] = "Rp. ".number_format($data->pengepakan_biaya);
        $val[$no][3] = "";

        if(isset($data->muat)){
            foreach($data->muat as $mu){
                ++$no;
                $val[$no][0] = "";
                $val[$no][1] = $mu->transport_nama." : ".$mu->kotaa_nama." ".$mu->kotat_nama;
                $val[$no][2] = "";
                $val[$no][3] = "";

                ++$no;
                $val[$no][0] = "";
                $val[$no][1] = $mu->berat." x ".$mu->jarak." Rp. ".number_format($mu->tarif);
                $val[$no][2] = "Rp. ".number_format($mu->biaya);
                $val[$no][3] = "";
            }
        }

        ++$no;
        $val[$no][0] = "III";
        $val[$no][1] = "UANG HARIAN";
        $val[$no][2] = "";
        $val[$no][3] = "";

        ++$no;
        $val[$no][0] = "";
        $val[$no][1] = $data->status_perkawinan." di ".$data->kotat_nama.", ".$data->provinsit_nama;
        $val[$no][2] = "";
        $val[$no][3] = "";

        ++$no;
        $val[$no][0] = "";
        $val[$no][1] = $data->uangh_jml_orang." Orang x Rp. ".number_format($data->uangh_jml_tarif)." x ".$data->uangh_jml_hari." Hari";
        $val[$no][2] = "Rp. ".number_format($data->uangh_jml_biaya);
        $val[$no][3] = "";

        ++$no;
        $val[$no]['style'][0] = ['gridSpan' => 2];
        $val[$no]['textfstyle'][0] = null;
        $val[$no]['textastyle'][0] = $alignCenterStyle;
        $val[$no][0] = "JUMLAH";
        $val[$no][2] = "Rp. ".number_format($data->rampung_jumlah);
        $val[$no][3] = "";

        ++$no;
        $val[$no]['style'][0] = ['gridSpan' => 4];
        $val[$no]['textfstyle'][0] = $fontStyle;
        $val[$no]['textastyle'][0] = $alignCenterStyle;
        $val[$no][0] = "Terbilang : ".$data->uangh_jml_terbilang;


        $table2 = $section2->addTable(['cellMargin' => 80, 'width' => 5000,'unit' => 'pct','borderColor' => '000000','borderSize' => '6']);
        $rowCount = count($val);

        //------- Row / Baris -------
        for ($r = 0; $r <= ($rowCount-1); $r++) {
            $table2->addRow();

            $cellCount = count($val[$r]);
            //------- Cell / Kolom -------
            for ($c = 0; $c <= ($cellCount-1); $c++) {

                //------ Add Cell Style ----------
                $style = [];
                if(isset($val[$r]['style'][$c])){
                    $style = $val[$r]['style'][$c];
                }
                
                if(isset($val[$r][$c])){
                    $v = $val[$r][$c];
                    if(is_array($v)){
                        //--------------- Cell values Multiple Line --------------
                        for ($rc = 0; $rc <= (count($v)-1); $rc++) {

                            if($rc == 0){
                                // Log::debug('style : '.json_encode($style));
                                $cell = $table2->addCell(null,$style);
                            }

                            if(isset($val[$r][$c][$rc])){
                                $v1 = $val[$r][$c][$rc];

                                if(!is_array($v1)){
                                    
                                    $cell->addText($v1);
                                }
                            }
                        }
                    }else{
                        $text_fontstyle = [];
                        $text_alignstyle = [];
                        if(isset($val[$r]['textfstyle'][$c])){
                            $text_fontstyle = $val[$r]['textfstyle'][$c];
                        }
                        if(isset($val[$r]['textastyle'][$c])){
                            $text_alignstyle = $val[$r]['textastyle'][$c];
                        }
                        $cell = $table2->addCell(null,$style)->addText( $val[$r][$c],$text_fontstyle,$text_alignstyle);
                    }
                }
            }
        }
        $section2->addText("");

        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save('Perhitungan Biaya Mutasi.docx');
        return response()->download(public_path('Perhitungan Biaya Mutasi.docx'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $action = 'store';
        $page = 'Perhitungan Biaya Mutasi';
        $title = 'Tambah baru';
        $pejabat_komitmen = PejabatKomitmen::all();
        $pangkat_golongan = PangkatGolongan::all();
        $kelompok_jabatan = KelompokJabatan::all();
        $transport = Transport::all();
        $kota = Kota::all();
        $bendaharawan = Paraf::where('kelompok','ilike','Bendaharawan')->first();
        $kuasaanggaran = Paraf::where('kelompok','ilike','Kuasa Pengguna Anggaran')->first();
        $penerima = Paraf::where('kelompok','ilike','Yang menerima/dikuasakan')->first();
        $ppk = PejabatKomitmen::first();
        return view('transaksi_biaya.form',compact('penerima','ppk','kuasaanggaran','bendaharawan','action','title','page','pejabat_komitmen','pangkat_golongan','kelompok_jabatan','transport','kota'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        // request()->validate([
        //     'kelompok'   => 'required',
        //     'nourut'   => 'required',
        //     'nama'   => 'required',
        //     'nip'   => 'required',
        //     'pangkat'   => 'required',
        //     'jabatan'   => 'required',
        // ]);
        // Log::debug('data '.json_encode($request->all()));

        DB::beginTransaction();
        try {
            $data = $request->only('tanggal','tanggal_berangkat','tanggal_kembali','nomor','pegawai_diperintah','jabatan_instansi','nip','pejabat_komitmen_id','pejabat_komitmen2_id'
            ,'pangkat_golongan_id','kelompok_jabatan_id','tingkat_perj_dinas','transport_id','kota_asal_id','ket_keberangkatan','lama_perj_dinas',
            'kota_tujuan_id','ket_tujuan','status_perkawinan','maksud_perj_dinas','jumlah_pengikut','pembantu_ikut','pembebanan_anggaran','mata_anggaran'
            ,'ket_lain2','pengepakan_berat','pengepakan_transport_id','pengepakan_tarif','pengepakan_biaya','uangh_jml_orang','uangh_jml_hari','uangh_jml_tarif'
            ,'uangh_jml_biaya','uangh_jml_pembantu','uangh_jml_hari_p','uangh_jml_tarif_p','uangh_jml_biaya_p','uangh_jml_uang','uangh_jml_terbilang'
            ,'rampung_jumlah','rampung_dibayar','rampung_sisa','rampung_beban_mak','rampung_buktikas','rampung_tgl_pelunasan','rampung_thn_anggaran'
            ,'rampung_bendaharawan_id','rampung_kuasa_nama','rampung_ppk_id','rampung_anggaran_id','rampung_rincian','rampung_kuasa_nip','rampung_kuasa');
            
            $user = auth()->user();
            $data['pengepakan_tarif'] = str_replace(',', '', $data['pengepakan_tarif']);
            $data['pengepakan_biaya'] = str_replace(',', '', $data['pengepakan_biaya']);
            $data['uangh_jml_tarif'] = str_replace(',', '', $data['uangh_jml_tarif']);
            $data['uangh_jml_biaya'] = str_replace(',', '', $data['uangh_jml_biaya']);
            $data['uangh_jml_tarif_p'] = str_replace(',', '', $data['uangh_jml_tarif_p']);
            $data['uangh_jml_biaya_p'] = str_replace(',', '', $data['uangh_jml_biaya_p']);
            $data['uangh_jml_uang'] = str_replace(',', '', $data['uangh_jml_uang']);
            $data['rampung_jumlah'] = str_replace(',', '', $data['rampung_jumlah']);
            $data['rampung_dibayar'] = str_replace(',', '', $data['rampung_dibayar']);
            $data['rampung_beban_mak'] = str_replace(',', '', $data['rampung_beban_mak']);
            $data['uangh_jml_tarif'] = str_replace(',', '', $data['uangh_jml_tarif']);
            $data['uangh_jml_biaya'] = str_replace(',', '', $data['uangh_jml_biaya']);
            $data['uangh_jml_tarif_p'] = str_replace(',', '', $data['uangh_jml_tarif_p']);
            $data['uangh_jml_biaya_p'] = str_replace(',', '', $data['uangh_jml_biaya_p']);
            $data['uangh_jml_uang'] = str_replace(',', '', $data['uangh_jml_uang']);
            $data['created_by'] = $user->id;
            $data['updated_by'] = $user->id;
            $transaksi_biaya = TransaksiBiaya::create($data);

            //--------------- KELUARGA -------------------
            $kel_nama = $request->kel_nama;
            $kel_dinas = $request->kel_perj_dinas;
            $kel_dob = $request->kel_dob;
            $kel_umur = $request->kel_umur;
            $kel_keterangan = $request->kel_keterangan;
            $dataKeluarga = [];
            if($kel_nama != null && count($kel_nama) > 0){
                foreach($kel_nama as $key => $nama){
                    $dataKeluarga[] = [
                        'transaksi_biaya_id' => $transaksi_biaya->id,
                        'biaya_perj_dinas' => $kel_dinas[$key],
                        'nama' => $nama,
                        'tanggal_lahir' => $kel_dob[$key],
                        'umur' => $kel_umur[$key],
                        'keterangan' => $kel_keterangan[$key],
                        'created_by' => $user->id,
                        'updated_by' => $user->id,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ];
                }
            }
            // Log::debug('dataKeluarga '.json_encode($dataKeluarga));
            if(count($dataKeluarga) > 0)
                $transaksi_keluarga = TransaksiBiayaKeluarga::insert($dataKeluarga);

            //--------- TRANSPORT -----------------
            $trans_pembantu = $request->trans_pembantu;
            $trans_transport_id = $request->trans_transport_id;
            $trans_kota_asal_id = $request->trans_kota_asal_id;
            $trans_kota_tujuan_id = $request->trans_kota_tujuan_id;
            $trans_orang = $request->trans_orang;
            $trans_biaya = $request->trans_biaya;
            $trans_jumlah_biaya = $request->trans_jumlah_biaya;
            $trans_metode = $request->trans_metode;
            $trans_perkiraan = $request->trans_perkiraan;
            $trans_manual = $request->trans_manual;

            $dataTransport = [];
            if($trans_pembantu != null && count($trans_pembantu) > 0){
                foreach($trans_pembantu as $key => $pembantu){
                    
                    $dataTransport[] = [
                        'transaksi_biaya_id' => $transaksi_biaya->id,
                        'pembantu' => $pembantu,
                        'transport_id' => $trans_transport_id[$key],
                        'kota_asal_id' => $trans_kota_asal_id[$key],
                        'kota_tujuan_id' => $trans_kota_tujuan_id[$key],
                        'orang' => $trans_orang[$key],
                        'biaya_perorang' => str_replace(',', '', $trans_biaya[$key]),
                        'rinci_perkiraan' => $trans_perkiraan[$key] != null ? $trans_perkiraan[$key] : "",
                        'jumlah_biaya' => str_replace(',', '', $trans_jumlah_biaya[$key]),
                        'metode' => $trans_metode[$key],
                        'manual' => $trans_manual[$key],
                    ];
                }
            }
            // Log::debug('dataTransport '.json_encode($dataTransport));
            if(count($dataTransport) > 0)
                $transaksi_transport = TransaksiBiayaTransport::insert($dataTransport);

            //--------- MUAT BARANG -----------------
            $muat_transport_id = $request->muat_transport_id;
            $muat_kota_asal_id = $request->muat_kota_asal_id;
            $muat_kota_tujuan_id = $request->muat_kota_tujuan_id;
            $muat_berat = $request->muat_berat;
            $muat_jarak = $request->muat_jarak;
            $muat_biaya = $request->muat_biaya;
            $muat_metode = $request->muat_metode;
            $muat_manual = $request->muat_manual;
            $muat_tarif = $request->muat_tarif;

            $dataMuat = [];
            if($muat_transport_id != null && count($muat_transport_id) > 0){
                foreach($muat_transport_id as $key => $transport){
                    
                    $dataMuat = [
                        'transaksi_biaya_id' => $transaksi_biaya->id,
                        'transport_id' => $transport,
                        'manual' => $muat_manual[$key],
                        'kota_asal_id' => $muat_kota_asal_id[$key],
                        'kota_tujuan_id' => $muat_kota_tujuan_id[$key],
                        'berat' => $muat_berat[$key],
                        'jarak' => str_replace(',', '', $muat_jarak[$key]),
                        'tarif' => str_replace(',', '', $muat_tarif[$key]),
                        'biaya' => str_replace(',', '', $muat_biaya[$key]),
                        'metode' => $muat_metode[$key],
                    ];
                }
            }
            // Log::debug('dataMuat '.json_encode($dataMuat));
            if(count($dataMuat) > 0)
                $transaksi_muat = TransaksiBiayaMuat::insert($dataMuat);

            //Commit
            DB::commit();

            return redirect('/transaksi-biaya')->with('info', 'Transaksi biaya berhasil ditambahkan');
            
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            return Redirect::back()->withInput($request->input())->withErrors(['error'=> 'Tambah Transaksi biaya gagal, silahkan coba kembali.']);
            // something went wrong
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        
        $transaksi_biaya = new TransaksiBiaya();
        $biaya = $transaksi_biaya->get_detail($id);
        // Log::debug('$biaya '.json_encode($biaya));

        $page = 'Approve Biaya';
        if($request->ajax()){
            return view('transaksi_biaya.approve_modal',compact('biaya'));
        }
    }

    public function approve(Request $request)
    {
        request()->validate([
            'id'   => 'required',
        ]);

        $transaksi_biaya = TransaksiBiaya::find($request->id);
        if($transaksi_biaya){

            DB::beginTransaction();
            try {

                $user = auth()->user();
                $transaksi_biaya->approved = 1;
                $transaksi_biaya->approved_by = $user->id;
                $transaksi_biaya->approved_at = date('Y-m-d H:i:s');
                $transaksi_biaya->save();

                DB::commit();

                return redirect('/transaksi-biaya')->with('info', 'Biaya berhasil di approve');
                
            } catch (\Exception $e) {
                DB::rollback();
                Log::Error($e->getMessage());
                return Redirect::back()->withInput($request->input())->withErrors(['error'=> 'Approve Biaya gagal, silahkan coba kembali.']);
                // something went wrong
            }
        }else{
            return Redirect::back()->withInput($request->input())->withErrors(['error'=> 'Data Biaya tidak ditemukan.']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $action = 'update';
        $page = 'Perhitungan Biaya Mutasi';
        $title = 'Update';
        $pejabat_komitmen = PejabatKomitmen::all();
        $pangkat_golongan = PangkatGolongan::all();
        $kelompok_jabatan = KelompokJabatan::all();
        $transport = Transport::all();
        $kota = Kota::all();
        $bendaharawan = Paraf::where('kelompok','ilike','Bendaharawan')->first();
        $kuasaanggaran = Paraf::where('kelompok','ilike','Kuasa Pengguna Anggaran')->first();
        $penerima = Paraf::where('kelompok','ilike','Yang menerima/dikuasakan')->first();
        $ppk = PejabatKomitmen::first();

        $transaksi_biaya = new TransaksiBiaya();
        $biaya = $transaksi_biaya->get_detail($id);

        return view('transaksi_biaya.form',compact('penerima','ppk','kuasaanggaran','bendaharawan', 'transaksi_biaya','pejabat_komitmen',
        'pangkat_golongan','kelompok_jabatan','transport','kota','action','title','page','biaya'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $cekTransaksi = TransaksiBiaya::find($id);
        if($cekTransaksi){
                
            DB::beginTransaction();
            try {
                $data = $request->only('tanggal','tanggal_berangkat','tanggal_kembali','nomor','pegawai_diperintah','jabatan_instansi','nip','pejabat_komitmen_id','pejabat_komitmen2_id'
                ,'pangkat_golongan_id','kelompok_jabatan_id','tingkat_perj_dinas','transport_id','kota_asal_id','ket_keberangkatan','lama_perj_dinas',
                'kota_tujuan_id','ket_tujuan','status_perkawinan','maksud_perj_dinas','jumlah_pengikut','pembantu_ikut','pembebanan_anggaran','mata_anggaran'
                ,'ket_lain2','pengepakan_berat','pengepakan_transport_id','pengepakan_tarif','pengepakan_biaya','uangh_jml_orang','uangh_jml_hari','uangh_jml_tarif'
                ,'uangh_jml_biaya','uangh_jml_pembantu','uangh_jml_hari_p','uangh_jml_tarif_p','uangh_jml_biaya_p','uangh_jml_uang','uangh_jml_terbilang'
                ,'rampung_jumlah','rampung_dibayar','rampung_sisa','rampung_beban_mak','rampung_buktikas','rampung_tgl_pelunasan','rampung_thn_anggaran'
                ,'rampung_bendaharawan_id','rampung_kuasa_nama','rampung_ppk_id','rampung_anggaran_id','rampung_rincian','rampung_kuasa_nip','rampung_kuasa');
                
                $user = auth()->user();
                $data['pengepakan_tarif'] = str_replace(',', '', $data['pengepakan_tarif']);
                $data['pengepakan_biaya'] = str_replace(',', '', $data['pengepakan_biaya']);
                $data['uangh_jml_tarif'] = str_replace(',', '', $data['uangh_jml_tarif']);
                $data['uangh_jml_biaya'] = str_replace(',', '', $data['uangh_jml_biaya']);
                $data['uangh_jml_tarif_p'] = str_replace(',', '', $data['uangh_jml_tarif_p']);
                $data['uangh_jml_biaya_p'] = str_replace(',', '', $data['uangh_jml_biaya_p']);
                $data['uangh_jml_uang'] = str_replace(',', '', $data['uangh_jml_uang']);
                $data['rampung_jumlah'] = str_replace(',', '', $data['rampung_jumlah']);
                $data['rampung_dibayar'] = str_replace(',', '', $data['rampung_dibayar']);
                $data['rampung_beban_mak'] = str_replace(',', '', $data['rampung_beban_mak']);
                $data['uangh_jml_tarif'] = str_replace(',', '', $data['uangh_jml_tarif']);
                $data['uangh_jml_biaya'] = str_replace(',', '', $data['uangh_jml_biaya']);
                $data['uangh_jml_tarif_p'] = str_replace(',', '', $data['uangh_jml_tarif_p']);
                $data['uangh_jml_biaya_p'] = str_replace(',', '', $data['uangh_jml_biaya_p']);
                $data['uangh_jml_uang'] = str_replace(',', '', $data['uangh_jml_uang']);
                $data['updated_by'] = $user->id;
                $transaksi_biaya = TransaksiBiaya::where('id',$id)->update($data);

                //--------------- KELUARGA -------------------
                $kel_nama = $request->kel_nama;
                $kel_dinas = $request->kel_perj_dinas;
                $kel_dob = $request->kel_dob;
                $kel_umur = $request->kel_umur;
                $kel_keterangan = $request->kel_keterangan;
                $kel_id = $request->kel_id;
                $dataKeluarga = [];

                //delete keluarga old
                TransaksiBiayaKeluarga::where('transaksi_biaya_id',$id)->whereNotIn('id',$kel_id)->delete();

                //insert / update
                if($kel_nama != null && count($kel_nama) > 0){
                    foreach($kel_nama as $key => $nama){
                        TransaksiBiayaKeluarga::updateOrCreate([
                            'id' => $kel_id[$key],
                            'transaksi_biaya_id' => $id,
                        ],[
                            'biaya_perj_dinas' => $kel_dinas[$key],
                            'nama' => $nama,
                            'tanggal_lahir' => $kel_dob[$key],
                            'umur' => $kel_umur[$key],
                            'keterangan' => $kel_keterangan[$key],
                            'updated_by' => $user->id,
                            'updated_at' => date('Y-m-d H:i:s'),
                        ]);
                    }
                }
                
                //--------- TRANSPORT -----------------
                $trans_pembantu = $request->trans_pembantu;
                $trans_transport_id = $request->trans_transport_id;
                $trans_kota_asal_id = $request->trans_kota_asal_id;
                $trans_kota_tujuan_id = $request->trans_kota_tujuan_id;
                $trans_orang = $request->trans_orang;
                $trans_biaya = $request->trans_biaya;
                $trans_jumlah_biaya = $request->trans_jumlah_biaya;
                $trans_metode = $request->trans_metode;
                $trans_perkiraan = $request->trans_perkiraan;
                $trans_manual = $request->trans_manual;
                $trans_id = $request->trans_id;

                //delete Transport old
                TransaksiBiayaTransport::where('transaksi_biaya_id',$id)->whereNotIn('id',$trans_id)->delete();

                $dataTransport = [];
                if($trans_pembantu != null && count($trans_pembantu) > 0){
                    foreach($trans_pembantu as $key => $pembantu){
                        
                        TransaksiBiayaTransport::updateOrCreate([
                            'id' => $trans_id[$key],
                            'transaksi_biaya_id' => $id,
                        ],[
                            'pembantu' => $pembantu,
                            'transport_id' => $trans_transport_id[$key],
                            'kota_asal_id' => $trans_kota_asal_id[$key],
                            'kota_tujuan_id' => $trans_kota_tujuan_id[$key],
                            'orang' => $trans_orang[$key],
                            'biaya_perorang' => str_replace(',', '', $trans_biaya[$key]),
                            'rinci_perkiraan' => $trans_perkiraan[$key] != null ? $trans_perkiraan[$key] : "",
                            'jumlah_biaya' => str_replace(',', '', $trans_jumlah_biaya[$key]),
                            'metode' => $trans_metode[$key],
                            'manual' => $trans_manual[$key],
                        ]);
                    }
                }
                
                //--------- MUAT BARANG -----------------
                $muat_transport_id = $request->muat_transport_id;
                $muat_kota_asal_id = $request->muat_kota_asal_id;
                $muat_kota_tujuan_id = $request->muat_kota_tujuan_id;
                $muat_berat = $request->muat_berat;
                $muat_jarak = $request->muat_jarak;
                $muat_biaya = $request->muat_biaya;
                $muat_metode = $request->muat_metode;
                $muat_manual = $request->muat_manual;
                $muat_tarif = $request->muat_tarif;
                $muat_id = $request->muat_id;

                //delete Transport old
                TransaksiBiayaMuat::where('transaksi_biaya_id',$id)->whereNotIn('id',$muat_id)->delete();

                $dataMuat = [];
                if($muat_transport_id != null && count($muat_transport_id) > 0){
                    foreach($muat_transport_id as $key => $transport){

                        TransaksiBiayaMuat::updateOrCreate([
                            'id' => $muat_id[$key],
                            'transaksi_biaya_id' => $id,
                        ],[
                            'transport_id' => $transport,
                            'manual' => $muat_manual[$key],
                            'kota_asal_id' => $muat_kota_asal_id[$key],
                            'kota_tujuan_id' => $muat_kota_tujuan_id[$key],
                            'berat' => $muat_berat[$key],
                            'jarak' => str_replace(',', '', $muat_jarak[$key]),
                            'tarif' => str_replace(',', '', $muat_tarif[$key]),
                            'biaya' => str_replace(',', '', $muat_biaya[$key]),
                            'metode' => $muat_metode[$key],
                        ]);
                    }
                }

                //Commit
                DB::commit();

                return redirect('/transaksi-biaya')->with('info', 'Transaksi biaya berhasil diubah');
                
            } catch (\Exception $e) {
                DB::rollback();
                Log::error($e->getMessage());
                return Redirect::back()->withInput($request->input())->withErrors(['error'=> 'Tambah Transaksi biaya gagal, silahkan coba kembali.']);
                // something went wrong
            }
        }else{
            return Redirect::back()->withInput($request->input())->withErrors(['error'=> 'ID tidak ditemukan']);
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $transaksi_biaya = TransaksiBiaya::find($id);
        if($transaksi_biaya){
            TransaksiBiayaKeluarga::where('transaksi_biaya_id',$transaksi_biaya->id)->delete();
            TransaksiBiayaTransport::where('transaksi_biaya_id',$transaksi_biaya->id)->delete();
            TransaksiBiayaMuat::where('transaksi_biaya_id',$transaksi_biaya->id)->delete();
            TransaksiBiaya::where('id',$transaksi_biaya->id)->delete();
            return redirect('/transaksi-biaya')->with('info', 'Transaki biaya berhasil di delete.');
        }else{
            return Redirect::back()->withErrors(['error'=> 'Transaki biaya tidak ditemukan.']);
        }
    }

}
