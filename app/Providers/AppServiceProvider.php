<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

   view()->composer('layouts.sidebar', function($view)
    {
        $company=array(1,2,3);
        $view->with('company', 'company');


    });

        require_once app_path() . '/Helper/validators.php';
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
