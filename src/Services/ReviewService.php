<?php

namespace App\Services;

use App\DTO\ReviewApiDto;
use App\Entity\Hotel;
use App\Entity\Review;
use App\Interfaces\iReview;
use Carbon\Carbon;
use Doctrine\ORM\EntityManagerInterface;

class ReviewService implements iReview
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * ReviewService constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }


    /**
     * @return object[]
     */
    public function getAllReviews()
    {
        return $this->em->getRepository(Review::class)->findAll();
    }

    /**
     * @param $id
     * @return object|null
     */
    public function getReviewsById($id)
    {
        return $this->em->getRepository(Review::class)->find($id);
    }

    /**
     * @param $id
     * @return object|null
     */
    public function getHotelById($id)
    {
        return $this->em->getRepository(Hotel::class)->find($id);
    }

    /**
     * @param $content
     * @return ReviewApiDto
     */
    public function postReviews($content): ReviewApiDto
    {
        $hotelId = $this->em->getRepository(Hotel::class)->findOneBy(['id' => $content->hotelId]);
        $score = $content->score;
        $comment = $content->comment;
        $createdDate = Carbon::parse($content->createdDate)->toDate();

        $review = new Review();
        $review->setHotel($hotelId);
        $review->setScore($score);
        $review->setComment($comment);
        $review->setCreatedDate($createdDate);

        $this->em->persist($review);
        $this->em->flush();

        return $this->prepareResponse($review);

    }

    /**
     * @param $content
     * @param $id
     * @return ReviewApiDto
     */
    public function putReviews($content, $id): ReviewApiDto
    {
        $review = $this->em->getRepository(Review::class)->findOneBy(['id' => $id]);
        $hotelId = $this->em->getRepository(Hotel::class)->findOneBy(['id' => $content->hotelId]);
        $score = $content->score;
        $comment = $content->comment;
        $createdDate = Carbon::parse($content->createdDate)->toDate();

        $review->setHotel($hotelId);
        $review->setScore($score);
        $review->setComment($comment);
        $review->setCreatedDate($createdDate);

        $this->em->persist($review);
        $this->em->flush();

        if ($review instanceof Review) {
            return $this->prepareResponse($review);
        }

    }

    /**
     * @param $id
     * @return string|void
     */
    public function deleteReviews($id)
    {
        $review = $this->em->getRepository(Review::class)->findOneBy(['id' => $id]);

        $this->em->remove($review);
        $this->em->flush();

    }


    /**
     * @param Review $review
     * @return ReviewApiDto
     */
    public function prepareResponse(Review $review): ReviewApiDto
    {
        $dto = ReviewApiDto::create(
            $review->getId(),
            $review->getHotel(),
            $review->getScore(),
            $review->getComment(),
            $review->getCreatedDate(),
            $review->getCreatedAt(),
            $review->getUpdatedAt()
        );

        return $dto;
    }
}