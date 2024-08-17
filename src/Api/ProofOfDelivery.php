<?php

namespace Rainwaves\Api;

use Rainwaves\Exceptions\ColliveryException;

class ProofOfDelivery extends BaseApi
{
    /**
     * Get a list of proofs of delivery.
     *
     * @param array $parameters
     * @return array
     * @throws ColliveryException
     */
    public function getProofsOfDelivery(array $parameters = []): array
    {
        return $this->handleRequest('GET', '/proofs_of_delivery', $parameters);
    }

    /**
     * Get details of a specific proof of delivery by ID.
     *
     * @param int $proofId
     * @return array
     * @throws ColliveryException
     */
    public function getProofOfDeliveryById(int $proofId): array
    {
        return $this->handleRequest('GET', "/proofs_of_delivery/{$proofId}");
    }
}
