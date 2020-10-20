<?php


namespace App\DTO;

use App\Entity\Hotel;

final class HotelAssembler
{
    /**
     * @param HotelApiDto $hotelApiDto
     * @param Hotel|null $hotel
     * @return Hotel
     */
    private function readDTO(HotelApiDto $hotelApiDto, ?Hotel $hotel = null): Hotel
    {
        if (!$hotel) {
            $hotel = new Hotel();
        }

        $hotel->setId($hotelApiDto->getId());
        $hotel->setName($hotelApiDto->getName());
        $hotel->setCreatedAt($hotelApiDto->getCreatedAt());
        $hotel->setUpdatedAt($hotelApiDto->getUpdatedAt());

        return $hotel;
    }

    /**
     * @param HotelApiDto $hotelApiDto
     * @return Hotel
     */
    public function hotelDto(HotelApiDto $hotelApiDto): Hotel
    {
        return $this->readDTO($hotelApiDto);
    }

}