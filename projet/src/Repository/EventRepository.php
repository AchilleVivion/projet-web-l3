<?php

namespace App\Repository;

use App\Entity\Event;
use App\Entity\User;
use App\Entity\Community;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Security\LoginAuthenticator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserProviderInterface;

/**
 * @method Event|null find($id, $lockMode = null, $lockVersion = null)
 * @method Event|null findOneBy(array $criteria, array $orderBy = null)
 * @method Event[]    findAll()
 * @method Event[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Event::class);
    }

    /**
    * @return Event[] Returns an array of Event objects
    */
    public function findByCommunity(Community $commu)
    {
        return $this->createQueryBuilder('e')
            ->andWhere(':commu MEMBER OF e.communities')
            ->setParameter('commu', $commu)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
    * @return Event[] Returns an array of Event objects
    */
    public function findUpcomingEventUser(User $value, $filtres)
    {
        $ret = $this->createQueryBuilder('e')
        ->andWhere(':val MEMBER OF e.participants')
        ->setParameter('val', $value);
        if($filtres['minPrice'] != 0){
            $ret->andWhere('e.prix >= :min')
            ->setParameter('min', $filtres['minPrice']);
        }
        if($filtres['maxPrice'] != 0){
            $ret->andWhere('e.prix <= :max')
            ->setParameter('max', $filtres['maxPrice']);
        }
        if($filtres['date'] != ""){
            $ret->andWhere('e.date = :dat')
            ->setParameter('dat', $filtres['date']);
        }
        return $ret->orderBy('e.date', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
    * @return Event[] Returns an array of Event objects
    */
    public function findUpcomingEvent($filtres)
    {
        $ret = $this->createQueryBuilder('e')
        ->innerJoin('e.communities', 'c')
        ->andWhere('c.public = true');
        if($filtres['minPrice'] != 0){
            $ret->andWhere('e.prix >= :min')
            ->setParameter('min', $filtres['minPrice']);
        }
        if($filtres['maxPrice'] != 0){
            $ret->andWhere('e.prix <= :max')
            ->setParameter('max', $filtres['maxPrice']);
        }
        if($filtres['date'] != ""){
            $ret->andWhere('e.date = :dat')
            ->setParameter('dat', $filtres['date']);
        }
        return $ret->orderBy('e.date', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return Event
     */
    public function findOneById($value): ?Event
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.id = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    /**
     * @return Event
     */
    public function isParticipating(User $user, Event $event): ?Event
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.id = :event')
            ->andWhere(':user MEMBER OF e.participants')
            ->setParameter('event', $event)
            ->setParameter('user', $user)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    
}
