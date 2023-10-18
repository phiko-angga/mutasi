<?php

namespace App\Http\Controllers;

use App\Models\Provinsi;
use App\Exports\ProvinsiExport;
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
        
        $paginate_num = $request->get('show_per_page') != null ? $request->get('show_per_page') : 10;
        $provinsi = new Provinsi();
        $data = $provinsi->get_data($request);

        $page = 'PROVINSI';
        if($request->ajax()){
            return view('provinsi.list_pagination', compact('data','paginate_num'));
        }else{
            return view('provinsi.list', compact('data','page','paginate_num'));
        }
    }
    
    public function printPdf(Request $request)
    {
        
        $title = 'DAFTAR IBUKOTA PROVINSI REPUBLIK INDONESIA';
        $provinsi = new Provinsi();
        $data = $provinsi->get_data($request);
    	$pdf = PDF::loadview('provinsi.list_pdf', compact('data','title'));
    	return $pdf->stream('DAFTAR IBUKOTA PROVINSI REPUBLIK INDONESIA.pdf');
    }

    public function printExcel(Request $request)
    {
        return \Excel::download(new provinsiExport($request), 'DAFTAR IBUKOTA PROVINSI REPUBLIK INDONESIA.xlsx');
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

    private function formatedKode($kode,$prefix,$length){
        $result = "";
        $kodeLen = strlen($kode);
        if($kodeLen < $length){
            for ($i=0; $i < ($length - $kodeLen); $i++) { 
                $result .= $prefix.$kode; 
            }
        }else{
            $result = $kode; 
        }
        return $result;
    }

    public function store(Request $request)
    {
        request()->validate([
            'nama'   => 'required|unique:tb_provinsi,nama',
            // 'kode'   => 'required|unique:tb_provinsi,kode',
        ]);

        DB::beginTransaction();
        try {
            $getLast = Provinsi::orderBy('kode','desc')->first();
            $kodeBaru = "PRV01";
            if($getLast){
                $getLastNo = $getLast->kode;
                $lastNo = (int)substr($getLastNo,3,2);
                ++$lastNo;
                $kodeBaru = 'PRV'.$this->formatedKode($lastNo, '0',2);
            }

            $data = $request->only(['nama']);
            $data['jawamadura'] = $request->has('jawamadura') ? $request->jawamadura : 0;
            $data['kode'] = $kodeBaru;
            $data['status'] = 1;
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
            'nama'   => 'required|unique:tb_provinsi,nama,'.$id,
            // 'kode'   => 'required|unique:tb_provinsi,kode,'.$id,
        ]);

        $provinsi = Provinsi::find($request->id);
        if($provinsi){

            DB::beginTransaction();
            try {
                $data = $request->only(['nama','kode']);
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
