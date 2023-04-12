<?php

namespace App\Finder;

use App\DTO\ShelfFoundDTO;
use App\Entity\Shelf;
use App\Repository\ShelfRepository;

class ShelfFinder
{
    private ShelfRepository $shelfRepository;

    public function __construct(ShelfRepository $shelfRepository)
    {
        $this->shelfRepository = $shelfRepository;
    }

    public function findShelfsByProductIdAndQuantity(int $productId, int $productQuantity): array
    {
        $shelfs = $this->shelfRepository->getShelfsByProductOrEmpty($productId, $productQuantity);
        return $this->createShelfDTOs($shelfs);
    }

    public function findShelfsPositionsByQuantity(array $products): array
    {
        $shelfs = [];
        foreach ($products as $product) {
            if (!isset($product['productId']) || !isset($product['quantity'])) {
                continue;
            }

            $shelfs = array_merge($shelfs, $this->createShelfDTOs(
                $this->shelfRepository->getShelfsByProductAndQuantity($product['productId'], $product['quantity'])
                )
            );
        }

        return $shelfs;
    }

    private function createShelfDTOs(array $shelfs): array
    {
        $shelfDTOs = [];

        /** @var Shelf $shelf */
        foreach ($shelfs as $shelf) {
            $shelfDTOs[] = new ShelfFoundDTO(
                $shelf->getId(),
                $shelf->getAlley(),
                $shelf->getCol(),
                $shelf->getLevel(),
                $shelf->getProduct()?->getId() ?? null,
                $shelf->getQuantity()
            );
        }

        return $shelfDTOs;
    }
}
