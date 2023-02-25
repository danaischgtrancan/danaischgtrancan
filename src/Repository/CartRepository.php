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
            ->select('cart.id as cart_id', 'cart.count as num', 'p.id as p_id', 'p.name as p_name', 'p.price', 'p.image', 'cart.count * p.price as unitTotal', 'c.name as cate_name')
            ->join('cart.product', 'p')
            ->join('p.category', 'c')
            ->andWhere('cart.user = :val')
            ->setParameter('val', $value)
            ->groupBy('p.name', 'p.id')
            ->getQuery()
            ->execute();
    }

    /**
     * @return Cart[] Returns an array of Cart objects
     */
    public function removeCart($id, $user): array
    {
        //SELECT * FROM `cart` WHERE c.product_id = 1 AND c.user_id = 1

        return $this->createQueryBuilder('cart')
            ->andWhere('cart.product = :val')
            ->setParameter('val', $id)
            ->andWhere('cart.user = :i')
            ->setParameter('i', $user)
            ->getQuery()
            ->execute();
    }

    /**
     * @return Cart[] Returns an array of Cart objects
     */
    public function findByProId($id, $user): array
    {
        //SELECT * FROM `cart` as c INNER JOIN product as p ON c.product_id = p.id WHERE c.product_id = 1 AND c.user_id = 1

        return $this->createQueryBuilder('c')
            ->select('c.id')
            ->join('c.product', 'p')
            ->join('c.user', 'u')
            ->where('p.id = :pid')
            ->setParameter('pid', $id)
            ->andWhere('u.id = :val')
            ->setParameter('val', $user)
            ->getQuery()
            ->getArrayResult();
    }

    /**
     * @return Cart[] Returns an array of Cart objects
     */
    public function updateQty($pro, $user): array
    {

        return $this->createQueryBuilder('c')
            ->select('COUNT(c.count) as total')
            ->where('c.product = :val')
            ->setParameter('val', $pro)
            ->andWhere('c.user = :vul')
            ->setParameter('vul', $user)
            ->groupBy('c.count')
            ->getQuery()
            ->getArrayResult();
    }

    /**
     * @return Cart[] Returns an array of Cart objects
     */
    public function getCartOfCurrentUser($user): array
    {
        // SELECT * FROM `cart` c JOIN `product` p ON c.product_id = p.id WHERE user_id = 1
        return $this->createQueryBuilder('c')
            ->select('p.id as proId', 'c.count as qty')
            ->join('c.product', 'p')
            ->andWhere('c.user = :val')
            ->setParameter('val', $user)
            ->getQuery()
            ->getArrayResult();
    }
    /**
     * @return Cart[] Returns an array of Cart objects
     */
    public function findUser($user): array
    {
        // SELECT * FROM `cart` c JOIN `product` p ON c.product_id = p.id WHERE user_id = 1
        return $this->createQueryBuilder('c')
            ->select('c.id as cartId')
            ->andWhere('c.user = :val')
            ->setParameter('val', $user)
            ->getQuery()
            ->getArrayResult();
    }
    // /**
    //  * @return Cart[] Returns an array of Cart objects
    //  */
    // public function removeCart($pro_id, $user): array
    // {
    //     return $this->createQueryBuilder('cart')
    //         ->andWhere('cart.product = :val')
    //         ->setParameter('val', $pro_id)
    //         ->andWhere('cart.user = :val')
    //         ->setParameter('val', $user)
    //         ->getQuery()
    //         ->getArrayResult();
    // }
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
