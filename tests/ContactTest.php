<?php

namespace Rainwaves\Tests;

use Orchestra\Testbench\TestCase;
use Rainwaves\Api\Auth;
use Rainwaves\Api\Contact;
use Rainwaves\Exceptions\ColliveryException;
use Illuminate\Support\Facades\Cache;
use Rainwaves\Interfaces\HttpClientInterface;

class ContactTest extends TestCase
{
    protected $httpClient;

    protected function setUp(): void
    {
        parent::setUp();

        $this->httpClient = $this->createMock(HttpClientInterface::class);
    }

    public function test_it_can_retrieve_and_cache_contacts()
    {
        $expectedContacts = [['id' => 1, 'full_name' => 'John Doe']];
        $this->httpClient->method('get')
            ->willReturn([
                'status_code' => 200,
                'data' => $expectedContacts
            ]);

        $contactService = new Contact($this->httpClient, $this->getMockAuth());
        $contacts = $contactService->getContacts();

        $this->assertEquals($expectedContacts, $contacts);
        $this->assertEquals($expectedContacts, Cache::get('contacts_' . md5(serialize([]))));
    }

    public function test_it_uses_cached_contacts_if_available()
    {
        $cachedContacts = [['id' => 1, 'full_name' => 'John Cached']];
        Cache::put('contacts_' . md5(serialize([])), $cachedContacts, now()->addMinutes(30));

        $contactService = new Contact($this->httpClient, $this->getMockAuth());
        $contacts = $contactService->getContacts();

        $this->assertEquals($cachedContacts, $contacts);
    }

    public function test_it_can_retrieve_contact_by_id_and_cache_it()
    {
        $expectedContact = ['id' => 1, 'full_name' => 'John Doe'];
        $this->httpClient->method('get')
            ->willReturn([
                'status_code' => 200,
                'data' => $expectedContact
            ]);

        $contactService = new Contact($this->httpClient, $this->getMockAuth());
        $contact = $contactService->getContactById(1);

        $this->assertEquals($expectedContact, $contact);
        $this->assertEquals($expectedContact, Cache::get('collivery_contact_1'));
    }

    public function test_it_throws_exception_on_failed_request()
    {
        $this->httpClient->method('get')
            ->will($this->throwException(new \Exception('API error')));

        $this->expectException(ColliveryException::class);

        $contactService = new Contact($this->httpClient, $this->getMockAuth());
        $contactService->getContacts();
    }

    /**
     * @throws ColliveryException
     */
    public function test_it_can_create_contact_with_provided_payload()
    {
        $contactPayload = [
            'address_id' => 952,
            'email' => 'foo@example.com',
            'full_name' => 'John Doe',
            'cell_no' => '0721234567',
            'cellphone' => '0721234567',
            'work_no' => null,
            'work_phone' => null,
        ];

        $expectedResponse = array_merge(['id' => 1], $contactPayload);
        $this->httpClient->method('post')
            ->willReturn([
                'status_code' => 200,
                'data' => $expectedResponse
            ]);

        $contactService = new Contact($this->httpClient, $this->getMockAuth());
        $response = $contactService->createContact($contactPayload);

        $this->assertEquals($expectedResponse, $response);
    }

    /**
     * @throws ColliveryException
     */
    public function test_it_can_update_contact()
    {
        $updatedData = ['full_name' => 'Jane Doe'];
        $expectedResponse = ['id' => 1, 'full_name' => 'Jane Doe'];
        $this->httpClient->method('put')
            ->willReturn([
                'status_code' => 200,
                'data' => $expectedResponse
            ]);

        $contactService = new Contact($this->httpClient, $this->getMockAuth());
        $response = $contactService->updateContact(1, $updatedData);

        $this->assertEquals($expectedResponse, $response);
    }

    /**
     * @throws ColliveryException
     */
    public function test_it_can_delete_contact()
    {
        $expectedResponse = ['status' => 'success'];
        $this->httpClient->method('delete')
            ->willReturn([
                'status_code' => 200,
                'data' => $expectedResponse
            ]);

        $contactService = new Contact($this->httpClient, $this->getMockAuth());
        $response = $contactService->deleteContact(1);

        // Assert
        $this->assertEquals($expectedResponse, $response);
    }

    /**
     * Mock the Auth instance.
     *
     * @return Auth
     */
    protected function getMockAuth(): Auth
    {
        $auth = $this->createMock(Auth::class);
        $auth->method('getToken')->willReturn('mock_token');
        return $auth;
    }
}
