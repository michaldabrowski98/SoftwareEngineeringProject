<?php

namespace App\Controller;

use App\Entity\Product;
use App\Service\ProductListService;
use App\Service\ProductService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    private ProductListService $productListService;

    private ProductService $productService;

    private EntityManagerInterface $entityManager;

    public function __construct(
        ProductListService $productListService,
        ProductService $productService,
        EntityManagerInterface $entityManager
    ) {
        $this->productListService = $productListService;
        $this->productService = $productService;
        $this->entityManager = $entityManager;
    }

    #[Route('/api/product/list', name: 'api_product_list')]
    public function listAction(): JsonResponse
    {
        return new JsonResponse($this->productListService->getAllProducts());
    }

    #[Route('/api/product/edit/{id}', name: 'api_product_edit')]
    public function editAction(Request $request): JsonResponse
    {
        $productId = (int) $request->get('id');
        return new JsonResponse($this->productService->getProductById($productId));
    }

    #[Route('/api/product/new', name: 'api_product_new', methods: ["POST"])]
    public function newAction(Request $request): JsonResponse
    {
        $product = $this->getProduct($request);
        try {
            $this->entityManager->persist($product);
            $this->entityManager->flush();
        } catch (\Exception) {
            return new JsonResponse(['success' => false]);
        }

        return new JsonResponse(['success' => true]);
    }

    private function getProduct(Request $request): Product
    {
        return  new Product(
            $request->get('name'),
            $request->get('description'),
            (float)$request->get('weight'),
            $request->get('price')
        );
    }
}