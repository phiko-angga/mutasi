<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PejabatKomitmen extends Model
{
    use HasFactory;
    
    protected $table = "tb_pejabat_komitmen";
    protected $fillable = [
        'nama','nip','created_by','updated_by'
    ];
    
    public function get_data($request, $paginate = true){
        $data = Self::select('tb_pejabat_komitmen.*','c.fullname as created_name')->selectRaw("coalesce(u.fullname,'') as updated_name")
        ->join('tb_pengguna as c','c.id','=','tb_pejabat_komitmen.created_by')
        ->leftJoin('tb_pengguna as u','u.id','=','tb_pejabat_komitmen.updated_by');
        
        $search = $request->get('search');
        if(isset($search)){
            $data = $data->where('nama', 'ilike', '%'.$search.'%')
            ->orWhere('nip', 'ilike', '%'.$search.'%')
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
        $data = Self::select('tb_pejabat_komitmen.*','c.fullname as created_name')->selectRaw("coalesce(u.fullname,'') as updated_name")
        ->join('tb_pengguna as c','c.id','=','tb_pejabat_komitmen.created_by')
        ->leftJoin('tb_pengguna as u','u.id','=','tb_pejabat_komitmen.updated_by')
        ->where('tb_pejabat_komitmen.id',$id)->first();
        
        return $data; 
    }
}
