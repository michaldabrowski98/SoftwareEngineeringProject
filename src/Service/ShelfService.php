<?php

namespace App\Service;

use App\Builder\AlleyBuilder;
use App\DTO\AddProductToShelfDTO;
use App\Repository\ShelfRepository;

class ShelfService
{
    private ShelfRepository $shelfRepository;

    private AlleyBuilder $alleyBuilder;

    public function __construct(
        ShelfRepository $shelfRepository,
        AlleyBuilder    $alleyBuilder
    )
    {
        $this->shelfRepository = $shelfRepository;
        $this->alleyBuilder = $alleyBuilder;
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
        while ($calculatedWeight <= 0) {
            foreach ($availableShelf as $shelf)
            $quantity = $shelf['max_weight'] / $addProductToShelf->getWeight();
            $shelf['product_id'] = $addProductToShelf->getId();
            $shelf['quantity'] = $quantity;
            $this->shelfRepository->save($shelf);
            $calculatedWeight = -$quantity * $addProductToShelf->getTotalWeight();
        }
    }
}
