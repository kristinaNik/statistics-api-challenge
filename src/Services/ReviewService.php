<?php

namespace App\Services;

use App\DTO\Response\Transformer\ReviewResponseTransformer;
use App\DTO\ReviewResponseDto;
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
     * @var ReviewResponseTransformer
     */
    private $dtoTransformer;

    /**
     * ReviewService constructor.
     * @param EntityManagerInterface $entityManager
     * @param ReviewResponseTransformer $dtoTransformer
     */
    public function __construct(EntityManagerInterface $entityManager, ReviewResponseTransformer $dtoTransformer)
    {
        $this->em = $entityManager;
        $this->dtoTransformer = $dtoTransformer;
    }


    /**
     * @return iterable
     */
    public function getAllReviews()
    {
        $reviews =  $this->em->getRepository(Review::class)->findAll();
        return $this->dtoTransformer->transformFromObjects($reviews);
    }

    /**
     * @param $id
     * @return \App\DTO\ReviewResponseDto
     */
    public function getReviewsById($id): ReviewResponseDto
    {
        $review =  $this->em->getRepository(Review::class)->find($id);
        if ($review instanceof Review) {
            return  $this->dtoTransformer->transformFromObject($review);
        }

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
     * @return ReviewResponseDto
     */
    public function postReviews($content): ReviewResponseDto
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

       return $this->dtoTransformer->transformFromObject($review);
    }

    /**
     * @param $content
     * @param $id
     * @return ReviewResponseDto
     */
    public function putReviews($content, $id): ReviewResponseDto
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
            return $this->dtoTransformer->transformFromObject($review);
        }

    }

    /**
     * @param $id
     */
    public function deleteReviews($id)
    {
        $review = $this->em->getRepository(Review::class)->findOneBy(['id' => $id]);

        $this->em->remove($review);
        $this->em->flush();

    }

}