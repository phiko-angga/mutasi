<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangGolongan extends Model
{
    use HasFactory;
    
    protected $table = "tb_barang_golongan";
    protected $fillable = [
        'golongan','bujangan','keluarga','anak1','anak2','anak3','created_by','updated_by'
    ];
    
    public function get_data($request, $paginate = true){
        $data = Self::select('tb_barang_golongan.*','c.fullname as created_name')->selectRaw("coalesce(u.fullname,'') as updated_name")
        ->join('tb_pengguna as c','c.id','=','tb_barang_golongan.created_by')
        ->leftJoin('tb_pengguna as u','u.id','=','tb_barang_golongan.updated_by');
        
        $search = $request->get('search');
        if(isset($search)){
            $data = $data->where('golongan', 'like', '%'.$search.'%')
            ->orWhere('bujangan', 'like', '%'.$search.'%')
            ->orWhere('keluarga', 'like', '%'.$search.'%')
            ->orWhere('anak1', 'like', '%'.$search.'%')
            ->orWhere('anak2', 'like', '%'.$search.'%')
            ->orWhere('anak3', 'like', '%'.$search.'%')
            ->orWhere('c.username', 'like', '%'.$search.'%');
        }
        
        if($paginate){
            $data = $data->paginate(10);
        }else
            $data = $data->get();
        
        return $data; 
    }
    
    public function get_id($id){
        $data = Self::select('tb_barang_golongan.*','c.fullname as created_name')->selectRaw("coalesce(u.fullname,'') as updated_name")
        ->join('tb_pengguna as c','c.id','=','tb_barang_golongan.created_by')
        ->leftJoin('tb_pengguna as u','u.id','=','tb_barang_golongan.updated_by')
        ->where('tb_barang_golongan.id',$id)->first();
        
        return $data; 
    }
}
