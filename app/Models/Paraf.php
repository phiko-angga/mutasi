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
}
