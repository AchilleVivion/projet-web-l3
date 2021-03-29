<?php

namespace App\Repository;

use App\Entity\Community;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Community|null find($id, $lockMode = null, $lockVersion = null)
 * @method Community|null findOneBy(array $criteria, array $orderBy = null)
 * @method Community[]    findAll()
 * @method Community[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommunityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Community::class);
    }

    /**
    * @return Community[] Returns an array of Community objects
    */
    public function findCommuOrganise(User $value)
    {
        return $this->createQueryBuilder('c')
            ->innerJoin('c.organises', 'o')
            ->andWhere('o.theuser = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
    * @return Community[] Returns an array of Community objects
    */
    public function findCommuFollow(User $value)
    {
        return $this->createQueryBuilder('c')
            ->innerJoin('c.followedby', 'f')
            ->andWhere('f.theuser = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
    * @return Community[] Returns an array of Community objects
    */
    public function findCommuPublic()
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.public = :val')
            ->setParameter('val', true)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return Community
     */
    public function findOneById($value): ?Community
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.id = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
