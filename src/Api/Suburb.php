<?php

namespace Rainwaves\Api;

use Rainwaves\Exceptions\ColliveryException;

class Suburb extends BaseApi
{
    /**
     * Get a list of suburbs.
     *
     * @param array $parameters
     * @return array
     * @throws ColliveryException
     */
    public function getSuburbs(array $parameters = []): array
    {
        return $this->handleRequest('GET', '/suburbs', $parameters);
    }

    /**
     * Get details of a specific suburb by ID.
     *
     * @param int $suburbId
     * @return array
     * @throws ColliveryException
     */
    public function getSuburbById(int $suburbId): array
    {
        return $this->handleRequest('GET', "/suburbs/{$suburbId}");
    }

    /**
     * Search for suburbs based on given criteria.
     *
     * @param string $searchTerm
     * @return array
     * @throws ColliveryException
     */
    public function searchSuburbs(string $searchTerm): array
    {
        $parameters = ['search' => $searchTerm];
        return $this->handleRequest('GET', '/suburbs/search', $parameters);
    }
}
