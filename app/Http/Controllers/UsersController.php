<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Exports\UserExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use PDF;
use Redirect;
use Log;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $mUser = new User();
        $users = $mUser->get_data($request);

        if($request->ajax()){
            return view('users.list_pagination', compact('users'));
        }else{
            return view('users.list', compact('users'));
        }
    }
        
    public function printPdf(Request $request)
    {
        
        $title = 'DAFTAR USER';
        $user = new User();
        $users = $user->get_data($request);
    	$pdf = PDF::loadview('users.list_pdf', compact('users','title'));
    	return $pdf->stream('DAFTAR-users.pdf');
    }

    public function printExcel(Request $request)
    {
        return \Excel::download(new userExport($request), 'MASTER USER.xlsx');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $action = 'store';
        $page = 'User';
        $title = 'Tambah baru';
        return view('users.form',compact('action','title','page'));
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
            'username'   => 'required|unique:tb_pengguna,username',
            'fullname'   => 'required',
            'password'   => ['required','min:8','regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%]).*$/'],
        ]);

        DB::beginTransaction();
        try {
            $data = $request->except(['_token']);
            
            $user = auth()->user();
            $data['created_by'] = $user->id;
            $data['updated_by'] = $user->id;
            $data['password'] = Hash::make($request->password);
            $user = User::create($data);

            DB::commit();

            return redirect('/user')->with('info', 'User berhasil ditambahkan');
            
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

        $muser = new User();
        $users = $muser->get_id($id);

        $action = 'update';
        $title = 'User Update';
        $page = 'User';
        return view('users.form',compact('users','action','title','page'));
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
            'username'   => 'required|unique:tb_pengguna,username,'.$id,
            'fullname'   => 'required',
            'password'   => ['nullable','min:8','regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%]).*$/'],
        ]);

        $user = User::find($request->id);
        if($user){

            DB::beginTransaction();
            try {
                $data = $request->except(['_token','_method','password','id']);
                if(isset($request->password)){
                    $data['password'] = Hash::make($request->password);
                }
                
                $user = auth()->user();
                $data['updated_by'] = $user->id;
                User::where('id',$user->id)->update($data);
                DB::commit();

                return redirect('/user')->with('info', 'User berhasil di update');
                
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
            return redirect('/user')->with('info', 'User berhasil di delete.');
        }else{
            return Redirect::back()->withErrors(['error'=> 'Data User tidak ditemukan.']);
        }
    }


}
