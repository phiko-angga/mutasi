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
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Redirect;
use Log;
use PDF;

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
    
    public function printDetailPdf(Request $request, $id)
    {
        $title = 'SURAT PERJALANAN DINAS';
        $transaksi_biaya = new TransaksiBiaya();
        $data = $transaksi_biaya->get_detail($id);
        // Log::debug('data '.json_encode($data));
    	// return view('transaksi_biaya.list_detail_pdf', compact('data','title'));
    	$pdf = PDF::loadview('transaksi_biaya.list_detail_pdf', compact('data','title'));
    	return $pdf->stream('SURAT PERJALANAN DINAS.pdf');
    }

    public function printExcel(Request $request)
    {
        return \Excel::download(new transaksi_biayaExport($request), 'DAFTAR NAMA PEJABAT PENANDATANGANAN.xlsx');
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
        $ppk = PejabatKomitmen::first();
        return view('transaksi_biaya.form',compact('ppk','kuasaanggaran','bendaharawan','action','title','page','pejabat_komitmen','pangkat_golongan','kelompok_jabatan','transport','kota'));
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
            ,'rampung_bendaharawan_id','rampung_kuasa_nama','rampung_ppk_id','rampung_anggaran_id','rampung_rincian');
            
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
        Log::debug('$biaya '.json_encode($biaya));

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

        $mtransaksi_biaya = new Paraf();
        $transaksi_biaya = $mtransaksi_biaya->get_id($id);

        $action = 'update';
        $title = 'Paraf Update';
        $page = 'Paraf';
        return view('transaksi_biaya.form',compact('transaksi_biaya','action','title','page'));
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
        request()->validate([
            'id'   => 'required',
            'kelompok'   => 'required',
            'nourut'   => 'required',
            'nama'   => 'required',
            'nip'   => 'required',
            'pangkat'   => 'required',
            'jabatan'   => 'required',
        ]);

        $transaksi_biaya = Paraf::find($request->id);
        if($transaksi_biaya){

            DB::beginTransaction();
            try {
                $data = $request->except(['_token','_method']);
                
                $user = auth()->user();
                $data['updated_by'] = $user->id;
                Paraf::where('id',$transaksi_biaya->id)->update($data);
                DB::commit();

                return redirect('/transaksi_biaya')->with('info', 'Paraf berhasil di update');
                
            } catch (\Exception $e) {
                DB::rollback();
                Log::Error($e->getMessage());
                return Redirect::back()->withInput($request->input())->withErrors(['error'=> 'Update Paraf gagal, silahkan coba kembali.']);
                // something went wrong
            }
        }else{
            return Redirect::back()->withInput($request->input())->withErrors(['error'=> 'Data Paraf tidak ditemukan.']);
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
