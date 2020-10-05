<?php


namespace App\Interfaces;


interface iStatistics
{
    public function getStatistics(\DateTime $dateFrom, \DateTime $dateTo, $hotelId);

    public function getHotelById($id);
}