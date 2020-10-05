<?php

namespace App\Tests;

use App\Tests\Functional\AbstractEndpointTest;
use Faker\Factory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class StatisticsEndpointTest extends AbstractEndpointTest
{
    private const DATES = "date_from=2019-10-01&date_to=2020-10-05";

    public function testGetStatistics(): void
    {
        $response = $this->getResponseFromRequest(Request::METHOD_GET ,
            'api/statistics/hotel/' .$this->getHotelId(). '/overtime.json?' . self::DATES);
        $responseContent = $response->getContent();
        $responseDecoded = json_decode($responseContent);

        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());
        self::assertJson($responseContent);
        self::assertNotEmpty($responseDecoded);
    }

    public function getHotelId(): int
    {
        $faker = Factory::create();

        return $faker->numberBetween(1,11);
    }


}
