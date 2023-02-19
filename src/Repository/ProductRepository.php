<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
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

    public function save(Product $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Product $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return Product[] Returns an array of Product objects
     */
    public function findBestSeller(): array
    {
        return $this->createQueryBuilder('p')
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(4)
            ->getQuery()
            ->getArrayResult();
    }
    /**
     * @return Product[] Returns an array of Product objects
     */
    public function findNewItem(): array
    {
        return $this->createQueryBuilder('p')
            ->orderBy('p.name', 'ASC')
            ->setMaxResults(4)
            ->getQuery()
            ->getArrayResult();
    }

    /**
     * @return Product[] Returns an array of Product objects
     */
    public function findCategory(): array
    {
        // SELECT DISTINCT category.name FROM `product` JOIN category ON category_id = category.id

        return $this->createQueryBuilder('p')
            ->select('DISTINCT c.name as cate_name')
            ->innerJoin('p.category', 'c')
            ->getQuery()
            ->getArrayResult();
    }

    /**
     * @return Product[] Returns an array of Product objects
     */
    public function findSupplier(): array
    {
        // SELECT DISTINCT category.name FROM `product` JOIN category ON category_id = category.id

        return $this->createQueryBuilder('p')
            ->select('DISTINCT s.name as supp_name')
            ->innerJoin('p.supplier', 's')
            ->getQuery()
            ->getArrayResult();
    }

    /**
     * @return Product[] Returns an array of Product objects
     */
    public function findByName($value): array
    {
        return $this->createQueryBuilder('p')
            ->orderBy('p.name', $value)
            ->getQuery()
            ->getArrayResult();
    }

    /**
     * @return Product[] Returns an array of Product objects
     */
    public function findByPrice($value): array
    {
        return $this->createQueryBuilder('p')
            ->orderBy('p.price', $value)
            ->getQuery()
            ->getArrayResult();
    }

    /**
     * @return Product[] Returns an array of Product objects
     */
    public function findByCate($value): array
    {
        return $this->createQueryBuilder('p')
            ->join('p.category', 'c')
            ->andWhere('c.name = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getArrayResult();
    }

    /**
     * @return Product[] Returns an array of Product objects
     */
    public function findBySupp($value): array
    {
        return $this->createQueryBuilder('p')
            ->join('p.supplier', 's')
            ->andWhere('s.name = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getArrayResult();
    }

    /**
     * @return Product[] Returns an array of Product objects
     */
    public function findByGender($value): array
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.forGender = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getArrayResult();
    }
    //    /**
    //     * @return Product[] Returns an array of Product objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()  
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Product
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
