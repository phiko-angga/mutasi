<?php

namespace App\Http\Controllers;

use App\Models\Dephub;
use App\Models\Provinsi;
use App\Models\Kota;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Redirect;
use Log;

class DephubController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        $dephub = new Dephub();
        $data = $dephub->get_data($request);

        $page = 'Dep Hub';
        if($request->ajax()){
            return view('dephub.list_pagination', compact('data'));
        }else{
            return view('dephub.list', compact('data','page'));
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
        $page = 'Dep Hub';
        $title = 'Tambah baru';
        $provinsi = Provinsi::all();
        $kota = Kota::all();
        return view('dephub.form',compact('action','title','page','provinsi','kota'));
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
            'jarak_km'   => 'required',
        ]);

        DB::beginTransaction();
        try {
            $data = $request->only(['jarak_km','harga_tiket','provinsi_asal_id','provinsi_tujuan_id','kota_asal_id','kota_tujuan_id']);
            
            $user = auth()->user();
            $data['created_by'] = $user->id;
            $data['updated_by'] = $user->id;
            $dephub = Dephub::create($data);

            DB::commit();

            return redirect('/dephub')->with('info', 'Dep Hub berhasil ditambahkan');
            
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            return Redirect::back()->withInput($request->input())->withErrors(['error'=> 'Tambah Dep Hub gagal, silahkan coba kembali.']);
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

        $mdephub = new Dephub();
        $dephub = $mdephub->get_id($id);

        $action = 'update';
        $title = 'Dep Hub Update';
        $page = 'Dep Hub';
        $provinsi = Provinsi::all();
        $kota = Kota::all();
        return view('dephub.form',compact('dephub','action','title','page','provinsi','kota'));
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
            'jarak_km'   => 'required',
        ]);

        $dephub = Dephub::find($request->id);
        if($dephub){

            DB::beginTransaction();
            try {
                $data = $request->only(['jarak_km','harga_tiket','provinsi_asal_id','provinsi_tujuan_id','kota_asal_id','kota_tujuan_id']);
                
                $user = auth()->user();
                $data['updated_by'] = $user->id;
                Dephub::where('id',$dephub->id)->update($data);
                DB::commit();

                return redirect('/dephub')->with('info', 'Dep Hub berhasil di update');
                
            } catch (\Exception $e) {
                DB::rollback();
                Log::Error($e->getMessage());
                return Redirect::back()->withInput($request->input())->withErrors(['error'=> 'Update Dep Hub gagal, silahkan coba kembali.']);
                // something went wrong
            }
        }else{
            return Redirect::back()->withInput($request->input())->withErrors(['error'=> 'Data Dep Hub tidak ditemukan.']);
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
        $dephub = Dephub::find($id);
        if($dephub ){
            Dephub::where('id',$dephub->id)->delete();
            return redirect('/dephub')->with('info', 'Dep Hub berhasil di delete.');
        }else{
            return Redirect::back()->withErrors(['error'=> 'Data Dep Hub tidak ditemukan.']);
        }
    }

}
