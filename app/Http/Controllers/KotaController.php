<?php

namespace App\Http\Controllers;

use App\Models\Provinsi;
use App\Models\Kota;
use App\Exports\KotaExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Redirect;
use Log;
use PDF;

class KotaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        $kota = new Kota();
        $data = $kota->get_data($request);

        $page = 'KOTA';
        if($request->ajax()){
            return view('kota.list_pagination', compact('data'));
        }else{
            return view('kota.list', compact('data','page'));
        }
    }
    
    public function printPdf(Request $request)
    {
        
        $title = 'DAFTAR KOTA';
        $kota = new Kota();
        $data = $kota->get_data($request);
    	$pdf = PDF::loadview('kota.list_pdf', compact('data','title'));
    	return $pdf->download('DAFTAR-KOTA.pdf');
    }

    public function printExcel(Request $request)
    {
        return \Excel::download(new kotaExport($request), 'MASTER KOTA.xlsx');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $action = 'store';
        $page = 'KOTA';
        $title = 'Tambah baru';
        $provinsi = Provinsi::all();
        return view('kota.form',compact('action','title','page','provinsi'));
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
            'provinsi_id'   => 'required',
            'nama'   => 'required',
            'kode'   => 'required',
            'status'   => 'required',
        ]);

        DB::beginTransaction();
        try {
            $data = $request->except(['_token']);
            
            $data['jawamadura'] = 0;
            $user = auth()->user();
            $data['created_by'] = $user->id;
            $data['updated_by'] = $user->id;
            $kota = Kota::create($data);

            DB::commit();

            return redirect('/kota')->with('info', 'Kota berhasil ditambahkan');
            
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            return Redirect::back()->withInput($request->input())->withErrors(['error'=> 'Tambah Kota gagal, silahkan coba kembali.']);
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

        $mkota = new Kota();
        $kota = $mkota->get_id($id);

        $action = 'update';
        $title = 'Kota Update';
        $page = 'KOTA';
        $provinsi = Provinsi::all();
        return view('kota.form',compact('kota','action','title','page','provinsi'));
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
            'nama'   => 'required',
            'kode'   => 'required',
            'provinsi_id'   => 'required',
        ]);

        $kota = Kota::find($request->id);
        if($kota){

            DB::beginTransaction();
            try {
                $data = $request->except(['_token','_method']);
                $user = auth()->user();
                $data['updated_by'] = $user->id;
                $data['jawamadura'] = 0;
                Kota::where('id',$kota->id)->update($data);
                DB::commit();

                return redirect('/kota')->with('info', 'Kota berhasil di update');
                
            } catch (\Exception $e) {
                DB::rollback();
                Log::Error($e->getMessage());
                return Redirect::back()->withInput($request->input())->withErrors(['error'=> 'Update Kota gagal, silahkan coba kembali.']);
                // something went wrong
            }
        }else{
            return Redirect::back()->withInput($request->input())->withErrors(['error'=> 'Data Kota tidak ditemukan.']);
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
        $kota = Kota::find($id);
        if($kota ){
            Kota::where('id',$kota->id)->delete();
            return redirect('/kota')->with('info', 'Kota berhasil di delete.');
        }else{
            return Redirect::back()->withErrors(['error'=> 'Data Kota tidak ditemukan.']);
        }
    }

}
