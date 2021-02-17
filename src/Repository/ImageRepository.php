<?php

namespace App\Repository;

use App\Entity\Image;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Image|null find($id, $lockMode = null, $lockVersion = null)
 * @method Image|null findOneBy(array $criteria, array $orderBy = null)
 * @method Image[]    findAll()
 * @method Image[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ImageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Image::class);
    }

    // /**
    //  * @return Image[] Returns an array of Image objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Image
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */


    public function nombreImage()
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql ='SELECT count(i.id) as nombre
        FROM `image` i 
        ';
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt ->fetchAllAssociative();
    }
    
    public function pagination($premier, $dernier)
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql ='SELECT *
        FROM image i 
        ORDER BY i.id
        DESC LIMIT ' . $premier .', '. $dernier 
        ;
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt ->fetchAllAssociative();
    }
}
