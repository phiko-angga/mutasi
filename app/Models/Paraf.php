<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paraf extends Model
{
    use HasFactory;
    
    protected $table = "tb_tandatangan";
    protected $fillable = [
        'kelompok','nourut','nama','nip','pangkat','jabatan','created_by','updated_by'
    ];
    
    public function get_data($request, $paginate = true){
        $data = Self::select('tb_tandatangan.*','c.fullname as created_name')->selectRaw("coalesce(u.fullname,'') as updated_name")
        ->join('tb_pengguna as c','c.id','=','tb_tandatangan.created_by')
        ->leftJoin('tb_pengguna as u','u.id','=','tb_tandatangan.updated_by');
        
        $search = $request->get('search');
        if(isset($search)){
            $data = $data->where('tb_tandatangan.nama', 'ilike', '%'.$search.'%')
            ->orWhere('tb_tandatangan.nip', 'ilike', '%'.$search.'%')
            ->orWhere('tb_tandatangan.pangkat', 'ilike', '%'.$search.'%')
            ->orWhere('tb_tandatangan.jabatan', 'ilike', '%'.$search.'%')
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
        $data = Self::select('tb_tandatangan.*','c.fullname as created_name')->selectRaw("coalesce(u.fullname,'') as updated_name")
        ->join('tb_pengguna as c','c.id','=','tb_tandatangan.created_by')
        ->leftJoin('tb_pengguna as u','u.id','=','tb_tandatangan.updated_by')
        ->where('tb_tandatangan.id',$id)->first();
        
        return $data; 
    }

    public function kepangkatan(){ 
        return [
            'Juru Muda',
            'Juru Muda Tk. I',
            'Juru',
            'Juru Tk. I',
            'Pengatur Muda',
            'Pengatur Muda Tk. I',
            'Pengatur',
            'Pengatur Tk. I',
            'Penata Muda',
            'Penata Muda Tk. I',
            'Penata',
            'Penata Tk. I ',
            'Pembina',
            'Pembina Tk. I',
            'Pembina Utama Muda',
            'Pembina Utama Madya',
            'Pembina Utama',
        ];
    }

    public function ttd(){ 
        return [
            'Pejabat Pembuat Komitmen',
            'Bendaharawan',
            'Kuasa Pengguna Anggaran',
            'Yang Menerima/Dikuasakan',
        ];
    }
}
