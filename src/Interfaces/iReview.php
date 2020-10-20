<?php


namespace App\Interfaces;

use App\DTO\ReviewApiDto;
use App\Entity\Review;

interface iReview
{
    public function getAllReviews();

    public function getReviewsById($id);

    public function getHotelById($id);

    public function postReviews($content): Review;

    public function putReviews($content, $id): Review;

    public function deleteReviews($id);

    public function prepareResponse(Review $review): Review;

}