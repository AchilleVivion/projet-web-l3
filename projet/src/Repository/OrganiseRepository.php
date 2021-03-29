<?php

namespace App\Repository;

use App\Entity\Organise;
use App\Entity\Community;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Organise|null find($id, $lockMode = null, $lockVersion = null)
 * @method Organise|null findOneBy(array $criteria, array $orderBy = null)
 * @method Organise[]    findAll()
 * @method Organise[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrganiseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Organise::class);
    }

    /**
    * @return Organise[] Returns an array of Organise objects
    */
    public function findByCommunity(Community $commu)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.community = :commu')
            ->setParameter('commu', $commu)
            ->getQuery()
            ->getResult()
        ;
    }

    /*
    public function findOneBySomeField($value): ?Organise
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
