<?php

namespace Rainwaves\Api;

use Rainwaves\Exceptions\ColliveryException;

class VendorWaybill extends BaseApi
{
    /**
     * Get a list of vendor waybills.
     *
     * @param array $parameters
     * @return array
     * @throws ColliveryException
     */
    public function getVendorWaybills(array $parameters = []): array
    {
        return $this->handleRequest('GET', '/vendor_waybills', $parameters);
    }

    /**
     * Get details of a specific vendor waybill by ID.
     *
     * @param int $waybillId
     * @return array
     * @throws ColliveryException
     */
    public function getVendorWaybillById(int $waybillId): array
    {
        return $this->handleRequest('GET', "/vendor_waybills/{$waybillId}");
    }
}
