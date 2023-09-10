<?php

namespace App\Repository;

use App\Entity\UserWithImage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<UserWithImage>
 *
 * @method UserWithImage|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserWithImage|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserWithImage[]    findAll()
 * @method UserWithImage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserWithImageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserWithImage::class);
    }

//    /**
//     * @return UserWithImage[] Returns an array of UserWithImage objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('u.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?UserWithImage
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
