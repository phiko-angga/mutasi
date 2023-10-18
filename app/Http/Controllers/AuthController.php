<?php
 
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Log;
 
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
            // 'g-recaptcha-response' => 'required|captcha',
            'username' => ['required'],
            'password' => ['required','min:8','regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%]).*$/'],
        ]);
 
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            // dd($credentials);
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
    
    public function resetPassword(){
        $users = auth()->user();
        return view('users.form_reset',compact('users'));
    }

    public function resetPasswordAct(Request $request){
        
        request()->validate([
            'id'        => 'required',
            'cur_password'  => 'required',
            'password'  => ['required','min:8','regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%]).*$/'],
        ]);

        $id = $request->id;
        $users = User::find($id);
        if($users){
            // $cur_password = Hash::make($request->cur_password);
            // Log::debug($request->cur_password.' - '.$cur_password.' - '.$users->password);
            if(Hash::check($request->cur_password, $users->password)){
                $users->password = Hash::make($request->password);
                $users->save();
                return redirect('/')->with('info', 'User password berhasil diubah');
            }else{
                return Redirect::back()->withInput($request->input())->withErrors(['error'=> 'Current Password tidak cocok.']);
            }
        }
    }
}