<?php

namespace App\Repository;

use App\Entity\Gameday;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Gameday|null find($id, $lockMode = null, $lockVersion = null)
 * @method Gameday|null findOneBy(array $criteria, array $orderBy = null)
 * @method Gameday[]    findAll()
 * @method Gameday[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GamedayRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Gameday::class);
    }

    // /**
    //  * @return Gameday[] Returns an array of Gameday objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Gameday
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
