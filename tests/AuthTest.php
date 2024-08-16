<?php

namespace Rainwaves\Tests;

use Orchestra\Testbench\TestCase;
use Rainwaves\Api\Auth;
use Rainwaves\Exceptions\ColliveryException;
use Illuminate\Support\Facades\Cache;
use Rainwaves\Interfaces\HttpClientInterface;

class AuthTest extends TestCase
{
    protected $httpClient;

    protected function setUp(): void
    {
        parent::setUp();

        $this->httpClient = $this->createMock(HttpClientInterface::class);
    }

    /**
     * @throws ColliveryException
     */
    public function test_it_can_retrieve_and_cache_a_token()
    {
        $expectedToken = 'mocked_token';
        $this->httpClient->method('post')
            ->willReturn([
                'status_code' => 200,
                'data' => ['token' => $expectedToken]
            ]);

        $auth = Auth::getInstance($this->httpClient);
        $token = $auth->getToken();

        $this->assertEquals($expectedToken, $token);
        $this->assertEquals($expectedToken, Cache::get('collivery_api_token'));
    }

    /**
     * @throws ColliveryException
     */
    public function test_it_uses_cached_token_if_available()
    {
        $cachedToken = 'cached_token';
        Cache::put('collivery_api_token', $cachedToken, now()->addMinutes(30));

        $auth = Auth::getInstance($this->httpClient);
        $token = $auth->getToken();

        $this->assertEquals($cachedToken, $token);
    }

    public function test_it_throws_exception_on_authentication_failure()
    {
        $this->httpClient->method('post')
            ->will($this->throwException(new \Exception('API error')));

        $this->expectException(ColliveryException::class);
        $auth = Auth::getInstance($this->httpClient);
        $auth->getToken();
    }

    protected function getEnvironmentSetUp($app): void
    {
        $app['config']->set('collivery.username', 'test_username');
        $app['config']->set('collivery.password', 'test_password');
        $app['config']->set('collivery.app_name', 'Test App');
        $app['config']->set('collivery.app_version', '1.0');
        $app['config']->set('collivery.app_host', 'PHPUnit');
        $app['config']->set('collivery.app_lang', 'en');
        $app['config']->set('collivery.app_url', 'http://localhost');
    }
}
