<?php

namespace App\Repository;

use App\Entity\ListingCategoryTranslation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ListingCategoryTranslation|null find($id, $lockMode = null, $lockVersion = null)
 * @method ListingCategoryTranslation|null findOneBy(array $criteria, array $orderBy = null)
 * @method ListingCategoryTranslation[]    findAll()
 * @method ListingCategoryTranslation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ListingCategoryTranslationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ListingCategoryTranslation::class);
    }

    // /**
    //  * @return ListingCategoryTranslation[] Returns an array of ListingCategoryTranslation objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ListingCategoryTranslation
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
