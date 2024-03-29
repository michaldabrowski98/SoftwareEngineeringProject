<?php

namespace App\Service;

use App\Builder\AlleyBuilder;
use App\DTO\AddProductToShelfDTO;
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
            $shelfEntity = $this->shelfRepository->findOneBy(['id' => (int) $shelf['shelfId']]);
            $shelfEntity->setProduct(
                $this->productRepository->findOneBy(['id' => (int) $shelf['productId']])
            );
            $shelfEntity->setQuantity((int) $shelf['quantity']);

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
    public function addProductToShelf(AddProductToShelfDTO $addProductToShelf)
    {
        $this->tryAddProductToFirstLevel($addProductToShelf);
        $availableShelf = $this->shelfRepository->getShelfsByProductOrEmpty($addProductToShelf->getId(), $addProductToShelf->getQuantity());
        $calculatedWeight = $addProductToShelf->getTotalWeight();
        $currentQuantity = $addProductToShelf->getQuantity();
        foreach ($availableShelf as $shelf) {
            $maxQuantity = floor($shelf['maxWeight'] / $addProductToShelf->getWeight());
            if ($calculatedWeight <= 0 || $maxQuantity < 1 || $currentQuantity < 0) break;
            $shelf['product_id'] = $addProductToShelf->getId();
            if ($shelf['quantity'] != null) {
                if ($currentQuantity - $maxQuantity > 0) {
                    $addedQuantity = $maxQuantity - $shelf['quantity'];
                    $currentQuantity = $currentQuantity - $maxQuantity + $shelf['quantity'];
                    $shelf['quantity'] = $maxQuantity;
                }
                else if ($currentQuantity + $shelf['quantity'] > $maxQuantity) {
                    $addedQuantity = $maxQuantity - $shelf['quantity'];
                    $shelf['quantity'] = $shelf['quantity'] + $addedQuantity;
                    $currentQuantity = $currentQuantity - $addedQuantity;
                } else {
                    $addedQuantity = $currentQuantity;
                    $shelf['quantity'] = $shelf['quantity'] + $addedQuantity;
                    $currentQuantity = 0;
                }
            } else {
                if ($currentQuantity - $maxQuantity > 0) {
                    $shelf['quantity'] = $maxQuantity;
                    $addedQuantity = $maxQuantity;
                } else {
                    $shelf['quantity'] = $currentQuantity;
                    $addedQuantity = $currentQuantity;
                }
                $currentQuantity = $currentQuantity - $maxQuantity;
            }
            $this->shelfRepository->merge($this->createShelfEntity($shelf));
            $usedWeight = $addedQuantity * $addProductToShelf->getWeight();
            $calculatedWeight = $calculatedWeight - $usedWeight;
        }
    }

    public function removeAlley(int $alleyNumber): void
    {
        $shelfs = $this->shelfRepository->findBy(
            [
                'alley' => $alleyNumber
            ]
        );

        foreach ($shelfs as $shelf) {
            $this->entityManager->remove($shelf);
        }
        $this->entityManager->flush();
    }

    public function removeShelf(int $shelfId): void
    {
        $shelf = $this->shelfRepository->findOneBy(
            [
                'id' => $shelfId
            ]
        );

        $this->entityManager->remove($shelf);
        $this->entityManager->flush();
    }

    private function createShelfEntity(mixed $type): Shelf
    {
        $shelf = new Shelf($type['alley'], $type['level'], $type['col'], $type['maxWeight']);
        $shelf->setId($type['id']);
        $shelf->setQuantity($type['quantity']);
        $product = $this->productRepository->findOneBy(['id'=> $type['product_id']]);
        $shelf->setProduct($product);
        return $shelf;
    }
    private function tryAddProductToFirstLevel(AddProductToShelfDTO $addProductToShelf): AddProductToShelfDTO
    {
        $products = $this->shelfRepository->getShelfsByProductAndQuantity($addProductToShelf->getId());
        if (!$products) {
            $shelf = $this->shelfRepository->getShelfsFirstLevel($addProductToShelf->getId())[0];
            $calculatedWeight = $addProductToShelf->getTotalWeight();
            $currentQuantity = $addProductToShelf->getQuantity();
            $maxQuantity = floor($shelf['maxWeight'] / $addProductToShelf->getWeight());
            $shelf['product_id'] = $addProductToShelf->getId();
            if ($shelf['quantity'] != null) {
                if ($currentQuantity - $maxQuantity > 0) {
                    $addedQuantity = $maxQuantity - $shelf['quantity'];
                    $currentQuantity = $currentQuantity - $maxQuantity + $shelf['quantity'];
                    $shelf['quantity'] = $maxQuantity;
                } else if ($currentQuantity + $shelf['quantity'] > $maxQuantity) {
                    $addedQuantity = $maxQuantity - $shelf['quantity'];
                    $shelf['quantity'] = $shelf['quantity'] + $addedQuantity;
                    $currentQuantity = $currentQuantity - $addedQuantity;
                } else {
                    $addedQuantity = $currentQuantity;
                    $shelf['quantity'] = $shelf['quantity'] + $addedQuantity;
                    $currentQuantity = 0;
                }
            } else {
                if ($currentQuantity - $maxQuantity > 0) {
                    $shelf['quantity'] = $maxQuantity;
                    $addedQuantity = $maxQuantity;
                } else {
                    $shelf['quantity'] = $currentQuantity;
                    $addedQuantity = $currentQuantity;
                }
                $currentQuantity = $currentQuantity - $maxQuantity;
            }
            $this->shelfRepository->merge($this->createShelfEntity($shelf));
            $usedWeight = $addedQuantity * $addProductToShelf->getWeight();
            $calculatedWeight = $calculatedWeight - $usedWeight;

            $addProductToShelf->setTotalWeight($calculatedWeight);
            $addProductToShelf->setQuantity($currentQuantity);
        }
        return $addProductToShelf;
    }
}