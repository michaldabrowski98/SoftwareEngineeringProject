<?php

namespace App\Controller;

use App\Entity\Product;
use App\Service\ProductCreator;
use App\Service\AuthenticationChecker;
use App\Service\ProductListService;
use App\Service\ProductService;
use App\Traits\AuthenticationCheckerTrait;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    use AuthenticationCheckerTrait;
    private ProductCreator $productCreator;

    private ProductListService $productListService;

    private ProductService $productService;

    private EntityManagerInterface $entityManager;

    private AuthenticationChecker $authenticationChecker;

    public function __construct(
        ProductListService $productListService,
        ProductService $productService,
        EntityManagerInterface $entityManager,
        AuthenticationChecker $authenticationChecker,
        ProductCreator $productCreator
    ) {
        $this->productCreator = $productCreator;
        $this->productListService = $productListService;
        $this->productService = $productService;
        $this->entityManager = $entityManager;
        $this->authenticationChecker = $authenticationChecker;
    }

    #[Route('/api/product/list', name: 'api_product_list')]
    public function listAction(Request $request): JsonResponse
    {
        if (null !== $invalidAuthentication = $this->isAuthenticationInvalid()) {
            return $invalidAuthentication;
        }

        $page = $request->get('page') ?? 1;

        return new JsonResponse($this->productListService->getProductsWithPagination($page));
    }

    #[Route('/api/product/edit/{id}', name: 'api_product_edit', methods: ["GET"])]
    public function editAction(Request $request): JsonResponse
    {
        if (null !== $invalidAuthentication = $this->isAuthenticationInvalid()) {
            return $invalidAuthentication;
        }

        $productId = (int) $request->get('id');
        return new JsonResponse($this->productService->getProductById($productId));
    }

    #[Route('/api/product/edit/{id}/save', name: 'api_product_save', methods: ["POST"])]
    public function saveAction(Request $request): JsonResponse
    {
        if (null !== $invalidAuthentication = $this->isAuthenticationInvalid()) {
            return $invalidAuthentication;
        }

        $productId = (int) $request->get('id');
        $productData = json_decode($request->getContent(), true);
        try {
            $product = $this->productCreator->getProductEntityById($productId, $productData);
            $this->entityManager->persist($product);
            $this->entityManager->flush();
        } catch (\Exception $e) {
            return new JsonResponse(['success' => false]);
        }

        return new JsonResponse(['success' => true]);
    }

    #[Route('/api/product/new', name: 'api_product_new', methods: ["POST"])]
    public function newAction(Request $request): JsonResponse
    {
        if (null !== $invalidAuthentication = $this->isAuthenticationInvalid()) {
            return $invalidAuthentication;
        }

        $product = $this->getProduct(json_decode($request->getContent(), true));
        try {
            $this->entityManager->persist($product);
            $this->entityManager->flush();
        } catch (\Exception) {
            return new JsonResponse(['success' => false]);
        }

        return new JsonResponse(['success' => true]);
    }

    #[Route('/api/product/delete/{id}', name: 'api_product_delete', methods: ["DELETE"])]
    public function deleteAction(Request $request): JsonResponse
    {
        if (null !== $invalidAuthentication = $this->isAuthenticationInvalid()) {
            return $invalidAuthentication;
        }
        try {
            $this->productService->removeProductById($request->get('id'));
        } catch (\Exception $e) {
            return new JsonResponse(['success' => false]);
        }

        return new JsonResponse(['success' => true]);
    }

    #[Route('/api/product/list/simplified', name: 'api_product_list_simplified', methods: ["GET"])]
    public function getNamesAction(): JsonResponse
    {
        if (null !== $invalidAuthentication = $this->isAuthenticationInvalid()) {
            return $invalidAuthentication;
        }

        $productListSimplified = [];

        try {
            $productListSimplified = $this->productListService->getProductListSimplified();
        } catch (\Exception $exception) {
            // do nothing
        }

        return new JsonResponse($productListSimplified);
    }

    private function getProduct(array $productArray): Product
    {
        return  new Product(
            $productArray['name'],
            $productArray['description'],
            (float) $productArray['weight'],
            $productArray['price']
        );
    }
}
