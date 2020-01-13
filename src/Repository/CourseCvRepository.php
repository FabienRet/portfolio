<?php

namespace App\Repository;

use App\Entity\CourseCv;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method CourseCv|null find($id, $lockMode = null, $lockVersion = null)
 * @method CourseCv|null findOneBy(array $criteria, array $orderBy = null)
 * @method CourseCv[]    findAll()
 * @method CourseCv[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CourseCvRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CourseCv::class);
    }

    // /**
    //  * @return CourseCv[] Returns an array of CourseCv objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CourseCv
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
