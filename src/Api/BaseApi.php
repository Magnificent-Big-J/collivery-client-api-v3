<?php

namespace Rainwaves\Api;

use Rainwaves\Exceptions\ColliveryException;
use Rainwaves\Exceptions\UnauthorizedException;
use Rainwaves\Exceptions\ForbiddenException;
use Rainwaves\Exceptions\NotFoundException;
use Rainwaves\Exceptions\ValidationException;
use Rainwaves\Exceptions\ServerException;
use Rainwaves\Exceptions\RateLimitException;
use Rainwaves\Exceptions\BadRequestException;
use Rainwaves\Exceptions\ConflictException;
use Rainwaves\Interfaces\HttpClientInterface;

abstract class BaseApi
{
    /**
     * @var HttpClientInterface
     */
    protected $httpClient;

    /**
     * @var Auth
     */
    protected $auth;

    /**
     * BaseApi constructor.
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
     * Handles API requests and checks for status codes.
     *
     * @param string $method
     * @param string $endpoint
     * @param array $parameters
     * @param array $data
     * @return mixed
     * @throws ColliveryException
     */
    protected function handleRequest(string $method, string $endpoint, array $parameters = [], array $data = []): mixed
    {
        try {
            $response = $this->httpClient->$method($endpoint, $this->getAuthHeaders(), $parameters, $data);

            switch ($response['status_code']) {
                case 200:
                case 201:
                    return $response['data'];
                case 400:
                    throw new BadRequestException("Bad Request: " . json_encode($response['errors']));
                case 401:
                    throw new UnauthorizedException();
                case 403:
                    throw new ForbiddenException();
                case 404:
                    throw new NotFoundException("Not Found: " . json_encode($response['errors']));
                case 409:
                    throw new ConflictException("Conflict: " . json_encode($response['errors']));
                case 422:
                    throw new ValidationException("Validation error: " . json_encode($response['errors']));
                case 429:
                    throw new RateLimitException();
                case 500:
                    throw new ServerException();
                default:
                    throw new ColliveryException("An unexpected error occurred: " . json_encode($response));
            }
        } catch (\Exception $e) {
            throw new ColliveryException("Request failed: " . $e->getMessage(), 0, $e);
        }
    }

    /**
     * Get the headers required for authentication.
     *
     * @return array
     */
    protected function getAuthHeaders(): array
    {
        return [
            'Authorization' => 'Bearer ' . $this->auth->getToken(),
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
