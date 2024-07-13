<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    //comment here for cpanel
    public function register()
    {
        //
    }
    // Uncomment  here for cpanel purpose
    // public function register()
    // {
    //     $this->app->bind('path.public', function() {
    //         return base_path('../public_html');
    //     });
    // }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Paginator::useBootstrap();
    }
}
