<?php

namespace App\Repository;

use App\Entity\Cart;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Cart>
 *
 * @method Cart|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cart|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cart[]    findAll()
 * @method Cart[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CartRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cart::class);
    }

    public function save(Cart $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Cart $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return Cart[] Returns an array of Cart objects
     */
    public function showCart($value): array
    {
        // SELECT p.id, p.name, c.name 'cate_name', SUM(cart.count), SUM(cart.count) * p.price 'total' FROM `product` p
        // JOIN `cart` ON p.id = cart.product_id
        // JOIN `category` c ON p.category_id = c.id
        // JOIN `user` u ON u.id = cart.user_id
        // GROUP BY p.name, p.id
        return $this->createQueryBuilder('cart')
            ->select('p.id as p_id', 'p.name as p_name', 'p.price', 'p.image', 'SUM(cart.count) as num', 'SUM(cart.count) * p.price as unitTotal', 'c.name as cate_name')
            ->andWhere('cart.user = :val')
            ->setParameter('val', $value)
            ->join('cart.product', 'p')
            ->join('p.category', 'c')
            // ->join('cart.user', 'u')
            ->groupBy('p.name', 'p.id')
            ->getQuery()
            ->getArrayResult();
    }

    /**
     * @return Cart[] Returns an array of Cart objects
     */
    public function removeCart($pro_id, $user): array
    {
        return $this->createQueryBuilder('cart')
            ->andWhere('cart.product.id = :val')
            ->setParameter('val', $pro_id)
            ->andWhere('cart.user.username = :val')
            ->setParameter('val', $user)
            ->getQuery()
            ->getArrayResult();
    }
    //    /**
    //     * @return Cart[] Returns an array of Cart objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Cart
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
