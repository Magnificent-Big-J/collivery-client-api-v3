<?php

namespace Rainwaves\Interfaces;

interface HttpClientInterface
{
    /**
     * Send a GET request.
     *
     * @param string $url
     * @param array $headers
     * @param array $parameters
     * @return mixed
     */
    public function get(string $url, array $headers = [], array $parameters = []): mixed;

    /**
     * Send a POST request.
     *
     * @param string $url
     * @param array $headers
     * @param array $data
     * @return mixed
     */
    public function post(string $url, array $headers = [], array $data = []): mixed;

    /**
     * Send a PUT request.
     *
     * @param string $url
     * @param array $headers
     * @param array $data
     * @return mixed
     */
    public function put(string $url, array $headers = [], array $data = []): mixed;

    /**
     * Send a DELETE request.
     *
     * @param string $url
     * @param array $headers
     * @param array $parameters
     * @return mixed
     */
    public function delete(string $url, array $headers = [], array $parameters = []): mixed;
}