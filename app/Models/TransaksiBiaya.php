<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiBiaya extends Model
{
    use HasFactory;
    
    protected $table = "tb_transaksi_biaya";
    protected $fillable = [
        'tanggal','tanggal_berangkat','tanggal_kembali','nomor','pegawai_diperintah','jabatan_instansi','nip','pejabat_komitmen_id','pejabat_komitmen2_id'
        ,'pangkat_golongan_id','kelompok_jabatan_id','tingkat_perj_dinas','transport_id','kota_asal_id','ket_keberangkatan','lama_perj_dinas',
        'kota_tujuan_id','ket_tujuan','status_perkawinan','maksud_perj_dinas','jumlah_pengikut','pembantu_ikut','pembebanan_anggaran','mata_anggaran'
        ,'ket_lain2','pengepakan_berat','pengepakan_transport_id','pengepakan_tarif','pengepakan_biaya','uangh_jml_orang','uangh_jml_hari','uangh_jml_tarif'
        ,'uangh_jml_biaya','uangh_jml_pembantu','uangh_jml_hari_p','uangh_jml_tarif_p','uangh_jml_biaya_p','uangh_jml_uang','uangh_jml_terbilang'
        ,'rampung_jumlah','rampung_dibayar','rampung_sisa','rampung_beban_mak','rampung_buktikas','rampung_tgl_pelunasan','rampung_thn_anggaran'
        ,'rampung_bendaharawan_id','rampung_kuasa_nama','rampung_ppk_id','rampung_anggaran_id','rampung_rincian','created_by','updated_by'
    ];
    
    public function get_data($request, $paginate = true){
        $data = Self::select('tb_transaksi_biaya.*','pg.pangkat','pg.golongan'
        ,'c.fullname as created_name')
        ->selectRaw("coalesce(u.fullname,'') as updated_name")
        ->join('tb_pangkat_golongan as pg','pg.id','=','tb_transaksi_biaya.pangkat_golongan_id')
        ->join('tb_pengguna as c','c.id','=','tb_transaksi_biaya.created_by')
        ->leftJoin('tb_pengguna as u','u.id','=','tb_transaksi_biaya.updated_by');
        
        $search = $request->get('search');
        if(isset($search)){
            $data = $data->where('tb_transaksi_biaya.nama', 'like', '%'.$search.'%')
            ->orWhere('tb_transaksi_biaya.nomor', 'like', '%'.$search.'%')
            ->orWhere('c.username', 'like', '%'.$search.'%');
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
