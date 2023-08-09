<?php

namespace App\Http\Controllers;

use App\Models\Laut;
use App\Models\Provinsi;
use App\Models\Pelabuhan;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Redirect;
use Log;
use PDF;

class LautController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        $laut = new Laut();
        $data = $laut->get_data($request);

        $page = 'Laut';
        if($request->ajax()){
            return view('laut.list_pagination', compact('data'));
        }else{
            return view('laut.list', compact('data','page'));
        }
    }
    
    public function printPdf(Request $request)
    {
        
        $title = 'DAFTAR RUTE LAUT';
        $laut = new Laut();
        $data = $laut->get_data($request);
    	$pdf = PDF::loadview('laut.list_pdf', compact('data','title'));
    	return $pdf->download('DAFTAR-RUTE-LAUT.pdf');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $action = 'store';
        $page = 'Laut';
        $title = 'Tambah baru';
        $provinsi = Provinsi::all();
        $pelabuhan = Pelabuhan::all();
        return view('laut.form',compact('action','title','page','provinsi','pelabuhan'));
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
            'pelabuhan_asal_id'   => 'required',
            'pelabuhan_tujuan_id'   => 'required',
            'jarak_mil'   => 'required',
        ]);

        DB::beginTransaction();
        try {
            $data = $request->only(['jarak_mil','provinsi_asal_id','provinsi_tujuan_id','pelabuhan_asal_id','pelabuhan_tujuan_id']);
            
            $user = auth()->user();
            $data['created_by'] = $user->id;
            $data['updated_by'] = $user->id;
            $laut = Laut::create($data);

            DB::commit();

            return redirect('/laut')->with('info', 'Laut berhasil ditambahkan');
            
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            return Redirect::back()->withInput($request->input())->withErrors(['error'=> 'Tambah Laut gagal, silahkan coba kembali.']);
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

        $mlaut = new Laut();
        $laut = $mlaut->get_id($id);

        $action = 'update';
        $title = 'Laut Update';
        $page = 'Laut';
        $provinsi = Provinsi::all();
        $pelabuhan = Pelabuhan::all();
        return view('laut.form',compact('laut','action','title','page','provinsi','pelabuhan'));
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
            'pelabuhan_asal_id'   => 'required',
            'pelabuhan_tujuan_id'   => 'required',
            'jarak_mil'   => 'required',
        ]);

        $laut = Laut::find($request->id);
        if($laut){

            DB::beginTransaction();
            try {
                $data = $request->only(['jarak_mil','provinsi_asal_id','provinsi_tujuan_id','pelabuhan_asal_id','pelabuhan_tujuan_id']);
                
                $user = auth()->user();
                $data['updated_by'] = $user->id;
                Laut::where('id',$laut->id)->update($data);
                DB::commit();

                return redirect('/laut')->with('info', 'Laut berhasil di update');
                
            } catch (\Exception $e) {
                DB::rollback();
                Log::Error($e->getMessage());
                return Redirect::back()->withInput($request->input())->withErrors(['error'=> 'Update Laut gagal, silahkan coba kembali.']);
                // something went wrong
            }
        }else{
            return Redirect::back()->withInput($request->input())->withErrors(['error'=> 'Data Laut tidak ditemukan.']);
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
        $laut = Laut::find($id);
        if($laut ){
            Laut::where('id',$laut->id)->delete();
            return redirect('/laut')->with('info', 'Laut berhasil di delete.');
        }else{
            return Redirect::back()->withErrors(['error'=> 'Data Laut tidak ditemukan.']);
        }
    }

}
