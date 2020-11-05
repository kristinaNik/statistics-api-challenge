<?php

namespace App\Services;

use App\DTO\HotelApiDto;
use App\DTO\HotelAssembler;
use App\DTO\Response\Transformer\HotelResponseTransformer;
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
     * @var HotelResponseTransformer
     */
    private $dtoTransformer;

    /**
     * HotelService constructor.
     * @param EntityManagerInterface $entityManager
     * @param HotelResponseTransformer $dtoTransformer
     */
    public function __construct(EntityManagerInterface $entityManager, HotelResponseTransformer $dtoTransformer)
    {
        $this->em = $entityManager;
        $this->dtoTransformer = $dtoTransformer;
    }

    /**
     * @return object[]
     */
    public function getAllHotels()
    {
        $hotels =  $this->em->getRepository(Hotel::class)->findAll();
        return $this->dtoTransformer->transformFromObjects($hotels);
    }

    /**
     * @param $id
     * @return object|null
     */
    public function getHotelsById($id)
    {
        $hotel = $this->em->getRepository(Hotel::class)->find($id);
        if ($hotel instanceof Hotel) {
            return  $this->dtoTransformer->transformFromObject($hotel);
        }

    }

    /**
     * @param $content
     */
    public function postHotels($content)
    {
        $this->em->persist($content);
        $this->em->flush();

        return $this->dtoTransformer->transformFromObject($content);
    }

    /**
     * @param $content
     * @param $id
     */
    public function putHotels($content, $id)
    {
        $hotel = $this->em->getRepository(Hotel::class)->find($id);
        $hotel->setName($content->getName());

        $this->em->persist($hotel);
        $this->em->flush();

        if ($hotel instanceof Hotel) {
           return  $this->dtoTransformer->transformFromObject($hotel);
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

}