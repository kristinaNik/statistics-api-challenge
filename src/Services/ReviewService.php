<?php


namespace App\Services;

use App\Entity\Hotel;
use App\Entity\Review;
use Doctrine\ORM\EntityManagerInterface;
use League\Fractal\TransformerAbstract;


class ReviewService extends TransformerAbstract
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
     * @param \DateTime $dateFrom
     * @param \DateTime $dateTo
     * @return mixed
     */
    public function getCountReviews(\DateTime $dateFrom, \DateTime $dateTo, $hotelId)
    {
        $reviewRepo = $this->em->getRepository(Review::class);
        $hotelRepo = $this->em->getRepository(Hotel::class)->find($hotelId);

        return $reviewRepo->countReviews($hotelRepo, $dateFrom, $dateTo);
    }
}