<?php

namespace App\Controller;

use App\Services\StatisticsService;
use Carbon\Carbon;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class StatisticsController extends AbstractController
{
    private $service;

    public function __construct(StatisticsService $service)
    {
        $this->service = $service;
    }

    /**
     * @Route("api/statistics/hotel/{hotelId}/overtime", name="statistics_hotel_overtime")
     *
     * @param Request $request
     * @param $hotelId
     * @param SerializerInterface $serializer
     * @return JsonResponse
     */
    public function index(Request $request, $hotelId, SerializerInterface $serializer): JsonResponse
    {
        $dateFrom = Carbon::parse($request->query->get('date_from'))->toDate();
        $dateTo =   Carbon::parse($request->query->get('date_to'))->toDate();

        $json = $serializer->serialize($this->service->getCountReviews($dateFrom, $dateTo, $hotelId), 'json');

        return new JsonResponse($json, 200, [],true);
    }
}
