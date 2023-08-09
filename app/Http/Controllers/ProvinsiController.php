<?php

namespace App\Http\Controllers;

use App\Models\Provinsi;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Redirect;
use Log;
use PDF;

class ProvinsiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        $provinsi = new Provinsi();
        $data = $provinsi->get_data($request);

        $page = 'PROVINSI';
        if($request->ajax()){
            return view('provinsi.list_pagination', compact('data'));
        }else{
            return view('provinsi.list', compact('data','page'));
        }
    }
    
    public function printPdf(Request $request)
    {
        
        $title = 'DAFTAR PROVINSI';
        $provinsi = new Provinsi();
        $data = $provinsi->get_data($request);
    	$pdf = PDF::loadview('provinsi.list_pdf', compact('data','title'));
    	return $pdf->download('DAFTAR-PROVINSI.pdf');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $action = 'store';
        $page = 'PROVINSI';
        $title = 'Tambah baru';
        return view('provinsi.form',compact('action','title','page'));
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
            'nama'   => 'required',
            'kode'   => 'required',
            'status'   => 'required',
        ]);

        DB::beginTransaction();
        try {
            $data = $request->only(['nama','kode','status']);
            
            $data['jawamadura'] = $request->has('jawamadura') ? $request->jawamadura : 0;
            $user = auth()->user();
            $data['created_by'] = $user->id;
            $data['updated_by'] = $user->id;
            $provinsi = Provinsi::create($data);

            DB::commit();

            return redirect('/provinsi')->with('info', 'Provinsi berhasil ditambahkan');
            
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            return Redirect::back()->withInput($request->input())->withErrors(['error'=> 'Tambah Provinsi gagal, silahkan coba kembali.']);
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

        $mprovinsi = new Provinsi();
        $provinsi = $mprovinsi->get_id($id);

        $action = 'update';
        $title = 'Provinsi Update';
        $page = 'PROVINSI';
        return view('provinsi.form',compact('provinsi','action','title','page'));
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
        ]);

        $provinsi = Provinsi::find($request->id);
        if($provinsi){

            DB::beginTransaction();
            try {
                $data = $request->only(['nama','kode','status']);
                $data['jawamadura'] = $request->has('jawamadura') ? $request->jawamadura : 0;
                $user = auth()->user();
                $data['updated_by'] = $user->id;
                Provinsi::where('id',$provinsi->id)->update($data);
                DB::commit();

                return redirect('/provinsi')->with('info', 'Provinsi berhasil di update');
                
            } catch (\Exception $e) {
                DB::rollback();
                Log::Error($e->getMessage());
                return Redirect::back()->withInput($request->input())->withErrors(['error'=> 'Update Provinsi gagal, silahkan coba kembali.']);
                // something went wrong
            }
        }else{
            return Redirect::back()->withInput($request->input())->withErrors(['error'=> 'Data Provinsi tidak ditemukan.']);
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
        $provinsi = Provinsi::find($id);
        if($provinsi ){
            Provinsi::where('id',$provinsi->id)->delete();
            return redirect('/provinsi')->with('info', 'Provinsi berhasil di delete.');
        }else{
            return Redirect::back()->withErrors(['error'=> 'Data Provinsi tidak ditemukan.']);
        }
    }

}
