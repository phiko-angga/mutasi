<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Uangh extends Model
{
    use HasFactory;
    
    protected $table = "tb_uangh";
    protected $fillable = [
        'provinsi_id','satuan','luar_kota','dalam_kota','diklat','tanggal','created_by','updated_by'
    ];
    
    public function get_data($request, $paginate = true){
        $data = Self::select('tb_uangh.*','p.nama as provinsi_nama','c.fullname as created_name')
        ->selectRaw("coalesce(u.fullname,'') as updated_name")
        ->join('tb_provinsi as p','p.id','=','tb_uangh.provinsi_id')
        ->join('tb_pengguna as c','c.id','=','tb_uangh.created_by')
        ->leftJoin('tb_pengguna as u','u.id','=','tb_uangh.updated_by');
        
        $search = $request->get('search');
        if(isset($search)){
            $data = $data->where('satuan', 'ilike', '%'.$search.'%')
            ->orWhere('p.nama', 'ilike', '%'.$search.'%')
            ->orWhere('luar_kota', 'ilike', '%'.$search.'%')
            ->orWhere('dalam_kota', 'ilike', '%'.$search.'%')
            ->orWhere('diklat', 'ilike', '%'.$search.'%')
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
        $data = Self::select('tb_uangh.*','p.nama as provinsi_nama','c.fullname as created_name')->selectRaw("coalesce(u.fullname,'') as updated_name")
        ->join('tb_provinsi as p','p.id','=','tb_uangh.provinsi_id')
        ->join('tb_pengguna as c','c.id','=','tb_uangh.created_by')
        ->leftJoin('tb_pengguna as u','u.id','=','tb_uangh.updated_by')
        ->where('tb_uangh.id',$id)->first();
        
        return $data; 
    }
}
