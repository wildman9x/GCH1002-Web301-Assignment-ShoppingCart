<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Product>
 *
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

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Product $entity, bool $flush = true): void
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
    public function remove(Product $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }
    public function sortByNameAscending()
    {
        return $this->createQueryBuilder('product')
            ->orderBy('product.name', "ASC")
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Product[]
     */
    public function sortByPriceAscending()
    {
        return $this->createQueryBuilder('product')
            ->orderBy('product.price', "ASC")
            ->getQuery()
            ->getResult();
    }
    /**
     * @return Product[]
     */
    public function sortByPriceDescending()
    {
        return $this->createQueryBuilder('product')
            ->orderBy('product.price', "DESC")
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Product[]
     */
    public function searchByName($name)
    {
        return $this->createQueryBuilder('product')
            ->andWhere('product.name LIKE :name')
            ->setParameter('name', '%' . $name . '%')
            ->orderBy('product.id', 'DESC')
            // ->setMaxResults(5)
            ->getQuery()
            ->getResult();
    }

    // /**
    //  * @return Product[] Returns an array of Product objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Product
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
