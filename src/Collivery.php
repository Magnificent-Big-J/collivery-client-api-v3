<?php

namespace Rainwaves;

use Rainwaves\Api\Address;
use Rainwaves\Api\Contact;
use Rainwaves\Api\Waybill;
use Rainwaves\Api\StatusTracking;
use Rainwaves\Api\Auth;
use Rainwaves\Interfaces\HttpClientInterface;

class Collivery
{
    /**
     * @var Auth
     */
    protected $auth;

    /**
     * @var HttpClientInterface
     */
    protected $httpClient;

    /**
     * Collivery constructor.
     *
     * @param HttpClientInterface $httpClient
     * @param Auth $auth
     */
    public function __construct(HttpClientInterface $httpClient, Auth $auth)
    {
        $this->httpClient = $httpClient;
        $this->auth = $auth;
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
     * Get an instance of the Contact service.
     *
     * @return Contact
     */
    public function contact(): Contact
    {
        return new Contact($this->httpClient, $this->auth);
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
     * Get an instance of the StatusTracking service.
     *
     * @return StatusTracking
     */
    public function statusTracking(): StatusTracking
    {
        return new StatusTracking($this->httpClient, $this->auth);
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
}
