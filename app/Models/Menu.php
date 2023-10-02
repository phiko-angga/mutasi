<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;
    
    protected $table = "tb_menu";
    protected $fillable = [
        'menu','link','urutan','parent','grup','grup_urutan'
    ];
    
    function get_grup(){
        $data = Self::select('grup','grup_urutan')->distinct()->orderBy('grup_urutan')->get();
        return $data;
    }
    
    function get_pergrup($grup){
        $data = Self::where('grup',$grup)->orderBy('urutan')->get();
        return $data;
    }

    function get_menugrup_akses($user){
        $data = Self::select('grup','grup_urutan')->distinct()->join('tb_menu_user as mu','mu.menu_id','=','tb_menu.id')
        ->where('mu.pengguna_id',$user)->orderBy('grup_urutan')->get();
        return $data;
    }

    function get_menu_akses($user){
        $data = Self::join('tb_menu_user as mu','mu.menu_id','=','tb_menu.id')->where('mu.pengguna_id',$user)
        ->orderBy('urutan')->get();
        return $data;
    }

    function get_menu_akses2($user){
        $data = Self::select('tb_menu.*')
        ->selectRaw("coalesce(mu.id,0) as curmenu")
        ->leftJoin('tb_menu_user as mu', function($join) use($user)
        {
            $join->on('tb_menu.id', '=', 'mu.menu_id');
            $join->where('mu.pengguna_id',$user);
        })
        ->orderBy('urutan')->get();
        return $data;
    }
}
