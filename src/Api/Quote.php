<?php

namespace Rainwaves\Api;

use Rainwaves\Exceptions\ColliveryException;
use Illuminate\Support\Facades\Cache;

class Quote extends BaseApi
{
    /**
     * Retrieve all quotes.
     *
     * @param array $parameters
     * @return array
     */
    public function getQuotes(array $parameters = []): array
    {
        $cacheKey = $this->getCacheKey('quotes', $parameters);

        return Cache::remember($cacheKey, now()->addMinutes(30), function () use ($parameters) {
            return $this->handleRequest('get', '/quotes', $parameters);
        });
    }

    /**
     * Retrieve a specific quote by ID.
     *
     * @param int $id
     * @return array
     */
    public function getQuoteById(int $id): array
    {
        $cacheKey = "collivery_quote_{$id}";

        return Cache::remember($cacheKey, now()->addMinutes(30), function () use ($id) {
            return $this->handleRequest('get', "/quotes/{$id}");
        });
    }

    /**
     * Create a new quote.
     *
     * @param array $data
     * @return array
     * @throws ColliveryException
     */
    public function createQuote(array $data): array
    {
        return $this->handleRequest('post', '/quotes', [], $data);
    }

    /**
     * Update an existing quote.
     *
     * @param int $id
     * @param array $data
     * @return array
     * @throws ColliveryException
     */
    public function updateQuote(int $id, array $data): array
    {
        return $this->handleRequest('put', "/quotes/{$id}", [], $data);
    }

    /**
     * Delete a quote.
     *
     * @param int $id
     * @return array
     * @throws ColliveryException
     */
    public function deleteQuote(int $id): array
    {
        return $this->handleRequest('delete', "/quotes/{$id}");
    }

    /**
     * Generate a cache key for storing quotes.
     *
     * @param string $prefix
     * @param array $parameters
     * @return string
     */
    protected function getCacheKey(string $prefix, array $parameters = []): string
    {
        return $prefix . '_' . md5(serialize($parameters));
    }
}
