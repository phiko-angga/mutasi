<?php

namespace App\Http\Controllers;

use App\Models\Sbum;
use App\Models\Provinsi;
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
                $query->where('nama','like','%'.$search.'%');
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

}
