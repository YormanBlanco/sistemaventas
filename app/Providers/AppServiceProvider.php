<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use DB;

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
        //
        /*DB::listen(function ($query) { //function para q impirma el script sql q se ejecute
            //$query->sql;
            // $query->bindings
            // $query->time
            echo "<pre> {$query->sql } </pre>";
            //print_r($query->sql);
        }); */
    }
}
