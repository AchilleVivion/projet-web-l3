<?php

namespace App\Repository;

use App\Entity\Follow;
use App\Entity\User;
use App\Entity\Community;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Follow|null find($id, $lockMode = null, $lockVersion = null)
 * @method Follow|null findOneBy(array $criteria, array $orderBy = null)
 * @method Follow[]    findAll()
 * @method Follow[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FollowRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Follow::class);
    }

    /**
    * @return Follow[] Returns an array of Follow objects
    */
    public function findByCommunity(Community $commu)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.community = :commu')
            ->setParameter('commu', $commu)
            ->getQuery()
            ->getResult()
        ;
    }

    /*
    public function findOneBySomeField($value): ?Follow
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function isFollowing(User $user, Community $commu): ?Follow
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.theuser = :user')
            ->andWhere('f.community = :commu')
            ->setParameter('user', $user)
            ->setParameter('commu', $commu)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
