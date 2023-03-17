<?php

namespace App\Service;

use App\DTO\ProductDTO;
use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;

class ProductService
{
    private ProductRepository $productRepository;
    private EntityManagerInterface $entityManager;

    public function __construct(
        ProductRepository $productRepository,
        EntityManagerInterface $entityManager
    ) {
        $this->productRepository = $productRepository;
        $this->entityManager = $entityManager;
    }

    public function removeProductById(int $productId): void
    {
        $productEntity = $this->productRepository->findOneBy(['id' => $productId]);
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