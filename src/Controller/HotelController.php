<?php

namespace App\Controller;

use App\Interfaces\iHotel;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class HotelController extends AbstractController
{
    /**
     * @var iHotel
     */
    private $service;

    /**
     * HotelController constructor.
     * @param iHotel $service
     */
    public function __construct(iHotel $service)
    {
        $this->service = $service;
    }

    /**
     * @Route("api/hotels/", name="get_all_hotels",methods={"GET","HEAD"})
     *
     * @param Request $request
     * @param SerializerInterface $serializer
     * @return JsonResponse
     */
    public function getHotels(Request $request, SerializerInterface $serializer)
    {
        $json = $serializer->serialize($this->service->getAllHotels(), 'json');

        return new JsonResponse($json, 200, [], true);
    }

    /**
     * @Route("api/hotels/{id}", name="get_hotels_by_id",methods={"GET","HEAD"})
     *
     * @param $id
     * @param Request $request
     * @param SerializerInterface $serializer
     * @return JsonResponse
     */
    public function getHotelsById(Request $request, $id, SerializerInterface $serializer)
    {
        $json = $serializer->serialize($this->service->getHotelsById($id), 'json');

        return new JsonResponse($json, 200, [], true);
    }


    /**
     * @Route("api/hotels",name="post_hotels",methods={"POST"})
     *
     * @param Request $request
     * @param SerializerInterface $serializer
     * @return JsonResponse
     */
    public function postHotels(Request $request, SerializerInterface $serializer): JsonResponse
    {
        $content = json_decode($request->getContent());
        $json = $serializer->serialize($this->service->postHotels($content), 'json');

        return new JsonResponse($json, 200, [], true);
    }

    /**
     * @Route("api/hotels/{id}",name="put_hotels",methods={"PUT"})
     *
     * @param Request $request
     * @param SerializerInterface $serializer
     * @return JsonResponse
     */
    public function putHotels(Request $request, $id, SerializerInterface $serializer): JsonResponse
    {
        $content = json_decode($request->getContent());
        $json = $serializer->serialize($this->service->putHotels($content, $id), 'json');

        return new JsonResponse($json, 200, [], true);
    }

    /**
     * @Route("api/hotels/{id}",name="delete_hotels",methods={"DELETE"})
     *
     * @param Request $request
     * @param $id
     * @param SerializerInterface $serializer
     * @return JsonResponse
     */
    public function deleteHotels(Request $request, $id, SerializerInterface $serializer): JsonResponse
    {
        $json = $serializer->serialize($this->service->deleteHotels($id), 'json');

        return new JsonResponse($json, 200, [], true);
    }

}