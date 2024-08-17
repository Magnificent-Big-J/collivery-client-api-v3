<?php

namespace Rainwaves\Api;

use Rainwaves\Exceptions\ColliveryException;

class LocationType extends BaseApi
{
    /**
     * Get a list of location types.
     *
     * @param array $parameters
     * @return array
     * @throws ColliveryException
     */
    public function getLocationTypes(array $parameters = []): array
    {
        return $this->handleRequest('GET', '/location_types', $parameters);
    }

    /**
     * Get details of a specific location type by ID.
     *
     * @param int $locationTypeId
     * @return array
     * @throws ColliveryException
     */
    public function getLocationTypeById(int $locationTypeId): array
    {
        return $this->handleRequest('GET', "/location_types/{$locationTypeId}");
    }
}
