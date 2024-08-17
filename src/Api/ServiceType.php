<?php

namespace Rainwaves\Api;

use Rainwaves\Exceptions\ColliveryException;

class ServiceType extends BaseApi
{
    /**
     * Get a list of service types.
     *
     * @param array $parameters
     * @return array
     * @throws ColliveryException
     */
    public function getServiceTypes(array $parameters = []): array
    {
        return $this->handleRequest('GET', '/service_types', $parameters);
    }

    /**
     * Get details of a specific service type by ID.
     *
     * @param int $serviceTypeId
     * @return array
     * @throws ColliveryException
     */
    public function getServiceTypeById(int $serviceTypeId): array
    {
        return $this->handleRequest('GET', "/service_types/{$serviceTypeId}");
    }
}
