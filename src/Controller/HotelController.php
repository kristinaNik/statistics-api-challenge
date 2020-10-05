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
     * @Route("api/hotels.{_format}",
     *     format="json",
     *     requirements={
     *         "_format": "json",
     *     },
     *     name="get_all_hotels",
     *     methods={"GET"})
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getHotels(Request $request)
    {
        $data = $this->service->getAllHotels();

        return $this->json($data, 200, []);
    }

    /**
     * @Route("api/hotels/{id}.{_format}",
     *     format="json",
     *     requirements={
     *         "_format": "json",
     *     },
     *     name="get_hotels_by_id",
     *     methods={"GET"})
     *
     * @param $id
     * @param Request $request
     * @return JsonResponse
     */
    public function getHotelsById(Request $request, $id)
    {
        $data = $this->service->getHotelsById($id);

        if ($data === null) {
            return $this->json(['message' => "The resource does not exist"], 404, []);
        }

        return $this->json($data, 200, []);
    }

    /**
     * @Route("api/hotels.{_format}",
     *     format="json",
     *     requirements={
     *         "_format": "json",
     *     },
     *     name="post_hotels",
     *     methods={"POST"})
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
     * @Route("api/hotels/{id}.{_format}",
     *     format="json",
     *     requirements={
     *         "_format": "json",
     *     },
     *     name="put_hotels",
     *     methods={"PUT"})
     *
     * @param Request $request
     * @param $id
     * @param SerializerInterface $serializer
     * @param ValidatorInterface $validator
     * @return JsonResponse
     */
    public function putHotels(Request $request, $id, SerializerInterface $serializer,ValidatorInterface $validator): JsonResponse
    {
        if ($this->service->getHotelsById($id) === null) {
            return $this->json(['message' => "The resource does not exist"], 404, []);
        }

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
     * @Route("api/hotels/{id}.{_format}",
     *     format="json",
     *     requirements={
     *         "_format": "json",
     *     },
     *     name="delete_hotels",
     *     methods={"DELETE"})
     *
     * @param Request $request
     * @param $id
     * @param SerializerInterface $serializer
     * @return JsonResponse
     */
    public function deleteHotels(Request $request, $id, SerializerInterface $serializer): JsonResponse
    {
        if ($this->service->getHotelsById($id) === null) {
            return $this->json(['message' => "The resource does not exist"], 404, []);
        }

        $this->service->deleteHotels($id);

        return $this->json(['message' => 'Resource successfully deleted'], 200, []);
    }

}
