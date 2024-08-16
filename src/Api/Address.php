<?php

namespace Rainwaves\Api;

use Rainwaves\Helpers\HttpClientInterface;
use Rainwaves\Exceptions\ColliveryException;
use Illuminate\Support\Facades\Cache;

class Address extends BaseApi
{
    /**
     * Retrieve all addresses.
     *
     * @param array $parameters
     * @return array
     */
    public function getAddresses(array $parameters = []): array
    {
        $cacheKey = $this->getCacheKey('addresses', $parameters);

        return Cache::remember($cacheKey, now()->addMinutes(30), function () use ($parameters) {
            return $this->handleRequest('get', '/addresses', $parameters);
        });
    }

    /**
     * Retrieve a specific address by ID.
     *
     * @param int $id
     * @return array
     */
    public function getAddressById(int $id): array
    {
        $cacheKey = "collivery_address_{$id}";

        return Cache::remember($cacheKey, now()->addMinutes(30), function () use ($id) {
            return $this->handleRequest('get', "/addresses/{$id}");
        });
    }

    /**
     * Create a new address.
     *
     * @param array $data
     * @return array
     * @throws ColliveryException
     */
    public function createAddress(array $data): array
    {
        return $this->handleRequest('post', '/addresses', [], $data);
    }

    /**
     * Update an existing address.
     *
     * @param int $id
     * @param array $data
     * @return array
     * @throws ColliveryException
     */
    public function updateAddress(int $id, array $data): array
    {
        return $this->handleRequest('put', "/addresses/{$id}", [], $data);
    }

    /**
     * Delete an address.
     *
     * @param int $id
     * @return array
     * @throws ColliveryException
     */
    public function deleteAddress(int $id): array
    {
        return $this->handleRequest('delete', "/addresses/{$id}");
    }

    /**
     * Generate a cache key for storing addresses.
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
