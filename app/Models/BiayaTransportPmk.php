<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BiayaTransportPmk extends Model
{
    use HasFactory;
    
    protected $table = "tb_biaya_transport";
    protected $fillable = [
        'provinsi_id','kota_id','biaya_transport','created_by','updated_by'
    ];
    
    public function get_data($request, $paginate = true){
        $data = Self::select('tb_sbum.*'
        ,'pa.nama as provinsia_nama','pt.nama as provinsit_nama'
        ,'ka.nama as kotaa_nama','kt.nama as kotat_nama'
        ,'c.fullname as created_name')->selectRaw("coalesce(u.fullname,'') as updated_name")
        ->join('tb_provinsi as pa','pa.id','=','tb_sbum.provinsi_asal_id')
        ->join('tb_provinsi as pt','pt.id','=','tb_sbum.provinsi_tujuan_id')
        ->join('tb_kota as ka','ka.id','=','tb_sbum.kota_asal_id')
        ->join('tb_kota as kt','kt.id','=','tb_sbum.kota_tujuan_id')
        ->join('tb_pengguna as c','c.id','=','tb_sbum.created_by')
        ->leftJoin('tb_pengguna as u','u.id','=','tb_sbum.updated_by');
        
        $search = $request->get('search');
        if(isset($search)){
            $data = $data->where('tb_sbum.harga_tiket', 'ilike', '%'.$search.'%')
            ->orWhere('pa.nama', 'ilike', '%'.$search.'%')
            ->orWhere('pt.nama', 'ilike', '%'.$search.'%')
            ->orWhere('ka.nama', 'ilike', '%'.$search.'%')
            ->orWhere('kt.nama', 'ilike', '%'.$search.'%')
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
        $data = Self::select('tb_sbum.*'
        ,'pa.nama as provinsia_nama','pt.nama as provinsit_nama'
        ,'ka.nama as kotaa_nama','kt.nama as kotat_nama'
        ,'c.fullname as created_name')->selectRaw("coalesce(u.fullname,'') as updated_name")
        ->join('tb_provinsi as pa','pa.id','=','tb_sbum.provinsi_asal_id')
        ->join('tb_provinsi as pt','pt.id','=','tb_sbum.provinsi_tujuan_id')
        ->join('tb_kota as ka','ka.id','=','tb_sbum.kota_asal_id')
        ->join('tb_kota as kt','kt.id','=','tb_sbum.kota_tujuan_id')
        ->join('tb_pengguna as c','c.id','=','tb_sbum.created_by')
        ->leftJoin('tb_pengguna as u','u.id','=','tb_sbum.updated_by')
        ->where('tb_sbum.id',$id)->first();
        
        return $data; 
    }
}
