<?php

namespace Rainwaves;

use Illuminate\Support\ServiceProvider;
use Rainwaves\Api\Address;
use Rainwaves\Api\Auth;
use Rainwaves\Api\Contact;
use Rainwaves\Api\StatusTracking;
use Rainwaves\Api\Town;
use Rainwaves\Api\Waybill;
use Rainwaves\Helpers\HttpClient;

class ColliveryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        // Bind HttpClient to the service container
        $this->app->singleton(HttpClient::class, function () {
            return new HttpClient();
        });

        // Bind Collivery to the service container
        $this->app->singleton(Collivery::class, function ($app) {
            $httpClient = $app->make(HttpClient::class);
            $config = [
                'username' => config('collivery.username'),
                'password' => config('collivery.password'),
                'app_name' => config('collivery.app_name'),
                'app_version' => config('collivery.app_version'),
                'app_host' => config('collivery.app_host'),
                'app_lang' => config('collivery.app_lang'),
                'app_url' => config('collivery.app_url'),
            ];

            return new Collivery($httpClient, $config);
        });

        $this->app->singleton(Address::class, function ($app) {
            return $app->make(Collivery::class)->address();
        });

        $this->app->singleton(Contact::class, function ($app) {
            return $app->make(Collivery::class)->contact();
        });

        $this->app->singleton(Waybill::class, function ($app) {
            return $app->make(Collivery::class)->waybill();
        });

        $this->app->singleton(StatusTracking::class, function ($app) {
            return $app->make(Collivery::class)->statusTracking();
        });

        $this->app->singleton(Town::class, function ($app) {
            return $app->make(Collivery::class)->town();
        });

        $this->app->singleton(Auth::class, function ($app) {
            return $app->make(Collivery::class)->auth();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(): void
    {
        // Publish the configuration file
        $this->publishes([
            __DIR__ . '/../config/collivery.php' => config_path('collivery.php'),
        ], 'config');
    }
}
