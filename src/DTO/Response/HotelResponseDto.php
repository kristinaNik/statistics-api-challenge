<?php


namespace App\DTO\Response;

use JMS\Serializer\Annotation as Serialization;

class HotelResponseDto
{

    /**
     * @Serialization\Type("int")
     */
    public int $id;

    /**
     * @Serialization\Type("string")
     */
    public string $name;

    /**
     * @Serialization\Type("DateTime<Y-m-d>")
     */
    public \DateTime $createdAt;

    /**
     * @Serialization\Type("DateTime<Y-m-d>")
     */
    public \DateTime $updatedAt;


}