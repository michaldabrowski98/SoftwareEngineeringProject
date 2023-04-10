<?php

namespace App\Service;

use App\Builder\AlleyBuilder;
use App\DTO\AddProductToShelfDTO;
use App\Entity\Shelf;
use App\Repository\ProductRepository;
use App\Repository\ShelfRepository;

class ShelfService
{
    private ShelfRepository $shelfRepository;
    private ProductRepository $productRepository;
    private AlleyBuilder $alleyBuilder;

    public function __construct(
        ShelfRepository   $shelfRepository,
        AlleyBuilder      $alleyBuilder,
        ProductRepository $productRepository
    )
    {
        $this->shelfRepository = $shelfRepository;
        $this->alleyBuilder = $alleyBuilder;
        $this->productRepository = $productRepository;
    }

    public function getWarehouseScheme(): array
    {
        $allShelfs = $this->shelfRepository->findAll();
        return $this->alleyBuilder->build($allShelfs);
    }

    public function addProductToShelf(AddProductToShelfDTO $addProductToShelf)
    {
        $availableShelf = $this->shelfRepository->getShelfWithProductOrEmpty($addProductToShelf->getId());
        $calculatedWeight = $addProductToShelf->getTotalWeight();
        foreach ($availableShelf as $shelf) {
            if ($calculatedWeight <= 0) break;
            $quantity = $shelf['maxWeight'] / $addProductToShelf->getWeight();
            $shelf['product_id'] = $addProductToShelf->getId();
            $shelf['quantity'] = $quantity;
            $this->shelfRepository->merge($this->createShelfEntity($shelf));
            $usedWeight = $quantity * $addProductToShelf->getWeight();
            $calculatedWeight = $calculatedWeight - $usedWeight;
        }
    }

    private function createShelfEntity(mixed $type): Shelf
    {
        $shelf = new Shelf($type['alley'], $type['level'], $type['col'], $type['maxWeight']);
        $shelf->setId($type['id']);
        $shelf->setQuantity($type['quantity']);
        $product = $this->productRepository->findOneBy(['id'=> $type['product_id']]);
        $shelf->setProduct($product);
        return $shelf;//
    }
}