<?php

namespace App\Tests\Functional;

use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Faker\Factory;

class ReviewEndpointsTest extends AbstractEndpointTest
{
    private const HOST = 'http://statistics-api.local';
    private const REVIEW_RESPONSE = '{"id" : %d,
                              "hotel" : {"name" : "%s", "createdAt" : "%s", "updatedAt" : "%s"},
                              "score" : %d,
                              "comment" : "%s",
                              "createdDate" : "%s",
                              "createdAt" : "%s",
                              "updatedAt" :"%s"}';
    private const DELETE_RESPONSE = '{"message" : "Resource successfully deleted"}';

    public function testGetReviews(): void
    {
        $response = $this->getResponseFromRequest(Request::METHOD_GET , 'api/reviews.json');
        $responseContent = $response->getContent();
        $responseDecoded = json_decode($responseContent);

        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());
        self::assertJson($responseContent);
        self::assertNotEmpty($responseDecoded);
    }

    public function testPostReviews(): void
    {
        $apiResponse =  new MockResponse($this->getPayload());

        $httpClient = new MockHttpClient($apiResponse);
        $response = $httpClient->request(Request::METHOD_POST ,
            self::HOST . '/api/reviews',
            ['ACCEPT' => 'application/json', 'CONTENT_TYPE' => 'application/json']);

        $responseContent = $response->getContent();
        $responseDecoded = json_decode($responseContent);

        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());
        self::assertJson($responseContent);
        self::assertNotEmpty($responseDecoded);
    }

    public function testPutReviews(): void
    {
        $apiResponse =  new MockResponse($this->getPayload());

        $httpClient = new MockHttpClient($apiResponse);
        $response = $httpClient->request(Request::METHOD_PUT ,
            self::HOST . '/api/reviews/' . $this->getReviewId(),
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
            self::HOST . '/api/reviews/' . $this->getReviewId(),
            ['ACCEPT' => 'application/json', 'CONTENT_TYPE' => 'application/json']);

        $responseContent = $response->getContent();
        $responseDecoded = json_decode($responseContent);

        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());
        self::assertJson($responseContent);
        self::assertNotEmpty($responseDecoded);
    }

    public function getReviewId(): int
    {
        $faker = Factory::create();

        return $faker->numberBetween(1,100);
    }

    private function getPayload(): string
    {
        $faker = Factory::create();

        return str_replace('\n', '',sprintf(self::REVIEW_RESPONSE,
            $faker->numberBetween(1,11),
            $faker->name,
            $faker->date('Y-m-d'),
            $faker->date('Y-m-d'),
            $faker->numberBetween(0, 5),
            $faker->text,
            $faker->text,
            $faker->date('Y-m-d'),
            $faker->date('Y-m-d'),
            $faker->date('Y-m-d')
        ));

    }
}
