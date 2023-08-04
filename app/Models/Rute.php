<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rute extends Model
{
    use HasFactory;
    
    protected $table = "tb_rute";
    protected $fillable = [
        'kode','kota_id','bus','kapal','plane','created_by','updated_by'
    ];
    
    public function get_data($request, $paginate = true){
        $data = Self::select('tb_rute.*','ka.nama as kota_nama'
        ,'c.fullname as created_name')->selectRaw("coalesce(u.fullname,'') as updated_name")
        ->join('tb_kota as ka','ka.id','=','tb_rute.kota_id')
        ->join('tb_pengguna as c','c.id','=','tb_rute.created_by')
        ->leftJoin('tb_pengguna as u','u.id','=','tb_rute.updated_by');
        
        // $search = $request->get('search');
        // if(isset($search)){
        //     $data = $data->where('tb_rute.nama', 'like', '%'.$search.'%')
        //     ->orWhere('tb_rute.kode', 'like', '%'.$search.'%');
        // }
        
        if($paginate){
            $data = $data->paginate(10);
        }else
            $data = $data->get();
        
        return $data; 
    }
    
    public function get_id($id){
        $data = Self::select('tb_rute.*','ka.nama as kota_nama'
        ,'c.fullname as created_name')->selectRaw("coalesce(u.fullname,'') as updated_name")
        ->join('tb_kota as ka','ka.id','=','tb_rute.kota_id')
        ->join('tb_pengguna as c','c.id','=','tb_rute.created_by')
        ->leftJoin('tb_pengguna as u','u.id','=','tb_rute.updated_by')
        ->where('tb_rute.id',$id)->first();
        
        return $data; 
    }
}
