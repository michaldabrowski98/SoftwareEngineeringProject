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

    public function getShelfWithProductOrEmpty(int $productId): array
    {
/*        $result = $this->createQueryBuilder('s')
            ->select()
            ->where('s.product_id = :productId OR s.quantity is NULL')
            ->setParameter('productId', $productId)
            ->getQuery()
            ->getArrayResult();*/
        return $this->getEntityManager()->createQuery("select s from shelf s where s.product_id = 120 or s.quantity is null")->getArrayResult();
    }
}
