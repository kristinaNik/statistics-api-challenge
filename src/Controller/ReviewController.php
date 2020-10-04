<?php

namespace App\Controller;

use App\Interfaces\iReview;
use App\Services\ReviewService;
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
     * @param SerializerInterface $serializer
     * @return JsonResponse
     */
    public function getReviews(Request $request, SerializerInterface $serializer)
    {
        $json = $serializer->serialize($this->reviewService->getAllReviews(), 'json');

        return new JsonResponse($json, 200, [], true);
    }

    /**
     * @Route("api/reviews/{id}", name="get_review_by_id",methods={"GET","HEAD"})
     *
     * @param $id
     * @param Request $request
     * @param SerializerInterface $serializer
     * @return JsonResponse
     */
    public function getReviewsById(Request $request, $id, SerializerInterface $serializer)
    {
        $json = $serializer->serialize($this->reviewService->getReviewsById($id), 'json');

        return new JsonResponse($json, 200, [], true);
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
        $json = $serializer->serialize($this->reviewService->postReviews($content), 'json');

        return new JsonResponse($json, 204, [], true);
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
        $json = $serializer->serialize($this->reviewService->putReviews($content, $id), 'json');

        return new JsonResponse($json, 204, [], true);
    }

    /**
     * @Route("api/reviews/{id}",name="delete_reviews",methods={"DELETE"})
     *
     * @param Request $request
     * @param $id
     * @param SerializerInterface $serializer
     * @return JsonResponse
     */
    public function deleteReviews(Request $request, $id, SerializerInterface $serializer): JsonResponse
    {
        $json = $serializer->serialize($this->reviewService->deleteReviews($id), 'json');

        return new JsonResponse($json, 200, [], true);
    }

}
