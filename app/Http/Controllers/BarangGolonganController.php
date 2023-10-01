<?php

namespace App\Http\Controllers;

use App\Models\BarangGolongan;
use App\Exports\BarangGolonganExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Redirect;
use Log;
use PDF;

class BarangGolonganController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        $barang = new BarangGolongan();
        $data = $barang->get_data($request);

        $page = 'Maks. Barang (Kg) Per Gol.';
        if($request->ajax()){
            return view('barang_golongan.list_pagination', compact('data'));
        }else{
            return view('barang_golongan.list', compact('data','page'));
        }
    }
    
    public function printPdf(Request $request)
    {
        
        $title = 'MAKS. BARANG (KG) PER GOL.';
        $barang = new BarangGolongan();
        $data = $barang->get_data($request);
    	$pdf = PDF::loadview('barang_golongan.list_pdf', compact('data','title'));
    	return $pdf->stream('MAKS BARANG (KG) PER GOL.pdf');
    }

    public function printExcel(Request $request)
    {
        return \Excel::download(new BarangGolonganExport($request), 'MAKS BARANG (KG) PER GOL.xlsx');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $action = 'store';
        $page = 'MAKS. BARANG (KG) PER GOL.';
        $title = 'Tambah baru';
        return view('barang_golongan.form',compact('action','title','page'));
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
            'golongan'   => 'required',
            'bujangan'   => 'required',
            'keluarga'   => 'required',
            'anak1'   => 'required',
            'anak2'   => 'required',
            'anak3'   => 'required',
        ]);

        DB::beginTransaction();
        try {
            $data = $request->except(['_token','_method']);
            
            $user = auth()->user();
            $data['created_by'] = $user->id;
            $data['updated_by'] = $user->id;
            $barang = BarangGolongan::create($data);

            DB::commit();

            return redirect('/barang-golongan')->with('info', 'Barang per Golongan berhasil ditambahkan');
            
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            return Redirect::back()->withInput($request->input())->withErrors(['error'=> 'Tambah Barang per Golongan gagal, silahkan coba kembali.']);
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

        $mBarang = new BarangGolongan();
        $barang = $mBarang->get_id($id);

        $action = 'update';
        $title = 'Barang per Golongan Update';
        $page = 'Barang per Golongan';
        return view('barang_golongan.form',compact('barang','action','title'));
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
            'golongan'   => 'required',
            'bujangan'   => 'required',
            'keluarga'   => 'required',
            'anak1'   => 'required',
            'anak2'   => 'required',
            'anak3'   => 'required',
        ]);

        $barang = BarangGolongan::find($request->id);
        if($barang){

            DB::beginTransaction();
            try {
                $data = $request->except(['_token','_method']);
                
                $user = auth()->user();
                $data['updated_by'] = $user->id;
                BarangGolongan::where('id',$barang->id)->update($data);
                DB::commit();

                return redirect('/barang-golongan')->with('info', 'Barang per Golongan berhasil di update');
                
            } catch (\Exception $e) {
                DB::rollback();
                Log::Error($e->getMessage());
                return Redirect::back()->withInput($request->input())->withErrors(['error'=> 'Update Barang per Golongan gagal, silahkan coba kembali.']);
                // something went wrong
            }
        }else{
            return Redirect::back()->withInput($request->input())->withErrors(['error'=> 'Data Barang per Golongan tidak ditemukan.']);
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
        $barang = BarangGolongan::find($id);
        if($barang ){
            BarangGolongan::where('id',$barang->id)->delete();
            return redirect('/barang-golongan')->with('info', 'Barang per Golongan berhasil di delete.');
        }else{
            return Redirect::back()->withErrors(['error'=> 'Data Barang per Golongan tidak ditemukan.']);
        }
    }

}
