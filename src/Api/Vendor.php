<?php

namespace Rainwaves\Api;

use Rainwaves\Exceptions\ColliveryException;

class Vendor extends BaseApi
{
    /**
     * Get a list of vendors.
     *
     * @param array $parameters
     * @return array
     * @throws ColliveryException
     */
    public function getVendors(array $parameters = []): array
    {
        return $this->handleRequest('GET', '/vendors', $parameters);
    }

    /**
     * Get details of a specific vendor by ID.
     *
     * @param int $vendorId
     * @return array
     * @throws ColliveryException
     */
    public function getVendorById(int $vendorId): array
    {
        return $this->handleRequest('GET', "/vendors/{$vendorId}");
    }
}
