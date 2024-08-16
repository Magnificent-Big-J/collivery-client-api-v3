<?php

namespace Rainwaves\Api;

use Rainwaves\Exceptions\ColliveryException;
use Rainwaves\Interfaces\HttpClientInterface;

class Auth
{
    /**
     * @var HttpClientInterface
     */
    protected HttpClientInterface $httpClient;

    /**
     * @var string|null
     */
    protected ?string $token;

    /**
     * Singleton instance.
     *
     * @var Auth|null
     */
    protected static ?Auth $instance = null;

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
     * Get the singleton instance.
     *
     * @param HttpClientInterface $httpClient
     * @return Auth
     */
    public static function getInstance(HttpClientInterface $httpClient): Auth
    {
        if (self::$instance === null) {
            self::$instance = new self($httpClient);
        }

        return self::$instance;
    }

    /**
     * Authenticate and retrieve the API token.
     *
     * @param string $email
     * @param string $password
     * @return string
     * @throws ColliveryException
     */
    public function login(string $email, string $password): string
    {
        $response = $this->httpClient->post('/login', [], [
            'email' => $email,
            'password' => $password,
        ]);

        if (!isset($response['token'])) {
            throw new ColliveryException('Authentication failed: Token not provided');
        }

        $this->token = $response['token'];
        return $this->token;
    }

    /**
     * Get the current token.
     *
     * @return string|null
     */
    public function getToken(): ?string
    {
        return $this->token;
    }
}
