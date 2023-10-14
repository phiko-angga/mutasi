<?php

namespace App\Http\Controllers;

use App\Models\Sbum;
use App\Models\Dephub;
use App\Models\Paraf;
use App\Models\PejabatKomitmen;
use App\Models\Provinsi;
use App\Models\Darat;
use App\Models\Laut;
use App\Models\Kota;
use App\Models\Transport;
use App\Exports\SbumExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
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
        $search = $request->q;
        $limit = $request->page_limit;
        $page = $request->page;

        $trans = Transport::select('id','nama','kode');
        
        if($exclude != null){
            $trans = $trans->where('id','<>',$exclude);
        }

        if($search != null){
            $trans = $trans->where(function($query) use ($search){
                $query->where('nama','like','%'.$search.'%');
            });
        }

        $trans = $trans->skip($page)->take($limit)->get();
        $data = ["total_count"   => 0];
        
        if($trans){
            foreach($trans as $p){
                $data['items'][] = [
                    'id' => $p->id,
                    'text' => $p->nama,
                ];
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
                $query->where('nama','like','%'.$search.'%');
            });
        }

        $provinsi = $provinsi->skip($page)->take($limit)->get();
        $data = ["total_count"   => 0];
        
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

        $kota = Kota::select('tb_kota.id','tb_kota.nama','pr.nama as provinsi')->join('tb_provinsi as pr','pr.id','=','tb_kota.provinsi_id');
        
        if($provinsi != null)
            $kota = $kota->where('provinsi_id',$provinsi);
        
        if($exclude != null){
            $kota = $kota->where('id','<>',$exclude);
        }

        if($search != null){
            $kota = $kota->where(function($query) use ($search){
                $query->where('nama','like','%'.$search.'%')
                ->orWhere('kode','like','%'.$search.'%');
            });
        }
        $kota = $kota->skip($page)->take($limit)->get();
        $data = ["total_count"   => 0];
        
        if($kota){
            foreach($kota as $p){
                $data['items'][] = [
                    'id' => $p->id,
                    'text' => $p->nama,
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

        $paraf = Paraf::select('id','nama','nip')->where('kelompok',$kelompok);
        
        if($search != null){
            $paraf = $paraf->where(function($query) use ($search){
                $query->where('nama','like','%'.$search.'%');
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
                $query->where('nama','like','%'.$search.'%');
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
        
        $darat = Darat::select('jarak_km')->where('kota_asal_id',$kotaAsal)->where('kota_tujuan_id',$kotaTujuan);
        $jarak = Laut::select('jarak_mil as jarak_km')->where('kota_asal_id',$kotaAsal)->where('kota_tujuan_id',$kotaTujuan)
        ->union($darat)->toSql();
        // Log::debug('jarak '.$jarak);
        $jarak = Laut::select('jarak_mil as jarak_km')->where('kota_asal_id',$kotaAsal)->where('kota_tujuan_id',$kotaTujuan)
        ->union($darat)->first();
        if(!$jarak){
            $jarak = ['jarak_km' => 0];
        }

        return response()->json($jarak, 200);
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
    
}
