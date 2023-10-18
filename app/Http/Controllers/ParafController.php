<?php

namespace App\Http\Controllers;

use App\Models\Paraf;
use App\Models\Provinsi;
use App\Models\Kota;
use App\Exports\ParafExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Redirect;
use Log;
use PDF;

class ParafController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        $paginate_num = $request->get('show_per_page') != null ? $request->get('show_per_page') : 10;
        $paraf = new Paraf();
        $data = $paraf->get_data($request);

        $page = 'Paraf';
        if($request->ajax()){
            return view('paraf.list_pagination', compact('data','paginate_num'));
        }else{
            return view('paraf.list', compact('data','page','paginate_num'));
        }
    }
    
    public function printPdf(Request $request)
    {
        $title = 'DAFTAR NAMA PEJABAT PENANDATANGANAN';
        $paraf = new Paraf();
        $data = $paraf->get_data($request);
    	$pdf = PDF::loadview('paraf.list_pdf', compact('data','title'));
    	return $pdf->stream('DAFTAR NAMA PEJABAT PENANDATANGANAN.pdf');
    }

    public function printExcel(Request $request)
    {
        return \Excel::download(new parafExport($request), 'DAFTAR NAMA PEJABAT PENANDATANGANAN.xlsx');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        $mParaf = new Paraf;
        $kepangkatan = $mParaf->kepangkatan();
        $ttd = $mParaf->ttd();

        $action = 'store';
        $page = 'Paraf';
        $title = 'Tambah baru';
        return view('paraf.form',compact('action','title','page','kepangkatan','ttd'));
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
            'kelompok'   => 'required',
            'nourut'   => 'required',
            'nama'   => 'required',
            'nip'   => 'required',
            'pangkat'   => 'required',
            'jabatan'   => 'required',
        ]);

        DB::beginTransaction();
        try {
            $data = $request->except(['_token']);
            
            $user = auth()->user();
            $data['created_by'] = $user->id;
            $data['updated_by'] = $user->id;
            $paraf = Paraf::create($data);

            DB::commit();

            return redirect('/paraf')->with('info', 'Paraf berhasil ditambahkan');
            
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            return Redirect::back()->withInput($request->input())->withErrors(['error'=> 'Tambah Paraf gagal, silahkan coba kembali.']);
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

        $mparaf = new Paraf();
        $paraf = $mparaf->get_id($id);
        $kepangkatan = $mparaf->kepangkatan();
        $ttd = $mparaf->ttd();

        $action = 'update';
        $title = 'Paraf Update';
        $page = 'Paraf';
        return view('paraf.form',compact('paraf','action','title','page','kepangkatan','ttd'));
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
            'kelompok'   => 'required',
            'nourut'   => 'required',
            'nama'   => 'required',
            'nip'   => 'required',
            'pangkat'   => 'required',
            'jabatan'   => 'required',
        ]);

        $paraf = Paraf::find($request->id);
        if($paraf){

            DB::beginTransaction();
            try {
                $data = $request->except(['_token','_method']);
                
                $user = auth()->user();
                $data['updated_by'] = $user->id;
                Paraf::where('id',$paraf->id)->update($data);
                DB::commit();

                return redirect('/paraf')->with('info', 'Paraf berhasil di update');
                
            } catch (\Exception $e) {
                DB::rollback();
                Log::Error($e->getMessage());
                return Redirect::back()->withInput($request->input())->withErrors(['error'=> 'Update Paraf gagal, silahkan coba kembali.']);
                // something went wrong
            }
        }else{
            return Redirect::back()->withInput($request->input())->withErrors(['error'=> 'Data Paraf tidak ditemukan.']);
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
        $paraf = Paraf::find($id);
        if($paraf ){
            Paraf::where('id',$paraf->id)->delete();
            return redirect('/paraf')->with('info', 'Paraf berhasil di delete.');
        }else{
            return Redirect::back()->withErrors(['error'=> 'Data Paraf tidak ditemukan.']);
        }
    }

}
