<?php

namespace App\Http\Controllers;

use App\Models\BiayaPengepakan;
use App\Exports\BiayaPengepakanExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Redirect;
use Log;
use PDF;

class BiayaPengepakanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        $biaya = new BiayaPengepakan();
        $data = $biaya->get_data($request);

        $page = 'Biaya Pengepakan';
        if($request->ajax()){
            return view('biaya_pengepakan.list_pagination', compact('data'));
        }else{
            return view('biaya_pengepakan.list', compact('data','page'));
        }
    }
    
    public function printPdf(Request $request)
    {
        
        $title = 'BIAYA PENGEPAKAN BARANG';
        $biaya = new BiayaPengepakan();
        $data = $biaya->get_data($request);
    	$pdf = PDF::loadview('biaya_pengepakan.list_pdf', compact('data','title'));
    	return $pdf->stream('BIAYA PENGEPAKAN BARANG.pdf');
    }

    public function printExcel(Request $request)
    {
        return \Excel::download(new BiayaPengepakanExport($request), 'BIAYA PENGEPAKAN BARANG.xlsx');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $action = 'store';
        $page = 'Biaya Pengepakan Barang';
        $title = 'Tambah baru';
        return view('biaya_pengepakan.form',compact('action','title','page'));
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
            'transport_darat'   => 'required',
            'transport_laut'   => 'required',
        ]);

        DB::beginTransaction();
        try {
            $data = $request->only(['transport_darat','transport_laut']);
            
            $user = auth()->user();
            $data['transport_darat'] = str_replace(",","",$data['transport_darat']);
            $data['transport_laut'] = str_replace(",","",$data['transport_laut']);
            $data['created_by'] = $user->id;
            $data['updated_by'] = $user->id;
            $biaya = BiayaPengepakan::create($data);

            DB::commit();

            return redirect('/biaya-pengepakan')->with('info', 'Biaya Pengepakan Barang berhasil ditambahkan');
            
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            return Redirect::back()->withInput($request->input())->withErrors(['error'=> 'Tambah Biaya Pengepakan Barang gagal, silahkan coba kembali.']);
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

        $mdarat = new BiayaPengepakan();
        $biaya = $mdarat->get_id($id);

        $action = 'update';
        $title = 'Biaya Pengepakan Barang Update';
        $page = 'Biaya Pengepakan Barang';
        return view('biaya_pengepakan.form',compact('biaya','action','title'));
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
            'transport_darat'   => 'required',
            'transport_laut'   => 'required',
        ]);

        $biaya = BiayaPengepakan::find($request->id);
        if($biaya){

            DB::beginTransaction();
            try {
                $data = $request->only(['transport_darat','transport_laut']);
                
                $user = auth()->user();
                $data['transport_darat'] = str_replace(",","",$data['transport_darat']);
                $data['transport_laut'] = str_replace(",","",$data['transport_laut']);
                $data['updated_by'] = $user->id;
                BiayaPengepakan::where('id',$biaya->id)->update($data);
                DB::commit();

                return redirect('/biaya-pengepakan')->with('info', 'Biaya Pengepakan Barang berhasil di update');
                
            } catch (\Exception $e) {
                DB::rollback();
                Log::Error($e->getMessage());
                return Redirect::back()->withInput($request->input())->withErrors(['error'=> 'Update Biaya Pengepakan Barang gagal, silahkan coba kembali.']);
                // something went wrong
            }
        }else{
            return Redirect::back()->withInput($request->input())->withErrors(['error'=> 'Data Biaya Pengepakan Barang tidak ditemukan.']);
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
        $biaya = BiayaPengepakan::find($id);
        if($biaya ){
            BiayaPengepakan::where('id',$biaya->id)->delete();
            return redirect('/biaya-pengepakan')->with('info', 'Biaya Pengepakan Barang berhasil di delete.');
        }else{
            return Redirect::back()->withErrors(['error'=> 'Data Biaya Pengepakan Barang tidak ditemukan.']);
        }
    }

}
