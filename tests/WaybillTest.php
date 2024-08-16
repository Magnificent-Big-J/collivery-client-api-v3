<?php

namespace Rainwaves\Tests;

use Orchestra\Testbench\TestCase;
use Rainwaves\Api\Auth;
use Rainwaves\Api\Waybill;
use Rainwaves\Exceptions\ColliveryException;
use Illuminate\Support\Facades\Cache;
use Rainwaves\Interfaces\HttpClientInterface;

class WaybillTest extends TestCase
{
    protected $httpClient;

    protected function setUp(): void
    {
        parent::setUp();

        $this->httpClient = $this->createMock(HttpClientInterface::class);
    }

    public function test_it_can_retrieve_and_cache_waybills()
    {
        $expectedWaybills = [['id' => 1, 'service' => 3]];
        $this->httpClient->method('get')
            ->willReturn([
                'status_code' => 200,
                'data' => $expectedWaybills
            ]);

        $waybillService = new Waybill($this->httpClient, $this->getMockAuth());
        $waybills = $waybillService->getWaybills();

        $this->assertEquals($expectedWaybills, $waybills);
        $this->assertEquals($expectedWaybills, Cache::get('waybills_' . md5(serialize([]))));
    }

    public function test_it_uses_cached_waybills_if_available()
    {
        $cachedWaybills = [['id' => 1, 'service' => 3]];
        Cache::put('waybills_' . md5(serialize([])), $cachedWaybills, now()->addMinutes(30));

        $waybillService = new Waybill($this->httpClient, $this->getMockAuth());
        $waybills = $waybillService->getWaybills();

        $this->assertEquals($cachedWaybills, $waybills);
    }

    public function test_it_can_retrieve_waybill_by_id_and_cache_it()
    {
        $expectedWaybill = ['id' => 1, 'service' => 3];
        $this->httpClient->method('get')
            ->willReturn([
                'status_code' => 200,
                'data' => $expectedWaybill
            ]);

        $waybillService = new Waybill($this->httpClient, $this->getMockAuth());
        $waybill = $waybillService->getWaybillById(1);

        $this->assertEquals($expectedWaybill, $waybill);
        $this->assertEquals($expectedWaybill, Cache::get('collivery_waybill_1'));
    }

    public function test_it_throws_exception_on_failed_request()
    {
        $this->httpClient->method('get')
            ->will($this->throwException(new \Exception('API error')));

        $this->expectException(ColliveryException::class);

        $waybillService = new Waybill($this->httpClient, $this->getMockAuth());
        $waybillService->getWaybills();
    }

    /**
     * @throws ColliveryException
     */
    public function test_it_can_create_waybill_with_provided_payload()
    {
        $waybillPayload = [
            'service' => 3,
            'parcels' => [
                [
                    'length' => 21.5,
                    'width' => 10.0,
                    'height' => 5.5,
                    'weight' => 5.2,
                    'quantity' => 2,
                    'product_id' => 2542,
                    'ref' => 'ypcemwoqy',
                ],
            ],
            'collection_address' => '952',
            'collection_contact' => 593,
            'delivery_address' => '955',
            'delivery_contact' => 596,
            'exclude_weekend' => true,
            'risk_cover' => true,
            'consolidate' => true,
            'battery_type' => 'pi_965',
            'parcel_type' => 2,
        ];

        $expectedResponse = array_merge(['id' => 1], $waybillPayload);
        $this->httpClient->method('post')
            ->willReturn([
                'status_code' => 200,
                'data' => $expectedResponse
            ]);

        $waybillService = new Waybill($this->httpClient, $this->getMockAuth());
        $response = $waybillService->createWaybill($waybillPayload);

        $this->assertEquals($expectedResponse, $response);
    }

    /**
     * @throws ColliveryException
     */
    public function test_it_can_update_waybill()
    {
        $updatedData = ['service' => 4];
        $expectedResponse = ['id' => 1, 'service' => 4];
        $this->httpClient->method('put')
            ->willReturn([
                'status_code' => 200,
                'data' => $expectedResponse
            ]);

        $waybillService = new Waybill($this->httpClient, $this->getMockAuth());
        $response = $waybillService->updateWaybill(1, $updatedData);

        $this->assertEquals($expectedResponse, $response);
    }

    /**
     * @throws ColliveryException
     */
    public function test_it_can_cancel_waybill()
    {
        $expectedResponse = ['status' => 'success'];
        $this->httpClient->method('delete')
            ->willReturn([
                'status_code' => 200,
                'data' => $expectedResponse
            ]);

        $waybillService = new Waybill($this->httpClient, $this->getMockAuth());
        $response = $waybillService->cancelWaybill(1);

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
