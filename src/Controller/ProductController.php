<?php

namespace App\Controller;

use App\Service\ProductListService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    private ProductListService $productListService;

    public function __construct(ProductListService $productListService)
    {
        $this->productListService = $productListService;
    }

    #[Route('/api/product/list', name: 'api_product_list')]
    public function listAction(): JsonResponse
    {
        return new JsonResponse($this->productListService->getAllProducts());
    }
}