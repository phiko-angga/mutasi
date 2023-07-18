<?php
 
namespace App\Http\Controllers;

use App\Models\Provinsi;
use App\Models\Kota;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;
 
class AuthController extends Controller
{
    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

     public function login(){
        return view('login');
     }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);
 
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            if(auth()->user()->provinsi_id){
                Session::put('provinsi_id',auth()->user()->provinsi_id);
                $provinsi = Provinsi::find(auth()->user()->provinsi_id);
                Session::put('provinsi_name',$provinsi->provinsi);
            }
            if(auth()->user()->kota_id){
                Session::put('kota_id',auth()->user()->kota_id);
                $kota = Kota::find(auth()->user()->kota_id);
                Session::put('kota_name',$kota->kota);
            }
            if(auth()->user()->kecamatan_id){
                Session::put('kecamatan_id',auth()->user()->kecamatan_id);
                $kecamatan = Kecamatan::find(auth()->user()->kecamatan_id);
                Session::put('kecamatan_name',$kecamatan->kecamatan);
            }
            if(auth()->user()->kelurahan_id){
                Session::put('kelurahan_id',auth()->user()->kelurahan_id);
                $kelurahan = Kelurahan::find(auth()->user()->kelurahan_id);
                Session::put('kelurahan_name',$kelurahan->kelurahan);
            }

            if(is_null(auth()->user()->provinsi_id) && is_null(auth()->user()->kota_id) && is_null(auth()->user()->kecamatan_id) && is_null(auth()->user()->kelurahan_id)){
                Session::put('user_type','admin');
            }else{
                Session::put('user_type','koordinator');
            }
 
            return redirect()->intended('');
        }
 
        return back()->withErrors([
            'name' => 'The provided credentials do not match our records.',
        ]);
    }
    
    public function logout()
    {
        Session::flush();
        Auth::logout();
        return Redirect::to('/login');
    }
}