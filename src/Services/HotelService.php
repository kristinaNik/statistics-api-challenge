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

    public function getAllHotels()
    {
        return $this->em->getRepository(Hotel::class)->findAll();
    }

    public function getHotelsById($id)
    {
        return $this->em->getRepository(Hotel::class)->find($id);
    }

    public function postHotels($content): HotelApiDto
    {
        $name = $content->name;

        $hotel = new Hotel();
        $hotel->setName($name);

        $this->em->persist($hotel);
        $this->em->flush();

        return $this->prepareResponse($hotel);
    }

    public function putHotels($content, $id): HotelApiDto
    {
        $hotel = $this->em->getRepository(Hotel::class)->findOneBy(['id' => $id]);
        $name = $content->name;
        $hotel->setName($name);

        $this->em->persist($hotel);
        $this->em->flush();

        if ($hotel instanceof Hotel) {
            return $this->prepareResponse($hotel);
        }

    }

    public function deleteHotels($id): string
    {
        $hotel = $this->em->getRepository(Hotel::class)->findOneBy(['id' => $id]);

        if ($hotel === null) {
            return json_encode("This hotel has already been deleted", 400);
        }

        $this->em->remove($hotel);
        $this->em->flush();

        return json_encode("The hotel with id " . $id . " has been deleted");
    }

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