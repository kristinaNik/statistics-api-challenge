<?php

namespace App\Controller;

use App\Services\ReviewService;
use Carbon\Carbon;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;

class ReviewController extends AbstractController
{

    private $reviewService;

    public function __construct(ReviewService $reviewService)
    {
        $this->reviewService = $reviewService;
    }

    /**
     * @Route("api/reviews/hotel/{hotelId}/overtime", name="reviews_hotel_overtime")
     */
    public function index(Request $request, $hotelId, SerializerInterface $serializer)
    {
        $dateFrom = Carbon::parse($request->query->get('date_from'))->toDate();
        $dateTo =   Carbon::parse($request->query->get('date_to'));

        $json = $serializer->serialize($this->reviewService->getCountReviews($dateFrom, $dateTo, $hotelId), 'json');

        return new JsonResponse($json, 200, [],true);
    }
}
