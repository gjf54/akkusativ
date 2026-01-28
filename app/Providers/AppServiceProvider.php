<?php

namespace App\Providers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        App::bind(
            \App\Contracts\RepositoryContract::class,
            \App\Repositories\Repository::class,
        );

        App::bind(
            \App\Contracts\ServiceContract::class,
            \App\Services\Service::class,
        );
    }

    
    public function boot(): void
    {
        
    }
}
