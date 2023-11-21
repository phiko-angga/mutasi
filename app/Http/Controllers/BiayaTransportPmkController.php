<?php

namespace App\Http\Controllers;

use App\Models\BiayaTransportPmk;
use App\Exports\biayaTransportExport;
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
        $biaya = new BiayaTransport();
        $data = $biaya->get_data($request);
    	$pdf = PDF::loadview('biaya_transport_pmk.list_pdf', compact('data','title'));
    	return $pdf->stream('BIAYA TRANSPORT PMK.pdf');
    }

    public function printExcel(Request $request)
    {
        return \Excel::download(new biayaTransportExport($request), 'BIAYA TRANSPORT PMK.xlsx');
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
        return view('biaya_transport_pmk.form',compact('action','title','page'));
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
            'kota_id'   => 'required',
            'biaya_transport'   => 'required',
        ]);

        DB::beginTransaction();
        try {
            $data = $request->only(['provinsi_id','kota_id','biaya_transport']);
            
            $user = auth()->user();
            $data['biaya_darat'] = str_replace(",","",$data['biaya_darat']);
            $data['biaya_laut'] = str_replace(",","",$data['biaya_laut']);
            $data['created_by'] = $user->id;
            $data['updated_by'] = $user->id;
            $biaya = BiayaTransport::create($data);

            DB::commit();

            return redirect('/biaya-transport')->with('info', 'Biaya Transport berhasil ditambahkan');
            
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            return Redirect::back()->withInput($request->input())->withErrors(['error'=> 'Tambah Biaya Transport gagal, silahkan coba kembali.']);
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

        $mdarat = new BiayaTransport();
        $biaya = $mdarat->get_id($id);

        $action = 'update';
        $title = 'Biaya Transport Update';
        $page = 'Biaya Transport';
        return view('biaya_transport.form',compact('biaya','action','title'));
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
            'biaya_darat'   => 'required',
            'biaya_laut'   => 'required',
        ]);

        $biaya = BiayaTransport::find($request->id);
        if($biaya){

            DB::beginTransaction();
            try {
                $data = $request->only(['biaya_darat','biaya_laut']);
                
                $user = auth()->user();
                $data['biaya_darat'] = str_replace(",","",$data['biaya_darat']);
                $data['biaya_laut'] = str_replace(",","",$data['biaya_laut']);
                $data['updated_by'] = $user->id;
                BiayaTransport::where('id',$biaya->id)->update($data);
                DB::commit();

                return redirect('/biaya-transport')->with('info', 'Biaya Transport berhasil di update');
                
            } catch (\Exception $e) {
                DB::rollback();
                Log::Error($e->getMessage());
                return Redirect::back()->withInput($request->input())->withErrors(['error'=> 'Update Biaya Transport gagal, silahkan coba kembali.']);
                // something went wrong
            }
        }else{
            return Redirect::back()->withInput($request->input())->withErrors(['error'=> 'Data Biaya Transport tidak ditemukan.']);
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
        $biaya = BiayaTransport::find($id);
        if($biaya ){
            BiayaTransport::where('id',$biaya->id)->delete();
            return redirect('/biaya-transport')->with('info', 'Biaya Transport berhasil di delete.');
        }else{
            return Redirect::back()->withErrors(['error'=> 'Data Biaya Transport tidak ditemukan.']);
        }
    }

}
