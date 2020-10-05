<?php


namespace App\Services;

use App\Entity\Hotel;
use App\Entity\Review;
use App\Interfaces\iStatistics;
use Doctrine\ORM\EntityManagerInterface;

class StatisticsService implements iStatistics
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
     * @param $hotelId
     * @return mixed
     */
    public function getStatistics(\DateTime $dateFrom, \DateTime $dateTo, $hotelId)
    {
        $reviewRepo = $this->em->getRepository(Review::class);
        $hotelRepo = $this->em->getRepository(Hotel::class)->find($hotelId);

        return [
            'review-count' => $reviewRepo->countReviews($hotelRepo, $dateFrom, $dateTo),
            'average-score' => $reviewRepo->averageScores($hotelRepo, $dateFrom, $dateTo),
            'date-group' => [
                'daily' => $reviewRepo->groupDatesByDay($hotelRepo, $dateFrom, $dateTo),
                'weekly' => $reviewRepo->groupDatesByWeek($hotelRepo, $dateFrom, $dateTo),
                'monthly' => $reviewRepo->groupDatesByMonth($hotelRepo, $dateFrom, $dateTo)
            ]
        ];
    }

    /**
     * @param $id
     * @return object|null
     */
    public function getHotelById($id)
    {
        return $this->em->getRepository(Hotel::class)->find($id);
    }
}