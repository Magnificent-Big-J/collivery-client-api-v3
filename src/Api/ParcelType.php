<?php

namespace Rainwaves\Api;

use Rainwaves\Exceptions\ColliveryException;

class ParcelType extends BaseApi
{
    /**
     * Get a list of parcel types.
     *
     * @param array $parameters
     * @return array
     * @throws ColliveryException
     */
    public function getParcelTypes(array $parameters = []): array
    {
        return $this->handleRequest('GET', '/parcel_types', $parameters);
    }

    /**
     * Get details of a specific parcel type by ID.
     *
     * @param int $parcelTypeId
     * @return array
     * @throws ColliveryException
     */
    public function getParcelTypeById(int $parcelTypeId): array
    {
        return $this->handleRequest('GET', "/parcel_types/{$parcelTypeId}");
    }
}
