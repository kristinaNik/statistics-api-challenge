<?php


namespace App\DTO;

use App\Entity\Review;

class ReviewApiDto
{
    /**
     * @var Review
     */
    private $review;


    /**
     * ReviewApiDto constructor.
     * @param Review $review
     */
    public function __construct(Review $review)
    {
        $this->review = $review;
    }


    public function getId()
    {
        return $this->review->getId();
    }

    public function getScore()
    {
        return $this->review->getScore();
    }

    public function getComment()
    {
        return $this->review->getComment();
    }

    public function getHotelId()
    {
        return $this->review->getHotel()->getId();
    }

}