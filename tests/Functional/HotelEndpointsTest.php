<?php

namespace App\Tests\Functional;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Faker\Factory;

class HotelEndpointsTest extends AbstractEndpointTest
{
    private $hotelPayload = '{"name" : "%s"}';

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
        $response = $this->getResponseFromRequest(
            Request::METHOD_POST , 'api/hotels.json',
            $this->getPayload()
        );
        $responseContent = $response->getContent();
        $responseDecoded = json_decode($responseContent);

        self::assertEquals(Response::HTTP_CREATED, $response->getStatusCode());
        self::assertJson($responseContent);
        self::assertNotEmpty($responseDecoded);

    }

    private function getPayload(): string
    {
        $faker = Factory::create();

        return sprintf($this->hotelPayload,  $faker->name);
    }
}
