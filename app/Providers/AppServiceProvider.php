<?php

namespace App\Providers;

use Carbon;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use App\Providers\Debugbar;
use Barryvdh\Debugbar\Middleware\DebugbarEnabled;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        Blade::withoutComponentTags();

        Blade::component('catalogos.share._panel_list','panel');

        if($this->app->environment('production')) {
            URL::forceScheme('https');
        }


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
