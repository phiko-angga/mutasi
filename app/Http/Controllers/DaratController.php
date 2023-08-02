<?php

namespace App\Http\Controllers;

use App\Models\Darat;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Redirect;
use Log;

class DaratController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

    }
    
    public function printPdf(Request $request)
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $action = 'store';
        $title = 'User Baru';
        return view('users.form',compact('action','title'));
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
            'name'   => 'required',
            'username'   => 'required',
            'password'   => 'required|min:8',
        ]);

        DB::beginTransaction();
        try {
            $data = $request->only(['name','username','provinsi_id','kota_id','kecamatan_id','kelurahan_id']);
            // dd($data);
            $data['password'] = Hash::make($request->password);
            
            if(!isset($data['provinsi_id']) || (isset($data['provinsi_id']) && $data['provinsi_id'] == '%')) $data['provinsi_id'] = null;
            if(!isset($data['kota_id']) || (isset($data['kota_id']) && $data['kota_id'] == '%')) $data['kota_id'] = null;
            if(!isset($data['kecamatan_id']) || (isset($data['kecamatan_id']) && $data['kecamatan_id'] == '%')) $data['kecamatan_id'] = null;
            if(!isset($data['kelurahan_id']) || (isset($data['kelurahan_id']) && $data['kelurahan_id'] == '%')) $data['kelurahan_id'] = null;
            
            $user = User::create($data);

            DB::commit();

            return redirect('/users')->with('info', 'User berhasil ditambahkan');
            
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            return Redirect::back()->withInput($request->input())->withErrors(['error'=> 'Tambah User gagal, silahkan coba kembali.']);
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
        $users = User::select('users.*')->where('users.id',$id)
        ->selectRaw('ifnull(kel.kelurahan,"All") as kelurahan')
        ->selectRaw('ifnull(kec.kecamatan,"All") as kecamatan')
        ->selectRaw('ifnull(kot.kota,"All") as kota')
        ->selectRaw('ifnull(pro.provinsi,"All") as provinsi')
        ->leftJoin('wkelurahan as kel','kel.id','=','users.kelurahan_id')
        ->leftJoin('wkecamatan as kec','kec.id','=','users.kecamatan_id')
        ->leftJoin('wkota as kot','kot.id','=','users.kota_id')
        ->leftJoin('wprovinsi as pro','pro.id','=','users.provinsi_id')->first();

        $action = 'update';
        $title = 'User Update';
        return view('users.form',compact('users','action','title'));
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
            'name'   => 'required',
            'username'   => 'required',
        ]);

        $user = User::find($request->id);
        if($user){

            DB::beginTransaction();
            try {
                $data = $request->only(['name','username','provinsi_id','kota_id','kecamatan_id','kelurahan_id']);
                if(isset($request->password)){
                    $data['password'] = Hash::make($request->password);
                }

                if(!isset($data['provinsi_id']) || (isset($data['provinsi_id']) && $data['provinsi_id'] == '%')) $data['provinsi_id'] = null;
                if(!isset($data['kota_id']) || (isset($data['kota_id']) && $data['kota_id'] == '%')) $data['kota_id'] = null;
                if(!isset($data['kecamatan_id']) || (isset($data['kecamatan_id']) && $data['kecamatan_id'] == '%')) $data['kecamatan_id'] = null;
                if(!isset($data['kelurahan_id']) || (isset($data['kelurahan_id']) && $data['kelurahan_id'] == '%')) $data['kelurahan_id'] = null;

                User::where('id',$user->id)->update($data);
                DB::commit();

                return redirect('/users')->with('info', 'User berhasil di update');
                
            } catch (\Exception $e) {
                DB::rollback();
                Log::Error($e->getMessage());
                return Redirect::back()->withInput($request->input())->withErrors(['error'=> 'Update User gagal, silahkan coba kembali.']);
                // something went wrong
            }
        }else{
            return Redirect::back()->withInput($request->input())->withErrors(['error'=> 'Data User tidak ditemukan.']);
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
        $user = User::find($id);
        if($user ){
            User::where('id',$user->id)->delete();
            return redirect('/users')->with('info', 'User berhasil di delete.');
        }else{
            return Redirect::back()->withErrors(['error'=> 'Data User tidak ditemukan.']);
        }
    }

}
