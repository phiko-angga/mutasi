<?php

namespace App\Http\Controllers;

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
        
        // $transaksi_biaya = new Paraf();
        // $data = $transaksi_biaya->get_data($request);

        $page = 'Perhitungan Biaya Mutasi';
        if($request->ajax()){
            return view('transaksi_biaya.list_pagination');
        }else{
            return view('transaksi_biaya.list', compact('page'));
        }
    }
    
    public function printPdf(Request $request)
    {
        $title = 'DAFTAR NAMA PEJABAT PENANDATANGANAN';
        $transaksi_biaya = new Paraf();
        $data = $transaksi_biaya->get_data($request);
    	$pdf = PDF::loadview('transaksi_biaya.list_pdf', compact('data','title'));
    	return $pdf->stream('DAFTAR NAMA PEJABAT PENANDATANGANAN.pdf');
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
        return view('transaksi_biaya.form',compact('action','title','page','pejabat_komitmen','pangkat_golongan','kelompok_jabatan','transport','kota'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        request()->validate([
            'kelompok'   => 'required',
            'nourut'   => 'required',
            'nama'   => 'required',
            'nip'   => 'required',
            'pangkat'   => 'required',
            'jabatan'   => 'required',
        ]);

        DB::beginTransaction();
        try {
            $data = $request->except(['_token']);
            
            $user = auth()->user();
            $data['created_by'] = $user->id;
            $data['updated_by'] = $user->id;
            $transaksi_biaya = Paraf::create($data);

            DB::commit();

            return redirect('/transaksi_biaya')->with('info', 'Paraf berhasil ditambahkan');
            
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            return Redirect::back()->withInput($request->input())->withErrors(['error'=> 'Tambah Paraf gagal, silahkan coba kembali.']);
            // something went wrong
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        $transaksi_biaya = Paraf::find($id);
        if($transaksi_biaya ){
            Paraf::where('id',$transaksi_biaya->id)->delete();
            return redirect('/transaksi_biaya')->with('info', 'Paraf berhasil di delete.');
        }else{
            return Redirect::back()->withErrors(['error'=> 'Data Paraf tidak ditemukan.']);
        }
    }

}
