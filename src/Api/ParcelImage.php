<?php

namespace Rainwaves\Api;

use Rainwaves\Exceptions\ColliveryException;

class ParcelImage extends BaseApi
{
    /**
     * Get a list of parcel images.
     *
     * @param array $parameters
     * @return array
     * @throws ColliveryException
     */
    public function getParcelImages(array $parameters = []): array
    {
        return $this->handleRequest('GET', '/parcel_images', $parameters);
    }

    /**
     * Get details of a specific parcel image by ID.
     *
     * @param int $imageId
     * @return array
     * @throws ColliveryException
     */
    public function getParcelImageById(int $imageId): array
    {
        return $this->handleRequest('GET', "/parcel_images/{$imageId}");
    }
}
