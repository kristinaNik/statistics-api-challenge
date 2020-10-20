<?php

namespace App\Services;

use App\DTO\HotelApiDto;
use App\DTO\HotelAssembler;
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
     * @var HotelAssembler
     */
    private $assembler;

    /**
     * HotelService constructor.
     * @param EntityManagerInterface $entityManager
     * @param HotelAssembler $assembler
     */
    public function __construct(EntityManagerInterface $entityManager, HotelAssembler $assembler)
    {
        $this->em = $entityManager;
        $this->assembler = $assembler;
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
     * @return Hotel
     */
    public function postHotels($content): Hotel
    {
        $this->em->persist($content);
        $this->em->flush();

        return $this->prepareResponse($content);
    }

    /**
     * @param $content
     * @param $id
     * @return Hotel
     */
    public function putHotels($content, $id): Hotel
    {
        $hotel = $this->em->getRepository(Hotel::class)->find($id);
        $hotel->setName($content->getName());

        $this->em->persist($hotel);
        $this->em->flush();

        if ($hotel instanceof Hotel) {
            return $this->prepareResponse($hotel);
        }

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


    public function prepareResponse(Hotel $hotel): Hotel
    {
        $dto = $this->assembler->hotelDto(new HotelApiDto(
            $hotel->getId(),
            $hotel->getName(),
            $hotel->getCreatedAt(),
            $hotel->getUpdatedAt()
        ));

        return $dto;
    }
}