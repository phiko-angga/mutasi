<?php

namespace App\Http\Controllers;

use App\Models\Rute;
use App\Models\Provinsi;
use App\Models\Kota;
use App\Exports\RuteExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Redirect;
use Log;
use PDF;

class RuteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        $rute = new Rute();
        $data = $rute->get_data($request);

        $page = 'Rute';
        if($request->ajax()){
            return view('rute.list_pagination', compact('data'));
        }else{
            return view('rute.list', compact('data','page'));
        }
    }
    
    public function printPdf(Request $request)
    {
        
        $title = 'DAFTAR BIAYA TIKET KOTA PROVINSI REPUBLIK INDONESIA';
        $rute = new Rute();
        $data = $rute->get_data($request);
    	$pdf = PDF::loadview('rute.list_pdf', compact('data','title'));
    	return $pdf->stream('DAFTAR BIAYA TIKET KOTA PROVINSI REPUBLIK INDONESIA.pdf');
    }

    public function printExcel(Request $request)
    {
        return \Excel::download(new ruteExport($request), 'DAFTAR BIAYA TIKET KOTA PROVINSI REPUBLIK INDONESIA.xlsx');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $action = 'store';
        $page = 'Rute';
        $title = 'Tambah baru';
        $kota = Kota::all();
        $title = 'Tambah baru';
        $provinsi = Provinsi::all();
        return view('rute.form',compact('action','title','page','kota','provinsi'));
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
            'kota_id'   => 'required',
            'bus'   => 'required',
            'kapal'   => 'required',
            'plane'   => 'required',
        ]);

        DB::beginTransaction();
        try {
            $data = $request->except(['_token']);
            
            $user = auth()->user();
            $data['bus'] = str_replace(",","",$data['bus']);
            $data['kapal'] = str_replace(",","",$data['kapal']);
            $data['plane'] = str_replace(",","",$data['plane']);
            $data['created_by'] = $user->id;
            $data['updated_by'] = $user->id;
            $rute = Rute::create($data);

            DB::commit();

            return redirect('/rute')->with('info', 'Rute berhasil ditambahkan');
            
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            return Redirect::back()->withInput($request->input())->withErrors(['error'=> 'Tambah Rute gagal, silahkan coba kembali.']);
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

        $mrute = new Rute();
        $rute = $mrute->get_id($id);

        $action = 'update';
        $title = 'Rute Update';
        $page = 'Rute';
        $kota = Kota::all();
        $provinsi = Provinsi::all();
        return view('rute.form',compact('rute','action','title','page','kota','provinsi'));
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
            'kota_id'   => 'required',
            'bus'   => 'required',
            'kapal'   => 'required',
            'plane'   => 'required',
        ]);

        $rute = Rute::find($request->id);
        if($rute){

            DB::beginTransaction();
            try {
                $data = $request->except(['_token','_method']);
                
                $user = auth()->user();
                $data['bus'] = str_replace(",","",$data['bus']);
                $data['kapal'] = str_replace(",","",$data['kapal']);
                $data['plane'] = str_replace(",","",$data['plane']);
                $data['updated_by'] = $user->id;
                Rute::where('id',$rute->id)->update($data);
                DB::commit();

                return redirect('/rute')->with('info', 'Rute berhasil di update');
                
            } catch (\Exception $e) {
                DB::rollback();
                Log::Error($e->getMessage());
                return Redirect::back()->withInput($request->input())->withErrors(['error'=> 'Update Rute gagal, silahkan coba kembali.']);
                // something went wrong
            }
        }else{
            return Redirect::back()->withInput($request->input())->withErrors(['error'=> 'Data Rute tidak ditemukan.']);
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
        $rute = Rute::find($id);
        if($rute ){
            Rute::where('id',$rute->id)->delete();
            return redirect('/rute')->with('info', 'Rute berhasil di delete.');
        }else{
            return Redirect::back()->withErrors(['error'=> 'Data Rute tidak ditemukan.']);
        }
    }

}
