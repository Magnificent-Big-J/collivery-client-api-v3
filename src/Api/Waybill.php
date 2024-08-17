<?php

namespace Rainwaves\Api;

use Rainwaves\Exceptions\ColliveryException;
use Illuminate\Support\Facades\Cache;

class Waybill extends BaseApi
{
    /**
     * Retrieve all waybills.
     *
     * @param array $parameters
     * @return array
     */
    public function getWaybills(array $parameters = []): array
    {
        $cacheKey = $this->getCacheKey('waybills', $parameters);

        return Cache::remember($cacheKey, now()->addMinutes(30), function () use ($parameters) {
            return $this->handleRequest('get', '/waybills', $parameters);
        });
    }

    /**
     * Retrieve a specific waybill by ID.
     *
     * @param int $id
     * @return array
     */
    public function getWaybillById(int $id): array
    {
        $cacheKey = "collivery_waybill_{$id}";

        return Cache::remember($cacheKey, now()->addMinutes(30), function () use ($id) {
            return $this->handleRequest('get', "/waybills/{$id}");
        });
    }

    /**
     * Create a new waybill.
     *
     * @param array $data
     * @return array
     * @throws ColliveryException
     */
    public function createWaybill(array $data): array
    {
        return $this->handleRequest('post', '/waybills', [], $data);
    }

    /**
     * Update an existing waybill.
     *
     * @param int $id
     * @param array $data
     * @return array
     * @throws ColliveryException
     */
    public function updateWaybill(int $id, array $data): array
    {
        return $this->handleRequest('put', "/waybills/{$id}", [], $data);
    }

    /**
     * Cancel a waybill.
     *
     * @param int $id
     * @return array
     * @throws ColliveryException
     */
    public function cancelWaybill(int $id): array
    {
        return $this->handleRequest('delete', "/waybills/{$id}");
    }

    /**
     * Generate a cache key for storing waybills.
     *
     * @param string $prefix
     * @param array $parameters
     * @return string
     */
    protected function getCacheKey(string $prefix, array $parameters = []): string
    {
        return $prefix . '_' . md5(serialize($parameters));
    }
}
