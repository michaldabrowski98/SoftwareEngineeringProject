<?php

namespace App\Service;

use App\DTO\ProductDTO;
use App\Entity\Product;
use App\Repository\ProductRepository;

class ProductListService
{
    private ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function getProductsWithPagination(int $page): array
    {
        $products = $this->productRepository->getProductsWithPagination($page);

        return $this->getProducts($products);
    }

    public function getProducts(array $products): array
    {
        $productDTOs = [];
        foreach ($products as $product) {
            $productDTOs[] = $this->getProductDTO($product);
        }
        return $productDTOs;
    }

    public function getProductDTO(Product $product): ProductDTO
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