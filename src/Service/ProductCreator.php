<?php

namespace App\Service;

use App\Entity\Product;

class ProductCreator
{
    private ProductService $productService;
    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function getProductEntityById(int $productId, mixed $productData): Product
    {
        $product = $this->productService->getProductEntityById($productId);
        $product->setName($productData['name']);
        $product->setDescription($productData['description']);
        $product->setWeight((float)$productData['weight']);
        $product->setPrice($productData['price']);
        return $product;
    }
}