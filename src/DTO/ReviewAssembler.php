<?php


namespace App\DTO;

use App\Entity\Review;

final class ReviewAssembler
{

    /**
     * @param ReviewApiDto $reviewApiDto
     * @param Review|null $review
     * @return Review
     */
    private function readDTO(ReviewApiDto $reviewApiDto, ?Review $review = null): Review
    {
        if (!$review) {
            $review = new Review();
        }

        $review->setId($reviewApiDto->getId());
        $review->setComment($reviewApiDto->getComment());
        $review->setScore($reviewApiDto->getScore());
        $review->setHotel($reviewApiDto->getHotelId());
        $review->setCreatedDate($reviewApiDto->getCreatedDate());
        $review->setCreatedAt($reviewApiDto->getCreatedAt());
        $review->setUpdatedAt($reviewApiDto->getUpdatedAt());

        return $review;
    }

    /**
     * @param ReviewApiDto $reviewApiDto
     * @return Review
     */
    public function reviewDto(ReviewApiDto $reviewApiDto): Review
    {
        return $this->readDTO($reviewApiDto);
    }

}