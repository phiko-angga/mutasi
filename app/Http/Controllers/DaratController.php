<?php

namespace App\Http\Controllers;

use App\Models\Darat;
use App\Models\Provinsi;
use App\Models\Kota;
use App\Exports\DaratExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Redirect;
use Log;
use PDF;

class DaratController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        $darat = new Darat();
        $data = $darat->get_data($request);

        $page = 'Darat';
        if($request->ajax()){
            return view('darat.list_pagination', compact('data'));
        }else{
            return view('darat.list', compact('data','page'));
        }
    }
    
    public function printPdf(Request $request)
    {
        
        $title = 'DAFTAR RUTE DARAT';
        $darat = new Darat();
        $data = $darat->get_data($request);
    	$pdf = PDF::loadview('darat.list_pdf', compact('data','title'));
    	return $pdf->download('DAFTAR-RUTE-DARAT.pdf');
    }

    public function printExcel(Request $request)
    {
        return \Excel::download(new daratExport($request), 'MASTER DARAT.xlsx');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $action = 'store';
        $page = 'Darat';
        $title = 'Tambah baru';
        $provinsi = Provinsi::all();
        $kota = Kota::all();
        return view('darat.form',compact('action','title','page','provinsi','kota'));
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
            'provinsi_asal_id'   => 'required',
            'provinsi_tujuan_id'   => 'required',
            'kota_asal_id'   => 'required',
            'kota_tujuan_id'   => 'required',
            'jarak_km'   => 'required',
        ]);

        DB::beginTransaction();
        try {
            $data = $request->only(['jarak_km','provinsi_asal_id','provinsi_tujuan_id','kota_asal_id','kota_tujuan_id']);
            
            $user = auth()->user();
            $data['created_by'] = $user->id;
            $data['updated_by'] = $user->id;
            $darat = Darat::create($data);

            DB::commit();

            return redirect('/darat')->with('info', 'Darat berhasil ditambahkan');
            
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            return Redirect::back()->withInput($request->input())->withErrors(['error'=> 'Tambah Darat gagal, silahkan coba kembali.']);
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

        $mdarat = new Darat();
        $darat = $mdarat->get_id($id);

        $action = 'update';
        $title = 'Darat Update';
        $page = 'Darat';
        $provinsi = Provinsi::all();
        $kota = Kota::all();
        return view('darat.form',compact('darat','action','title','page','provinsi','kota'));
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
            'provinsi_asal_id'   => 'required',
            'provinsi_tujuan_id'   => 'required',
            'kota_asal_id'   => 'required',
            'kota_tujuan_id'   => 'required',
            'jarak_km'   => 'required',
        ]);

        $darat = Darat::find($request->id);
        if($darat){

            DB::beginTransaction();
            try {
                $data = $request->only(['jarak_km','provinsi_asal_id','provinsi_tujuan_id','kota_asal_id','kota_tujuan_id']);
                
                $user = auth()->user();
                $data['updated_by'] = $user->id;
                Darat::where('id',$darat->id)->update($data);
                DB::commit();

                return redirect('/darat')->with('info', 'Darat berhasil di update');
                
            } catch (\Exception $e) {
                DB::rollback();
                Log::Error($e->getMessage());
                return Redirect::back()->withInput($request->input())->withErrors(['error'=> 'Update Darat gagal, silahkan coba kembali.']);
                // something went wrong
            }
        }else{
            return Redirect::back()->withInput($request->input())->withErrors(['error'=> 'Data Darat tidak ditemukan.']);
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
        $darat = Darat::find($id);
        if($darat ){
            Darat::where('id',$darat->id)->delete();
            return redirect('/darat')->with('info', 'Darat berhasil di delete.');
        }else{
            return Redirect::back()->withErrors(['error'=> 'Data Darat tidak ditemukan.']);
        }
    }

}
