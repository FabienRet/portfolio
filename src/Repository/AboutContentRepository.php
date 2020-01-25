<?php

namespace App\Repository;

use App\Entity\AboutContent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method AboutContent|null find($id, $lockMode = null, $lockVersion = null)
 * @method AboutContent|null findOneBy(array $criteria, array $orderBy = null)
 * @method AboutContent[]    findAll()
 * @method AboutContent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AboutContentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AboutContent::class);
    }

    // /**
    //  * @return AboutContent[] Returns an array of AboutContent objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AboutContent
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
