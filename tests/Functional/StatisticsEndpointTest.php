<?php

namespace App\Tests;

use App\Tests\Functional\AbstractEndpointTest;
use Carbon\Carbon;
use Faker\Factory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class StatisticsEndpointTest extends AbstractEndpointTest
{
    private const ID = 50;
    private const DATES = "date_from=2019-10-01&date_to=2020-10-05";

    public function testGetStatistics()
    {
        $response = $this->getResponseFromRequest(Request::METHOD_GET ,
            'api/statistics/hotel/' . self::ID . '/overtime.json?' . self::DATES);
        $responseContent = $response->getContent();
        $responseDecoded = json_decode($responseContent);

        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());
        self::assertJson($responseContent);
        self::assertNotEmpty($responseDecoded);
    }


}
