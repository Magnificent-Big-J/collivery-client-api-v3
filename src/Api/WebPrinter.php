<?php

namespace Rainwaves\Api;

use Rainwaves\Exceptions\ColliveryException;

class WebPrinter extends BaseApi
{
    /**
     * Get a list of available printers.
     *
     * @param array $parameters
     * @return array
     * @throws ColliveryException
     */
    public function getPrinters(array $parameters = []): array
    {
        return $this->handleRequest('GET', '/web_printers', $parameters);
    }

    /**
     * Send a print job to a specific printer.
     *
     * @param int $printerId
     * @param array $printData
     * @return array
     * @throws ColliveryException
     */
    public function printDocument(int $printerId, array $printData): array
    {
        return $this->handleRequest('POST', "/web_printers/{$printerId}/print", [], $printData);
    }
}
