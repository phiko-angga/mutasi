<?php

namespace App\Http\Controllers;

use App\Models\Sbum;
use App\Models\Provinsi;
use App\Models\Kota;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Redirect;
use Log;

class SbumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        $sbum = new Sbum();
        $data = $sbum->get_data($request);

        $page = 'SBU - M';
        if($request->ajax()){
            return view('sbum.list_pagination', compact('data'));
        }else{
            return view('sbum.list', compact('data','page'));
        }
    }
    
    public function printPdf(Request $request)
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $action = 'store';
        $page = 'SBU - M';
        $title = 'Tambah baru';
        $provinsi = Provinsi::all();
        $kota = Kota::all();
        return view('sbum.form',compact('action','title','page','provinsi','kota'));
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
            'harga_tiket'   => 'required',
        ]);

        DB::beginTransaction();
        try {
            $data = $request->only(['harga_tiket','provinsi_asal_id','provinsi_tujuan_id','kota_asal_id','kota_tujuan_id']);
            
            $user = auth()->user();
            $data['created_by'] = $user->id;
            $data['updated_by'] = $user->id;
            $sbum = Sbum::create($data);

            DB::commit();

            return redirect('/sbum')->with('info', 'SBU-M berhasil ditambahkan');
            
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            return Redirect::back()->withInput($request->input())->withErrors(['error'=> 'Tambah SBU-M gagal, silahkan coba kembali.']);
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

        $msbum = new Sbum();
        $sbum = $msbum->get_id($id);

        $action = 'update';
        $title = 'Sbum Update';
        $page = 'SBU - M';
        $provinsi = Provinsi::all();
        $kota = Kota::all();
        return view('sbum.form',compact('sbum','action','title','page','provinsi','kota'));
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
            'harga_tiket'   => 'required',
        ]);

        $sbum = Sbum::find($request->id);
        if($sbum){

            DB::beginTransaction();
            try {
                $data = $request->only(['harga_tiket','provinsi_asal_id','provinsi_tujuan_id','kota_asal_id','kota_tujuan_id']);
                
                $user = auth()->user();
                $data['updated_by'] = $user->id;
                Sbum::where('id',$sbum->id)->update($data);
                DB::commit();

                return redirect('/sbum')->with('info', 'SBU-M berhasil di update');
                
            } catch (\Exception $e) {
                DB::rollback();
                Log::Error($e->getMessage());
                return Redirect::back()->withInput($request->input())->withErrors(['error'=> 'Update SBU-M gagal, silahkan coba kembali.']);
                // something went wrong
            }
        }else{
            return Redirect::back()->withInput($request->input())->withErrors(['error'=> 'Data SBU-M tidak ditemukan.']);
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
        $sbum = Sbum::find($id);
        if($sbum ){
            Sbum::where('id',$sbum->id)->delete();
            return redirect('/sbum')->with('info', 'SBU-M berhasil di delete.');
        }else{
            return Redirect::back()->withErrors(['error'=> 'Data SBU-M tidak ditemukan.']);
        }
    }

}
