<?php

namespace App\Providers;
use App\Observers\MedecinObserver;
use App\Medecin;
use App\Pharmacie;
use App\Observers\PharmacieObserver;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Auth;
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
        Blade::if('admin',function(){
            return Auth::user()->isAdmin();
        });

        Medecin::observe(MedecinObserver::class);
        Pharmacie::observe(PharmacieObserver::class);
    }


}
