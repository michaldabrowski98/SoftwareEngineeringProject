<?php

namespace App\Finder;

use App\DTO\ShelfFoundDTO;
use App\Entity\Product;
use App\Entity\Shelf;
use App\Repository\ProductRepository;
use App\Repository\ShelfRepository;

class ShelfFinder
{
    private ShelfRepository $shelfRepository;

    private ProductRepository $productRepository;

    public function __construct(
        ShelfRepository $shelfRepository,
        ProductRepository $productRepository
    ) {
        $this->shelfRepository = $shelfRepository;
        $this->productRepository = $productRepository;
    }

    public function findShelfsByProductIdAndQuantity(int $productId, int $productQuantity): array
    {
        $shelfs = $this->shelfRepository->getShelfsByProductOrEmpty($productId, $productQuantity);

        /** @var Product $product */
        $product = $this->productRepository->findOneBy(['id' => $productId]);
        /** @var Shelf $shelf */
        foreach ($shelfs as $shelf) {
            $shelfCapacity = (int) ($shelf->getMaxWeight() / $product->getWeight()) - $shelf->getQuantity();
            $shelf->setQuantity($shelfCapacity);
        }
        return $this->createShelfDTOs($shelfs);
    }

    public function findShelfsPositionsByQuantity(array $products): array
    {
        $shelfs = [];
        foreach ($products as $product) {
            if (!isset($product['id'])) {
                continue;
            }

            $shelfs = array_merge($shelfs, $this->createShelfDTOs(
                $this->shelfRepository->getShelfsByProductAndQuantity($product['id'])
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
