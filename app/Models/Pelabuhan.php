<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelabuhan extends Model
{
    use HasFactory;
    
    protected $table = "tb_pelabuhan";
    protected $fillable = [
        'nama','provinsi_id','alamat','created_by','updated_by'
    ];
    
    public function get_data($request, $paginate = true){
        $data = Self::select('tb_pelabuhan.*','p.nama as provinsi_nama','c.fullname as created_name')->selectRaw("coalesce(u.fullname,'') as updated_name")
        ->join('tb_provinsi as p','p.id','=','tb_pelabuhan.provinsi_id')
        ->join('tb_pengguna as c','c.id','=','tb_pelabuhan.created_by')
        ->leftJoin('tb_pengguna as u','u.id','=','tb_pelabuhan.updated_by');
        
        $search = $request->get('search');
        if(isset($search)){
            $data = $data->where('nama', 'ilike', '%'.$search.'%');
        }
        
        if($paginate){
            $data = $data->paginate(10);
        }else
            $data = $data->get();
        
        return $data; 
    }
    
    public function get_id($id){
        $data = Self::select('tb_pelabuhan.*','p.nama as provinsi_nama','c.fullname as created_name')->selectRaw("coalesce(u.fullname,'') as updated_name")
        ->join('tb_provinsi as p','p.id','=','tb_pelabuhan.provinsi_id')
        ->join('tb_pengguna as c','c.id','=','tb_pelabuhan.created_by')
        ->leftJoin('tb_pengguna as u','u.id','=','tb_pelabuhan.updated_by')
        ->where('tb_pelabuhan.id',$id)->first();
        
        return $data; 
    }
}
