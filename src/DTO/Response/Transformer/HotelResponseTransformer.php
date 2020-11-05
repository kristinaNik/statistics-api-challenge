<?php


namespace App\DTO\Response\Transformer;


use App\DTO\Response\HotelResponseDto;
use App\Entity\Hotel;

class HotelResponseTransformer extends AbstractResponseDtoTransformer
{
    /**
     * @param Hotel $hotel
     * @return HotelResponseDto
     */
    public function transformFromObject($hotel): HotelResponseDto
    {
        $dto = new HotelResponseDto();

        $dto->id = $hotel->getId();
        $dto->name = $hotel->getName();
        $dto->createdAt = $hotel->getCreatedAt();
        $dto->updatedAt = $hotel->getUpdatedAt();

        return $dto;
    }

}