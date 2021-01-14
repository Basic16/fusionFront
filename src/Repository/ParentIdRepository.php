<?php

namespace App\Repository;

use App\Entity\ParentId;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ParentId|null find($id, $lockMode = null, $lockVersion = null)
 * @method ParentId|null findOneBy(array $criteria, array $orderBy = null)
 * @method ParentId[]    findAll()
 * @method ParentId[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ParentIdRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ParentId::class);
    }

    // /**
    //  * @return ParentId[] Returns an array of ParentId objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ParentId
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
