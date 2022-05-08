<?php

namespace App\Tests;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\Contacts;

class ContactsTest extends ApiTestCase
{
    // Validate case of Get Collection
    public function testGetCollection(): void
    {
        static::createClient()->request('GET', '/api/v1/contacts');

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
    }

    // Validate case of Record Not Found
    public function testGetResourceNotFound(): void
    {
        static::createClient()->request('GET', '/api/v1/contacts/99');

        $this->assertResponseStatusCodeSame(404);
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
    }


    // Validate case of Creat Record with empty params
    public function testCreateContactWithEmptyParams(): void
    {
        $response = static::createClient()->request('POST', '/api/v1/contacts', [
            'headers' => [
                'Content-Type' => 'multipart/form-data',
            ],
            'extra' => [
                'parameters' => []
            ]
        ]);

        $this->assertResponseStatusCodeSame(422);
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
    }

    // Validate case of Creat Record
    public function testCreateContact(): void
    {
        $response = static::createClient()->request('POST', '/api/v1/contacts', [
            'headers' => [
                'Content-Type' => 'multipart/form-data',
            ],
            'extra' => [
                'parameters' => [
                    'firstname' => 'Aun',
                    'lastname' => 'Abbas',
                    'country' => 'Pakistan',
                    'city' => 'Karachi',
                    'street' => '14th street',
                    'zipcode' => '75080',
                    'phone' => '033-2302-5063',
                    'birthday' => '1990-02-26',
                    'email' => 'syedaun.abbasrizvi@gmail.com'
                ]
            ]
        ]);

        $this->assertResponseStatusCodeSame(201);
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
    }

    // Validate case of Duplicate Email
    public function testCreateDuplicateEmail(): void
    {
        $response = static::createClient()->request('POST', '/api/v1/contacts', [
            'headers' => [
                'Content-Type' => 'multipart/form-data',
            ],
            'extra' => [
                'parameters' => [
                    'firstname' => 'Aun',
                    'lastname' => 'Abbas',
                    'country' => 'Pakistan',
                    'city' => 'Karachi',
                    'street' => '14th street',
                    'zipcode' => '75080',
                    'phone' => '123-1234-5678',
                    'birthday' => '1990-02-26',
                    'email' => 'syedaun.abbasrizvi@gmail.com'
                ]
            ]
        ]);

        $this->assertResponseStatusCodeSame(422);
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
    }

    // Validate case of Duplicate Phone
    public function testCreateDuplicatePhone(): void
    {
        $response = static::createClient()->request('POST', '/api/v1/contacts', [
            'headers' => [
                'Content-Type' => 'multipart/form-data',
            ],
            'extra' => [
                'parameters' => [
                    'firstname' => 'Aun',
                    'lastname' => 'Abbas',
                    'country' => 'Pakistan',
                    'city' => 'Karachi',
                    'street' => '14th street',
                    'zipcode' => '75080',
                    'phone' => '033-2302-5063',
                    'birthday' => '1990-02-26',
                    'email' => 'syedaun.abbasrizvi+1@gmail.com'
                ]
            ]
        ]);

        $this->assertResponseStatusCodeSame(422);
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
    }

    // Validate case of Record Found
    public function testGetResourcFound(): void
    {
        static::createClient()->request('GET', '/api/v1/contacts/1');

        $this->assertResponseStatusCodeSame(200);
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
    }
}
