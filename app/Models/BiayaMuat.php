<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BiayaMuat extends Model
{
    use HasFactory;
    
    protected $table = "tb_biaya_muatbarang";
    protected $fillable = [
        'biaya_darat','biaya_laut','jawamadura','created_by','updated_by'
    ];
    
    public function get_data($request, $paginate = true){
        $data = Self::select('tb_biaya_muatbarang.*'
        ,'c.fullname as created_name')
        ->selectRaw("coalesce(u.fullname,'') as updated_name")
        ->join('tb_pengguna as c','c.id','=','tb_biaya_muatbarang.created_by')
        ->leftJoin('tb_pengguna as u','u.id','=','tb_biaya_muatbarang.updated_by');
        
        $search = $request->get('search');
        if(isset($search)){
            $data = $data->where('biaya_darat', 'ilike', '%'.$search.'%')
            ->orWhere('biaya_laut', 'ilike', '%'.$search.'%')
            ->orWhere('c.username', 'ilike', '%'.$search.'%');
        }
        
        if($paginate){
            $paginate_num = $request->get('show_per_page') != null ? $request->get('show_per_page') : 10;
            $data = $data->paginate($paginate_num);
        }else
            $data = $data->get();
        
        return $data; 
    }
    
    public function get_id($id){
        $data = Self::select('tb_biaya_muatbarang.*','c.fullname as created_name')
        ->selectRaw("coalesce(u.fullname,'') as updated_name")
        ->join('tb_pengguna as c','c.id','=','tb_biaya_muatbarang.created_by')
        ->leftJoin('tb_pengguna as u','u.id','=','tb_biaya_muatbarang.updated_by')
        ->where('tb_biaya_muatbarang.id',$id)->first();
        
        return $data; 
    }
}
