<?php

namespace App\Providers;

use Carbon;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use App\Providers\Debugbar;
use Barryvdh\Debugbar\Middleware\DebugbarEnabled;
use DebugBar\DebugBar as DebugBarDebugBar;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::component('catalogos.share._panel_list','panel');
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
