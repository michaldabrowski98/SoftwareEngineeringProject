<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomePageController extends AbstractController
{
    private ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    #[Route('/home/page', name: 'app_home_page')]
    public function index(): Response
    {
        return $this->render(
            'base.html.twig',
            [
                'products' => $this->productRepository->findAll()
            ]
        );
    }
}
