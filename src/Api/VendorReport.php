<?php

namespace Rainwaves\Api;

use Rainwaves\Exceptions\ColliveryException;

class VendorReport extends BaseApi
{
    /**
     * Get a list of vendor reports.
     *
     * @param array $parameters
     * @return array
     * @throws ColliveryException
     */
    public function getVendorReports(array $parameters = []): array
    {
        return $this->handleRequest('GET', '/vendor_reports', $parameters);
    }

    /**
     * Get details of a specific vendor report by ID.
     *
     * @param int $reportId
     * @return array
     * @throws ColliveryException
     */
    public function getVendorReportById(int $reportId): array
    {
        return $this->handleRequest('GET', "/vendor_reports/{$reportId}");
    }
}
