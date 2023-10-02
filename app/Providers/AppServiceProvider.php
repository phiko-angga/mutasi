<?php

namespace App\Providers;

use App\Models\Menu;
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
    }
}
