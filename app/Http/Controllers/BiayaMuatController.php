<?php

namespace App\Http\Controllers;

use App\Models\BiayaMuat;
use App\Exports\BiayaMuatExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Redirect;
use Log;
use PDF;

class BiayaMuatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        $biaya = new BiayaMuat();
        $data = $biaya->get_data($request);

        $page = 'Biaya Muat Barang';
        if($request->ajax()){
            return view('biaya_muat.list_pagination', compact('data'));
        }else{
            return view('biaya_muat.list', compact('data','page'));
        }
    }
    
    public function printPdf(Request $request)
    {
        
        $title = 'DAFTAR BIAYA MUAT BARANG';
        $biaya = new BiayaMuat();
        $data = $biaya->get_data($request);
    	$pdf = PDF::loadview('biaya_muat.list_pdf', compact('data','title'));
    	return $pdf->download('DAFTAR BIAYA MUAT BARANG.pdf');
    }

    public function printExcel(Request $request)
    {
        return \Excel::download(new BiayaMuatExport($request), 'MASTER BIAYA MUAT BARANG.xlsx');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $action = 'store';
        $page = 'Biaya Muat Barang';
        $title = 'Tambah baru';
        return view('biaya_muat.form',compact('action','title','page'));
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
            'biaya_darat'   => 'required',
            'biaya_laut'   => 'required',
        ]);

        DB::beginTransaction();
        try {
            $data = $request->only(['biaya_darat','biaya_laut','jawamadura']);
            
            $user = auth()->user();
            $data['created_by'] = $user->id;
            $data['updated_by'] = $user->id;
            $biaya = BiayaMuat::create($data);

            DB::commit();

            return redirect('/biaya-muat')->with('info', 'Biaya Muat Barang berhasil ditambahkan');
            
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            return Redirect::back()->withInput($request->input())->withErrors(['error'=> 'Tambah Biaya Muat Barang gagal, silahkan coba kembali.']);
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

        $mdarat = new BiayaMuat();
        $biaya = $mdarat->get_id($id);

        $action = 'update';
        $title = 'Biaya Muat Barang Update';
        $page = 'Biaya Muat Barang';
        return view('biaya_muat.form',compact('biaya','action','title'));
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
            'biaya_darat'   => 'required',
            'biaya_laut'   => 'required',
        ]);

        $biaya = BiayaMuat::find($request->id);
        if($biaya){

            DB::beginTransaction();
            try {
                $data = $request->only(['biaya_darat','biaya_laut','jawamadura']);
                
                $user = auth()->user();
                $data['updated_by'] = $user->id;
                BiayaMuat::where('id',$biaya->id)->update($data);
                DB::commit();

                return redirect('/biaya-muat')->with('info', 'Biaya Muat Barang berhasil di update');
                
            } catch (\Exception $e) {
                DB::rollback();
                Log::Error($e->getMessage());
                return Redirect::back()->withInput($request->input())->withErrors(['error'=> 'Update Biaya Muat Barang gagal, silahkan coba kembali.']);
                // something went wrong
            }
        }else{
            return Redirect::back()->withInput($request->input())->withErrors(['error'=> 'Data Biaya Muat Barang tidak ditemukan.']);
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
        $biaya = BiayaMuat::find($id);
        if($biaya ){
            BiayaMuat::where('id',$biaya->id)->delete();
            return redirect('/biaya-muat')->with('info', 'Biaya Muat Barang berhasil di delete.');
        }else{
            return Redirect::back()->withErrors(['error'=> 'Data Biaya Muat Barang tidak ditemukan.']);
        }
    }

}
