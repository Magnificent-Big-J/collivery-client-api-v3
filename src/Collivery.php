<?php

namespace Rainwaves;

use Rainwaves\Api\Address;
use Rainwaves\Api\BatteryType;
use Rainwaves\Api\Contact;
use Rainwaves\Api\Country;
use Rainwaves\Api\LocationType;
use Rainwaves\Api\ParcelImage;
use Rainwaves\Api\ParcelType;
use Rainwaves\Api\PredifinedParcel;
use Rainwaves\Api\ServiceType;
use Rainwaves\Api\Status;
use Rainwaves\Api\Suburb;
use Rainwaves\Api\TermAndCondition;
use Rainwaves\Api\Vendor;
use Rainwaves\Api\VendorReport;
use Rainwaves\Api\VendorWaybill;
use Rainwaves\Api\Waybill;
use Rainwaves\Api\StatusTracking;
use Rainwaves\Api\Auth;
use Rainwaves\Api\Town;
use Rainwaves\Api\WaybillDocument;
use Rainwaves\Api\WebPrinter;
use Rainwaves\Exceptions\ColliveryException;
use Rainwaves\Interfaces\HttpClientInterface;

class Collivery
{
    /**
     * @var Auth
     */
    protected Auth $auth;

    /**
     * @var HttpClientInterface
     */
    protected HttpClientInterface $httpClient;

    /**
     * @var array
     */
    protected array $config;

    /**
     * Collivery constructor.
     *
     * @param HttpClientInterface $httpClient
     * @param array $config
     * @throws ColliveryException
     */
    public function __construct(HttpClientInterface $httpClient, array $config)
    {
        $this->httpClient = $httpClient;
        $this->config = $config;

        // Initialize Auth using the provided configuration
        $this->auth = Auth::getInstance($httpClient);
        $this->auth->login($config['username'], $config['password']);
    }

    /**
     * Get an instance of the Address service.
     *
     * @return Address
     */
    public function address(): Address
    {
        return new Address($this->httpClient, $this->auth);
    }

    /**
     * Get an instance of the batteryType service.
     *
     * @return batteryType
     */
    public function batteryType(): BatteryType
    {
        return new BatteryType($this->httpClient, $this->auth);
    }

    /**
     * Get an instance of the Contact service.
     *
     * @return Contact
     */
    public function contact(): Contact
    {
        return new Contact($this->httpClient, $this->auth);
    }

    /**
     * Get an instance of the Country service.
     *
     * @return Country
     */
    public function country(): Country
    {
        return new Country($this->httpClient, $this->auth);
    }

    /**
     * Get an instance of the locationType service.
     *
     * @return locationType
     */
    public function locationType(): LocationType
    {
        return new LocationType($this->httpClient, $this->auth);
    }

    /**
     * Get an instance of the StatusTracking service.
     *
     * @return StatusTracking
     */
    public function statusTracking(): StatusTracking
    {
        return new StatusTracking($this->httpClient, $this->auth);
    }

    /**
     * Get an instance of the Town service.
     *
     * @return Town
     */
    public function town(): Town
    {
        return new Town($this->httpClient, $this->auth);
    }

    /**
     * Get an instance of the ServiceType service.
     *
     * @return ServiceType
     */

    public function serviceType(): ServiceType
    {
        return new ServiceType($this->httpClient, $this->auth);
    }

    /**
     * Get an instance of the Suburb service.
     *
     * @return Suburb
     */
    public function suburb(): Suburb
    {
        return new Suburb($this->httpClient, $this->auth);
    }

    /**
     * Get an instance of the Status service.
     *
     * @return Status
     */
    public function status(): Status
    {
        return new Status($this->httpClient, $this->auth);
    }

    /**
     * Get an instance of the ParcelImage service.
     *
     * @return ParcelImage
     */
    public function parcelImage(): ParcelImage
    {
        return new ParcelImage($this->httpClient, $this->auth);
    }

    /**
     * Get an instance of the parcelType service.
     *
     * @return parcelType
     */
    public function parcelType(): ParcelType
    {
        return new ParcelType($this->httpClient, $this->auth);
    }
    /**
     * Get an instance of the Status service.
     *
     * @return PredifinedParcel
     */
    public function predifinedParcel(): PredifinedParcel
    {
        return new PredifinedParcel($this->httpClient, $this->auth);
    }

    /**
     * Get an instance of the TermAndCondition service.
     *
     * @return TermAndCondition
     */
    public function termAndCondition(): TermAndCondition
    {
        return new TermAndCondition($this->httpClient, $this->auth);
    }

    /**
     * Get an instance of the Vendor service.
     *
     * @return Vendor
     */

    public function vendor(): Vendor
    {
        return new Vendor($this->httpClient, $this->auth);
    }

    /**
     * Get an instance of the VendorReport service.
     *
     * @return VendorReport
     */
    public function vendorReport(): VendorReport
    {
        return new VendorReport($this->httpClient, $this->auth);
    }

    /**
     * Get an instance of the vendorWaybill service.
     *
     * @return vendorWaybill
     */
    public function vendorWaybill(): VendorWaybill
    {
        return new VendorWaybill($this->httpClient, $this->auth);
    }

    /**
     * Get an instance of the Waybill service.
     *
     * @return Waybill
     */
    public function waybill(): Waybill
    {
        return new Waybill($this->httpClient, $this->auth);
    }


    /**
     * Get an instance of the Status service.
     *
     * @return waybillDocument
     */
    public function waybillDocument(): WaybillDocument
    {
        return new WaybillDocument($this->httpClient, $this->auth);
    }

    /**
     * Get an instance of the WebPrinter service.
     *
     * @return WebPrinter
     */
    public function webPrinter(): WebPrinter
    {
        return new WebPrinter($this->httpClient, $this->auth);
    }
    /**
     * Get the Auth instance.
     *
     * @return Auth
     */
    public function auth(): Auth
    {
        return $this->auth;
    }

    /**
     * Get the configuration array.
     *
     * @return array
     */
    public function getConfig(): array
    {
        return $this->config;
    }
}
