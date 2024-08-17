<?php

namespace Rainwaves\Api;

use Rainwaves\Exceptions\ColliveryException;

class WaybillDocument extends BaseApi
{
    /**
     * Get a list of waybill documents.
     *
     * @param array $parameters
     * @return array
     * @throws ColliveryException
     */
    public function getWaybillDocuments(array $parameters = []): array
    {
        return $this->handleRequest('GET', '/waybill_documents', $parameters);
    }

    /**
     * Get details of a specific waybill document by ID.
     *
     * @param int $documentId
     * @return array
     * @throws ColliveryException
     */
    public function getWaybillDocumentById(int $documentId): array
    {
        return $this->handleRequest('GET', "/waybill_documents/{$documentId}");
    }
}
