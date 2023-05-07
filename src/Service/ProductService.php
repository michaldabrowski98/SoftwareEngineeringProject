<?php

namespace App\Service;

use App\DTO\ProductDTO;
use App\Entity\Product;
use App\Repository\ProductRepository;
use App\Repository\ShelfRepository;
use Doctrine\ORM\EntityManagerInterface;

class ProductService
{
    private ProductRepository $productRepository;
    private EntityManagerInterface $entityManager;

    private ShelfRepository $shelfRepository;

    public function __construct(
        ProductRepository $productRepository,
        EntityManagerInterface $entityManager,
        ShelfRepository $shelfRepository
    ) {
        $this->productRepository = $productRepository;
        $this->entityManager = $entityManager;
        $this->shelfRepository = $shelfRepository;
    }

    public function getProductEntityById(int $id): Product
    {
        return $this->productRepository->findOneBy(['id' => $id]);
    }

    public function removeProductById(int $productId): void
    {
        $productEntity = $this->productRepository->findOneBy(['id' => $productId]);
        $shelfs = $this->shelfRepository->findBy(['product' => $productEntity]);
        foreach ($shelfs as $shelf) {
            $this->entityManager->remove($shelf);
        }
        $this->entityManager->remove($productEntity);
        $this->entityManager->flush();
    }

    public function getProductById(int $productId): ProductDTO
    {
        $productEntity = $this->productRepository->findOneBy(['id' => $productId]);

        return $this->getProductDTO($productEntity);
    }

    private function getProductDTO(Product $product): ProductDTO
    {
        $productDTO = new ProductDTO();
        $productDTO->setId($product->getId());
        $productDTO->setName($product->getName());
        $productDTO->setDescription($product->getDescription());
        $productDTO->setWeight($product->getWeight());
        $productDTO->setPrice($product->getPrice());

        return $productDTO;
    }
}