<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Psr\Http\Client\ClientInterface;
use Symfony\Component\HttpClient\Psr18Client;

class ElasticsearchServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
        $this->app->bind(ClientInterface::class, function () {
        return new Psr18Client();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
        
    }
}
