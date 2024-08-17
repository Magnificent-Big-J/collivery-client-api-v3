<?php

namespace Rainwaves\Api;

use Rainwaves\Exceptions\ColliveryException;

class Country extends BaseApi
{
    /**
     * Get a list of countries.
     *
     * @param array $parameters
     * @return array
     * @throws ColliveryException
     */
    public function getCountries(array $parameters = []): array
    {
        return $this->handleRequest('GET', '/countries', $parameters);
    }

    /**
     * Get details of a specific country by ID.
     *
     * @param int $countryId
     * @return array
     * @throws ColliveryException
     */
    public function getCountryById(int $countryId): array
    {
        return $this->handleRequest('GET', "/countries/{$countryId}");
    }
}
