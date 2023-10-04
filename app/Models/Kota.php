<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kota extends Model
{
    use HasFactory;
    
    protected $table = "tb_kota";
    protected $fillable = [
        'provinsi_id','nama','kode','status','jawamadura','created_by','updated_by',
        'kantor',
        'ibukota_prov',
        'bandara',
        'pelabuhan',
        'stasiun',
        'terminal',
        'alamat',
        'kodepos',
        'telepon',
    ];
    
    public function get_data($request, $paginate = true){
        $data = Self::select('tb_kota.*','p.nama as provinsi_nama','c.fullname as created_name')
        ->selectRaw("coalesce(u.fullname,'') as updated_name")
        ->join('tb_provinsi as p','p.id','=','tb_kota.provinsi_id')
        ->join('tb_pengguna as c','c.id','=','tb_kota.created_by')
        ->leftJoin('tb_pengguna as u','u.id','=','tb_kota.updated_by');
        
        $search = $request->get('search');
        if(isset($search)){
            $data = $data->where('tb_kota.nama', 'like', '%'.$search.'%')
            ->orWhere('tb_kota.kode', 'like', '%'.$search.'%')
            ->orWhere('p.nama', 'like', '%'.$search.'%')
            ->orWhere('alamat', 'like', '%'.$search.'%')
            ->orWhere('kodepos', 'like', '%'.$search.'%')
            ->orWhere('telepon', 'like', '%'.$search.'%')
            ->orWhere('c.username', 'like', '%'.$search.'%');
        }
        
        if($paginate){
            $data = $data->paginate(10);
        }else
            $data = $data->get();
        
        return $data; 
    }
    
    public function get_id($id){
        $data = Self::select('tb_kota.*','p.nama as provinsi_nama','c.fullname as created_name')->selectRaw("coalesce(u.fullname,'') as updated_name")
        ->join('tb_provinsi as p','p.id','=','tb_kota.provinsi_id')
        ->join('tb_pengguna as c','c.id','=','tb_kota.created_by')
        ->leftJoin('tb_pengguna as u','u.id','=','tb_kota.updated_by')
        ->where('tb_kota.id',$id)->first();
        
        return $data; 
    }
}
