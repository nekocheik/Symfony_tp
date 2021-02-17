<?php

namespace App\Repository;

use App\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Category|null find($id, $lockMode = null, $lockVersion = null)
 * @method Category|null findOneBy(array $criteria, array $orderBy = null)
 * @method Category[]    findAll()
 * @method Category[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Category::class);
    }

    // /**
    //  * @return Category[] Returns an array of Category objects
    //  */
    public function findByName($name, $limit = 10)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.name = :val')
            ->setParameter('val', $name)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByTerm($typeOfTerm)
    {
      return $this->createQueryBuilder('c')
            ->andWhere('c.term = :val')
            ->setParameter('val', $typeOfTerm)
            ->orderBy('c.id', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
