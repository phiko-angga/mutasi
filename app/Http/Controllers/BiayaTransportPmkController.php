<?php

namespace App\Http\Controllers;

use App\Models\Provinsi;
use App\Models\BiayaTransportPmk;
use App\Exports\biayaTransportPmkExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Redirect;
use Log;
use PDF;

class BiayaTransportPmkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        $biaya = new BiayaTransportPmk();
        $data = $biaya->get_data($request);
        $paginate_num = $request->get('show_per_page') != null ? $request->get('show_per_page') : 10;

        $page = 'Biaya Transport PMK';
        if($request->ajax()){
            return view('biaya_transport_pmk.list_pagination', compact('data','paginate_num'));
        }else{
            return view('biaya_transport_pmk.list', compact('data','page','paginate_num'));
        }
    }
    
    public function printPdf(Request $request)
    {
        
        $title = 'BIAYA TRANSPORT PMK';
        $biaya = new BiayaTransportPmk();
        $data = $biaya->get_data($request);
    	$pdf = PDF::loadview('biaya_transport_pmk.list_pdf', compact('data','title'));
    	return $pdf->stream('BIAYA TRANSPORT PMK.pdf');
    }

    public function printExcel(Request $request)
    {
        return \Excel::download(new biayaTransportPmkExport($request), 'BIAYA TRANSPORT PMK.xlsx');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $action = 'store';
        $page = 'Biaya Transport PMK';
        $title = 'Tambah baru';
        $provinsi = Provinsi::all();
        return view('biaya_transport_pmk.form',compact('action','title','page','provinsi'));
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
            'biaya_transport'   => 'required',
        ]);

        DB::beginTransaction();
        try {
            $data = $request->only(['provinsi_asal_id','provinsi_tujuan_id','kota_asal_id','kota_tujuan_id','biaya_transport']);
            
            $user = auth()->user();
            $data['biaya_transport'] = str_replace(",","",$data['biaya_transport']);
            $data['created_by'] = $user->id;
            $data['updated_by'] = $user->id;
            $biaya = BiayaTransportPmk::create($data);

            DB::commit();

            return redirect('/biaya-transport-pmk')->with('info', 'Biaya Transport PMK berhasil ditambahkan');
            
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            return Redirect::back()->withInput($request->input())->withErrors(['error'=> 'Tambah Biaya Transport PMK gagal, silahkan coba kembali.']);
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

        $biaya = new BiayaTransportPmk();
        $biayatranspmk = $biaya->get_id($id);

        $action = 'update';
        $title = 'Biaya Transport PMK Update';
        $page = 'Biaya Transport PMK';
        $provinsi = Provinsi::all();
        return view('biaya_transport_pmk.form',compact('biayatranspmk','action','title','provinsi'));
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
            'biaya_transport'   => 'required',
        ]);

        $biaya = BiayaTransportPmk::find($request->id);
        if($biaya){

            DB::beginTransaction();
            try {
                $data = $request->only(['provinsi_asal_id','provinsi_tujuan_id','kota_asal_id','kota_tujuan_id','biaya_transport']);
                
                $user = auth()->user();
                $data['biaya_transport'] = str_replace(",","",$data['biaya_transport']);
                $data['updated_by'] = $user->id;
                BiayaTransportPmk::where('id',$biaya->id)->update($data);
                DB::commit();

                return redirect('/biaya-transport-pmk')->with('info', 'Biaya Transport PMK berhasil di update');
                
            } catch (\Exception $e) {
                DB::rollback();
                Log::Error($e->getMessage());
                return Redirect::back()->withInput($request->input())->withErrors(['error'=> 'Update Biaya Transport PMK gagal, silahkan coba kembali.']);
                // something went wrong
            }
        }else{
            return Redirect::back()->withInput($request->input())->withErrors(['error'=> 'Data Biaya Transport PMK tidak ditemukan.']);
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
        $biaya = BiayaTransportPmk::find($id);
        if($biaya ){
            BiayaTransportPmk::where('id',$biaya->id)->delete();
            return redirect('/biaya-transport-pmk')->with('info', 'Biaya Transport PMK berhasil di delete.');
        }else{
            return Redirect::back()->withErrors(['error'=> 'Data Biaya PMK Transport tidak ditemukan.']);
        }
    }

}
