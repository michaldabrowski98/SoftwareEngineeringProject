<?php

namespace App\Repository;

use App\Entity\Shelf;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ShelfRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Shelf::class);
    }

    public function save(Shelf $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Shelf $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getLastAlleyNumber(): int
    {
        $result = $this->createQueryBuilder('s')
            ->select('DISTINCT s.alley')
            ->getQuery()
            ->getSingleColumnResult();

        return max($result);
    }

    public function getShelfsByProductOrEmpty(int $productId, int $productQuantity): array
    {
        return $this->createQueryBuilder('s')
            ->select('s, p')
            ->leftJoin('s.product', 'p')
            ->andWhere(
                '(p = :productId AND s.maxWeight > p.weight * :productQuantity) 
                OR (s.product IS NULL AND s.quantity IS NULL)'
            )
            ->setParameter('productId', $productId)
            ->setParameter('productQuantity', $productQuantity)
            ->getQuery()->getResult();
    }

    public function getShelfsByProductAndQuantity(int $productId, int $productQuantity): array
    {
        return $this->createQueryBuilder('s')
            ->andWhere(
                '(s.product = :productId AND s.quantity >= :productQuantity)'
            )
            ->setParameter('productId', $productId)
            ->setParameter('productQuantity', $productQuantity)
            ->getQuery()->getResult();
    }
}
