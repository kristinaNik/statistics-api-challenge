<?php

namespace App\Controller;

use App\Entity\Hotel;
use App\Interfaces\iHotel;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

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
     * @param ValidatorInterface $validator
     * @return JsonResponse
     */
    public function postHotels(Request $request, SerializerInterface $serializer,ValidatorInterface $validator): JsonResponse
    {
        $data = $request->getContent();
        $json = $serializer->deserialize($data, Hotel::class, 'json');

        $errors  = $validator->validate($json);
        if (count($errors) > 0) {
            return $this->json($errors, 400);
        }

        $response = $this->service->postHotels($json);
        return $this->json($response, 201, []);
    }

    /**
     * @Route("api/hotels/{id}",name="put_hotels",methods={"PUT"})
     *
     * @param Request $request
     * @param $id
     * @param SerializerInterface $serializer
     * @param ValidatorInterface $validator
     * @return JsonResponse
     */
    public function putHotels(Request $request, $id, SerializerInterface $serializer,ValidatorInterface $validator): JsonResponse
    {
        $data = $request->getContent();
        $json = $serializer->deserialize($data, Hotel::class, 'json');

        $errors  = $validator->validate($json);
        if (count($errors) > 0) {
            return $this->json($errors, 400);
        }

        $response = $this->service->putHotels($json, $id);
        return $this->json($response, 201, []);

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
