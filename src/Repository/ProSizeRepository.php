<?php

namespace App\Repository;

use App\Entity\ProSize;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ProSize>
 *
 * @method ProSize|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProSize|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProSize[]    findAll()
 * @method ProSize[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProSizeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProSize::class);
    }

    public function save(ProSize $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ProSize $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    /**
     * @return ProSize[] Returns an array of ProSize objects
     */
    public function findByProduct($pro, $size): array
    {
        return $this->createQueryBuilder('ps')
            ->select('s.name as sizeName', 'p.id as proId', 'p.name as proName', 'ps.quantity as quantity')
            ->join('ps.product', 'p')
            ->join('ps.size', 's')
            ->andWhere('p.id = :val')
            ->setParameter('val', $pro)
            ->andWhere('p.id = :val')
            ->setParameter('val', $size)
            ->getQuery()
            ->getArrayResult();
    }
    /**
     * @return ProSize[] Returns an array of ProSize objects
     */
    public function findSize($value): array
    {
        return $this->createQueryBuilder('ps')
            ->select('s.id as sizeId', 's.name as sizeName', 'ps.quantity as productQty', 'p.id as productId', 'p.name as productName')
            ->join('ps.size', 's')
            ->join('ps.product', 'p')
            ->andWhere('p.id = :val')
            ->setParameter('val', $value)
            ->groupBy('s.id')
            ->getQuery()
            ->getArrayResult();

    }

    //    /**
    //     * @return ProSize[] Returns an array of ProSize objects
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

    //    public function findOneBySomeField($value): ?ProSize
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
