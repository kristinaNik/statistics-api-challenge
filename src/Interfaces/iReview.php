<?php


namespace App\Interfaces;

use App\DTO\ReviewApiDto;
use App\DTO\ReviewResponseDto;
use App\Entity\Review;

interface iReview
{
    public function getAllReviews();

    public function getReviewsById($id);

    public function getHotelById($id);

    public function postReviews($content): ReviewResponseDto;

    public function putReviews($content, $id): ReviewResponseDto;

    public function deleteReviews($id);

}