<?php

namespace Rainwaves\Api;

use Rainwaves\Exceptions\ColliveryException;

class BatteryType extends BaseApi
{
    /**
     * Get a list of battery types.
     *
     * @param array $parameters
     * @return array
     * @throws ColliveryException
     */
    public function getBatteryTypes(array $parameters = []): array
    {
        return $this->handleRequest('GET', '/battery_types', $parameters);
    }

    /**
     * Get details of a specific battery type by ID.
     *
     * @param int $batteryTypeId
     * @return array
     * @throws ColliveryException
     */
    public function getBatteryTypeById(int $batteryTypeId): array
    {
        return $this->handleRequest('GET', "/battery_types/{$batteryTypeId}");
    }
}
