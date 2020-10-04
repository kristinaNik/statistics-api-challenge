<?php


namespace App\Interfaces;

use App\DTO\HotelApiDto;
use App\Entity\Hotel;

interface iHotel
{

    public function getAllHotels();

    public function getHotelsById($id);

    public function postHotels($content): HotelApiDto;

    public function putHotels($content, $id): HotelApiDto;

    public function deleteHotels($id): string;

    public function prepareResponse(Hotel $review): HotelApiDto;

}