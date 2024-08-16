<?php

namespace Rainwaves\Api;

use Rainwaves\Exceptions\ColliveryException;
use Illuminate\Support\Facades\Cache;
use Rainwaves\Interfaces\HttpClientInterface;

class Auth
{
    /**
     * @var Auth
     */
    private static Auth $instance;

    /**
     * @var HttpClientInterface
     */
    protected HttpClientInterface $httpClient;

    /**
     * The token that is used for API authentication.
     *
     * @var string|null
     */
    protected ?string $token;

    /**
     * Auth constructor.
     *
     * @param HttpClientInterface $httpClient
     */
    private function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * Get the singleton instance of the Auth class.
     *
     * @param HttpClientInterface $httpClient
     * @return Auth
     */
    public static function getInstance(HttpClientInterface $httpClient): Auth
    {
        if (null === static::$instance) {
            static::$instance = new static($httpClient);
        }

        return static::$instance;
    }

    /**
     * Retrieve the API token.
     *
     * @return string
     * @throws ColliveryException
     */
    public function getToken(): string
    {
        if ($this->token === null) {
            $this->token = $this->getCachedToken() ?: $this->authenticate();
        }

        return $this->token;
    }

    /**
     * Authenticate with the API and retrieve a new token.
     *
     * @return string
     * @throws ColliveryException
     */
    protected function authenticate(): string
    {
        $credentials = [
            'username' => config('collivery.username'),
            'password' => config('collivery.password'),
        ];

        try {
            $response = $this->httpClient->post('/login', $this->getHeaders(), [], $credentials);

            if ($response['status_code'] === 200 && isset($response['data']['token'])) {
                $token = $response['data']['token'];
                $this->cacheToken($token);
                return $token;
            }

            throw new ColliveryException("Authentication failed: Invalid response from API");
        } catch (\Exception $e) {
            throw new ColliveryException("Authentication failed: " . $e->getMessage(), 0, $e);
        }
    }

    /**
     * Cache the API token.
     *
     * @param string $token
     * @return void
     */
    protected function cacheToken(string $token): void
    {
        Cache::put('collivery_api_token', $token, now()->addMinutes(30));
    }

    /**
     * Retrieve the cached token if available.
     *
     * @return string|null
     */
    protected function getCachedToken(): ?string
    {
        return Cache::get('collivery_api_token');
    }

    /**
     * Get the headers required for authentication including application information.
     *
     * @return array
     */
    protected function getHeaders(): array
    {
        return [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'X-App-Name' => config('collivery.app_name'),
            'X-App-Version' => config('collivery.app_version'),
            'X-App-Host' => config('collivery.app_host'),
            'X-App-Lang' => config('collivery.app_lang'),
            'X-App-Url' => config('collivery.app_url'),
        ];
    }
}
