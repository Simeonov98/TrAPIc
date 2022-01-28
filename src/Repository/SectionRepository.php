<?php

namespace App\Repository;

use App\Entity\Section;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use function Doctrine\ORM\QueryBuilder;

/**
 * @method Section|null find($id, $lockMode = null, $lockVersion = null)
 * @method Section|null findOneBy(array $criteria, array $orderBy = null)
 * @method Section[]    findAll()
 * @method Section[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SectionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Section::class);
    }


    public function findonehourplusminus(){


        $date = new DateTime();
        $plus=new DateTime('+30 minutes',new \DateTimeZone('Europe/Sofia'));
        $minus=new DateTime('-30 minutes',new \DateTimeZone('Europe/Sofia'));



        return $this->createQueryBuilder('s')
            ->where('s.createdAt >= :val1')
            ->andWhere('s.createdAt <= :val2')
            ->setParameter('val1',$minus->format('Y-m-d H:i:s'))
            ->setParameter('val2',$plus->format('Y-m-d H:i:s'))
            ->orderBy('s.createdAt','DESC')
            ->setMaxResults(50)
            ->getQuery()
            ->getResult();
    }
    public function findonehour(){


        $date = new DateTime("NOW" ,new \DateTimeZone('Europe/Sofia'));
        $plus=new DateTime('-60 minutes',new \DateTimeZone('Europe/Sofia'));
        //$minus=new DateTime('-30 minutes');


        return $this->createQueryBuilder('s')
            ->where('s.createdAt <= :val1')
            ->andWhere('s.createdAt >= :val2')
            ->setParameter('val1',$date->format('Y-m-d H:i:s'))
            ->setParameter('val2',$plus->format('Y-m-d H:i:s'))
            ->orderBy('s.createdAt','DESC')
            ->setMaxResults(50)
            ->getQuery()
            ->getResult();
    }
    public function findxtime($time){

        //dd($time);
        $date = new DateTime("NOW" ,new \DateTimeZone('Europe/Sofia'));
        $plus=new DateTime($time,new \DateTimeZone('Europe/Sofia'));
        //dd($plus);
        //$minus=new DateTime('-30 minutes');


        return $this->createQueryBuilder('s')
            ->where('s.createdAt <= :val1')
            ->andWhere('s.createdAt >= :val2')
            ->setParameter('val1',$date->format('Y-m-d H:i:s'))
            ->setParameter('val2',$plus->format('Y-m-d H:i:s'))
            ->orderBy('s.createdAt','DESC')
            ->setMaxResults(50)
            ->getQuery()
            ->getResult();
    }
    // /**
    //  * @return Section[] Returns an array of Section objects
    //  */
    /*
    public function findBycreatedAt($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.createdAt < :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Section
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
