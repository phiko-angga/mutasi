<?php

namespace App\Models;

use App\Models\TransaksiBiayaKeluarga;
use App\Models\TransaksiBiayaTransport;
use App\Models\TransaksiBiayaMuat;
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

    public function keluarga(){
        return $this->hasMany(TransaksiBiayaKeluarga::class,'transaksi_biaya_id')
        ->select('tb_transaksi_biaya_keluarga.*','c.fullname as created_name')
        ->selectRaw("coalesce(u.fullname,'') as updated_name")
        ->join('tb_pengguna as c','c.id','=','tb_transaksi_biaya_keluarga.created_by')
        ->leftJoin('tb_pengguna as u','u.id','=','tb_transaksi_biaya_keluarga.updated_by');
    }

    public function transport(){
        return $this->hasMany(TransaksiBiayaTransport::class,'transaksi_biaya_id')
        ->select('tb_transaksi_biaya_transport.*','tr.nama as transport_nama','kota.nama as kotaa_nama','kott.nama as kotat_nama',
        'proa.nama as provinsia_nama','prot.nama as provinsit_nama')
        ->join('tb_transport as tr','tr.id','=','tb_transaksi_biaya_transport.transport_id')
        ->join('tb_kota as kota','kota.id','=','tb_transaksi_biaya_transport.kota_asal_id')
        ->join('tb_provinsi as proa','proa.id','=','kota.provinsi_id')
        ->join('tb_kota as kott','kott.id','=','tb_transaksi_biaya_transport.kota_tujuan_id')
        ->join('tb_provinsi as prot','prot.id','=','kott.provinsi_id')
        ->where('tb_transaksi_biaya_transport.pembantu',0);
    }

    public function transport_pembantu(){
        return $this->hasMany(TransaksiBiayaTransport::class,'transaksi_biaya_id')
        ->select('tb_transaksi_biaya_transport.*','tr.nama as transport_nama','kota.nama as kotaa_nama','kott.nama as kotat_nama',
        'proa.nama as provinsia_nama','prot.nama as provinsit_nama')
        ->join('tb_transport as tr','tr.id','=','tb_transaksi_biaya_transport.transport_id')
        ->join('tb_kota as kota','kota.id','=','tb_transaksi_biaya_transport.kota_asal_id')
        ->join('tb_provinsi as proa','proa.id','=','kota.provinsi_id')
        ->join('tb_kota as kott','kott.id','=','tb_transaksi_biaya_transport.kota_tujuan_id')
        ->join('tb_provinsi as prot','prot.id','=','kott.provinsi_id')
        ->where('tb_transaksi_biaya_transport.pembantu',1);
    }

    public function muat(){
        return $this->hasMany(TransaksiBiayaMuat::class,'transaksi_biaya_id')
        ->select('tb_transaksi_biaya_muat.*','tr.nama as transport_nama','kota.nama as kotaa_nama','kott.nama as kotat_nama',
        'proa.nama as provinsia_nama','prot.nama as provinsit_nama')
        ->join('tb_transport as tr','tr.id','=','tb_transaksi_biaya_muat.transport_id')
        ->join('tb_kota as kota','kota.id','=','tb_transaksi_biaya_muat.kota_asal_id')
        ->join('tb_provinsi as proa','proa.id','=','kota.provinsi_id')
        ->join('tb_kota as kott','kott.id','=','tb_transaksi_biaya_muat.kota_tujuan_id')
        ->join('tb_provinsi as prot','prot.id','=','kott.provinsi_id');
    }
    
    public function get_data($request, $paginate = true,$param = null){
        $data = Self::select('tb_transaksi_biaya.*','pg.pangkat','pg.golongan','c.fullname as created_name')
        ->selectRaw("coalesce(u.fullname,'') as updated_name")
        ->selectRaw("coalesce(a.fullname,'') as approved_name")
        ->join('tb_pangkat_golongan as pg','pg.id','=','tb_transaksi_biaya.pangkat_golongan_id')
        ->join('tb_pengguna as c','c.id','=','tb_transaksi_biaya.created_by')
        ->leftJoin('tb_pengguna as u','u.id','=','tb_transaksi_biaya.updated_by')
        ->leftJoin('tb_pengguna as a','a.id','=','tb_transaksi_biaya.approved_by');
        
        if($param != null){
            if(isset($param['approved'])){
                $data = $data->where('approved',$param['approved']);
            }
        }

        $search = $request->get('search');
        if(isset($search)){
            $data = $data->where(function($query) use($search){
                $query->where('tb_transaksi_biaya.nama', 'like', '%'.$search.'%')
                ->orWhere('tb_transaksi_biaya.nomor', 'like', '%'.$search.'%')
                ->orWhere('c.username', 'like', '%'.$search.'%'); 
            });
        }
        
        if($paginate){
            $data = $data->paginate(10);
        }else
            $data = $data->get();
        
        return $data; 
    }
    
    public function get_detail($id){
        $data = Self::select('tb_transaksi_biaya.*','pg.pangkat','pg.golongan','c.fullname as created_name','pk.nama as pejabat_komitmen_nama'
        ,'pk2.nama as pejabat_komitmen_nama2','pk2.nip as pejabat_komitmen_nip2','ttd.nama as bendaharawan_nama','ttd.nip as bendaharawan_nip',
        'ttd2.nama as kuasa_nama','ttd2.nip as kuasa_nip','pk3.nama as pejabat_komitmen_nama3','pk3.nip as pejabat_komitmen_nip3',
        'pk4.nama as pejabat_komitmen_nama4','pk4.nip as pejabat_komitmen_nip4',
        'tr.nama as transport_nama','tr2.nama as pengepakan_transport_nama','kota.nama as kotaa_nama','kott.nama as kotat_nama','proa.nama as provinsia_nama','prot.nama as provinsit_nama')
        ->with([
            'keluarga', 'transport', 'transport_pembantu', 'muat'
        ])
        ->selectRaw("coalesce(u.fullname,'') as updated_name")
        ->join('tb_pejabat_komitmen as pk','pk.id','=','tb_transaksi_biaya.pejabat_komitmen_id')
        ->join('tb_pejabat_komitmen as pk2','pk2.id','=','tb_transaksi_biaya.pejabat_komitmen2_id')
        ->join('tb_pejabat_komitmen as pk3','pk3.id','=','tb_transaksi_biaya.rampung_ppk_id')
        ->join('tb_pejabat_komitmen as pk4','pk4.id','=','tb_transaksi_biaya.rampung_anggaran_id')
        ->join('tb_transport as tr','tr.id','=','tb_transaksi_biaya.transport_id')
        ->join('tb_transport as tr2','tr2.id','=','tb_transaksi_biaya.pengepakan_transport_id')
        ->join('tb_kota as kota','kota.id','=','tb_transaksi_biaya.kota_asal_id')
        ->join('tb_provinsi as proa','proa.id','=','kota.provinsi_id')
        ->join('tb_kota as kott','kott.id','=','tb_transaksi_biaya.kota_tujuan_id')
        ->join('tb_provinsi as prot','prot.id','=','kott.provinsi_id')
        ->join('tb_pangkat_golongan as pg','pg.id','=','tb_transaksi_biaya.pangkat_golongan_id')
        ->join('tb_tandatangan as ttd','ttd.id','=','tb_transaksi_biaya.rampung_bendaharawan_id')
        ->join('tb_tandatangan as ttd2','ttd2.id','=','tb_transaksi_biaya.rampung_kuasa_nama')
        ->join('tb_pengguna as c','c.id','=','tb_transaksi_biaya.created_by')
        ->where('tb_transaksi_biaya.id',$id)
        ->leftJoin('tb_pengguna as u','u.id','=','tb_transaksi_biaya.updated_by')->first();
        
        return $data; 
    }
}
