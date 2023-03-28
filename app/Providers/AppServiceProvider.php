<?php

namespace App\Providers;

use App\Models\Api;
use App\Services\Common;
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
        //
        $this->app->singleton('common', function ($app) {
            return new Common();
        });
        view()->composer('*',function($view) {
            $view->with('rezlive',Api::all());
        });
    }
}
