<?php

namespace App\Http\Controllers;

use App\Models\Transport;
use App\Exports\TransportExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Redirect;
use Log;
use PDF;

class TransportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        $paginate_num = $request->get('show_per_page') != null ? $request->get('show_per_page') : 10;
        $transport = new Transport();
        $data = $transport->get_data($request);

        $page = 'TRANSPORT';
        if($request->ajax()){
            return view('transport.list_pagination', compact('data','paginate_num'));
        }else{
            return view('transport.list', compact('data','page','paginate_num'));
        }
    }
    
    public function printPdf(Request $request)
    {
        
        $title = 'DAFTAR JENIS TANSPORTASI';
        $transport = new Transport();
        $data = $transport->get_data($request);
        // return view('transport.list_pdf', compact('data','title'));
    	$pdf = PDF::loadview('transport.list_pdf', compact('data','title'));
    	return $pdf->stream('DAFTAR-TANSPORT.pdf');
    }

    public function printExcel(Request $request)
    {
        return \Excel::download(new transportExport($request), 'MASTER TRANSPORT.xlsx');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $action = 'store';
        $page = 'TRANSPORT';
        $title = 'Tambah baru';
        return view('transport.form',compact('action','title','page'));
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
            'alias'   => 'required',
        ]);

        DB::beginTransaction();
        try {
            $data = $request->only(['nama','kode','alias','status']);

            $transport = auth()->user();
            $data['created_by'] = $transport->id;
            $data['updated_by'] = $transport->id;
            $transport = Transport::create($data);

            DB::commit();

            return redirect('/transport')->with('info', 'Transport berhasil ditambahkan');
            
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            return Redirect::back()->withInput($request->input())->withErrors(['error'=> 'Tambah Transport gagal, silahkan coba kembali.']);
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

        $mtransport = new Transport();
        $transport = $mtransport->get_id($id);

        $action = 'update';
        $title = 'Transport Update';
        $page = 'TRANSPORT';
        return view('transport.form',compact('transport','action','title','page'));
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
            'alias'   => 'required',
        ]);

        $transport = Transport::find($request->id);
        if($transport){

            DB::beginTransaction();
            try {
                $data = $request->only(['nama','kode','alias','status']);
                Transport::where('id',$transport->id)->update($data);
                DB::commit();

                return redirect('/transport')->with('info', 'Transport berhasil di update');
                
            } catch (\Exception $e) {
                DB::rollback();
                Log::Error($e->getMessage());
                return Redirect::back()->withInput($request->input())->withErrors(['error'=> 'Update Transport gagal, silahkan coba kembali.']);
                // something went wrong
            }
        }else{
            return Redirect::back()->withInput($request->input())->withErrors(['error'=> 'Data Transport tidak ditemukan.']);
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
        $transport = Transport::find($id);
        if($transport ){
            Transport::where('id',$transport->id)->delete();
            return redirect('/transport')->with('info', 'Transport berhasil di delete.');
        }else{
            return Redirect::back()->withErrors(['error'=> 'Data Transport tidak ditemukan.']);
        }
    }

}
