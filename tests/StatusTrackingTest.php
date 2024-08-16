<?php

namespace Rainwaves\Tests;

use Orchestra\Testbench\TestCase;
use Rainwaves\Api\Auth;
use Rainwaves\Api\StatusTracking;
use Rainwaves\Exceptions\ColliveryException;
use Illuminate\Support\Facades\Cache;
use Rainwaves\Interfaces\HttpClientInterface;
use Carbon\Carbon;
class StatusTrackingTest extends TestCase
{
    protected $httpClient;

    protected function setUp(): void
    {
        parent::setUp();

        $this->httpClient = $this->createMock(HttpClientInterface::class);
    }

    public function test_it_can_track_shipment_with_provided_payload()
    {
        $trackingPayload = [
            'statuses' => '1,3',
            'per_page' => 100,
            'start_date' => Carbon::today()->subDays(30),
            'end_date' => Carbon::today()->subDays(30),
            'page' => 1,
        ];

        $expectedResponse = [['waybill_id' => 123456, 'status' => 3]];
        $this->httpClient->method('get')
            ->willReturn([
                'status_code' => 200,
                'data' => $expectedResponse
            ]);

        $statusTrackingService = new StatusTracking($this->httpClient, $this->getMockAuth());
        $response = $statusTrackingService->trackShipment(123456, $trackingPayload);

        $this->assertEquals($expectedResponse, $response);
        $this->assertEquals($expectedResponse, Cache::get('collivery_tracking_123456'));
    }

    public function test_it_can_retrieve_tracking_history_and_cache_it()
    {
        $expectedHistory = [['waybill_id' => 123456, 'status' => 3, 'date' => '2023-11-10']];
        $this->httpClient->method('get')
            ->willReturn([
                'status_code' => 200,
                'data' => $expectedHistory
            ]);

        $statusTrackingService = new StatusTracking($this->httpClient, $this->getMockAuth());
        $history = $statusTrackingService->getTrackingHistory(123456);

        $this->assertEquals($expectedHistory, $history);
        $this->assertEquals($expectedHistory, Cache::get('collivery_tracking_history_123456'));
    }

    public function test_it_can_retrieve_all_shipment_statuses_and_cache_them()
    {
        $expectedStatuses = [['status_id' => 1, 'status' => 'In Transit'], ['status_id' => 3, 'status' => 'Delivered']];
        $this->httpClient->method('get')
            ->willReturn([
                'status_code' => 200,
                'data' => $expectedStatuses
            ]);

        $statusTrackingService = new StatusTracking($this->httpClient, $this->getMockAuth());
        $statuses = $statusTrackingService->getAllShipmentStatuses();

        $this->assertEquals($expectedStatuses, $statuses);
        $this->assertEquals($expectedStatuses, Cache::get('collivery_all_shipment_statuses'));
    }

    /**
     * @throws ColliveryException
     */
    public function test_it_can_update_shipment_status_with_provided_payload()
    {
        $updatePayload = [
            'status_id' => 3.0,
            'cheapest' => true,
        ];

        $expectedResponse = ['waybill_id' => 123456, 'status_id' => 3, 'updated' => true];
        $this->httpClient->method('put')
            ->willReturn([
                'status_code' => 200,
                'data' => $expectedResponse
            ]);

        $statusTrackingService = new StatusTracking($this->httpClient, $this->getMockAuth());
        $response = $statusTrackingService->updateShipmentStatus(123456, $updatePayload);

        $this->assertEquals($expectedResponse, $response);
    }

    public function test_it_throws_exception_on_failed_request()
    {
        $this->httpClient->method('get')
            ->will($this->throwException(new \Exception('API error')));

        $this->expectException(ColliveryException::class);

        $statusTrackingService = new StatusTracking($this->httpClient, $this->getMockAuth());
        $statusTrackingService->trackShipment(123456);
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
