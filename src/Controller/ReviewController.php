<?php

namespace App\Controller;

use App\Entity\Review;
use App\Interfaces\iReview;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;

class ReviewController extends AbstractController
{
    /**
     * @var iReview
     */
    private $reviewService;

    /**
     * ReviewController constructor.
     * @param iReview $reviewService
     */
    public function __construct(iReview $reviewService)
    {
        $this->reviewService = $reviewService;
    }

    /**
     * @Route("api/reviews/", name="get_all_reviews",methods={"GET","HEAD"})
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getReviews(Request $request)
    {
        $data = $this->reviewService->getAllReviews();

        return $this->json($data, 200, []);
    }

    /**
     * @Route("api/reviews/{id}", name="get_review_by_id",methods={"GET","HEAD"})
     *
     * @param $id
     * @param Request $request
     * @return JsonResponse
     */
    public function getReviewsById(Request $request, $id)
    {
        $data = $this->reviewService->getReviewsById($id);
        if ($data === null) {
            return $this->json(['message' => "The resource does not exist"], 404, []);
        }

        return $this->json($data, 200, []);
    }


    /**
     * @Route("api/reviews",name="post_reviews",methods={"POST"})
     *
     * @param Request $request
     * @param SerializerInterface $serializer
     * @return JsonResponse
     */
    public function postReviews(Request $request, SerializerInterface $serializer): JsonResponse
    {
        $content = json_decode($request->getContent());

        if ($this->reviewService->getHotelById($content->hotelId) === null) {
            return  $this->json(['message' => 'Hotel does not exist'], 404, []);
        }

        $data = $serializer->serialize($this->reviewService->postReviews($content), 'json');

        return new JsonResponse($data, 201, [], true);
    }

    /**
     * @Route("api/reviews/{id}",name="put_reviews",methods={"PUT"})
     *
     * @param Request $request
     * @param SerializerInterface $serializer
     * @return JsonResponse
     */
    public function putReviews(Request $request, $id, SerializerInterface $serializer): JsonResponse
    {
        $content = json_decode($request->getContent());

        if ($this->reviewService->getReviewsById($id) && $this->reviewService->getHotelById($content->hotelId) === null) {
            return $this->json(['message' => "The resource does not exist"], 404, []);
        }

        $json = $serializer->serialize($this->reviewService->putReviews($content, $id), 'json');

        return new JsonResponse($json, 201, [], true);
    }

    /**
     * @Route("api/reviews/{id}",name="delete_reviews",methods={"DELETE"})
     *
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function deleteReviews(Request $request, $id): JsonResponse
    {
        if ($this->reviewService->getReviewsById($id) ===  null) {
            return $this->json(['message' => "The resource does not exist"], 404, []);
        }

        $this->reviewService->deleteReviews($id);

        return $this->json(['message' => 'Resource successfully deleted'], 200, []);
    }

}
