<?php

namespace App\Service;

use App\DTO\ProductDTO;
use App\Entity\Product;
use App\Repository\ProductRepository;

class ProductService
{
    private ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
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