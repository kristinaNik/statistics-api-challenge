<?php


namespace App\DTO\Response\Transformer;


use App\DTO\ReviewResponseDto;
use App\Entity\Review;

class ReviewResponseTransformer extends AbstractResponseDtoTransformer
{

    /**
     * @var HotelResponseTransformer
     */
    private $hotelResponseTransformer;

    /**
     * ReviewResponseTransformer constructor.
     * @param HotelResponseTransformer $hotelResponseTransformer
     */
    public function __construct(HotelResponseTransformer $hotelResponseTransformer)
    {
        $this->hotelResponseTransformer = $hotelResponseTransformer;
    }

    /**
     * @param Review $review
     */
    public function transformFromObject($review): ReviewResponseDto
    {
        $dto = new ReviewResponseDto();

        $dto->id = $review->getId();
        $dto->hotelId = $this->hotelResponseTransformer->transformFromObject($review->getHotel());
        $dto->score = $review->getScore();
        $dto->comment = $review->getComment();
        $dto->createdDate = $review->getCreatedDate();
        $dto->createdAt = $review->getCreatedAt();
        $dto->updatedAt = $review->getUpdatedAt();

        return $dto;
    }


}