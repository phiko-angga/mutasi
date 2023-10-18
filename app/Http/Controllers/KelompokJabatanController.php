<?php

namespace App\Http\Controllers;

use App\Models\KelompokJabatan;
use App\Exports\KelompokJabatanExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Redirect;
use Log;
use PDF;

class KelompokJabatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        $paginate_num = $request->get('show_per_page') != null ? $request->get('show_per_page') : 10;
        $pejabat = new KelompokJabatan();
        $data = $pejabat->get_data($request);

        $page = 'Kelompok (Jenis) Jabatan';
        if($request->ajax()){
            return view('kelompok_jabatan.list_pagination', compact('data','paginate_num'));
        }else{
            return view('kelompok_jabatan.list', compact('data','page','paginate_num'));
        }
    }
    
    public function printPdf(Request $request)
    {
        $title = 'KELOMPOK (JENIS) JABATAN';
        $pejabat = new KelompokJabatan();
        $data = $pejabat->get_data($request);
    	$pdf = PDF::loadview('kelompok_jabatan.list_pdf', compact('data','title'));
    	return $pdf->stream('KELOMPOK (JENIS) JABATAN.pdf');
    }

    public function printExcel(Request $request)
    {
        return \Excel::download(new KelompokJabatanExport($request), 'KELOMPOK (JENIS) JABATAN.xlsx');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $action = 'store';
        $page = 'Kelompok (Jenis) Jabatan';
        $title = 'Tambah baru';
        return view('kelompok_jabatan.form',compact('action','title','page'));
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
            'kelompok'   => 'required',
        ]);

        DB::beginTransaction();
        try {
            $data = $request->except(['_token']);
            
            $user = auth()->user();
            $data['created_by'] = $user->id;
            $data['updated_by'] = $user->id;
            $pejabat = KelompokJabatan::create($data);

            DB::commit();

            return redirect('/kelompok_jabatan')->with('info', 'Kelompok (Jenis) Jabatan berhasil ditambahkan');
            
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            return Redirect::back()->withInput($request->input())->withErrors(['error'=> 'Tambah Kelompok (Jenis) Jabatan gagal, silahkan coba kembali.']);
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

        $mpejabat = new KelompokJabatan();
        $kelompok_jabatan = $mpejabat->get_id($id);

        $action = 'update';
        $title = 'Kelompok (Jenis) Jabatan Update';
        $page = 'Kelompok (Jenis) Jabatan';
        return view('kelompok_jabatan.form',compact('kelompok_jabatan','action','title','page'));
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
            'kelompok'   => 'required',
        ]);

        $pejabat = KelompokJabatan::find($request->id);
        if($pejabat){

            DB::beginTransaction();
            try {
                $data = $request->except(['_token','_method']);
                
                $user = auth()->user();
                $data['updated_by'] = $user->id;
                KelompokJabatan::where('id',$pejabat->id)->update($data);
                DB::commit();

                return redirect('/kelompok_jabatan')->with('info', 'Kelompok (Jenis) Jabatan berhasil di update');
                
            } catch (\Exception $e) {
                DB::rollback();
                Log::Error($e->getMessage());
                return Redirect::back()->withInput($request->input())->withErrors(['error'=> 'Update Kelompok (Jenis) Jabatan gagal, silahkan coba kembali.']);
                // something went wrong
            }
        }else{
            return Redirect::back()->withInput($request->input())->withErrors(['error'=> 'Data Kelompok (Jenis) Jabatan tidak ditemukan.']);
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
        $pejabat = KelompokJabatan::find($id);
        if($pejabat ){
            KelompokJabatan::where('id',$pejabat->id)->delete();
            return redirect('/kelompok_jabatan')->with('info', 'Kelompok (Jenis) Jabatan berhasil di delete.');
        }else{
            return Redirect::back()->withErrors(['error'=> 'Data Kelompok (Jenis) Jabatan tidak ditemukan.']);
        }
    }

}
