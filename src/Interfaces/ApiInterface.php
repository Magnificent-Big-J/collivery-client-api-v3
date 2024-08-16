<?php

namespace Rainwaves\Interfaces;

interface ApiInterface
{
    /**
     * Authenticate the API client.
     *
     * @return mixed
     */
    public function authenticate(): mixed;

    /**
     * Send a GET request to the API.
     *
     * @param string $endpoint
     * @param array $parameters
     * @return mixed
     */
    public function get(string $endpoint, array $parameters = []): mixed;

    /**
     * Send a POST request to the API.
     *
     * @param string $endpoint
     * @param array $data
     * @return mixed
     */
    public function post(string $endpoint, array $data = []): mixed;

    /**
     * Send a PUT request to the API.
     *
     * @param string $endpoint
     * @param array $data
     * @return mixed
     */
    public function put(string $endpoint, array $data = []): mixed;

    /**
     * Send a DELETE request to the API.
     *
     * @param string $endpoint
     * @param array $parameters
     * @return mixed
     */
    public function delete(string $endpoint, array $parameters = []): mixed;
}