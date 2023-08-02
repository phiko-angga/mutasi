<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dephub extends Model
{
    use HasFactory;
    
    protected $table = "tb_dephub";
    protected $fillable = [
        'provinsi_asal_id','kota_asal_id','provinsi_tujuan_id','kota_tujuan_id','jarak_km','harga_tiket','created_by','updated_by'
    ];
    
    public function get_data($request, $paginate = true){
        $data = Self::select('tb_dephub.*'
        ,'pa.nama as provinsia_nama','pt.nama as provinsit_nama'
        ,'ka.nama as kotaa_nama','kt.nama as kotat_nama'
        ,'c.fullname as created_name')->selectRaw("coalesce(u.fullname,'') as updated_name")
        ->join('tb_provinsi as pa','pa.id','=','tb_dephub.provinsi_asal_id')
        ->join('tb_provinsi as pt','pt.id','=','tb_dephub.provinsi_tujuan_id')
        ->join('tb_kota as ka','ka.id','=','tb_dephub.kota_asal_id')
        ->join('tb_kota as kt','kt.id','=','tb_dephub.kota_tujuan_id')
        ->join('tb_pengguna as c','c.id','=','tb_dephub.created_by')
        ->leftJoin('tb_pengguna as u','u.id','=','tb_dephub.updated_by');
        
        $search = $request->get('search');
        if(isset($search)){
            $data = $data->where('tb_kota.nama', 'like', '%'.$search.'%')
            ->orWhere('tb_kota.kode', 'like', '%'.$search.'%');
        }
        
        if($paginate){
            $data = $data->paginate(10);
        }else
            $data = $data->get();
        
        return $data; 
    }
    
    public function get_id($id){
        $data = Self::select('tb_dephub.*'
        ,'pa.nama as provinsia_nama','pt.nama as provinsit_nama'
        ,'ka.nama as kotaa_nama','kt.nama as kotat_nama'
        ,'c.fullname as created_name')->selectRaw("coalesce(u.fullname,'') as updated_name")
        ->join('tb_provinsi as pa','pa.id','=','tb_dephub.provinsi_asal_id')
        ->join('tb_provinsi as pt','pt.id','=','tb_dephub.provinsi_tujuan_id')
        ->join('tb_kota as ka','ka.id','=','tb_dephub.kota_asal_id')
        ->join('tb_kota as kt','kt.id','=','tb_dephub.kota_tujuan_id')
        ->join('tb_pengguna as c','c.id','=','tb_dephub.created_by')
        ->leftJoin('tb_pengguna as u','u.id','=','tb_dephub.updated_by')
        ->where('tb_dephub.id',$id)->first();
        
        return $data; 
    }
}
