<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Darat extends Model
{
    use HasFactory;
    
    protected $table = "tb_darat";
    protected $fillable = [
        'provinsi_id','nama','kode','status','jawamadura','created_by','updated_by'
    ];
}
