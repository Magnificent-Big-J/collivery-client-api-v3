<?php

namespace Rainwaves;

use Illuminate\Support\ServiceProvider;
use Rainwaves\Api\Auth;
use Rainwaves\Api\Address;
use Rainwaves\Api\Contact;
use Rainwaves\Api\Waybill;
use Rainwaves\Api\StatusTracking;
use Rainwaves\Helpers\HttpClient;

class ColliveryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // Bind HttpClient to the service container
        $this->app->singleton(HttpClient::class, function () {
            return new HttpClient();
        });

        // Bind Auth to the service container
        $this->app->singleton(Auth::class, function ($app) {
            $httpClient = $app->make(HttpClient::class);
            $auth = Auth::getInstance($httpClient);
            $auth->login(
                config('collivery.username'),
                config('collivery.password')
            );
            return $auth;
        });

        $this->app->singleton(Address::class, function ($app) {
            $httpClient = $app->make(HttpClient::class);
            $auth = $app->make(Auth::class);
            return new Address($httpClient, $auth);
        });

        $this->app->singleton(Contact::class, function ($app) {
            $httpClient = $app->make(HttpClient::class);
            $auth = $app->make(Auth::class);
            return new Contact($httpClient, $auth);
        });

        $this->app->singleton(Waybill::class, function ($app) {
            $httpClient = $app->make(HttpClient::class);
            $auth = $app->make(Auth::class);
            return new Waybill($httpClient, $auth);
        });

        $this->app->singleton(StatusTracking::class, function ($app) {
            $httpClient = $app->make(HttpClient::class);
            $auth = $app->make(Auth::class);
            return new StatusTracking($httpClient, $auth);
        });

        $this->app->singleton(Collivery::class, function ($app) {
            $httpClient = $app->make(HttpClient::class);
            $auth = $app->make(Auth::class);
            return new Collivery($httpClient, $auth);
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../config/collivery.php' => config_path('collivery.php'),
        ], 'config');
    }
}
