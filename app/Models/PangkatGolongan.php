<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PangkatGolongan extends Model
{
    use HasFactory;
    
    protected $table = "tb_pangkat_golongan";
    protected $fillable = [
        'pangkat','golongan','urutan'
    ];
    
    public function get_data($request, $paginate = true){
        $data = Self::select('tb_tandatangan.*','c.fullname as created_name')->selectRaw("coalesce(u.fullname,'') as updated_name")
        ->join('tb_pengguna as c','c.id','=','tb_tandatangan.created_by')
        ->leftJoin('tb_pengguna as u','u.id','=','tb_tandatangan.updated_by');
        
        // $search = $request->get('search');
        // if(isset($search)){
        //     $data = $data->where('nama', 'like', '%'.$search.'%');
        // }
        
        if($paginate){
            $paginate_num = $request->get('show_per_page') != null ? $request->get('show_per_page') : 10;
            $data = $data->paginate($paginate_num);
        }else
            $data = $data->get();
        
        return $data; 
    }
    
    public function get_id($id){
        $data = Self::select('tb_tandatangan.*','c.fullname as created_name')->selectRaw("coalesce(u.fullname,'') as updated_name")
        ->join('tb_pengguna as c','c.id','=','tb_tandatangan.created_by')
        ->leftJoin('tb_pengguna as u','u.id','=','tb_tandatangan.updated_by')
        ->where('tb_tandatangan.id',$id)->first();
        
        return $data; 
    }
}
