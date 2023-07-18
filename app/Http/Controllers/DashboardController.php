<?php

namespace App\Http\Controllers;

use App\Models\Kandidat;
use App\Models\Surveyor;
use App\Models\Tps;
use App\Models\TpsLampiran;
use App\Models\PerolehanSuara;
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
        return view('welcome');
    }

}
