<?php

namespace Rainwaves\Api;

use Rainwaves\Exceptions\ColliveryException;

class PredifinedParcel extends BaseApi
{
    /**
     * Get a list of predefined parcels.
     *
     * @param array $parameters
     * @return array
     * @throws ColliveryException
     */
    public function getPredefinedParcels(array $parameters = []): array
    {
        return $this->handleRequest('GET', '/predefined_parcels', $parameters);
    }

    /**
     * Get details of a specific predefined parcel by ID.
     *
     * @param int $parcelId
     * @return array
     * @throws ColliveryException
     */
    public function getPredefinedParcelById(int $parcelId): array
    {
        return $this->handleRequest('GET', "/predefined_parcels/{$parcelId}");
    }
}
