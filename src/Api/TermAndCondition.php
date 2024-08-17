<?php

namespace Rainwaves\Api;

use Rainwaves\Exceptions\ColliveryException;

class TermAndCondition extends BaseApi
{
    /**
     * Get a list of terms and conditions.
     *
     * @param array $parameters
     * @return array
     * @throws ColliveryException
     */
    public function getTermsAndConditions(array $parameters = []): array
    {
        return $this->handleRequest('GET', '/terms_and_conditions', $parameters);
    }

    /**
     * Get details of specific terms and conditions by ID.
     *
     * @param int $termId
     * @return array
     * @throws ColliveryException
     */
    public function getTermAndConditionById(int $termId): array
    {
        return $this->handleRequest('GET', "/terms_and_conditions/{$termId}");
    }
}
