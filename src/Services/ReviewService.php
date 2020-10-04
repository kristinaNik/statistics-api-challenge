<?php


namespace App\Services;

use App\DTO\ReviewApiDto;
use App\Entity\Hotel;
use App\Entity\Review;
use Carbon\Carbon;
use Doctrine\ORM\EntityManagerInterface;
use League\Fractal\TransformerAbstract;

class ReviewService
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
     * @return string
     */
    public function deleteReviews($id): string
    {
        $review = $this->em->getRepository(Review::class)->findOneBy(['id' => $id]);

        if ($review === null) {
            return json_encode("This review has already been deleted", 400);
        }

        $this->em->remove($review);
        $this->em->flush();

        return json_encode("The review with id " . $id . " has been deleted");
    }


    /**
     * @param Review $review
     * @return ReviewApiDto
     */
    private function prepareResponse(Review $review): ReviewApiDto
    {
        $dto = ReviewApiDto::create(
            $review->getId(),
            $review->getHotel(),
            $review->getScore(),
            $review->getComment(),
            $review->getCreatedDate()
        );

        return $dto;
    }
}