<?php

namespace Rainwaves\Api;

use Rainwaves\Exceptions\ColliveryException;
use Illuminate\Support\Facades\Cache;

class Contact extends BaseApi
{
    /**
     * Retrieve all contacts.
     *
     * @param array $parameters
     * @return array
     */
    public function getContacts(array $parameters = []): array
    {
        $cacheKey = $this->getCacheKey('contacts', $parameters);

        return Cache::remember($cacheKey, now()->addMinutes(30), function () use ($parameters) {
            return $this->handleRequest('get', '/contacts', $parameters);
        });
    }

    /**
     * Retrieve a specific contact by ID.
     *
     * @param int $id
     * @return array
     */
    public function getContactById(int $id): array
    {
        $cacheKey = "collivery_contact_{$id}";

        return Cache::remember($cacheKey, now()->addMinutes(30), function () use ($id) {
            return $this->handleRequest('get', "/contacts/{$id}");
        });
    }

    /**
     * Create a new contact.
     *
     * @param array $data
     * @return array
     * @throws ColliveryException
     */
    public function createContact(array $data): array
    {
        return $this->handleRequest('post', '/contacts', [], $data);
    }

    /**
     * Update an existing contact.
     *
     * @param int $id
     * @param array $data
     * @return array
     * @throws ColliveryException
     */
    public function updateContact(int $id, array $data): array
    {
        return $this->handleRequest('put', "/contacts/{$id}", [], $data);
    }

    /**
     * Delete a contact.
     *
     * @param int $id
     * @return array
     * @throws ColliveryException
     */
    public function deleteContact(int $id): array
    {
        return $this->handleRequest('delete', "/contacts/{$id}");
    }

    /**
     * Generate a cache key for storing contacts.
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
