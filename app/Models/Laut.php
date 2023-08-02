<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laut extends Model
{
    use HasFactory;
    
    protected $table = "tb_laut";
    protected $fillable = [
        'provinsi_id','pelabuhan_asal_id','provinsi_tujuan_id','pelabuhan_tujuan_id','jarak_mil','created_by','updated_by'
    ];
}
