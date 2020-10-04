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
}
