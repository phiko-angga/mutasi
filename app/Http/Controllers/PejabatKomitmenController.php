<?php

namespace App\Http\Controllers;

use App\Models\PejabatKomitmen;
use App\Exports\PejabatKomitmenExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Redirect;
use Log;
use PDF;

class PejabatKomitmenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        $pejabat = new PejabatKomitmen();
        $data = $pejabat->get_data($request);

        $page = 'Pejabat Pembuat Komitmen';
        if($request->ajax()){
            return view('pejabat_komitmen.list_pagination', compact('data'));
        }else{
            return view('pejabat_komitmen.list', compact('data','page'));
        }
    }
    
    public function printPdf(Request $request)
    {
        $title = 'PEJABAT PEMBUAT KOMITMEN';
        $pejabat = new PejabatKomitmen();
        $data = $pejabat->get_data($request);
    	$pdf = PDF::loadview('pejabat_komitmen.list_pdf', compact('data','title'));
    	return $pdf->stream('PEJABAT PEMBUAT KOMITMEN.pdf');
    }

    public function printExcel(Request $request)
    {
        return \Excel::download(new PejabatKomitmenExport($request), 'PEJABAT PEMBUAT KOMITMEN.xlsx');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $action = 'store';
        $page = 'Pejabat Pembuat Komitmen';
        $title = 'Tambah baru';
        return view('pejabat_komitmen.form',compact('action','title','page'));
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
            'nip'   => 'required',
        ]);

        DB::beginTransaction();
        try {
            $data = $request->except(['_token']);
            
            $user = auth()->user();
            $data['created_by'] = $user->id;
            $data['updated_by'] = $user->id;
            $pejabat = PejabatKomitmen::create($data);

            DB::commit();

            return redirect('/pejabat_komitmen')->with('info', 'Pejabat Pembuat Komitmen berhasil ditambahkan');
            
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            return Redirect::back()->withInput($request->input())->withErrors(['error'=> 'Tambah Pejabat Pembuat Komitmen gagal, silahkan coba kembali.']);
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

        $mpejabat = new PejabatKomitmen();
        $pejabat_komitmen = $mpejabat->get_id($id);

        $action = 'update';
        $title = 'Pejabat Pembuat Komitmen Update';
        $page = 'Pejabat Pembuat Komitmen';
        return view('pejabat_komitmen.form',compact('pejabat_komitmen','action','title','page'));
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
            'nip'   => 'required',
        ]);

        $pejabat = PejabatKomitmen::find($request->id);
        if($pejabat){

            DB::beginTransaction();
            try {
                $data = $request->except(['_token','_method']);
                
                $user = auth()->user();
                $data['updated_by'] = $user->id;
                PejabatKomitmen::where('id',$pejabat->id)->update($data);
                DB::commit();

                return redirect('/pejabat_komitmen')->with('info', 'Pejabat Pembuat Komitmen berhasil di update');
                
            } catch (\Exception $e) {
                DB::rollback();
                Log::Error($e->getMessage());
                return Redirect::back()->withInput($request->input())->withErrors(['error'=> 'Update Pejabat Pembuat Komitmen gagal, silahkan coba kembali.']);
                // something went wrong
            }
        }else{
            return Redirect::back()->withInput($request->input())->withErrors(['error'=> 'Data Pejabat Pembuat Komitmen tidak ditemukan.']);
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
        $pejabat = PejabatKomitmen::find($id);
        if($pejabat ){
            PejabatKomitmen::where('id',$pejabat->id)->delete();
            return redirect('/pejabat_komitmen')->with('info', 'Pejabat Pembuat Komitmen berhasil di delete.');
        }else{
            return Redirect::back()->withErrors(['error'=> 'Data Pejabat Pembuat Komitmen tidak ditemukan.']);
        }
    }

}
