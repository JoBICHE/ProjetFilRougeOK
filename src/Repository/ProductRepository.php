<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    // /**
    //  * @return Product[] Returns an array of Product objects
    //  */
    
    public function findByPrice($price)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.price <= :val')
            ->setParameter('val', $price)
            ->orderBy('p.title', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByCat($cat)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.category = :val')
            ->setParameter('val', $cat)
            ->orderBy('p.title', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }
   

    
/*     public function find($value): ?Product
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    } */
   
}
