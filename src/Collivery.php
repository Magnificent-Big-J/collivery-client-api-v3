<?php

namespace Rainwaves;

use Rainwaves\Api\Address;
use Rainwaves\Api\Contact;
use Rainwaves\Api\Waybill;
use Rainwaves\Api\StatusTracking;
use Rainwaves\Api\Auth;
use Rainwaves\Api\Town;
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
     * Get an instance of the Town service.
     *
     * @return Town
     */
    public function town(): Town
    {
        return new Town($this->httpClient, $this->auth);
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
