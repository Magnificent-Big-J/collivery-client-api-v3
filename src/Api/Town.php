<?php

namespace Rainwaves\Api;

use Rainwaves\Exceptions\ColliveryException;

class Town extends BaseApi
{
    /**
     * Get a list of towns.
     *
     * @param array $parameters
     * @return array
     * @throws ColliveryException
     */
    public function getTowns(array $parameters = []): array
    {
        return $this->handleRequest('GET', '/towns', $parameters);
    }

    /**
     * Get details of a specific town by ID.
     *
     * @param int $townId
     * @return array
     * @throws ColliveryException
     */
    public function getTownById(int $townId): array
    {
        return $this->handleRequest('GET', "/towns/{$townId}");
    }

    /**
     * Search for towns based on given criteria.
     *
     * @param string $searchTerm
     * @return array
     * @throws ColliveryException
     */
    public function searchTowns(string $searchTerm): array
    {
        $parameters = ['search' => $searchTerm];
        return $this->handleRequest('GET', '/towns/search', $parameters);
    }
}
