<?php

namespace App\Http\Controllers;

use App\Models\Uangh;
use App\Models\Provinsi;
use App\Models\Kota;
use App\Exports\UanghExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Redirect;
use Log;
use PDF;

class UanghController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        $uangh = new Uangh();
        $data = $uangh->get_data($request);

        $page = 'Uang Harian';
        if($request->ajax()){
            return view('uangh.list_pagination', compact('data'));
        }else{
            return view('uangh.list', compact('data','page'));
        }
    }
    
    public function printPdf(Request $request)
    {
        
        $title = 'SATUAN BIAYA UANG HARIAN PERJALANAN DINAS DALAM NEGERI (Dalam Rupiah)';
        $uangh = new Uangh();
        $data = $uangh->get_data($request);
    	$pdf = PDF::loadview('uangh.list_pdf', compact('data','title'));
    	return $pdf->stream('SATUAN BIAYA UANG HARIAN PERJALANAN DINAS DALAM NEGERI.pdf');
    }

    public function printExcel(Request $request)
    {
        return \Excel::download(new uanghExport($request), 'SATUAN BIAYA UANG HARIAN PERJALANAN DINAS DALAM NEGERI.xlsx');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $action = 'store';
        $page = 'Uang Harian';
        $title = 'Tambah baru';
        $provinsi = Provinsi::all();
        return view('uangh.form',compact('action','title','page','provinsi'));
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
            'satuan'   => 'required',
            'luar_kota'   => 'required',
            'dalam_kota'   => 'required',
            'diklat'   => 'required',
        ]);

        DB::beginTransaction();
        try {
            $data = $request->except(['_token']);
            
            $user = auth()->user();
            $data['created_by'] = $user->id;
            $data['updated_by'] = $user->id;
            $uangh = Uangh::create($data);

            DB::commit();

            return redirect('/uangh')->with('info', 'Uangh berhasil ditambahkan');
            
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            return Redirect::back()->withInput($request->input())->withErrors(['error'=> 'Tambah Uangh gagal, silahkan coba kembali.']);
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

        $muangh = new Uangh();
        $uangh = $muangh->get_id($id);

        $action = 'update';
        $title = 'Uang Harian Update';
        $page = 'Uang Harian';
        $provinsi = Provinsi::all();
        return view('uangh.form',compact('uangh','action','title','page','provinsi'));
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
            'provinsi_id'   => 'required',
            'satuan'   => 'required',
            'luar_kota'   => 'required',
            'dalam_kota'   => 'required',
            'diklat'   => 'required',
        ]);

        $uangh = Uangh::find($request->id);
        if($uangh){

            DB::beginTransaction();
            try {
                $data = $request->except(['_token','_method']);
                
                $user = auth()->user();
                $data['updated_by'] = $user->id;
                Uangh::where('id',$uangh->id)->update($data);
                DB::commit();

                return redirect('/uangh')->with('info', 'Uangh berhasil di update');
                
            } catch (\Exception $e) {
                DB::rollback();
                Log::Error($e->getMessage());
                return Redirect::back()->withInput($request->input())->withErrors(['error'=> 'Update Uangh gagal, silahkan coba kembali.']);
                // something went wrong
            }
        }else{
            return Redirect::back()->withInput($request->input())->withErrors(['error'=> 'Data Uangh tidak ditemukan.']);
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
        $uangh = Uangh::find($id);
        if($uangh ){
            Uangh::where('id',$uangh->id)->delete();
            return redirect('/uangh')->with('info', 'Uang Harian berhasil di delete.');
        }else{
            return Redirect::back()->withErrors(['error'=> 'Data Uang Harian tidak ditemukan.']);
        }
    }

}
