<?php

namespace App\Http\Controllers;

use App\Models\BiayaMuat;
use App\Models\BiayaPengepakan;
use App\Models\BarangGolongan;
use App\Models\PangkatGolongan;
use App\Models\BiayaTransport;
use App\Models\Sbum;
use App\Models\Dephub;
use App\Models\Paraf;
use App\Models\PejabatKomitmen;
use App\Models\Provinsi;
use App\Models\Darat;
use App\Models\Laut;
use App\Models\Kota;
use App\Models\UangH;
use App\Models\Transport;
use App\Exports\SbumExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use DateTime;
use Redirect;
use Log;
use PDF;

class GetSelectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    

     public function getTransport(Request $request){
        $exclude = $request->exclude;
        $onlydarat = $request->onlydarat != null ? $request->onlydarat : 0;
        $excludelaut = $request->excludelaut != null ? $request->excludelaut : 0;
        $search = $request->q;
        $limit = $request->page_limit;
        $page = $request->page;

        $trans = Transport::select('id','nama','kode');
        
        if($exclude != null){
            $trans = $trans->where('id','<>',$exclude);
        }

        if($search != null){
            $trans = $trans->where(function($query) use ($search){
                $query->where('nama','ilike','%'.$search.'%');
            });
        }

        $trans = $trans->skip($page)->take($limit)->get();
        $data = ["total_count"   => 0];
        
        if($trans){
            foreach($trans as $key => $p){
                $data['items'][$key] = [
                    'id' => $p->id,
                    'text' => $p->kode,
                    'data' => $p
                ];
                
                if($onlydarat == 1 && $p->kode != 'DARAT' ){
                    $data['items'][$key]['disabled'] = true;
                }

                if($excludelaut == 1 && $p->kode == 'LAUT' ){
                    $data['items'][$key]['disabled'] = true;
                }
            }
            $data['total_count'] = $trans->count();
        }
        return response()->json($data, 200);
    }

     public function getProvinsi(Request $request){
        $exclude = $request->exclude;
        $search = $request->q;
        $limit = $request->page_limit;
        $page = $request->page;

        $provinsi = Provinsi::select('id','nama','kode');
        
        if($exclude != null){
            $provinsi = $provinsi->where('id','<>',$exclude);
        }

        if($search != null){
            $provinsi = $provinsi->where(function($query) use ($search){
                $query->where('nama','ilike','%'.$search.'%');
            });
        }

        $provinsi = $provinsi->skip($page)->take($limit)->get();
        $data = ["total_count"   => 0];
        
        $data['items'][] = [
            'id' => '%',
            'text' => 'ALL'
        ];

        if($provinsi){
            foreach($provinsi as $p){
                $data['items'][] = [
                    'id' => $p->id,
                    'text' => $p->nama
                ];
            }
            $data['total_count'] = $provinsi->count();
        }
        return response()->json($data, 200);
    }
    
    public function getKota(Request $request){
        $exclude = $request->exclude;
        $provinsi = $request->provinsi;
        $search = $request->q;
        $limit = $request->page_limit;
        $page = $request->page;

        $kota = Kota::select('tb_kota.id','tb_kota.nama','pr.nama as provinsi')
        ->join('tb_provinsi as pr','pr.id','=','tb_kota.provinsi_id');
        
        if($provinsi != null)
            $kota = $kota->where('provinsi_id',$provinsi);
        
        if($exclude != null){
            $kota = $kota->where('tb_kota.id','<>',$exclude);
        }

        if($search != null){
            $kota = $kota->where(function($query) use ($search){
                $query->where('tb_kota.nama','ilike','%'.$search.'%')
                ->orWhere('tb_kota.kode','ilike','%'.$search.'%');
            });
        }
        $kota = $kota->skip($page)->take($limit)->get();
        $data = ["total_count"   => 0];
        
        if($kota){
            foreach($kota as $p){
                $data['items'][] = [
                    'id' => $p->id,
                    'text' => $p->nama."#Provinsi ".$p->provinsi,
                    'data' => $p
                ];
            }
            $data['total_count'] = $kota->count();
        }
        return response()->json($data, 200);
    }
    
    public function getParaf(Request $request){
        $kelompok = $request->kelompok;
        $search = $request->q;
        $limit = $request->page_limit;
        $page = $request->page;

        $paraf = Paraf::select('id','nama','nip')->where('kelompok','ilike',$kelompok);
        
        if($search != null){
            $paraf = $paraf->where(function($query) use ($search){
                $query->where('nama','ilike','%'.$search.'%');
            });
        }
        $paraf = $paraf->skip($page)->take($limit)->get();
        $data = ["total_count"   => 0];
        
        if($paraf){
            foreach($paraf as $p){
                $data['items'][] = [
                    'id' => $p->id,
                    'text' => $p->nama,
                    'data' => $p
                ];
            }
            $data['total_count'] = $paraf->count();
        }
        return response()->json($data, 200);
    }
    
    public function getPpk(Request $request){
        $search = $request->q;
        $limit = $request->page_limit;
        $page = $request->page;

        $ppk = PejabatKomitmen::select('id','nama','nip');
        
        if($search != null){
            $ppk = $ppk->where(function($query) use ($search){
                $query->where('nama','ilike','%'.$search.'%');
            });
        }
        $ppk = $ppk->skip($page)->take($limit)->get();
        $data = ["total_count"   => 0];
        
        if($ppk){
            foreach($ppk as $p){
                $data['items'][] = [
                    'id' => $p->id,
                    'text' => $p->nama,
                    'data' => $p
                ];
            }
            $data['total_count'] = $ppk->count();
        }
        return response()->json($data, 200);
    }
    
    public function getJarak(Request $request){
        $kotaAsal = $request->kota_asal;
        $kotaTujuan = $request->kota_tujuan;
        $inTransport = $request->transport;
        $transport = Transport::find($inTransport);
        $jarak_km = 0;

        $metode = "";
        if($transport->kode == 'DARAT'){
            $metode = "Reg Darat";
            $union = Darat::select('jarak_km')->where('kota_asal_id',$kotaTujuan)->where('kota_tujuan_id',$kotaAsal);
            $jarak = Darat::select('jarak_km')->where('kota_asal_id',$kotaAsal)->where('kota_tujuan_id',$kotaTujuan)
            ->unionAll($union)->first();
            if($jarak){
                $jarak_km = $jarak->jarak_km;
            }
        }

        return response()->json(['jarak_km' => $jarak_km,'metode' => $metode], 200);
    }

    
    public function biayaPerOrang(Request $request){
        $kotaAsal = $request->kota_asal;
        $kotaTujuan = $request->kota_tujuan;
        
        $dephub = Dephub::select('harga_tiket')->where('kota_asal_id',$kotaAsal)->where('kota_tujuan_id',$kotaTujuan);
        $biaya = Sbum::select('harga_tiket')->where('kota_asal_id',$kotaAsal)->where('kota_tujuan_id',$kotaTujuan)
        ->union($dephub)->first();
        if(!$biaya){
            $biaya = ['harga_tiket' => 0];
        }

        return response()->json($biaya, 200);
    }

    public function biayaDarat(Request $request){
        $kotaAsal = $request->kota_asal;
        $kotaTujuan = $request->kota_tujuan;
        
        $union = Darat::select('jarak_km')->where('kota_asal_id',$kotaTujuan)->where('kota_tujuan_id',$kotaAsal);
        $data = Darat::select('jarak_km')->where('kota_asal_id',$kotaAsal)->where('kota_tujuan_id',$kotaTujuan)
        ->unionAll($union)
        ->first();
        $biaya = 0;
        if($data){
            $biaya_darat = BiayaTransport::select('biaya_darat')->first();
            $biaya = $biaya_darat->biaya_darat * $data->jarak_km;
        }

        return response()->json(["biaya" => $biaya,"metode" => "Reg Darat"], 200);
    }

    public function biayaUdara(Request $request){
        $kotaAsal = $request->kota_asal;
        $kotaTujuan = $request->kota_tujuan;
        
        $sbum2 = Sbum::select('harga_tiket')->selectRaw("'Reg SBU/M' as metode")->selectRaw("'2' as prioritas")->where('kota_asal_id',$kotaTujuan)->where('kota_tujuan_id',$kotaAsal);
        $dephub = Dephub::select('harga_tiket')->selectRaw("'Reg DepHub' as metode")->selectRaw("'3' as prioritas")->where('kota_asal_id',$kotaAsal)->where('kota_tujuan_id',$kotaTujuan);
        $dephub2 = Dephub::select('harga_tiket')->selectRaw("'Reg DepHub' as metode")->selectRaw("'4' as prioritas")->where('kota_asal_id',$kotaTujuan)->where('kota_tujuan_id',$kotaAsal);
        $data = Sbum::select('harga_tiket')->selectRaw("'Reg SBU/M' as metode")->selectRaw("'1' as prioritas")->where('kota_asal_id',$kotaAsal)->where('kota_tujuan_id',$kotaTujuan)
        ->unionAll($sbum2)
        ->unionAll($dephub)
        ->unionAll($dephub2)
        ->orderBy("prioritas","ASC")->first();

        $biaya = 0;
        $metode = "";
        if($data){
            $biaya = $data->harga_tiket;
            $metode = $data->metode;
        }

        return response()->json(["biaya" => $biaya,"metode" => $metode], 200);
    }

    public function biayaLaut(Request $request){
        return response()->json(["biaya" => 0,"metode" => ""], 200);
    }
    
    public function getPengepakanBerat(Request $request){
        $golongan = $request->golongan;
        $status_kawin = $request->status_kawin;
        $berat_max = 0;

        $pangkatGolongan = PangkatGolongan::find($golongan);
        if($pangkatGolongan){
            $golongan = $pangkatGolongan->golongan;
            $golongan = substr($golongan,0,strpos($golongan,"/"));
            Log::debug('golongan '.$golongan);

            $barangGolongan = BarangGolongan::where('golongan',$golongan)->first();
            if($barangGolongan){
                $berat_max = $barangGolongan->$status_kawin;
            }
        }
        return response()->json(['berat_max' => $berat_max], 200);
    }
    
    public function getPengepakanTarif(Request $request){
        $transport = $request->transport;
        $tarif = 0;

        $transport = Transport::find($transport);
        $biaya = BiayaPengepakan::first();
        if($biaya){
            $field = 'transport_'.(strtolower($transport->kode));
            $tarif = $biaya->$field;
        }
        return response()->json(['tarif' => $tarif], 200);
    }
    
    public function getMuatTarif(Request $request){
        $transport = $request->transport;
        $tarif = 0;

        $transport = Transport::find($transport);
        $biaya = BiayaMuat::first();
        // Log::debug('biaya '.json_encode($biaya));
        // Log::debug('transport '.json_encode($transport));
        if($biaya){
            $field = 'biaya_'.(strtolower($transport->kode));
            $tarif = $biaya->$field;
        }
        return response()->json(['tarif' => $tarif], 200);
    }
    
    public function getUangH(Request $request){
        
        $kotaAsal = $request->kota_asal;
        $kotaTujuan = $request->kota_tujuan;

        $uangh = 0;
        // Log::debug($kotaAsal.' - '.$kotaTujuan);
        $kotaa = Kota::find($kotaAsal);
        $kotat = Kota::find($kotaTujuan);
        $uangH = UangH::where('provinsi_id',$kotat->provinsi_id)->first();
        if($uangH){
            if($kotaa->provinsi_id == $kotat->provinsi_id){
                $uangh = $uangH->dalam_kota;
            }else{
                $uangh = $uangH->luar_kota;
            }
        }
        return response()->json(['uangh' => $uangh], 200);
    }

    public function getUmur(Request $request){
        
        $dob = $request->dob;

        $bday = new DateTime($dob); // Your date of birth
        $today = new Datetime(date('Y-m-d'));
        $diff = $today->diff($bday);
        // Log::debug(' Your age : %d years, %d month, %d days '. $diff->y.' - '. $diff->m.' - '. $diff->d);

        return response()->json([
            'tahun' => $diff->y,
            'bulan' => $diff->m,
            'hari' => $diff->d,
        ], 200);
    }
}
