<?php


namespace App\Interfaces;

use App\DTO\HotelApiDto;
use App\Entity\Hotel;

interface iHotel
{

    public function getAllHotels();

    public function getHotelsById($id);

    public function postHotels($content): Hotel;

    public function putHotels($content, $id): Hotel;

    public function deleteHotels($id);

    public function prepareResponse(Hotel $review): Hotel;

}