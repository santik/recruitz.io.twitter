<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Santik\RecruitzIoTwitter\TwitterService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind('TwitterService', TwitterService::class;
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
