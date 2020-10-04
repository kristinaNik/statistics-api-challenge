<?php

namespace App\Repository;

use App\Entity\Review;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Review|null find($id, $lockMode = null, $lockVersion = null)
 * @method Review|null findOneBy(array $criteria, array $orderBy = null)
 * @method Review[]    findAll()
 * @method Review[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReviewRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Review::class);
    }

    public function countReviews($hotelId, \DateTime $dateFrom, \DateTime $dateTo)
    {
        return $this->createQueryBuilder('r')
            ->select('COUNT(r.id) AS count')
            ->join('r.hotel', 'h')
            ->andWhere('r.createdDate >= :dateFrom')
            ->andWhere('r.createdDate <= :dateTo')
            ->andWhere('h.id = :hotelId')
            ->setParameter('hotelId', $hotelId)
            ->setParameter('dateFrom', $dateFrom)
            ->setParameter('dateTo', $dateTo)
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function averageScores($hotelId, \DateTime $dateFrom, \DateTime $dateTo)
    {
        return $this->createQueryBuilder('r')
            ->select('AVG(r.score) AS score')
            ->join('r.hotel', 'h')
            ->andWhere('r.createdDate >= :dateFrom')
            ->andWhere('r.createdDate <= :dateTo')
            ->andWhere('h.id = :hotelId')
            ->setParameter('hotelId', $hotelId)
            ->setParameter('dateFrom', $dateFrom)
            ->setParameter('dateTo', $dateTo)
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function groupDatesByWeek($hotelId,  \DateTime $dateFrom, \DateTime $dateTo)
    {
        return $this->createQueryBuilder('r')
            ->select(['COUNT(r.id) AS review_count', 'AVG(r.score) AS average_score', 'WEEK(r.createdDate) AS weeks'])
            ->join('r.hotel', 'h')
            ->andWhere('h.id = :hotelId')
            ->andWhere('r.createdDate >= :dateFrom')
            ->andWhere('r.createdDate <= :dateTo')
            ->setParameter('hotelId', $hotelId)
            ->setParameter('dateFrom', $dateFrom)
            ->setParameter('dateTo', $dateTo)
            ->groupBy('weeks')
            ->getQuery()
            ->getArrayResult();
    }

    public function groupDatesByDay($hotelId,  \DateTime $dateFrom, \DateTime $dateTo)
    {
        return $this->createQueryBuilder('r')
            ->select(['COUNT(r.id) AS review_count', 'AVG(r.score) AS average_score', 'DAY(r.createdDate) AS days'])
            ->join('r.hotel', 'h')
            ->andWhere('h.id = :hotelId')
            ->andWhere('r.createdDate >= :dateFrom')
            ->andWhere('r.createdDate <= :dateTo')
            ->setParameter('hotelId', $hotelId)
            ->setParameter('dateFrom', $dateFrom)
            ->setParameter('dateTo', $dateTo)
            ->groupBy('days')
            ->getQuery()
            ->getArrayResult();
    }

    public function groupDatesByMonth($hotelId,  \DateTime $dateFrom, \DateTime $dateTo)
    {
        return $this->createQueryBuilder('r')
            ->select(['COUNT(r.id) AS review_count', 'AVG(r.score) AS average_score', 'MONTH(r.createdDate) AS months'])
            ->join('r.hotel', 'h')
            ->andWhere('h.id = :hotelId')
            ->andWhere('r.createdDate >= :dateFrom')
            ->andWhere('r.createdDate <= :dateTo')
            ->setParameter('hotelId', $hotelId)
            ->setParameter('dateFrom', $dateFrom)
            ->setParameter('dateTo', $dateTo)
            ->groupBy('months')
            ->getQuery()
            ->getArrayResult();
    }
}
