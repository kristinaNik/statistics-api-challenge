<?php

namespace App\Tests\Functional;

use Liip\FunctionalTestBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

abstract class AbstractEndpointTest extends WebTestCase
{
    private $serverInformation = ['ACCEPT' => 'application/json', 'CONTENT_TYPE' => 'application/json'];

    public function getResponseFromRequest(string $method, string $uri, string $payload = '') : Response
    {
        $client = self::createClient();
        $client->request(
            $method,
            $uri,
            [],
            [],
            $this->serverInformation,
            $payload
        );

        return $client->getResponse();
    }
}
