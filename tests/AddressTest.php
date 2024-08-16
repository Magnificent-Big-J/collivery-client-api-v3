<?php

namespace Rainwaves\Tests;

use Orchestra\Testbench\TestCase;
use Rainwaves\Api\Address;
use Rainwaves\Api\Auth;
use Rainwaves\Exceptions\ColliveryException;
use Illuminate\Support\Facades\Cache;
use Rainwaves\Interfaces\HttpClientInterface;

class AddressTest extends TestCase
{
    protected $httpClient;

    protected function setUp(): void
    {
        parent::setUp();

        $this->httpClient = $this->createMock(HttpClientInterface::class);
    }

    public function test_it_can_retrieve_and_cache_addresses()
    {
        $expectedAddresses = [['id' => 1, 'line1' => '123 Main St']];
        $this->httpClient->method('get')
            ->willReturn([
                'status_code' => 200,
                'data' => $expectedAddresses
            ]);

        $addressService = new Address($this->httpClient, $this->getMockAuth());
        $addresses = $addressService->getAddresses();

        $this->assertEquals($expectedAddresses, $addresses);
        $this->assertEquals($expectedAddresses, Cache::get('addresses_' . md5(serialize([]))));
    }

    public function test_it_uses_cached_addresses_if_available()
    {
        $cachedAddresses = [['id' => 1, 'line1' => '123 Cached St']];
        Cache::put('addresses_' . md5(serialize([])), $cachedAddresses, now()->addMinutes(30));

        $addressService = new Address($this->httpClient, $this->getMockAuth());
        $addresses = $addressService->getAddresses();

        $this->assertEquals($cachedAddresses, $addresses);
    }

    public function test_it_can_retrieve_address_by_id_and_cache_it()
    {
        $expectedAddress = ['id' => 1, 'line1' => '123 Main St'];
        $this->httpClient->method('get')
            ->willReturn([
                'status_code' => 200,
                'data' => $expectedAddress
            ]);

        $addressService = new Address($this->httpClient, $this->getMockAuth());
        $address = $addressService->getAddressById(1);

        $this->assertEquals($expectedAddress, $address);
        $this->assertEquals($expectedAddress, Cache::get('collivery_address_1'));
    }

    public function test_it_throws_exception_on_failed_request()
    {
        $this->httpClient->method('get')
            ->will($this->throwException(new \Exception('API error')));

        $this->expectException(ColliveryException::class);

        $addressService = new Address($this->httpClient, $this->getMockAuth());
        $addressService->getAddresses();
    }

    public function test_it_can_create_address_with_provided_payload()
    {
        $addressPayload = [
            'town_id' => 147,
            'town_name' => 'Johannesburg',
            'province' => 'Gauteng',
            'suburb_id' => 1936,
            'suburb_name' => 'Selby',
            'company_name' => 'MDS Collivery',
            'building' => 'MDS House',
            'street_number' => '58c',
            'street' => 'Webber Street',
            'location_type' => 1,
            'location_type_name' => 'Business Premises',
            'contact' => [
                'id' => 2519728,
                'full_name' => 'John Doe',
                'cellphone' => '0723456789',
                'email_address' => 'demo@collivery.co.za',
            ],
            'country' => 'ZAF',
        ];

        $expectedResponse = array_merge(['id' => 1], $addressPayload);
        $this->httpClient->method('post')
            ->willReturn([
                'status_code' => 200,
                'data' => $expectedResponse
            ]);

        $addressService = new Address($this->httpClient, $this->getMockAuth());
        $response = $addressService->createAddress($addressPayload);

        $this->assertEquals($expectedResponse, $response);
    }

    /**
     * @throws ColliveryException
     */
    public function test_it_can_update_address()
    {
        $updatedData = ['line1' => '456 New St'];
        $expectedResponse = ['id' => 1, 'line1' => '456 New St'];
        $this->httpClient->method('put')
            ->willReturn([
                'status_code' => 200,
                'data' => $expectedResponse
            ]);

        $addressService = new Address($this->httpClient, $this->getMockAuth());
        $response = $addressService->updateAddress(1, $updatedData);

        $this->assertEquals($expectedResponse, $response);
    }

    /**
     * @throws ColliveryException
     */
    public function test_it_can_delete_address()
    {
        $expectedResponse = ['status' => 'success'];
        $this->httpClient->method('delete')
            ->willReturn([
                'status_code' => 200,
                'data' => $expectedResponse
            ]);

        $addressService = new Address($this->httpClient, $this->getMockAuth());
        $response = $addressService->deleteAddress(1);

        $this->assertEquals($expectedResponse, $response);
    }

    /**
     * Mock the Auth instance.
     *
     * @return Auth
     */
    protected function getMockAuth(): Auth
    {
        $auth = $this->createMock(Auth::class);
        $auth->method('getToken')->willReturn('mock_token');
        return $auth;
    }
}
