<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // The admin panel is built on AdminLTE (Bootstrap 4)
        Paginator::useBootstrapFour();
    }
}
