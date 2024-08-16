<?php

namespace Rainwaves\Helpers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use Psr\Http\Message\ResponseInterface;
use Rainwaves\Exceptions\ColliveryException;
use Rainwaves\Interfaces\HttpClientInterface;

class HttpClient implements HttpClientInterface
{
    /**
     * @var Client
     */
    protected Client $client;

    /**
     * HttpClient constructor.
     */
    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => config('collivery.api_base_uri', 'https://api.collivery.net'),
            'timeout'  => config('collivery.timeout', 30),
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'X-App-Name' => config('collivery.app_name'),
                'X-App-Version' => config('collivery.app_version'),
                'X-App-Host' => config('collivery.app_host'),
                'X-App-Lang' => config('collivery.app_lang'),
                'X-App-Url' => config('collivery.app_url'),
            ],
        ]);
    }

    /**
     * Send a GET request.
     *
     * @param string $url
     * @param array $headers
     * @param array $parameters
     * @return array
     * @throws ColliveryException|GuzzleException
     */
    public function get(string $url, array $headers = [], array $parameters = []): array
    {
        return $this->sendRequest('GET', $url, $headers, $parameters);
    }

    /**
     * Send a POST request.
     *
     * @param string $url
     * @param array $headers
     * @param array $parameters
     * @return array
     * @throws ColliveryException
     * @throws GuzzleException
     */
    public function post(string $url, array $headers = [], array $parameters = []): array
    {
        return $this->sendRequest('POST', $url, $headers, $parameters);
    }

    /**
     * Send a PUT request.
     *
     * @param string $url
     * @param array $headers
     * @param array $parameters
     * @return array
     * @throws ColliveryException
     * @throws GuzzleException
     */
    public function put(string $url, array $headers = [], array $parameters = []): array
    {
        return $this->sendRequest('PUT', $url, $headers, $parameters);
    }

    /**
     * Send a DELETE request.
     *
     * @param string $url
     * @param array $headers
     * @return array
     * @throws ColliveryException
     * @throws GuzzleException
     */
    public function delete(string $url, array $headers = [], array $parameters = []): array
    {
        return $this->sendRequest('DELETE', $url, $headers, $parameters);
    }

    /**
     * Send an HTTP request.
     *
     * @param string $method
     * @param string $url
     * @param array $headers
     * @param array $parameters
     * @return array
     * @throws ColliveryException|GuzzleException
     */
    protected function sendRequest(string $method, string $url, array $headers = [], array $parameters = []): array
    {
        try {
            $options = ['headers' => $headers];

            if ($method === 'GET') {
                $options['query'] = $parameters;
            } else {
                $options['json'] = $parameters;
            }

            $response = $this->client->request($method, $url, $options);

            return $this->handleResponse($response);
        } catch (RequestException $e) {
            throw new ColliveryException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Handle the API response.
     *
     * @param ResponseInterface $response
     * @return array
     * @throws ColliveryException
     */
    protected function handleResponse(ResponseInterface $response): array
    {
        $data = json_decode($response->getBody()->getContents(), true);
        if ($response->getStatusCode() >= 400) {
            throw new ColliveryException($data['message'] ?? 'An error occurred', $response->getStatusCode());
        }
        return $data;
    }
}
