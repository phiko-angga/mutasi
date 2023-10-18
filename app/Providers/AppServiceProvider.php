<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use App\Models\Menu;
use App\Models\Provinsi;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        
        Paginator::useBootstrap();
        
        view()->composer(
            ['layout._sidebar'], 
            function ($view) {
            $request = app(\Illuminate\Http\Request::class);
            
            $user = auth()->user();
            $mMenu = new Menu; 
            $menu = $mMenu->get_menu_akses($user->id);
            $menu_grup = $mMenu->get_menugrup_akses($user->id);

            view()->share(compact('menu','menu_grup'));
        });

        view()->composer(
            ['layout._filter_wilayah'], 
            function ($view) {
            $request = app(\Illuminate\Http\Request::class);
            
            $provinsi = null;
            $provinsi_id = $request->get('provinsi');
            if($provinsi_id != null){
                $provinsi = Provinsi::find($provinsi_id);
            }

            view()->share(compact('provinsi'));
        });
    }
}
