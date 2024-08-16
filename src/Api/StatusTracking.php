<?php

namespace Rainwaves\Api;

use Rainwaves\Exceptions\ColliveryException;
use Illuminate\Support\Facades\Cache;

class StatusTracking extends BaseApi
{
    /**
     * Track the status of a shipment by waybill ID.
     *
     * @param int $waybillId
     * @return array
     */
    public function trackShipment(int $waybillId): array
    {
        $cacheKey = "collivery_tracking_{$waybillId}";

        return Cache::remember($cacheKey, now()->addMinutes(30), function () use ($waybillId) {
            return $this->handleRequest('get', "/tracking/{$waybillId}");
        });
    }

    /**
     * Retrieve the tracking history for a specific shipment by waybill ID.
     *
     * @param int $waybillId
     * @return array
     */
    public function getTrackingHistory(int $waybillId): array
    {
        $cacheKey = "collivery_tracking_history_{$waybillId}";

        return Cache::remember($cacheKey, now()->addMinutes(30), function () use ($waybillId) {
            return $this->handleRequest('get', "/tracking/{$waybillId}/history");
        });
    }

    /**
     * Retrieve all shipment statuses.
     *
     * @return array
     */
    public function getAllShipmentStatuses(): array
    {
        $cacheKey = "collivery_all_shipment_statuses";

        return Cache::remember($cacheKey, now()->addMinutes(30), function () {
            return $this->handleRequest('get', "/tracking/statuses");
        });
    }

    /**
     * Update the status of a specific shipment by waybill ID.
     *
     * @param int $waybillId
     * @param array $data
     * @return array
     * @throws ColliveryException
     */
    public function updateShipmentStatus(int $waybillId, array $data): array
    {
        return $this->handleRequest('put', "/tracking/{$waybillId}/status", [], $data);
    }
}
