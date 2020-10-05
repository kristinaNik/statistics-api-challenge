<?php

namespace App\Services;

use App\DTO\HotelApiDto;
use App\Entity\Hotel;
use App\Interfaces\iHotel;
use Doctrine\ORM\EntityManagerInterface;

class HotelService implements iHotel
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * ReviewService constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    /**
     * @return object[]
     */
    public function getAllHotels()
    {
        return $this->em->getRepository(Hotel::class)->findAll();
    }

    /**
     * @param $id
     * @return object|null
     */
    public function getHotelsById($id)
    {
        return $this->em->getRepository(Hotel::class)->find($id);
    }

    /**
     * @param $content
     * @return HotelApiDto
     */
    public function postHotels($content): HotelApiDto
    {
        $this->em->persist($content);
        $this->em->flush();

        return $this->prepareResponse($content);
    }

    /**
     * @param $content
     * @param $id
     * @return HotelApiDto
     */
    public function putHotels($content, $id): HotelApiDto
    {
        $this->em->persist($content);
        $this->em->flush();

        return $this->prepareResponse($content);
    }

    /**
     * @param $id
     */
    public function deleteHotels($id)
    {
        $hotel = $this->em->getRepository(Hotel::class)->findOneBy(['id' => $id]);

        $this->em->remove($hotel);
        $this->em->flush();
    }

    /**
     * @param Hotel $hotel
     * @return HotelApiDto
     */
    public function prepareResponse(Hotel $hotel): HotelApiDto
    {
        $dto = HotelApiDto::create(
            $hotel->getId(),
            $hotel->getName(),
            $hotel->getCreatedAt(),
            $hotel->getUpdatedAt()
        );

        return $dto;
    }
}