<?php

namespace Rainwaves\Api;

use Rainwaves\Exceptions\ColliveryException;

class Status extends BaseApi
{
    /**
     * Get a list of statuses.
     *
     * @param array $parameters
     * @return array
     * @throws ColliveryException
     */
    public function getStatuses(array $parameters = []): array
    {
        return $this->handleRequest('GET', '/statuses', $parameters);
    }

    /**
     * Get details of a specific status by ID.
     *
     * @param int $statusId
     * @return array
     * @throws ColliveryException
     */
    public function getStatusById(int $statusId): array
    {
        return $this->handleRequest('GET', "/statuses/{$statusId}");
    }
}
