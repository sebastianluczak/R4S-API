<?php
// api/tests/BooksTest.php

namespace App\Tests;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\HairdresserStall;
use App\Entity\Reservation;

class ReservationsTest extends ApiTestCase
{
    public function testLogin(): string
    {
        $response = static::createClient()->request('POST', '/authentication_token', ['json' => [
            'email' => 'test@example.com',
            'password' => 'password123',
        ]]);

        $this->assertResponseIsSuccessful();

        $responseObject = json_decode($response->getContent());
        $this->assertIsObject($responseObject);
        $this->assertIsString($responseObject->token);

        return $responseObject->token;
    }

    /**
     * @depends testLogin
     */
    public function testHairdresserStallGet(string $token): array
    {
        $response = static::createClient()->request('GET', '/api/hairdresser_stalls', [
            'headers' => [
                'Authorization' => 'Bearer '.$token
            ]
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
        $this->assertCount(2, $response->toArray()['hydra:member']);
        $this->assertMatchesResourceCollectionJsonSchema(HairdresserStall::class);

        return $response->toArray()['hydra:member'][0];
    }

    /**
     * @depends testLogin
     * @depends testHairdresserStallGet
     */
    public function testReservationSuccessfulCreate(string $token, array $hairdresserStall): void
    {
        $response = static::createClient()->request('POST', '/api/reservations', [
            'json' => [
                'hairdresserStall' => $hairdresserStall['@id'],
                'startDate' => "2020-04-17T08:30:00.000Z",
                'endDate' => "2020-04-17T19:30:00.000Z",
            ],
            'headers' => [
                'Authorization' => 'Bearer '.$token
            ]
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
    }

    /**
     * @depends testLogin
     * @depends testHairdresserStallGet
     */
    public function testReservationOverlappingFailedCreate(string $token, array $hairdresserStall): void
    {
        $response = static::createClient()->request('POST', '/api/reservations', [
            'json' => [
                'hairdresserStall' => $hairdresserStall['@id'],
                'startDate' => "2020-04-17T08:00:00.000Z",
                'endDate' => "2020-04-17T09:30:00.000Z",
            ],
            'headers' => [
                'Authorization' => 'Bearer '.$token
            ]
        ]);

        $this->assertResponseStatusCodeSame(400);
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
    }

    /**
     * @depends testLogin
     * @depends testHairdresserStallGet
     */
    public function testReservationTwiceFailedCreate(string $token, array $hairdresserStall): void
    {
        $response = static::createClient()->request('POST', '/api/reservations', [
            'json' => [
                'hairdresserStall' => $hairdresserStall['@id'],
                'startDate' => "2020-04-17T08:30:00.000Z",
                'endDate' => "2020-04-17T19:30:00.000Z",
            ],
            'headers' => [
                'Authorization' => 'Bearer '.$token
            ]
        ]);

        $this->assertResponseStatusCodeSame(400);
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
    }

    /**
     * @depends testLogin
     * @depends testHairdresserStallGet
     */
    public function testReservationExceedingFailedCreate(string $token, array $hairdresserStall): void
    {
        $response = static::createClient()->request('POST', '/api/reservations', [
            'json' => [
                'hairdresserStall' => $hairdresserStall['@id'],
                'startDate' => "2020-04-17T09:00:00.000Z",
                'endDate' => "2020-04-17T20:00:00.000Z",
            ],
            'headers' => [
                'Authorization' => 'Bearer '.$token
            ]
        ]);

        $this->assertResponseStatusCodeSame(400);
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
    }

    /**
     * @depends testLogin
     * @depends testHairdresserStallGet
     */
    public function testReservationFailedCreate(string $token, array $hairdresserStall): void
    {
        $response = static::createClient()->request('POST', '/api/reservations', [
            'json' => [
                'hairdresserStall' => $hairdresserStall['@id'],
                'startDate' => "2020-04-17T06:22:00.000Z",
                'endDate' => "2020-04-17T23:10:00.000Z",
            ],
            'headers' => [
                'Authorization' => 'Bearer '.$token
            ]
        ]);

        $this->assertResponseStatusCodeSame(400);
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
    }

    /**
     * @depends testLogin
     * @depends testReservationSuccessfulCreate
     */
    public function testGetCollection(string $token): void
    {
        $response = static::createClient()->request('GET', '/api/reservations', [
            'headers' => [
                'Authorization' => 'Bearer '.$token
            ]
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
        $this->assertMatchesResourceCollectionJsonSchema(Reservation::class);
    }
}