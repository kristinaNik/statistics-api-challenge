<?php

namespace App\Tests\Functional;

use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Faker\Factory;

class HotelEndpointsTest extends AbstractEndpointTest
{
    private const HOST = 'http://statistics-api.local';
    private const HOTEL_RESPONSE = '{"name" : "%s"}';
    private const DELETE_RESPONSE = '{"message" : "Resource successfully deleted"}';

    public function testGetHotels(): void
    {
        $response = $this->getResponseFromRequest(Request::METHOD_GET , 'api/hotels.json');
        $responseContent = $response->getContent();
        $responseDecoded = json_decode($responseContent);

        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());
        self::assertJson($responseContent);
        self::assertNotEmpty($responseDecoded);

    }

    public function testPostHotels(): void
    {
        $apiResponse =  new MockResponse($this->getPayload());

        $httpClient = new MockHttpClient($apiResponse);
        $response = $httpClient->request(Request::METHOD_POST,
            self::HOST . '/api/hotels',
            ['ACCEPT' => 'application/json', 'CONTENT_TYPE' => 'application/json']);
        $responseContent = $response->getContent();
        $responseDecoded = json_decode($responseContent);

        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());
        self::assertJson($responseContent);
        self::assertNotEmpty($responseDecoded);

    }

    public function testPutHotels(): void
    {
        $apiResponse =  new MockResponse($this->getPayload());

        $httpClient = new MockHttpClient($apiResponse);
        $response = $httpClient->request(Request::METHOD_PUT ,
            self::HOST . '/api/hotels/' . $this->getHotelId(),
            ['ACCEPT' => 'application/json', 'CONTENT_TYPE' => 'application/json']);

        $responseContent = $response->getContent();
        $responseDecoded = json_decode($responseContent);

        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());
        self::assertJson($responseContent);
        self::assertNotEmpty($responseDecoded);
    }


    public function testDeleteHotels(): void
    {
        $apiResponse =  new MockResponse(self::DELETE_RESPONSE);

        $httpClient = new MockHttpClient($apiResponse);
        $response = $httpClient->request(Request::METHOD_DELETE ,
            self::HOST . '/api/hotels/' . $this->getHotelId(),
            ['ACCEPT' => 'application/json', 'CONTENT_TYPE' => 'application/json']);

        $responseContent = $response->getContent();
        $responseDecoded = json_decode($responseContent);

        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());
        self::assertJson($responseContent);
        self::assertNotEmpty($responseDecoded);
    }


    public function getHotelId(): int
    {
        $faker = Factory::create();

        return $faker->numberBetween(1,100);
    }

    private function getPayload(): string
    {
        $faker = Factory::create();

        return sprintf(self::HOTEL_RESPONSE,  $faker->name);
    }
}
