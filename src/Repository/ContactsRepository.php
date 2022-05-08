<?php

namespace App\Repository;

use App\Entity\Contacts;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Contacts>
 *
 * @method Contacts|null find($id, $lockMode = null, $lockVersion = null)
 * @method Contacts|null findOneBy(array $criteria, array $orderBy = null)
 * @method Contacts[]    findAll()
 * @method Contacts[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContactsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Contacts::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Contacts $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Contacts $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return Contacts[] Returns an array of Contacts objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Contacts
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */


    /**
     * @return Contacts[] Returns an array of Contacts objects
     */
    public function findByName($keyword)
    {
        #dd($keyword);
        // $query = $this->createQueryBuilder('c');

        // $query->where('c.firstname  LIKE :keyword')
        //     ->orWhere('c.lastname LIKE :keyword')
        //     ->setParameter('keyword', $keyword)
        //     #->orderBy('c.firstname', 'ASC')
        //     ->getQuery()
        //     ->getOneOrNullResult();

        // #dd(get_class_methods($query));
        // dd($query->__toString());

        return $this->createQueryBuilder('c')
            ->where('c.firstname  LIKE :keyword')
            ->orWhere('c.lastname LIKE :keyword')
            ->setParameter('keyword', '%' . $keyword . '%')
            ->orderBy('c.firstname', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
