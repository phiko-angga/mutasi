<?php

namespace App\Http\Controllers;

use App\Models\TransaksiBiaya;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $sumBiayaNotApproved = TransaksiBiaya::selectRaw('sum(rampung_jumlah) as rampung_jumlah')->where('approved',0)->first();
        $sumBiayaApproved = TransaksiBiaya::selectRaw('sum(rampung_jumlah) as rampung_jumlah')->where('approved',1)->first();
        return view('welcome',compact('sumBiayaNotApproved','sumBiayaApproved'));
    }

}
