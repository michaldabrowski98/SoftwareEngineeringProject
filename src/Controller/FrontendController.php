<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FrontendController extends AbstractController
{
    #[Route('/', name: 'frontend')]
    #[Route('/{route}', name: 'vue', requirements: ['route' => '^.+'])]
    public function index(): Response
    {
        return $this->render('base.html.twig', []);
    }
}