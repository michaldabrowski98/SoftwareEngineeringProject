<?php

namespace App\Service;

use App\Builder\AlleyBuilder;
use App\Entity\Shelf;
use App\Repository\ProductRepository;
use App\Repository\ShelfRepository;
use Doctrine\ORM\EntityManagerInterface;

class ShelfService
{
    private ShelfRepository $shelfRepository;

    private ProductRepository $productRepository;

    private AlleyBuilder $alleyBuilder;

    private EntityManagerInterface $entityManager;

    public function __construct(
        ShelfRepository $shelfRepository,
        ProductRepository $productRepository,
        AlleyBuilder $alleyBuilder,
        EntityManagerInterface $entityManager
    ) {
        $this->shelfRepository = $shelfRepository;
        $this->productRepository = $productRepository;
        $this->alleyBuilder = $alleyBuilder;
        $this->entityManager = $entityManager;
    }

    public function getWarehouseScheme(): array
    {
        $allShelfs = $this->shelfRepository->findAll();
        return $this->alleyBuilder->build($allShelfs);
    }

    public function saveShelfs(array $shelfs): void
    {
        foreach ($shelfs as $shelf) {
            if (!isset($shelf['shelfId'])
                || !isset($shelf['quantity'])
                || !isset($shelf['productId'])) {
                continue;
            }
            /** @var Shelf $shelfEntity */
            $shelfEntity = $this->shelfRepository->findOneBy(['id' => $shelf['shelfId']]);
            $shelfEntity->setProduct(
                $this->productRepository->findOneBy(['id' => $shelf['productId']])
            );
            $shelfEntity->setQuantity($shelf['quantity']);

            $this->entityManager->persist($shelfEntity);
        }

        $this->entityManager->flush();
    }

    public function removeShelfs(array $shelfs): void
    {
        foreach ($shelfs as $shelf) {
            if (!isset($shelf['shelfId']) || !isset($shelf['quantity'])) {
                continue;
            }
            /** @var Shelf $shelfEntity */
            $shelfEntity = $this->shelfRepository->findOneBy(['id' => $shelf['shelfId']]);
            $shelfEntity->setQuantity($shelfEntity->getQuantity() - $shelf['quantity']);

            $this->entityManager->persist($shelfEntity);
        }

        $this->entityManager->flush();
    }
}
