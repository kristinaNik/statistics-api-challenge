<?php


namespace App\DTO;


class HotelApiDto
{

    private $name;

    private $createdAt;

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }



}