<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiBiayaKeluarga extends Model
{
    use HasFactory;
    
    protected $table = "tb_transaksi_biaya_keluarga";
    protected $fillable = [
        'transaksi_biaya_id','biaya_perj_dinas','nama','tanggal_lahir','umur','keterangan','created_by','updated_by','created_at','updated_at'
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
            $data = $data->paginate(10);
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
