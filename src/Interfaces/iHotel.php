<?php


namespace App\Interfaces;

use App\DTO\HotelApiDto;
use App\Entity\Hotel;

interface iHotel
{

    public function getAllHotels();

    public function getHotelsById($id);

    public function postHotels($content);

    public function putHotels($content, $id);

    public function deleteHotels($id);

}