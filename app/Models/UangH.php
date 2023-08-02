<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provinsi extends Model
{
    use HasFactory;
    
    protected $table = "tb_uangh";
    protected $fillable = [
        'provinsi_id','satuan','luar_kota','dalam_kota','diklat','tanggal','created_by','updated_by'
    ];
}
