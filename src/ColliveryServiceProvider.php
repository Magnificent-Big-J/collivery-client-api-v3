<?php

namespace Rainwaves;

use Illuminate\Support\ServiceProvider;
use Rainwaves\Api\Address;
use Rainwaves\Api\Auth;
use Rainwaves\Api\BatteryType;
use Rainwaves\Api\Contact;
use Rainwaves\Api\Country;
use Rainwaves\Api\LocationType;
use Rainwaves\Api\ParcelImage;
use Rainwaves\Api\ParcelType;
use Rainwaves\Api\PredifinedParcel;
use Rainwaves\Api\ProofOfDelivery;
use Rainwaves\Api\ServiceType;
use Rainwaves\Api\Status;
use Rainwaves\Api\StatusTracking;
use Rainwaves\Api\Suburb;
use Rainwaves\Api\TermAndCondition;
use Rainwaves\Api\Town;
use Rainwaves\Api\Vendor;
use Rainwaves\Api\VendorReport;
use Rainwaves\Api\VendorWaybill;
use Rainwaves\Api\Waybill;
use Rainwaves\Api\WaybillDocument;
use Rainwaves\Api\WebPrinter;
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

        $this->app->singleton(BatteryType::class, function ($app) {
            return $app->make(Collivery::class)->batteryType();
        });

        $this->app->singleton(Contact::class, function ($app) {
            return $app->make(Collivery::class)->contact();
        });

        $this->app->singleton(Country::class, function ($app) {
            return $app->make(Collivery::class)->country();
        });
        $this->app->singleton(LocationType::class, function ($app) {
            return $app->make(Collivery::class)->locationType();
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

        $this->app->singleton(ServiceType::class, function ($app) {
            return $app->make(Collivery::class)->serviceType();
        });

        $this->app->singleton(Suburb::class, function ($app) {
            return $app->make(Collivery::class)->suburb();
        });

        $this->app->singleton(Status::class, function ($app) {
            return $app->make(Collivery::class)->status();
        });

        $this->app->singleton(ParcelType::class, function ($app) {
            return $app->make(Collivery::class)->parcelType();
        });

        $this->app->singleton(ParcelImage::class, function ($app) {
            return $app->make(Collivery::class)->parcelImage();
        });

        $this->app->singleton(PredifinedParcel::class, function ($app) {
            return $app->make(Collivery::class)->predifinedParcel();
        });

        $this->app->singleton(ProofOfDelivery::class, function ($app) {
            return $app->make(Collivery::class)->proofOfDelivery();
        });

        $this->app->singleton(TermAndCondition::class, function ($app) {
            return $app->make(Collivery::class)->termAndCondition();
        });

        $this->app->singleton(Vendor::class, function ($app) {
            return $app->make(Collivery::class)->vendor();
        });

        $this->app->singleton(VendorReport::class, function ($app) {
            return $app->make(Collivery::class)->vendorReport();
        });

        $this->app->singleton(VendorWaybill::class, function ($app) {
            return $app->make(Collivery::class)->vendorWaybill();
        });

        $this->app->singleton(WaybillDocument::class, function ($app) {
            return $app->make(Collivery::class)->waybillDocument();
        });

        $this->app->singleton(WebPrinter::class, function ($app) {
            return $app->make(Collivery::class)->webPrinter();
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
