<?php

namespace App\DTO;

use JMS\Serializer\Annotation as Serialization;

class ReviewResponseDto
{

    /**
     * @Serialization\Type("int")
     */
    public $id;


    public $hotelId;

    /**
     * @Serialization\Type("float")
     */
    public $score;

    /**
     * @Serialization\Type("string")
     */
    public $comment;

    /**
     * @Serialization\Type("DateTime<Y-m-d>")
     */
    public $createdDate;

    /**
     * @Serialization\Type("DateTime<Y-m-d>")
     */
    public $createdAt;

    /**
     * @Serialization\Type("DateTime<Y-m-d>")
     */
    public $updatedAt;

}