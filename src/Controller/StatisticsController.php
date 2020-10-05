<?php

namespace App\Controller;

use App\Interfaces\iStatistics;
use App\Services\StatisticsService;
use Carbon\Carbon;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class StatisticsController extends AbstractController
{
    /**
     * @var iStatistics|StatisticsService
     */
    private $service;

    /**
     * StatisticsController constructor.
     * @param iStatistics $service
     */
    public function __construct(iStatistics $service)
    {
        $this->service = $service;
    }

    /**
     * @Route("api/statistics/hotel/{hotelId}/overtime.{_format}",
     *     format="json",
     *     requirements={
     *         "_format": "json",
     *     },
     *     name="statistics_hotel_overtime",
     *     methods={"GET"})
     *
     * @param Request $request
     * @param $hotelId
     * @param SerializerInterface $serializer
     * @return JsonResponse
     */
    public function index(Request $request, $hotelId, SerializerInterface $serializer): JsonResponse
    {
        $dateFrom = Carbon::create($request->query->get('date_from'))->toDate();
        $dateTo =   Carbon::parse($request->query->get('date_to'))->toDate();

        if ($this->service->getHotelById($hotelId) === null) {
            return $this->json(['message' => "The resource does not exist"], 404, []);
        }

        $response = $this->service->getStatistics($dateFrom, $dateTo, $hotelId);

        return $this->json($response, 200, []);
    }
}
