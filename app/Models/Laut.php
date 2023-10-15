<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laut extends Model
{
    use HasFactory;
    
    protected $table = "tb_laut";
    protected $fillable = [
        'provinsi_asal_id','kota_asal_id','pelabuhan_asal','provinsi_tujuan_id','kota_tujuan_id','pelabuhan_tujuan','jarak_mil','created_by','updated_by','nama_table'
    ];
    
    public function get_data($request, $paginate = true){
        $data = Self::select('tb_laut.*'
        ,'pa.nama as provinsia_nama','pt.nama as provinsit_nama'
        ,'ka.nama as kotaa_nama','kt.nama as kotat_nama'
        ,'c.fullname as created_name')->selectRaw("coalesce(u.fullname,'') as updated_name")
        ->join('tb_provinsi as pa','pa.id','=','tb_laut.provinsi_asal_id')
        ->join('tb_provinsi as pt','pt.id','=','tb_laut.provinsi_tujuan_id')
        ->join('tb_kota as ka','ka.id','=','tb_laut.kota_asal_id')
        ->join('tb_kota as kt','kt.id','=','tb_laut.kota_tujuan_id')
        ->join('tb_pengguna as c','c.id','=','tb_laut.created_by')
        ->leftJoin('tb_pengguna as u','u.id','=','tb_laut.updated_by');
        
        $search = $request->get('search');
        if(isset($search)){
            $data = $data->where('tb_laut.nama_table', 'ilike', '%'.$search.'%')
            ->orWhere('pa.nama', 'ilike', '%'.$search.'%')
            ->orWhere('pt.nama', 'ilike', '%'.$search.'%')
            ->orWhere('ka.nama', 'ilike', '%'.$search.'%')
            ->orWhere('kt.nama', 'ilike', '%'.$search.'%')
            ->orWhere('jarak_mil', 'ilike', '%'.$search.'%')
            ->orWhere('c.username', 'ilike', '%'.$search.'%');
        }
        
        if($paginate){
            $data = $data->paginate(10);
        }else
            $data = $data->get();
        
        return $data; 
    }
    
    public function get_id($id){
        $data = Self::select('tb_laut.*'
        ,'pa.nama as provinsia_nama','pt.nama as provinsit_nama'
        ,'ka.nama as kotaa_nama','kt.nama as kotat_nama'
        ,'c.fullname as created_name')->selectRaw("coalesce(u.fullname,'') as updated_name")
        ->join('tb_provinsi as pa','pa.id','=','tb_laut.provinsi_asal_id')
        ->join('tb_provinsi as pt','pt.id','=','tb_laut.provinsi_tujuan_id')
        ->join('tb_kota as ka','ka.id','=','tb_laut.kota_asal_id')
        ->join('tb_kota as kt','kt.id','=','tb_laut.kota_tujuan_id')
        ->join('tb_pengguna as c','c.id','=','tb_laut.created_by')
        ->leftJoin('tb_pengguna as u','u.id','=','tb_laut.updated_by')
        ->where('tb_laut.id',$id)->first();
        
        return $data; 
    }
}
